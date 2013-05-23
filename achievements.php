<?php
require_once dirname(__FILE__).'/lib/Stats.php';
require_once dirname(__FILE__).'/lib/Site.php';
$site = new Site();

$s = '';
$rs = array();
$stats = new Stats();
$page = !empty($_REQUEST['page']) ? intval($_REQUEST['page'])-1 : 0;
$limit = 25;
$offset = $page * $limit;
$winners = $stats->get('achievement',array(
    'limit' => $limit,
    'start' => $offset,
));

$total = !empty($winners['total']) ? $winners['total'] : 25;
$totalPages = floor($total / $limit);

if (array_key_exists('results',$winners)) {
    foreach ($winners['results'] as $ach) {
        $ach['url'] = urlencode($ach['code']);
        $ach['winners'] = number_format(count($ach['users']));
        $rs[] = $ach;
    }
}


$achievers = array();
$achieversResult = $stats->get('achievers',array(
));
if (array_key_exists('results',$achieversResult)) {
    foreach ($achieversResult['results'] as $ach) {
        $ach['achievements'] = number_format($ach['achievements']);
        $achievers[] = $ach;
    }
}

$recent = array();
$recentResult = $stats->get('achievement/recent',array(
));
if (array_key_exists('results',$recentResult)) {
    foreach ($recentResult['results'] as $ach) {
        $ach['created_at'] = strftime('%b %e, %Y at %I:%S %p',strtotime($ach['created_at']));
        $recent[] = $ach;
    }
}

$site->render('achievements.html',array(
    'achievements' => $rs,
    'achievers' => $achievers,
    'recent' => $recent,
    'total' => $total,
    'currentPage' => $page,
    'totalPages' => $totalPages+1,
));
