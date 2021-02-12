<?php
/**
 * @link      http://www.vouchertoday.uk/
 * @copyright Copyright (c) 2021 Jonathan Kelley
 */

namespace jmkelley\dumptruck\models;

use jmkelley\dumptruck\DumpTruck;

use Craft;
use craft\base\Model;
use craft\validators\ArrayValidator;

/**
 * DumpTruck Settings Model
 *
 * @author    Jonathan Kelley
 * @package   DumpTruck
 * @since     1.0.0
 */
class Settings extends Model
{
    public $timeElapsed = '1';
    public $channels = [];
    
    public function rules(): array
    {
        return [
            ['timeElapsed', 'string'],
            ['channels', ArrayValidator::class],
        ];
    }
}
