<?php
/**
 * Define la funcionalidad de internacionalización
 *
 * Carga y define los archivos de internacionalización de este plugin para que este listo para su traducción.
 *
 * @link       http://misitioweb.com
 * @since      1.0.0
 *
 * @package    newtheme-blank
 * @subpackage newtheme-blank/includes
 */

/**
 * esta clase define todo lo necesario durante la activación del plugin
 *
 * @since      1.0.0
 * @package    newtheme-blank
 * @subpackage newtheme-blank/includes
 * @author     Jhon J.R <email@example.com>
 */
class NEW_i18n {
    
    /**
	 * Carga el dominio de texto (textdomain) del plugin para la traducción.
	 *
     * @since    1.0.0
     * @access private
	*/    
    public function load_plugin_textdomain() {
        
        load_plugin_textdomain(
            'newtheme-textdomain',
            false,
            NEW_PLUGIN_DIR_PATH . '/languages'
        );
        
    }
    
}