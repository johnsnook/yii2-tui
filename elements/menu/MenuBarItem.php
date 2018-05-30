<?php

/**
 * @author John Snook
 * @date May 2, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace johnsnook\tui\elements\menu;

//use johnsnook\tui\events\RectangleEvent;
use johnsnook\tui\elements\Clickable;
use johnsnook\tui\helpers\Format;
use yii\base\Event;

/**
 * {@inheritDoc}
 * Contained by a menu bar, this control opens a menu when clicked
 */
class MenuBarItem extends Clickable {
    #use ClickableTrait;

    /**
     * Our menu pane
     * @var Menu
     */
    public $menu;

    /**
     * {@inheritDoc}
     * Initialize the Menu control, set our width and height then set the shortcut
     * key "pen" and set the callback for the click event.
     */
    public function init() {
        parent::init();
        $this->style->bgColor = $this->owner->style->bgColor;

        if (is_array($this->menu)) {
            $this->menu['owner'] = $this;
            $this->menu['id'] = $this->id . 'Menu';
            $this->menu = \Yii::createObject($this->menu);
        }
        $this->width = $this->labelLength + $this->style->paddingLeft + $this->style->paddingRight;
        $this->height = 1;

        $this->shortcutKeyDecorator = $this->style->getPen(Format::xtermFgColor(255), $this->style->bgColor);

        $this->click = function(Event $event) {
            if ($this->menu->visible) {
                $this->menu->hide();
            } else {
                $this->menu->show();
            }
        };
    }

    /**
     * {@inheritDoc}
     * Build the buffer, put the label in, position the Menu to be underneath us
     */
    public function beforeShow() {
        if (parent::beforeShow()) {
            $this->bufferLabel();
            return true;
        }
        return false;

//        $rect = $this->absolutePosition;
//        $this->menu->move($rect->top + 1, $rect->left);
//        $this->menu->onReady();
    }

    /**
     * {@inheritDoc}
     * When the mouse is down, highlight it
     */
    public function onMouseDown($event) {
        $this->style->decoration = Format::NEGATIVE;
        $this->buffer->build();
        $this->bufferLabel();
        $this->draw();
    }

    /**
     * {@inheritDoc}
     * When the mouse is up, set it back to normal
     */
    public function onMouseUp($event) {
        $this->style->decoration = Format::NORMAL;
        $this->buffer->build();
        $this->bufferLabel();
        $this->draw();
    }

}