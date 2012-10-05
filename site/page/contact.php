<?php

$title = 'Contact me';
$description = 'If you have any question or if you want to be in the "Who\'s using it?" page';
$no_header = false;

include_once('Mail.php');

function isValidEmail($email) {
  return preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email);
}

function validformsendmail() {
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

      echo 'Mail sent!';
    }
}

validformsendmail();

$content ='
           <form method="post" style="width: 50%; margin-left: 22%;">
             <div class="row-fluid">
	       <div class="span2">
		 <p><i class="icon-user"></i> Login</p>
	       </div>
	       <div class="span10">
		 <input style="width: 100%;" type="text" value="" name="login" /><br />
	       </div>
	     </div>
             <div class="row-fluid">
	       <div class="span2">
		 <p><i class="icon-envelope"></i> E-mail</p>
	       </div>
	       <div class="span10">
		 <input style="width: 100%;" type="text" value="" name="mail" /><br />
	       </div>
	     </div>
             <div class="row-fluid">
	       <div class="span2">
		 <p><i class="icon-chevron-right"></i> Object</p>
	       </div>
	       <div class="span10">
		 <input style="width: 100%;" type="text" value="" name="object" /><br />
	       </div>
	     </div>
             <div class="row-fluid">
	       <div class="span2">
		 <p><i class="icon-pencil"></i> Content
	       </div>
	       <div class="span10">
		 <textarea name="content" class="contact" style="height: 250px; width: 100%;"></textarea>
	       </div>
	     </div>
	     <div class="row-fluid">
	       <div class="pull-right"><input type="submit" class="btn btn-large btn-warning" value="Envoyer" /></div>
	     </div>
	   </form>
';
