<?php
	require_once __DIR__ . "/common.php";
	
	$oneColumn = true;

	$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
	$alias = filter_input(INPUT_GET, 'alias');
	$number = filter_input(INPUT_GET, 'number', FILTER_VALIDATE_INT);

	if (!$id && $alias) {
		$id = $db->GetComicStandaloneIdByAlias($alias);
	}

	if ($id > 0) {
		$comicRow = $db->GetComicStandalone($id);
		if ($comicRow != null) {
			$comic = $builder->BuildComicStandalone($comicRow);
	
			$pageRow = $db->GetComicStandalonePage($id, $number);
			$page = $builder->BuildComicStandalonePage($pageRow, $comic);
	
			$title = $page['number_str'] . ' - ' . $comic['name_ru'];
			if ($comic['name_en']) {
				$title .= ' (' . $comic['name_en'] . ')';
			}
			
			if (isset($page['prev'])) {
				$rel_prev = $page['prev']['page_url'];
			}
			
			if (isset($page['next'])) {
				$rel_next = $page['next']['page_url'];
			}
		}
	}

	if (!$page) {
		$title = 'Страница не найдена';
	}

	include __DIR__ . "/header.php";
	
	$tpl = new SmartTemplate("{$folders['templates']}comics/standalone_page.tpl");
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
	$tpl->assign('page', $page);

	$tpl->assign('comics_index', $settings->comics_index);
	$tpl->assign('comics_title', $settings->comics_title);

	$tpl->output();

	include __DIR__ . "/footer.php";
