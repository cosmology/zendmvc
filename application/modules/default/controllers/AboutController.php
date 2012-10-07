<?php
class AboutController extends Zend_Controller_Action
{

	public function init()
	{
		$uri = $this->_request->getPathInfo();
		$activeNav = $this->view->navigation()->findByUri($uri);	
		$activeNav->active = true;
		
		$fc = Zend_Controller_Front::getInstance()->getRequest();
		//var_dump($fc->getParams());
		
		//echo $this->view->myUrl($fc->getParams());
		
		$this->view->addHelperPath('/ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
		
	}
	
	public function indexAction()
	{
		
	}

}