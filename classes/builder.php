<?php

class Builder {
	protected $env;
	
	function __construct($env) {
		$this->env = $env;
	}
	
	function __get($property) {
		if ($this->env->{$property}) {
			return $this->env->{$property};
		}
	}
	
	function AddGameUrl(&$game, $forced = false) {
		if ($game != null && (!$game['default'] || $forced)) {
			$game['url'] = $this->router->Game($game);
		}
		
		return $game;
	}
	
	function GamesWithUrls($games) {
		foreach ($games as &$game) {
			$this->AddGameUrl($game, true);
		}

		return $games;
	}
	
	private function FormatDate($date) {
		return strftime($this->settings->date_format, $date);
	}
	
	private function FormatDateTime($date) {
		return strftime($this->settings->time_format, $date);
	}

	function BuildNews($row, $full = false) {
		$id = $row['tid'];
		$title = DecodeTopicTitle($row['title']);

		$post = BeforeParsePost($row['post'], $id, $full);
		$post = $this->forum_parser->convert([ "TEXT" => $post, "CODE" => 1 ]);
		$post = AfterParsePost($post);

		$game = $this->db->GetGameByForumId($row['forum_id']);
		$this->AddGameUrl($game);

		$tag_rows = $this->db->GetForumTopicTags($id);

		foreach ($tag_rows as $tag_row) {
			$text = $tag_row['tag_text'];
			$tags[] = [ "text" => $text, "url" => $this->router->ForumTag($text) ];
		}

		return [
			"title" => $title,
			"game" => $game,
			"posts" => $row['posts'],
			"start_date" => $this->FormatDateTime($row['start_date']),
			"starter_url" => $this->router->ForumUser($row['starter_id']),
			"starter_name" => $row['starter_name'],
			"tags" => $tags,
			"text" => $post,
			"url" => $this->router->News($id),
			"forum_url" => $this->router->ForumTopic($id),
		];
	}

	function BuildNewsLink($row, $game) {
		$id = $row['tid'];
		$title = DecodeTopicTitle($row['title']);

		return [
			"title" => $title,
			"game" => $game,
			"posts" => $row['posts'],
			"url" => $this->router->News($id),
		];
	}
	
	private function BuildForumTopic($row, $game = null) {
		$title = DecodeTopicTitle($row['title']);
		
		if ($game == null) {
			$game = $this->db->GetGameByForumId($row['forum_id']);
		}
	
		return [
			"title" => $title,
			"url" => $this->router->ForumTopic($row['tid'], true),
			"game" => $game,
			"posts" => $row['posts'],
		];
	}
	
	function BuildForumTopics($game = null) {
		$limit = $this->settings->sidebar_forum_topic_limit;
		$rows = $this->db->GetLatestForumTopics($limit, $game);
	
		foreach ($rows as $row) {
			$forum_topics[] = $this->BuildForumTopic($row, $game);
		}
		
		return $forum_topics;
	}
	
	function BuildLatestNews($game, $except_news_id = null) {
		$limit = $this->settings->sidebar_latest_news_limit;
		$rows = $this->db->GetLatestNews($limit, $game, $except_news_id);
		
		foreach ($rows as $row) {
			$news[] = $this->BuildNewsLink($row, $game);
		}
		
		return $news;
	}
	
	private function BuildArticle($row, $game = null) {
		if ($game == null) {
			$game = [
				"alias" => $row['game_alias'],
				"name" => $row['game_name'],
			];
		}

		return [
			"url" => $this->router->Article($row['name_en'], $row['cat']),
			"title" => $row['name_ru'],
			"game" => $game,
		];
	}
	
	function BuildArticles($game = null, $except_article_id = null) {
		$limit = $this->settings->sidebar_article_limit;
		$article_rows = $this->db->GetLatestArticles($limit, $game, $except_article_id);

		if (!empty($article_rows) > 0) {
			foreach ($article_rows as $row) {
				$articles[] = $this->BuildArticle($row, $game);
			}
		}
		
		return $articles;
	}
	
