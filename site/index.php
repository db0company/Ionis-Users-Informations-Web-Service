
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

if (isset($_POST['login']) && isset($_POST['pass'])
    && $iui->checkPass($_POST['login'], $_POST['pass']))
  {
    if (empty($_POST['infos']))
      $login = $_POST['login'];
    else
      $login = $_POST['infos'];      
    if (!$iui->isLogin($login))
      echo '<div class="alert">Unknown login.</div>',
           '<a href="."><button class="btn">« Back to the form</button></a>';
    else
      {
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
  }
 else
   {
     echo '
    <h3>Get Informations about Ionis Users</h3>
    <form method="post">
      <label for="login">My Login </label>
      <input type="text" name="login" value="" /><br />
      <label for="pass">My PPP Pass </label>
      <input type="password" name="pass" value="" /><br />
      <label for="pass">Informations about user</label>
      <input type="text" name="infos" value="" /><br />
      <input type="submit" value="OK" class="btn" style="margin-left: 480px;" /><br />
    </form>
';
   }
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
