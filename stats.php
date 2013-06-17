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
$result = $stats->get('rankings',array(
    'limit' => $limit,
    'offset' => $offset,
));
$total = !empty($result['total']) ? $result['total'] : 20;
$totalPages = floor($total / $limit);

$site->render('stats.html',array(
    'ranks' => $result['results'],
    'total' => intval($result['total']),
    'page_offset' => $offset,
    'currentPage' => $page,
    'totalPages' => $totalPages+1,
));
