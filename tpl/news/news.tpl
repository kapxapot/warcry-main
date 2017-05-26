<!-- IF news -->
<div class="panel panel-primary">
	<div class="panel-heading panel-title">
	  <span class="icon-{news.game.alias}" title="[{news.game.name}] {news.title}">{news.title}</span>
	</div>
  	<div class="panel-body breadcrumbs">
  		<ol class="breadcrumb">
  			<li><a href="/">{sitename}</a></li>
  			<!-- IF news.game.url --><li><a href="{news.game.url}">{news.game.name}</a></li><!-- ENDIF -->
  			<li class="active">{news.title}</li>
		</ol>
	</div>
  	<div class="panel-body news">
    	{news.text}
    </div>
    <div class="panel-footer">
    	<div class="glyphicon-block"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> {news.start_date}</div>
    	<div class="glyphicon-block"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <a href="{news.starter_url}">{news.starter_name}</a></div>
    	<div class="glyphicon-block"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> <a href="{news.forum_url}" title="Комментарии на форуме">{news.posts}</a></div>
    	<!-- IF news.tags --><div class="glyphicon-block"><span class="glyphicon glyphicon-tag" aria-hidden="true"></span><!-- BEGIN news.tags --> <a href="{url}" title="Тег: {text}" class="label label-default">{text}</a><!-- END tags --></div><!-- ENDIF -->
    </div>
</div>
<!-- ELSE -->
<div class="verticalspace">По вашему запросу новость не найдена. Возможно, эта ссылка сформирована неверно или устарела.</div>
<!-- ENDIF -->