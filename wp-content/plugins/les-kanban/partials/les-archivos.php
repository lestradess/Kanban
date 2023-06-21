<?php

/**
 //* Aquí encolaremos todos los archivos css y js
 */
//?Archivos de CSS
function enqueue_styles($hook)
{
    if (
        !is_admin()
        // $hook != 'toplevel_page_res_popup' &&
        // $hook != 'les_productos_page_les_listado_productos' &&
        // $hook != 'les_productos_page_les_productos_rapido'&&
        // $hook != 'admin-bar'
    ) {
        return;
    }

    //?Encolando Boostrap.css desde CDN
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css', array(), '5.3.0-alpha3', 'all');
    //?Encolando fontawesome
    /* wp_enqueue_style(
        'font-awesome',
        plugin_dir_url(__DIR__) . 'helpers/fontawesome_6.4.0/css/all.min.css',
        [],
        '6.4.0',
        'all',
    ); */

    //?Encolando app.css
    wp_enqueue_style(
        'admin-style',
        plugin_dir_url(__DIR__) . 'admin/css/app.css',
        [], //aquí encolamos lo que queremos que se encole primero
        '1.0.0',
        'all', //dispositivo que queremos que se visualice
    );
    //?Encolando kamban.css
    wp_enqueue_style(
        'admin-style-kanban',
        plugin_dir_url(__DIR__) . 'admin/css/kanban.css',
        [], //aquí encolamos lo que queremos que se encole primero
        '1.0.0',
        'all', //dispositivo que queremos que se visualice
    );
    //?Encolando fuente noto sand
    wp_enqueue_style('noto', 'https://fonts.googleapis.com/css2?family=Monsieur+La+Doulaise&family=Noto+Sans:wght@100;300;700&display=swap');
}
add_action('admin_enqueue_scripts', 'enqueue_styles');

//?Archivos de JS
function enqueue_scripts($hook)
{
    if (
        !is_admin()
        // $hook != 'toplevel_page_res_popup' &&
        // $hook != 'les_productos_page_les_listado_productos' &&
        // $hook != 'les_productos_page_les_productos_rapido'&&
        // $hook != 'admin-bar'
    ) {
        return;
    }
    //?Encolando app.js
    wp_enqueue_script(
        'admin-script',
        plugin_dir_url(__DIR__) . 'admin/js/app.js',
        ['jquery', 'bootstrap-bundle'], //aquí encolamos lo que queremos que se encole primero
        '1.0.0',
        false //donde queremos encolar en el head/false al final del body/true
    );
    //?Encolando kanban.js
    wp_enqueue_script(
        'admin-script-kanban',
        plugin_dir_url(__DIR__) . 'admin/js/kanban.js',
        ['jquery', 'bootstrap-bundle'], //aquí encolamos lo que queremos que se encole primero
        '1.0.0',
        false //donde queremos encolar en el head/false al final del body/true
    );

    //?Encolando Bootstrap desde CDN
    wp_enqueue_script('bootstrap-bundle', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.3.0-alpha3', true);
}
add_action('admin_enqueue_scripts', 'enqueue_scripts');


