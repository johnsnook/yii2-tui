<?php

/**
 * @author John Snook
 * @date Apr 28, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace johnsnook\tui\elements;

use johnsnook\tui\components\Style;
use johnsnook\tui\helpers\Format;
use johnsnook\tui\behaviors\ClickableBehavior;

/**
 * A button that can be activated via mouse clicks or a shortcut key
 */
class Button extends Element {

    /**
     * {@inheritDoc}
     */
    public function init() {
        parent::init();
        $this->shortcutKeyDecorator = $this->style->getPen(Format::xtermFgColor(255), $this->style->bgColor);
    }

    public function behaviors() {
        #parent::behaviors();
        return [
            'clickable' => ClickableBehavior::className()
        ];
    }

    /**
     * {@inheritDoc}
     * if we have a border, make it look pushed in.
     */
    public function onMouseDown($event) {
        if ($this->style->borderWidth && $this->style->borderWidth !== Style::NONE) {
            $this->style->borderStyle = Style::INSET;
        } else {
            $this->style->decoration = Format::NEGATIVE;
        }
        $this->buffer->build();
        $this->bufferLabel();
        $this->draw();
    }

    /**
     * {@inheritDoc}
     * if we have a border, set it back to how it was
     */
    public function onMouseUp($event) {
        $this->style->decoration = Format::NORMAL;
        if ($this->style->borderWidth) {
            $this->style->borderStyle = Style::OUTSET;
        }
        $this->buffer->build();
        $this->bufferLabel();
        $this->draw();
    }

}
