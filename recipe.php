<?php

require_once __DIR__."/common.php";
require_once "{$folders['phplive']}recipe.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$rebuild = filter_input(INPUT_GET, 'rebuild');

$recipe = new Recipe($env);
$recipe->Load($id);

$recipe->debug = isset($debug);
$forced = isset($rebuild);
$recipe->Build($forced);

$disqus_id = "recipe" . $recipe->id;

$title = $recipe->title;
$text = $recipe->block_search.
	$recipe->block_text.
	$recipe->block_debug;

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
