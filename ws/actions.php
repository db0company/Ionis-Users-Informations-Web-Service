<?php

include_once('CastManager.class.php');

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

function	default_params($default_values)
{
  foreach ($default_values as $key => $value)
    if (!isset($_GET[$key]) || empty($_GET[$key]))
      $_GET[$key] = $value;
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
					     'plan'));
  return ($result);
}

function	ws_get_phone($result)
{
  global	$iui;

  if (!(check_params($result, array('login'))))
    return ($result);
  $result['result']['login'] = $_GET['login'];
  $result['result']['phone'] = ($iui->getPhone($_GET['login'],
					       'plan'));
  return ($result);
}

function	ws_get_infos($result)
{
  global	$iui;

  if (!(check_params($result, array('login'))))
    return ($result);
  $result['result']['login'] = $_GET['login'];
  $result['result']['uid'] = ($iui->getUid($_GET['login']));
  $result['result']['name'] = ($iui->getName($_GET['login']));
  $result['result']['group'] = ($iui->getGroup($_GET['login']));
  $result['result']['school'] = ($iui->getSchool($_GET['login']));
  $result['result']['promo'] = ($iui->getPromo($_GET['login']));
  $result['result']['city'] = ($iui->getCity($_GET['login']));
  $result['result']['report_url'] = ($iui->getReportUrl($_GET['login']));
  $result['result']['photo_url'] = ($iui->getPhotoUrl($_GET['login']));
  $result['result']['plan'] = ($iui->getPlan($_GET['login'], 'plan'));
  $result['result']['phone'] = ($iui->getPhone($_GET['login'], 'plan'));
  return ($result);
}

function	ws_search($result)
{
  global	$iui;

  if (!(check_params($result, array('query'))))
    return ($result);
  if (isset($_GET['limit'])) {
    $limit = intval($_GET['limit']);
    $result['result'] = $iui->search($_GET['query'], $limit);
  } else {
    $result['result'] = $iui->search($_GET['query']);
  }
  return ($result);
}

function	ws_get_logins($result)
{
  global	$iui;

  $result['result'] = $iui->getLogins($_GET['school'], $_GET['promo'], $_GET['city']);
  return ($result);
}

function	ws_get_schools($result)
{
  global	$iui;

  $result['result'] =
    $iui->getSchools(((isset($_GET['from_database'])
		       && $_GET['from_database']) ?
		      true : false));
  return ($result);
}

function	ws_get_cities($result)
{
  global	$iui;

  if (isset($_GET['school']))
    $result['result'] = $iui->getCities($_GET['school']);
  else
    $result['result'] = $iui->getCities();
  return ($result);
}

function	ws_get_promos($result)
{
  global	$iui;

  if (isset($_GET['school']))
    $result['result'] =
      $iui->getPromos($_GET['school'],
		      ((isset($_GET['from_database'])
			&& $_GET['from_database']) ?
		       true : false));
  else
    $result['result'] =
      $iui->getPromos('epitech',
		      ((isset($_GET['from_database'])
			&& $_GET['from_database']) ?
		       true : false));
  return ($result);
}

// Take the name of the cast parent, return the tree of childrens

function	ws_get_casts($result)
{
  default_params(array('root' => 'root'));
  if (!(check_params($result, array('root'))))
    return ($result);
  $bdd = cast_bdd();
  $casts = new CastManager($bdd, $_GET['root']);
  $result['result'] = $casts->getCastsArray();
  return $result;
}

function	ws_get_casts_tree($result)
{
  global $format;
  if ($format == 'ini')
    return ws_get_casts($result);

  default_params(array('root' => 'root'));
  if (!(check_params($result, array('root'))))
    return ($result);
  $bdd = cast_bdd();
  $casts = new CastManager($bdd, $_GET['root']);
  $result['result'] = $casts->getSimpleTree();
  return $result;
}

function	ws_get_cast_members($result)
{
  if (!(check_params($result, array('cast'))))
    return ($result);
  $bdd = cast_bdd();
  $casts = new CastManager($bdd, $_GET['cast'], false);
  $result['result'] = $casts->getCastMembers($_GET['cast']);
  return $result;
}
