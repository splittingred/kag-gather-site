<?php
require_once dirname(dirname(__FILE__)).'/lib/Stats.php';
require_once dirname(dirname(__FILE__)).'/lib/Cache.php';
require_once dirname(dirname(__FILE__)).'/lib/Translator.php';
require_once dirname(dirname(__FILE__)).'/lib/Site.php';

function mostFrequent($x) {
    $counted = array_count_values($x);
    arsort($counted);
    return key($counted);
}

if (empty($_REQUEST['id'])) {
    header('Location: http://gather.kag2d.nl/'); exit();
}
$id = intval($_REQUEST['id']);

$cache = new Cacher();
$stats = new Stats();
$data = $stats->get('gather_match',array('id' => $id));
if (empty($data) || empty($data['object'])) {
    header('Location: http://gather.kag2d.nl/'); exit();
}
$placeholders = array_merge(array(),$data['object']);
$placeholders['created_at'] = strftime('%b %d, %Y at %I:%M %p',strtotime($placeholders['created_at']));

$ws = array();
foreach ($placeholders['stats']['wins'] as $team => $wins) {
    for ($i=0;$i<$wins;$i++) array_push($ws,$team);
}
$placeholders['stats']['winner'] = mostFrequent($ws);

$site = new Site();
$site->render('match/index.html',$placeholders,array(
    'skip_header' => true,
    'skip_footer' => true,
));
