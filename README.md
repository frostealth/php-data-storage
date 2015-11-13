# PHP Data Storage

Simple PHP Data Storage.

## Installation

Run the [Composer](http://getcomposer.org/download/) command to install the latest stable version:

```
composer require frostealth/php-data-storage @stable
```

## Usage

```php
$storage = new frostealth\storage\Data(); // or new frostealth\storage\Data($array);
$storage->set('login', 'example@example.com');

// ...

if ($storage->has('login')) {
    $login = $storage->get('login');
    $storage->remove('login');
}
// or with default value
if ($storage->get('login', false)) {
    $login = $storage->get('login');
    $storage->remove('login');
}

// ...

$storage->clear(); // clear all values
```

Working with arrays using "dot" notation

```php
$storage = new frostealth\storage\ArrayData();
$storage->set('params', ['method' => 'post', 'url' => 'http://example.com/']);

$url = $storage->get('params.url'); // 'http://example.com/'
$storage->set('params.method', 'get');
$method = $storage->get('params.method'); // 'get'
$params = $storage->get('params'); // ['method' => 'get', 'url' => 'http://example.com/']

$storage->set('options.my_option', 'value');
$options = $storage->get('options'); // ['my_option' => 'value']

```

## Dependency Injection

```php
use frostealth\storage\DataInterface;

class MyClass
{
    /**
     * @var DataInterface
     */
    protected $data;

    /**
     * @param DataInterface $data
     */
    public function __construct(DataInterface $data)
    {
        $this->data = $data;
    }
}
```

## License

The MIT License (MIT).
See [LICENSE.md](https://github.com/frostealth/php-data-storage/blob/master/LICENSE.md) for more information.