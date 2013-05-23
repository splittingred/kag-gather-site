<?php
require_once dirname(dirname(__FILE__)).'/lib/Stats.php';
require_once dirname(dirname(__FILE__)).'/lib/Cache.php';
require_once dirname(dirname(__FILE__)).'/lib/Site.php';

if (empty($_REQUEST['a'])) {
    header('Location: http://gather.kag2d.nl/'); exit();
}
$code = $_REQUEST['a'];

$cache = new Cacher();
$stats = new Stats();
$data = $stats->get('achievement',array('code' => $code));
if (empty($data) || empty($data['object'])) {
    die('Failed to get achievement data: '.print_r($data,true));
    header('Location: http://gather.kag2d.nl/'); exit();
}

$placeholders = array_merge(array(),$data['object']);
foreach ($placeholders['users'] as &$user) {
    $user['value'] = number_format($user['value']);
}
$site = new Site();
$site->render('achievement/index.html',$placeholders);
