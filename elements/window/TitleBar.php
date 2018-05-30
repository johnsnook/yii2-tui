<?php

/**
 * @author John Snook
 * @date May 19, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 * Description of TitleBar
 */

namespace johnsnook\tui\elements\window;

use johnsnook\tui\components\Style;
use johnsnook\tui\behaviors\DraggableBehavior;
use johnsnook\tui\events\DragEvent;
use johnsnook\tui\elements\Element;

class TitleBar extends \johnsnook\tui\elements\Control {

    public $label = 'Untitled';

    public function init() {
        parent::init();
        $this->height = 1;
        #$this->style->pull = Style::TOP;
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
