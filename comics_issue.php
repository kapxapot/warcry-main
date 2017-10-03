<?php

require_once __DIR__ . "/common.php";

$seriesId = filter_input(INPUT_GET, 'series_id', FILTER_VALIDATE_INT);
$seriesAlias = filter_input(INPUT_GET, 'alias');
$number = filter_input(INPUT_GET, 'number', FILTER_VALIDATE_INT);

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
	$comicRow = $db->GetComicIssue($seriesId, $number);
	if ($comicRow != null) {
		$comic = $builder->BuildComicIssue($comicRow, $series);
		
		$title = $series['name_ru'] . ' ' . $comic['number_str'];
		if ($series['name_en']) {
			$title .= ' (' . $series['name_en'] . ')';
		}
		
		$pageRows = $db->GetComicIssuePages($comic['id']);
		foreach ($pageRows as $pageRow) {
			$pages[] = $builder->BuildComicIssuePage($pageRow, $series, $comic);
		}
		
		if (isset($comic['prev'])) {
			$rel_prev = $comic['prev']['page_url'];
		}
		
		if (isset($comic['next'])) {
			$rel_next = $comic['next']['page_url'];
		}
	}
}

if (!$comic) {
	$title = 'Комикс не найден';
}

$online_stream = $builder->BuildOnlineStream();

include __DIR__ . "/header.php";

$tpl = new SmartTemplate("{$folders['templates']}comics/issue.tpl");
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
$tpl->assign('pages', $pages);

$tpl->assign('comics_index', $settings->comics_index);
$tpl->assign('comics_title', $settings->comics_title);

$tpl->output();

include __DIR__ . "/footer.php";
