<?php

require_once __DIR__ . "/common.php";

$title = $settings->comics_title;

$series = [];
$comics = [];

$seriesRows = $db->GetComicSeries();

foreach ($seriesRows as $seriesRow) {
	$series[] = $builder->BuildComicSeries($seriesRow);
}

$comicRows = $db->GetComicStandalones();

foreach ($comicRows as $comicRow) {
	$comics[] = $builder->BuildComicStandalone($comicRow);
}

$online_stream = $builder->BuildOnlineStream();

include __DIR__ . "/header.php";

$tpl = new SmartTemplate("{$folders['templates']}comics/index.tpl");
$tpl->assign('sitename', $sitename);
$tpl->assign('title', $title);

$tpl->assign('series', $series);
$tpl->assign('comics', $comics);
$tpl->assign('game', $db->GetDefaultGame());

$tpl->output();

include __DIR__ . "/footer.php";
