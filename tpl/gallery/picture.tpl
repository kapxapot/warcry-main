<div class="panel panel-primary">
	<div class="panel-heading panel-title">
	  <span class="icon-{game.alias}" title="[{game.name}] {title}">{title}</span>
	</div>
  	<div class="panel-body breadcrumbs">
  		<ol class="breadcrumb">
  			<li><a href="/">{sitename}</a></li>
  			<li><a href="{gallery_index}">{gallery_title}</a></li>
  			<li><a href="{author.page_url}">{author.name}</a></li>
  			<li class="active">{title}</li>
		</ol>
	</div>
<!-- IF picture -->
  	<div class="panel-body gallery-picture">
  		<div>
  			<!-- IF picture.next --><a href="{picture.next.page_url}" title="Вперед: {picture.next.comment}"><!-- ENDIF -->
  				<img src="{picture.url}" class="center img-responsive" />
  			<!-- IF picture.next --></a><!-- ENDIF -->
  		</div>
  		<!-- IF picture.description -->
  		<div class="gallery-picture-description">{picture.description}</div>
  		<!-- ENDIF -->
  		<div class="center gallery-picture-nav">
			<nav aria-label="Навигация и действия с картинкой" class="center" id="paging-bottom">
			  <ul class="pagination">
		  		<!-- IF picture.prev --><li><a href="{picture.prev.page_url}" title="Назад: {picture.prev.comment}"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a></li><!-- ENDIF -->
		  		<li><a href="{picture.url}" download="{author.name} - {picture.comment} ({sitename}).jpg"><span class="glyphicon glyphicon-save" aria-hidden="true" title="Скачать"></span></a></li>
		  		<!-- IF picture.next --><li><a href="{picture.next.page_url}" title="Вперед: {picture.next.comment}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a></li><!-- ENDIF -->
			  </ul>
			</nav>			
		</div>
   	</div>
    <div class="panel-footer">
    	<!-- IF author --><div class="glyphicon-block"><span class="glyphicon glyphicon-user" aria-hidden="true" title="Автор"></span> <a href="{author.page_url}">{author.name}</a><!-- IF author.real_name --> ({author.real_name})<!-- ENDIF --></div><!-- ENDIF -->
    	<div class="glyphicon-block"><span class="glyphicon glyphicon-time" aria-hidden="true" title="Дата добавления"></span> {picture.created_at}</div>
    	<!-- IF picture.official --><div class="glyphicon-block"><span class="glyphicon glyphicon-copyright-mark" aria-hidden="true" title="Копирайт"></span> Официальный арт</div><!-- ENDIF -->
    </div>
<!-- ELSE -->
  	<div class="panel-body">
		<p>Картинка не найдена.</p>
    </div>
<!-- ENDIF -->
</div>