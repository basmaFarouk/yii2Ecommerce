<?php

namespace common\widgets;


use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class BgWidget extends Widget
{
    public $bgColor='white';

    public function init()
    {
        parent::init();
        ob_start();
    }

    public function run() //return the html we want to use
    {
        parent::run();
        $output=ob_get_clean();
       return Html::tag('div',$output,[
            'style'=>'background-color: '.$this->bgColor,
        ]);
        //return '<div>'.$output.'</div>';
    }
}