<div class="panel panel-primary">
	<div class="panel-heading panel-title">
	  <span class="icon-{game.alias}" title="[{game.name}] {title}">{title}</span>
	</div>
  	<div class="panel-body breadcrumbs">
  		<ol class="breadcrumb">
  			<li><a href="/">{sitename}</a></li>
  			<li><a href="{gallery_index}">{gallery_title}</a></li>
  			<li class="active">{title}</li>
		</ol>
	</div>
  	<div class="panel-body">
<!-- IF author.real_name -->
  		<p><strong>Настоящее имя:</strong> {author.real_name}<!-- IF author.real_name_en --> ({author.real_name_en})<!-- ENDIF --></p>
<!-- ENDIF -->
<!-- IF author.member_url -->
		<p><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <a href="{author.member_url}">Профиль на форуме</a></p>
<!-- ENDIF -->
<!-- IF author.deviant -->
		<p><span class="glyphicon glyphicon-picture" aria-hidden="true"></span> <a href="http://{author.deviant}.deviantart.com">Портфолио на DeviantArt</a></p>
<!-- ENDIF -->
<!-- IF author.description -->
  		<p>{author.description}</p>
<!-- ENDIF -->
<!-- IF pictures -->
		<div id="gallery" class="flex-wrapper">
<!-- BEGIN pictures -->
			<div class="flex-item flex-item-shaded">
				<a href="{page_url}">
					<img src="{thumb}" alt="{comment}" class="card-image" />
					<div class="card-body">
						<p>{comment}</p>
					</div>
				</a>
			</div>
<!-- END pictures -->
		</div>
<!-- ELSE -->
		<p>По заданным параметрам картинки не найдены.</p>
<!-- ENDIF -->
<!-- IF paging -->
		<div class="col-md-12 col-sm-12 col-xs-12">
			<nav aria-label="Навигация по страницам" class="center" id="paging-bottom">
			  <ul class="pagination">
<!-- BEGIN paging.pages -->
				<!-- IF current --><li class="active"><span>{label}</span></li><!-- ELSE --><li><a href="{url}" title="{title}">{label}</a></li><!-- ENDIF -->
<!-- END paging.pages -->
			  </ul>
			</nav>			
		</div>
<!-- ENDIF -->
    </div>
</div>