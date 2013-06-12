<?php
error_reporting(E_ALL); ini_set('display_errors',true);
require_once dirname(__FILE__).'/Twig/lib/Twig/Autoloader.php';
require_once dirname(__FILE__).'/Twig/lib/Twig/ExtensionInterface.php';
require_once dirname(__FILE__).'/Twig/lib/Twig/Extension.php';

class Site {
    /** @var \Twig_Environment $twig */
    public $twig;

    public function __construct() {
        Twig_Autoloader::register();

        $loader = new Twig_Loader_Filesystem(dirname(dirname(__FILE__)).'/templates');
        $this->twig = new Twig_Environment($loader, array(
            'cache' => dirname(dirname(__FILE__)).'/cache/twig/',
            'auto_reload' => true,
            'debug' => true,
        ));
        $this->twig->addExtension(new RadiusExtension());
    }

    public function render($page,array $values = array(),array $options = array()) {
        $isSsl = ((isset ($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') || $_SERVER['SERVER_PORT'] == 443);
        $urlScheme=  $isSsl ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME']),'/').'/';
        $full = $urlScheme.$host.$base;

        $values['http_host'] = $host;
        $values['url_scheme'] = $urlScheme;
        $values['site_url'] = $full;
        $values['top_url'] = $urlScheme.$host;
        $values['base_href'] = $base;
        $values['base_url'] = rtrim($values['top_url'],'/').'/';
        $values['full_url'] = rtrim($values['base_url'],'/').$_SERVER['PHP_SELF'];


        if (empty($options['skip_header'])) echo $this->twig->render('_header.html',$values);
        echo $this->twig->render($page,$values);
        if (empty($options['skip_footer'])) echo $this->twig->render('_footer.html',$values);
    }
}

class RadiusExtension extends \Twig_Extension {
    public function getFunctions() {
        return array(
            'radius' => new \Twig_Function_Method($this,'computeRadius'),
        );
    }
    public function computeRadius($cntr,$radius,$maxPage) {
        $low = ($cntr - $radius > 1) ? $cntr - $radius : 1;
        $hi = $radius + $cntr;
        if ($hi > $maxPage) $hi = $maxPage;
        $range = range($low,$hi);
        return $range;
    }

    public function getName() {
        return 'radius';
    }
}