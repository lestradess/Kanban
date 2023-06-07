<?php get_header();?>
      <main>
          <?php the_post();?>
          <div id="content" class="comments-border flex flex-col md:flex-row w-10/12  h-auto mx-auto mt-16 border-solid rounded-xl mb-12">
          <div class="w-full">
            <div class=" text-white  p-6 ml-6 text-lg lg:text-2xl font-bold capitalize"><?php the_title();?></div>
            <div class="flex flex-row w-42 ml-12">
              <div class="text-1xl text-yellow-500"><?php the_category();?></div>
              <div class="text-1xl text-white ml-8"><?php the_time();?></div>
            </div>
           <?php if(has_post_thumbnail()):?>
            <?php $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),$size=array(530,353)); ?>
            <div class=" pl-12 pt-3"><img src="<?php echo esc_url($featured_img_url)?>" alt="The post thumbnail"></div>
            <?php endif;?>
            <div class=" pl-12 pt-6 pr-12 text-white text-md lg:text-xl"><?php the_content();?>
            <div class="hidden"><?php the_tags();?></div>
        </div>
              
              <div class="flex flex-row items-center  ml-12 mb-12 mt-5">
              
                <?php echo get_avatar(get_the_author_meta('ID'),48,"","The profile pic",$args=array('class'=>"rounded-full"));?>
                <div class="text-white ml-8"><a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta('ID')));?>"><?php the_author();?></a></div>
              </div>
          </div>
          

          <?php
$args = array (
    'before'            => '<div class="page-links-XXX"><span class="page-link-text">' . __( 'More pages: ', 'games-online' ) . '</span>',
    'after'             => '</div>',
    'link_before'       => '<span class="page-link">',
    'link_after'        => '</span>',
    'next_or_number'    => 'next',
    'separator'         => ' | ',
    'nextpagelink'      => __( 'Next &raquo', 'games-online' ),
    'previouspagelink'  => __( '&laquo Previous', 'games-online' ),
);
 
wp_link_pages( $args );
?>
<?php the_posts_pagination( array( 'mid_size' => 2 ) ); ?>
          </div> 
            
      </main>

      <section>
      <div  class="comments-border flex flex-col w-5/6 h-auto mx-auto mt-16 border-solid rounded-xl mb-12">
         <span class="comments-holder"> <?php comments_template();?> </span>
      </div>
      </section>
<?php get_footer();?>