<?php
require_once dirname(__FILE__).'/lib/Site.php';
$site = new Site();

$site->render('rules.html',array(
));