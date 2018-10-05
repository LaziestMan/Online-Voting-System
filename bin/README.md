## EXPRESS PHP FRAMEWORK DOCUMENTATION

1. SETTING UP YOUR FIRST EXPRESS PHP APP
	1. Clone the Express PHP repository on Github
	2. Create a index.php file
	```
	<?php
	
	// Require Express file
	require 'Express.php';
	
	// Instance a new Express App Object
	$app = new Express();
	
	# Express Configurations..
	
	# Set Express router's base path...
	
	// Set your App's base path. i.e where you extracted the app
	 $app->set('basePath', '/express');
	
	# Set Express view engine...
	
	// Set your App's view engine. By default Expess PHP supports Smarty view engine
	// You can set it to default, if you don't want to render your views with any view engine
	// if set to default your view template would be php files
	 $app->set('view engine', 'smarty');

	# Set Express views path...
	
	// Set the directory where your app's view template will reside
	$app->set('views', 'views/');

	
	# ROUTES...
	
	// Match a GET HTTP request to '/'
	$app->get('/', function($request, $response){
	
		// SEND BACK A MESSAGE TO THE BROWSER
		$response->send('Express PHP', array(
				'Content-type' => 'text/html'
		));
	});
	
	?>
	```
	
	3. Create .htaccess file add the following
	```
	RewriteEngine On
	RewriteCond %{REQUEST_FILENAME} !-
	RewriteRule ^(.*)$ index.php/$1 [L]
	```

	When you browse the address http://localhost/express the following would be displayed on your browser
		Express PHP
		
		
	2. Express PHP file structure
		Express PHP does not force you to use the MVC style. Since it is like a port of Express JS, it file structure almost looks like Express JS
		
		
		|- express_modules/										// Where Express PHP modules resides
		|- cache/												// Where Express caches are stored
			|-views/													# Where Express views cache is stored...
		|- views/ 												// Where Express views template are stored
		|- public/												// Where Express static files i.e JS, CSS, images e.t.c are stored
		|- Express.php											// The Express PHP file
		|- index.php											// Entry point to Express PHP app
		|- .htaccess											// Express .htaccess configuration
		
		
		2.1 express_modules/
			This is where Express PHP modules are stored. In fact Express PHP built modules are stored this directory too.
			Example include
				1. Smarty
				2. ExpressValidator
				
		2.2 cache/
			This is where Express PHP caches reside.
			
			2.2.1 View Cache
			
			|- cache/views/
			This is where Express view template caches are stored. Note, if you set your view engine to default, you don't need to set up view
			caching.
			NOTE that you can change it to another folder, All you have to do is create the folder and
			use Express PHP setter method to set configuration.
			
			```
			$app->set('view cache path', 'your/new/cache/folder/');
			```
			You can even disable template caching using the following snippet. By the way, by default template caching is disabled
			```
			$app->set('view cache', FALSE);
			```
			
		2.3 views/
			This is where Express app view template resides. NOTE: If you wish to change the folder, create your folder and use the following
			snippet to configure Express to that folder you created.
			```
			$app->set('views', 'your/new/path/to/view/templates/');
			```
			
			Express PHP views are rendered using template engine you set.
			Express PHP supports Smarty view engine. To use enable it use the following:
			```
			$app->set('view engine', 'smarty');
			```
			
			By default, view engine is set to 'default'. Which means Express PHP will render pure PHP files as templates:
			```
			$app->set('view engine', 'default');
			``` 
			
		2.4 public/
			This is where Express PHP static files reside. File that resides here are directly accessible by the  browser.
			NOTE: By default, the public folder is used. If you desire to change it use the following snippet:
			
			```
			$app->set('static', 'path/to/new/publc/folder/');
			```
		2.5 Express.php
			This is the Express PHP Framework code base. One of the aim of this frame work is been light weight. In fact this is all you need
			to create a Express PHP app.
			
		2.6 index.php
			This is your Express App entry point. It is where your business logic resides
			
		2.7 .htaccess
			Here is where we use mod_rewrite to rewrite Express PHP URL to a vanity/pretty one
			
			
			
		3.1
		Express PHP App Structure
		
		```
		<?php
		
		// Require Express PHP Framework
		
		// CREATE THE APP
		
		// Configure Express PHP
		
		// IMPORT EXPRESS MODULES
		
		// SET YOUR EXPRESS PHP APP MIDDLEWARES
		
		// MAP EXPRESS APP ROUTES
		
		?>
		```
		
		3.1.1 REQUIRE/INCLUDE EXPRES PHP FRAMEWORK
		
		In other to use Express PHP you have to include it your 'index.php' file
		``` [PHP]
		require 'Express.php';
		
		3.1.2 CREATING Express PHP APP
		After including Express PHP framework. you have to create an Express PHP app. To do so you instance a new Express object which
		your APP object
		``` [PHP]
		$app = new Express();
		```
		
		3.1.3 CONFIGURING Express PHP App
		After creating Express PHP app, you must configure the app in other for it to work properly
		In Express Framework; the $app->set(); is used to set Express PHP application Configuration.
		
		$app->set(); accepts to arguments, which are 1. the name of the configuration and
		2. the value you want to set it to. 
	
		Express APP CONFIGURATIONS INCLUDE:
			
			1. basepath 		// Express APP base path
				$app->set('basepath', 'path/to/where/you/install/express/');
				
			2. views 			// Where your Express App view templates resides
				$app->set('views', 'path/to/where/your/view/template/resides/');
				
			3. view engine 		// The name of the view engine you are using
				_________________________________________________________________________________
				| Engine Name | Value 	| Description								| Extension |
				=================================================================================
				| No Engine   | default | This means that no view engine is			| .php      |
				|			  |			| employed. Express would render pure PHP	| 			|
				| 			  | 		| files as view.							|			|
				---------------------------------------------------------------------------------
				| Smarty 	  | smarty  | Use set Express to use smarty view engine.|			|
				|			  |	 		| Express would use smarty to render it	    | .tpl		|
				|			  |			| views.									|			|
				=================================================================================
				
				Example 1: Using no view engine.
				
					$app->set('view engine', 'default');
				Example 2: Using Smarty view engine.
				
					$app->set('view engine', 'smarty');
					
			4. env 			// TO SET APP's Environment
				The following are possible values
				1. development
				2. production
				3. test
				4. debug
				
				Example: Set app's mode to production
					$app->set('env', 'production');
					
			5. view cache		// TO ENABLE OF DISABLE VIEW CACHING
				This configuration is used to enable or disable view template caching. It accepts boolean values.
				VALUES: TRUE|FALSE
				
				Example 1: Enable view caching.	
				$app->set('view cache', true);
				
				Example 2: Disable view caching.		
				$app->set('view cache', false);
				
			6. view cache path 			// SET WHERE EXPRES WILL CACHE THE VIEW TEMPLATES TO.
				
				$app->set('view cache path', 'path/to/where/you/want/express/to/cache/its/view/template/');
				
		3.1.4 IMPORT EXPRESS MODULES
			Express supports modular coding. It supports a special type of dependency injection, where you inject your predefined
			Modules into Express PHP.
			
			3.1.4.1 THE Express PHP MODULE
			All Express PHP modules resides in the 'express_modules/' folder
			Let's see the a MODULE structure in Express PHP
			
			|- express_modules/
				|- MyModuleName/			// Where your module files resides (ModuleName in PascalCase)
					|- index.php			// Entry point to your module, this is where Express PHP will import
					|- MyModuleName.php		// This is where your module business logic resides
											// (logic file Named after the ModuleName in PascalCase)
			
			Express employs the use of PascalCase in naming it modules
			
			3.1.4.1.1 CREATING A MODULE
			Let create a simple module that reverse  given string just for example. Let name it 'ReverseString'.
			1. Inside the express_modules/ folder
				ReverseString/
				
			2. Create two files inside the folder you created:
				1. index.php
				2. ReverseString.php
				
				Your folder structure should now look like this.
				|- express_modules/
				|- ReverseString/
					|- index.php
					|- ReverseString.php
					
			3. Write your Module logic in the:
			
			```
			class ReverseString {
				public function reverse($string) {
					return str_rev($string);
				}
			}
			```
			
			4. Now write your module entry point, in other for you to export/inject it into Express PHP.
			
			Here is a template of creating your module entry point.
			
			``` [PHP]
			<?php

			# Require ModuleName Class Definition...
			require 'ModuleName.php';


			$export = function(){
				
				# Instance the module...
				$module = new ModuleName();

				# Inject Module into Express...
				$GLOBALS['app']->_ModuleName = $module; // Note  ModuleName here must be prefixed with Underscore(_)
														//	This tells Express PHP that this property is a module, and were
														// Are injecting it into our Express() Object.
			};

			# Export module..
			$export();
			```
			
			Edit your index.php add the following codes
			```
			<?php

			# Require ReverseString Class Definition...
			require 'ReverseString.php';


			$export = function(){
				
				# Instance the module...
				$module = new ReverseString();

				# Inject Module into Express...
				$GLOBALS['app']->_ReverseString = $module;
			};

			# Export module..
			$export();
			```
	
			Yo!. you have successfully created your first Express PHP module
																		   
																		   ***
			3.1.4.1.2 IMPORTING EXPRESS PHP MODULE_______		
			To import a module in Express, we do this using the import() method.
			
				$app->import('ModuleName');
				
			Now Let's Import the module we created earlier
				To Do so:
					$app->import('ReverseString');
					// You have successfully imported the module...
					
			3.1.4.1.3 USING Express PHP Module
			
				To use the module you have imported into Express PHP. You access the Module's Object in general this format:
				
				$app->_ModuleName
				
				NOTE: We Standardize appending underscore before your Module Object so as to differentiate Your Module and Express() Object
				property. So I Express PHP whenever you see '$app->_Anything', it is a module which as been injected into Express () Object
				
				Let use the ReverseString module we created earlier, to reverse a string:
				 
				 $app->_ReverseString->reverse('Hello World');
				 //OUTPUT: dlroW olleH
				 
				For example:
				``` [PHP]
				<?php
				include 'Express.php';
				$app = new Express();
				$app->set('basePath', '/express');
				$app->import('ReverseString');
				echo $app->_ReverseString->reverse('Hello world');
				?>
				```
				
				When you launch this in your browser, You will see...
					dlroW olleH
					
				Some modules that comes bundled with Express PHP:
					1. ExpressVilidator
					
					Example: ExpressValidator Module in action. Let's see if a specified string match the email form criteria.
					
					$app->import('ExpressValidator');
					var_dump($app->_ExpressValidator->validate('email', 'victor.olorunbunmi@gmail.com'));
					// OUTPUT: boolean TRUE
					
		3.1.4 SET YOUR EXPRESS PHP APP MIDDLEWARES
					3.1.4.1 What is a middleware?
						As the name suggest, Middleware acts as a middle man between request and response. It is a type of filtering mechanism.
					For example, ExpressPHP includes a middleware that verifies whether user of the application is authenticated or not.
					If the user is authenticated, he will be redirected to the home page otherwise, he will be redirected to the login page.
					There are two types of middlewares in Express PHP
						1. General Middleware, (Invoking middleware)
						2. Route Specific Middleware
										
					3.1.4.2 The USE() METHOD
						In Express PHP. We use use() a method of Express PHP object to declare a middleware.
						$app->use();
						The use() method is an overloaded method:
							1. $app->use($arg1);		// Declaring a general middleware
							2. $app->use($arg1, $arg2); // Declaring a route specific middleware
							
					3.1.4.3 General Middleware (Invoking Middleware)
					The general middleware is called the invoking middleware because it accepts a function and invokes it. Simple!
					And it's is called general because it will be invoked even before url routing begins, this imlies that all routes will
					be middlewared by the general middleware.
					Syntax:
						$app->use(function);
						
						You pass in a function with the invoke operator as an argument to the method;
						
					3.1.4.3.1 Declaring A General Middleware
						Lets declare a simple General middleware that echo 'hello I am a middleware' on every routes.
						
						function middleware1() {
							echo 'Hello I am a middleware';
						}
						
						$app->use(middleware1());
						
						A practical use of the General middleware is using it to start a user session.
						Example: This is a General middleware that initiates a user using ssession_start() every route.
						
						$app->use(session_start());
						
					3.1.4.4.1 How Route Specific Middlewares works in Express PHP
						Once User Request for a route. Express PHP gets its Middlewares register and checks
						if there are any middleware callback function registered for this route requested. If found
						it will invoke the callback and after that Express PHP now invokes your route's callback.
					
					3.1.4.4.2 Declaring Route Specific Middleware
					Middleware is an amazingly useful pattern that allows developers to reuse code within their applications and even
					share it with others in the form of Express PHP modules. The essential definition of middleware is a function with two
					arguments: request (or req), response (res). Here’s an example of how to define your own middleware:
					
					The second overloaded use() method which accepts two parameters is used to declare a route specific middleware.
					
						$app->use(@route, @callback);
						
						@route: Is a string representing the route you want to add the middleware
						@callback: Is the function is invoked a user request matches the route, before the route's
									callback function is invoked. When you define @callback, you give it two parameters.
									1. $req // Which is the request object
									2. $res // Which is the response Object
									
						$app->use('/', function($req, $res){
							# Your route specific middleware logic goes here...
						});
					
					Let's create a simple Logged In user authentication using the General, Route specific middleware and

						```
						
						// Declare a General middleware that initiates a user session 
						$app->use(session_start());
						
						// Create a route specific middleware that executes its when the user visits the dashboard route
						$app->use('/dashboard', function($req, $res){
							if(isset($req->session['loggedIn']) && $req->session['loggedIn']==FALSE) {
							
								// User has not logged in, redirect to the login page
								$res->redirect('/login');
							} else {
							
								// User is logged in! Send A message
								$res->send('Hello '.$req->session['username'], array(
									'Content-type'=>'text/html'
								));
							}
						});
						```
						
						
						NOTE: A single route can have more than one middleware and all will be invoked.
						Example: An example showing a route that has three middleware
						
						$app->use('/', function($req, $res){
							echo "middleware 1";
						});
						
						$app->use('/', function($req, $res){
							echo "middleware 2";
						});
						
						$app->use('/', function($req, $res){
							echo "middleware 2";
						});