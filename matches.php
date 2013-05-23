<?php
require_once dirname(__FILE__).'/lib/Stats.php';
require_once dirname(__FILE__).'/lib/Site.php';
$site = new Site();

$s = '';
$rs = array();
$stats = new Stats();
$page = !empty($_REQUEST['page']) ? intval($_REQUEST['page'])-1 : 0;
$limit = 20;
$offset = $page * $limit;

$result = $stats->get('gather_match',array(
    'limit' => $limit,
    'offset' => $offset,
));
$total = !empty($result['total']) ? $result['total'] : 20;
$totalPages = floor($total / $limit);

if (array_key_exists('results',$result)) {
    foreach ($result['results'] as $match) {
        $match['created_at'] = strftime('%b %d, %Y at %I:%M %p',strtotime($match['created_at']));
        $rs[] = $match;
    }
}

$site->render('matches.html',array(
    'matches' => $rs,
    'total' => $total,
    'currentPage' => $page,
    'totalPages' => $totalPages+1,
));
