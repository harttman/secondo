## Secondo

### instalation
```bash
composer require harttmann/secondo
```

# How to use this lib?
*Easy...*

```php
<?php
include __DIR__."/vendor/autoload.php";
$bot = new  Bot("TOKEN");
$bot->on("message", function($message) {
    $message->chat->send("hw");
});

$bot->poll();
```

*use types to type your code*
See `example` or `guide`!

By harttman
