<?php
class UserController extends Zend_Controller_Action
{

    protected $paginator;
	
	public function indexAction()
    {
		$users = new Application_Model_UserMapper();
		
		$this->view->entries = $users->fetchAll();
		
		// Create a Paginator for the blog posts query
		$this->paginator = Zend_Paginator::factory($this->view->entries);
		 
		// Read the current page number from the request. Default to 1 if no explicit page number is provided.
		$this->paginator->setCurrentPageNumber($this->_getParam('page', 1));
		 
		// Assign the Paginator object to the view
		$this->view->paginator = $this->paginator;
		
    }

    public function signAction()
    {
        $request = $this->getRequest();
        $form = new Application_Form_UserInputForm();
        
        // Add the name element
        $form->addElement('text', 'name', array(
        		'label'      => 'Your Name:',
        		'required'   => true,
        		'validators' => array(
        				array('validator' => 'StringLength', 'options' => array(0, 30))
        		)
        ));
        
        if($this->getRequest()->isPost()){
        	if($form->isValid($request->getPost())){
        		$user = new Application_Model_User($form->getValues());
        		$mapper = new Application_Model_UserMapper();
        		$mapper->save($user);

        		return $this->_helper->redirector('index');
        	}
        }
        
        $this->view->form = $form;
    }

	public function searchAction()
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


?>

