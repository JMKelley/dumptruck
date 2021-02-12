<?php
/**
 * Dump Truck plugin for Craft CMS 3.x
 *
 * Delete Expired Entries plugin for Craft CMS 3.x
 *
 * @link      http://www.vouchertoday.uk/
 * @copyright Copyright (c) 2021 Jonathan Kelley
 */

namespace jmkelley\dumptruck;

use jmkelley\dumptruck\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\console\Application as ConsoleApplication;
use craft\web\UrlManager;
use craft\events\RegisterUrlRulesEvent;
use craft\events\RegisterCpNavItemsEvent;
use craft\web\twig\variables\Cp;

use yii\base\Event;

/**
 * @author    Jonathan Kelley
 * @package   DumpTruck
 * @since     1.0.0
 */
class DumpTruck extends Plugin
{
    public static $plugin;
    public $schemaVersion = '1.0.0';
    public $hasCpSettings = true;
    public $hasCpSection = false;

    public function init()
    {
        parent::init();
        self::$plugin = $this;

        if (Craft::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'jmkelley\dumptruck\console\controllers';
        }

        Event::on(
            Cp::class,
            Cp::EVENT_REGISTER_CP_NAV_ITEMS,
            function(RegisterCpNavItemsEvent $event) {
                $event->navItems[] = [
                    'url' => 'settings/plugins/dump-truck',
                    'label' => \Craft::t('app', 'Dump Truck'),
                    'fontIcon' => 'trash',
                    'id' => 'nav-dump-truck'
                ];
            }
        );

    }

    protected function createSettingsModel()
    {
        return new Settings();
    }

    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'dump-truck/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
