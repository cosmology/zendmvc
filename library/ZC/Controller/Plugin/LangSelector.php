<?php
/**
 * Description of LangSelector
*
* @author jon
*/
class ZC_Controller_Plugin_LangSelector
	extends Zend_Controller_Plugin_Abstract
{
	/* public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		
		//die('LangSelector plugin loaded dying');
		$lang = $request->getParam('lang', '');
		
		var_dump($request->getParams());

		if ($lang !== 'en' && $lang !== 'sr')
			$request->setParam('lang','en');

		$lang = $request->getParam('lang');
		if ($lang == 'en')
			$locale = 'en_US';
		else
			$locale = 'sr_SR';

		$zl = new Zend_Locale();
		$zl->setLocale($locale);
		Zend_Registry::set('Zend_Locale', $zl);

		//$translate = new Zend_Translate('csv', APPLICATION_PATH . '/languages/'. $lang . '.csv' , $lang);
		$translate = new Zend_Translate(
				'array',
				APPLICATION_PATH . '/languages/',
				$this->_locale,
				array(
						'scan' => Zend_Translate::LOCALE_DIRECTORY
				)
		);
		Zend_Registry::set('Zend_Translate', $translate);

	} */
	
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		
		$lang = $request->getParam('lang', '');
		
		var_dump($request->getParams());
		//die('Language: ' . $lang);
	
		if ($lang !== 'en' && $lang !== 'sr')
			$request->setParam('lang','en');
	
		$lang = $request->getParam('lang');
		if ($lang == 'en')
			$locale = 'en';
		else
			$locale = 'sr';
	
		$zl = new Zend_Locale();
		$zl->setLocale($locale);
		Zend_Registry::set('Zend_Locale', $zl);
	
		$translate = new Zend_Translate('csv', APPLICATION_PATH . '/configs/lang/'. $lang . '.csv' , $lang);
		Zend_Registry::set('Zend_Translate', $translate);
	
	}

}

?>