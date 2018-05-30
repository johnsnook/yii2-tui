<?php

/**
 * @author John Snook
 * @date May 27, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace johnsnook\tui\behaviors;

class ControlBehavior extends \yii\base\Behavior {

    /**
     * @var string $label The buttons label
     */
    protected $label;

    /**
     * @var boolean Can this element receive focus via arrow keys or tabbing?
     */
    protected $canReceiveFocus = true;

    public function setLabel($val) {
        $this->label = $val;
    }

    /**
     * the plaintext length of this label
     */
    protected function getLabelLength() {
        return strlen(str_replace('_', '', $this->label));
    }

    public function getLabel() {
        return $this->label;
    }

    public function getCanReceiveFocus() {
        return $this->canReceiveFocus;
    }

    public function onFocus() {

    }

    public function onBlur() {

    }

}
