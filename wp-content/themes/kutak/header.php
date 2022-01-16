<?php get_template_part('framework/head'); ?>

<header>
  <div class="header-background p-xs-1 smokey-background">
    <nav class="nav">
      <div class="container">
        <div class="row">
          <ul class="col-xs-12 col-md-3 col-lg-2 p-xs-1">
            <li id="hamburger-menu">
              <span class="nav-menu-bar"><i></i></span>
            </li>
            <li>
              <img src="https://demo.apalodi.com/kutak/wp-content/themes/kutak/assets/img/logo.png"/>
            </li>
            <li id="search-button">
              <span class="fas fa-search"></span>
            </li>
          </ul>
        </div>
      </div>
      <section class="search-section">
        <div class="container">
          <div class="row">
            <form class="search-form" action="">
              <input
                type="text"
                name="query"
                id="search"
                placeholder="Search.."
              />
              <button type="submit">
                <span class="fas fa-search"></span>
              </button>
            </form>
          </div>
        </div>
      </section>
      <section class="nav-expand-section">
        <div class="container">
          <div class="row">
            <div class="categories-container">
              <div class="col-xs-6 col-md-3 pb-xs-2">
                <div class="card">
                  <a href="#">accusantium</a>
                </div>
              </div>
              <div class="col-xs-6 col-md-3 pb-xs-2">
                <div class="card">
                  <a href="#">accusantium</a>
                </div>
              </div>
              <div class="col-xs-6 col-md-3 pb-xs-2">
                <div class="card">
                  <a href="#">accusantium</a>
                </div>
              </div>
              <div class="col-xs-6 col-md-3 pb-xs-2">
                <div class="card">
                  <a href="#">accusantium</a>
                </div>
              </div>
              <div class="col-xs-6 col-md-3 pb-xs-2">
                <div class="card">
                  <a href="#">accusantium</a>
                </div>
              </div>
              <div class="col-xs-6 col-md-3 pb-xs-2">
                <div class="card">
                  <a href="#">accusantium</a>
                </div>
              </div>
              <div class="col-xs-6 col-md-3 pb-xs-2">
                <div class="card">
                  <a href="#">accusantium</a>
                </div>
              </div>
              <div class="col-xs-6 col-md-3 pb-xs-2">
                <div class="card">
                  <a href="#">accusantium</a>
                </div>
              </div>
              <div class="col-xs-6 col-md-3 pb-xs-2">
                <div class="card">
                  <a href="#">accusantium</a>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-xs-4">
            <div class="footer-menu">
              <?php surge_custom_menu( 'footer-menu' );?>
	          </div>
          </div>
          <div class="row">
          	<div class="footer-social">
              <div class="social-icons">
                <a href="#" target="_blank"><i class="fab fa-facebook-square"></i></a>
                <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="#" target="_blank"><i class="fab fa-google-plus-g"></i></a>
              </div>
	          </div>
          </div>
        </div>
      </section>
    </nav>
  </div>
</header>