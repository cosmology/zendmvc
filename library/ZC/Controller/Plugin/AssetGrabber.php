<?php
/**
 * Description of AssetGrabber
 *
 * @author jon
 */
class ZC_Controller_Plugin_AssetGrabber
    extends Zend_Controller_Plugin_Abstract
{
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
		//die('AssetGrabber plugin loaded dying');
    	if ($request->getControllerName() != 'assets')
		    return;
		
		$session = new Zend_Session_Namespace('auth');
		if (!$session->authenticated)
		{
		    $request->setControllerName('index');
		    $request->setActionName('index');
		    return;
		}
		
		$action = $request->getActionName();
		echo file_get_contents(APPLICATION_PATH .'/assets/' . $action);
	
		exit;
    }

}