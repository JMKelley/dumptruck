<?php
/**
 * Dump Truck plugin for Craft CMS 3.x
 *
 * This plugin automatically deletes entries when a set time has elapsed from a date/time field.
 *
 * @link      http://www.vouchertoday.uk/
 * @copyright Copyright (c) 2020 Jonathan Kelley
 */

namespace jmkelley\dumptruck\jobs;

use jmkelley\dumptruck\DeleteEntries as DeleteEntriesPlugin;

use Craft;
use craft\queue\BaseJob;

/**
 * DeleteEntries job
 *
 *
 * @author    Jonathan Kelley
 * @package   DeleteEntries
 * @since     1.0.0
 */
class DeleteEntries extends BaseJob
{

    public function execute($queue)
    {
        $pluginSettings = DeleteEntriesPlugin::$plugin->getSettings();
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
        return Craft::t('delete-entries', 'DeleteEntries');
    }

}
