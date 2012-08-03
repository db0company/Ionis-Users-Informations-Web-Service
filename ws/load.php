<?php

include_once('conf.php');
include_once($ionisusersinformations_path);
$iui = new IonisInfo($mysql_login, $mysql_pass, $mysql_dbname,
		     $ionis_login, $ionis_unix_password, $absolute_path_local_files, $afs,
		     $ionis_ppp_pass);

