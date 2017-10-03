<?php

require_once __DIR__ . "/../common.php";

$log = filter_input(INPUT_GET, 'log');

$rows = $db->GetStreams();

foreach ($rows as $row) {
	$builder->updateStreamData($row, isset($log));
	print("Stream {$row['stream_id']} updated.<br/><br/>");
}

print('Done.');
