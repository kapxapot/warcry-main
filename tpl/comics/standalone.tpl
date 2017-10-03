<div class="panel panel-primary">
	<div class="panel-heading panel-title">
	  <span class="icon-{game.alias}" title="[{game.name}] {title}">{title_ru}<!-- IF title_en --> <small>({title_en})</small><!-- ENDIF --></span>
	</div>
  	<div class="panel-body breadcrumbs">
  		<ol class="breadcrumb">
  			<li><a href="/">{sitename}</a></li>
  			<li><a href="{comics_index}">{comics_title}</a></li>
  			<li class="active">{comic.name_ru}</li>
		</ol>
	</div>
  	<div class="panel-body">
<!-- IF comic.publisher -->
  		<p><b>Издательство:</b> <a href="{comic.publisher.website}">{comic.publisher.name}</a></p>
<!-- ENDIF -->
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
<!-- ELSE -->
		<p>По заданным параметрам комикс не найден.</p>
<!-- ENDIF -->
	</div>
</div>