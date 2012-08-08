<?php

include_once('include/header.php');
include_once('include/news.php');

$title = get_title();
$description = 'From a simple login, get all informations about students in Ionis group!';
$no_header = true;

$schools = array('epitech' => 'Epitech',
		 'epita' => 'Epita',
		 'eartsup' => 'e-art sup',
		 'supinternet' => 'Sup\'internet',
		 'webacademie' => 'Web@cademie',
                 'isbp' => 'Isbp',
		 'etna' => 'Etna',
		 'ipsa' => 'Ipsa');

$infos = array('Login',
	       'Uid',
	       'Group',
	       'School',
	       'Promo',
	       'City',
	       'Intranet Report URL',
	       'Photo',
	       '.Plan file',
	       'Phone number',
	       'Modules (Epitech)',
	       'Marks (Epitech)',
	       'GPA (Epitech)',
	       '...',
	       '...',
	       '...',
	       );

$content = '

   <div class="row-fluid">
     <div class="span9">
       <div class="hero-unit">
	 <div class="row-fluid">
	   <div class="span6">
	     <h1 style="margin-bottom: 4%;">'. $title. '</h1>
	     <p>'. $description. '</p>
	     <p style="padding-left: 5%; margin-top: 4%;">
	       '.menu_link(get_menu_elem('peuple')).
	       '<button class="btn-info btn-large">A service</button></a>
	       '.menu_link(get_menu_elem('ws')).
               '<button class="btn-primary btn-large">A Web Service</button></a>
	       '.menu_link(get_menu_elem('php')).
               '<button class="btn btn-large">A PHP Class</button></a>
            </div>
	   <div class="span6">
	   <img src="img/logo_iui.png">
	   </div>
	 </div>
       </div>

       <div class="row-fluid">
         <div class="span4">
	   <img src="img/users-icon.png" alt="users icon" style="width: 80px; float: right;" />
           <h2>« Peuple »</h2>
	   <p>
	     Human usable service to quickly get informations
	     about student.
	     <ul>
	       <li>Need to call a friend but you don\'t have his number?</li>
	       <li>Need to calculate your GPA?</li>
	       <li>Need to see someone\'s face?</li>
	       <li>Need to get informations but the intranet is down?</li>
	     </ul>
	   </p>
           <p>'.menu_link(get_menu_elem('peuple')).'<button class="btn">» Try Peuple!</button></a></p>
         </div>
         <div class="span4">
	   <img src="img/puzzle-icon.png" alt="Web-Service" style="float: right;" />
           <h2>Web Service</h2>
           <p>If you want to code your own tool that would need information
	     and want it to be always up to date, you can use the web service
	     from any language. It can provide many different data formats
	     and is easily usable.</p>
           <p>'.menu_link(get_menu_elem('ws')).'<button class="btn">» Documentation, sources</button></a></p>
	 </div>
         <div class="span4">
	   <img src="img/php-icon.png" alt="PHP logo elephant" style="float: right;" />
           <h2>PHP Class</h2>
	   <p>If you want to code your own tool in PHP that would require
	     information about users Ionis, you can use this PHP class.
	     It does not require much and makes all the retrieval of
	     informations for you. Please consider that you will have
	     to manage the updating of informations by yourself.</p>
           <p>'.menu_link(get_menu_elem('php')).'<button class="btn">» Documentation, sources and download</button></a></p>
	 </div>
       </div>
       <hr />
       <center><h2>Available Informations</h2></center>
       <hr />
       <div class="row-fluid">
';
$i = 1;
foreach ($infos as $info) {
  $content .= '<div class="span3">'.$info.'</div>';
  if (!($i % 4))
    $content .= '</div><div class="row-fluid">';
  $i++;
}

$content .= '</div>
       <hr />
       <center><h2>Ionis Institute Of Technology Schools</h2></center>
       <hr />
       <div class="row-fluid">
';
	 $i = 0;
	 foreach ($schools as $img => $name) {
           if ($i && !($i % 4))
             $content .= '</div><hr /><br />'."\n".'<div class="row-fluid">'."\n";
	   $content .= '<div class="span3">'."\n";
           if (file_exists('img/'.$img.'-logo.png'))
	     $content .= '<img src="img/'.$img.'-logo.png" />'."\n";
           else
	     $content .= $name;
	   $content .= '</div>'."\n";
	   $i++;
	 }

$content .= '</div>
     </div>
     <div class="span3" style="border-left: 1px solid #EEE; padding-left: 1%;">
       <a href="?rss"><img src="img/rss-icon.png" style="float: right;" alt="RSS Feed" /></a>
       <h3 id="news">News</h3>
       <hr />
<ul class="pager">
  <li class="previous" id="previous" style="display: none;">
    <a href="#" onClick="change_news(-1); return false;">&larr; Newer</a>
  </li>
  <li class="next" id="next">
    <a href="#" onClick="change_news(1); return false;">Older &rarr;</a>
  </li>
</ul>
<div id="news0" class="new">
';
$i = 0;
$iddiv = 1;
foreach ($newsfeed as $date => $info) {
  if ($i && !($i % 5)) {
    $content .= '</div><div class="new" id="news'.$iddiv.'" style="display: none;">';
    $iddiv++;
  }
  $content .= '<h6>'.$date.'</h6>'."\n".
    '<p>'.$info.'</p>'."\n".
    '<hr />'."\n";
  $i++;
}

$content .= '
     </div>
</div>
   </div>	
</div>
';

