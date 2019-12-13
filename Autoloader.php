<?php 
//autoload all classes
spl_autoload_register(function ($class_name){

	$dirs = array_filter(glob('*'), 'is_dir');
	foreach ($dirs as $dir) {
		if(file_exists ($dir."/".$class_name.'.php')){
			include_once "./".$dir."/".$class_name.'.php';
		}
	}
	if(file_exists ($class_name.'.php')){
		include_once $class_name.'.php';
	}
});
?>