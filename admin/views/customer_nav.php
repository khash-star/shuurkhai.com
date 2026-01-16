<ul class="navbar-nav aux-nav">
			<li class="nav-item">
				<a class="nav-link" href="customers?action=active">Идэвхитэй</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="customers?action=register">Бүртгэх</a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="customers?action=warehouse">Агуулахад ачаатай</a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="customers?action=incoming">Ирж буй ачаатай</a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="customers?action=error">Мэдээлэл алдаатай</a>
			</li>


			<li class="nav-item">
				<a class="nav-link" href="customers?action=new">Шинэ</a>
			</li>

			<li class="dropdown nav-item">
				<a class="nav-link" href="customers?action=category" data-toggle="dropdown" role="button" aria-haspopup="true">Ангилал <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="customers?action=category">Бүх ангилал</a></li>
					<?
					$sql = "SELECT *FROM customer_category ORDER BY dd";
					$result= mysqli_query($conn,$sql);
					while ($data = mysqli_fetch_array($result))
					{
						?>
						<li><a href="customers?action=categorize&category=<?=$data["id"];?>"><?=$data["name"];?></a></li>
						<?
					}
					?>
				</ul>
			</li>
			
			<li class="nav-item active">
				<a class="nav-link" href="customers?action=display">Бүгд </a>
			</li>
		</ul>