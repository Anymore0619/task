<?php
return array(
	'_root_'  => 'welcome/index',  // The default route
	//'_404_'   => 'welcome/404',    // The main 404 route
	
	//'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
    'example' => 'web/example',   // /web/example -> /example
    'example/item/(:any)' => '/web/example/item/$1'   // web/example/item/12

);
