<?php get_header();?>
    <main>
   
    <div class="flex flex-row justify-center items-center">
        <form
          class="mt-3 flex"
          method="get"
          action="<?php echo esc_url(home_url('/'));?>"
        >
          <input
            class="
              h-10
              text-white
              box-border
              border border-gray-400
              bg-transparent
              rounded-3xl
              w-96
              pl-3
              mr-4
            "
            type="text"
            name="s"
            placeholder=<?php esc_attr_e("Search...","games-online")?>
          />

          <button
            type="submit"
            class="
              text-purple-300 text-xs
              leading-3
              flex
              border-purple-post border
              rounded-full
              items-center
              justify-center
              w-40
              h-10
            "
          >
            <p class="ml-auto"><?php esc_html_e("SEARCH","games-online");?></p>

            <img
              src="<?php echo esc_url(get_template_directory_uri());?>/src/images/right-arrow.png"
              alt=<?php esc_attr_e("Arrow pointing right","games-online")?>
              class="ml-auto mr-2"
            />
          </button>
        </form>
      </div>
      
   
      <div
      id="content"
        class="
          flex flex-col
          max-w-7xl
          m-auto
          mt-20
          text-white
          font-sans
          justify-center
          items-center
        "
      >
     
        <div
          class="
            flex flex-col
            flex-wrap
            xl:max-w-none
            md:flex-row
            justify-center
            items-center
            mb-10
            
          "
        >
        <?php if(have_posts()) : ?>
        <?php while(have_posts() ) : the_post(); ?>
        <article>
        <div id="post-<?php the_ID();?>" <?php post_class('flex flex-col max-w-xs mb-6 md:mr-6 relative');?>>
         <?php if(has_post_thumbnail()):?>
          <div class="rounded-t-md border border-purple-post box-border w-full max-h-52 h-52"><?php  the_post_thumbnail('post');?></div>
          <?php else:?>
            <div class="rounded-t-md border border-purple-post box-border w-full max-h-52 h-52"><img src="<?php echo esc_url(get_template_directory_uri());?>/src/images/placeholder-post.jpg" alt=<?php esc_attr_e("Placeholder post image","games-online");?>/></div>
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
              
                <div class="mr-2 text-yellow-600 text-xs mb-1"><?php the_category(',');?></div>
              <div  class=" break-normal truncate text-xl leading-6">
                <?php the_title();?>
              </div>
              <div class="text-xs text-gray-400 mt-3"><?php the_time();?></div>
              <div class="text-base leading-5 mt-4 text-gray-200">
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
               <p class="text-purple-300 text-xs leading-3 ml-auto"
                  ><?php esc_html_e("READ ARTICLE","games-online");?></p
                >
                <img
                  src="<?php echo esc_url(get_template_directory_uri());?>/src/images/right-arrow.png"
                  alt=<?php esc_attr_e("Arrow pointing right","games-online")?>
                  class="ml-auto"
                />
  
        </a>
            </div>
          </div>
          </article>
          <?php  endwhile; ?>
        <?php else : ?>
          <?php esc_html_e('Sorry,no posts were found',"games-online");?>
        <?php endif; ?> 

     
    
      
      </div>
  
      <div class="flex flex-row justify-center items-center">
        
          <a href="<?php echo esc_url(get_previous_posts_page_link());?>" class="hover:underline focus:underline"  ><img src="<?php echo esc_url(get_template_directory_uri()); ?>/src/images/left.png" alt=<?php esc_attr_e("Arrow pointing left","games-online")?> /></a>
       
          <a href="<?php echo esc_url(get_next_posts_page_link());?>"  class="hover:underline focus:underline" ><img src="<?php echo esc_url(get_template_directory_uri()); ?>/src/images/right.png" alt=<?php esc_attr_e("Arrow pointing right","games-online")?> /></a>
      </div>

     
    </main>
  
<?php get_footer();?>