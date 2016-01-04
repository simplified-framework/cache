<?php

namespace Simplified\Cache;

class MemoryCache implements CacheContainerInterface {
    private static $cache;

    public function __construct() {
        if (self::$cache == null)
            self::$cache = array();
    }

    public function has($key) {
        if (extension_loaded('apc'))
            return (boolean) apc_exists(strtolower($key));

        if (isset(self::$cache[$key]))
            return true;

        return false;
    }

    public function get($key) {
        if ($this->has($key)) {
            if (extension_loaded('apc')) {
                if (!$data = apc_fetch(strtolower($key))) {
                    throw new CacheException('Error fetching data with the key ' . $key . ' from the APC cache.');
                }
                return $data;
            }

            return self::$cache[$key];
        }
        return null;
    }

    public function set($key, $data) {
        if (extension_loaded('apc')) {
            if (!apc_store(strtolower($key), $data)) {
                throw new CacheException('Error saving data with the key ' . $key . ' to the APC cache.');
            }
            return $this;
        } else {
            self::$cache[$key] = $data;
        }

    }

    public function delete($key) {
        if ($this->has($key)) {
            if (extension_loaded('apc')) {
                if (!apc_delete(strtolower($key))) {
                    throw new CacheException('Error deleting data with the key ' . $key . ' from the APC cache.');
                }
                return true;
            }

            unset(self::$cache[$key]);
            return true;
        }
        return false;
    }

    public function clear() {
        if (extension_loaded('apc')) {
            apc_clear_cache();
            apc_clear_cache('user');
            apc_clear_cache('opcode');apc_clear_cache();
            apc_clear_cache('user');
            apc_clear_cache('opcode');
            return true;
        }

        self::$cache = array();
        return true;
    }
}