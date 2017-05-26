<div id="news-index">
	<!-- IF news -->
	<!-- BEGIN news -->
	<div class="panel panel-primary">
		<div class="panel-heading panel-title">
		  <a class="icon-{game.alias}" href="{url}" title="[{game.name}] {title}">{title}</a>
		</div>
	    <div class="panel-body news">
	    	{text}
	    </div>
	    <div class="panel-footer">
	    	<div class="glyphicon-block"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> {start_date}</div>
	    	<div class="glyphicon-block"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <a href="{starter_url}">{starter_name}</a></div>
	    	<div class="glyphicon-block"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> <a href="{forum_url}" title="Комментарии на форуме">{posts}</a></div>
	    	<!-- IF tags --><div class="glyphicon-block"><span class="glyphicon glyphicon-tag" aria-hidden="true"></span><!-- BEGIN tags --> <a href="{url}" title="Тег: {text}" class="label label-default">{text}</a><!-- END tags --></div><!-- ENDIF -->
	    </div>
	</div>
	<!-- END news -->
	<!-- ELSE -->
	<div>По заданному вами запросу новостей нет. Возможно, эта ссылка сформированна неверно или устарела.</div>
	<!-- ENDIF -->
	<div class="all-news"><a href="{news_index}">Все новости &raquo;&raquo;</a></div>
</div>
