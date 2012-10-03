<?php
/**
 * Description of LayoutPicker
 *
 * @author jon
 */
class ZC_Controller_Plugin_LayoutPicker
    extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
    	//die('LayoutPicker plugin loaded dying');
    	Zend_Layout::getMvcInstance()->setLayout($request->getModuleName());
    }

}