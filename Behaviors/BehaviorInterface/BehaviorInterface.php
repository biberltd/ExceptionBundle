<?php
/**
 * @name        BehaviorInterface
 * @package		BiberLtd\ExceptionBundle
 *
 * @author		Can Berkol
 * @version     1.0.0
 * @date        05.07.2013
 *
 * @copyright   Biber Ltd. (http://www.biberltd.com)
 * @license     GPL v3.0
 *
 * @description The inteface of exception behavior handler.
 *
 */
namespace BiberLtd\Bundles\ExceptionBundle\Behaviors\BehaviorInterface;

use BiberLtd\Bundles\ExceptionBundle\Services\ExceptionAdapter;

interface BehaviorInterface {
   public function notify(ExceptionAdapter $service);
}
/**
 * Change Log:
 * **************************************
 * v1.0.0                      Can Berkol
 * 05.07.2013
 * **************************************
 * A notify()
 */