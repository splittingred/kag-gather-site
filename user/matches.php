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
$data = $stats->get('user/match',array(
    'username' => $username,
));
if (empty($data) || empty($data['results'])) {
    //header('Location: http://gather.kag2d.nl/'); exit();
}

foreach ($data['results'] as &$m) {
    $m['created_at'] = strftime('%b %d, %Y at %I:%M %p',strtotime($m['created_at']));
}

$placeholders = array(
    'matches' => $data['results'],
    'total' => $data['total'],
    'all_total' => $data['all_total'],
);

$site = new Site();
$site->render('u/matches.html',$placeholders,array(
    'skip_header' => true,
    'skip_footer' => true,
));
