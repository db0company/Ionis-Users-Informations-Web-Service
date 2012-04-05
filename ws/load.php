<?php

include_once('conf.php');
include_once($class_path.'/ionisinfo.class.php');
$iui = new IonisInfo($mysql_login, $mysql_pass, $mysql_dbname,
		     $ionis_login, $ionis_unix_password, $path_local_files, $afs);

