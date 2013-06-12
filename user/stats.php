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

ksort($user['stats']);
$s = '';
$list = array();
$st = array();
$ranks = array();
foreach ($user['stats'] as $k => $stat) {
    $list[] = array(
        'name' => T::translate($k),
        'value' => intval($stat['times']),
    );
    $st[str_replace('.','_',$k)] = intval($stat['times']);
    $ranks[str_replace('.','_',$k)] = intval($stat['rank']);
}
$placeholders['stat_list'] = $list;
$placeholders['stats'] = $st;
$placeholders['ranks'] = $ranks;
if (!empty($placeholders['clan_name'])) {
    $placeholders['clan_url'] = urlencode($placeholders['clan_name']);
}

$site = new Site();
$site->render('u/stats.html',$placeholders,array(
    'skip_header' => true,
    'skip_footer' => true,
));
