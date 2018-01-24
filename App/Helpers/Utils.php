<?php
/**
 * Utils.php
 */

namespace App\Helpers;

/**
 * Class Utils
 * @author Nicolás Marulanda P.
 */
class Utils {
    
    public function dateNow($format = 'Y-m-d') {
        return date($format, time());
    }
    
    public function stringToDate($time, $format, $toFormat = 'Y-m-d') {
        return \DateTime::createFromFormat($format, $time)
                        ->format($toFormat);
    }
}
