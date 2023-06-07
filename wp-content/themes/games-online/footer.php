<?php wp_footer();?>

<footer>
           <div  class="footer mt-12 flex w-full xl:h-40 flex-col">
            <img class="w-8 h-8 mt-4 mx-auto" src="<?php echo esc_url(get_template_directory_uri());?>/src/images/icon3.svg" alt="icon">
            <p 
 class="text-sm uppercase text-white mx-auto font-bold w-30 mt-4 font-bold mb-5"><?php bloginfo('title');?></p>
           
          
           
          <?php wp_nav_menu(array(
            'theme_location' => 'footer',
            'menu_class' => "navigation-main navigation-footer flex flex-row text-white items-center justify-center font-sans text-base mt-4",
            'menu_id' => 'footer-menu',
            ));?>
          
          
        <?php gamesonline_setTimeFrame();?>
           </div>
       </footer>
   
  </body>
</html>