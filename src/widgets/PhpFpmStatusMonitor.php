<?php

namespace noahjahn\phpfpmstatusmonitor\widgets;

use Exception;
use Craft;
use craft\base\Widget;
use noahjahn\phpfpmstatusmonitor\services\PhpFpm;

class PhpFpmStatusMonitor extends Widget
{

    public static function displayName(): string
    {
        return Craft::t('app', 'PHP FPM Status Monitor');
    }

    public static function isSelectable(): bool
    {
        return (parent::isSelectable() && Craft::$app->getUser()->getIsAdmin());
    }

    protected static function allowMultipleInstances(): bool
    {
        return false;
    }

    public static function icon()
    {
        return Craft::getAlias('@appicons/settings.svg');
    }

    public function getTitle(): string
    {
        return 'FPM Status';
    }

    public function getBodyHtml()
    {
        if (!Craft::$app->getUser()->getIsAdmin()) {
            return false;
        }

        try {
            $phpFpm = new PhpFpm();
            return Craft::$app->getView()->renderTemplate('php-fpm-status-monitor/_components/widgets/PhpFpmStatusMonitor/body', [
                'fpmStatus' => $phpFpm->getStatus(),
            ]);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            Craft::error($errorMessage);
            return Craft::$app->getView()->renderTemplate('php-fpm-status-monitor/_components/widgets/PhpFpmStatusMonitor/_error', [
                'error' => $errorMessage,
            ]);
        }
    }
}
