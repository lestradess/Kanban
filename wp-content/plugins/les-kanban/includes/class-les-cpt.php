<?php

class NEW_CPT {
    
    public function newtheme() {
        $labels = [
            'name' => __( 'Plurar', 'newtheme-textdomain' ),
            'singular_name' => __( 'Singular', 'newtheme-textdomain' ),
            'add_new' => __( 'Agregar nuevo', 'newtheme-textdomain' ),
            'add_new_item' => __( 'Agregar nuevo item', 'newtheme-textdomain' ),
            'edit_item' => __( 'Editar items', 'newtheme-textdomain' ),
            'view_item' => __( 'Ver items', 'newtheme-textdomain' ),
            'featured_image' => __( 'Imagen de portada items', 'newtheme-textdomain' ),
            'set_featured_image' => __( 'Definir portada item', 'newtheme-textdomain' ),
            'remove_featured_image' => __( 'Remover imagen del item', 'newtheme-textdomain' ),
            'use_featured_image' => __( 'Usar como imagen de item', 'newtheme-textdomain' ),
        ];

        $args = [
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'supports' => [ 'title', 'editor', 'thumbnail' ],
            'capability_type' => 'post',
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => false,
            'show_in_admin_bar' => false,
            'rewrite' => [ 'slug' => 'items' ],
        ];

        register_post_type( 'newtheme_post_type', $args );

        flush_rewrite_rules();
    }
        
}