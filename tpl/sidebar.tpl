<div id="sidebar-panels">
	<!-- IF online_stream -->
	<div class="panel panel-primary">
		<div class="panel-heading panel-title">Сейчас в эфире</div>
		<div class="panel-body panel-body-bare">
			<div class="stream-standalone">
			    <!-- IF online_stream.large_img_url -->
			    	<div class="stream-image">
			    		<a href="{online_stream.page_url}"><img class="card-image" src="{online_stream.large_img_url}" /></a>
						<span class="viewers"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> {online_stream.remote_viewers}</span>
			    	</div>
			    <!-- ENDIF -->
			   	<div class="title">
			   		<p>
			   			<a href="{online_stream.page_url}">{online_stream.title}</a>
			   			<!-- IF online_stream.channel -->
			   				<!-- IF online_stream.remote_status -->
			   				транслирует <b>{online_stream.remote_status}</b>
			   				<!-- ELSE -->
			   				ведет трансляцию
			   				<!-- ENDIF -->
			   			<!-- ELSE -->
			   			играет в <b>{online_stream.remote_game}</b>
			   			<!-- ENDIF -->
			   		</p>
			   		<p>Всего онлайн <a href="/streams">{online_stream.total_streams_online}</a></p>
			   	</div>
			</div>
		</div>
	</div>
	<!-- ENDIF -->
	<!-- IF latest_news -->
	<div class="panel panel-primary">
		<div class="panel-heading panel-title">Последние новости</div>
		<div class="panel-body linkblock">
	<!-- BEGIN latest_news -->
		  <a class="icon-{game.alias}" title="[{game.name}] {title}" href="{url}">{title} ({posts})</a>
	<!-- END latest_news -->
		</div>
	</div>
	<!-- ENDIF -->
	<!-- IF forum_topics -->
	<div class="panel panel-primary">
		<div class="panel-heading panel-title">Обсуждения</div>
		<div class="panel-body linkblock">
	<!-- BEGIN forum_topics -->
		  <a class="icon-{game.alias}" title="[{game.name}] {title}" href="{url}">{title} ({posts})</a>
	<!-- END forum_topics -->
		</div>
	</div>
	<!-- ENDIF -->
	<!-- IF articles -->
	<div class="panel panel-primary">
		<div class="panel-heading panel-title">Последние статьи</div>
		<div class="panel-body linkblock">
	<!-- BEGIN articles -->
		  <a class="icon-{game.alias}" title="[{game.name}] {title}" href="{url}">{title}</a>
	<!-- END articles -->
		</div>
	</div>
	<!-- ENDIF -->	
</div>
