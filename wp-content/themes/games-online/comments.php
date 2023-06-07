<?php $args = array(
    'walker' => null,
    'max_depth'=> '',
    'style'=>'ol',
    'callback'=>'gamesonline_better_comments',
    'end-callback'=> null,
    'type'=>'all',
    'reply_text'=>'Reply',
    'page'=>'',
    'per_page'=>'',
    'avatar_size'=>80,
    'reverse_top_level'=>null,
    'reverse_children'=>'',
    'format'=>'html5',
    'short_ping'=> false,
    'echo'=>true,

);?>



<?php $comments_args = array(
        // Change the title of send button 
        'label_submit' => __( 'Send', 'games-online' ),
        // Change the title of the reply section
        'title_reply' => __( 'Reply','games-online' ),
        // Remove "Text or HTML to be displayed after the set of comment fields".
        'comment_notes_after' => '',
        'logged_in_as' => '',
        // Redefine your own textarea (the comment body).
        'class_form' => 'comment-respond flex flex-col  items-center  p-5 lg:flex-row',
        'comment_field' => '<input type="text" placeholder='.esc_attr__("Add a comment",'games-online').' class=" comment-form-comment mr-5 w-full outline-none h-10 rounded-3xl pl-3 bg-transparent text-white"  id="comment" name="comment" aria-required="true"/>',
        'submit_button' =>'<button  name="%1$s" type="submit" id="%2$s" class="comments-button flex mt-3 md:mt-0  h-10 flex-row justify-center items-center xl:mx-auto rounded-3xl w-40"> <p style="color:#B0ADD1;" class="w-5/6 text-center font-bold text-xs ">'. esc_html__('POST',"games-online").'</p> </button>'
);?>



<p  class="p-5 text-2xl ml-3"><?php comments_number();?></p>

<p class="comments-logged-in p-5 text-2xl ml-3 "><?php esc_html_e('To comment you need to be logged in!',"games-online");?></p>

<?php comment_form( $comments_args );?>

<?php wp_list_comments($args,$comments);?>
<?php paginate_comments_links( array(
    'prev_text'  => 'back',
    'next_text' => 'forward'
) );?>



