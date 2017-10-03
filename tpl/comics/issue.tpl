<div class="panel panel-primary">
	<div class="panel-heading panel-title">
	  <span class="icon-{game.alias}" title="[{game.name}] {title}">{title_ru} {comic.number_str}<!-- IF title_en --> <small>({title_en})</small><!-- ENDIF --></span>
	</div>
  	<div class="panel-body breadcrumbs">
  		<ol class="breadcrumb">
  			<li><a href="/">{sitename}</a></li>
  			<li><a href="{comics_index}">{comics_title}</a></li>
  			<li><a href="{series.page_url}">{series.name_ru}</a></li>
  			<li class="active">Выпуск {comic.number_str}</li>
		</ol>
	</div>
  	<div class="panel-body">
<!-- IF comic.issued_on -->
  		<p><b>Дата выхода:</b> {comic.issued_on}</p>
<!-- ENDIF -->
<!-- IF comic.description -->
  		<p>{comic.description}</p>
<!-- ENDIF -->
<!-- IF pages -->
		<div class="flex-wrapper comics-issue">
<!-- BEGIN pages -->
			<div class="flex-item flex-item-shaded">
				<a href="{page_url}" title="{number_str}"><img src="{thumb}" class="card-image" /></a>
				<div class="card-body">
			    	<p><a href="{page_url}">{number_str}</a></p>
				</div>
			</div>
<!-- END pages -->
		</div>
  		<div class="center gallery-picture-nav">
			<nav aria-label="Навигация и действия с комиксом" class="center" id="paging-bottom">
			  <ul class="pagination">
		  		<!-- IF comic.prev --><li><a href="{comic.prev.page_url}" title="Назад: Выпуск {comic.prev.number_str}"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a></li><!-- ENDIF -->
		  		<!-- IF comic.next --><li><a href="{comic.next.page_url}" title="Вперед: Выпуск {comic.next.number_str}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a></li><!-- ENDIF -->
			  </ul>
			</nav>			
		</div>
<!-- ELSE -->
		<p>По заданным параметрам комикс не найден.</p>
<!-- ENDIF -->
	</div>
</div>