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
					<?php
					$sql = "SELECT * FROM product_category ORDER BY dd";
					$result= mysqli_query($conn,$sql);
					if ($result) {
						while ($data = mysqli_fetch_array($result))
						{
							if ($data) {
							?>
							<li><a href="products?action=categorize&category=<?php echo htmlspecialchars($data["id"] ?? '');?>"><?php echo htmlspecialchars($data["name"] ?? '');?></a></li>
							<?php
							}
						}
					}
					?>
				</ul>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="products?action=display">Бүх бараа</a>
			</li>
			

		</ul>