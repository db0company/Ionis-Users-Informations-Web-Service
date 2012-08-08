<?php

$title = '« Peuple »';
$description = 'The human-usable version of Ionis-Users-Informations';

include_once('../ws/load.php');

function	show_gpa($iui, $content, $login)
{
  $gpamod = intval($_POST['gpamodule']);
  if (($gpamod != 0 && $gpamod < 2007) || $gpamod > intval(@date('Y')))
    {
      $content .= '<div class="alert">Invalid date.</div>'.
	'<a href="?peuple"><button class="btn">« Back to the form</button></a>';
      return ;
    }
  $content .= '<h5>Year : '.($gpamod ? $gpamod.'-'.($gpamod + 1) : 'All').'</h5>';

  define('INTRA_BETWEEN_TRANSAC', 0.1);
  define('INTRA_URL_MAIN',                'https://www.epitech.eu/intra/');
  define('INTRA_USERAGENT',               'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.835.186 Safari/535.1');
  $iui->intra_login();
  if (!$gpamod)
    {
      $modules = array();
      for ($i = 2007; $i < (intval(@date('Y')) - 0); ++$i)
	{
	  $gpamod = $i.'-'.($i+1);
	  $tmp = $iui->fetch_modules($login, $gpamod);
	  if (!empty($tmp))
	    $modules = array_merge($tmp, $modules);
	}
    }
  else
    {
      $gpamod = $gpamod.'-'.($gpamod + 1);
      $modules = $iui->fetch_modules($login, $gpamod);
    }
  if (!empty($modules))
    $gpa = $iui->calc_gpa($modules);

  $content .= '<h3>'.$iui->getName($login).'. your GPA is : '.number_format($gpa, 3).'</h3>';

  if ($_POST['modshow'] && !empty($modules))
    {
      $content .= '<table class="table table-striped table-bordered table-condensed">';
      $content .= '<tr>';
      $content .= '<th>Name</th>';
      $content .= '<th>Credits</th>';
      $content .= '<th>Status</th>';
      $content .= '</tr>';
      foreach ($modules as $module)
	{
	  $content .= '<tr>';
	  $content .= '<td>'.$module[1].'</td>';
	  $content .= '<td>'.$module[3].'</td>';
	  $content .= '<td>'.$module[5].'</td>';
	  $content .= '</tr>';
	}
      $content .= '</table>';
    }
  $content .= '<a href="?peuple"><button class="btn">« Back to the form</button></a>';
  return $content;
}

function	show_informations($iui, $content, $login) {
  $content .= '
	  <h3>Informations about : '.$login.'</h3>
         <div class="row-fluid">';
  $content .= '
     <div class="span8">
      <table class="table table-striped table-bordered">
        <tr>
          <th>Login</th>
	  <td>'.$login.'</td>
        </tr>
        <tr>
          <th>Uid</th>
	  <td>'.$iui->getUid($login).'</td>
        </tr>
        <tr>
          <th>Name</th>
	  <td>'.$iui->getName($login).'</td>
        </tr>
        <tr>
          <th>Group</th>
	  <td>'.$iui->getGroup($login).'</td>
        </tr>
	<tr>
          <th>School</th>
	  <td>'.$iui->getSchool($login).'</td>
        </tr>
        <tr>
          <th>Promo</th>
	  <td>'.$iui->getPromo($login).'</td>
        </tr>
        <tr>
          <th>City</th>
	  <td>'.$iui->getCity($login).'</td>
        </tr>
        <tr>
          <th>Intranet Report</th>
	  <td><a href="'.$iui->getReportUrl($login).'">link</a></td>
        </tr>
        <tr>
          <th>Phone</th>
	  <td>'.$iui->getPhone($login. 'plan').'</td>
        </tr>

      </table>
     </div>';
  if (($photo = $iui->getPhotoUrl($login)) == '')
    $photo = 'http://www.epitech.eu/intra/photos/no.jpg';
  $content .= '<div class="well span4" style="text-align: center;">'.
    '<a href="'.$iui->getReportUrl($login).'">'.
    '<img src="'.$photo.'"/></a></div>';
$content .= '</div>
  <h5>.Plan</h5>
';
  
  if (($plan = $iui->getPlan($login, 'plan')) != '')
    $content .= '<pre>'.$plan.'</pre>';
  else
    $content .= '<div class="alert">.plan file not found</div>';
  $content .= '<a href="?peuple"><button class="btn">« Back to the form</button></a>';
  return $content;
}

