<?php
/**
 * Delete Entries plugin for Craft CMS 3.x
 *
 * This plugin automatically deletes entries when a set time has elapsed from a date/time field.
 *
 * @link      http://www.vouchertoday.uk/
 * @copyright Copyright (c) 2020 Jonathan Kelley
 */

namespace jonathan\deleteentries\console\controllers;

use jonathan\deleteentries\DeleteEntries as DeleteEntriesPlugin;

use Craft;
use yii\console\Controller;
use yii\helpers\Console;
use jonathan\deleteentries\jobs\DeleteEntries as DeleteEntriesJob;

/**
 * @author    Jonathan Kelley
 * @package   DeleteEntries
 * @since     1.0.0
 */
class DeleteEntriesController extends Controller
{
    public function actionIndex()
    {
        $result = '';

        $pluginSettings = DeleteEntriesPlugin::$plugin->getSettings();
        $timeElapsed = $pluginSettings->timeElapsed;
        $channels = $pluginSettings->channels;

        if( $timeElapsed == 1 ) $timeString = "-1 day"; else $timeString = "-{$timeElapsed} days";

        $expiryDate = (new \DateTime($timeString))->format(\DateTime::ATOM);

        $entriesCount = \craft\elements\Entry::find()->sectionId($channels)->expiryDate("<= {$expiryDate}")->status('expired')->count();

        if( $entriesCount )
        {
            $queue = Craft::$app->getQueue();
            $jobId = $queue->push(new DeleteEntriesJob([
                'description' => Craft::t('delete-entries', 'Deleting expired entries expired before ' . $timeElapsed . ' day(s).')
            ]));
        }

        return $result;
    }
}
