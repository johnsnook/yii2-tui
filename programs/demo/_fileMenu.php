<?php

/**
 * @author John Snook
 * @date May 5, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */
use johnsnook\tui\elements\Button;
use johnsnook\tui\elements\menu\Menu;
use johnsnook\tui\elements\menu\MenuBar;
use johnsnook\tui\elements\menu\MenuBarItem;
use johnsnook\tui\elements\menu\Separator;
use johnsnook\tui\Tui;
use johnsnook\tui\helpers\Format;

/**
 * Description of _fileMenu
 */
return [
    'class' => MenuBar::className(),
    'css' => [
        'bgColor' => Format::xtermBgColor(248),
    ],
    'elements' => [
        'fileMenuItem' => [
            'class' => MenuBarItem::className(),
            'label' => '_File',
            'menu' => [
                'class' => Menu::className(),
                'elements' => [
                    'newFile' => [
                        'class' => Button::className(),
                        'label' => '_New',
                        'on click' => function ($data) {
                            Tui::$program->statusBar->text = "New File";
                        }
                    ],
                    'openFile' => [
                        'class' => Button::className(),
                        'label' => '_Open',
                        'on click' => function ($data) {
                            Tui::$program->testWindow->open();
                        }
                    ],
                    'sep' => ['class' => Separator::className()],
                    'quit' => [
                        'class' => Button::className(),
                        'label' => '_Quit',
                        'on click' => function () {
                            Tui::$program->end();
                        }
                    ]
                ]]
        ]
    ]
];
