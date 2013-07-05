<?php
/**
 * @name        ExceptionAdapter
 * @package		BiberLtd\ExceptionBundle
 *
 * @author		Can Berkol
 * @version     1.1.0
 * @date        05.07.2013
 *
 * @copyright   Biber Ltd. (http://www.biberltd.com)
 * @license     GPL v3.0
 *
 * @description Main exception adapter.
 *
 */
namespace BiberLtd\Bundles\ExceptionBundle\Services;

class ExceptionAdapter extends \Exception {
    protected $date;
    protected $email_from = 'support@biberltd.com';
    protected $email_to = 'support@biberltd.com';
    protected $env = 'dev';
    private $behaviors;

    private $exception;

    public function __construct($kernel, $message = '', $code = 0, Exception $previous = null) {
        /** Register adapters */
        $this->register_behaviors();
        if($kernel->getContainer()->hasParameter('biber_ltd_bundles_exception.email.from')){
            $this->email_from = $kernel->getContainer()->getParameter('biber_ltd_bundles_exception.email.from');
        }
        if($kernel->getContainer()->hasParameter('biber_ltd_bundles_exception.email.to')){
            $this->email_to = $kernel->getContainer()->getParameter('biber_ltd_bundles_exception.email.to');
        }
        /** Get environment*/
        $this->env = $kernel->getEnvironment();
        $this->exception = new \Exception($message, $code, $previous);
        $this->date = new \DateTime('now');
    }
    public function __destruct(){
        $fatal = false;
        if(isset($this->behaviors[$this->env.'behavior'])){
            $behavior = $this->behaviors[$this->env.'behavior'];
            /** System error */
            if(!$behavior->notify($this) && $this->env == 'dev'){
               throw $this->exception;
            }
            else if(!$behavior->notify($this) && $this->env != 'dev'){
                $fatal = true;
            }
        }
        else{
            $fatal = true;
        }
        if($fatal){
            echo 'FATAL ERROR :: ExceptionBundle :: Please contact your developer immediately.';
            exit;
        }
    }
    /**
     * @name 			register_behaviors()
     *  				Registers all available currencies.
     *
     * @since			1.1.0
     * @version         1.1.0
     * @author          Can Berkol
     *
     * @return          object      $this
     *
     */
    private function register_behaviors(){
        $files = glob(__DIR__.'\\..\\Behaviors\\*Behavior.php');
        foreach($files as $file){
            $behavior_class = str_replace('.php', '', $file);
            $behavior_name = $behavior_class = str_replace(__DIR__.'\\..\\Behaviors\\', '', $behavior_class);
            $behavior_class = '\\BiberLtd\\Bundles\\ExceptionBundle\\Behaviors\\'.$behavior_name;
            $behavior = new $behavior_class();

            $this->behaviors[strtolower($behavior_name)] = $behavior;
        }

        return $this;
    }
    /**
     * @name 			getBehaviors()
     *  				Returns registered behaviors.
     *
     * @since			1.1.0
     * @version         1.1.0
     * @author          Can Berkol
     *
     * @return          array       $this->behaviors
     *
     */
    public function getBehaviors(){
        return $this->behaviors;
    }
    /**
     * @name 			getDate()
     *  				Returns date.
     *
     * @since			1.1.0
     * @version         1.1.0
     * @author          Can Berkol
     *
     * @return          array       $this->date
     *
     */
    public function getDate(){
        return $this->date;
    }
    /**
     * @name 			getEmailFrom()
     *  				Returns email from property.
     *
     * @since			1.1.0
     * @version         1.1.0
     * @author          Can Berkol
     *
     * @return          array       $this->email_from
     *
     */
    public function getEmailFrom(){
        return $this->email_from;
    }
    /**
     * @name 			getEmailTo()
     *  				Returns email to property.
     *
     * @since			1.1.0
     * @version         1.1.0
     * @author          Can Berkol
     *
     * @return          array       $this->email_to
     *
     */
    public function getEmailTo(){
        return $this->email_to;
    }
    /**
     * @name 			getEnv()
     *  				Returns env to property.
     *
     * @since			1.1.0
     * @version         1.1.0
     * @author          Can Berkol
     *
     * @return          array       $this->env
     *
     */
    public function getEnv(){
        return $this->env;
    }
    /**
     * @name 			getEnvironment()
     *  				Returns env to property. Alias to getEnv()
     *
     * @since			1.1.0
     * @version         1.1.0
     * @author          Can Berkol
     *
     * @return          array       $this->env
     *
     */
    public function getEnvironment(){
        return $this->getEnv();
    }
    /**
     * @name 			getException()
     *  				Returns exception to property.
     *
     * @since			1.1.0
     * @version         1.1.0
     * @author          Can Berkol
     *
     * @return          array       $this->exception
     *
     */
    public function getException(){
        return $this->exception;
    }
}
/**
 * Change Log:
 * **************************************
 * v1.1.0                      Can Berkol
 * 05.07.2013
 * **************************************
 * A getBehaviors()
 * A getDate()
 * A getEmailFrom()
 * A getEmailTo()
 * A getEnv()
 * A getEnvironment() alias to getEnv()
 * A getException()
 * A registerBehaviors()
 *
 * **************************************
 * v1.0.0                      Can Berkol
 * 26.06.2013
 * **************************************
 * A $date
 * A $email_from
 * A $email_to
 * A __construct()
 * A __destruct()
 * A notify
 *
 */