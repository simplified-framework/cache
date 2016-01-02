<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 02.01.2016
 * Time: 18:35
 */

namespace Simplified\Cache;

use Simplified\Core\ContainerInterface;

interface CacheContainerInterface extends ContainerInterface {

    /**
     * @param $key string The key on which a cacheable item can be found in the store
     * @param $data mixed A serializable object, string or integer to hold in cache
     * @return void
     */
    public function set($key, $data);

    /**
     * @param $key string The key on which a cacheable item can be found in the store
     * @return boolean Returns true if the item was deleted, otherwise false
     */
    public function delete($key);

    /**
     * @return void
     */
    public function clear();
}