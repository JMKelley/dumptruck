<?php
/**
 * Dump Truck plugin for Craft CMS 3.x
 *
 * This plugin automatically deletes entries when a set time has elapsed from a date/time field.
 *
 * @link      http://www.vouchertoday.uk/
 * @copyright Copyright (c) 2020 Jonathan Kelley
 */

namespace jmkelley\dumptruck\services;

use jmkelley\dumptruck\DeleteEntries;

use Craft;
use craft\base\Component;

/**
 * DeleteEntries Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Jonathan Kelley
 * @package   DeleteEntries
 * @since     1.0.0
 */
class DeleteEntries extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     DeleteEntries::$plugin->deleteEntries->exampleService()
     *
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';
        // Check our Plugin's settings for `someAttribute`
        if (DeleteEntries::$plugin->getSettings()->someAttribute) {
        }

        return $result;
    }
}
