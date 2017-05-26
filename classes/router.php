<?php

class Router {
	protected $env;

	public function __construct($env) {
		$this->env = $env;
	}
	
	public function __get($property) {
		if ($this->env->{$property}) {
			return $this->env->{$property};
		}
	}
	
	// urls
	private function ForumUrl($url) {
		return $this->settings->forum_page."?{$url}";
	}
	
	private function IndexUrl($url) {
		return $this->settings->absolute_index_page."/{$url}";
	}
	
	private function ArticleUrl($url) {
		$au = $this->settings->article_page."/{$url}";

		return $this->parser->FromSpaces($au);
	}

	// site
	public function Article($name, $cat = null) {
		$link = $name;

		if ($cat != null) {
			$link .= "/{$cat}";
		}

		return $this->ArticleUrl($link);
	}
	
	public function News($id) {
		return "/news/{$id}";
	}

	public function Game($game) {
		$appendix = $game['default'] ? "" : $game['alias'];
	
		return "/{$appendix}";
	}
	
	// disqus
	public function DisqusNews($id) {
		return $this->IndexUrl("news.php?id={$id}");
	}
	
	public function DisqusArticle($id, $cat = null) {
		$link = "article.php?id={$id}";
		
		if ($cat != null) {
			$link .= "&cat={$cat}";
		}

		return $this->IndexUrl($link);
	}
	
	public function DisqusGalleryAuthor($id) {
		return $this->IndexUrl("gallery/author.php?author_id={$id}");
	}
	
	// forum
	public function ForumTag($text) {
		return $this->ForumUrl("app=core&module=search&do=search&search_tags=".urlencode($text)."&search_app=forums");
	}
	
	public function ForumUser($id) {
		return $this->ForumUrl("showuser={$id}");
	}
	
	public function ForumNewsIndex() {
		return $this->ForumUrl("showforum=6");
	}
	
	public function ForumTopic($id, $new = false) {
		$appendix = $new ? "&view=getnewpost" : "";
		
		return $this->ForumUrl("showtopic={$id}{$appendix}");
	}
	
	public function ForumUpload($name) {
		return $this->settings->forum_index."/uploads/{$name}";
	}
	
	// gallery
	public function GalleryAuthor($author) {
		return $this->settings->gallery_index."/{$author['alias']}";
	}
	
	const IMAGE_TYPES = [
		'jpeg' => 'jpg',
		'png' => 'png',
		'gif' => 'gif',
	];
	
	private function getExtension($type) {
		if (!$type) {
			$type = 'jpeg';
		}
		
		if (!array_key_exists($type, self::IMAGE_TYPES)) {
			throw new \InvalidArgumentException('Неизвестный или не поддерживаемый формат изображения: ' . $type);
		}
		
		return self::IMAGE_TYPES[$type];
	}
	
	public function GalleryPictureImg($picture) {
		$ext = $this->getExtension($picture['picture_type']);
		return $this->settings->gallery_pictures_index."/{$picture['id']}.{$ext}";
	}
	
	public function GalleryThumbImg($picture) {
		$ext = $this->getExtension($picture['thumb_type']);
		return $this->settings->gallery_thumbs_index."/{$picture['id']}.{$ext}";
	}
	
	public function GalleryPicture($author, $id) {
		return $this->GalleryAuthor($author)."/".$id;
	}
	
	// streams
	public function Stream($id) {
		return $this->settings->streams_index."/".$id;
	}
	
	// paging
	function Page($base, $page) {
		return $base.($page == 1 ? "" : "?page={$page}");
	}
}
