<?php
	require_once __DIR__."/common.php";
	require_once "{$folders['phplive']}map.php";
	
    $title = 'Карта сайта';
    
    $map = new Map($env);
    $map->Build();
    
	include __DIR__."/header.php";

	$tpl = new SmartTemplate("{$folders['templates']}dummy.tpl");
	$tpl->assign('sitename', $sitename);
	$tpl->assign('title', $title);

	$tpl->assign('game', $db->GetDefaultGame());
	$tpl->assign('text', $map->block_text);
	
	$tpl->output();
    
	include __DIR__."/footer.php";
?>