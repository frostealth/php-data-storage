<?php

use frostealth\storage\Data;

/**
 * Class DataTest
 */
class DataTest extends \PHPUnit_Framework_TestCase
{
    public function testSetAndGet()
    {
        $storage = new Data();

        $this->assertNull($storage->get('key'));

        $value = 'A value';
        $storage->set('key', $value);

        $this->assertSame($value, $storage->get('key'));
    }

    public function testHas()
    {
        $storage = new Data();

        $this->assertFalse($storage->has('key'));

        $storage->set('key', 'a value');
        $this->assertTrue($storage->has('key'));
    }

    public function testRemoveAndClear()
    {
        $storage = new Data();

        $storage->set('key1', 1);
        $storage->set('key2', 2);
        $storage->set('key3', 3);

        $storage->remove('key3');
        $this->assertNull($storage->get('key3'));

        $storage->clear();
        $this->assertNull($storage->get('key1'));
        $this->assertNull($storage->get('key2'));
    }

    public function testFillAndAll()
    {
        $arr = [
            'key1' => 'one',
            'key2' => 'two',
        ];
        $storage = new Data();

        $storage->fill($arr);
        $this->assertSame($arr['key1'], $storage->get('key1'));
        $this->assertSame($arr['key2'], $storage->get('key2'));
        $this->assertSame($arr, $storage->all());

        $arr = ['a value'];
        $storage->fill($arr);
        $this->assertSame($arr, $storage->all());
    }

    public function testKeys()
    {
        $arr = [
            'key1' => 1,
            'key2' => 2,
            'key3' => 3,
        ];
        $storage = new Data();

        $storage->fill($arr);
        $this->assertSame(array_keys($arr), $storage->keys());
    }

    public function testDefault()
    {
        $storage = new Data();

        $this->assertFalse($storage->get('key', false));
        $this->assertSame(0, $storage->get('key', 0));

        $storage->set('key', 'a value');
        $this->assertNotFalse($storage->get('key', false));
    }

    public function testReplace()
    {
        $arr1 = [
            'key1' => 1,
            'key2' => 2,
            'key3' => 3,
            'key4' => [
                'key1' => 'one',
                'key2' => 'two',
            ],
        ];
        $arr2 = [
            'key2' => 'two',
            'key3' => 'three',
            'key4' => [
                'key2' => 2,
                'key3' => 3,
            ],
        ];
        $storage = new Data();

        $storage->fill($arr1);
        $storage->replace($arr2);
        $this->assertSame(array_replace($arr1, $arr2), $storage->all());

        $storage->fill($arr1);
        $storage->replace($arr2, true);
        $this->assertSame(array_replace_recursive($arr1, $arr2), $storage->all());
    }
}
 