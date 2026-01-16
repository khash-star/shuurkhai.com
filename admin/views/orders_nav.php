<ul class="navbar-nav aux-nav">
	<li class="nav-item"><a class="nav-link" href="orders?action=dashboard">Илгээмжүүд</a></li>
		<?
		if (isset($_GET["id"]))
		{
			$order_id = intval($_GET["id"]);
			?>
			<li class="nav-item"><a class="nav-link" href="orders?action=detail&id=<?=$order_id;?>">Дэлгэрэнгүй</a></li>
			<li class="nav-item"><a class="nav-link" href="orders?action=delete&id=<?=$order_id;?>">Устгах</a></li>
			<li class="nav-item"><a target="new" class="nav-link" href="cp72?id=<?=$order_id;?>">Хэвлэх</a></li>
			<?
		}
		?>
</ul>