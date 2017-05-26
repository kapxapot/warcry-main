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
		return strftime($this->settings->time_format, $date);
	}

	function BuildNews($row, $full = false) {
		$id = $row['tid'];
		$title = DecodeTopicTitle($row['title']);
		
		$post = BeforeParsePost($row['post'], $id, $full);
		$post = $this->forum_parser->convert(array("TEXT" => $post, "CODE" => 1));
		$post = AfterParsePost($post);

		$game = $this->db->GetGameByForumId($row['forum_id']);
		$this->AddGameUrl($game);

		$tag_rows = $this->db->GetForumTopicTags($id);

		foreach ($tag_rows as $tag_row) {
			$text = $tag_row['tag_text'];
			$tags[] = array("text" => $text, "url" => $this->router->ForumTag($text));
		}

		return array(
			"title" => $title,
			"game" => $game,
			"posts" => $row['posts'],
			"start_date" => $this->FormatDate($row['start_date']),
			"starter_url" => $this->router->ForumUser($row['starter_id']),
			"starter_name" => $row['starter_name'],
			"tags" => $tags,
			"text" => $post,
			"url" => $this->router->News($id),
			"forum_url" => $this->router->ForumTopic($id)
		);
	}

	function BuildNewsLink($row, $game) {
		$id = $row['tid'];
		$title = DecodeTopicTitle($row['title']);

		return array(
			"title" => $title,
			"game" => $game,
			"posts" => $row['posts'],
			"url" => $this->router->News($id),
		);
	}
	
	private function BuildForumTopic($row, $game = null) {
		$title = DecodeTopicTitle($row['title']);
		
		if ($game == null) {
			$game = $this->db->GetGameByForumId($row['forum_id']);
		}
	
		return array(
			"title" => $title,
			"url" => $this->router->ForumTopic($row['tid'], true),
			"game" => $game,
			"posts" => $row['posts']
		);
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
			$game = array("alias" => $row['game_alias'], "name" => $row['game_name']);
		}

		return array(
			"url" => $this->router->Article($row['name_en'], $row['cat']),
			"title" => $row['name_ru'],
			"game" => $game
		);
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

	private function Kartinok($num) {
		$result = "картинок";

		if ($num < 5 || $num > 20) {
			switch ($num % 10) {
				case 1:
					$result = "картинка";
					break;

				case 2:
				case 3:
				case 4:
					$result = "картинки";
					break;
			}
		}
		
		return $result;
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
	
			$author['pictures_str'] = $this->Kartinok($author['count']);
			
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
		
		// prev/next pictures
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
			'title' => ($title != null) ? $title : "Страница {$page}"
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
		$stream['viewers'] = 0;
		$stream['online'] = 0;

		switch ($stream['type']) {
			// Twitch
			case 1:
				$stream['img_url'] = "http://static-cdn.jtvnw.net/previews/live_user_{$id}-320x180.jpg";
				$stream['twitch'] = true;
				$stream['stream_url'] = "http://twitch.tv/{$id}";
				
				$data = $this->getTwitchStreamData($id);
				$json = json_decode($data, true);
				
				$stream['data'] = $data;
				
				if (isset($json['streams'][0])) {
					$s = $json['streams'][0];

					$stream['online'] = 1;
					$stream['game'] = $s['game'];
					$stream['viewers'] = $s['viewers'];
					
					if (isset($s['channel'])) {
						$ch = $s['channel'];

						$stream['title'] = $ch['display_name'];
						$stream['status'] = $ch['status'];
						$stream['logo'] = $ch['logo'];
					}
				}
				
				break;
			
			// Own3d
			case 2:
				$stream['img_url'] = "http://img.hw.own3d.tv/live/live_tn_{$id}_.jpg";
				$stream['own3d'] = true;
				break;
		}

		return $stream;
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
}
