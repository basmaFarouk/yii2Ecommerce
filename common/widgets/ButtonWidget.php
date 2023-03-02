<?php

namespace common\widgets;

use Yii;
use yii\base\Widget;

class ButtonWidget extends Widget
{
    public $text;

    public function init()
    {
        parent::init();
        $this->text=ucfirst($this->text);
    }

    public function run() //return the html we want to use
    {
        parent::run();
        return '<button>'.$this->text.'</button>';
    }
}