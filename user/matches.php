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
$page = !empty($_REQUEST['page']) ? intval($_REQUEST['page'])-1 : 0;
$limit = 25;
$offset = $page * $limit;
$data = $stats->get('user/match',array(
    'username' => $username,
    'limit' => $limit,
    'offset' => $offset,
));
if (empty($data) || empty($data['results'])) {
    return '';
}

$total = !empty($data['total']) ? $data['total'] : 25;
$totalPages = floor($total / $limit);

foreach ($data['results'] as &$m) {
    $m['created_at'] = strftime('%b %d, %Y at %I:%M %p',strtotime($m['created_at']));
}

$placeholders = array(
    'matches' => $data['results'],
    'total' => $data['total'],
    'all_total' => $data['all_total'],
    'username' => $username,
    'page' => $page,
    'currentPage' => $page,
    'totalPages' => $totalPages+1,
);

$site = new Site();
$site->render('u/matches.html',$placeholders,array(
    'skip_header' => true,
    'skip_footer' => true,
));
