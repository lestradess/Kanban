<?php
/**
 * Se activa en la activación del plugin
 *
 * Esta clase define todo lo necesario durante la activación del plugin

 */
class NEW_Ajax {

    /**
	 * Método constructor
	 *
	 * Se ejecuta cuando se instancia la clase
	 *
	 * @since    1.0.0
     * access public
	 */
    public function __construct() {

        // Algun código a ejecutar en la instancia del objeto

    }

    /**
	 * Método para interactuar con el archivo Javascript
	 *
	 * Se usa para interactuar con un archivo específico
     * de javascript con el metodo AJAX
	 */
    public function peticiones() {

        // Chequea el código generado por wp_create_nonce()
        // y pasado al archivo javascript
        //check_ajax_referer( 'codigo_seguridad', 'clave_nonce' );

        //echo json_encode( $json );
        //wp_die();
    }

}