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
  	<div class="panel-body">
  		<p>В этом разделе собраны картинки на тему игр <b>Blizzard</b>, присланные нам на сайт или опубликованные на <a href="{forum_index}">форуме</a> (а также позаимствованные из портфолио художников). У нас вы можете найти как фан-арт, так и официальные работы, права на которые принадлежат <strong>Blizzard</strong>. Некоторые из художников начинали публиковать свои работы здесь, а теперь официально рисуют для любимой компании!</p>
  		<p>Если вы хотите опубликовать здесь свои работы, присылайте их <a href="mailto:{teammail}">по почте</a> или публикуйте на форуме <a href="{forum_topic}">в специальной теме</a>.</p>
<!-- IF authors -->
		<div id="gallery" class="flex-wrapper">
<!-- BEGIN authors -->
			<div class="flex-item flex-item-shaded">
		<!-- IF last_thumb_url -->
				<a href="{page_url}" title="{name}: {count} {pictures_str}"><img src="{last_thumb_url}" class="card-image" /></a>
		<!-- ENDIF -->
				<div class="card-body">
			    	<p><a href="{page_url}" title="{count} {pictures_str}"><strong>{name}</strong> ({count})</a></p>
				</div>
			</div>
<!-- END authors -->
		</div>
<!-- ELSE -->
		<p>Пока тут ничего нет. :(</p>
<!-- ENDIF -->
    </div>
</div>
