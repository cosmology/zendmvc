<?php
class SearchController extends Zend_Controller_Action
{

	public function init()
	{
		$uri = $this->_request->getPathInfo();
		$activeNav = $this->view->navigation()->findByUri($uri);
		$activeNav->active = true;
		
		//$fc = Zend_Controller_Front::getInstance()->getRequest();
		//var_dump($fc->getParams());
	
		//echo $this->view->myUrl($fc->getParams());
	
		$this->view->addHelperPath('/ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
	
	}
	
	public function indexAction()
	{
		$request = $this->getRequest();
    	$form = new Application_Form_SearchUserOnGoogleForm();
    
    	if($this->getRequest()->isPost()){
    		if($form->isValid($request->getPost())){
    			
    			//$user = new Application_Model_User($form->getValues());
    			//$mapper = new Application_Model_UserMapper();
    			//$mapper->save($user);
    			
    			$search = new Application_Model_GoogleScraper($form->getValue('name')); //SERP_Scrapper ("Ivan Prokic");
    			$results =  $search->get_google_results();
    			
    			$this->view->assign('results', $results);
    			//return $this->_helper->redirector('index');
    		}
    	}
    
    	$this->view->form = $form;
	}
}