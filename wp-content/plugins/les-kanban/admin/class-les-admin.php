<?php

/**
 * La funcionalidad especifica de administración del plugin.

 * Define el nombre del plugin, la versión y dos métodos para
 * Encolar la hoja de estilos especifica de administración y JavaScript.
 *
 */
class LES_Admin
{
    private $plugin_name; //El identificador único de este plugin
    private $version; //Version actual del plugin
    private $plugin_dir_path;
    private $plugin_dir_url;
    private $plugin_dir_url_dir;
    private $build_menupage; //Para crear un nuevo menu en la administración
    private $db; //Para utilizar los metodos de consultas sql de wordpress
    private $crud_json; //Objeto NEW_CRUD_JSON

    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->plugin_dir_path = plugin_dir_path(__FILE__);
        $this->plugin_dir_url = plugin_dir_url(__FILE__);
        $this->plugin_dir_url_dir = plugin_dir_url(__DIR__);
        //$this->build_menupage = new NEW_Build_Menupage;

        global $wpdb;
        $this->db = $wpdb;
        //$this->crud_json = new NEW_CRUD_JSON;
    }

    public function enqueue_styles()
    {
        if (!is_admin()
            // $hook != 'toplevel_page_res_popup' &&
            // $hook != 'les_productos_page_les_listado_productos' &&
            // $hook != 'les_productos_page_les_productos_rapido'&&
            // $hook != 'admin-bar'
        ) {
            return;
        }

        //?Encolando Boostrap.css desde CDN
        wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css', array(), '5.3.0-alpha3', 'all');

        //?Encolando app.css
        wp_enqueue_style(
            'admin-style',
            plugin_dir_url(__DIR__) . 'admin/css/app.css',
            [], //aquí encolamos lo que queremos que se encole primero
            '1.0.0',
            'all', //dispositivo que queremos que se visualice
        );
        //?Encolando kamban.css
        $screen = get_current_screen();
        if ($screen->id === 'les_kanban') {
            wp_enqueue_style(
                'admin-style-kanban',
                plugin_dir_url(__DIR__) . 'admin/css/kanban.css',
                [], //aquí encolamos lo que queremos que se encole primero
                '1.0.0',
                'all', //dispositivo que queremos que se visualice
            );
        }
        //?Encolando fuente noto sand
        wp_enqueue_style('noto', 'https://fonts.googleapis.com/css2?family=Monsieur+La+Doulaise&family=Noto+Sans:wght@100;300;700&display=swap');
    }

    public function enqueue_scripts()
    {
        if (!is_admin()
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
        $screen = get_current_screen();
        if ($screen->id === 'les_kanban') {
            //?Encolando kanban.js
            wp_enqueue_script(
                'admin-script-kanban',
                plugin_dir_url(__DIR__) . 'admin/js/kanban.js',
                ['jquery', 'bootstrap-bundle'], //aquí encolamos lo que queremos que se encole primero
                '1.0.0',
                false //donde queremos encolar en el head/false al final del body/true
            );
        }

        //?Encolando Bootstrap desde CDN
        wp_enqueue_script('bootstrap-bundle', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.3.0-alpha3', true);

        /**
         * Función para el ajax de datos
         * Parámetros:
         * 1. Nombre del archivo = $this->plugin_name
         * 2. Nombre del objeto = newdata
         * 3. array de datos:
         * -url: la url del archivo la creara wordpress internamente en el archivo admin_ajax.php
         * -nombre del nonce de seguridad = seguridad
         *
         */
        wp_localize_script(
            'admin-script',
            'lesdata',
            [
                'ajaxurl' => admin_url('admin-ajax.php'),
                'seguridad' => wp_create_nonce('lesdata_seg')
            ]
        );
    }
    /**
     * Método para pasar datos por ajax
     * Este metodo esta definido en el ajax de nuestro archivo .js
     */
    public function ajax_crud_table()
    {
        //validamos el nonce
        check_ajax_referer('lesdata_seg', 'nonce');
        //validamos las capacidades de usuario
        if (current_user_can('manage_options')) {

            extract($_POST, EXTR_OVERWRITE);

            if ($tipo == 'add') {

                $columns = [
                    'nombre' => $nombre,
                    'data' => ''
                ];

                $result = $this->db->insert(LES_TABLE, $columns);

                $json = json_encode([
                    'result'    => $result,
                    'nombre'    => $nombre,
                    'insert_id' => $this->db->insert_id
                ]);
            }

            echo $json;
            wp_die();
        }
    }
}
