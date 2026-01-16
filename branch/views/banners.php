

        <div class="card">
                <!-- <div class="card-header">
                        <h4 class="card-title">Basic Example</h4>
                </div> -->
                <div class="card-body">
                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                <!-- <div class="carousel-indicators">
                                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                </div> -->
                                <div class="carousel-inner">
                                        <?
                                        $count =1;
                                        $sql = "SELECT *FROM banners ORDER BY rand() LIMIT 3";
                                        $result = mysqli_query($conn,$sql);
                                        while ($banners = mysqli_fetch_array($result))
                                        {
                                                ?>
                                                <div class="carousel-item <?=($count==1)?'active':'';?>">
                                                        <a href="<?=$banners["link"];?>" target="new">
                                                                <img class="card-img-top" src="<?=$banners["image"];?>" alt="<?=$banners["link"];?>" />
                                                        </a>
                                                </div>                                             
                                                <?
                                                $count++;
                                        }
                                        ?>
                                        <!-- <div class="carousel-item">
                                                <iframe width="100%" height="550" src="https://www.youtube.com/embed/-8wL4RJoa_M" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        </div>           -->
                                        <!-- <div class="carousel-item active">
                                        <img src="app-assets/images/slider/02.jpg" class="d-block w-100" alt="First slide" />
                                        </div>
                                        <div class="carousel-item">
                                        <img src="app-assets/images/slider/03.jpg" class="d-block w-100" alt="Second slide" />
                                        </div>
                                        <div class="carousel-item">
                                        <img src="app-assets/images/slider/01.jpg" class="d-block w-100" alt="Third slide" />
                                        </div> -->
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                </button>
                        </div>
                </div>
        </div>

        <!-- <div class="card">
                <img class="card-img-top" src="app-assets/images/slider/05.jpg" alt="Card image cap" />
                <div class="card-body">
                <h4 class="card-title">Card title</h4>
                <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                </div>
                <div class="card-footer">
                <small class="text-muted">Last updated 3 mins ago</small>
                </div>
        </div>
        <div class="card">
                <img class="card-img-top" src="app-assets/images/slider/03.jpg" alt="Card image cap" />
                <div class="card-body">
                <h4 class="card-title">Card title</h4>
                <p class="card-text">
                        This is a wider card with supporting text below as a natural lead-in to additional content. This card has even
                        longer content than the first to show that equal height action.
                </p>
                </div>
                <div class="card-footer">
                <small class="text-muted">Last updated 3 mins ago</small>
                </div>
        </div> -->
<!-- </div> -->