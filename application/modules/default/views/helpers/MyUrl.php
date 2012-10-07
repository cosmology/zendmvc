<?php
class Zend_View_Helper_MyUrl extends Zend_View_Helper_Url
{

	protected function _getCurrentLanguage()
	{
		return Zend_Registry::get('Zend_Locale')->getLanguage();
	}

	public function myUrl($urlOptions = array(), $name = null, $reset = true, $encode = true)
	{
	
		//die('Module View_Helper_MyUrl');
		
		$urlOptions = array_merge(
				array(
						"lang" => $this->_getCurrentLanguage()
				),
				$urlOptions
		);
		print_r($urlOptions);
		return parent::url($urlOptions, $name, $reset, $encode);
	}

}