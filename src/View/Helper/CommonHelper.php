<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\StringTemplateTrait;

class CommonHelper extends Helper
{
	function get_url($url){
        return $url;
    }

    function humanTiming ($time)
	{
		$time = time() - $time; // to get the time since that moment
		$tokens = array (
			31536000 => 'year',
			2592000 => 'month',
			604800 => 'week',
			86400 => 'day',
			3600 => 'hour',
			60 => 'minute',
			1 => 'second'
		);
	
		foreach ($tokens as $unit => $text) {
			if ($time < $unit) continue;
			$numberOfUnits = floor($time / $unit);
			return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
		}
	
	}

	// function to get file preview url based on file type
	function getPreviewUrl($file_type)
	{
            echo $file_type;
	}
}

?>
