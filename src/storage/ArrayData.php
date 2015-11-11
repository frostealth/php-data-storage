<?php

namespace frostealth\storage;

/**
 * Class ArrayData
 *
 * @package frostealth\storage
 */
class ArrayData implements DataInterface, \ArrayAccess
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    /**
     * Set an array item to a given value using "dot" notation
     * If no key is given to the method, the entire array will be replaced
     *
     * @param string $key
     * @param mixed  $value
     */
    public function set($key, $value)
    {
        $data = &$this->data;
        if ($this->isDotNotation($key)) {
            $keys = explode('.', $key);
            $key = array_pop($keys);

            foreach ($keys as $segment) {
                if (!isset($data[$segment]) || !is_array($data[$segment])) {
                    $data[$segment] = [];
                }

                $data = &$data[$segment];
            }
        }

        $data[$key] = $value;
    }

    /**
     * Get an item from an array using "dot" notation
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }

        $value = $default;
        if ($this->isDotNotation($key)) {
            $keys = explode('.', $key);
            $value = $this->data;

            foreach ($keys as $segment) {
                if (!is_array($value) || !array_key_exists($segment, $value)) {
                    $value = $default;
                    break;
                }

                $value = $value[$segment];
            }
        }

        return $value;
    }

    /**
     * Check if an item exists in an array using "dot" notation
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        $result = array_key_exists($key, $this->data);
        if (!$result && $this->isDotNotation($key)) {
            $result = true;
            $keys = explode('.', $key);
            $data = $this->data;

            foreach ($keys as $key) {
                if (!is_array($data) || !array_key_exists($key, $data)) {
                    $result = false;
                    break;
                }

                $data = $data[$key];
            }
        }

        return $result;
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
        $data = &$this->data;
        if ($this->isDotNotation($key)) {
            $keys = explode('.', $key);
            $key = array_pop($keys);

            foreach ($keys as $segment) {
                if (!is_array($data) || !array_key_exists($segment, $data)) {
                    break;
                }

                $data = &$data[$segment];
            }
        }

        if (is_array($data)) {
            unset($data[$key]);
        }
    }

    /**
     * @param array $data
     * @param bool  $recursive
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

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    /**
     * Clear all values
     */
    public function clear()
    {
        $this->fill([]);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    protected function isDotNotation($key)
    {
        return strpos($key, '.') !== false;
    }
}
