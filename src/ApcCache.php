<?php

namespace Simplified\Cache;

class ApcCache implements CacheContainerInterface {

    public function has($key) {
        return (boolean) apc_exists(strtolower($key));
    }

    public function get($key) {
        if ($this->has($key)) {
            if (!$data = apc_fetch(strtolower($key))) {
                throw new CacheException('Error fetching data with the key ' . $key . ' from the APC cache.');
            }
            return $data;
        }
        return null;
    }

    public function set($key, $data) {
        if (!apc_store(strtolower($key), $data)) {
            throw new CacheException('Error saving data with the key ' . $key . ' to the APC cache.');
        }
        return $this;
    }

    public function delete($key) {
        if ($this->has($key)) {
            if (!apc_delete(strtolower($key))) {
                throw new CacheException('Error deleting data with the key ' . $key . ' from the APC cache.');
            }
            return true;
        }
        return false;
    }

    public function clear() {
        apc_clear_cache();
    }
}