<?php
/**
 * Dump Truck plugin for Craft CMS 3.x
 *
 * This plugin automatically deletes entries when a set time has elapsed from a date/time field.
 *
 * @link      http://www.vouchertoday.uk/
 * @copyright Copyright (c) 2020 Jonathan Kelley
 */

namespace jmkelley\dumptruck\controllers;

use jmkelley\dumptruck\DeleteEntries;

use Craft;
use craft\web\Controller;
use craft\base\Component;
use jmkelley\dumptruck\jobs\DeleteEntries as DeleteEntriesJob;

/**
 * @author    Jonathan Kelley
 * @package   DeleteEntries
 * @since     1.0.0
 */
class DeleteEntriesController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index'];

    // Public Methods
    // =========================================================================

    /**
     * Handle a request going to our plugin's index action URL,
     * e.g.: actions/delete-entries/delete-entries
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $result = 'Entries Deleted!!!';

        // Only admin can perform this action
        $this->requireAdmin();

        $pluginSettings = DeleteEntries::$plugin->getSettings();
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
        }else{
            Craft::$app->session->getFlash('notice', 'There is no entries to delete.', true);
        }

        // foreach ($entries as $entry) {
        //     Craft::$app->getElements()->deleteElementById($entry->id, 'craft\elements\Entry');
        // }

        $return = 'settings/plugins/delete-entries';

        return $this->redirect($return);
    }
}