	function BuildMenu($game = null) {
		$menu = [];
		
		if ($game != null) {
			$menu_sections = $this->db->GetMenuSections($game['id']);
			foreach ($menu_sections as $menu_section) {
				$m = $menu_section;
				
				$menu_items = $this->db->GetMenuItems($menu_section['id']);
				if (count($menu_items) > 0) {
					$items = [];
					foreach ($menu_items as $menu_item) {
						$items[] = $menu_item;
					}
					
					$m['items'] = $items;
				}

				$menu[] = $m;
			}
		}
		
		return $menu;
	}

	function BuildGalleryAuthor($row, $short = false) {
		$author = $row;

		$author['page_url'] = $this->router->GalleryAuthor($author);

		if (!$short) {
			$pic_rows = $this->db->GetGalleryPictures($author['id'], 0, 1);
			if (count($pic_rows) > 0) {
				$lastId = $pic_rows[0]['id'];
				$last = $this->db->GetGalleryPicture($lastId);

				$author['last_picture_id'] = $lastId;
				$author['last_thumb_url'] = $this->router->GalleryThumbImg($last);
			}
	
			$author['pictures_str'] = $this->cases->caseForNumber('картинка', $author['count']);
			
			if ($author['member_id'] > 0) {
				$author['member_url'] = $this->router->ForumUser($author['member_id']);
			}
			
			if ($author['avatar_x'] > 100) {
				$author['avatar_x'] = 100;
			}
	
			$avatar = $author['avatar'];
			$url = null;
	
			if ((strlen($avatar) > 0) && ($avatar != 'noavatar')) {
				$pos = strpos($avatar, "upload:");
				if (($pos !== false) && ($pos == 0)) {
					$url = $this->router->ForumUpload(substr($avatar, strlen("upload:")));
				}
				else {
					$pos = strpos($avatar, "http://");
					if (($pos !== false) && ($pos == 0)) {
						$url = $avatar;
					}
					else {
						$url = $this->router->ForumUpload($avatar);
					}
				}
			}
			
			$author['avatar_url'] = $url;
		}
		
		return $author;
	}
	
	function BuildGalleryPicture($row, $author = null) {
		$picture = $row;

		$id = $picture['id'];
		
		$picture['url'] = $this->router->GalleryPictureImg($picture);
		$picture['thumb'] = $this->router->GalleryThumbImg($picture);

		if ($author == null) {
			$author_row = $this->db->GetGalleryAuthor($picture['author_id']);
			$author = $this->builder->BuildGalleryAuthor($author_row, true);
		}

		if ($author != null) {
			$picture['author'] = $author;
			$picture['page_url'] = $this->router->GalleryPicture($author, $id);
		}
		
		$prev = $this->db->GetGalleryPicturePrev($id);
		$next = $this->db->GetGalleryPictureNext($id);
		
		if ($prev != null) {
			$prev['page_url'] = $this->router->GalleryPicture($author, $prev['id']);
			$picture['prev'] = $prev;
		}
		
		if ($next != null) {
			$next['page_url'] = $this->router->GalleryPicture($author, $next['id']);
			$picture['next'] = $next;
		}

		return $picture;
	}
	
	private function BuildPage($base_url, $page, $current, $label = null, $title = null) {
		return [
			'page' => $page,
			'current' => $current,
			'url' => $this->router->Page($base_url, $page),
			'label' => ($label != null) ? $label : $page,
			'title' => ($title != null) ? $title : "Страница {$page}",
		];
	}

	function BuildPaging($base_url, $total_pages, $page) {
		if ($total_pages > 1) {
			$paging = [];
			$pages = [];
			
			if ($page > 1) {
				$prev = $this->BuildPage($base_url, $page - 1, false, $this->decorator->Prev(), 'Предыдущая страница');
				$paging['prev'] = $prev;
				$pages[] = $prev;
			}

			for ($i = 1; $i <= $total_pages; $i++) {
				$pages[] = $this->BuildPage($base_url , $i, $i == $page);
			}
			
			if ($page < $total_pages) {
				$next = $this->BuildPage($base_url, $page + 1, false, $this->decorator->Next(), 'Следующая страница');
				$paging['next'] = $next;
				$pages[] = $next;
			}
			
			$paging['pages'] = $pages;

			return $paging;
		}
	}
	
