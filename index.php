<?php
	require_once __DIR__."/common.php";

	$index = 1;
	$no_social = true;
	$no_disqus = true;
	
	$game_id = filter_input(INPUT_GET, 'game_id', FILTER_VALIDATE_INT);
    if ($game_id > 0) {
		$game = $db->GetGame($game_id);
    }

	$offset_opt = [ 'default' => 0 ];
	$limit_opt = [ 'default' => $settings->news_limit ];

	$news_offset = filter_input(INPUT_GET, 'offset', FILTER_VALIDATE_INT, [ 'options' => $offset_opt ]);
	$news_limit = filter_input(INPUT_GET, 'limit', FILTER_VALIDATE_INT, [ 'options' => $limit_opt ]);

	$news_rows = $db->GetLatestNews($news_limit, $game, null, $news_offset);

	foreach ($news_rows as $row) {
		$news[] = $builder->BuildNews($row);
	}

	//$latest_news = $builder->BuildLatestNews($game);
	$forum_topics = $builder->BuildForumTopics($game);
	$articles = $builder->BuildArticles($game);
	
	$online_stream = $builder->BuildOnlineStream();

	include __DIR__."/header.php";

	$tpl = new SmartTemplate("{$folders['templates']}news/index.tpl");
	$tpl->assign('news', $news);
	$tpl->assign('news_index', $router->ForumNewsIndex());

	$tpl->output();

	include __DIR__."/footer.php";
?>