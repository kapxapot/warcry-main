<?php
	require_once __DIR__."/common.php";

    $title = 'Ссылки';
    
	include __DIR__."/header.php";

	$tpl = new SmartTemplate("{$folders['templates']}links.tpl");
	$tpl->assign('sitename', $sitename);
	$tpl->assign('title', $title);
	$tpl->assign('team_mail', $teammail);

	$tpl->assign('game', $db->GetDefaultGame());

	$tpl->output();
    
	include __DIR__."/footer.php";
?>