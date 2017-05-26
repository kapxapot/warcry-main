<?php

require_once __DIR__."/common.php";

$title = $settings->gallery_title;

$authors = [];

$rows = $db->GetGalleryAuthors();

foreach ($rows as $row) {
	$authors[] = $builder->BuildGalleryAuthor($row);
}

include __DIR__."/header.php";

$tpl = new SmartTemplate("{$folders['templates']}gallery/index.tpl");
$tpl->assign('sitename', $sitename);
$tpl->assign('title', $title);

$tpl->assign('authors', $authors);
$tpl->assign('game', $db->GetDefaultGame());

$tpl->assign('forum_index', $settings->forum_index);
$tpl->assign('teammail', $teammail);
$tpl->assign('forum_topic', $router->ForumTopic(3443));

$tpl->output();

include __DIR__."/footer.php";
