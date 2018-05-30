<?php

use johnsnook\tui\components\Observer;
use johnsnook\tui\components\Style;
use johnsnook\tui\elements\Button;
use johnsnook\tui\elements\Program;
use johnsnook\tui\elements\StatusBar;
use johnsnook\tui\elements\window\Window;
use johnsnook\tui\events\KeyPressEvent;
use johnsnook\tui\events\MouseEvent;
use johnsnook\tui\helpers\Keys;
use johnsnook\tui\helpers\Format;
use johnsnook\tui\Tui;

/**
 * @author John Snook
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 *
 * Sample Tui Application
 */
return new Program([
    'id' => 'demo',
    'css' => [
        'bgColor' => Format::xtermBgColor(84),
        'fgColor' => Format::xtermFgColor(21),
        'bgPattern' => ' ░▒▓▒░'
    #'bgPattern' => '`'
    ],
    'observerConfig' => [
        'on *' => function($event) {
            $sb = Tui::$program->statusBar;
            if (is_a($event, KeyPressEvent::className())) {
                $sb->changeText($event->description);
            } elseif (is_a($event, MouseEvent::className())) {
                $sb->changeText($event->name . " X: {$event->point->left} Y: {$event->point->top}");
            } else {
                $sb->changeText($event->name);
            }
        }
    ],
    'on ready' => function($event) {
        $event->sender->testWindow->open();
    },
//    'observer' => new Observer(),
    'exitKey' => Keys::CTRL_Q,
    'elements' => [
        'menuBar' => require __DIR__ . '/_fileMenu.php',
        'statusBar' => [
            'class' => StatusBar::className(),
            'text' => 'Demo running!',
            'css' => ['bgColor' => Format::xtermBgColor(248), 'fgColor' => Format::FG_BLACK],
        ],
        'testWindow' => [
            'class' => Window::className(),
            'title' => 'Test Window',
            'css' => [
                'bgColor' => Format::xtermBgColor(248),
                'align' => Style::VERTICAL + Style::HORIZONTAL,
                'width' => '50%',
                'height' => '50%',
                'borderWidth' => Style::SINGLE,
            ],
            'elements' => [
                'btnClose' => [
                    'class' => Button::className(),
                    'label' => '_Close',
                    'on click' => function($event) {
                        $event->sender->owner->close();
                    },
                    'css' => [
                        'bgColor' => Format::xtermBgColor(248),
                        'fgColor' => Format::FG_BLACK,
                        //'decoration' => Format::BOLD,
                        'width' => 12,
                        'height' => 3,
                        'marginBottom' => 2,
                        'align' => Style::HORIZONTAL,
                        'pull' => Style::BOTTOM,
                    ]
                ]
            ]
        ]
    ]]
);


