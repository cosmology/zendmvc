<?php

class Application_Form_UserInputForm extends Zend_Form
{

	public function init()
	{
		// Set the method for the display form to POST
		$this->setMethod('post');
		
		
		// Add the name element
		$this->addElement('text', 'name', array(
				'label'      => 'Your Name:',
				'required'   => true,
				'validators' => array(
						array('validator' => 'StringLength', 'options' => array(0, 30))
				)
		));
		
		
		// Add an email element
		$this->addElement('text', 'email', array(
				'label'      => 'Your email address:',
				'required'   => true,
				'filters'    => array('StringTrim'),
				'validators' => array(
						'EmailAddress',
				)
		));
		
		
		// Add the phone element
		$this->addElement('text', 'phone', array(
				'label'      => 'Your Phone:',
				'required'   => true,
				'validators' => array(
						array('validator' => 'StringLength', 'options' => array(0, 10))
				)
		));
	
		
	
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
	
		// Add the submit button
		$this->addElement('submit', 'submit', array(
				'ignore'   => true,
				'label'    => 'Add Client',
		));
	
		// And finally add some CSRF protection
		$this->addElement('hash', 'csrf', array(
				'ignore' => true,
		));
	}

}

