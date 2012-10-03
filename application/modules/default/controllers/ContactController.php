<?php
class ContactController extends Zend_Controller_Action
{

	public function init()
	{
		$uri = $this->_request->getPathInfo();
		$activeNav = $this->view->navigation()->findByUri($uri);
		$activeNav->active = true;
	
		//var_dump($fc->getParams());
	
		//echo $this->view->myUrl($fc->getParams());
	
		$this->view->addHelperPath('/ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
	
	}
	
	public function indexAction()
	{
		$form = new ZendX_JQuery_Form();
		 
		$heardOfUs = new ZendX_JQuery_Form_Element_AutoComplete('ac');
		$heardOfUs->setLabel('How did you hear about us?');
		$heardOfUs->setJQueryParam('data', array('Internet','Article','Word of mouth','Webinar','Podcast'));
		 
		$form->addElement($heardOfUs);
		 
		 
		 
		//$name = new ZendX_JQuery_Form_Element_UiWidget($spec);
		 
		$date = new ZendX_JQuery_Form_Element_DatePicker(
				'date1',
				array('label' => 'Setup Appointment Date:')
		);
		 
		$date->setJQueryParams(array('dateFormat' => 'yy-mm-dd',
				'required'   => true));
		 
		 
		 
		$form->addElement($date);
		 
		$this->view->form = $form;
	}
}