<?php
require_once dirname(__FILE__).'/lib/Stats.php';
require_once dirname(__FILE__).'/lib/Site.php';
$site = new Site();

$s = '';
$rs = array();
$stats = new Stats();
$winners = $stats->get('clan');

if (array_key_exists('object',$winners)) {
    foreach ($winners['object'] as $clan) {
        if ($clan['score'] <= 0) continue;
        $tiers = array();
        $ties = explode(',',$clan['name']);
        foreach ($ties as $u) {
            $u = trim($u);
            $tiers[] = array(
                'url' => urlencode(htmlspecialchars(str_replace('#','POUND',$u))),
                'name' => $u,
            );
        }

        $r['clans'] = $tiers;
        $r['score'] = $clan['score'];
        $r['name'] = $clan['name'];
        $rs[] = $r;
    }
}

$site->render('clans.html',array(
    //'stats' => $s,
    'ranks' => $rs,
));
