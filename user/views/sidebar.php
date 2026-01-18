<?php $current_page = basename($_SERVER['REQUEST_URI'], '?' . ($_SERVER['QUERY_STRING'] ?? '')); ?>

<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">
            
            <nav id="compactSidebar">

                <div class="theme-logo">
                    <a href="home">
                        <img src="assets/images/logo-white-xs.png" class="navbar-logo" alt="logo">
                    </a>
                </div>

                <ul class="menu-categories">
                    <li class="menu  <?php echo ($current_page=="tracks")?'active':''; ?>">
                        <a href="#track" data-active="false" class="menu-toggle">
                            <div class="base-menu">
                                <div class="base-icons">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                                </div>
                            </div>
                            <span class="menu-text">Track</span>
                        </a>
                       
                        <div class="tooltip"><span>Track</span></div>
                    </li>

                    <li class="menu <?php echo ($current_page=="packages")?'active':''; ?>">
                        <a href="#packages" data-active="false" class="menu-toggle">
                            <div class="base-menu">
                                <div class="base-icons">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                </div>
                            </div>
                            <span class="menu-text">Илгээмж</span>
                        </a>
                        <div class="tooltip"><span>Илгээмж</span></div>
                    </li>

                    <li class="menu <?php echo ($current_page=="online")?'active':''; ?>">
                        <a href="#online" data-active="false" class="menu-toggle">
                            <div class="base-menu">
                                <div class="base-icons">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                </div>
                            </div>
                            <span class="menu-text">Захиалга</span>
                        </a>
                        
                        <div class="tooltip"><span>Онлайн захиалга</span></div>
                    </li>

                    <li class="menu <?php echo ($current_page=="envoices")?'active':''; ?>">
                        <a href="#envoices" data-active="false" class="menu-toggle">
                            <div class="base-menu">
                                <div class="base-icons">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                                </div>
                            </div>
                            <span class="menu-text">Нэхэмжлэх</span>
                        </a>
                        <div class="tooltip"><span>Нэхэмжлэх</span></div>
                    </li>

                    <li class="menu <?php echo (in_array($current_page, ["shops","products"]))?'active':''; ?>">
                        <a href="#shops" data-active="false" class="menu-toggle">
                            <div class="base-menu">
                                <div class="base-icons">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                </div>
                            </div>
                            <span class="menu-text">Дэлгүүр</span>
                        </a>
                        <div class="tooltip"><span>Онлайн дэлгүүр</span></div>
                    </li>

                    <li class="menu <?php echo ($current_page=="profile")?'active':''; ?>">
                        <a href="#profile" data-active="false" class="menu-toggle">
                            <div class="base-menu">
                                <div class="base-icons">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                </div>
                            </div>
                            <span class="menu-text">Тохиргоо</span>
                        </a>
                        <div class="tooltip"><span>Хувийн тохиргоо</span></div>
                    </li>

                    <li class="menu <?php echo ($current_page=="extra")?'active':''; ?>">
                        <a href="#extra" data-active="false" class="menu-toggle">
                            <div class="base-menu">
                                <div class="base-icons">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tool"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                                </div>
                            </div>
                            <span class="menu-text">Нэмэлт</span>
                        </a>
                        <div class="tooltip"><span>Нэмэлт үйлдлүүд</span></div>
                    </li>

                    

                </ul>

                <div class="external-links">
                    <a href="https://www.facebook.com/shuurkhai.from.us" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                        <div class="tooltip"><span>FB/shuurkhai</span></div>
                    </a>
                </div>

            </nav>

            <div id="compact_submenuSidebar" class="submenu-sidebar">

                <div class="theme-brand-name">
                    <a href="home">Туслах цэс</a>
                </div>


                <div class="submenu" id="track">
                    <div class="category-info">
                        <h5>Трак</h5>
                        <p>Трак нь гадаадын сайтаас онлайнаар бараа захиалахад үүсэх давтагдашгүй дугаар юм.</p>
                    </div>
                    <ul class="submenu-list" data-parent-element="#app"> 
                        <li>
                            <a href="tracks?action=insert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg> Трак оруулах </a>
                        </li>
                        <li>
                            <a href="tracks"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg> Бүртгэлтэй трак </a>
                        </li>
                        <!-- <li>
                            <a href="tracks?action=history"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg> Түүх </a>
                        </li> -->
                                           
                    </ul>
                </div>

                <div class="submenu" id="online">
                    <div class="category-info">
                        <h5>Онлайн захиалга</h5>
                        <p>Та өөрөө худалдан авахад боломжгүй бол бидэнд хандан авах барааны хаягийн оруулж захиалга хийх боломжтой</p>
                    </div>
                    <ul class="submenu-list" data-parent-element="#online"> 
                        <li>
                            <a href="online?action=insert"> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Захиалга оруулах </a>
                        </li>
                        <li>
                            <a href="online?action=mine"> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Миний захиалгууд </a>
                        </li>
                        <li>
                            <a href="online?action=pending"> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Захиалга хийгдсэн </a>
                        </li>
                     
                        <li>
                            <a href="online?action=postponed"> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Хойшлуулсан захиалга </a>
                        </li>
                        <li>
                            <a href="online?action=history"> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Захиалгын түүх </a>
                        </li>                            
                        <li>
                            <a href="online?action=payment"> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Захиалгын төлбөр төлөх </a>
                        </li>
                    </ul>
                </div>

                <div class="submenu" id="packages">
                    <div class="category-info">
                        <h5>Илгээмж</h5>
                        <p>Америкаас таны нэр дээр ирж буй ачааны мэдээлэл байна</p>
                    </div>
                    <ul class="submenu-list" data-parent-element="#packages"> 
                        <li>
                            <a href="packages"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Миний илгээмж</a>
                        </li>
                        <li>
                            <a href="packages?action=history"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Түүх</a>
                        </li>
                        <li>
                            <a href="packages?action=container"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Газрын ачаа </a>
                        </li>      
                        <li>
                            <a href="packages?action=payment"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Тээврийн зардал </a>
                        </li>                   
                    </ul>
                </div>


                <div class="submenu" id="envoices">
                    <div class="category-info">
                        <h5>Нэхэмжлэх</h5>
                        <p>Өмнө үүсгэсэн нэхэмжлэлүүдийг харах боломжтой</p>
                    </div>
                    <ul class="submenu-list" data-parent-element="#envoices">
                        <li>
                            <a href="envoices?action=create"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Нэхэмжлэх үүсгэх </a>
                        </li>
                        <li>
                            <a href="envoices?action=modern"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Нэхэмжлэхүүд</a>
                        </li>
                        <!-- <li>
                            <a href="envoices?action=paid"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Төлөгдсөн нэхэмжлэх </a>
                        </li> -->
                    </ul>
                </div>


                <div class="submenu" id="shops">
                    <div class="category-info">
                        <h5>Онлайн дэлгүүр</h5>
                        <p>Захиалга их хийгдэж буй бараа, онлайн дэлгүүрийн талаар мэдээлэл байршина</p>
                    </div>
                    <ul class="submenu-list" data-parent-element="#shops">
                        <!-- <li>
                            <a href="products"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Бараа </a>
                        </li> -->
                        <li>
                            <a href="shops"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Дэлгүүр </a>
                        </li>
                    </ul>
                </div>

                <div class="submenu" id="profile">
                    <div class="category-info">
                        <h5>Хувийн тохиргоо</h5>
                        <p>10 жил бидэнтэй хамт байсан харилцагч танд баярлалаа.</p>
                    </div>
                    <ul class="submenu-list" data-parent-element="#profile">
                        <li>
                            <a href="profile"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Хувийн тохиргоо </a>
                        </li>
                        <li>
                            <a href="profile?action=edit&type=password"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Нууц үг солих </a>
                        </li>
                        <li>
                            <a href="profile?action=logged_history"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Нэвтэрсэн түүх </a>
                        </li>
                        <li>
                            <a href="profile?action=addresses"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Хүргэлтийн хаяг </a>
                        </li>
                        <li>
                            <a href="profile?action=proxies"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Захиалагч </a>
                        </li>
                        
                        
                    </ul>
                </div>

                <div class="submenu" id="extra">
                    <div class="category-info">
                        <h5>Нэмэлт үйлдлүүд</h5>
                        <p>Энэ хэсэгт дээрх цэсүүдэд хамааралгүй бусад үйлдлүүд байрлана</p>
                    </div>
                    <ul class="submenu-list" data-parent-element="#extra">
                        <li>
                            <a href="extra?action=contact"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Холбогдох</a>
                        </li>
                        <li>
                            <a href="extra?action=faqs"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Түгээмэл асуулт </a>
                        </li>
                        <li>
                            <a href="extra?action=report"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Алдааг мэдээлэх </a>
                        </li>
                        <li>
                            <a href="extra?action=collaboration"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Хамтран ажиллах санал </a>
                        </li>                        
                        <li>
                            <a href="extra?action=privacy"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg></span> Нууцлалын бодлого </a>
                        </li>
                    </ul>
                </div>
                
                
            </div>

        </div>
        <!--  END SIDEBAR  -->