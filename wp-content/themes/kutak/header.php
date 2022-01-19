<?php get_template_part('framework/head'); ?>

<?php
  // chech this page is home page or not
  $is_home = is_home();

  // check this page is category page or not
  $is_category = is_category();

  // check this page is single post or not
  $is_single = is_single();

?>

<header>
  <?php if( is_home() || is_category() || is_single() ){  ?>
    <div class="header-background p-xs-1 smokey-background">
  <?php } else{ ?>
    <div class="header-background p-xs-1 white-background">
  <?php } ?>
    <nav class="nav">
      <div class="container">
        <div class="row">
          <ul class="col-xs-12 col-md-3 col-lg-2 p-xs-1">
            <li id="hamburger-menu">
              <span class="nav-menu-bar"><i></i></span>
            </li>
            <li>
              <a href="<?php echo get_home_url(); ?>">
                <img src="https://demo.apalodi.com/kutak/wp-content/themes/kutak/assets/img/logo.png"/>
              </a>
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