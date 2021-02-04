<?php
/**
 * Dump Truck plugin for Craft CMS 3.x
 *
 * This plugin automatically deletes entries when a set time has elapsed from a date/time field.
 *
 * @link      http://www.vouchertoday.uk/
 * @copyright Copyright (c) 2020 Jonathan Kelley
 */

namespace jmkelley\dumptruck\models;

use jmkelley\dumptruck\DeleteEntries;

use Craft;
use craft\base\Model;
use craft\validators\ArrayValidator;

/**
 * DeleteEntries Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Jonathan Kelley
 * @package   DeleteEntries
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some field model attribute
     *
     * @var string
     */
    public $timeElapsed = '1';
    public $channels = [];

    // Public Methods
    // =========================================================================


    // public function getTimeElapsed(): int
    // {
    //     return Craft::parseEnv($this->timeElapsed);
    // }

    // public function getChannels(): array
    // {
    //     return [];
    // }    

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */

    public function rules(): array
    {
        return [
            ['timeElapsed', 'string'],
            ['channels', ArrayValidator::class],
        ];
    }
}
