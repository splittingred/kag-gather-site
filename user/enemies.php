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
$data = $stats->get('user',array('username' => $username));
if (empty($data) || empty($data['object'])) {
    header('Location: http://gather.kag2d.nl/'); exit();
}
$user = $data['object'];
$user['created_at'] = strftime('%b %d, %Y',strtotime($user['created_at']));
$placeholders = array_merge(array(),$user);

if (!empty($placeholders['clan_name'])) {
    $placeholders['clan_url'] = urlencode($placeholders['clan_name']);
}


$site = new Site();
$site->render('u/enemies.html',$placeholders,array(
    'skip_header' => true,
    'skip_footer' => true,
));
