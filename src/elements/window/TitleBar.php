<?php

/**
 * @author John Snook
 * @date May 19, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 * Description of TitleBar
 */

namespace johnsnook\tui\elements\window;

use johnsnook\tui\behaviors\DraggableBehavior;
use johnsnook\tui\components\Style;
use johnsnook\tui\elements\Control;
use johnsnook\tui\elements\Element;
use johnsnook\tui\events\DragEvent;
use johnsnook\tui\helpers\Unicodes;
use johnsnook\tui\helpers\Format;
use \johnsnook\tui\helpers\Debug;

class TitleBar extends Control {

    public $label = 'Untitled';

    public function init() {
        parent::init();
        $this->height = 1;
        $this->style->pull = Style::TOP;
    }

    /**
     * Make us draggable
     *
     * @return array The behaviors this class uses
     */
    public function behaviors() {
        return [
            'draggable' => [
                'class' => DraggableBehavior::className(),
            ]
        ];
    }

    public function beforeShow() {
        parent::beforeShow();
        $label = Unicodes::mbStringPad($this->label, $this->width, Unicodes::THREE_LINES, STR_PAD_BOTH);
        $pen = $this->style->getPen(Format::FG_GREY, Format::xtermBgColor(93), Format::BOLD);
        $this->buffer->writeToRow($label, 0, 0, $pen);
        Debug::log($this, $this->absoluteRectangle);
    }

    public function afterShow() {
        parent::afterShow();
        $this->owner->on(Element::MOVE_EVENT, 'updateRectangle');
        $this->on(DraggableBehavior::DRAG_END, 'onDrag');
    }

    public function afterHide() {
        parent::afterHide();
        $this->off(DraggableBehavior::DRAG_END, 'onDrag');
    }

    public function updateRectangle($event) {
        $this->dragRect = $this->absoluteRectangle();
    }

    public function onDrag(DragEvent $event) {
        $x = $event->endPoint->x - $this->startDrag->x;
        $y = $event->endPoint->y - $this->startDrag->y;

        $this->owner->hide();
        $this->owner->move($this->y + $y, $this->x + $x);
        $this->owner->show();
        $event->handled = true;
    }

}
