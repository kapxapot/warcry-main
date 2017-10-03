<?php

require_once __DIR__ . "/common.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$alias = filter_input(INPUT_GET, 'alias');

if (!$id && $alias) {
	$id = $db->GetComicStandaloneIdByAlias($alias);
}

if ($id > 0) {
	$row = $db->GetComicStandalone($id);
	if ($row != null) {
		$comic = $builder->BuildComicStandalone($row);

		$title = $comic['name_ru'];
		if ($comic['name_en']) {
			$title .= ' (' . $comic['name_en'] . ')';
		}
		
		$pageRows = $db->GetComicStandalonePages($comic['id']);
		foreach ($pageRows as $pageRow) {
			$pages[] = $builder->BuildComicStandalonePage($pageRow, $comic);
		}
	}
}

if (!$comic) {
	$title = 'Комикс не найден';
}

$online_stream = $builder->BuildOnlineStream();

include __DIR__ . "/header.php";

$tpl = new SmartTemplate("{$folders['templates']}comics/standalone.tpl");
$tpl->assign('sitename', $sitename);
$tpl->assign('title', $title);

if ($comic) {
	$tpl->assign('title_ru', $comic['name_ru']);
	$tpl->assign('title_en', $comic['name_en']);
	$tpl->assign('game', $db->GetGame($comic['game_id']));
}
else {
	$tpl->assign('game', $db->GetDefaultGame());
}

$tpl->assign('comic', $comic);
$tpl->assign('pages', $pages);

$tpl->assign('comics_index', $settings->comics_index);
$tpl->assign('comics_title', $settings->comics_title);

$tpl->output();

include __DIR__ . "/footer.php";
