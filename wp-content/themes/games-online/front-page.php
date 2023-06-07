<?php get_header();?>
       <main>
           <div class="main-background flex flex-col h-screen hero-pattern bg-no-repeat bg-cover bg-center">
            <div class="flex flex-col mx-auto my-36 w-4/5 h-96 text-white items-center justify-center text-center">
                <p class="text-1xl xl:text-2xl"><?php bloginfo('description'); ?></p>
                <p class="text-2xl pt-4 xl:text-4xl xl:w-3/4"> <?php bloginfo('title');?>. </p>
              <a href="<?php echo esc_url(get_permalink( get_option( 'page_for_posts' ) )); ?>" class="bg-yellow-500 text-center w-52 h-12 text-white mt-16 rounded-full pt-3"  ><?php esc_html_e("The Latest Releases","games-online");?></a>
            </div>
           </div>
       </main>
       <section>

       <div
       id="content"
          class="
            flex flex-col
            flex-wrap
            xl:max-w-none
            md:flex-row
            justify-center
            items-center
            mb-10
            mt-10
          "
        >
      <?php $query = new WP_Query(('posts_per_page=3'));?>
       <?php if($query -> have_posts()) : ?>
        <?php  while($query -> have_posts() ) : $query -> the_post(); ?>
        <article>
        <div  class="flex flex-col  max-w-xs mb-6 md:mr-6 relative  ">
          <?php if(has_post_thumbnail()):?>
          <div class="rounded-t-xl border border-purple-post box-border w-full max-h-52 h-52"><?php  the_post_thumbnail('post');?></div>
          <?php else:?>
            <div class="rounded-t-xl border border-purple-post box-border w-full max-h-52 h-52"><img src="<?php  echo esc_url(get_template_directory_uri());?>/src/images/placeholder-post.jpg" alt=<?php esc_attr_e("Placeholder post image","games-online");?>/></div>
          <?php endif;?>
          
            <div
              class="
                bg-black-post
                p-5
                border
                box-border
                rounded-md
                border-purple-post
                rounded-t-none
                h-72
                flex
                flex-col
                justify-between
              "
            >
              
                <div class="mr-2 text-yellow-600 text-xs mb-1 focus:underline hover:underline"><?php the_category(',');?></div>
              <div  class=" break-normal truncate text-xl leading-6 text-white">
                <?php the_title();?>
              </div>
              <div class="text-xs text-gray-400 mt-3"><?php the_time();?></div>
              <div  class="text-base leading-5 mt-4 text-gray-200">
                <?php the_excerpt();?>
              </div>
              
              <a
              href="<?php the_permalink();?>"
                class="
                  mt-4
                  border border-solid border-purple-border
                  rounded-3xl
                  box-border
                  self-center
                  w-11/12
                  px-4
                  py-4
                  text-sm text-purple-border text-center
                  hover:bg-white
                  cursor-pointer
                  flex flex-row
                  justify-center
                  items-center
                  hover:underline
                  focus:bg-white
                  focus:underline
                "
              >
               <p  class="text-purple-300 text-xs leading-3 ml-auto "
                  ><?php esc_html_e("READ ARTICLE","games-online");?></p
                >
                <img
                  src="<?php echo esc_url(get_template_directory_uri());?>/src/images/right-arrow.png"
                  alt="Arrow pointing right"
                  class="ml-auto"
                />
  
        </a>
            </div>
          </div>
          </article>
          <?php  endwhile; ?>
        <?php else : ?>
          <?php  esc_html_e('Sorry,no posts were found',"games-online");?>
        <?php endif; ?> 
        </div>
       </section>
    <?php wp_reset_postdata();?>
  
<?php get_footer();?>