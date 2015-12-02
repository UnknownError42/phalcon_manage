<?php
use Phalcon\Mvc\Application;
use Phalcon\Config\Adapter\Ini as ConfigIni;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Dispatcher;
/**
 * Read the configuration
 */
$config = new ConfigIni(__DIR__ . '/config/config.ini');
if(is_readable(__DIR__ . '/config/config.dev.ini')){
	$override = new ConfigIni(__DIR__ . '/config/config.dev.ini');
	$config->merge($override);
}

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * We register the events manager
*/
$di->set('dispatcher', function () use($di){
	$dispatcher = new Dispatcher();
	return $dispatcher;
});
/**
 * Auto-loader configuration
 */
require __DIR__ . '/config/loader.php';

/**
 * Load application services
 */
require __DIR__ . '/config/services.php';

$application = new Application($di);

// register moudles
$application->registerModules(array(
	'Frontend'=> array(
		'className'=> 'Frontend\Module',
		'path'=> __DIR__ . '/Frontend/Module.php' 
	),
	'Admin'=> array(
		'className'=> 'Admin\Module',
		'path'=> __DIR__ . '/Admin/Module.php' 
	) 
));
// router
$di->set('router', function () use($application){
	return require __DIR__ . '/config/routes.php';
});