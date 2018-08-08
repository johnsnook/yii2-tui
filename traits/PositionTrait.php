<?php

/**
 * @author John Snook
 * @date May 13, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace johnsnook\tui\traits;

use johnsnook\tui\components\Style;
use johnsnook\tui\events\ElementEvent;
use johnsnook\tui\Tui;

/**
 * Traits for mananging upper x coordinates of a rectangle
 */
trait PositionTrait {

    /**
     * @var integer The X coordinate, relative to either screen or a Container
     */
    protected $pX = 1;

    /**
     * @var integer The Y coordinate, relative to either screen or a Container
     */
    protected $pY = 1;

    public function getX() {
        return $this->pX;
    }

    public function setLeft($val) {
        $val = ($val < 1 ? 1 : $val);
        $val = ($val > Tui::$program->width ? Tui::$program->width : $val);
        if ($this->pX !== $val) {
            $old = $this->pX;
            $this->pX = $val;
            $event = new ElementEvent(['what' => 'x', 'new' => $val, 'old' => $old]);
            $this->trigger(ElementEvent::ELEMENT_MOVE_EVENT, $event);
        }
    }

    public function getY() {
        return $this->pY;
    }

    public function setTop($val) {
        $val = ($val < 1 ? 1 : $val);
        $val = ($val > Tui::$program->height ? Tui::$program->height : $val);

        if ($this->pY !== $val) {
            $old = $this->pY;
            $this->pY = $val;
            $event = new ElementEvent(['what' => 'y', 'new' => $val, 'old' => $old]);
            $this->trigger(ElementEvent::ELEMENT_MOVE_EVENT, $event);
        }
    }

    public function move($y, $x) {
        $old = [$this->top, $this->left];
        $this->pY = $y;
        $this->pX = $x;
        $event = new ElementEvent(['what' => 'position', 'new' => [$y, $x], 'old' => $old]);
        $this->trigger(ElementEvent::ELEMENT_MOVE_EVENT, $event);
    }

    /**
     * Calculates and returns an rectangles relative to the y x of the screen
     * @return stdClass [$X, $Y]
     */
    public function getAbsolutePosition() {
        if (($this->style->positioning === False) || $this->style->positioning === Style::ABSOLUTE) {
            return (object) ['x' => $this->left, 'y' => $this->top];
        } elseif ($this->style->positioning === Style::RELATIVE) {
            $element = $this;
            $absolut = (object) ['x' => $this->left, 'y' => $this->top];
            while ($owner = $element->owner) {
                $absolut->top += $owner->top;
                $absolut->left += $owner->left;
                #$absolut->setPosition($owner->top + $absolut->top, $owner->left + $absolut->left);
                if ($owner->style->positioning === Style::ABSOLUTE) {
                    return $absolut;
                }
                $element = $owner;
            }
            return $absolut;
        }
    }

    /**
     * Modifies the rectangle object with adjusted properties.
     * Processed y down, so setting $position = Y | BOTTOM will process
     * BOTTOM last, overriding Y
     *
     * @param integer $position Bitmasked options
     * @param \johnsnook\tui\helpers\Rectangle $owner The rectangle of the object which contains the $element rectangle
     * @param \johnsnook\tui\helpers\Rectangle $element The element whose rectangle attributes we're adjusting
     * @param integer $widthPercent Optional. Use whole numbers, eg 66 for 66%
     * @param integer $heightPercent Optional. Use whole numbers, eg 66 for 66%
     * @return \johnsnook\tui\helpers\Rectangle
     */
    public function applyStyle(Style $style, Rectangle $container = null) {
        if (empty($container)) {
            $container = Screen::getScreenRect();
        }
        $old = clone $this;
        if (gettype($style->width) === 'integer') {
            $this->pWidth = $style->width;
        } elseif (strpos($style->width, '%')) {
            $this->pWidth = floor($container->width * ($style->width / 100));
        }
        if (gettype($style->height) === 'integer') {
            $this->height = $style->height;
        } elseif (strpos($style->height, '%')) {
            $this->pHeight = floor($container->height * ($style->height / 100));
        }

        if ($style->positioning === Style::Y) {
            $this->pY = $container->top;
        } elseif ($style->positioning === Style::BOTTOM) {
            $this->pY = $container->top + $container->height - $this->pHeight;
        } elseif ($style->positioning === Style::X) {
            $this->pX = $container->left;
        } elseif ($style->positioning === Style::RIGHT) {
            $this->pX = $container->left + $container->width - $container->pWidth;
        }

        if ($style->align & Style::VERTICAL) {
            $this->pY = $container->top + floor(($container->height / 2) - ($this->pHeight / 2));
        }
        if ($style->align & Style::HORIZONTAL) {
            $this->pX = $container->left + floor(($container->width / 2) - ($this->pWidth / 2));
        }

        $event = new RectangleEvent(['what' => 'rectangle', 'new' => $this, 'old' => $old]);
        $this->trigger(RectangleEvent::EVENT_RECTANGLE_CHANGED, $event);
    }

}
