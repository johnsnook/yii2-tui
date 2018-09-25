<?php

/**
 * This file is part of the Yii2 extension module, yii2-tui
 *
 * @author John Snook
 * @date 2018-06-28
 * @license https://github.com/johnsnook/yii2-tui/LICENSE
 * @copyright 2018 John Snook Consulting
 */

namespace johnsnook\tui;

use Yii;
use yii\base\ActionEvent;
use yii\web\Application;
use yii\helpers\Url;
use yii\base\BootstrapInterface;
use yii\base\Module as BaseModule;

/**
 * This is the main module class for the Yii2-ip-tui extension.
 *
 * @author John Snook <jsnook@gmail.com>
 */
class Module extends BaseModule implements BootstrapInterface {

    /**
     * @var string The next release version string
     */
    const VERSION = 'v0.0.5';

    /**
     * Why don't you pull yourself up by the bootstraps like I did by being born
     * middle class and having parents who could help pay for college?
     *
     * If we're running in console mode set the controller space to our commands
     * folder.  If not, attach our main event to the the [[ap beforeAction
     *
     * @param Application $app
     */
    public function bootstrap($app) {
        if ($app->hasModule($this->id) && ($module = $app->getModule($this->id)) instanceof Module) {
            /** this allows me to do some importing from my old security system */
            if ($app instanceof \yii\console\Application) {
                $this->controllerNamespace = 'johnsnook\tui\commands';
            }
        }
    }

}
