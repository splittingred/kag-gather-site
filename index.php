<?php
require_once dirname(__FILE__).'/lib/Site.php';
$site = new Site();


ob_start();
$number = "5";
include "cutenews/show_news.php";
$news = ob_get_contents();
ob_end_clean();


$site->render('index.html',array(
    'news' => $news,
));