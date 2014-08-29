PHP Data Storage
================

Example
-----
```php
<?php

$storage = new frostealth\Storage\Data(); // or $storage = new frostealth\Storage\Data($array);
$storage->set('login', 'example@example.com');
// ...

if ($storage->has('login')) {
    $login = $storage->get('login');
    $storage->remove('login');
}

$storage->clear();

```