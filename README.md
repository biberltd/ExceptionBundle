ExceptionBundle
===============

A library to handle exceptions in a custom way. Right now this bundle offers two different behaviors to handle exceptions based on environments.

The first behavior is the devBehavior and the second behavior is the prodBehavior.

devBehavior outputs the exception into screen and prodBehavior sends the exception via email to a configured e-mail address among many other useful debugging information.

Using ExceptionBundle, you can easily add new environment specific exception handling behaviors to your coding. For example, you can add a behavior to open a new bug report ticket automatically whenever an exception raises in your application.


Requirements
===============
This is a Symfony2 Bundle. To use it as is you have to have  Symfony2 installed.

Installation
===============
Using Composer:
	You need to add
	
	"biberltd/exception-bundle": "dev-master",
	
	into "require" array within your symfony/composer.json. Once you do that, you can install the bundle by typing 
	the following command within your console:
	
	composer install --dev
	
Manual Installation:
	Download the source code of the bundle. Create a folder named "BiberLtd" in your vendor folder. Within that folder create 
	a folder named as "exception-bundle" and either 
	
		1. unpack the files you have downloaded into "exception-bundle"
		2. or create the following folder structure: BiberLtd/Bundles and pull files into the Bundles folder.
		
	After that open vendor/composer/autoload_namespaces.php and add this line:
	
		'BiberLtd\\Bundles\\ExceptionBundle' => array($vendorDir . '/biberltd/exception-bundle'),
		
	Finally, open app/AppKernel.php and register the bundle by adding the following line into $bundles array:
	
		new BiberLtd\Bundle\ExceptionBundle\BiberLtdBundlesExceptionBundle(),
		
Configuring the Email Functionality:
	Open the ExceptionBundle/Resources/config/services.yml file.
	
	Here you will see two parameters. One for the from address and the other for the to address.
	
		- biber_ltd_exception.email.from: support@biberltd.com
    - biber_ltd_exception.email.to: support@biberltd.com
  
  Change them as you want and you are good to go.

How to Use ExceptionBundle
===============

You need to define your own exceptions to use ExceptionBundle. To do this first create a folder where you will store your
exceptions. For example in your bundle MyBundle create Exceptions folder: MyBundle/Exceptions.

	1. Now create a sample exception called SampleException. The file name must have the same name as your class, so it will be SampleException.php
	
	2. You need to define the files namespace first and second you need to include this statement:
		use BiberLtd\Bundle\ExceptionBundle\Services;
		
	3. All you need to do is to create your class as following:
		class SampleException extends Services\ExceptionAdapter { }
		
	4. In your class you need to have only a constructor function that calls the paranet constructor function.
	
		public function __construct($kernel, $message = "", $code = 0, Exception $previous = null) {
        parent::__construct(
            $kernel,
            'Oh my god! '.$message.' not found here!',
            $code,
            $previous);
		}
	
		As you can see $message parameter should contain any dynamic part of the message you require. You can leave the
		$code parameter as zero or you can set it to a numeric value based on your own error coding scheme.
		
		You can change the line that starts with 'Oh my god!'... with the message you want to output.
		
	5. Once you have created your exception you can use it in any other files including controllers. Open a controller for example
		and add the following line on top of the file.
    
    use MyNameSpace\MyBundle\Exceptions;
    
  6. In your class where you expect to see an error - within an if statement etc. - create a new Exception. Make sure that
  	you do not THROW the extension but only create it like this:
  	
  	new Exceptions\SampleException($kernel, 'something');
  	
  	Make sure to pass the kernel to the function (AppKernel instance). There are numerous ways to get a copy of the kernel. 
  	The second parameter may be an empty string but it is recommended that you dump the value that you test.
  	
  7. The ExceptionBundle handles the rest automatically. Based on your environment, the bundle decides which behavior to run and based on the behavior
  	the bundle handles the exception.

How to Add New Behaviors
===============
In ExceptionBundle you will see a folder named Behaviors. Here you'll see two different behaviors. You can either modify these behaviors or add a new one.

When adding a new behavior you need to make sure that the file name ends with "Behavior.php" and starts with the environment name with its first letter being capital.

For example, if you have an environment set as "staging", you can create a behavior file with the following name:
	StagingBehavior.php

Your behavior must
	- be placed within the 
		namespace BiberLtd\Bundle\ExceptionBundle\Behaviors;
	- use BiberLtd\Bundle\ExceptionBundle\Behaviors\BehaviorInterface;
	- use BiberLtd\Bundle\ExceptionBundle\Services\ExceptionAdapter;
	- implement BehaviorInterface\BehaviorInterface
	- have a public function called notify with the ExceptionAdapter $service parameter.
	
The parameter holds all you need about the exception.

The getException() method returns a regular PHP exception object.

The getEmailFrom() and the getEmailTo() functions return defined parameters.

The rest is up to your imagination. The ExceptionBundle defines which behavior to use based on the set environment.
	


