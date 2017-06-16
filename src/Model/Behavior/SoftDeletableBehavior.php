<?php
/**
 * Created by PhpStorm.
 * User: rsi
 * Date: 12-Nov-15
 * Time: 10:51 PM
 */

namespace App\Model\Behavior;

use Cake\ORM\Behavior;

class SoftDeletableBehavior extends Behavior
{
    function setup(&$Model, $settings = array()) {
        // do any setup here
    }

    // override the delete function (behavior methods that override model methods take precedence)
    function delete(&$Model, $id = null) {
        $Model->id = $id;
        log("yooooooooooooooooo");
        log($Model);
        // save the deleted field with current date-time
        if ($Model->saveField('status', STATUS_NOT_ACTIVE)) {
            return true;
        }

        return false;
    }

    function beforeFind(&$Model, $query) {
        // only include records that have null deleted columns
        $query->where([$this->_table->registryAlias().".status" => STATUS_ACTIVE]);
        return $query;
    }
}