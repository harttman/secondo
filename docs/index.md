*Working with the "Secondo" library is very simple.*

# How does the work happen?

*Here is an example of a quick start.*

# first of all, install this
> ```bash ~/root $> composer require harttmann/secondo```

---
```php
<?php

include __DIR__."/vendor/autoload.php";

use Secondo\Bot;
use Secondo\Parts\Message;

$client = new Bot("12345:ABC");
$client->on("message", function(Message $message) {
    if($message->text == "/start") {
        $message->chat->send("Привет {$message->from->first_name}");
    }
});

$client->poll();
```

*Get your token from bot father!*

# Chat
### Fields:
In development
### Methods:
*send(strint text, array $options = [])*: bool
Guide for use:
```php
$chat = <Message>->chat;
$chat->send(
    "Hello, World",
    [
        "disable_notification" => true
    ]
);
```

# Message
### Fields:
In development
### Methods:
*send(int $chat_id, string $text, array $options = []): bool;*
Guide for use:
```php
<Client>->on("message", function(Message $message) {
    $message->send(
        $message->chat->id,
        "Hello, world"
    );
});
```