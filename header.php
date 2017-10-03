<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <meta name="theme-color" content="#222" />
    
    <!-- coded by kapxapot &copy; 2004-<?php echo date("Y"); ?> -->
    
	<title><?php
	if (isset($title)) {
		echo "{$title} - ";
	}
	echo $sitename;
	if (!isset($title)) {
		echo " - {$short_site_description}";
	}
	?></title>
	<meta name="copyright" content="(c) 2004—<?php echo date("Y"); ?> Copyright by Warcry.ru" />
	<meta name="keywords" content="world of warcraft, warcraft, world, wow, вов, варкрафт, starcraft, starcraft 2, старкрафт, старкрафт 2, diablo, diablo 2, diablo 3, диабло, дьябло, дьябла, hearthstone heroes of warcraft, hearthstone, хартстоун, heroes of the storm, hots, overwatch, овервотч, blizzard, близзард, альянс, орда, alliance, horde, люди, орки, таурены, нежить, ночные эльфы, тролли, дворфы, гномы, human, orc, tauren, undead, night elf, elves, troll, dwarf, gnome, воин, маг, шаман, разбойник, рога, прист, жрец, варлок, чернокнижник, друид, охотник, хантер, паладин, warrior, mage, shaman, rogue, priest, warlock, druid, hunter, paladin, игра, ролевая, ролевые, игры, role-playing, roleplaying, role, playing, рпг, rpg, mmorpg, game, games, faq, forum, форум, форумы, скриншот, арт, фан-арт, screen, screenshot, art, fan, файлы, скачать, патчи, патч, рецепты, статьи, новости" />
	<meta name="description" content="<?php
	if (!isset($page_description)) {
		if (isset($title)) {
			echo "{$title} - ";
		}
		echo $sitename . ' - ' . $sitedescription;
	}
	else {
		echo $page_description;
	}
	?>" />
	
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:site" content="@warcry_ru" />
	<meta name="twitter:title" content="<?php echo (isset($title) ? $title : $sitename); ?>" />
	<meta name="twitter:description" content="<?php echo (isset($page_description) ? $page_description : $sitedescription); ?>" />
	<meta name="twitter:image" content="<?php echo $twitter_card_image; ?>" />

    <link rel="shortcut icon" href="/favicon.ico" />
	
	<!--link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"-->

    <link href="<?php echo $folders['absolute']; ?>css/bootstrap.css" rel="stylesheet" />
    <link href="<?php echo $folders['absolute']; ?>css/warcry.css" rel="stylesheet" />
    <link href="<?php echo $folders['colorbox']; ?>colorbox.css" rel="stylesheet" />
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<link rel="alternate" type="application/rss+xml" title="Warcry.ru RSS" href="http://feeds.feedburner.com/warcryru" />
	<link rel="search" href="/search.xml" type="application/opensearchdescription+xml" title="Warcry.ru"/>
	
	<?php if ($rel_prev) echo "<link rel=\"prev\" href=\"{$rel_prev}\" />", PHP_EOL; ?>
	<?php if ($rel_next) echo "<link rel=\"next\" href=\"{$rel_next}\" />", PHP_EOL; ?>

	<!-- VK -->
	<script type="text/javascript" src="//vk.com/js/api/openapi.js?78"></script>
	<!-- Google Analytics -->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-1465426-1', 'auto');
	  ga('send', 'pageview');
	</script>
  </head>
  <body>
    <!-- nav bar -->
    <div class="navbar navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Меню</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
		  <a href="<? if (isset($home)) { echo $home; } else { echo "/"; } ?>"><img class="logo" src="<?php echo $logo; ?>" alt="<? echo $sitename; ?> - <? echo $sitedescription; ?>" title="<? echo $sitename; ?> - <? echo $sitedescription; ?>" /></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse navbar-left">
          <ul class="nav navbar-nav">
<?php
	$menu_game = $game ? $game : $db->GetDefaultGame();

	$tpl = new SmartTemplate("{$folders['templates']}menu.tpl");
	
	$games = $db->GetGames();
	$tpl->assign('games', $builder->GamesWithUrls($games));

	$tpl->assign('game', $menu_game);
	$tpl->assign('menu', $builder->BuildMenu($menu_game));
	$tpl->output();
?>
          </ul>
        </div>
      </div>
    </div>

    <div class="container">
      <!-- content -->
      <div class="row">
        <!-- main -->
        <div id="main" class="<? if (!$oneColumn) echo "col-md-9 "; ?>col-xs-12">
