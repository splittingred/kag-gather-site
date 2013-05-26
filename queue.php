<?php
require_once dirname(__FILE__).'/lib/Stats.php';
require_once dirname(__FILE__).'/lib/Site.php';
$site = new Site();

$s = '';
$rs = array();
$stats = new Stats();
$response = $stats->get('queue',array(),false);

$site->render('queue.html',array(
    'queue' => $response['object'],
    'players' => $response['object']['players'],
    'matches' => $response['object']['matches'],
));
