<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        //$uri = $this->_request->getPathInfo();
        //$activeNav = $this->view->navigation()->findByUri($uri);        
        $activeNav->active = true;
        
        $this->view->addHelperPath('/ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
        
    }
    
    // display static views
    public function displayAction(){
    	$page = $this->getRequest()->getParam('page');
    	if (file_exists($this->view->getScriptPath(null) ."/" . $this->getRequest()->getControllerName() ."/$page." . $this->viewSuffix))
    	{
    		$this->render($page);
    	} else {
    		throw new Zend_Controller_Action_Exception('Page not found',404);
    	}
    }

    public function indexAction()
    {
          	
    	$register = new Application_Model_Register();
    	//$var = ZC_Printer::printMe();
    	
    }
    
    public function breadcrumbsAction()
    {
    
    }
    
    public function sitemapAction()
    {
    	$this->view->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	echo $this->view->navigation()->sitemap();
    }
    
}

