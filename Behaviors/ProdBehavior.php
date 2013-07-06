<?php
/**
 * @name        ProdBehavior
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
namespace BiberLtd\Bundles\ExceptionBundle\Behaviors;


use BiberLtd\Bundles\ExceptionBundle\Behaviors\BehaviorInterface;
use BiberLtd\Bundles\ExceptionBundle\Services\ExceptionAdapter;

class ProdBehavior implements BehaviorInterface\BehaviorInterface{
    /**
     * @name 			notify()
     *  				Sends e-mail notification to admin.
     *
     * @since			1.0.0
     * @version         1.0.0
     * @author          Can Berkol
     *
     * @param 			ExceptionAdapter        $service
     *
     * @return          bool
     */
    public function notify(ExceptionAdapter $service){
        /**
         * send email only if this error is different from the previous.
         */
        if(!is_null($service->getException()->getPrevious()) && $service->getException()->getPrevious()->getCode() != $service->getException()->getCode()){
            $trace = $service->getException()->getTraceAsString();
            $exception_content =
                 '=========================================================='.PHP_EOL
                .'ERROR #'.$service->getException()->getCode().PHP_EOL
                .'=========================================================='.PHP_EOL
                .'LINE :: '.$service->getException()->getLine().PHP_EOL
                .'FILE :: '.$service->getException()->getFile().PHP_EOL.PHP_EOL
                .'MESSAGE :: '.PHP_EOL.$service->getException()->getMessage().PHP_EOL.PHP_EOL
                .'=========================================================='.PHP_EOL
                .'TRACE:'.PHP_EOL.PHP_EOL
                .$trace.PHP_EOL.PHP_EOL
                .'=========================================================='.PHP_EOL
                .'CLIENT / BROWSER INFO'.PHP_EOL
                .'=========================================================='.PHP_EOL
                .'URL :: '.$_SERVER['SCRIPT_URI'].PHP_EOL
                .'CLIENT IP :: '.$_SERVER['REMOTE_ADDR'].PHP_EOL
                .'COOKIE :: '.$_SERVER['HTTP_COOKIE'].PHP_EOL
                .'AGENT :: '.PHP_EOL.$_SERVER['HTTP_USER_AGENT'].PHP_EOL.PHP_EOL;

            $subject = 'Exception :: '.$service->getException()->getCode().' :: '.$service->getDate()->format('Y-m-d h:i:s');
            $headers = 'From: '.$service->getEmailFrom()."\r\n".
                'Reply-To: '.$service->getEmailTo()."\r\n".
                'Content-Type: text/plain; charset=utf-8'."\r\n".
                'X-Mailer: PHP/'.phpversion();

            mail($service->getEmailTo(), $subject, $exception_content, $headers);
            return true;
        }
        return false;
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