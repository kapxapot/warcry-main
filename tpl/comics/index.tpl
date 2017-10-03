<div class="panel panel-primary">
	<div class="panel-heading panel-title">
	  <span class="icon-{game.alias}" title="[{game.name}] {title}">{title}</span>
	</div>
  	<div class="panel-body breadcrumbs">
  		<ol class="breadcrumb">
  			<li><a href="/">{sitename}</a></li>
  			<li class="active">{title}</li>
		</ol>
	</div>
<!-- IF series -->
  	<div class="panel-body">
  		<h4>Серии комиксов</h4>
		<div class="flex-wrapper comics">
<!-- BEGIN series -->
			<div class="flex-item flex-item-shaded">
				<a href="{page_url}" title="{name_ru} ({comic_count_str})"><img src="{cover_url}" class="card-image" /></a>
				<div class="card-body">
			    	<p><a href="{page_url}">{name_ru}</a></p>
				</div>
			</div>
<!-- END series -->
		</div>
	</div>
<!-- ENDIF -->
<!-- IF comics -->
  	<div class="panel-body">
  		<h4>Одиночные комиксы</h4>
		<div class="flex-wrapper comics">
<!-- BEGIN comics -->
			<div class="flex-item flex-item-shaded">
				<a href="{page_url}" title="{name_ru}"><img src="{cover_url}" class="card-image" /></a>
				<div class="card-body">
			    	<p><a href="{page_url}">{name_ru}</a></p>
				</div>
			</div>
<!-- END comics -->
		</div>
    </div>
<!-- ENDIF -->
</div>
