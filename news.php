<?php

require_once __DIR__ . "/common.php";

$news_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($news_id > 0) {
	$disqus_url = $router->DisqusNews($news_id);

	$row = $db->GetNews($news_id);
	
	if ($row != null) {
		$news = $builder->BuildNews($row, true);
	
		$page_description = substr(strip_tags($news['text']), 0, 1000);
		$game = $news['game'];
	
		$latest_news = $builder->BuildLatestNews($game, $news_id);
		$forum_topics = $builder->BuildForumTopics($game);

		$title = $news['title'];
	}
}

$online_stream = $builder->BuildOnlineStream();

include __DIR__ . "/header.php";

$tpl = new SmartTemplate("{$folders['templates']}news/news.tpl");
$tpl->assign('news', $news);
$tpl->assign('sitename', $sitename);

$tpl->output();

include __DIR__ . "/footer.php";
