<div class="panel panel-primary">
	<div class="panel-heading panel-title">
	  <span class="icon-{game.alias}" title="[{game.name}] {title}">{title_ru}<!-- IF title_en --> <small>({title_en})</small><!-- ENDIF --></span>
	</div>
  	<div class="panel-body breadcrumbs">
  		<ol class="breadcrumb">
  			<li><a href="/">{sitename}</a></li>
  			<li><a href="{comics_index}">{comics_title}</a></li>
  			<li class="active">{title_ru}</li>
		</ol>
	</div>
  	<div class="panel-body">
<!-- IF series.publisher -->
  		<p><b>Издательство:</b> <a href="{series.publisher.website}">{series.publisher.name}</a></p>
<!-- ENDIF -->
<!-- IF series.description -->
  		<p>{series.description}</p>
<!-- ENDIF -->
<!-- IF comics -->
		<div class="flex-wrapper comics">
<!-- BEGIN comics -->
			<div class="flex-item flex-item-shaded">
				<a href="{page_url}" title="Выпуск {number_str}"><img src="{cover_url}" class="card-image" /></a>
				<div class="card-body">
			    	<p><a href="{page_url}">Выпуск {number_str}</a></p>
				</div>
			</div>
<!-- END comics -->
		</div>
<!-- ELSE -->
		<p>По заданным параметрам комиксы не найдены.</p>
<!-- ENDIF -->
    </div>
</div>