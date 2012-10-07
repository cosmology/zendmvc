<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	
	// antyhing that starts with _init will be run by bootstrap process
	
	
	protected function _initAutoload()
	{
		$moduleLoader = new Zend_Application_Module_Autoloader(array(
				'namespace' => '',
				'basePath' => APPLICATION_PATH));
		
		
		return $moduleLoader;
	}
	
	/* public function _initTranslate() {
		$this->bootstrap('locale');
		if($this->hasResource('locale')){
			$locale = $this->getResource('locale');
		}
	
		$translate = new Zend_Translate(array(
				'adapter' => 'csv',
				'disableNotices' => true,
		)
		);
	
		$translate->getAdapter()->addTranslation(
				array(
						'content' => APPLICATION_PATH . '/languages/en_US/en.csv',
						'locale' => 'en'
				)
		);
		$translate->getAdapter()->addTranslation(
				array(
						'content' => APPLICATION_PATH . '/languages/sr_RS/sr.csv',
						'locale' => 'sr'
				)
		);
		if($translate->getAdapter()->isAvailable($locale->getLanguage())){
			$translate->getAdapter()->setLocale($locale->getLanguage());
		}else{
			$translate->getAdapter()->setLocale('sr');
		}
		Zend_Registry::set('Zend_Locale', $locale);
		Zend_Registry::set('Zend_Translate', $translate);
	} */
	
	
	/* protected function _initRoutes()
	{
		
		
		$frontController = Zend_Controller_Front::getInstance();
		$router = $frontController->getRouter();
		$router->removeDefaultRoutes();		
		
		// add language to default route
		$route = new Zend_Controller_Router_Route(
				':lang/:module/:controller/:action/*',
				array('controller'=>'index',
						'action' => 'index',
						'module'=>'default',
						'lang'=>':lang'));
		
		$router = $frontController->getRouter();
		$router->addRoute('default', $route);
		$frontController->setRouter($router);
	} */
	
	
	protected function _initRoutes()
    {
		
    	$this->bootstrap('FrontController');   	
    	$this->_frontController = $this->getResource('FrontController');
    	$router = $this->_frontController->getRouter();
    	$router->removeDefaultRoutes();
    	
    	$module = new Zend_Controller_Router_Route_Module(
    			array(),
    			$this->_frontController->getDispatcher(),
    			$this->_frontController->getRequest()
    	);
    	 
    	
    	$langRoute = new Zend_Controller_Router_Route(
    			':lang/',
    			array(
    					'lang' => 'en', //use init locale here
    			)
    	);
    	 
    	$defaultModuleRoute = new Zend_Controller_Router_Route(
    			':controller/:action',
    			array(    					
    					'lang'		=>'en',//use init locale here
    					'module'	=>'default',
    					'controller'=>'index',
    					'action'	=>'index'
    			)
    	);
    	
    	$adminModuleRoute = new Zend_Controller_Router_Route(
    			':module/:controller/:action',
    			array(
    					'module'	=>'admin',
    					'controller'=>'index',
    					'action'	=>'index'
    			)
    	);
    	
    	$chainRoute = new Zend_Controller_Router_Route_Chain();
    	$chainRoute->chain($langRoute)
    				->chain($module);
    	 
    	//echo '--------------------------------';
    	//var_dump($module);
    	//echo '--------------------------------';
    	$router->addRoute('default', $chainRoute);
    	//$router->addRoute('langRoute', $langRoute);
    	//$router->addRoute('adminModuleRoute', $adminModuleRoute);
    	//$router->addRoute('defaultModuleRoute', $defaultModuleRoute);
    	
    	//$router->addRoute('langControllerActionRoute', $langControllerActionRoute);
		
		/* $frontController = Zend_Controller_Front::getInstance();
		$router = $frontController->getRouter();
		//$router->removeDefaultRoutes();
		$router->addRoute(
		  'langmodulecontrolleraction',
		  new Zend_Controller_Router_Route('/:lang/:module/:controller/:action',
		    array('lang' => ':lang')
		  )
		);
		
		$router->addRoute(
				'langcontrolleraction',
				new Zend_Controller_Router_Route('/:lang/:controller/:action',
						array('lang' => ':lang')
				)
		); */
		
		/* $router->addRoute(
				'langmodcontroller',
				new Zend_Controller_Router_Route('/:lang/@module/:@controller/:action',
						array(
						'lang' => ':lang',
						'module' => 'default',
						'controller' => 'index',
						'action' => 'index'
				)
				)
		); */
		
		
		/* new Zend_Controller_Router_Route(
				':@controller/:@action/*',
				array(
						'lang' => $this->_locale->toString(),
						'module' => 'default',
						'controller' => 'index',
						'action' => 'index'
				),
				array(
						'lang' => $regexValidation
				)
		); */
		
		
		/* 
		$router->addRoute(
				'langcontroller',
				new Zend_Controller_Router_Route('/:lang/:controller',
						array('lang' => 'en',
								'module' => 'default',
								'controller' => 'index',
								'action' => 'index'
						)
				)
		);
		
		$router->addRoute(
		  'langindex',
		  new Zend_Controller_Router_Route('/:lang',
		    array('lang' => 'en',
			  'module' => 'default',
			  'controller' => 'index',
			  'action' => 'index'
		    )
		  )
		); */
		
    }
	
	protected function _initDoctype()
	{
		$this->bootstrap('layout');		
		$layout = $this->getResource('layout');		
		$view = $layout->getView();		
		
		$view->doctype('XHTML1_STRICT');
		
		$view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=utf-8')
						->appendName('description','Ivan Prokic Zend Framework demo project.')
						->appendName('keywords', 'framework, PHP, productivity');
		
		
		$view->headTitle('Zend MVC Application');
		
		Zend_Paginator::setDefaultScrollingStyle('Sliding');
		Zend_View_Helper_PaginationControl::setDefaultViewPartial('/controls/controls.phtml');
	}
	
	protected function _initNavigation()
	{

		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view = $layout->getView();
			
		$navArray = array(
				array(
						'module'		=> 'default',
						'controller' => 'index',
						'action' => 'index',
						'label' => 'home'
				),
				array(
						'module'		=> 'default',
						'controller' => 'about',
						'action' => 'index',
						'label' => 'about'
				),
				array(
						'module'		=> 'default',
						'controller' => 'user',
						'action' => 'index',
						'label' => 'user'
				),
				array(
						'module'		=> 'default',
						'controller' => 'search',
						'action' => 'index',
						'label' => 'search'
				)
				,
				array(
						'module'		=> 'default',
						'controller' => 'contact',
						'action' => 'index',
						'label' => 'contact'
				),
				array(
						'module'		=> 'admin',
						'controller' => 'index',
						'action' => 'index',
						'label' => 'admin'
				)
		);
		
		
		
		$config = new Zend_Config($navArray);
		$navigation = new Zend_Navigation();
		$navigation->addPages($config);
		
		//$config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');
		// setup navigations
		$navigation = new Zend_Navigation($config);
		
		/*
		$locale = 'sr';
			
		
		
		$menuPages =  $navigation->getPages();
		$outter = 0;
		$inner = 0;
		
		foreach ($menuPages as $page) {
			$outter++;
			echo "outter $outter <br />";
			$page->uri = $locale . $page->uri;
			echo 'main page uri: ' . $page->uri . '<br />';
			foreach ($page->pages as $subpage){
				$inner++;
				echo "inner $inner ";
				//$subpage = new Zend_Navigation_Page_Mvc(array('controller' => 'controller', 'action' => 'action'));
				//echo 'Sub page uri: ' . $this->_getParam('lang') . $subpage->uri . '<br />';
				//$localeLink =  $subpage->uri;
				//$subpage->uri = $locale . $subpage->uri;
				//echo "subpage->uri: $subpage->uri <br />";
				//echo "this->uri: $subpage->uri and locale $locale<br />";
				
				//var_dump($subpage);
				 
			}
		}
		*/
		
		// this fixes a bug in framework!
		Zend_Registry::set('Zend_Navigation', $navigation);
		$view->navigation($navigation);
	}
	
	
	
	protected function _initView()
	{
		//$view = new Zend_View();
		$layout = $this->getResource('layout');
		$view = $layout->getView();
		$view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
		
		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
		$viewRenderer->setView($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
		
		return $view;
	}	
}