	function BuildUser($row) {
		$user = $row;
		
		if ($user['member_id'] > 0) {
			$user['member_url'] = $this->router->ForumUser($user['member_id']);
		}
		
		if ($user['name'] == null) {
			$user['name'] = $user['login'];
		}

		return $user;
	}
	
	public function BuildStream($row) {
		$stream = $row;
		
		$id = $stream['stream_id'];
		
		if (!$stream['stream_alias']) {
			$stream['stream_alias'] = $id;
		}

		$stream['page_url'] = $this->router->Stream($stream['stream_alias']);

		switch ($stream['type']) {
			// Twitch
			case 1:
				//$stream['img_url'] = "http://static-cdn.jtvnw.net/previews/live_user_{$id}-320x180.jpg";
				$stream['img_url'] = "https://static-cdn.jtvnw.net/previews-ttv/live_user_{$id}-320x180.jpg";
				$stream['large_img_url'] = "https://static-cdn.jtvnw.net/previews-ttv/live_user_{$id}-640x360.jpg";
				
				$stream['twitch'] = true;
				$stream['stream_url'] = "http://twitch.tv/{$id}";
				break;
			
			// Own3d
			case 2:
				$stream['img_url'] = "http://img.hw.own3d.tv/live/live_tn_{$id}_.jpg";
				$stream['own3d'] = true;
				break;
		}
		
		$onlineAt = $stream['remote_online_at'];
		
		if ($onlineAt) {
			$stream['remote_online_at'] = $this->FormatDate(strtotime($onlineAt));
			$stream['remote_online_ago'] = $this->dateToAgo($onlineAt);
		}
		
		$form = [
			'time' => Cases::PAST,
			'person' => Cases::FIRST,
			'number' => Cases::SINGLE,
			'gender' => $stream['gender_id'],
		];
		
		$stream['played'] = $this->cases->conjugation('играть', $form);
		$stream['broadcasted'] = $this->cases->conjugation('транслировать', $form);
		$stream['held'] = $this->cases->conjugation('вести', $form);

		return $stream;
	}
	
	public function updateStreamData($row, $log = false) {
		$stream = $row;
		
		$id = $stream['stream_id'];
		
		switch ($stream['type']) {
			// Twitch
			case 1:
				$data = $this->getTwitchStreamData($id);
				$json = json_decode($data, true);
				
				if ($log) {
					var_dump($json);
				}
				
				if (isset($json['streams'][0])) {
					$s = $json['streams'][0];

					$stream['remote_online'] = 1;
					$stream['remote_game'] = $s['game'];
					$stream['remote_viewers'] = $s['viewers'];
					
					if (isset($s['channel'])) {
						$ch = $s['channel'];

						$stream['remote_title'] = $ch['display_name'];
						$stream['remote_status'] = $ch['status'];
						$stream['remote_logo'] = $ch['logo'];
					}
				}
				else {
					$stream['remote_online'] = 0;
					$stream['remote_viewers'] = 0;
				}
				
				break;
			
			// Own3d
			case 2:
				// move along
				break;
		}

		// save
		$this->db->saveStreamData($stream);
	}

	private function getTwitchStreamData($id) {
		$url = "https://api.twitch.tv/kraken/streams?channel={$id}";
		$clientId = $this->settings->twitch_client_id;
		$data = $this->curlGet($url, $clientId);

		return $data;
	}

	private function curlGet($url, $clientId) {
		$ch = curl_init();

		$headers = [ "Client-ID: {$clientId}" ];
	
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		$data = curl_exec($ch);
		curl_close($ch);
		
		return $data;
	}

	public function multiSort($array, $sorts) {
		usort($array, function($a, $b) use ($sorts) {
		    foreach ($sorts as $field => $settings) {
		    	$dir = $settings['dir'];
		    	$str = (isset($settings['type']) && $settings['type'] == 'string');
		    	
		    	$cmp = $str ? strcasecmp($a[$field], $b[$field]) : ($a[$field] - $b[$field]);
		    	
		    	if ($cmp != 0) {
			    	if ($dir == 'desc') {
			    		$cmp = -$cmp;
			    	}
			    	
			    	return $cmp;
		    	}
		    }
		    
		    return 0;
		});
		
		return $array;
	}

