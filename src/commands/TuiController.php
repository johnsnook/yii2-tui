<?php

namespace johnsnook\tui\commands;

use johnsnook\tui\helpers\Format;
use \johnsnook\tui\Tui;
use johnsnook\tui\components\Observer;

/**
 * @Author John Snook
 * @date Apr 29, 2018
 * @License https://snooky.biz/site/license
 * @Copyright 2018 John Snook Consulting
 */
class TuiController extends \yii\console\Controller {

    /**
     * Declare the alias, and set up the static Tui object
     */
    public function init() {
        parent::init();
        \Yii::setAlias('@tui', __DIR__ . '/..');
        Tui::$observer = Observer::getInstance();
        Tui::$styleSheet = require \Yii::getAlias('@tui/css.php');
    }

    /**
     * The TuiController allow running and testing of tui programs
     */
    public function actionIndex() {

    }

    /**
     *
     * @param array $config
     * @return integer The exit code
     */
    public function actionRun($config) {
        Tui::$program = $config;
        $exitCode = Tui::$program->run();
        return($exitCode);
    }

    /**
     * Run the demo program
     *
     * @return integer The exit code
     */
    public function actionDemo() {
        Tui::$program = require \Yii::getAlias('@tui/programs/demo/main.php');
        $exitCode = Tui::$program->run();
        return($exitCode);
    }

//
//    public function actionTest() {
//        $esc = "\033";
//        echo "{$esc} P p p[384,240] c[+100,+50] {$esc}\\";
//    }
//
//    public function actionColors() {
//        for ($i = 0; $i < 15; $i++) {
//            echo Format::ansi($i, [Format::xtermFgColor($i)]) . ' ';
//        }
//        echo PHP_EOL;
//        for ($i = 0; $i < 15; $i++) {
//            echo Format::ansi($i, [Format::NEGATIVE, Format::xtermFgColor($i)]) . ' ';
//        }
//        echo PHP_EOL;
//        for ($i = 0; $i < 15; $i++) {
//            echo Format::ansi($i, [Format::ITALIC, Format::xtermFgColor($i)]) . ' ';
//        }
//        echo PHP_EOL;
//        for ($i = 0; $i < 15; $i++) {
//            echo Format::ansi($i, [Format::CONCEALED, Format::xtermFgColor($i)]) . ' ';
//        }
//        echo PHP_EOL;
//        for ($i = 0; $i < 15; $i++) {
//            echo Format::ansi($i, [Format::FRAMED, Format::xtermFgColor($i)]) . ' ';
//        }
//        echo PHP_EOL;
//
////        for ($i = 0; $i < 15; $i++) {
////            echo Format::ansi($i, [Format::xtermBgColor($i)]) . ' ';
////        }
////        echo PHP_EOL;
////        for ($i = 0; $i < 15; $i++) {
////            echo Format::ansi($i, [Format::BOLD, Format::xtermBgColor($i)]) . ' ';
////        }
////        echo PHP_EOL;
//
//        for ($i = 16; $i < 256; $i++) {
//            echo Format::ansi(str_pad($i, 3), [Format::xtermFgColor($i)]) . ' ';
//            if ((($i + 3) % 6) === 0)
//                echo PHP_EOL;
//        }
//        echo PHP_EOL;
//        for ($i = 16; $i < 256; $i++) {
//            echo Format::ansi(str_pad($i, 3), [Format::xtermBgColor($i)]) . ' ';
//            if ((($i + 3) % 6) === 0)
//                echo PHP_EOL;
//        }
//        echo PHP_EOL;
//
//        //Tui::$observer->mainLoop();
//    }
//
//    public function actionColors2() {
//        $esc = "\033]";
//        for ($i = 0; $i < hexdec("FFFFFFF"); $i++) {
//            $hexStr = str_pad(dechex($i), 7, '0', STR_PAD_LEFT);
//            $arr = str_split($hexStr);
//            echo '/' . dechex($i) . "/ [C:{$arr[0]}, R:{$arr[1]}{$arr[2]}, G:{$arr[3]}{$arr[4]}, B:{$arr[5]}{$arr[6]}]";
//            echo "{$esc}P{$hexStr}";
//            echo $hexStr;
//            echo "{$esc}R\n";
//        }
//        echo PHP_EOL;
//
//        //Tui::$observer->mainLoop();
//    }
}
