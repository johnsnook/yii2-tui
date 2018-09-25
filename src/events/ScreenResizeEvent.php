<?php

/**
 * @author John Snook
 * @date Apr 29, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 * Description of ResizeEvent
 */

namespace johnsnook\tui\events;

class ScreenResizeEvent extends \yii\base\Event {

    public $width;
    public $height;

}
