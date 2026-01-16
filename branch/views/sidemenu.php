<header class="main-nav">
  <div class="sidebar-user text-center d-none d-lg-block">
    <a class="setting-primary" href="profile"><i data-feather="settings"></i></a>
    <img class="img-90 rounded-circle" height="90" src="../<?=$g_logged_avatar;?>" alt="">
      <div class="badge-bottom"><span class="badge badge-primary"></span>
  </div>
  <a href="profile"><h6 class="mt-3 f-14 f-w-600"><?=$g_logged_name;?></h6></a>
  </div>
  <nav>
    <div class="main-navbar">
      <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
      <div id="mainnav">           
        <ul class="nav-menu custom-scrollbar">
          <li class="back-btn">
            <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
          </li>
          <li class="sidebar-main-title">
            <div>
              <h6>Main menu</h6>
            </div>
          </li>
          <li class="dropdown"><a class="nav-link menu-title link-nav" href="inventory?action=new"><i data-feather="plus"></i><span>Scan parcel</span></a></li>
          <li class="dropdown"><a class="nav-link menu-title link-nav" href="branch"><i data-feather="home"></i><span>Dashboard</span></a></li>
           <li class="dropdown"><a class="nav-link menu-title link-nav" href="inventory"><i data-feather="box"></i><span>Inventory</span></a></li>
           <li class="dropdown"><a class="nav-link menu-title link-nav" href="inventory?action=prepared"><i data-feather="archive"></i><span>Prepared</span></a></li>
           <li class="dropdown"><a class="nav-link menu-title link-nav" href="logout"><i data-feather="log-out"></i><span>Logout</span></a></li>
      </div>
      <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
    </div>
  </nav>
</header>
<!-- Page Sidebar Ends-->