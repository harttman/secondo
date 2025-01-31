<?php
namespace Secondo\Api;
use GuzzleHttp\Client;
use Secondo\Logger\ClientLogger;

class ClientApi
{
    public Client $api;
    public ClientLogger $logger;
    private string $url;
    public function __construct(string $token)
    {
        $this->logger = new ClientLogger();
        $this->url = "https://api.telegram.org/bot$token";
        $this->api = new Client([
            "timeout" => 2.0,
        ]);
    }

    public function sendPost(string $post, array $options = []): string
    {
        $response = $this->api->post("{$this->url}/$post", [
            "form_params" => $options,
        ]);
        return $response->getBody()->getContents();
    }

    public function sendGet(string $method, array $options = []): string
    {
        $response = $this->api->get("{$this->url}/$method", [
            "query" => $options,
        ]);
        return $response->getBody()->getContents();
    }
}
