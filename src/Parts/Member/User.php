<?php
/**
 * @author harttman https://github.com/harttman
 * @package Secondo
 */
namespace Secondo\Parts\Member;

use Secondo\Utils\BaseApi;
class User {
    public int $id;
    public bool $is_bot;
    public string $first_name;
    public ?string $last_name;
    public ?string $username;
    public ?string $langauge_code;
    public bool $is_premium;
    private BaseApi $api;

    /**
     * User construcor.
     * 
     * @param object $data User data object from API. 
     * @param BaseApi $api API communication.
     */
    public function __construct(mixed $data, BaseApi $api) {
        $this->api = $api;

        $this->id = $data->id;
        $this->is_bot = $data->is_bot ?? false;
        $this->first_name = $data->first_name;
        $this->last_name = $data->last_name ?? "";
        $this->username = $data->username ?? "";
        $this->langauge_code = $data->langauge_code ?? "en";
        $this->is_premium = $data->is_premium ?? false; 
    }
}