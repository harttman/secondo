## Secondo

### instalation
```bash
composer require harttman/secondo
```

# THIS LIB IS WORKING

```php
<?php
include __DIR__."/vendor/autoload.php";
$bot = new  Bot("TOKEN");
$bot->on("message", function($message) {
    $message->send("hw");
});

$bot->poll();
```

See `example` or `guide`!

By harttman
