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
			    <!-- IF img_url -->
			    	<div class="stream-image">
				    	<a href="{page_url}"><img class="card-image" src="{img_url}" /></a>
			    		<span class="viewers">
			    			<!-- IF remote_online -->
			    				<span class="glyphicon glyphicon-user" aria-hidden="true"></span> {remote_viewers}
			    			<!-- ELSE -->
			    				оффлайн
			    			<!-- ENDIF -->
			    		</span>
			    	</div>
			    <!-- ENDIF -->
				<div class="card-body">
			    	<p>
			    		<a href="{page_url}">{title}</a>
			    		<!-- IF channel -->
			    			<!-- IF remote_status -->
					    		<!-- IF remote_online -->
					    			транслирует
					    		<!-- ELSE -->
					    			{remote_online_ago} {broadcasted}
					    		<!-- ENDIF -->
					    		<b>{remote_status}</b>
					    	<!-- ELSE -->
					    		<!-- IF remote_online -->
					    			ведет трансляцию
					    		<!-- ELSE -->
					    			{held} трансляцию {remote_online_ago}
					    		<!-- ENDIF -->
					    	<!-- ENDIF -->
			    		<!-- ELSE -->
				    		<!-- IF remote_online -->
				    			играет
				    		<!-- ELSE -->
				    			{remote_online_ago} {played}
				    		<!-- ENDIF -->
				    		в <b>{remote_game}</b>
			    		<!-- ENDIF -->
			    	</p>
				</div>
			</div>
<!-- END streams -->
		</div>
<!-- ELSE -->
		<p>Нет стримов. :(</p>
<!-- ENDIF -->
    </div>
</div>
