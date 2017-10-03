<?php
	require_once __DIR__ . "/common.php";
	
	$oneColumn = true;

	$seriesId = filter_input(INPUT_GET, 'series_id', FILTER_VALIDATE_INT);
	$seriesAlias = filter_input(INPUT_GET, 'alias');
	$comicNumber = filter_input(INPUT_GET, 'comic_number', FILTER_VALIDATE_INT);
	$pageNumber = filter_input(INPUT_GET, 'page_number', FILTER_VALIDATE_INT);

	if (!$seriesId && $seriesAlias) {
		$seriesId = $db->GetComicSeriesIdByAlias($seriesAlias);
	}

	if ($seriesId > 0) {
		$row = $db->GetComicSeries($seriesId);
		if ($row != null) {
			$series = $builder->BuildComicSeries($row);
		}
	}
	
	if ($series) {
		$comicRow = $db->GetComicIssue($seriesId, $comicNumber);
		if ($comicRow != null) {
			$comic = $builder->BuildComicIssue($comicRow, $series);

			$pageRow = $db->GetComicIssuePage($comic['id'], $pageNumber);
			$page = $builder->BuildComicIssuePage($pageRow, $series, $comic);

			$title = $page['number_str'] . ' - ' . $series['name_ru'] . ' ' . $comic['number_str'];
			if ($series['name_en']) {
				$title .= ' (' . $series['name_en'] . ')';
			}
			
			if (isset($page['prev'])) {
				$rel_prev = $page['prev']['page_url'];
			}
			
			if (isset($comic['next'])) {
				$rel_next = $page['next']['page_url'];
			}
		}
	}
	
	if (!$page) {
		$title = 'Страница не найдена';
	}

	include __DIR__ . "/header.php";
	
	$tpl = new SmartTemplate("{$folders['templates']}comics/issue_page.tpl");
	$tpl->assign('sitename', $sitename);
	$tpl->assign('title', $title);

	if ($series) {
		$tpl->assign('title_ru', $series['name_ru']);
		$tpl->assign('title_en', $series['name_en']);
		$tpl->assign('game', $db->GetGame($series['game_id']));
	}
	else {
		$tpl->assign('game', $db->GetDefaultGame());
	}

	$tpl->assign('series', $series);
	$tpl->assign('comic', $comic);
	$tpl->assign('page', $page);

	$tpl->assign('comics_index', $settings->comics_index);
	$tpl->assign('comics_title', $settings->comics_title);

	$tpl->output();

	include __DIR__ . "/footer.php";
