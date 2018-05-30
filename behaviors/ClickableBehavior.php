<?php

/**
 * @author John Snook
 * @date Apr 28, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace johnsnook\tui\behaviors;

use johnsnook\tui\components\Style;
use johnsnook\tui\components\Observer;
use johnsnook\tui\elements\Element;
use johnsnook\tui\events\KeyPressEvent;
use johnsnook\tui\events\MouseEvent;

/**
 * Signals interest in and provides method for ClickEvents
 *
 * Provides the events, properties and methods to make an element respond to
 * clicks.
 */
class ClickableBehavior extends ControlBehavior {

    /**
     * @event MouseEvent|KeyPressEvent "Clicks" can be triggered by either clicking
     * with the mouse or using the keyboard shortcut.
     */
    const CLICK_EVENT = 'click';

    /**
     * set to '' for things like drop down menus?
     */
    public $keyModifier = 'ALT-';

    /**
     * this should contain a \johnsnook\tui\components\Style Pen string.
     */
    public $shortcutKeyDecorator;

    /**
     * @Description To use, declare a KeyPressEvent with the settings you're interested in
     * @var johnsnook\tui\events\KeyPressEvent
     */
    public $shortcutKey = '';

    public function events() {
        return [
            Element::BEFORE_SHOW_EVENT => 'beforeShow',
            Element::AFTER_SHOW_EVENT => 'afterShow',
            Element::AFTER_HIDE_EVENT => 'afterHide',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function beforeShow($event) {
        $this->bufferLabel();
    }

    /**
     * This class has the ability to use a shortcut key.  If a label has an
     * underscore before a letter, then that letter becomes the shortcut keys letter.
     * So we need find the position of the underscore, remove it, and highlight
     * the character by adding an underline
     *
     * Welcome the 3rd edition of "prepareLabel".  Takes a string with or without
     * an underscore and writes it to the center of the buffer.  At some point
     * I should add text justification to the Style.  Maybe a $labelRect?
     */
    protected function bufferLabel() {
        $owner = $this->owner;
        if ($owner->style->textAlign === Style::CENTER) {
            $y = round(($owner->height > 2) ? ($owner->height / 2) : 1);
            $x = round(($owner->width / 2) - ($this->labelLength / 2));
        } else {
            $y = 1 + $owner->style->paddingTop;
            $x = 1 + $owner->style->paddingLeft;
        }

        $label = str_replace('_', '', $this->label);
        $owner->buffer->writeToRow($label, $y - 1, $x - 1);

        if (($shortcutPos = strpos($this->label, '_')) !== false) {
            $letter = substr($label, $shortcutPos, 1);
            $this->shortcutKey = strtolower($letter);
            $owner->buffer->code($y - 1, $x + $shortcutPos - 1, $this->shortcutKeyDecorator);
        } else {
            $this->shortcutKey = null;
        }
    }

    /**
     * We care about 3 kinds of events: key press, mouse down and mouse up.  It's
     * not a proper click unless the mouse down and mouse up occur within our rectangle.
     *
     * We really only care about mouse up events after a mouse down happens in our
     * rectangle, so we reserve attaching a listener for mouse up until after the
     * mouse down event.
     */
    public function afterShow($event) {
        Tui::$observer->on(Observer::KEY_PRESSED, [$this, 'keypressHandler']);
        Tui::$observer->on(Observer::MOUSE_LEFT_DOWN, [$this, 'mouseDownHandler']);
    }

    /**
     * Detaches the event which were attached in [[attachEvents]]
     */
    public function afterHide($event) {
        Tui::$observer->off(Observer::KEY_PRESSED, [$this, 'keypressHandler']);
        Tui::$observer->off(Observer::MOUSE_LEFT_DOWN, [$this, 'mouseDownHandler']);
    }

    /**
     * Handles KeyPressEvents to turn them into clicks.  Adds a little animation
     * to give the user feedback
     * @param KeyPressEvent $event
     * @param KeyPressEvent $event The KeyPressEvent that triggered this method to be called
     */
    public function keypressHandler(KeyPressEvent $event) {
        if ($event->description === "{$this->keyModifier}{$this->shortcutKey}") {
            $this->owner->onMouseDown($event);
            //$this->owner->trigger(Observer::EVENT_MOUSE_LEFT_DOWN, $event);
            time_nanosleep(0, 330000000);
            //$this->owner->trigger(Observer::EVENT_MOUSE_LEFT_UP, $event);
            $this->owner->onMouseUp($event);
            $this->owner->trigger(self::CLICK_EVENT, new ControlEvent());
            $event->handled = true;
        }
    }

    /**
     * When the mouse goes down, we care if it's inside our rect.  So we start
     * listening for the mouse up to see if THAT's inside our rect.  If it is,
     * then it's a click.  I think this can be overridden.
     * @param MouseEvent $event The MouseEvent that triggered this method to be called
     */
    public function mouseDownHandler(MouseEvent $event) {
        /**
         * turn off any errant listeners incase the last mouse up happened
         * offscreen or something
         */
        Tui::$observer->off(Observer::MOUSE_LEFT_UP, [$this, 'mouseUpHandler']);
        $rect = $this->absoluteRectangle;
        if ($rect->pointInMe($event->point)) {
            //$this->onMouseDown($event);
            $this->owner->trigger(Observer::EVENT_MOUSE_LEFT_DOWN, $event);

            /**
             * we only care about mouse ups if we've already registered a mouse down
             */
            Tui::$observer->on(Observer::MOUSE_LEFT_UP, [$this, 'mouseUpHandler']);
            $event->handled = true;
        }
    }

    /**
     * Check if the mouse came inside our rectangle.  If it did, then it's a click.
     * I think this can be overridden.
     * @param MouseEvent $event The MouseEvent that triggered this method to be called
     */
    public function mouseUpHandler(MouseEvent $event) {
        $rect = $this->absoluteRectangle;
        $this->onMouseUp($event);
        if ($rect->pointInMe($event->point)) { //$this->pMouseDown && Boxy::pointInRectangle($event->point, $rect
            $this->owner->trigger(Observer::EVENT_MOUSE_LEFT_UP, $event);
            $this->owner->trigger(self::CLICK_EVENT, new ControlEvent());
            $event->handled = true;
        }
        // detach ourself
        Tui::$observer->off(Observer::MOUSE_LEFT_UP, [$this, 'mouseUpHandler']);
    }

}
