<?php

class Application_Form_SearchUserOnGoogleForm extends Zend_Form
{

public function init()
	{
		// Set the method for the display form to POST
		$this->setMethod('post');
		$this->clearDecorators();
		$this->addDecorator('FormElements')
		->addDecorator('HtmlTag',
				array('tag' => '<ul>'))
				->addDecorator('Form');
		
		$this->setElementDecorators(array(
				array('ViewHelper'),
				array('Errors'),
				array('Description'),
				array('Label', array('separator'=>' ')),
				array('HtmlTag',
						array('tag' => 'li', 'class'=>'form_elements')),
		));
		
		// Add the name element
		$this->addElement('text', 'name', array(
				'label'      => 'Search by Full Name:',
				'required'   => true,
				'validators' => array(
						array('validator' => 'StringLength', 'options' => array(0, 30))
				)
		));
		
		
		
		// Add the submit button
		$this->addElement('submit', 'submit', array(
				'ignore'   => true,
				'label'    => 'Search',
		));
		
		
		$this->getElement('submit')->setDecorators(array(
				array('ViewHelper'),
				array('Description'),
				array('HtmlTag',
						array('tag' => 'li', 'class'=>'submit_button')),
		));
		
		/*	
		// Add a captcha
		$this->addElement('captcha', 'captcha', array(
				'label'      => 'Please enter the 5 letters displayed below:',
				'required'   => true,
				'captcha'    => array(
						'captcha' => 'Figlet',
						'wordLen' => 5,
						'timeout' => 300
				)
		));	
	
		// And finally add some CSRF protection
		$this->addElement('hash', 'csrf', array(
				'ignore' => true,
		));
		*/
	}


}

