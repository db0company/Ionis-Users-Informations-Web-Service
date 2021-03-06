<?php

include_once('load.php');
include_once('actions.php');

function	check_requiered()
{
  $requiered = array('action',
		     'auth_login',
		     'auth_password'
		     );
  
  foreach ($requiered as $r)
    {
      if (!isset($_GET[$r]))
	return (false);
    }

  return (true);
}

function	run_request()
{
  global	$iui;

  if (!isset($format))
    $format = 'ini';
  
  $result = array();
  $result['result'] = array();
  $result['action'] = $_GET['action'];

  if (!check_requiered())
    {
      $result['error'] = 'missing_parameters';
      return ($result);
    }

  if (!function_exists('ws_'.$_GET['action']))
    {
      $result['error'] = 'unknown_action';
      return ($result);
    }

  if (empty($_GET['auth_login'])
      || empty($_GET['auth_password'])
      || !$iui->checkPass($_GET['auth_login'], $_GET['auth_password']))
    {
      $result['error'] = 'auth_fail';
      return ($result);
    }

  $result['error'] = 'none';
  $_GET['action'] = 'ws_'.$_GET['action'];
  $result = $_GET['action']($result);
  return ($result);
}

$result = run_request();
