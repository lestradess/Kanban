<?php 
//Creando el menu
if(!function_exists('les_menu')){
    function les_menu(){
        add_menu_page( 
            'Menu',                 //titulo de la pagina $page_title: 
            'Menu',                 //titulo del menu $menu_title: 
            'manage_options',       //usuarios que pueden verlo $capability:
            'les_menu',             //ruta a la pagina $menu_slug:
            'les_options_menu',     //funcion de llamada a la pagina que va dentro del menu $callback:
            'dashicons-megaphone',  //icono $icon_url:
             12                     //posicion $position:
            );
    }
    add_action( 'admin_menu', 'les_menu'); //admin_menu es una variable que se refiere al menu de administracion y les_menu la funcion anterior
}
//funcion de la pagina interior del menu
if (!function_exists('les_options_menu')) {
    function les_options_menu(){
        //TODO pendiente
        echo 'falta el contenido';
    }
}