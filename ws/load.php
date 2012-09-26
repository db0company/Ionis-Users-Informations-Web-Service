<?php

include_once('conf.php');
include_once($ionisusersinformations_path);
$iui = new IonisInfo($mysql_login, $mysql_pass, $mysql_dbname,
		     $ionis_login, $ionis_unix_password, $absolute_path_local_files, $afs,
		     $ionis_ppp_pass);

function	cast_bdd()
{
  global $casts_mysql_dbname, $casts_mysql_login, $casts_mysql_pass;
  $bdd = new PDO('mysql:host=localhost;dbname='.$casts_mysql_dbname,
		 $casts_mysql_login, $casts_mysql_pass);
  $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $bdd;
}