function	show_form($content)
{
  $content .= '
    <form method="post">';
  if (!isset($_SESSION['login']))
    $content .= '
  <div class="well">
    <h3>Login</h3>
      <div class="row-fluid">
        <div class="span4">
          <label for="login">My Login </label>
        </div>
        <div class="span8">
          <input type="text" name="login" value="" /><br />
        </div>
      </div>
      <div class="row-fluid">
        <div class="span4">
          <label for="pass">My PPP Pass </label>
        </div>
        <div class="span8">
          <input type="password" name="pass" value="" /><br />
        </div>
      </div></div>';

  $content .= '      <div class="well">
    <h3>Get Informations about Ionis Users</h3>';
  if (!isset($_SESSION['login']))
    $content .= '<p><i>Fill the login and pass from the form above.</i></p>';
  $content .= '<div class="row-fluid">
        <div class="span4">
          <label for="pass">Informations about user</label>
        </div>
        <div class="span8">
          <input type="text" name="infos" value="" /><br />
        </div>
      </div>
      <input type="submit" name="info" value="OK" class="btn" style="margin-left: 480px;" /><br />
      </div><div class="well">
      <h3>Calculate my G.P.A</h3>
      <p>This feature is verry slow. It takes more than 1 minute to calculate. Use it sparingly.';
  if (!isset($_SESSION['login']))
    $content .= '<br />';
  if (!isset($_SESSION['login']))
    $content .= '<p><i>Fill the login and pass from the form above.</i></p>';
  $content .= '</p>
      <input type="checkbox" name="modshow" /> Show modules details<br />
      <select name="gpamodule">';
  for ($i = @date('Y') - 1; $i > 2007; --$i)
    $content .= '<option value="'.$i.'">'.$i.'-'.($i+1).'</option>'."\n";
  $content .= '<option value="0">All</option>
      </select>
      <input type="submit" name="gpa" value="Calculate!" class="btn" /><br />
    </form>
  </div>
';
  return $content;
}

if ($_SERVER['SERVER_PORT'] != 443)
  $content .= '<a href="https://return.epitech.eu/ws/site/"><button class="btn" style="float: right;"><img src="img/secure.gif" /> Use HTTPS (Secure)</button></a>';
if (isset($_SESSION['login']))
  $content .= '<form method="post"><input type="submit" class="btn" name="logout" value="Logout" style="float: right;" /></form>';
if (isset($_POST['logout']))
  unset($_SESSION['login']);

if (isset($_SESSION['login']) ||
    (isset($_POST['login']) && isset($_POST['pass'])
     && $iui->checkPass($_POST['login'], $_POST['pass'])))
  {
    if (!isset($_SESSION['login']))
      {
	$login = $_SESSION['login'] = $_POST['login'];
	$first = true;
      }
    $login = $_SESSION['login'];
    if (isset($_POST['gpa']))
      $content = show_gpa($iui, $content, $login);
    else
      {
	if (empty($_POST['infos']) && !isset($_POST['info']) && !isset($first))
	  $content = show_form($content);
	else
	  {
	    if (!empty($_POST['infos']))
	      $login = $_POST['infos'];
	    if (!$iui->isLogin($login))
	      $content .= '<div class="alert">Unknown login.</div>'.
		'<a href="?peuple"><button class="btn">« Back to the form</button></a>';
	    else
	      $content = show_informations($iui, $content, $login);
	  }
      }
  }
 else
   $content = show_form($content);
