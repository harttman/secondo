<?php 
namespace Secondo\Parts\Member;

class From {
    public int $id;
    public bool $is_bot;
    public string $first_name;
    public string $last_name;
    public string $username;
    public string $language_code;
    public bool $is_premium;
    public bool $has_main_web_app;
    public bool $can_join_groups;

    public function __construct(mixed $data) {
        $this->id = $data->id;
        $this->is_bot = $data->is_bot ?? false;
        $this->first_name = $data->first_name ?? "";
        $this->last_name = $data->last_name ?? "";
        $this->username = $data->username ?? "";
        $this->language_code = $data->language_code;
        $this->is_premium = $data->is_premium ?? "";
        $this->has_main_web_app = $data->has_main_web_app ?? false;
        $this->can_join_groups = $data->can_join_groups ?? false;
    }
}