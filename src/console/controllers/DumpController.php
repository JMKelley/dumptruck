<?php
/**
 * @link      http://www.vouchertoday.uk/
 * @copyright Copyright (c) 2021 Jonathan Kelley
 */

namespace jmkelley\dumptruck\console\controllers;

use jmkelley\dumptruck\DumpTruck as DumpTruckPlugin;

use Craft;
use yii\console\Controller;
use yii\helpers\Console;

use jmkelley\dumptruck\jobs\Dumpentries as DumpentriesJob;

class DumpController extends Controller
{
    // php craft dump-truck/dump/entries
    public function actionEntries()
    {
        $result = '';

        $pluginSettings = DumpTruckPlugin::$plugin->getSettings();
        $timeElapsed = $pluginSettings->timeElapsed;
        $channels = $pluginSettings->channels;

        if( $timeElapsed == 1 ) $timeString = "-1 day"; else $timeString = "-{$timeElapsed} days";

        $expiryDate = (new \DateTime($timeString))->format(\DateTime::ATOM);

        $entriesCount = \craft\elements\Entry::find()->sectionId($channels)->expiryDate("<= {$expiryDate}")->status('expired')->count();

        if( $entriesCount )
        {
            $queue = Craft::$app->getQueue();
            $jobId = $queue->push(new DumpentriesJob([
                'description' => Craft::t('dump-truck', 'Deleting expired entries expired before ' . $timeElapsed . ' day(s).')
            ]));
        }

        return $result;
    }
}
