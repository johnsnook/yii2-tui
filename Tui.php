<?php

/**
 * @author John Snook
 * @date May 8, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace johnsnook\tui;

/**
 * Static class to provide services to all objects in the Tui app.
 */
class Tui {

    /**
     * @var components\Program Allows global access to the program.
     */
    public static $program;

    /**
     * @var components\Observer Singleton which handles user events, like
     * key presses, mouse, terminal resize
     */
    public static $observer;

    /**
     * @todo allow multiple style sheets for theming etc
     * @var array
     */
    public static $styleSheet;

    /**
     *
     * @param string $selector We need this to get it's class name and grab that from the stylesheet
     * @return array Style
     */
    public static function getStyle($selector = '*') {
        if (array_key_exists($selector, static::$styleSheet)) {
            return static::$styleSheet[$selector];
        }
        return false;
    }

    public static function addStyleShee($filename) {
        if (is_file($filename)) {
            array_merge(self::$styleSheet, include $filename);
        }
    }

    /**
     * Configures an object with the initial property values.
     * @param object $object the object to be configured
     * @param array $properties the property initial values given in terms of name-value pairs.
     * @return object the object itself
     */
    public static function configure($object, $properties) {
        foreach ($properties as $name => $value) {
            $object->$name = $value;
        }

        return $object;
    }

}
