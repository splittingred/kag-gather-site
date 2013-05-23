<?php
require_once dirname(dirname(__FILE__)).'/lib/Stats.php';
require_once dirname(dirname(__FILE__)).'/lib/Cache.php';
require_once dirname(dirname(__FILE__)).'/lib/Translator.php';
require_once dirname(dirname(__FILE__)).'/lib/Site.php';

if (empty($_REQUEST['s'])) {
    header('Location: http://gather.kag2d.nl/'); exit();
}
$stat = $_REQUEST['s'];

$cache = new Cacher();
$stats = new Stats();
$data = $stats->get('clan_stat',array('name' => $stat));
if (empty($data) || empty($data['results'])) {
    header('Location: http://gather.kag2d.nl/'); exit();
}
$placeholders = array_merge(array(),$data);
$placeholders['key'] = $placeholders['name'];
$placeholders['name'] = T::translate($placeholders['name']);

$site = new Site();
$site->render('cstat/index.html',$placeholders);
