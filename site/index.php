<?php
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Ionis-Users-Informations : Get informations about Ionis students</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/x-icon" href="img/fav.ico" /> 
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body>

    <div class="topbar">
      <div class="fill">
        <div class="container">
          <a class="brand" href="http://ionis-users-informations.paysdu42.fr/">Ionis Users Informations</a>
          <ul class="nav">
            <li><a href="ws.html">Web Service</a></li>
            <li><a href="https://github.com/db0company/Ionis-Users-Informations" target="_blank">Sources on GitHub</a></li>
            <li><a href="who.html">Who's using it?</a></li>
            <li class="active"><a href=".">Example</a></li>
            <li><a href="contact.php">Contact</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container">

      <div class="content">
        <div class="page-header">
          <h1>« Peuple » <small>- An example of usage of IUI</small></h1>
        </div>

<?php // '
include_once('../ws/load.php');

function	show_gpa($login)
{
  global	$iui;

  $gpamod = intval($_POST['gpamodule']);
  if (($gpamod != 0 && $gpamod < 2007) || $gpamod > intval(@date('Y')))
    {
      echo '<div class="alert">Invalid date.</div>',
	'<a href="."><button class="btn">« Back to the form</button></a>';
      return ;
    }
  echo '<h5>Year : ',($gpamod ? $gpamod.'-'.($gpamod + 1) : 'All'),'</h5>';

  define('INTRA_BETWEEN_TRANSAC', 0.1);
  define('INTRA_URL_MAIN',                'http://www.epitech.eu/intra/');
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

  echo '<h3>',$iui->getName($login),', your GPA is : ',number_format($gpa, 3),'</h3>';

  if ($_POST['modshow'])
    {
      echo '<table class="table table-striped table-bordered table-condensed">';
      echo '<tr>';
      echo '<th>Name</th>';
      echo '<th>Credits</th>';
      echo '<th>Status</th>';
      echo '</tr>';
      foreach ($modules as $module)
	{
	  echo '<tr>';
	  echo '<td>',$module[1],'</td>';
	  echo '<td>',$module[3],'</td>';
	  echo '<td>',$module[5],'</td>';
	  echo '</tr>';
	}
      echo '</table>';
    }
  echo '<a href="."><button class="btn">« Back to the form</button></a>';
}

function	show_informations($login)
{
  global	$iui;

  echo '
	  <h3>Informations about : '.$login.'</h3>';
  if (($photo = $iui->getPhotoUrl($login)) == '')
    $photo = 'http://www.epitech.eu/intra/photos/no.jpg';
  echo '<div class="well" style="float: right;">',
    '<a href="',$iui->getReportUrl($login),'" class="thumbnail">',
    '<img src="'.$photo.'"/></a></div>';
  echo '
     <div class="exampletab">
      <table class="table table-condensed">
        <tr>
          <th>Login</th>
	  <td>',$login,'</td>
        </tr>
        <tr>
          <th>Uid</th>
	  <td>',$iui->getUid($login),'</td>
        </tr>
        <tr>
          <th>Name</th>
	  <td>',$iui->getName($login),'</td>
        </tr>
        <tr>
          <th>Group</th>
	  <td>',$iui->getGroup($login),'</td>
        </tr>
	<tr>
          <th>School</th>
	  <td>',$iui->getSchool($login),'</td>
        </tr>
        <tr>
          <th>Promo</th>
	  <td>',$iui->getPromo($login),'</td>
        </tr>
        <tr>
          <th>City</th>
	  <td>',$iui->getCity($login),'</td>
        </tr>
        <tr>
          <th>Intranet Report</th>
	  <td><a href="'.$iui->getReportUrl($login).'">link</a></td>
        </tr>

      </table>
     </div>
  <h5>.Plan</h5>
';
  
  if (($plan = $iui->getPlan($login, 'plan')) != '')
    echo '<pre>'.$plan.'</pre>';
  else
    echo '<div class="alert">.plan file not found</div>';
  echo '<a href="."><button class="btn">« Back to the form</button></a>';
}

function	show_form()
{
  echo '
    <h3>Get Informations about Ionis Users</h3>
    <form method="post">';
  if (!isset($_SESSION['login']))
    echo '    <label for="login">My Login </label>
      <input type="text" name="login" value="" /><br />
      <label for="pass">My PPP Pass </label>
      <input type="password" name="pass" value="" /><br />';
  echo '      <label for="pass">Informations about user</label>
      <input type="text" name="infos" value="" /><br />
      <input type="submit" name="info" value="OK" class="btn" style="margin-left: 480px;" /><br />
      <h3>Calculate my G.P.A</h3>
      <p>This feature is verry slow. It takes more than 1 minute to calculate. Use it sparingly.';
  if (!isset($_SESSION['login']))
    echo '<br />
         Fill the login and pass from the form above.';
  echo '</p>
      <input type="checkbox" name="modshow" /> Show modules details<br />
      <select name="gpamodule">';
  for ($i = @date('Y') - 1; $i > 2007; --$i)
    echo '<option value="',$i,'">',$i,'-',($i+1),'</option>'."\n";
  echo '<option value="0">All</option>
      </select>
      <input type="submit" name="gpa" value="Calculate!" class="btn" /><br />
    </form>
';
}

if ($_SERVER['SERVER_PORT'] != 443)
  echo '<a href="https://return.epitech.eu/ws/site/"><button class="btn" style="float: right;"><img src="img/secure.gif" /> Use HTTPS (Secure)</button></a>';
if (isset($_SESSION['login']))
  echo '<a href="?logout"><button class="btn" style="float: right;">Logout</button></a>';
if (isset($_GET['logout']))
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
      show_gpa($login);
    else
      {
	if (empty($_POST['infos']) && !isset($_POST['info']) && !isset($first))
	  show_form();
	else
	  {
	    if (!empty($_POST['infos']))
	      $login = $_POST['infos'];
	    if (!$iui->isLogin($login))
	      echo '<div class="alert">Unknown login.</div>',
		'<a href="."><button class="btn">« Back to the form</button></a>';
	    else
	      show_informations($login);
	  }
      }
  }
 else
   show_form();
?>

      </div>
      <footer>
        <p>
	  <br />
	  Ionis-Users-Informations is developped and maintained by 
	  <a href="http://db0.fr">Barbara Lepage</a>. It is "protected" by the 
	  <a href="http://en.wikipedia.org/wiki/WTFPL" target="_blank">WTF Public License</a>.<br />
	  Please <a href="contact.php">contact me</a> if you have any question about this service
	  or if you want to be in the "<a href="who.html">Who's using it?</a>" page.<br />
	  Sources of the project on 
	  <a href="https://github.com/db0company/Ionis-Users-Informations">GitHub</a>.
	  Sources of this website are also available on
	  <a href="https://github.com/db0company/Ionis-Users-Informations-Web-Service">GitHub</a>.
	  <br />
	  <br />
	</p>
      </footer>

    </div> <!-- /container -->

  </body>
</html>
