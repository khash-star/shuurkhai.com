<ul class="navbar-nav aux-nav">
			<li class="nav-item">
				<a class="nav-link" href="news?action=new">Шинэ мэдээ</a>
			</li>

			<li class="dropdown nav-item">
				<a class="nav-link" href="news_category" data-toggle="dropdown" role="button" aria-haspopup="true">Ангилал <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="news_category">Бүх ангилал</a></li>
					<?php
					$sql = "SELECT * FROM news_category ORDER BY name";
					$result= mysqli_query($conn,$sql);
					if ($result) {
						while ($data = mysqli_fetch_array($result))
						{
							if ($data) {
							?>
							<li><a href="news?action=categorize&category=<?php echo htmlspecialchars($data["id"]);?>"><?php echo htmlspecialchars($data["name"]);?></a></li>
							<?php
							}
						}
					}
					?>
				</ul>
			</li>
			
			<li class="nav-item active">
				<a class="nav-link" href="news?action=display">Бүгд </a>
			</li>
		</ul>