<div class="panel panel-primary">
	<div class="panel-heading panel-title">
	  <span class="icon-{game.alias}" title="[{game.name}] {title}">{title}</span>
	</div>
  	<div class="panel-body breadcrumbs">
  		<ol class="breadcrumb">
  			<li><a href="/">{sitename}</a></li>
  			<li><a href="{streams_index}">{streams_title}</a></li>
  			<li class="active">{title}</li>
		</ol>
	</div>
  	<div class="panel-body stream">
  		<!-- IF stream -->
		<div class="embed-responsive embed-responsive-16by9">
			<!-- IF stream.twitch -->
			<iframe class="embed-responsive-item" id="live_embed_player_flash" src="https://player.twitch.tv/?channel={stream.stream_id}" allowfullscreen="true" width="640" height="360"></iframe>
			<!-- ENDIF -->
			<!-- IF stream.own3d -->
    		<iframe class="embed-responsive-item" src="http://www.own3d.tv/liveembed/{stream.stream_id}" allowfullscreen="true" width="640" height="360"></iframe>
			<!-- ENDIF -->
		</div>
		<div class="stream-description">
			<div class="col-md-6 col-xs-12">
				<p><b>Канал:</b> <!-- IF stream.stream_url --><a href="{stream.stream_url}">{stream.title}</a><!-- ELSE -->{stream.title}<!-- ENDIF --></p>
				<!-- IF stream.online -->
				<p><b>Зрители:</b> {stream.viewers}</p>
				<!-- ELSE -->
				<p>Оффлайн</p>
				<!-- ENDIF -->
				<!-- IF stream.game -->
				<p><b>Игра:</b> {stream.game}</p>
				<!-- ENDIF -->
				<!-- IF stream.status -->
				<p><b>Описание:</b> {stream.status}</p>
				<!-- ENDIF -->
				<!-- IF stream.logo -->
				<img src="{stream.logo}" class="stream-logo" />
				<!-- ENDIF -->
			</div>
			<!-- IF stream.twitch -->
			<div class="col-md-6 col-xs-12">
				<iframe id="chat_embed" src="http://twitch.tv/chat/embed?channel={stream.stream_id}&popout_chat=true" height="500" width="100%" frameborder="0" scrolling="no"></iframe>
			</div>
			<!-- ENDIF -->
		</div>
		<!-- ELSE -->
			<p>Стрим не найден.</p>
		<!-- ENDIF -->
    </div>
</div>
