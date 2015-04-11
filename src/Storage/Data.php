<?php

namespace frostealth\Storage;

/**
 * Class Data
 *
 * @package frostealth\Storage
 */
class Data
{
    /** @var array */
    protected $data;

    /**
     * @param array $data
     */
    public function  __construct(array $data = [])
    {
        $this->fill($data);
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->has($key) ? $this->data[$key] : $default;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * @return array
     */
    public function keys()
    {
        return array_keys($this->data);
    }

    /**
     * @param string $key
     */
    public function remove($key)
    {
        unset($this->data[$key]);
    }

    /**
     * @param array $data
     * @param bool $recursive
     */
    public function replace(array $data, $recursive = false)
    {
        $function = $recursive ? 'array_replace_recursive' : 'array_replace';
        $result = call_user_func($function, $this->all(), $data);
        $this->fill($result);
    }

    /**
     * @param array $data
     */
    public function fill(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->data;
    }

    public function clear()
    {
        $this->fill([]);
    }
}
 