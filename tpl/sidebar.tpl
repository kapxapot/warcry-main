<div id="sidebar-panels">
	<!-- IF latest_news -->
	<div class="panel panel-primary">
		<div class="panel-heading panel-title">
		  Последние новости
		</div>
		<div class="panel-body linkblock">
	<!-- BEGIN latest_news -->
		  <a class="icon-{game.alias}" title="[{game.name}] {title}" href="{url}">{title} ({posts})</a>
	<!-- END latest_news -->
		</div>
	</div>
	<!-- ENDIF -->
	<!-- IF forum_topics -->
	<div class="panel panel-primary">
		<div class="panel-heading panel-title">
		  Обсуждения
		</div>
		<div class="panel-body linkblock">
	<!-- BEGIN forum_topics -->
		  <a class="icon-{game.alias}" title="[{game.name}] {title}" href="{url}">{title} ({posts})</a>
	<!-- END forum_topics -->
		</div>
	</div>
	<!-- ENDIF -->
	<!-- IF articles -->
	<div class="panel panel-primary">
		<div class="panel-heading panel-title">
		  Последние статьи
		</div>
		<div class="panel-body linkblock">
	<!-- BEGIN articles -->
		  <a class="icon-{game.alias}" title="[{game.name}] {title}" href="{url}">{title}</a>
	<!-- END articles -->
		</div>
	</div>
	<!-- ENDIF -->	
</div>
