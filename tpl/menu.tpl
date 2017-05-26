<li class="dropdown">
  <a class="dropdown-toggle" data-toggle="dropdown" href="#"><img src="{game.icon}" alt="{game.name}" class="navbar-img" /> <!-- IF game.default -->Игры<!-- ELSE -->{game.name}<!-- ENDIF --><b class="caret"></b></a>
  <ul class="dropdown-menu">
<!-- BEGIN games -->
    <!-- IF published --><li><a href="{url}" class="icon-menu icon-{alias}"><!-- IF default -->Все игры<!-- ELSE -->{name}<!-- ENDIF --></a></li><!-- ENDIF -->
<!-- END games -->
  </ul>
</li>
<!-- BEGIN menu -->
<!-- IF items -->
<li class="dropdown">
  <a class="dropdown-toggle" data-toggle="dropdown" href="{link}">{text}<b class="caret"></b></a>
  <ul class="dropdown-menu">
	<!-- BEGIN items -->
    <li><a href="{link}">{text}</a></li>
	<!-- END items -->
  </ul>
</li>
<!-- ELSE -->
<li><a href="{link}">{text}</a></li>
<!-- ENDIF -->
<!-- END menu -->