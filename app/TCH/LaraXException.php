<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 10/16/2016
 * Time: 9:42 PM
 */

namespace TCH;

/**
 * Class LaraXException
 *
 * @package TCH
 */
class LaraXException extends \Exception {
    public function __construct($message = "", $code = 0, Exception $previous = NULL) {
        parent::__construct($message, $code, $previous);
    }

}