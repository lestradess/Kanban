<?php get_header();?>
    <main>
   
    <div class="flex flex-row justify-center items-center">
        <form
          class="mt-3 flex"
          method="get"
          action="<?php esc_url(home_url('/'));?>"
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
            <p class="ml-auto">SEARCH</p>

            <img
              src="<?php echo esc_url(get_template_directory_uri());?>/src/images/right-arrow.png"
              alt=<?php esc_attr_e("Arrow pointing right","games-online")?>
              class="ml-auto mr-2"
            />
          </button>
        </form>
      </div>
      
   
      <div
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
      <?php if(is_author()):?>
      <div style="font-family: 'Open Sans', sans-serif;" class="flex flex-row mb-6 place-self-start ml-36 capitalize text-2xl"><p style="font-family: 'Open Sans', sans-serif;" class="mr-3">Posts made by:</p> <?php the_author();?></div> 
      <?php endif;?>
      <?php if(is_category()):?>
        <div style="font-family: 'Open Sans', sans-serif;" class="flex flex-row  mb-6 place-self-start ml-36 capitalize text-yellow-600 text-2xl"><p style="font-family: 'Open Sans', sans-serif;" class="mr-3 text-white">Category:</p><?php the_category(' , ');?></div> 
        <?php endif;?> 
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
        <div class="flex flex-col max-w-xs mb-6 md:mr-6 relative">
         <?php if(has_post_thumbnail()):?>
          <div class="rounded-t-md border border-purple-post box-border w-full max-h-52 h-52"><?php  the_post_thumbnail('post');?></div>
          <?php else:?>
            <div class="rounded-t-md border border-purple-post box-border w-full max-h-52 h-52"><img src="<?php echo esc_url(get_template_directory_uri());?>/src/images/placeholder-post.jpg" alt=<?php esc_attr_e("Placeholder post image","games-online")?>/></div>
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
              <div style="font-family: 'Montserrat', sans-serif;" class="text-xl leading-6">
                <?php the_title();?>
              </div>
              <div style="font-family: 'Roboto', sans-serif;" class="text-xs text-gray-400 mt-3"><?php the_time();?></div>
              <div style="font-family: 'Open Sans', sans-serif;" class="text-base leading-5 mt-4 text-gray-200">
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
                "
              >
               <p style="font-family: 'Roboto', sans-serif;" class="text-purple-300 text-xs leading-3 ml-auto"
                  >READ ARTICLE</p
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
          <?php echo 'Sorry,no posts were found';?>
        <?php endif; ?> 


     
    
      
      </div>
  
      <div class="flex flex-row justify-center items-center">
        
          <a href="<?php echo esc_url(get_previous_posts_page_link());?>" class="hover:underline focus:underline" ><img src="<?php echo esc_url(get_template_directory_uri()); ?>/src/images/left.png" alt=<?php esc_attr_e("Arrow pointing left","games-online")?> /></a>
          <!-- <ul class="flex flex-row">
            <li><a href="/" class="mr-2 hover:text-yellow-500">1</a></li>
            <li><a href="/" class="mr-2 hover:text-yellow-500">2</a></li>
            <li><a href="/" class="hover:text-yellow-500">3</a></li>
          </ul> -->
          <a href="<?php echo esc_url(get_next_posts_page_link());?>" class="hover:underline focus:underline"  ><img src="<?php echo esc_url(get_template_directory_uri()); ?>/src/images/right.png" alt=<?php esc_attr_e("Arrow pointing right","games-online")?> /></a>
      </div>

     
    </main>
  
<?php get_footer();?>