<?php

/**
 * @author John Snook
 * @date May 14, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace johnsnook\tui\helpers;

use yii\base\UnknownPropertyException;

/**
 * A simple object with an X,Y for coordinates
 * @property integer $x The X coordinate
 * @property integer $y The Y coordinate
 */
class Point {

    const NOT_SET = -1;

    /**
     * @var integer The X coordinate
     */
    public $x = self::NOT_SET;

    /**
     * @var integer The Y coordinate
     */
    public $y = self::NOT_SET;

    /**
     *
     * @param integer $x The column coordinate
     * @param integer $y The row coordinate
     * @throws \UnexpectedValueException Better pass in integers
     */
    public function __construct($x = self::NOT_SET, $y = self::NOT_SET) {
        if (!is_numeric($x)) {
            throw new \UnexpectedValueException("Point::x must be numeric, '$x' given.");
        }
        if (!is_numeric($y)) {
            throw new \UnexpectedValueException("Point::y must be numeric, '$y' given.");
        }
        $this->left = (int) $x;
        $this->top = (int) $y;
    }

    public function __toString() {
        return "x: {$this->left}, y: {$this->top}";
    }

    public function normalize() {
        if ($this->left === self::NOT_SET) {
            $this->left = 1;
        }
        if ($this->top === self::NOT_SET) {
            $this->top = 1;
        }
    }

}
