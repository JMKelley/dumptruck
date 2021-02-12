<?php
/**
 * Dump Truck plugin for Craft CMS 3.x
 *
 * Delete Expired Entries plugin for Craft CMS 3.x
 *
 * @link      http://www.vouchertoday.uk/
 * @copyright Copyright (c) 2021 Jonathan Kelley
 */

namespace jmkelley\dumptruck\controllers;

use jmkelley\dumptruck\DumpTruck;

use Craft;
use craft\web\Controller;
use craft\base\Component;

use jmkelley\dumptruck\jobs\Dumpentries as DumpentriesJob;

/**
 * @author    Jonathan Kelley
 * @package   DumpTruck
 * @since     1.0.0
 */
class DumpController extends Controller
{
    protected $allowAnonymous = ['index'];

    // actions/dump-truck/dump
    public function actionIndex()
    {
        $this->requireAdmin();

        $pluginSettings = DumpTruck::$plugin->getSettings();
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
        }else{
            Craft::$app->session->getFlash('notice', 'There is no entries to delete.', true);
        }

        $return = 'settings/plugins/dump-truck';

        return $this->redirect($return);
    }
}
