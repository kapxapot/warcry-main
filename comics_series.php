<?php

require_once __DIR__ . "/common.php";

$seriesId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$seriesAlias = filter_input(INPUT_GET, 'alias');

if (!$seriesId) {
	if ($seriesAlias) {
		$seriesId = $db->GetComicSeriesIdByAlias($seriesAlias);
	}
}

if ($seriesId > 0) {
	$row = $db->GetComicSeries($seriesId);
	if ($row != null) {
		$series = $builder->BuildComicSeries($row);
	}
}

if ($series) {
	$title = $series['name_ru'];
	if ($series['name_en']) {
		$title .= ' (' . $series['name_en'] . ')';
	}

	$comicRows = $db->GetComicIssues($seriesId);
	
	$comics = [];
	foreach ($comicRows as $comicRow) {
		$comics[] = $builder->BuildComicIssue($comicRow, $series);
	}
}
else {
	$title = 'Серия не найдена';
}

$online_stream = $builder->BuildOnlineStream();

include __DIR__ . "/header.php";

$tpl = new SmartTemplate("{$folders['templates']}comics/series.tpl");
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
$tpl->assign('comics', $comics);

$tpl->assign('comics_index', $settings->comics_index);
$tpl->assign('comics_title', $settings->comics_title);

$tpl->output();

include __DIR__ . "/footer.php";
