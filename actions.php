<?php

function	check_params(&$result, $params)
{
  foreach ($params as $param)
    if (!isset($_GET[$param]))
      {
	$result['error'] = 'missing_parameters';
	return (false);
      }
  return (true);
}

function	ws_login($result)
{
  return ($result);
}

function	ws_is_login($result)
{
  global	$iui;

  if (!(check_params($result, array('login'))))
    return ($result);
  $result['result']['login'] = $_GET['login'];
  $result['result']['state'] = ($iui->isLogin($_GET['login']) ? 'OK' : 'KO');
  return ($result);
}

function	ws_check_password($result)
{
  global	$iui;

  if (!(check_params($result, array('login', 'password'))))
    return ($result);
  $result['result']['login'] = $_GET['login'];
  $result['result']['state'] = ($iui->checkPass($_GET['login'], $_GET['password']) ?
				'OK' : 'KO');
  return ($result);
}

function	ws_get_login_from_uid($result)
{
  global	$iui;

  if (!(check_params($result, array('uid'))))
    return ($result);
  $result['result']['uid'] = $_GET['uid'];
  $result['result']['login'] = $iui->getLoginFromUid($_GET['uid']);
  return ($result);
}

function	ws_get_uid($result)
{
  global	$iui;

  if (!(check_params($result, array('login'))))
    return ($result);
  $result['result']['login'] = $_GET['login'];
  $result['result']['uid'] = ($iui->getUid($_GET['login']));
  return ($result);
}

function	ws_get_name($result)
{
  global	$iui;

  if (!(check_params($result, array('login'))))
    return ($result);
  $result['result']['login'] = $_GET['login'];
  $result['result']['name'] = ($iui->getName($_GET['login']));
  return ($result);
}

function	ws_get_group($result)
{
  global	$iui;

  if (!(check_params($result, array('login'))))
    return ($result);
  $result['result']['login'] = $_GET['login'];
  $result['result']['group'] = ($iui->getGroup($_GET['login']));
  return ($result);
}

function	ws_get_school($result)
{
  global	$iui;

  if (!(check_params($result, array('login'))))
    return ($result);
  $result['result']['login'] = $_GET['login'];
  $result['result']['school'] = ($iui->getSchool($_GET['login']));
  return ($result);
}

function	ws_get_promo($result)
{
  global	$iui;

  if (!(check_params($result, array('login'))))
    return ($result);
  $result['result']['login'] = $_GET['login'];
  $result['result']['promo'] = ($iui->getPromo($_GET['login']));
  return ($result);
}

function	ws_get_city($result)
{
  global	$iui;

  if (!(check_params($result, array('login'))))
    return ($result);
  $result['result']['login'] = $_GET['login'];
  $result['result']['city'] = ($iui->getCity($_GET['login']));
  return ($result);
}

function	ws_get_report_url($result)
{
  global	$iui;

  if (!(check_params($result, array('login'))))
    return ($result);
  $result['result']['login'] = $_GET['login'];
  $result['result']['report_url'] = ($iui->getReportUrl($_GET['login']));
  return ($result);
}

function	ws_get_photo_url($result)
{
  global	$iui;

  if (!(check_params($result, array('login'))))
    return ($result);
  $result['result']['login'] = $_GET['login'];
  $result['result']['photo_url'] = ($iui->getPhotoUrl($_GET['login']));
  return ($result);
}

function	ws_get_plan($result)
{
  global	$iui;

  if (!(check_params($result, array('login'))))
    return ($result);
  $result['result']['login'] = $_GET['login'];
  $result['result']['plan'] = ($iui->getPlan($_GET['login'],
					     '/var/www/poney/Ionis-Users-Informations/plan'));
  return ($result);
}