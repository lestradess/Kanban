<?php


if (!defined('ABSPATH')) die();

// Registrar Custom Post Type
function les_kanban_post_type()
{

    $labels = array(
        'name'                  => _x('Tableros Kanban', 'Post Type General Name', 'les-kanban'),
        'singular_name'         => _x('Tablero Kanban', 'Post Type Singular Name', 'les-kanban'),
        'menu_name'             => __('Tableros Kanban', 'les-kanban'),
        'name_admin_bar'        => __('Tablero Kanban', 'les-kanban'),
        'archives'              => __('Archivo', 'les-kanban'),
        'attributes'            => __('Atributos', 'les-kanban'),
        'parent_item_colon'     => __('Tablero Kanban Padre', 'les-kanban'),
        'all_items'             => __('Todas Las Tableros Kanban', 'les-kanban'),
        'add_new_item'          => __('Agregar Tablero Kanban', 'les-kanban'),
        'add_new'               => __('Agregar Tablero Kanban', 'les-kanban'),
        'new_item'              => __('Nueva Tablero Kanban', 'les-kanban'),
        'edit_item'             => __('Editar Tablero', 'les-kanban'),
        'update_item'           => __('Actualizar Tablero Kanban', 'les-kanban'),
        'view_item'             => __('Ver Tablero Kanban', 'les-kanban'),
        'view_items'            => __('Ver Tableros Kanban', 'les-kanban'),
        'search_items'          => __('Buscar Tablero Kanban', 'les-kanban'),
        'not_found'             => __('No Encontrado', 'les-kanban'),
        'not_found_in_trash'    => __('No Encontrado en Papelera', 'les-kanban'),
        'featured_image'        => __('Imagen Destacada', 'les-kanban'),
        'set_featured_image'    => __('Guardar Imagen destacada', 'les-kanban'),
        'remove_featured_image' => __('Eliminar Imagen destacada', 'les-kanban'),
        'use_featured_image'    => __('Utilizar como Imagen Destacada', 'les-kanban'),
        'insert_into_item'      => __('Insertar en Tablero Kanban', 'les-kanban'),
        'uploaded_to_this_item' => __('Agregado en Tablero Kanban', 'les-kanban'),
        'items_list'            => __('Lista de Tableros Kanban', 'les-kanban'),
        'items_list_navigation' => __('Navegación de Tableros Kanban', 'les-kanban'),
        'filter_items_list'     => __('Filtrar Tableros Kanban', 'les-kanban'),
    );
    $args = array(
        'label'                 => __('Tablero Kanban', 'les-kanban'),
        'description'           => __('Tableros Kanban para el Sitio Web', 'les-kanban'),
        'labels'                => $labels,
        'supports'              => array('title'),
        'hierarchical'          => true, // true = posts , false = paginas
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-editor-table',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => false, // Desactiva la opción de publicar
        'capability_type'       => 'page',
    );

    register_post_type('les_kanban', $args);
}
add_action('init', 'les_kanban_post_type', 0);


function ocultar_contenido()
{
    global $post;

    // Verificar si estamos en la pantalla de edición del Custom Post Type
    if ($post->post_type === 'les_kanban') {
        // Ocultar el cuadro de publicar
        //echo '<style>#submitdiv { display: none; }</style>';
        echo '<style>#screen-meta-links { display: none; }</style>';
        echo '<style>.wp-heading-inline{ display: none; }</style>';
        echo '<style>.page-title-action{ display: none; }</style>';
        echo '<style>.wp-heading-inline{ display: none; }</style>';
    }
}
add_action('admin_head-post.php', 'ocultar_contenido');
add_action('admin_head-post-new.php', 'ocultar_contenido');



/* function ocultar_columna_secundaria()
{
    global $post;

    // Verificar si estamos en la pantalla de edición del Custom Post Type
    if ($post->post_type === 'les_kanban') {
        // Agregar clase al contenedor principal para ocultar la columna secundaria
        echo '<script>
            jQuery(document).ready(function($){
                $("#post-body-content").addClass("one-column");
            });
        </script>';
    }
}
add_action('admin_footer-post.php', 'ocultar_columna_secundaria');
add_action('admin_footer-post-new.php', 'ocultar_columna_secundaria'); */

/* function add_save_button_after_title()
{
    global $post;
    if ($post->post_type === 'les_kanban') {
        $button_value = ($post->post_status === 'auto-draft') ? 'Publicar' : 'Actualizar';
        $button_name = ($post->post_status === 'auto-draft') ? 'publish' : 'save';
?>
        <input id="btnSubmit" type="submit" name="<?php echo $button_name; ?>" id="<?php echo $button_name; ?>" class="button button-primary button-large" value="<?php echo $button_value; ?>">
<?php
    }
}
add_action('edit_form_after_title', 'add_save_button_after_title'); */


//?METABOX KANBAN
require_once(dirname(dirname(__FILE__)) . '/metaboxes/mtb-kanban.php');
//require_once(dirname(dirname(__FILE__)) . '/metaboxes/page-kanban.php');
