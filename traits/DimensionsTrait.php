<?php

/**
 * @author John Snook
 * @date May 13, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 * Description of DimensionsTrait
 */

namespace johnsnook\tui\traits;

use johnsnook\tui\events\ElementEvent;
use johnsnook\tui\Tui;

trait DimensionsTrait {

    /**
     * @var integer
     */
    protected $pHeight = 10;

    /**
     * @var integer
     */
    protected $pWidth = 10;

    public function getHeight() {
        return $this->pHeight;
    }

    public function setHeight($val) {
        if ($this->pHeight != $val) {
            $val = ($val < 1 ? 1 : $val);
            $val = ($val > Tui::$observer->height ? Tui::$observer->height : $val);

            $old = $this->pHeight;
            $this->pHeight = $val;
            $event = new ElementEvent(['what' => 'height', 'new' => $val, 'old' => $old]);
            $this->trigger(ElementEvent::ELEMENT_RESIZE_EVENT, $event);
        }
    }

    public function getWidth() {
        return $this->pWidth;
    }

    public function setWidth($val) {
        if ($this->pWidth != $val) {
            $val = ($val < 1 ? 1 : $val);
            $val = ($val > Tui::$observer->width ? Tui::$observer->width : $val);

            $old = $this->pWidth;
            $this->pWidth = $val;
            $event = new ElementEvent(['what' => 'width', 'new' => $val, 'old' => $old]);
            $this->trigger(ElementEvent::ELEMENT_RESIZE_EVENT, $event);
        }
    }

    public function resize($height, $width) {
        $old = [$this->pHeight, $this->pWidth];
        $this->pHeight = $height;
        $this->pWidth = $width;
        $event = new ElementEvent(['what' => 'dimensions', 'new' => [$height, $width], 'old' => $old]);
        $this->trigger(ElementEvent::ELEMENT_RESIZE_EVENT, $event);
    }

//    public function getInnerWidth() {
//        return $this->width - (isset($this->border) ? 2 : 0);
//    }
//
//    public function getInnerHeight() {
//        return $this->height - (isset($this->border) ? 2 : 0);
//    }
//
}
