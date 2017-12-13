<?php

class BootstrapSettings extends Settings {
	public $absolute_index_page = 'http://warcry.ru';

	public $forum_index = '/forum';
	public $forum_page = '/forum/index.php';

	public $gallery_index = '/gallery';
	public $gallery_pictures_index = '/gallery/pictures';
	public $gallery_thumbs_index = '/gallery/pictures/thumb';

	public $streams_index = '/streams';

	public $comics_index = '/comics';
	public $comics_pages_index = '/comics/pages';
	public $comics_thumbs_index = '/comics/pages/thumb';
	
	public $gallery_title = 'Галерея';
	public $streams_title = 'Стримы';
	public $comics_title = 'Комиксы';

	public $news_limit = 7;
	public $sidebar_article_limit = 7;
	public $sidebar_forum_topic_limit = 7;
	public $sidebar_latest_news_limit = 7;

	public $default_game_id = 5;
	public $hidden_forum_ids = 3;
	
	public $date_format = "%d.%m.%Y";
	
	public $twitch_client_id = 'your twitch key';
	public $telegram_bot_token = 'your telegram bot token';
	public $telegram_chat_id = 'your telegram chat id';
	public $warcry_channel_id = '@warcry_ru';
}
