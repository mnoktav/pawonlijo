<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Pawon Lijo</title>

  <link rel="stylesheet" href="{{ asset('assets/sneaky/vendors/bootstrap/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/sneaky/vendors/themify-icons/themify-icons.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/sneaky/vendors/owl-carousel/owl.theme.default.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/sneaky/vendors/owl-carousel/owl.carousel.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/sneaky/vendors/Magnific-Popup/magnific-popup.css')}}">

  <link rel="stylesheet" href="{{ asset('assets/sneaky/css/style.css')}}">
</head>
<body>

  <!--================ Header Menu Area start =================-->
  <header class="header_area">
    <div class="main_menu">
      <nav class="navbar navbar-expand-lg navbar-light">
        
      </nav>
    </div>
  </header>
  <!--================Header Menu Area =================-->

  <!--================Hero Banner Section start =================-->
  <section class="hero-banner">

    <div class="hero-wrapper">

      <div class="hero-left">
      	
        <h1 class="hero-title mb-0">Pawon Lijo </h1>
        <h4 class="mb-4 ml-2">Jombang</h4>
        <div class="d-sm-flex flex-wrap">
          <a class="button button-hero button-shadow mr-4" href="{{ route('admin.dashboard') }}" style="background-color: orange !important;">Login Admin</a>
          <a class="button button-hero button-shadow" href="{{ route('kasir.dashboard') }}" style="background-color: #307af2 !important;">Login Kasir</a>
        </div>
        <ul class="hero-info d-none d-lg-block" style="margin-left: 10%;">
          <li>
            <img src="{{ asset('assets/sneaky/img/banner/fas-service-icon.png')}}" alt="">
            <h4>Fast Service</h4>
          </li>
          <li>
            <img src="{{ asset('assets/sneaky/img/banner/fresh-food-icon.png')}}" alt="">
            <h4>Fresh Food</h4>
          </li>
        </ul>
        
      </div>
      <div class="hero-right">
        <div class="owl-carousel owl-theme hero-carousel">
          <div class="hero-carousel-item">
            <img class="img-fluid w-100" src="{{ asset('assets/sneaky/img/banner/hero-banner3.jpg')}}" alt="">
          </div>
          <div class="hero-carousel-item">
            <img class="img-fluid" src="{{ asset('assets/sneaky/img/banner/hero-banner5.jpg')}}" alt="">
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--================Hero Banner Section end =================-->

  
  <!--================About Section start =================-->
  {{-- <section class="about section-margin pb-xl-70">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-xl-6 mb-5 mb-md-0 pb-5 pb-md-0">
          <div class="img-styleBox">
            <div class="styleBox-border">
              <img class="styleBox-img1 img-fluid" src="img/home/about-img1.png" alt="">
            </div>
            <img class="styleBox-img2 img-fluid" src="img/home/about-img2.png" alt="">
          </div>
        </div>
        <div class="col-md-6 pl-md-5 pl-xl-0 offset-xl-1 col-xl-5">
          <div class="section-intro mb-lg-4">
            <h4 class="intro-title">About Us</h4>
            <h2>We speak the good food language</h2>
          </div>
          <p>Living first us creepeth she'd earth second be sixth hath likeness greater image said sixth was without male place fowl evening an grass form living fish and rule lesser for blessed can't saw third one signs moving stars light divided was two you him appear midst cattle for they are gathering.</p>
          <a class="button button-shadow mt-2 mt-lg-4" href="#">Learn More</a>
        </div>
      </div>
    </div>
  </section> --}}
  <!--================About Section End =================-->


  <!--================Featured Section Start =================-->
  {{-- <section class="section-margin mb-lg-100">
    <div class="container">
      <div class="section-intro mb-75px">
        <h4 class="intro-title">Featured Food</h4>
        <h2>Fresh taste and great price</h2>
      </div>


      <div class="owl-carousel owl-theme featured-carousel">
        <div class="featured-item">
          <img class="card-img rounded-0" src="img/home/featured1.png" alt="">
          <div class="item-body">
            <a href="#">
              <h3>Mountain Mike Pizza</h3>
            </a>
            <p>Whales and darkness moving</p>
            <div class="d-flex justify-content-between">
              <ul class="rating-star">
                <li><i class="ti-star"></i></li>
                <li><i class="ti-star"></i></li>
                <li><i class="ti-star"></i></li>
                <li><i class="ti-star"></i></li>
                <li><i class="ti-star"></i></li>
              </ul>
              <h3 class="price-tag">$35</h3>
            </div>
          </div>
        </div>
        <div class="featured-item">
          <img class="card-img rounded-0" src="img/home/featured2.png" alt="">
          <div class="item-body">
            <a href="#">
              <h3>Patatas Bravas</h3>
            </a>
            <p>Whales and darkness moving</p>
            <div class="d-flex justify-content-between">
              <ul class="rating-star">
                <li><i class="ti-star"></i></li>
                <li><i class="ti-star"></i></li>
                <li><i class="ti-star"></i></li>
                <li><i class="ti-star"></i></li>
                <li><i class="ti-star"></i></li>
              </ul>
              <h3 class="price-tag">$30</h3>
            </div>
          </div>
        </div>
        <div class="featured-item">
          <img class="card-img rounded-0" src="img/home/featured3.png" alt="">
          <div class="item-body">
            <a href="#">
              <h3>Pulled Sandwich</h3>
            </a>
            <p>Whales and darkness moving</p>
            <div class="d-flex justify-content-between">
              <ul class="rating-star">
                <li><i class="ti-star"></i></li>
                <li><i class="ti-star"></i></li>
                <li><i class="ti-star"></i></li>
                <li><i class="ti-star"></i></li>
                <li><i class="ti-star"></i></li>
              </ul>
              <h3 class="price-tag">$20</h3>
            </div>
          </div>
        </div>
        <div class="featured-item">
          <img class="card-img rounded-0" src="img/home/featured1.png" alt="">
          <div class="item-body">
            <a href="#">
              <h3>Mountain Mike Pizza</h3>
            </a>
            <p>Whales and darkness moving</p>
            <div class="d-flex justify-content-between">
              <ul class="rating-star">
                <li><i class="ti-star"></i></li>
                <li><i class="ti-star"></i></li>
                <li><i class="ti-star"></i></li>
                <li><i class="ti-star"></i></li>
                <li><i class="ti-star"></i></li>
              </ul>
              <h3 class="price-tag">$35</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> --}}
  <!--================Featured Section End =================-->

  <!--================Offer Section Start =================-->
  {{-- <section class="bg-lightGray section-padding">
    <div class="container">
      <div class="row no-gutters">
        <div class="col-sm">
          <img class="card-img rounded-0" src="img/home/offer-img.png" alt="">
        </div>
        <div class="col-sm">
          <div class="offer-card offer-card-position">
            <h3>Italian Pizza Offer</h3>
            <h2>50% OFF</h2>
            <a class="button" href="#">Read More</a>
          </div>
        </div>
      </div>
    </div>
  </section> --}}
  <!--================Offer Section End =================-->


  <!--================Food menu section start =================-->  
  {{-- <section class="section-margin">
    <div class="container">
      <div class="section-intro mb-75px">
        <h4 class="intro-title">Food Menu</h4>
        <h2>Delicious food</h2>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <div class="media align-items-center food-card">
            <img class="mr-3 mr-sm-4" src="img/home/food1.png" alt="">
            <div class="media-body">
              <div class="d-flex justify-content-between food-card-title">
                <h4>Roasted Marrow</h4>
                <h3 class="price-tag">$32</h3>
              </div>
              <p>Whales and darkness moving form cattle</p>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="media align-items-center food-card">
            <img class="mr-3 mr-sm-4" src="img/home/food1.png" alt="">
            <div class="media-body">
              <div class="d-flex justify-content-between food-card-title">
                <h4>Roasted Marrow</h4>
                <h3 class="price-tag">$32</h3>
              </div>
              <p>Whales and darkness moving form cattle</p>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="media align-items-center food-card">
            <img class="mr-3 mr-sm-4" src="img/home/food1.png" alt="">
            <div class="media-body">
              <div class="d-flex justify-content-between food-card-title">
                <h4>Roasted Marrow</h4>
                <h3 class="price-tag">$32</h3>
              </div>
              <p>Whales and darkness moving form cattle</p>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="media align-items-center food-card">
            <img class="mr-3 mr-sm-4" src="img/home/food1.png" alt="">
            <div class="media-body">
              <div class="d-flex justify-content-between food-card-title">
                <h4>Roasted Marrow</h4>
                <h3 class="price-tag">$32</h3>
              </div>
              <p>Whales and darkness moving form cattle</p>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="media align-items-center food-card">
            <img class="mr-3 mr-sm-4" src="img/home/food1.png" alt="">
            <div class="media-body">
              <div class="d-flex justify-content-between food-card-title">
                <h4>Roasted Marrow</h4>
                <h3 class="price-tag">$32</h3>
              </div>
              <p>Whales and darkness moving form cattle</p>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="media align-items-center food-card">
            <img class="mr-3 mr-sm-4" src="img/home/food1.png" alt="">
            <div class="media-body">
              <div class="d-flex justify-content-between food-card-title">
                <h4>Roasted Marrow</h4>
                <h3 class="price-tag">$32</h3>
              </div>
              <p>Whales and darkness moving form cattle</p>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="media align-items-center food-card">
            <img class="mr-3 mr-sm-4" src="img/home/food1.png" alt="">
            <div class="media-body">
              <div class="d-flex justify-content-between food-card-title">
                <h4>Roasted Marrow</h4>
                <h3 class="price-tag">$32</h3>
              </div>
              <p>Whales and darkness moving form cattle</p>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="media align-items-center food-card">
            <img class="mr-3 mr-sm-4" src="img/home/food1.png" alt="">
            <div class="media-body">
              <div class="d-flex justify-content-between food-card-title">
                <h4>Roasted Marrow</h4>
                <h3 class="price-tag">$32</h3>
              </div>
              <p>Whales and darkness moving form cattle</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> --}}
  <!--================Food menu section end =================-->  

  <!--================CTA section start =================-->  
  {{-- <section class="cta-area text-center">
    <div class="container">
      <p>Some Trendy And Popular Courses Offerd</p>
      <h2>Under replenish give saying thing</h2>
      <a class="button" href="#">Reservation</a>
    </div>
  </section> --}}
  <!--================CTA section end =================-->  


  <!--================Chef section start =================-->  
  {{-- <section class="section-margin">
    <div class="container">
      <div class="section-intro mb-75px">
        <h4 class="intro-title">Our Chef</h4>
        <h2>Talent & experience member</h2>
      </div>

      <div class="row">
        <div class="col-sm-6 col-lg-4 mb-4 mb-lg-0">
          <div class="chef-card">
            <img class="card-img rounded-0" src="img/home/chef-1.png" alt="">
            <div class="chef-footer">
              <h4>Daniesl Laran</h4>
              <p>Executive Chef</p>
            </div>

            <div class="chef-overlay">
              <ul class="social-icons">
                <li><a href="#"><i class="ti-facebook"></i></a></li>
                <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
                <li><a href="#"><i class="ti-skype"></i></a></li>
                <li><a href="#"><i class="ti-vimeo-alt"></i></a></li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-4 mb-4 mb-lg-0">
          <div class="chef-card">
            <img class="card-img rounded-0" src="img/home/chef-2.png" alt="">
            <div class="chef-footer">
              <h4>Daniesl Laran</h4>
              <p>Executive Chef</p>
            </div>

            <div class="chef-overlay">
              <ul class="social-icons">
                <li><a href="#"><i class="ti-facebook"></i></a></li>
                <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
                <li><a href="#"><i class="ti-skype"></i></a></li>
                <li><a href="#"><i class="ti-vimeo-alt"></i></a></li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-4 mb-4 mb-lg-0">
          <div class="chef-card">
            <img class="card-img rounded-0" src="img/home/chef-3.png" alt="">
            <div class="chef-footer">
              <h4>Daniesl Laran</h4>
              <p>Executive Chef</p>
            </div>

            <div class="chef-overlay">
              <ul class="social-icons">
                <li><a href="#"><i class="ti-facebook"></i></a></li>
                <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
                <li><a href="#"><i class="ti-skype"></i></a></li>
                <li><a href="#"><i class="ti-vimeo-alt"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> --}}
  <!--================Chef section end =================-->  


  <!--================Reservation section start =================-->  
  {{-- <section class="bg-lightGray section-padding">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 col-xl-5 mb-4 mb-md-0">
          <div class="section-intro">
            <h4 class="intro-title">Reservation</h4>
            <h2 class="mb-3">Get experience from sneaky</h2>
          </div>
          <p>Him given and midst tree form seas she'd saw give evening one every make hath moveth you're appear female heaven had signs own days saw they're have let midst given him given and midst tree. Form seas she'd saw give evening</p>
        </div>
        <div class="col-md-6 offset-xl-2 col-xl-5">
          <div class="search-wrapper">
            <h3>Book A Table</h3>

            <form class="search-form" action="#">
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Your Name">
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="ti-user"></i></span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Email Address">
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="ti-email"></i></span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Phone Number">
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="ti-headphone-alt"></i></span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Select Date">
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="ti-notepad"></i></span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Select People">
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="ti-layout-column3"></i></span>
                  </div>
                </div>
              </div>
              <div class="form-group form-group-position">
                <button class="button border-0" type="submit">Make Reservation</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section> --}}
  <!--================Reservation section end =================-->  


  <!--================Blog section start =================-->  
 {{--  <section class="section-margin">
    <div class="container">
      <div class="section-intro mb-75px">
        <h4 class="intro-title">Our Blog</h4>
        <h2>Latest food and recipe news</h2>
      </div>

      <div class="row">
        <div class="col-sm-6 col-lg-4 mb-4 mb-lg-0">
          <div class="card-blog">
            <img class="card-img rounded-0" src="img/blog/blog1.png" alt="">
            <div class="blog-body">
              <ul class="blog-info">
                <li><a href="#">Admin post</a></li>
                <li><a href="#">Jan 10, 2019</a></li>
              </ul>
              <a href="#">
                <h3>Huge cavity in antarctic glacie signals rapid</h3>
              </a>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-4 mb-4 mb-lg-0">
          <div class="card-blog">
            <img class="card-img rounded-0" src="img/blog/blog2.png" alt="">
            <div class="blog-body">
              <ul class="blog-info">
                <li><a href="#">Admin post</a></li>
                <li><a href="#">Jan 10, 2019</a></li>
              </ul>
              <a href="#">
                <h3>Researcher unearths age
                    in the desert</h3>
              </a>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-4 mb-4 mb-lg-0">
          <div class="card-blog">
            <img class="card-img rounded-0" src="img/blog/blog3.png" alt="">
            <div class="blog-body">
              <ul class="blog-info">
                <li><a href="#">Admin post</a></li>
                <li><a href="#">Jan 10, 2019</a></li>
              </ul>
              <a href="#">
                <h3>High-protein rice brings
                    value, nutrition</h3>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> --}}
  <!--================Blog section end =================-->  


  <!-- ================ start footer Area ================= -->
  <!-- ================ End footer Area ================= -->




  <script src="{{asset('assets/sneaky/vendors/jquery/jquery-3.2.1.min.js')}}"></script>
  <script src="{{asset('assets/sneaky/vendors/bootstrap/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/sneaky/vendors/owl-carousel/owl.carousel.min.js')}}"></script>
  <script src="{{asset('assets/sneaky/vendors/nice-select/jquery.nice-select.min.js')}}"></script>
  <script src="{{asset('assets/sneaky/vendors/Magnific-Popup/jquery.magnific-popup.min.js')}}"></script>
  <script src="{{asset('assets/sneaky/js/jquery.ajaxchimp.min.js')}}"></script>
  <script src="{{asset('assets/sneaky/js/mail-script.js')}}"></script>
  <script src="{{asset('assets/sneaky/js/main.js')}}"></script>
</body>
</html>