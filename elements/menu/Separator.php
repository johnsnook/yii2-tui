<?php

/**
 * @author John Snook
 * @date May 8, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 * Description of Separator
 */

namespace johnsnook\tui\elements\menu;

use johnsnook\tui\elements\Element;
use johnsnook\tui\helpers\Border;

class Separator extends Element {

    public function beforeShow() {
        if (parent::beforeShow()) {
            Border::bufferSeparator($this->owner->style, $this->buffer);
            return true;
        }
        return false;
    }

}
