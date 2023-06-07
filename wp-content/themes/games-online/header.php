<!DOCTYPE html>
<html <?php language_attributes();?>>
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="<?php bloginfo('charset');?>"/> 
    <?php wp_head();?>
  </head>
  <body  id="body-main"  <?php body_class('bg-gray-theme');?>>
  <?php wp_body_open(); ?>
  <a class="skip-link screen-reader-text" href="#content">
<?php esc_html_e( 'Skip to content', 'games-online' ); ?></a>
    <header class="rounded-none border-b border-solid border-purple-border p-5">
      <nav role="navigation">
      <div class="flex md:flex-row justify-around items-center text-white text-xl md:text-2xl lg:text-3xl">
        <div class="flex flex-col ">
        <a  class="no-underline-heading font-bold capitalize focus:underline" href="/"><?php bloginfo('name'); ?> </a>
        <p class="text-base"><?php bloginfo('description');?></p>
        </div>
        
        <div>
          
          <?php wp_nav_menu(array(
            'container' =>'',
            'theme_location' => 'primary',
            'menu_class' => "navigation-main hidden md:flex flex-row text-white items-center justify-center  text-base ",
            'menu_id' => 'main-menu',
            ));?>
          </div>
          
          
       <button
            id="hamburger-button"
            class="block md:hidden cursor-pointer "
            onclick="gamesOnline_toggleHamburger();"
            aria-controls="hidden-main-menu" 
            aria-expanded="false"
          >
            <div class="w-9 h-1 bg-white mx-0 my-1"></div>
            <div class="w-9 h-1 bg-white mx-0 my-1"></div>
            <div class="w-9 h-1 bg-white mx-0 my-1"></div>
          </button>
         
         
       </div> 
       <div id="hidden-menu" class="hidden md:hidden " >
          <?php $args = array(
            'theme_location' => 'primary',
            'menu_class' => "navigation-hidden flex flex-col text-white font-sans text-base justify-center items-center p-7",
            'menu_id' => 'hidden-main-menu',
            );?>
          <?php wp_nav_menu($args);?>
        </div>
      
        </nav>
    </header>