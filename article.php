<?php
	require_once __DIR__."/common.php";
	require_once "{$folders['phplive']}article.php";

	$id = filter_input(INPUT_GET, 'id');
	$cat = filter_input(INPUT_GET, 'cat');

	$rebuild = filter_input(INPUT_GET, 'rebuild');
	$tags = filter_input(INPUT_GET, 'tags');

	$article = new Article($env);
    $article->Load($id, $cat);

	$disqus_url = $router->DisqusArticle($id, $cat);

	$article->Build(isset($rebuild), isset($tags));
	
	$title = $article->title;
	$text = str_replace("%article%", $env->settings->article_page, $article->block_article);
	$text = str_replace("%warcry%", "", $text);

	$has_text = (strlen($article->text) > 0);

	if ($has_text) {
		$page_description = substr(strip_tags($article->block_text), 0, 2000);
	}

	$game = $db->GetGame($article->game_id);
	$builder->AddGameUrl($game);
	
	if ($article->author_id > 0) {
		$a_row = $db->GetUser($article->author_id);
		$author = $builder->BuildUser($a_row);
	}
	
	if ($article->editor_id > 0) {
		$e_row = $db->GetUser($article->editor_id);
		$editor = $builder->BuildUser($e_row);
	}
	
	//$forum_topics = $builder->BuildForumTopics($game);
	//$latest_news = $builder->BuildLatestNews($game);
	$articles = $builder->BuildArticles($game, $article->id);

	include __DIR__."/header.php";

	$tpl = new SmartTemplate("{$folders['templates']}article.tpl");
	$tpl->assign('article', $article);
	$tpl->assign('valid_article', $article->IsLoaded() && $article->published);
	$tpl->assign('breadcrumbs', $article->block_location);
	if (count($article->block_sublist) > 0) {
		$tpl->assign('sub_articles', $article->block_sublist);
	}
	
	if (count($article->block_contents) > 0) {
		$tpl->assign('contents', $article->block_contents);
	}
	
	$tpl->assign('title', $title);
	$tpl->assign('title_ru', $article->name_ru);
	
	if (!$article->hideeng) {
		$tpl->assign('title_en', $article->name_en);
	}
	
	$tpl->assign('text', $text);
	$tpl->assign('game', $game);
	$tpl->assign('sitename', $sitename);
	
	$tpl->assign('author', $author);
	$tpl->assign('created_at', $article->created_at);
	$tpl->assign('editor', $editor);
	$tpl->assign('updated_at', $article->updated_at);

	$tpl->assign('origin', $article->origin);

	$tpl->output();
		
	include __DIR__."/footer.php";
