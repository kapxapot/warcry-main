<!-- IF valid_article -->
<div class="panel panel-primary">
	<div class="panel-heading panel-title">
	  <span class="icon-{game.alias}" title="[{game.name}] {title}">{title_ru}<!-- IF title_en --> <small>({title_en})</small><!-- ENDIF --></span>
	</div>
  	<div class="panel-body breadcrumbs">
  		<ol class="breadcrumb">
  			<li><a href="/">{sitename}</a></li>
  			<!-- IF game.url --><li><a href="{game.url}">{game.name}</a></li><!-- ENDIF -->
  			<!-- BEGIN breadcrumbs -->
  			<li>{link}</li>
  			<!-- END breadcrumbs -->
  			<li class="active">{title_ru}</li>
		</ol>
	</div>
	<!-- IF sub_articles -->
  	<div class="panel-body sub-articles">
  		<!-- BEGIN sub_articles -->{link}<!-- END sub_articles -->
	</div>
	<!-- ENDIF -->
	{contents}
  	<div class="panel-body" id="article">
    	{text}
    </div>
    <div class="panel-footer">
    	<!-- IF author --><div class="glyphicon-block"><span class="glyphicon glyphicon-user" aria-hidden="true" title="Автор"></span> <!-- IF author.member_url --><a href="{author.member_url}">{author.name}</a><!-- ELSE -->{author.name}<!-- ENDIF --></div><!-- ENDIF -->
    	<div class="glyphicon-block"><span class="glyphicon glyphicon-time" aria-hidden="true" title="Дата создания"></span> {created_at}</div>
    	<!-- IF editor --><div class="glyphicon-block"><span class="glyphicon glyphicon-pencil" aria-hidden="true" title="Редактор"></span> <!-- IF editor.member_url --><a href="{editor.member_url}">{editor.name}</a><!-- ELSE -->{editor.name}<!-- ENDIF --></div><!-- ENDIF -->
    	<!-- IF updated_at --><div class="glyphicon-block"><span class="glyphicon glyphicon-time" aria-hidden="true" title="Дата редакции"></span> {updated_at}</div><!-- ENDIF -->
    	<!-- IF origin --><div class="glyphicon-block"><span class="glyphicon glyphicon-copyright-mark" aria-hidden="true" title="Источник"></span> <a href="{origin}">Источник</a></div><!-- ENDIF -->
    </div>
</div>
<!-- ELSE -->
<div class="verticalspace">По вашему запросу статья не найдена. Возможно, эта ссылка сформирована неверно или устарела.</div>
<!-- ENDIF -->