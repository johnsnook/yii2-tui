<?php

/**
 * @author John Snook
 * @date April 28, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace johnsnook\tui\elements\menu;

use johnsnook\tui\elements\Container;

/**
 * {@inheritDoc}
 * Represents the menu bar, contains MenuBarElements
 */
class MenuBar extends Container {

    /**
     * {@inheritDoc}
     * Position the menu items
     */
    public function beforeShow() {
        if (parent::beforeShow()) {
            $pos = $this->left + 2;
            foreach ($this->elements as $element) {
                $length = $element->width;
                $element->move(1, $pos);
                $pos = $pos + $length + 1;
            }
        }
    }

}
