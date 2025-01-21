Here's the documentation for the provided PHP codebase in English:

---

# **Secondo Bot Framework Documentation**

## **Overview**
The `Secondo` bot framework provides tools to create and manage bots with event handling, message processing, and API communication. This package is designed to integrate with messaging platforms via HTTP APIs.

---

## **Main Classes**

### **1. Bot**
The core bot class handles events, communicates with the API, and processes incoming messages.

#### **Properties**
- `BaseApi $api` - Handles API communication.
- `int $offset` - Tracks the last processed update ID.
- `?Message $message` - Stores the most recent message object.
- `array $eventHandler` - Stores event callbacks for different events.

#### **Methods**
- `__construct(string $token)`
  - Initializes the bot with an API token.
- `on(string $event, callable $callback)`
  - Registers an event listener.
  - **Parameters:**
    - `string $event` - The event type (e.g., `message`).
    - `callable $callback` - The callback function to execute.
- `triggers(string $event, mixed $data)`
  - Executes all callbacks registered for a specific event.
- `poll(): never`
  - Continuously polls the API for updates and processes them.

---

### **2. Message**
Handles individual messages, including their metadata and actions.

#### **Properties**
- `int $message_id` - The unique ID of the message.
- `?User $from` - The sender of the message.
- `?int $sender_boost_count` - The sender’s boost count, if available.
- `?int $date` - The timestamp of the message.
- `Chat $chat` - The chat object where the message originated.
- `?string $text` - The text content of the message.

#### **Methods**
- `__construct(mixed $data, BaseApi $api)`
  - Initializes the message object using data from the API.
- `send($chat_id, $text)`
  - Sends a message to a specified chat.
  - **Parameters:**
    - `$chat_id` - The ID of the recipient chat.
    - `$text` - The message content.

---

### **3. Chat**
Represents a chat and provides functionality to interact with it.

#### **Properties**
- `?int $id` - The unique ID of the chat.
- `string $type` - The type of chat (e.g., private, group, supergroup).
- `?string $title` - The chat title, if applicable.
- `?string $username` - The username associated with the chat.
- `?string $first_name` - The first name of the chat owner.
- `?string $last_name` - The last name of the chat owner.
- `?bool $is_forum` - Indicates whether the chat is a forum.

#### **Methods**
- `__construct(mixed $data, BaseApi $api)`
  - Initializes the chat object using data from the API.
- `send(string $text, array $options = []): bool`
  - Sends a message to the chat.
  - **Parameters:**
    - `string $text` - The message content.
    - `array $options` - Additional options (e.g., `parse_mode`, `disable_notification`).

---

### **4. User**
Represents a user and their details.

#### **Properties**
- `int $id` - The user ID.
- `bool $is_bot` - Whether the user is a bot.
- `string $first_name` - The user’s first name.
- `?string $last_name` - The user’s last name.
- `?string $username` - The user’s username.
- `?string $language_code` - The user’s language code.
- `bool $is_premium` - Indicates if the user has premium status.

#### **Methods**
- `__construct(mixed $data, BaseApi $api)`
  - Initializes the user object using data from the API.

---

## **Utilities**

### **BaseApi**
The `BaseApi` class is used internally to send requests to the messaging platform's API. While it is not directly defined here, its key functionality includes:
- Sending GET and POST requests.
- Constructing API endpoint URLs.

---

## **Usage**

### **1. Initialize the Bot**
```php
use Secondo\Bot;

$bot = new Bot("YOUR_API_TOKEN");
```

### **2. Register Event Handlers**
```php
$bot->on('message', function($message) {
    $message->chat->send("Hello, this is a response!");
});
```

### **3. Start Polling**
```php
$bot->poll();
```

---

## **Error Handling**
- **`LogicException` in `Chat::send()`**  
  Raised if the chat ID is not available when trying to send a message.
- **API Communication Errors**  
  Errors during API communication are logged.

---

# **Guide to Using `Chat` and `Message` Methods**

This guide provides practical examples and explanations for using the `Chat` and `Message` classes within the **Secondo** bot framework.

---

## **1. Chat Class**

The `Chat` class represents a chat object (e.g., a private chat, group, or channel) and provides methods to interact with it.

### **Properties**
- `int $id` - Unique identifier for the chat.
- `string $type` - Type of chat (`private`, `group`, `supergroup`, etc.).
- `?string $title` - Title of the chat (for groups and channels).
- `?string $username` - Username of the chat (if available).
- `?string $first_name` - First name of the chat participant (for private chats).
- `?string $last_name` - Last name of the chat participant (for private chats).
- `?bool $is_forum` - Indicates if the chat is a forum.

---

### **Methods**

#### **send(string $text, array $options = []): bool**
Sends a message to the current chat.

##### **Parameters**
- `string $text` - The content of the message.
- `array $options` - Additional options for the message, such as:
  - `parse_mode`: Formatting options (e.g., `Markdown`, `HTML`).
  - `disable_notification`: If true, the message is sent silently.
  - `reply_to_message_id`: Replies to a specific message ID.

##### **Example Usage**
```php
// Assuming $chat is an instance of the Chat class
$chat->send("Hello, welcome to the group!");
```

**With Options:**
```php
$options = [
    'parse_mode' => 'Markdown',
    'disable_notification' => true,
];
$chat->send("*Important Announcement!* Please read carefully.", $options);
```

##### **Error Handling**
- Throws a `LogicException` if the chat ID is missing.

---

## **2. Message Class**

The `Message` class represents an incoming message and provides methods to interact with the message or its sender.

### **Properties**
- `int $message_id` - Unique identifier for the message.
- `?User $from` - The sender of the message (an instance of `User`).
- `?int $sender_boost_count` - Sender’s boost count (if available).
- `?int $date` - Timestamp of the message.
- `Chat $chat` - The chat object where the message was sent.
- `?string $text` - The text content of the message.

---

### **Methods**

#### **send(mixed $chat_id, mixed $text): void**
Sends a new message to a specified chat.

##### **Parameters**
- `mixed $chat_id` - The unique ID of the chat where the message will be sent.
- `mixed $text` - The content of the message.

##### **Example Usage**
```php
// Assuming $message is an instance of the Message class
$message->send($message->chat->id, "Thank you for your message!");
```

---

## **Practical Usage Example**

Here is a complete example demonstrating how to use the `Chat` and `Message` methods in an event-driven bot.

```php
use Secondo\Bot;

$bot = new Bot("YOUR_API_TOKEN");

// Listen for messages
$bot->on('message', function($message) {
    // Respond to the chat where the message came from
    $message->chat->send("Hello, " . $message->from->first_name . "! How can I assist you?");
});

// Start polling for updates
$bot->poll();
```

---

### **Advanced Example with Formatting and Options**

```php
use Secondo\Bot;

$bot = new Bot("YOUR_API_TOKEN");

$bot->on('message', function($message) {
    $options = [
        'parse_mode' => 'HTML',
        'disable_notification' => true,
    ];

    $reply = "<b>Hello, " . $message->from->first_name . "!</b>\n";
    $reply .= "Here is an example of a formatted response.";

    $message->chat->send($reply, $options);
});

$bot->poll();
```

---

This guide should help you effectively use the `Chat` and `Message` methods to interact with chats and process messages in the **Secondo** framework.

<<<<<<< HEAD
BY VITALIY DAKIVA
=======
BY VITALIY DAKIVA
>>>>>>> 752e2f0876978163ab021ee8a7196b5aa7936b84
