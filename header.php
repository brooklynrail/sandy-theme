<!DOCTYPE html>
<html class="no-js">
  <head>
<!--
                            _
                          .' `'.__
                         /      \ `'"-,
        .-''''--...__..-/ .     |      \
      .'               ; :'     '.  a   |
     /                 | :.       \     =\
    ;                   \':.      /  ,-.__;.-;`
   /|     .              '--._   /-.7`._..-;`
  ; |       '                |`-'      \  =|
  |/\        .   -' /     /  ;         |  =/
  (( ;.       ,_  .:|     | /     /\   | =|
   ) / `\     | `""`;     / |    | /   / =/
     | ::|    |      \    \ \    \ `--' =/
    /  '/\    /       )    |/     `-...-`
   /    | |  `\    /-'    /;
   \  ,,/ |    \   D    .'  \
    `""`   \  nnh  D_.-'L__nnh
            `"""`

Come Together: Surviving Sandy
A collaboration between the Dedalus Foundation and the Brooklyn Rail

Website design by Seth Hoekstra, development by Dylan Fisher

-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php wp_title( '-', true, 'right' ); echo esc_html( get_bloginfo('name'), 1 ) ?></title>
    <meta name="description" content="<?php echo get_bloginfo('description') ?>">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width">
    <link rel="icon" type="image/png" href="<?php echo get_bloginfo('template_url'); ?>/images/favicon.png">
    <link rel="stylesheet" type="text/css" href="<?php echo  bloginfo('stylesheet_url'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo  get_bloginfo('template_url'); ?>/css/build/minified/application.css" />
    <script src="<?php echo get_bloginfo('template_url'); ?>/js/modernizr-2.6.2.min.js"></script>
    <?php wp_enqueue_script('jquery') // runs in noConflict mode ?>
    <?php wp_head() // For plugins ?>
  </head>
  <body <?php body_class() ?>>
    <!--[if lte IE 9]>
      <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->
    <div class="outer-wrapper">
      <div class="wrapper" id="wrapper">
        <header>
          <nav>
            <h1 id="site-title"><span><a href="<?php bloginfo('url') ?>/" title="<?php echo esc_html( bloginfo('name'), 1 ) ?>" rel="home"><?php bloginfo('name') ?></a></span></h1>
            <?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'container_class' => 'menu-header' ) ); ?>
          </nav>
          <div class="search-wrapper">
            <div class="search-input-wrapper">
              <div class="search-close close-button"></div>
              <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
                <label>
                  <span class="screen-reader-text visuallyhidden">Search for:</span>
                  <input type="search" id="search-input" class="search-field search-input" name="s" placeholder="Search for artists, authors, topics, essay text..." value="" />
                </label>
              </form>
            </div>
          </div>
        </header>
