<?php

namespace Secondo\Game;

use Secondo\Utils\BaseApi;

class Dice {
    public string $emoji;
    public int $value;

    public function __construct(mixed $data, BaseApi $api) {
        $this->emoji = $data->emoji;
        $this->value = $data->value;
    }
}