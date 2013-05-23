<?php
require_once dirname(dirname(__FILE__)).'/lib/Stats.php';
require_once dirname(dirname(__FILE__)).'/lib/Cache.php';
require_once dirname(dirname(__FILE__)).'/lib/Translator.php';
require_once dirname(dirname(__FILE__)).'/lib/Site.php';

if (empty($_REQUEST['c'])) {
    header('Location: http://gather.kag2d.nl/'); exit();
}
$name = urldecode(htmlspecialchars_decode(str_replace('POUND','#',$_REQUEST['c'])));

$cache = new Cacher();
$stats = new Stats();
$data = $stats->get('clan',array('name' => $name));

if (empty($data) || empty($data['object'])) {
    header('Location: http://gather.kag2d.nl/'); exit();
}
$clan = $data['object'];
$clan['created_at'] = strftime('%b %d, %Y',strtotime($clan['created_at']));
$placeholders = array_merge(array(),$clan);

ksort($clan['stats']);
$s = '';
$list = array();
$st = array();
$ranks = array();
foreach ($clan['stats'] as $k => $stat) {
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

$placeholders['user_list'] = array();
foreach ($clan['users'] as $user) {
    $r['score'] = $user['score'];
    $r['name'] = $user['name'];
    $r['url'] = urlencode($user['name']);
    $placeholders['user_list'][] = $r;
}

$site = new Site();
$site->render('clan/index.html',$placeholders);
