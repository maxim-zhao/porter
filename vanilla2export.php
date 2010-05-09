<?php
/**
 * All-purpose logic
 *
 * @copyright Vanilla Forums Inc. 2010
 * @license http://opensource.org/licenses/gpl-2.0.php GNU GPL2
 * @package VanillaPorter
 */
 
global $Supported;

/** @var array Supported forum packages: classname => array(name, prefix) */
$Supported = array(
   'vanilla' => array('name'=> 'Vanilla 1.x', 'prefix'=>'LUM_'),
   'vbulletin' => array('name'=>'vBulletin 3+', 'prefix'=>'vb_')
);

/** 
 * Test filesystem permissions 
 */  
function TestWrite() {
   // Create file
   $file = 'vanilla2test.txt';
   @touch($file);
   if(is_writable($file)) {
      @unlink($file);
      return true;
   }
   else return false;
}

// Files
include('class.exportmodel.php');
include('views.php');
include('class.exportcontroller.php');
foreach($Supported as $file => $info) {
   include('class.'.$file.'.php');
}

// Logic
if(isset($_POST['type']) && array_key_exists($_POST['type'], $Supported)) {
   // Mini-Factory
   $class = ucwords($_POST['type']);
   new $class;
}
else {
   // View form or error
   if(TestWrite())
      ViewForm($Supported);
   else
      ViewNoPermission("This script has detected that it does not have permission to create files in the current directory. Please rectify this and retry.");
}