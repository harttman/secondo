<?php
namespace Secondo\Parts;
class Message {
    public string|null $text;
    public bool|null $isBot;
    public string|null $languageCode;
    public function __construct($data) {
        $this->text = $data->text ?? null;
        $this->isBot = $data->from->is_bot ?? null;
        $this->languageCode = $data->from->languageCode ?? null;
    }

    public function send() {}
}