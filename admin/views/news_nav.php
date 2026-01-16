<ul class="navbar-nav aux-nav">
			<li class="nav-item">
				<a class="nav-link" href="news?action=new">Шинэ мэдээ</a>
			</li>

			<li class="dropdown nav-item">
				<a class="nav-link" href="news_category" data-toggle="dropdown" role="button" aria-haspopup="true">Ангилал <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="news_category">Бүх ангилал</a></li>
					<?
					$sql = "SELECT *FROM news_category ORDER BY name";
					$result= mysqli_query($conn,$sql);
					while ($data = mysqli_fetch_array($result))
					{
						?>
						<li><a href="news?action=categorize&category=<?=$data["id"];?>"><?=$data["name"];?></a></li>
						<?
					}
					?>
				</ul>
			</li>
			
			<li class="nav-item active">
				<a class="nav-link" href="news?action=display">Бүгд </a>
			</li>
		</ul>