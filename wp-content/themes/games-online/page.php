<?php get_header();?>
<div id="content" class="flex flex-col w-full mx-auto md:flex-row">
    <?php if(have_posts()):?>
        <?php while(have_posts()) : the_post();?>
              <div class="pt-16 w-3/4 z-10 h-auto mx-auto lg:w-5/12">
             
                   <?php the_post_thumbnail(array(600,800)) ?>
            
              </div>
             
              </div>
                
          </div>
      </main>
      <section>
          <div class="page-main w-4/5 h-auto mx-auto mb-10 mt-10 rounded-2xl lg:w-2/3">
          <p   class="page-main-2 text-ms text-left w-4/5 mx-auto mt-5 lg:text-3xl mb-5 "><?php the_title(); ?> </p>
          <div class="w-full h-auto lg:ml-24">
                   <?php the_post_thumbnail(array(600,800)) ?>
               </div>
          <div s class=" text-ms text-left w-4/5  mx-auto mt-5 mb-5 lg:text-xl break-normal"><?php the_content();?></div>
             
          </div>

      </section>
     
      <?php endwhile;?>
      <?php endif;?>

      <div  class="comments-border flex flex-col w-5/6 h-auto mx-auto mt-16 border-solid rounded-xl mb-12">
     
      <span class="comments-holder"> <?php comments_template();?> </span>
      </div>

<?php get_footer();?>