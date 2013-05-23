<?php
/**
 * The Configuration Singleton class in which configuration parameters are stored
 *
 * @package cloudapi
 */
class Config {
    /** @var array $config The configuration data in array format */
    protected $_config = array();

    /**
     * Get the Singleton instance of this class.
     *
     * @return Config
     */
    public static function instance() {
        static $instance = null;
        if ($instance === null) {
            $instance = new Config();
        }
        return $instance;
    }

    /**
     * Hide construct method to make Singleton class.
     */
    private function __construct() {}

    /**
     * Get a configuration value
     *
     * @param string $k The key of the value to get
     * @param null $default If the value desired is not set, use this value
     * @return mixed|null
     */
    public static function get($k,$default = null) {
        $config = Config::instance();
        $v = $config->$k;
        return $v === null ? $default : $v;
    }

    /**
     * Set a configuration value
     *
     * @todo Make setting sub-arrays work here
     *
     * @param string $k
     * @param mixed $v
     * @return mixed
     */
    public static function set($k,$v) {
        $config = Config::instance();
        return $config->$k = $v;
    }

    /**
     * Override __get to provide ->value functionality
     *
     * @param string $name The key in the configuration array to get from
     * @return mixed
     */
    public function __get($name) {
        if (empty($this->_config)) $this->fetch();

        if (array_key_exists($name,$this->_config)) {
            return $this->_config[$name];
        } else {
            $v = $this->_getConfigValue($this->_config,$name);
            if ($v !== null) return $v;
        }
/*
        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);*/
        return null;
    }

    /**
     * Override __set to provide ->value= functionality
     *
     * @param string $name The key in the configuration array to set
     * @param mixed $value The name of the value to set
     */
    public function __set($name,$value) {
        if (empty($this->_config)) $this->fetch();

        $this->_config[$name] = $value;
    }

    /**
     * Grab the configuration file and store it to the config array
     *
     * @return mixed
     */
    protected function fetch() {
        $configPath = dirname(dirname(__FILE__)).'/config/config.json';
        if (file_exists($configPath)) {
            $xml = file_get_contents($configPath);
            $this->_config = json_decode($xml,true);
        } else {
            die('No config at: '.$configPath);
        }
        return $this->_config;
    }

    /**
     * Get the configuration value, allowing for . syntax notation to delineate sub-arrays
     *
     * @param array $context The array to search
     * @param string $name The name of the key
     * @return null
     */
    private function _getConfigValue(&$context, $name) {
        $pieces = explode('.', $name);
        foreach ($pieces as $piece) {
            if (!is_array($context) || !array_key_exists($piece, $context)) {
                // error occurred
                return null;
            }
            $context = &$context[$piece];
        }
        return $context;
    }
}