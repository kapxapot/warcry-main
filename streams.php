<?php

require_once __DIR__."/common.php";
require_once "{$folders['phplive']}streams.php";

$id = filter_input(INPUT_GET, 'id');

if ($id) {
	$row = $db->GetStream($id);
	$stream = $builder->BuildStream($row);
	
	if ($stream) {
		$title = $stream['title'];
	}
	else {
		$title = 'Стрим не найден';
	}
}
else {
	$title = $settings->streams_title;
	
	$streams = [];
	
	$rows = $db->GetStreams();
	
	foreach ($rows as $row) {
		$streams[] = $builder->BuildStream($row);
	}
		
	$sorts = [
		'online' => [
			'dir' => 'desc',
		],
		'viewers' => [
			'dir' => 'desc',
		],
		'title' => [
			'dir' => 'asc',
			'type' => 'string',
		],
	];
	
	$streams = $builder->multiSort($streams, $sorts);
}

include __DIR__."/header.php";

if ($id) {
	$tpl = new SmartTemplate("{$folders['templates']}streams/stream.tpl");
	$tpl->assign('sitename', $sitename);
	$tpl->assign('streams_index', $settings->streams_index);
	$tpl->assign('streams_title', $settings->streams_title);

	$tpl->assign('title', $title);
	
	$tpl->assign('stream', $stream);
	$tpl->assign('game', $db->GetDefaultGame());

	$tpl->output();
}
else {
	$tpl = new SmartTemplate("{$folders['templates']}streams/index.tpl");
	$tpl->assign('sitename', $sitename);
	$tpl->assign('title', $settings->streams_title);
	
	$tpl->assign('streams', $streams);
	$tpl->assign('game', $db->GetDefaultGame());

	$tpl->output();
}

include __DIR__."/footer.php";
