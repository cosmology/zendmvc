<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $uri = $this->_request->getPathInfo();
        $activeNav = $this->view->navigation()->findByUri($uri);
        $activeNav->active = true;

        $this->view->addHelperPath('/ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
    }

    public function indexAction()
    {
        // action body    	
    	$register = new Application_Model_Register();
		
    	$var = ZC_Printer::printMe();    	
    	echo "updating user $var<br />";
 
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

