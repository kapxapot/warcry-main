<?php

if (isset($_GET['debug'])) {
	error_reporting(E_ALL & ~E_NOTICE);
	ini_set("display_errors", 1);
}

$folders = [];
$folders['root'] = __DIR__ . "/../../../";
$folders['absolute'] = "/codiad/workspace/warcry_bootstrap/";
$folders['lib'] = "/lib/";
$folders['bootstrap'] = "{$folders['lib']}bootstrap/";
$folders['colorbox'] = "{$folders['lib']}colorbox/";
$folders['phplive'] = "{$folders['root']}phplive/";
$folders['smarty'] = "{$folders['root']}smarty_classes/";
$folders['classes'] = __DIR__ . "/classes/";
$folders['templates'] = __DIR__ . "/tpl/";

require_once "{$folders['root']}common.php";
require_once "{$folders['smarty']}class.smarttemplate.php";
require_once "{$folders['classes']}env.php";

$env = new BootstrapEnvironment();

$settings = $env->settings;
$db = $env->db;
$builder = $env->builder;
$router = $env->router;

$short_site_description = 'World of Warcraft, Diablo III, Hearthstone, Overwatch';
$logo = '/images/text_logo_4.png';
$twitter_card_image = 'http://warcry.ru' . $logo;
