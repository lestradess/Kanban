<?php
/*
    Plugin Name: A-Lestradamus-Kanban
    Plugin URI: http://lestradamus.es
    Description: Kanban para Worpress
    Version: 1.0.0
    Author: Jose Luis Domingo 
    Author URI: http://lestradamus.es
    Text Domain: Lestradamus
*/
//*Comando para que nadie pueda abrir tu plugin desde el navegador
if (!defined('ABSPATH')) die();

global $wpdb;
//Proporciona la ruta relativa del directorio del plugin en el sistema de archivos, incluyendo el nombre base del archivo del plugin
define('LES_REALPATH_BASENAME_PLUGIN', dirname(plugin_basename(__FILE__)) . '/');
//Proporciona la ruta en el sistema de archivos del servidor
define('LES_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
//proporciona la URL accesible desde el navegador web
define('LES_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));
//define el nombre de la tabla, en este caso "a-kanban".
define('LES_TABLE', "{$wpdb->prefix}a_kanban"); 

//Funcion para activar un pluging
function les_activate()
{
    require_once LES_PLUGIN_DIR_PATH . 'includes/class-les-activator.php';
    LES_Activator::activate();
}
register_activation_hook(__FILE__, 'les_activate');

//Funcion para desactivar un plugin
function les_deactivate()
{
    require_once LES_PLUGIN_DIR_PATH . 'includes/class-les-deactivator.php'; 
    LES_Deactivator::deactivate();
}
register_deactivation_hook(__FILE__, 'les_deactivate');

//MCV modularizando 
require_once LES_PLUGIN_DIR_PATH . 'includes/class-les-master.php'; // Archivo general para definir todos los componentes

function les_run_les_master()
{
    $les_master = new LES_Master();
    $les_master->les_run();
}
les_run_les_master();//Ejecuta el metodo les-run de la clase LES-Master.
