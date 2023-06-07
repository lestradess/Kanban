<?php
if( ! function_exists( 'gamesonline_better_comments' ) ):
function gamesonline_better_comments($comment, $args, $depth) {
    ?>
    

        <div  id="li-comment-<?php comment_ID() ?>" class="comment flex flex-row w-5/6 mt-10 ml-10 pl-5 mb-10">
          <div class="w-12 h-12">
          <?php echo get_avatar(get_the_author_meta('ID'),48,"","The profile pic");?>
          </div>
          <div class="comment-block flex flex-col">
                  <p  class="comment-by text-white ml-4">
                  <?php echo esc_html(get_comment_author()); ?>
                  </p>
              <div   class="ml-4 text-white"><?php comment_text() ?></div>
                  <div class="flex flex-row">
                          <div  class="text-xs text-white ml-5 pt-3"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>
                         <?php /* translators: %1$s: Comment date, %2$s: Comment time */ ?>
                          <div  class="date text-xs pl-5 pt-3"><?php printf(esc_html_e('%1$s at %2$s' , 'games-online'), esc_url(get_comment_date(),"games-online"),  esc_url(get_comment_time(),"games-online"));?></div>
                 </div>
          </div>
          </div>

<?php
        }
endif;