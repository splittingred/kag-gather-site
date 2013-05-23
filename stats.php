<?php
require_once dirname(__FILE__).'/lib/Stats.php';
require_once dirname(__FILE__).'/lib/Site.php';
$site = new Site();

$s = '';
$rs = array();
$stats = new Stats();
$winners = $stats->get('rankings');

if (array_key_exists('results',$winners)) {
    foreach ($winners['results'] as $user) {
        $tiers = array();
        $ties = explode(',',$user['name']);
        foreach ($ties as $u) {
            $u = trim($u);
            $tiers[] = array(
                'url' => urlencode($u),
                'name' => $u,
            );
        }

        $r['users'] = $tiers;
        $r['score'] = $user['score'];
        $r['name'] = $user['name'];
        $rs[] = $r;
    }
}

$site->render('stats.html',array(
    //'stats' => $s,
    'ranks' => $rs,
));
