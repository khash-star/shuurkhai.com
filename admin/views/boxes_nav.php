<ul class="navbar-nav aux-nav">
	<li class="nav-item"><a class="nav-link" href="?action=dashboard">Удирдлага</a></li>
	<li class="nav-item"><a class="nav-link" href="?action=active">Идэвхитэй</a></li>
	<li class="nav-item"><a class="nav-link" href="?action=search">Хайх</a></li>
	<li class="nav-item"><a class="nav-link" href="?action=combine">Нэгтгэсэн ачаа</a></li>
	<li class="nav-item"><a class="nav-link" href="?action=history">Түүх</a></li>
	<li class="nav-item"><a class="nav-link" href="?action=excel">Excel файл шинэчлэх</a></li>
    <?php
    if (isset($_GET["id"]))
    {
        $order_id = intval($_GET["id"]);
        ?>
        <li class="nav-item"><a class="nav-link" href="?action=detail&id=<?php echo htmlspecialchars($order_id);?>">Box дэлгэрэнгүй</a></li>
        <li class="nav-item"><a class="nav-link" href="?action=badge&id=<?php echo htmlspecialchars($order_id);?>">Box гадуур дагавар</a></li>
        <li class="nav-item"><a class="nav-link" href="?action=delete&id=<?php echo htmlspecialchars($order_id);?>">Box Устгах</a></li>
        <?php
    }
    ?>
</ul>