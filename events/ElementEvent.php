<?php

/**
 * @author John Snook
 * @date Apr 27, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 * Description of MouseEvent
 */

namespace johnsnook\tui\events;

class ElementEvent extends \yii\base\Event {

    public $what;
    public $new;
    public $old;

}