	public function BuildSortedStreams($rows) {
		$streams = [];
		
		foreach ($rows as $row) {
			if ($row['alive'] == 1) {
				$stream = $this->BuildStream($row);
			
				$priorityGames = [
					'world of warcraft',
					'hearthstone',
					'overwatch',
					'heroes of the storm',
					'starcraft',
					'starcraft ii',
					'warcraft iii',
					'warcraft iii: the frozen throne',
					'diablo iii',
					'diablo iii: reaper of souls',
					'diablo ii',
					'diablo ii: lord of destruction',
				];
				
				$game = strtolower($stream['remote_game']) ?? '';
	
				$stream['priority_game'] = in_array($game, $priorityGames) ? 1 : 0;
				
				$streams[] = $stream;
			}
		}
			
		$sorts = [
			'remote_online' => [
				'dir' => 'desc',
			],
			'priority' => [
				'dir' => 'desc',
			],
			'priority_game' => [
				'dir' => 'desc',
			],
			'remote_viewers' => [
				'dir' => 'desc',
			],
			'title' => [
				'dir' => 'asc',
				'type' => 'string',
			],
		];
		
		$streams = $this->multiSort($streams, $sorts);
		
		return $streams;
	}
	
	public function BuildOnlineStream() {
		$rows = $this->db->GetStreams();
		$streams = $this->BuildSortedStreams($rows);
	
		$onlineStreams = array_filter($streams, function($stream) { return $stream['remote_online'] == 1; });
		$totalOnline = count($onlineStreams);
	
		if ($totalOnline > 0) {
			$onlineStream = $onlineStreams[0];
			$onlineStream['total_streams_online'] = $totalOnline . ' ' . $this->cases->caseForNumber('стрим', $totalOnline);
		}
		
		return $onlineStream;
	}
	
	// COMICS

	function BuildComicSeries($row) {
		$series = $row;

		$series['page_url'] = $this->router->ComicSeries($series['alias']);

		$comicRows = $this->db->GetComicIssues($series['id']);
		$comicCount = count($comicRows);
		
		if ($comicCount > 0) {
			$comicId = $comicRows[0]['id'];
			$pageRows = $this->db->GetComicIssuePages($comicId);
			
			if (count($pageRows) > 0) {
				$pageRow = $pageRows[0];
				$series['cover_url'] = $this->router->ComicThumbImg($pageRow);
			}
		}
		
		$series['comic_count'] = $comicCount;
		$series['comic_count_str'] = $comicCount . '&nbsp;' . $this->cases->caseForNumber('выпуск', $comicCount);

		$series['publisher'] = $this->db->GetComicPublisher($series['publisher_id']);
		
		if ($series['name_ru'] == $series['name_en']) {
			$series['name_en'] = null;
		}

		return $series;
	}

	function BuildComicStandalone($row) {
		$comic = $row;

		$comic['page_url'] = $this->router->ComicStandalone($comic['alias']);

		$pageRows = $this->db->GetComicStandalonePages($comic['id']);
		
		if (count($pageRows) > 0) {
			$pageRow = $pageRows[0];
			$comic['cover_url'] = $this->router->ComicThumbImg($pageRow);
		}

		$comic['publisher'] = $this->db->GetComicPublisher($comic['publisher_id']);
		$comic['issued_on'] = $this->FormatDate(strtotime($comic['issued_on']));

		if ($comic['name_ru'] == $comic['name_en']) {
			$comic['name_en'] = null;
		}

		return $comic;
	}
	
	private function padNum($num) {
		return str_pad($num, 2, '0', STR_PAD_LEFT);
	}
	
	private function comicNum($num) {
		return '#' . $num;
	}
	
	private function pageNum($num) {
		return $this->padNum($num);
	}

