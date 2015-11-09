# PHP Data Storage

Simple PHP Data Storage.

## Usage

```php
$storage = new frostealth\storage\Data(); // or $storage = new frostealth\storage\Data($array);
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

$storage->clear();

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
     * @param DataInterface $storage
     */
    public function __construct(DataInterface $storage)
    {
        $this->storage = $data;
    }
}
```