<?php
	require_once __DIR__."/common.php";
	
	$pics_per_page = 24;

	$author_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
	$author_alias = filter_input(INPUT_GET, 'alias');
	$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);

	if (!$author_id) {
		if ($author_alias) {
			$author_id = $db->GetGalleryAuthorIdByAlias($author_alias);
		}
	}

	if ($author_id > 0) {
		$disqus_url = $router->DisqusGalleryAuthor($author_id);

		$row = $db->GetGalleryAuthor($author_id);
		if ($row != null) {
			$author = $builder->BuildGalleryAuthor($row);
		}
	}
	
	if (isset($author)) {
		$title = $author['name'];

		$total_count = $author['count'];
		$total_pages = ceil($total_count / $pics_per_page);

		// determine page
		if (!isset($page) || !is_numeric($page) || $page < 2) {
			$page = 1;
		}

		if ($page > $total_pages) {
			$page = $total_pages;
		}
		
		// paging
		$base_url = $author['page_url'];
		$paging = $builder->BuildPaging($base_url, $total_pages, $page);

		if ($paging) {
			if (isset($paging['prev'])) {
				$rel_prev = $paging['prev']['url'];
			}
			
			if (isset($paging['next'])) {
				$rel_next = $paging['next']['url'];
			}
		}

		// pics
		$offset = ($page - 1) * $pics_per_page;
		
		$pic_rows = $db->GetGalleryPictures($author['id'], $offset, $pics_per_page);
		
		$pictures = [];
		foreach ($pic_rows as $pic_row) {
			$pictures[] = $builder->BuildGalleryPicture($pic_row, $author);
		}
	}
	else {
		$title = 'Автор не найден';
	}
	
	include __DIR__."/header.php";

	$tpl = new SmartTemplate("{$folders['templates']}gallery/author.tpl");
	$tpl->assign('sitename', $sitename);
	$tpl->assign('title', $title);

	$tpl->assign('author', $author);
	$tpl->assign('pictures', $pictures);
	$tpl->assign('game', $db->GetDefaultGame());

	$tpl->assign('gallery_index', $settings->gallery_index);
	$tpl->assign('gallery_title', $settings->gallery_title);

	$tpl->assign('paging', $paging);

	$tpl->output();
    
	include __DIR__."/footer.php";
