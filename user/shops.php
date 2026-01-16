<? require_once("config.php");?>
<? require_once("views/helper.php");?>
<? require_once("views/login_check.php");?>
<? require_once("views/init.php");?>

<link href="assets/css/apps/notes.css" rel="stylesheet" type="text/css" />
<link href="assets/css/elements/breadcrumb.css" rel="stylesheet" type="text/css" />
<link href="assets/css/forms/theme-checkbox-radio.css" rel="stylesheet" type="text/css" />


<body class="sidebar-noneoverflow">
    
    <? require_once("views/navbar.php");?>



    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <? require_once("views/sidebar.php");?>


        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <? if (isset($_GET["action"])) $action=$_GET["action"]; else $action="display"; ?>

                <?
                if ($action=="display")
                {
                
                    $user_id = $_SESSION["c_user_id"];
                    $sql = "SELECT * FROM envoice WHERE customer_id=".$user_id." ORDER BY created_date DESC";
                    ?>
                    <nav class="breadcrumb-two" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Нүүр</a></li>
                            <li class="breadcrumb-item active"><a href="shops">Онлайн дэлгүүр</a></li>
                        </ol>
                    </nav>

                     
                <div class="row app-notes layout-top-spacing" id="cancel-row">
                    <div class="col-lg-12">
                        <div class="app-hamburger-container">
                            <div class="hamburger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu chat-menu d-xl-none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></div>
                        </div>

                        <div class="app-container">
                            
                            <div class="app-note-container">

                                <div class="app-note-overlay"></div>

                                <div class="tab-title">
                                    <div class="row">
                                        <!-- <div class="col-md-12 col-sm-12 col-12 text-center">
                                            <a id="btn-add-notes" class="btn btn-primary btn-block" href="javascript:void(0);">Add</a>
                                        </div> -->
                                        <div class="col-md-12 col-sm-12 col-12">
                                            <ul class="nav nav-pills d-block" id="pills-tab3" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link list-actions active" id="all-notes"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg> Бүх дэлгүүр</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link list-actions" id="note-fav"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg> Таалагдсан</a>
                                                </li>
                                            </ul>

                                            <hr/>

                                            <p class="group-section"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7" y2="7"></line></svg> Ангилал</p>

                                            <ul class="nav nav-pills d-block group-list" id="pills-tab" role="tablist">
                                                <?
                                                $sql = "SELECT *FROM shops_category ORDER BY dd";
                                                $result = mysqli_query($conn,$sql);
                                                while ($data = mysqli_fetch_array($result))
                                                {
                                                    ?>
                                                    <li class="nav-item">
                                                        <a class="nav-link list-actions g-dot-primary" id="note-<?=$data["id"];?>"><?=$data["name"];?></a>
                                                    </li>
                                                    <?
                                                }
                                                ?>
                                                <!--                                                 
                                                <li class="nav-item">
                                                    <a class="nav-link list-actions g-dot-warning" id="note-work">Work</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link list-actions g-dot-success" id="note-social">Social</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link list-actions g-dot-danger" id="note-important">Important</a>
                                                </li> -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>


                                <div id="ct" class="note-container note-grid">
                                    <?
                                    $sql = "SELECT *FROM shops ORDER BY category,name";
                                    $result = mysqli_query($conn,$sql);
                                    while($data = mysqli_fetch_array($result))
                                    {
                                        ?>
                                        <div class="note-item all-notes note-<?=$data["category"];?>">
                                            <div class="note-inner-content">
                                                <div class="note-content">
                                                    <p class="note-title" data-noteTitle="<?=$data["name"];?>"><?=$data["name"];?></p>
                                                    <p class="meta-time"><a href="<?=$data["url"];?>"><?=$data["url"];?></a></p>
                                                    <div class="note-description-content">
                                                        <p class="note-description" data-noteDescription="Curabitur facilisis vel elit sed dapibus sodales purus rhoncus."><?=$data["description"];?></p>
                                                    </div>
                                                </div>
                                                <div class="note-action">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star fav-note"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 delete-note"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> -->
                                                </div>
                                                <div class="note-footer">
                                                    <!-- <div class="tags-selector btn-group">
                                                        <a class="nav-link dropdown-toggle d-icon label-group" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">
                                                            <div class="tags">
                                                                <div class="g-dot-personal"></div>
                                                                <div class="g-dot-work"></div>
                                                                <div class="g-dot-social"></div>
                                                                <div class="g-dot-important"></div>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                                            </div>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right d-icon-menu">
                                                            <a class="note-personal label-group-item label-personal dropdown-item position-relative g-dot-personal" href="javascript:void(0);"> Personal</a>
                                                            <a class="note-work label-group-item label-work dropdown-item position-relative g-dot-work" href="javascript:void(0);"> Work</a>
                                                            <a class="note-social label-group-item label-social dropdown-item position-relative g-dot-social" href="javascript:void(0);"> Social</a>
                                                            <a class="note-important label-group-item label-important dropdown-item position-relative g-dot-important" href="javascript:void(0);"> Important</a>
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>

                                        <?
                                    }
                                    ?>
                                    

                                    <!-- <div class="note-item all-notes note-fav">
                                        <div class="note-inner-content">
                                            <div class="note-content">
                                                <p class="note-title" data-noteTitle="Receive Package">Receive Package</p>
                                                <p class="meta-time">11/01/2019</p>
                                                <div class="note-description-content">
                                                    <p class="note-description" data-noteDescription="Facilisis curabitur facilisis vel elit sed dapibus sodales purus.">Facilisis curabitur facilisis vel elit sed dapibus sodales purus.</p>
                                                </div>
                                            </div>
                                            <div class="note-action">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star fav-note"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 delete-note"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                            </div>
                                            <div class="note-footer">
                                                <div class="tags-selector btn-group">
                                                    <a class="nav-link dropdown-toggle d-icon label-group" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">
                                                        <div class="tags">
                                                            <div class="g-dot-personal"></div>
                                                            <div class="g-dot-work"></div>
                                                            <div class="g-dot-social"></div>
                                                            <div class="g-dot-important"></div>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                                        </div>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right d-icon-menu">
                                                        <a class="note-personal label-group-item label-personal dropdown-item position-relative g-dot-personal" href="javascript:void(0);"> Personal</a>
                                                        <a class="note-work label-group-item label-work dropdown-item position-relative g-dot-work" href="javascript:void(0);"> Work</a>
                                                        <a class="note-social label-group-item label-social dropdown-item position-relative g-dot-social" href="javascript:void(0);"> Social</a>
                                                        <a class="note-important label-group-item label-important dropdown-item position-relative g-dot-important" href="javascript:void(0);"> Important</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>

                            </div>
                            
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="notesMailModal" tabindex="-1" role="dialog" aria-labelledby="notesMailModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        <div class="notes-box">
                                            <div class="notes-content">                                                                        
                                                <form action="javascript:void(0);" id="notesMailModalTitle">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="d-flex note-title">
                                                                <input type="text" id="n-title" class="form-control" maxlength="25" placeholder="Дэлгүүрийн нэр" name="name">
                                                            </div>
                                                            <span class="validation-text"></span>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="d-flex note-title">
                                                                <input type="text" id="n-url" class="form-control" placeholder="Хаяг" name="url">
                                                            </div>
                                                            <span class="validation-text"></span>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="d-flex note-description">
                                                                <textarea id="n-description" class="form-control" maxlength="60" placeholder="Тайлбар" rows="3" name="description"></textarea>
                                                            </div>
                                                            <span class="validation-text"></span>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button id="btn-n-save" class="float-left btn">Save</button>
                                        <button class="btn" data-dismiss="modal"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg> Болих</button>
                                        <button id="btn-n-add" class="btn">Хадгалах</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>

                    <?
                }
                ?>



                </div>
            <? require_once("views/footer.php");?>
        </div>
    </div>

    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/app.js"></script>

    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="plugins/highlight/highlight.pack.js"></script>
    <script src="assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="assets/js/ie11fix/fn.fix-padStart.js"></script>
    <script src="assets/js/apps/notes.js"></script>
    <!-- END PAGE LEVEL SCRIPTS -->

</body>
</html>