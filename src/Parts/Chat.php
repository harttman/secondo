<?php

namespace Secondo\Parts;

use Secondo\Api\ClientApi;

class Chat
{
    public int $id;
    public string $type;

    public ClientApi $api;
    public function __construct(mixed $data, ClientApi $api)
    {
        $this->id = $data->id;
        $this->type = $data->type;

        $this->api = $api;
    }
}
