<?php
/**
 * @name        DevBehavior
 * @package		BiberLtd\ExceptionBundle
 *
 * @author		Can Berkol
 * @version     1.0.0
 * @date        05.07.2013
 *
 * @copyright   Biber Ltd. (http://www.biberltd.com)
 * @license     GPL v3.0
 *
 * @description Exception behavior for production environment.
 *
 */
namespace BiberLtd\Bundle\ExceptionBundle\Behaviors;


use BiberLtd\Bundle\ExceptionBundle\Behaviors\BehaviorInterface;
use BiberLtd\Bundle\ExceptionBundle\Services\ExceptionAdapter;

class DevBehavior implements BehaviorInterface\BehaviorInterface{
    /**
     * @name 			notify()
     *  				Outputs everything immediately to screen.
     *
     * @since			1.0.0
     * @version         1.0.0
     * @author          Can Berkol
     *
     * @param 			ExceptionAdapter $service
     *
     * @throws          Exception
     *
     * @return          true
     */
    public function notify(ExceptionAdapter $service){
        throw $service->getException();

        return true;
    }
}
/**
 * Change Log:
 * **************************************
 * v1.0.0                      Can Berkol
 * 05.07.2013
 * **************************************
 * A notify()
 */