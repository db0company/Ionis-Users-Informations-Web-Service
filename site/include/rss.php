<?php

function	display_rss() {
  include('include/news.php');
  include("feedwriter/FeedWriter.php");
  $iuiFeed = new FeedWriter(RSS2);
  $iuiFeed->setTitle('Ionis Users Informations RSS feed');
  $iuiFeed->setLink('http://ionis-users-informations.paysdu42.fr/');
  $iuiFeed->setDescription('From a simple login, get all informations about students in Ionis group!');
  $iuiFeed->setImage('Testing the RSS writer class',
  		     'http://ionis-users-informations.paysdu42.fr/?rss',
  		     'http://ionis-users-informations.paysdu42.fr/Ionis-Users-Informations-Web-Service/site/img/iui_icon.png');
  if ($newsfeed)
    foreach ($newsfeed as $date => $new) {
      $item = $iuiFeed->createNewItem();
      $item->setTitle($date);
      $item->setLink('http://ionis-users-informations.paysdu42.fr/');
      $item->setDate($date);
      $item->setDescription($new);
      $iuiFeed->addItem($item);
    }
   $iuiFeed->generateFeed();
}
