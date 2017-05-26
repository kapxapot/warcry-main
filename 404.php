<?php
	require_once __DIR__."/common.php";

	$no_social = true;
	$no_disqus = true;
	
    $title = '404';
    
	include __DIR__."/header.php";

	$tpl = new SmartTemplate("{$folders['templates']}dummy.tpl");
	$tpl->assign('sitename', $sitename);
	$tpl->assign('title', $title);

	$tpl->assign('game', $db->GetDefaultGame());
	$tpl->assign('text', "Страница не найдена или перемещена. <a href=\"{$settings->absolute_index_page}\">Вернуться на главную?</a>");
	
	$tpl->output();
    
	include __DIR__."/footer.php";
?>