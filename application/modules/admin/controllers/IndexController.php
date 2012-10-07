<?php
/**
 * Description of IndexController
 *
 * @author jon
 */
class Admin_IndexController
    extends Zend_Controller_Action
{
	
	public function init()
	{
		$uri = $this->_request->getPathInfo();
		$activeNav = $this->view->navigation()->findByUri($uri);
		$activeNav->active = true;
	
		$fc = Zend_Controller_Front::getInstance()->getRequest();
		//var_dump($fc->getParams());
	
		// Output list of routes, in the order they are matched
		echo '<ol>';
		$routes = array_reverse($this->getFrontController()->getRouter()->getRoutes());
		foreach ($routes as $name => $route) {
			echo "	<li>$name</li>\n";
		}
		echo '</ol>';
	
		$this->view->addHelperPath('/ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
	
	}
	
	public function indexAction()
    {
		//die('I am in the admin module');
		echo 'Module Admin IndexController indexAction';
		
    }
}