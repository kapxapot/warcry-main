<?php

require_once __DIR__."/common.php";
require_once "{$folders['phplive']}recipes.php";

$skill = filter_input(INPUT_GET, 'skill', FILTER_VALIDATE_INT);
$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
$pagesize = filter_input(INPUT_GET, 'pagesize', FILTER_VALIDATE_INT);
$query = filter_input(INPUT_GET, 'q');

$recipes = new Recipes($env);
$recipes->debug = isset($debug);
$recipes->Build($skill, $page, $pagesize, $query);

$title = $recipes->title;
$text = $recipes->block_header.
	$recipes->block_search.
	$recipes->block_paging.
	$recipes->block_text.
	$recipes->block_paging.
	$recipes->block_debug;

$game = $db->GetGame($WOW);
$builder->AddGameUrl($game);

include __DIR__."/header.php";

$tpl = new SmartTemplate("{$folders['templates']}dummy.tpl");
//$tpl->assign('breadcrumbs', $article->block_location);

$tpl->assign('title', $title);
$tpl->assign('text', $text);
$tpl->assign('game', $game);
$tpl->assign('sitename', $sitename);

$tpl->output();
	
include __DIR__."/footer.php";
