<?php

namespace Admin;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Mvc\Dispatcher;

class Module {
	/**
	 * 注册自定义加载器
	 */
	public function registerAutoloaders($di){
		$loader = new Loader();
		$loader->registerNamespaces(array(
			'Admin\Controllers'=> __DIR__ . '/Controllers/',
			'Admin\Models'=> __DIR__ . '/Models/' 
		));
		
		$loader->register();
	}
	
	/**
	 * 注册自定义服务
	 */
	public function registerServices($di){
		// Registering a dispatcher
		$dispatcher = $di->get('dispatcher');
		$dispatcher->setDefaultNamespace("Admin\Controllers");
		$di->set('dispatcher', $dispatcher);
		// Registering the view component
		$view = $di->get('view');
		$view->setViewsDir(__DIR__ . '/Views/');
		$di->set('view', $view);
		// register menu
		$di->set('AdminMenus', function (){
			return require __DIR__ . '/Config/menus.php';
		});
	}
}