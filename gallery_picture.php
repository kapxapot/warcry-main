<?php
	require_once __DIR__."/common.php";
	
	$oneColumn = true;

	$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

	if ($id > 0) {
		$pic_row = $db->GetGalleryPicture($id);
	}

	if ($pic_row) {
		$picture = $builder->BuildGalleryPicture($pic_row);
		$author = $picture['author'];
		$title = $picture['comment'];
	}
	else {
		$title = 'Картинка не найдена';
		$author = [ 'page_url' => '#', 'name' => 'Автор не найден' ];
	}

	include __DIR__."/header.php";
	
	$tpl = new SmartTemplate("{$folders['templates']}gallery/picture.tpl");
	$tpl->assign('sitename', $sitename);
	$tpl->assign('title', $title);

	$tpl->assign('picture', $picture);
	$tpl->assign('author', $author);
	$tpl->assign('game', $db->GetDefaultGame());

	$tpl->assign('gallery_index', $settings->gallery_index);
	$tpl->assign('gallery_title', $settings->gallery_title);

	$tpl->output();


	include __DIR__."/footer.php";
