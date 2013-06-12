<?php
require dirname(__FILE__).'/Cache.php';
require dirname(__FILE__).'/Config.php';
/**
 * Rest client for getting stats
 */
class Stats {
    protected $host;
    protected $port;
    /** @var Cacher $cache */
    protected $cache;
    protected $cacheEnabled = true;

    public function __construct() {
        $this->host = Config::get('stats.url','http://stats.gather.splittingred.com/');
        $this->port = intval(Config::get('stats.port',50313));
        $this->cacheEnabled = Config::get('cache',true);
        $this->getCache();
    }

    public function get($path,array $params = array(),$cache = true) {
        return $this->_execute('get',$path,$params,$cache);
    }

    protected function _execute($method,$path,array $params = array(),$cache = true) {
        error_reporting(E_ALL); ini_set('display_errors',true);
        $ch = curl_init();
        $cacheKey = $path.'.'.md5(serialize($params));
        if ($this->cacheEnabled && $cache && $this->getCache()) {
            $cached = $this->cache->get($cacheKey);
            if (!empty($cached)) {
                return $cached;
            }
        }

        $url = $this->host.$path;
        if ($method != 'get') {
            curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($params));
        } else {
            $url .= strpos($url, '?') ? '&' : '?';
            $url .= $this->_formatQuery($params);
        }
        curl_setopt_array($ch,array(
            CURLOPT_VERBOSE => true,
            CURLOPT_URL => $url,
            CURLOPT_PORT => $this->port,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => 'KAGGatherSite 1.0',
            CURLOPT_HEADER => false,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_DNS_CACHE_TIMEOUT => 120,
            CURLOPT_MAXREDIRS => 3,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json; charset=utf-8',
            ),
        ));
        // $output contains the output string
        $output = curl_exec($ch);
        if ($output == false) {
            $output = curl_errno($ch).': '.curl_error($ch).' - from '.$url.' port '.$this->port.': '.$output;
        } else {
            $output = json_decode($output,true);
            if (!empty($output) && $this->cacheEnabled && $cache && $this->getCache()) {
                $this->cache->set($cacheKey,$output,300);
            }
        }
        curl_close($ch);
        return $output;
    }

    protected function getCache() {
        if (empty($this->cache)) {
            $this->cache = new Cacher();
        }
        return $this->cache;
    }

    private function _formatQuery(array $parameters, $primary='=', $secondary='&'){
        $query = "";
        foreach ($parameters as $key => $value){
            if (is_array($key) || is_array($value)) continue;
            $pair = array(urlencode($key), urlencode($value));
            $query .= implode($primary, $pair) . $secondary;
        }
        return rtrim($query, $secondary);
    }
}