<?php
require_once dirname(dirname(__FILE__)) . '/lib/Stats.php';
require_once dirname(dirname(__FILE__)) . '/lib/Cache.php';
require_once dirname(dirname(__FILE__)) . '/lib/Translator.php';
require_once dirname(dirname(__FILE__)) . '/lib/Site.php';

if (empty($_REQUEST['u'])) {
    header('Location: http://gather.kag2d.nl/'); exit();
}
$username = $_REQUEST['u'];

$cache = new Cacher();
$stats = new Stats();
$data = $stats->get('user/achievement',array('username' => $username));
if (empty($data) || empty($data['results'])) {
    header('Location: http://gather.kag2d.nl/'); exit();
}
$placeholders = array(
    'achievements' => $data['results'],
    'total' => $data['total'],
    'all_total' => $data['all_total'],
);

$site = new Site();
$site->render('u/achievements.html',$placeholders,array(
    'skip_header' => true,
    'skip_footer' => true,
));