	function BuildComicIssue($row, $series) {
		$comic = $row;

		$comic['page_url'] = $this->router->ComicIssue($series['alias'], $comic['number']);

		$pageRows = $this->db->GetComicIssuePages($comic['id']);
		
		if (count($pageRows) > 0) {
			$pageRow = $pageRows[0];
			$comic['cover_url'] = $this->router->ComicThumbImg($pageRow);
		}
		
		$comic['number_str'] = $this->comicNum($comic['number']);
		if ($comic['name_ru']) {
			$comic['number_str'] .= ': ' . $comic['name_ru'];
		}

		$comic['issued_on'] = $this->FormatDate(strtotime($comic['issued_on']));

		$prev = $this->db->GetComicIssuePrev($series['id'], $comic['number']);
		$next = $this->db->GetComicIssueNext($series['id'], $comic['number']);
		
		if ($prev != null) {
			$prev['page_url'] = $this->router->ComicIssue($series['alias'], $prev['number']);
			$prev['number_str'] = $this->comicNum($prev['number']);
			if ($prev['name_ru']) {
				$prev['number_str'] .= ': ' . $prev['name_ru'];
			}
			
			$comic['prev'] = $prev;
		}
		
		if ($next != null) {
			$next['page_url'] = $this->router->ComicIssue($series['alias'], $next['number']);
			$next['number_str'] = $this->comicNum($next['number']);
			if ($next['name_ru']) {
				$next['number_str'] .= ': ' . $next['name_ru'];
			}
			
			$comic['next'] = $next;
		}

		return $comic;
	}
	
	function BuildComicIssuePage($row, $series, $comic) {
		$page = $row;

		$id = $page['id'];
		
		$page['url'] = $this->router->ComicPageImg($page);
		$page['thumb'] = $this->router->ComicThumbImg($page);

		$page['page_url'] = $this->router->ComicIssuePage($series['alias'], $comic['number'], $page['number']);
		
		$page['number_str'] = $this->pageNum($page['number']);

		$prev = $this->db->GetComicIssuePagePrev($series['id'], $comic['number'], $page['number']);
		$next = $this->db->GetComicIssuePageNext($series['id'], $comic['number'], $page['number']);
		
		if ($prev != null) {
			$prev['page_url'] = $this->router->ComicIssuePage($series['alias'], $prev['comic_number'], $prev['number']);
			$prev['comic_number_str'] = $this->comicNum($prev['comic_number']);
			$prev['number_str'] = $this->pageNum($prev['number']);
			
			$page['prev'] = $prev;
		}
		
		if ($next != null) {
			$next['page_url'] = $this->router->ComicIssuePage($series['alias'], $next['comic_number'], $next['number']);
			$next['comic_number_str'] = $this->comicNum($next['comic_number']);
			$next['number_str'] = $this->pageNum($next['number']);
			
			$page['next'] = $next;
		}

		return $page;
	}
	
	function BuildComicStandalonePage($row, $comic) {
		$page = $row;

		$id = $page['id'];
		
		$page['url'] = $this->router->ComicPageImg($page);
		$page['thumb'] = $this->router->ComicThumbImg($page);

		$page['page_url'] = $this->router->ComicStandalonePage($comic['alias'], $page['number']);
		
		$page['number_str'] = $this->pageNum($page['number']);

		$prev = $this->db->GetComicStandalonePagePrev($id);
		$next = $this->db->GetComicStandalonePageNext($id);
		
		if ($prev != null) {
			$prev['page_url'] = $this->router->ComicStandalonePage($comic['alias'], $prev['number']);
			$prev['number_str'] = $this->pageNum($prev['number']);
			
			$page['prev'] = $prev;
		}
		
		if ($next != null) {
			$next['page_url'] = $this->router->ComicStandalonePage($comic['alias'], $next['number']);
			$next['number_str'] = $this->pageNum($next['number']);
			
			$page['next'] = $next;
		}

		return $page;
	}
	
	private function dateToAgo($date) {
		$now = new \DateTime;
		$today = new \DateTime("today");
		$yesterday = new \DateTime("yesterday");		
		
		$dt = new \DateTime($date);

		if ($dt > $today) {
			$str = 'сегодня';
		}
		elseif ($dt > $yesterday) {
			$str = 'вчера';
		}
		else {
			$interval = $dt->diff($now);
			$days = $interval->d;
			$str = $days . ' ' . $this->cases->caseForNumber('день', $days) . ' назад';
		}
		
		return $str ?? 'неизвестно когда';
	}
}
