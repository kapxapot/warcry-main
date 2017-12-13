<?php
	if (!$no_social) {
?>
			<div id="social-share">
<!-- UpToLike BEGIN -->
				<script type="text/javascript">(function(w,doc) {
				if (!w.__utlWdgt ) {
				    w.__utlWdgt = true;
				    var d = doc, s = d.createElement('script'), g = 'getElementsByTagName';
				    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
				    s.src = ('https:' == w.location.protocol ? 'https' : 'http')  + '://w.uptolike.com/widgets/v1/uptolike.js';
				    var h=d[g]('body')[0];
				    h.appendChild(s);
				}})(window,document);
				</script>
				<div data-background-alpha="0.0" data-buttons-color="#FFFFFF" data-counter-background-color="#ffffff" data-share-counter-size="16" data-top-button="false" data-share-counter-type="disable" data-share-style="1" data-mode="share" data-like-text-enable="false" data-mobile-view="false" data-icon-color="#ffffff" data-orientation="horizontal" data-text-color="#000000" data-share-shape="round-rectangle" data-sn-ids="fb.vk.tw.gp." data-share-size="30" data-background-color="#ffffff" data-preview-mobile="false" data-mobile-sn-ids="fb.vk.tw.wh.ok.vb." data-pid="1655357" data-counter-background-alpha="1.0" data-following-enable="false" data-exclude-show-more="false" data-selection-enable="false" class="uptolike-buttons" ></div>
<!-- UpToLike END -->
			</div>
<?php
	}

	if (!$no_disqus) {
?>
			<div id="comments">
<!-- Disqus -->
				<noindex>
				<div id="disqus_thread"></div>
				<script type="text/javascript">
				<?php
				if (isset($disqus_id)) {
					print("var disqus_identifier = '$disqus_id';
				");
				}
				
				if (isset($disqus_url)) {
					print("var disqus_url = '$disqus_url';
				");
				}
				?>
				  (function() {
				   var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
				   dsq.src = 'http://warcry-ru.disqus.com/embed.js';
				   (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
				  })();
				</script>
				<noscript>Включите JavaScript для просмотра <a href="http://disqus.com/?ref_noscript">комментариев Disqus</a>.</noscript>
				<a href="http://disqus.com" class="dsq-brlink">комментарии работают на <span class="logo-disqus">Disqus</span></a>
				</noindex>
<!-- Disqus End -->
			</div>
<?php
	}
?>
<!-- Google AdSense горизонтальный нижний -->
			<div id="ad-bottom" class="hidden-xs">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- Горизонтальный нижний для wc -->
				<ins class="adsbygoogle"
					style="display:inline-block;width:728px;height:90px"
				    data-ad-client="ca-pub-9578510786813714"
					data-ad-slot="9622218446"></ins>
				<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
<!-- End of Google AdSense -->
        </div>

<!-- SIDEBAR -->
        <div id="sidebar" class="<? if (!$oneColumn) echo "col-md-3 "; ?>col-xs-12">
<!-- Search -->
			<div id="search">
	            <form class="form-inline" method="get" action="http://www.google.com/search" onSubmit="search(this)">
					<input name="q" type="hidden" />
				  <div class="input-group">
					<input name="qfront" type="search" required class="form-control" placeholder="Искать..." maxlength="255" />
					<span class="input-group-btn">
		              <button type="submit" class="btn btn-primary" aria-label="Поиск">
						<span class="glyphicon glyphicon-search" aria-hidden="true" />
					  </button>
					</span>
				  </div>
	            </form>
			</div>
<!-- Search end -->

<?php
	$tpl = new SmartTemplate("{$folders['templates']}sidebar.tpl");
	$tpl->assign('articles', $articles);
	$tpl->assign('forum_topics', $forum_topics);
	$tpl->assign('latest_news', $latest_news);
	$tpl->assign('online_stream', $online_stream);
	$tpl->output();
?>

<!-- Google AdSense вертикальный боковой -->
			<div id="ad-sidebar"<? if ($oneColumn) echo ' class="visible-xs"'; ?>>
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- Вертикальный для wc -->
				<ins class="adsbygoogle"
				     style="display:inline-block;width:240px;height:400px"
				     data-ad-client="ca-pub-9578510786813714"
				     data-ad-slot="5192018847"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
<!-- End of Google AdSense -->
		<?

if (isset($index)) {
?>
<!-- VK Widget -->
			<div id="vk">
				<div id="vk_groups" class="center"></div>
				<script type="text/javascript">
					$(function() {
						loadScript('//vk.com/js/api/openapi.js?150', function() {
							VK.Widgets.Group("vk_groups", { mode: 0, width: "240", height: "290" }, 18630942);
						});
					});
				</script>
			</div>
<?php
}
?>

			<div id="site-buttons">
				<div id="gd-button">
					<a href="http://grimdawn.ru">Grim Dawn по-русски</a>
				</div>

	            <a href="http://dacomics.ru/" title="Комиксы и стрипы по играм. Dragon Age, World of Warcraft, Deus Ex и многое другое!"><img src="http://dacomics.ru/images/button.gif" alt=""></a>

	            <a href="http://subgames.ru/" title="Субъективно об играх — Заметки об играх"><img src="/images/subgames88x31.png" alt=""></a>
			</div>
			
			<div id="fansite">
				<a href="http://eu.battle.net/" title="Warcry.ru — официальный фан-сайт Blizzard"><img src="/images/blizzard_fansite_gold.gif" alt=""></a>
			</div>
        </div>
      </div>
    </div>
<!-- end of SIDEBAR -->

<!-- FOOTER -->
    <div id="footer" class="navbar navbar-inverse">
      <div class="container dark">
        <div class="row">
          <ul class="nav nav-pills">
            <li><a href="/article/Links">Ссылки</a></li>
            <?php /*<li><a href="/downloads/">Файлы</a></li>
            <li><a href="/tag/">Теги</a></li>*/ ?>
            <li><a href="/map/">Карта сайта</a></li>
            <li><a href="/article/About">О сайте</a></li>
            <li><a href="/article/Jobs">Вакансии</a></li>
            <li><a href="/article/Cooperation">Сотрудничество</a></li>
            <li><a href="/article/Contacts">Контакты</a></li>
          </ul>
        </div>
     
		<!-- social links -->
		<div><?php echo $sitename; ?> в социальных сетях и сервисах:</div>
		<div id="social-links">
			<a href="http://feeds.feedburner.com/warcryru"><img src="/images/sharelarge/rss.png" alt="Наши новости в формате RSS" /></a>
			<a href="https://eu.blizzard.com/invite/ePB7oUZgw"><img src="/images/sharelarge/battlenet.png" alt="Мы в Blizzard Battle.net" /></a>
			<a href="http://twitter.com/warcry_ru"><img src="/images/sharelarge/twitter.png" alt="Мы в Twitter" /></a>
			<a href="http://vk.com/warcry_ru"><img src="/images/sharelarge/vk.png" alt="Мы ВКонтакте" /></a>
			<!--a href="https://www.facebook.com/pages/Warcryru/240114022746294"><img src="/images/sharelarge/facebook.png" alt="Мы в Facebook" /></a-->
			<!--a href="https://plus.google.com/u/0/b/118030010104701570479/118030010104701570479/posts"><img src="/images/sharelarge/googleplus.png" alt="Мы в Google+" /></a-->
			<a href="http://youtube.com/user/WarcryCast/videos"><img src="/images/sharelarge/youtube.png" alt="Мы в YouTube" /></a>
			<a href="http://twitch.tv/warcryru"><img src="/images/sharelarge/twitch.png" alt="Мы на Twitch" /></a>
		</div>
     
        <div>Все права защищены. &copy; 2004—<?php echo date("Y"); ?> <a href="mailto:<?php echo $teammail; ?>"><?php echo $sitename; ?></a></div>
        <div>При копировании материалов ссылка на источник обязательна.</div>
        <div id="disclaimer">Все товарные знаки являются собственностью соответствующих владельцев. &copy; Blizzard Entertainment, <?php echo date("Y"); ?> г. Все права защищены.</div>
      </div>
    </div>

    <!-- scripts -->
    <script src="<?php echo $folders['bootstrap']; ?>js/bootstrap.min.js"></script>
    <script src="<?php echo $folders['colorbox']; ?>jquery.colorbox.js"></script>
    <script src="<?php echo $folders['absolute']; ?>js/warcry.js"></script>

	<!-- Wowhead etc. -->  
	<script async src="http://www.wowhead.com/widgets/power.js"></script>
	<script async src="http://eu.battle.net/d3/static/js/tooltips.js"></script>
  </body>
</html>
