<?php
namespace Secondo\Parts\Game;

class Dice
{
    public string $emoji;
    public int $value;
    public function __construct(mixed $data)
    {
        $this->emoji = $data->emoji;
        $this->value = $data->value;
    }
}
