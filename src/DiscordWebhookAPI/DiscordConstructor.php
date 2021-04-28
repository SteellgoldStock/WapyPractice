<?php

namespace DiscordWebhookAPI;

class DiscordConstructor {

    const LOGGER_CHANNEL = "799587642898907138/NvHvtlDVDapLKD-jl6fPiUFUDCJhH13LKyewQBTiZBnIgAjirWs5a4aLLk7Vd4fhhqzl";

    /**
     * @var array $data
     */
    public $data;

    public function __construct(String $title = "Default Title", String $contentMessage = "Please, enter a message"){
        $this->data["title"] = $title;
        $this->data["content"] = $contentMessage;
    }

    public function send(){
        $embed = new Embed();
        $message = new Message();
        $embed->setTitle($this->data["title"]);
        $embed->setDescription($this->data["content"]);
        $message->addEmbed($embed);

        $webhook = new Webhook(self::LOGGER_CHANNEL);
        $webhook->send($message);
    }
}