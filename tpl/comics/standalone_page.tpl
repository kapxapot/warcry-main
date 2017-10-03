<div class="panel panel-primary">
	<div class="panel-heading panel-title">
	  <span class="icon-{game.alias}" title="[{game.name}] {title}">{title_ru}<!-- {page.number_str}--><!-- IF title_en --> <small>({title_en})</small><!-- ENDIF --></span>
	</div>
  	<div class="panel-body breadcrumbs">
  		<ol class="breadcrumb">
  			<li><a href="/">{sitename}</a></li>
  			<li><a href="{comics_index}">{comics_title}</a></li>
  			<li><a href="{comic.page_url}">{comic.name_ru}</a></li>
  			<li class="active">Страница {page.number_str}</li>
		</ol>
	</div>
<!-- IF page -->
  	<div class="panel-body gallery-picture">
  		<div>
  			<!-- IF page.next --><a href="{page.next.page_url}" title="Вперед: Страница {page.next.comic_number_str}"><!-- ENDIF -->
  				<img src="{page.url}" class="center img-responsive" />
  			<!-- IF page.next --></a><!-- ENDIF -->
  		</div>
  		<div class="center gallery-picture-nav">
			<nav aria-label="Навигация и действия со страницей" class="center" id="paging-bottom">
			  <ul class="pagination">
		  		<!-- IF page.prev --><li><a href="{page.prev.page_url}" title="Назад: Страница {page.prev.number_str}"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a></li><!-- ENDIF -->
		  		<li><a href="{page.url}" download="{title_ru} {comic.number_str} - {page.number_str} ({sitename}).jpg"><span class="glyphicon glyphicon-save" aria-hidden="true" title="Скачать"></span></a></li>
		  		<!-- IF page.next --><li><a href="{page.next.page_url}" title="Вперед: Страница {page.next.number_str}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a></li><!-- ENDIF -->
			  </ul>
			</nav>			
		</div>
   	</div>
<!-- ELSE -->
  	<div class="panel-body">
		<p>Страница не найдена.</p>
    </div>
<!-- ENDIF -->
</div>