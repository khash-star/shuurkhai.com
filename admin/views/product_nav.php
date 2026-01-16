<ul class="navbar-nav aux-nav">
			<li class="nav-item">
				<a class="nav-link" href="products?action=add">Бараа нэмэх <span class="sr-only">(current)</span></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="products?action=active">Эрэлт ихтэй бараа</a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="products?action=new">Шинэхэн бараа</a>
			</li>


			<li class="dropdown nav-item">
				<a class="nav-link" href="products?action=category" data-toggle="dropdown" role="button" aria-haspopup="true">Ангилал <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="products?action=category">Бүх ангилал</a></li>
					<?
					$sql = "SELECT *FROM product_category ORDER BY dd";
					$result= mysqli_query($conn,$sql);
					while ($data = mysqli_fetch_array($result))
					{
						?>
						<li><a href="products?action=categorize&category=<?=$data["id"];?>"><?=$data["name"];?></a></li>
						<?
					}
					?>
				</ul>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="products?action=display">Бүх бараа</a>
			</li>
			

		</ul>