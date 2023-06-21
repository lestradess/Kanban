<?php
/**
 * Permite crear cajas de metadatos 
 * para algún tipo de post
 *
 * @link       http://misitioweb.com
 * @since      1.0.0
 *
 * @package    newtheme-blank
 * @subpackage newtheme-blank/includes
 */

/**
 * esta clase define todo lo necesario para
 * crear una caha con uno o más metatados 
 *
 * @since      1.0.0
 * @package    newtheme-blank
 * @subpackage newtheme-blank/includes
 * @author     Jhon J.R <email@example.com>
 */
abstract class NEW_Metabox {
    
    /**
	 * Método estático
	 *
	 * Permite agregar el metabox a los
     * tipos de post pasados en $post_types
	 *
	 * @since    1.0.0
     * @access   public static
	 */ 
    public static function add() {
        
        $post_types = ['new_post_type', 'post'];
    
        add_meta_box(
            'new_id_metabox',
            __('Título', 'newtheme-textdomain'),
            [self::class, 'html'],
            $post_types,
            'normal',
            'high',
            [
                "datos",
            ]
        );
        
    }
    
    /**
	 * Método estático que obtiene el meta post en el callback
	 *
     * @since    1.0.0
     * @access   public static
     * 
     * @param WP_Post $post - Un objeto del post_type actual obtenido desde la DB
     * @param array $metabox - Obtiene un array con el ( id, title, callback, y elementos de argumentos )
	 */ 
    public static function html($post, $metabox) {
        
        wp_nonce_field( 'new_nonce_seguridad', 'new_nonce' );
        
        $valor = get_post_meta( $post->ID, '_new_identificador', true );
        
        // Campos de formulario para mostrar
        $output = "
            <div>
                <label for='new_label'>Text label</label>
                <input type='text' name='new_name' id='new_label' value=''> 
            </div>
        ";
        
        echo $output;
                
    }
    
    /**
	 * Método estático que se ejecuta al guardar un post_type
	 * con un metabox agregado
     * 
     * @since    1.0.0
     * @access   public static
     * 
     * @param int $post_id El ID del post actual 
	 */ 
    public static function save($post_id) {
        
        $valor_nonce = isset( $_POST['new_nonce'] ) ? $_POST['new_nonce'] : '';
        $action_nonce = 'new_nonce_seguridad';
        
        if( ! isset($valor_nonce) ) {
             return;
        }
        
        if( ! wp_verify_nonce( $valor_nonce, $action_nonce ) ) {
            return;
        }
        
        if( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        
        if( array_key_exists( 'new_name', $_POST ) ) {
        
            update_post_meta(
                $post_id,
                '_new_identificador',
                $_POST['new_name']
            );

        }
        
    }
    
}
