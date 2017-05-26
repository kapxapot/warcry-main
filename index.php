<?php
	require_once __DIR__."/common.php";

	$index = 1;
	$no_social = true;
	$no_disqus = true;
	
	$game_id = filter_input(INPUT_GET, 'game_id', FILTER_VALIDATE_INT);
    if ($game_id > 0) {
		$game = $db->GetGame($game_id);
    }

	$fopt = [ 'default' => $settings->news_limit ];
	$news_limit = filter_input(INPUT_GET, 'newslimit', FILTER_VALIDATE_INT, [ 'options' => $fopt ]);

	$news_rows = $db->GetLatestNews($news_limit, $game);
	
	foreach ($news_rows as $row) {
		$news[] = $builder->BuildNews($row);
	}

	$forum_topics = $builder->BuildForumTopics($game);
	$articles = $builder->BuildArticles($game);

	include __DIR__."/header.php";

	$tpl = new SmartTemplate("{$folders['templates']}news/index.tpl");
	$tpl->assign('news', $news);
	$tpl->assign('news_index', $router->ForumNewsIndex());

	$tpl->output();

	include __DIR__."/footer.php";
?>