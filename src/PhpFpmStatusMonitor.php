<?php
namespace noahjahn\phpfpmstatusmonitor;

use Craft;
use craft\base\Plugin;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Dashboard;
use yii\base\Event;
use noahjahn\phpfpmstatusmonitor\widgets\PhpFpmStatusMonitor as PhpFpmStatusMonitorWidget;
use noahjahn\phpfpmstatusmonitor\models\Settings;


class PhpFpmStatusMonitor extends Plugin
{
    public $packageName = 'PHP FPM Status Monitor';

    public $hasCpSettings = true;

    public function init()
    {
        parent::init();

        $this->registerPhpFpmStatusMonitorWidget();
    }

    private function registerPhpFpmStatusMonitorWidget () {
        Event::on(
            Dashboard::class,
            Dashboard::EVENT_REGISTER_WIDGET_TYPES,
            function(RegisterComponentTypesEvent $event) {
                $event->types[] = PhpFpmStatusMonitorWidget::class;
            },
        );
    }

    protected function createSettingsModel()
    {
        return new Settings();
    }

    protected function settingsHtml()
    {
        return Craft::$app->getView()->renderTemplate(
            'php-fpm-status-monitor/settings',
            [ 'settings' => $this->getSettings() ]
        );
    }
}
