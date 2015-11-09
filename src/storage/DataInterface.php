<?php

namespace frostealth\storage;

/**
 * Interface DataInterface
 *
 * @package frostealth\storage
 */
interface DataInterface extends \IteratorAggregate, \Countable
{
    /**
     * @param array $data
     */
    public function __construct(array $data = []);

    /**
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key);

    /**
     * @return array
     */
    public function keys();

    /**
     * @param string $key
     */
    public function remove($key);

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function set($key, $value);
}
