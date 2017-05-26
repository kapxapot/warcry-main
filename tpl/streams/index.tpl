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
<!-- IF streams -->
		<div id="streams" class="flex-wrapper">
<!-- BEGIN streams -->
			<div class="flex-item flex-item-shaded">
			    <!-- IF img_url --><a href="{page_url}"><img class="card-image" src="{img_url}" /></a><!-- ENDIF -->
				<div class="card-body">
			    	<p><a href="{page_url}">{title}</a></p>
				</div>
			    <span class="viewers"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> {viewers}</span>
			</div>
<!-- END streams -->
		</div>
<!-- ELSE -->
		<p>Пока тут ничего нет. :(</p>
<!-- ENDIF -->
    </div>
</div>
