<?php
require_once dirname(__FILE__).'/lib/Stats.php';
require_once dirname(__FILE__).'/lib/Site.php';
$site = new Site();

$s = '';
$rs = array();
$stats = new Stats();
$winners = $stats->get('rankings');

$site->render('stats.html',array(
    'ranks' => $winners['results'],
));
