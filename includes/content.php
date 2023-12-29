<?php 
if(!isset($_SESSION['verified_user_id'])){
    include('modal.php');
}
?>
<!-- Carousel -->
<div id="carouselExampleRide" class="carousel slide" data-bs-ride="true" aria-live="polite" aria-atomic="true">
    <div class="carousel-inner">
        <div class="carousel-item active ">
            <img src="./pictures/Bruh (4).jpg" class="d-block w-100 object-fit-cover" alt="bg">
        </div>
        <div class="carousel-item ">
            <img src="./pictures/Bruh (2).jpg" class="d-block w-100  object-fit-cover" alt="bg">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Features -->
<div class="sections features" id="features">
    <div class="container">
        <div class="card">
            <div class="card-header text-center mb-5 p-sm-5">
                <span>Features</span>
                <h5 class="sections-title card-title">Why Choose?</h5>
                <p class="sections-p card-text">Discover the reasons to choose our services.</p>
            </div>
            <div class="card-body">
                <div class="row g-2 g-lg-3">
                    <div class="col-lg-4 col-md-6">
                        <div class="">
                            <div class="cardbody cardbody-style">
                                <i class="fa fa-glass card-icon"></i>
                                <h4 class="card-title">Quality Service</h4>
                                <p class="sections-p card-text">Experience top-notch service that exceeds expectations.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="">
                            <div class="cardbody cardbody-style">
                                <i class="fa fa-star card-icon"></i>
                                <h4 class="card-title">Exceptional Excellence</h4>
                                <p class="sections-p card-text">Strive for excellence with our exceptional offerings.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="">
                            <div class="cardbody cardbody-style">
                                <i class="fa fa-moon card-icon"></i>
                                <h4 class="card-title">Timely Solutions</h4>
                                <p class="sections-p card-text">Receive timely and effective solutions to meet your needs.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- About -->
<div class="sections abouts about-section position-relative w-100" id="abouts" style="background: #eff2f9;">
    <div class="container">
        <div class="row gap-lg-5 gap-3">
            <div class="col-xl-6 col-lg-6">
                <div class="about-img-wrapper w-100">
                    <div class="about-img position-relative d-inline-block">
                        <img height="500" src="./pictures/webdevpic1.jpg" alt="dev" class="object-fit-cover w-100">
                        <div class="about-experience position-absolute text-light">
                            <h3 class="fs-3 fw-bold mb-3">Document Processing and Request System</h3>
                            <p class="text-light fs-5 fw-normal lh-sm" style="margin: 0;">We've created the first-ever online tool for handling documents and requests. It's user-friendly and accessible to a wide range of people, thanks to its improved interface..</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-5">
                <div class="about-content-wrapper">
                    <div class="section-title">
                        <span>About Us</span>
                        <h2>The primary goal of this project is to offer people an alternative means of acquiring necessities</h2>
                    </div>
                    <div class="about-content">
                        <p id="aboutparag" class="counterparag">This project aims to give people, another way to get what they need without spending a lot of time and effort, especially in emergencies. Also, the offices of the barangay will be better structured, which will result in less work for the clerks or administrators of the barangay.</p>
                        <div class="counter-up d-flex justify-content-between">
                            <div class="counter me-2">   
                                <span>4</span>
                                <h4>Satisfied Clients</h4>
                                <p class="counterparag">No challenge is too great. We ensure a seamless experience for our clients, making their satisfaction our top priority.</p>
                            </div>
                            <div class="counter me-2">   
                                <span>0</span>
                                <h4>Projects Done</h4>
                                <p class="counterparag">We take pride in our track record of successfully completing projects. Our commitment to excellence is reflected in every endeavor we undertake.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Services -->
<div class="sections services" id="services">
    <div class="container">
        <div class="card">
            <div class="card-header text-center mb-5 p-sm-5">
                <span>Services</span>
                <h5 class="sections-title card-title">Our Best Services</h5>
                <p class="sections-p card-text">Choose your barangay</p>
            </div>
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-2 g-4">

                    <div class="col-lg-4 col-md-6">
                        <div class="services-box card border border-5 border-secondary text-center" style="">
                        <?php if(!isset($_SESSION['verified_user_id'])) : ?>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalLogin" class="text-decoration-none">
                        <?php else : ?>
                            <a href="barangayhome.php" class="text-decoration-none">
                        <?php endif; ?>
                                <div class="card-body py-5 services-body" style="">
                                    <div class="card-img-top pt-3">
                                        <img src="./pictures/bambanglogo.png" alt="bambang logo" height="100" width="100">
                                    </div>
                                    <h4 class="card-title">Barangay Bambang</h4>
                                    <p class="card-text services-box-clamp">Bambang, Bulakan, Bulacan</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="services-box card border border-5 border-secondary text-center" style="">
                        <?php if(!isset($_SESSION['verified_user_id'])) : ?>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalLogin" class="text-decoration-none">
                        <?php else : ?>
                            <a href="barangayhome.php" class="text-decoration-none">
                        <?php endif; ?>
                                <div class="card-body py-5 services-body" style="">
                                    <div class="card-img-top pt-3">
                                        <img src="./pictures/taliptiplogo.png" alt="bambang logo" height="100" width="100">
                                    </div>
                                    <h4 class="card-title">Barangay Taliptip</h4>
                                    <p class="card-text services-box-clamp">Taliptip, Bulakan, Bulacan</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="services-box card border border-5 border-secondary text-center" style="">
                        <?php if(!isset($_SESSION['verified_user_id'])) : ?>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalLogin" class="text-decoration-none">
                        <?php else : ?>
                            <a href="#" class="text-decoration-none">
                        <?php endif; ?>
                                <div class="card-body py-5 services-body" style="">
                                    <h4 class="card-title">To Be Announced</h4>
                                    <p class="card-text">Stay tuned for exciting updates and announcements!</p>
                                    <a href="#" class="btn btn-primary">Learn More</a>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="py-4 py-md-5 mt-5 bg-body-tertiary">
    <div class="container">
        <div class="row">
            <a class="navbar-brand text-wrap text-center text-md-start" href="#top">
                <img src="./pictures/KABARIO transparent.png" width="90" height="64" id="logo" alt="logo">
                <p class="d-inline-block mb-0 sections-p">"One place to request a Document"</p>
            </a>
        </div>
    </div>
</footer>