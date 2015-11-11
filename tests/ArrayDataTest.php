<?php

use frostealth\storage\ArrayData;

/**
 * Class ArrayDataTest
 */
class ArrayDataTest extends PHPUnit_Framework_TestCase
{
    public function testSetAndGet()
    {
        $storage = new ArrayData();

        $this->assertNull($storage->get('key'));

        $value = 'A value';
        $storage->set('key', $value);

        $this->assertSame($value, $storage->get('key'));
        $this->assertNull($storage->get('key.key'));

        $storage->set('key.key', $value);

        $this->assertSame($value, $storage->get('key.key'));
        $this->assertSame(['key' => $value], $storage->get('key'));

        $storage->set('key', ['key' => $value]);

        $this->assertSame($value, $storage->get('key.key'));
        $this->assertSame(['key' => $value], $storage->get('key'));
    }

    public function testHas()
    {
        $storage = new ArrayData();

        $this->assertFalse($storage->has('key'));

        $storage->set('key', 'a value');
        $this->assertTrue($storage->has('key'));
        $this->assertNotTrue($storage->has('key.key'));

        $storage->set('key.key', 'a value');
        $this->assertTrue($storage->has('key.key'));
        $this->assertTrue($storage->has('key'));
        $this->assertNotTrue($storage->has('key1'));
    }

    public function testRemoveAndClear()
    {
        $storage = new ArrayData();

        $storage->set('key1', 1);
        $storage->set('key2', 2);
        $storage->set('key3', 3);
        $storage->set('key4.key1', 1);
        $storage->set('key5', ['key1' => 1, 'key2' => 2]);

        $storage->remove('key3');
        $this->assertNull($storage->get('key3'));

        $storage->remove('key4.key1');
        $this->assertNull($storage->get('key4.key1'));
        $this->assertSame([], $storage->get('key4'));

        $storage->remove('key5.key2');
        $this->assertNull($storage->get('key5.key2'));
        $this->assertSame(['key1' => 1], $storage->get('key5'));

        $storage->clear();
        $this->assertNull($storage->get('key1'));
        $this->assertNull($storage->get('key2'));
        $this->assertNull($storage->get('key4'));
        $this->assertNull($storage->get('key5'));
    }

    public function testFillAndAll()
    {
        $arr = [
            'key1' => 'one',
            'key2' => 'two',
            'key3' => ['key1' => 'one'],
        ];
        $storage = new ArrayData();

        $storage->fill($arr);
        $this->assertSame($arr['key1'], $storage->get('key1'));
        $this->assertSame($arr['key2'], $storage->get('key2'));
        $this->assertSame($arr['key3'], $storage->get('key3'));
        $this->assertSame($arr['key3']['key1'], $storage->get('key3.key1'));
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
            'key4' => ['key1' => 1],
        ];
        $storage = new ArrayData();

        $storage->fill($arr);
        $this->assertSame(array_keys($arr), $storage->keys());
    }

    public function testDefault()
    {
        $storage = new ArrayData();

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
        $storage = new ArrayData();

        $storage->fill($arr1);
        $storage->replace($arr2);
        $this->assertSame(array_replace($arr1, $arr2), $storage->all());

        $storage->fill($arr1);
        $storage->replace($arr2, true);
        $this->assertSame(array_replace_recursive($arr1, $arr2), $storage->all());
    }
}
