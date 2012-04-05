<?php

include_once('Mail.php');

function isValidEmail($email)
{
  return preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email);
}

if (!empty($_POST['content']))
  {
    if (isValidEmail($_POST['mail']))
      $headers['From']    = $_POST['mail'];
    else
      $headers['From']    = 'lepage_b@epitech.eu';      

    $headers['To']      = 'db0company@gmail.com';

    $headers['Subject'] = '[WebService IUI] '.$_POST['object'];

    $content = utf8_encode('Login : '.$_POST['login'].'<br>'.
			   str_replace("\n", '<br>', $_POST['content']));
    $headers['Content-Type'] = "text/html; charset=\"UTF-8\"";
    $headers['Content-Transfer-Encoding'] = "8bit";
    
    $params['sendmail_path'] = '/usr/lib/sendmail';
  
    $mail_object =& Mail::factory('sendmail', $params);
    
    $mail_object->send($headers['To'], $headers, $content);

  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Ionis-Users-Informations : Get informations about Ionis students :: Contact</title>
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
          <a class="brand" href="..">Ionis Users Informations</a>
          <ul class="nav">
            <li><a href="ws.html">Web Service</a></li>
            <li><a href="https://github.com/db0company/Ionis-Users-Informations" target="_blank">Sources on GitHub</a></li>
            <li><a href="who.html">Who's using it?</a></li>
            <li><a href=".">Example</a></li>
            <li class="active"><a href="contact.php">Contact</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container">

      <div class="content">
        <div class="page-header">
          <h1>Contact me <small>- If you have any question or if you want to be in the "Who's using it?" page</small></h1>
        </div>

	<div class="row">
	  <div class="span4">
	    <div class="contact_label"><img src="img/user.gif" /> Login</div>
	    <div class="contact_label"><img src="img/email.gif" /> E-mail</div>
	    <div class="contact_label"><img src="img/title.gif" /> Object</div>
	  </div>
	  <div class="span8">
	    <form method="post">
	      <input class="contact" type="text" value="" name="login" /><br />
	      <input class="contact" type="text" value="" name="mail" /><br />
	      <input class="contact" type="text" value="" name="object" /><br />
	      <textarea name="content" class="contact" style="height: 250px;"></textarea>
	      <div class="right"><input type="submit" class="btn" value="Envoyer" /></div>
	    </form>
	  </div>
	</div>

      </div> <!-- /content -->

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
