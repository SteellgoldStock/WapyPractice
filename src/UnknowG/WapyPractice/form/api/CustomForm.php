<?php

namespace UnknowG\WapyPractice\form\api;

class CustomForm extends Form
{
    private $labelMap = [];

    /**
     * @param callable $callable
     */
    public function __construct(?callable $callable) {
        parent::__construct($callable);
        $this->data["type"] = "custom_form";
        $this->data["title"] = "";
        $this->data["content"] = [];
    }

    public function processData(&$data) : void {
        if(is_array($data)) {
            $new = [];
            foreach ($data as $i => $v) {
                $new[$this->labelMap[$i]] = $v;
            }
            $data = $new;
        }
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title) : void{
        $this->data["title"] = $title;
    }

    /**
     * @return string
     */
    public function getTitle() : string{
        return $this->data["title"];
    }

    /**
     * @param string $text
     * @param string|null $label
     */
    public function addLabel(string $text, ?string $label = null) : void
    {
        $this->addContent(["type" => "label", "text" => '§9§l» §r§f' . $text]);
        $this->labelMap[] = $label ?? count($this->labelMap);
    }

    /**
     * @param string $text
     * @param bool|null $default
     * @param string|null $textColor
     * @param string|null $label
     */
    public function addToggle(string $text, bool $default = null, String $textColor = "9", ?string $label = null) : void {
        $content = ["type" => "toggle", "text" => '§'.$textColor.'§l» §r§f' . $text];
        if($default !== null) {
            $content["default"] = $default;
        }
        $this->addContent($content);
        $this->labelMap[] = $label ?? count($this->labelMap);
    }

    /**
     * @param string $text
     * @param int $min
     * @param int $max
     * @param int $step
     * @param int $default
     * @param string|null $label
     */
    public function addSlider(string $text, int $min, int $max, int $step = -1, int $default = -1, ?string $label = null) : void{
        $content = ["type" => "slider", "text" => '§9§l» §r§f' . $text, "min" => $min, "max" => $max];
        if($step !== -1) {
            $content["step"] = $step;
        }

        if($default !== -1) {
            $content["player"] = $default;
        }

        $this->addContent($content);
        $this->labelMap[] = $label ?? count($this->labelMap);
    }

    /**
     * @param string $text
     * @param array $options
     * @param int|null $default
     * @param string $textColor
     * @param string|null $label
     */
    public function addDropdown(string $text, array $options, int $default = null, string $textColor = "9", ?string $label = null) : void {
        $this->addContent(["type" => "dropdown", "text" => "§".$textColor."§l» §r§f" . $text, "options" => $options, "default"=> $default]);
        $this->labelMap[] = $label ?? count($this->labelMap);
    }

    /**
     * @param string $text
     * @param string $placeholder
     * @param string|null $default
     * @param string|null $label
     */
    public function addInput(string $text, string $placeholder = "", string $default = null, ?string $label = null) : void{
        $this->addContent(["type" => "input", "text" => '§9§l» §r§f' . $text, "placeholder" => $placeholder, "player" => $default]);
        $this->labelMap[] = $label ?? count($this->labelMap);
    }

    /**
     * @param array $content
     */
    private function addContent(array $content) : void{
        $this->data["content"][] = $content;
    }

}