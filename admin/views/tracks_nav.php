<ul class="navbar-nav aux-nav">	
	<li class="nav-item"><a class="nav-link" href="tracks?action=active">Идэвхитэй трак</a></li>		
	<li class="nav-item"><a class="nav-link" href="tracks?action=search">Трак хайх</a></li>		
	<?php
	if (isset($_GET["id"]))
	{
		$track_id = intval($_GET["id"]);
		?>
		<li class="nav-item"><a class="nav-link" href="orders?action=detail&id=<?php echo htmlspecialchars($track_id);?>">Дэлгэрэнгүй</a></li>
		<li class="nav-item"><a target="new" class="nav-link" href="cp72?id=<?php echo htmlspecialchars($track_id);?>">Хэвлэх</a></li>
		<?php
	}
	?>
</ul>