<?php
class Cacher {
    public $directory = '';
    public function __construct() {
        $this->directory = dirname(dirname(__FILE__)).'/cache/';
    }

    protected function _getCacheFilename($k) {
        return rtrim($this->directory,'/').'/'.strtolower(str_replace('/','-',$k)).'.cache.php';
    }

    public function get($k) {
        $cache = false;
        $cacheFile = $this->_getCacheFilename($k);
        if (file_exists($cacheFile)) {
            $cache = include $cacheFile;
        }
        return $cache;
    }

    public function set($k,$v,$expire = 0) {
        $set = false;
        if ($v !== null) {
            //$k = str_replace('/','.',$k);
            if ($expire === null) $expire = 0;
            $expireTime = $expire ? time()+$expire : 0;
            $expireContent = 'if(time() > '.$expireTime.'){return null;}';
            $cacheFile = $this->_getCacheFilename($k);
            $content = '<?php '.$expireContent.' return '.var_export($v,true).';';
            $set = $this->_writeFile($cacheFile,$content);
        }
        return $set;
    }

    protected function _writeFile($filename,$content) {
        $written = false;
        $directory = dirname($filename);
        if (is_dir($directory) && is_writeable($directory)) {
            $file= fopen($filename,'wb');
            if ($file) {
                fseek($file, 0);
                ftruncate($file, 0);
                $written= fwrite($file, $content);
                fclose($file);
            }
        } elseif (!is_writeable($directory)) {
            echo 'Cache directory at '.$directory.' not writable.';
        } elseif (!is_dir($directory)) {
            echo 'Cache directory at '.$directory.' does not exist!';
        }
        return $written;
    }
}