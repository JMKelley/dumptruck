<?php
/**
 * Dump Truck plugin for Craft CMS 3.x
 *
 * Delete Expired Entries plugin for Craft CMS 3.x
 *
 * @link      http://www.vouchertoday.uk/
 * @copyright Copyright (c) 2021 Jonathan Kelley
 */

namespace jmkelley\dumptruck\jobs;

use jmkelley\dumptruck\DumpTruck as DumpTruckPlugin;

use Craft;
use craft\queue\BaseJob;

class Dumpentries extends BaseJob
{
    public function execute($queue)
    {
        $pluginSettings = DumpTruckPlugin::$plugin->getSettings();
        $timeElapsed = $pluginSettings->timeElapsed;
        $channels = $pluginSettings->channels;

        if( $timeElapsed == 1 ) $timeString = "-1 day"; else $timeString = "-{$timeElapsed} days";

        $expiryDate = (new \DateTime($timeString))->format(\DateTime::ATOM);

        $entries = \craft\elements\Entry::find()->sectionId($channels)->expiryDate("<= {$expiryDate}")->status('expired')->all();

        foreach ($entries as $entry) {
            Craft::$app->getElements()->deleteElementById($entry->id, 'craft\elements\Entry');
        }
    }

    protected function defaultDescription(): string
    {
        return Craft::t('dumptruck', 'Delete Expired Entries');
    }
}
