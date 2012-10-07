<?php 
class Tiger_Controller_Plugin_Language extends Zend_Controller_Plugin_Abstract
{
    protected $_request;
    protected $_locale;
    protected $_translate;
    protected $_router;
 
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        $this->_request = $request;
        
        //echo 'routeStartup request: <br />' .  var_dump($request);
        $module = strtolower($this->_request->getModuleName());
        
        echo 'routeStartup: ' . $request->getBaseUrl() . '<br/>';
        
        /* if (substr($request->getRequestUri(), 0, -1) == $request->getBaseUrl()){
        	$request->setRequestUri($request->getRequestUri()."en"."/");
        	$request->setParam("language", "en");
        } */
        
        //var_dump($request);
 		
        $this->initLocale();
        $this->initTranslate();
        $this->initRouter();
        $this->initLocalizedRoute();
    }
 
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        // we have to wait for Zend's Router to cough up the module name, so
        // this is the first place the module name will be available within
        // the request object.
 
        // check for additional module translation files
        $module = strtolower($this->_request->getModuleName());        
        $controller = strtolower($this->_request->getControllerName());        
        $action = strtolower($this->_request->getActionName()); 
        
        
 		
 		echo "routeShoutdwon<br />";
 		//var_dump($this->_request);
 			
        if (($module !== 'default'))
        {
            $languageDirectory  = APPLICATION_PATH . '/modules/' . $module . '/languages';
 
            $translate = new Zend_Translate(
                            'array',
                            $languageDirectory,
                            $this->_locale,
                            array(
                                'scan' => Zend_Translate::LOCALE_DIRECTORY
                            )
            );
 
            // add the module translation to the base application translation array
            $this->_translate->addTranslation(array('content' => $translate));
            //var_dump($this->_translate);
        }
    }
 
    protected function initRouter()
    {
        $this->_router = Zend_Controller_Front::getInstance()->getRouter();
    }
 
    protected function initLocale()
    {
        // first, attempt to discern if a locale exists within the first
        // position of the uri string; be sure none of your modules or
        // controllers look like locale strings!
        $uri_parts = explode('/', $_SERVER['REQUEST_URI']);
        $locale = (Zend_Locale::isLocale($uri_parts[1]))
                ? $uri_parts[1]
                : DEFAULT_LOCALE;//in /public/index.php
        // second, set our locale based on the URI, if the URI does not yeild a
        // real locale, we use Zend's locale auto-detection and the request
        // object's lang param
        $this->_locale = new Zend_Locale($locale);
        $this->_request->setParam('lang', $this->_locale->toString());
 		
        
        //echo 'setting up locale to' . DEFAULT_LOCALE;
        // stuff locale into the registry for other locale-aware components
        Zend_Registry::set('Zend_Locale', $this->_locale);
    }
 
    protected function initTranslate()
    {
       
    	$this->_translate = new Zend_Translate(
                        'array',
                        APPLICATION_PATH . '/languages/',
                        $this->_locale,
                        array(
                            'scan' => Zend_Translate::LOCALE_DIRECTORY
                        )
        );
    	
    	//echo 'initTranslate locale: <br />' .  var_dump($this->_translate);
 
        // check to see if we actually have a translation available for the locale.
        // if not, we need to toss and exception letting the user know that a
        // translation does not exist for their locale. normally, we would never
        // even get here because locale should have been set by default. but if the
        // user specifically enters a bogus locale into the uri, that's what Zend
        // will use, so we need to account for this.
        if (!$this->_translate->isAvailable($this->_locale->toString())) {
            throw new Zend_Translate_Exception('Translation for locale '
                    . $this->_locale->toString() . ' does not exist.');
        }
 
        // now stuff translate into the registry for translate-aware components to find.
        Zend_Registry::set('Zend_Translate', $this->_translate);
    }
 
    protected function initLocalizedRoute()
    {
        // NOTE: Zend_Translate must be set within Zend_Registry first for the
        // route to pickup the URI translations
 
        // this will generate something like: ^(en|en_US|es|es_US)$
        $regexValidation = $this->getRegexValidationList();
 
        $route = new Zend_Controller_Router_Route(
                        ':@module/:@controller/:@action/*',
                        array(
                            'lang' => $this->_locale->toString(),
                            'module' => 'default',
                            'controller' => 'index',
                            'action' => 'index'
                        ),
                        array(
                            'lang' => $regexValidation
                        )
        );
       	
        $this->_router->addRoute('language', $route);
 
        $route = new Zend_Controller_Router_Route(
                        ':lang/:@module/:@controller/:@action/*',
                        array(
                            'lang' => $this->_locale->toString(),
                            'module' => 'default',
                            'controller' => 'index',
                            'action' => 'index'
                        ),
                        array(
                            'lang' => $regexValidation
                        )
        );
        $this->_router->addRoute('localized', $route);
    }
 
    protected function getRegexValidationList()
    {
        // The objective of the getRegexValidationList is to auto generate a
        // RegEx validation string for the routes to validate against. This
        // list will be based on all of the langugages available within the
        // translation list. Basically if a language folder exists, it will
        // show up here as a valid language. The string generated will look
        // similar to this:
        //
        // ^(en|en_US|es|es_US)$
 
        $out = "^(";
        $languages = $this->_translate->getList();
        foreach ($languages as $language) {
            $out .= $language . "|";
        }
        $out = substr($out, 0, -1) . ")$";  // remove the last "|"
        return $out;
    }
    
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
    	$registry = Zend_Registry::getInstance();
    	// Get our translate object from registry.
    	$translate = $registry->get('Zend_Translate');
    	$currLocale = $translate->getLocale();
    	// Create Session block and save the locale
    	$session = new Zend_Session_Namespace('session');
    
    	$lang = $request->getParam('lang','');
    	// Register all your "approved" locales below.
    	switch($lang) {
    		case "sr":
    			$locale = 'sr';
    			break;
    		case "en":
    			$locale = 'en';
    			break;
    		default:
    			/**
    			 * Get a previously set locale from session or set
    			 * the current application wide locale (set in
    			 * Bootstrap)if not.
    			 */
    			$locale = isset($session->lang) ? $session->lang : $currLocale;
    	}
    
    	$newLocale = new Zend_Locale();
    	$newLocale->setLocale($locale);
    	$registry->set('Zend_Locale', $newLocale);
    
    	$translate->setLocale($locale);
    	$session->lang = $locale;
    
    	// Save the modified translate back to registry
    	$registry->set('Zend_Translate', $translate);
    
    }    
 
}