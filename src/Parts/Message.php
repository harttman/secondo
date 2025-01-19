<?php
namespace Secondo\Parts;
class Message {
    public string $text;
    public bool $isBot;
    public string $languageCode;
    public function __construct($data) {
        $this->text = $data["text"];
        $this->isBot = $data["is_bot"];
        $this->languageCode = $data["language_code"];
    }

    public function send() {}
}