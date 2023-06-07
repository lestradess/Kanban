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
//Funcion para activar un pluging
function les_activar(){
    //Acion requerir un archivo
    require_once 'activador.php';
}
//hook para activar la funcion
register_activation_hook(
    //Ruta de archivo
    __FILE__,
    //nombre funcion
    'les_activar'
);
//Funcion para desactivar un plugin
function les_desactivar(){
    //Accion limpiar los enlaces permanentes
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'les_desactivar');
require_once 'partials/les-menu.php';