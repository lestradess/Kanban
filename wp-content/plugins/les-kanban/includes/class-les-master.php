<?php

/**
 * Es el archivo que define la clase del cerebro principal del plugin
 *
 * Una definición de clase que incluye atributos y funciones que se 
 * utilizan tanto del lado del público como del área de administración.
 * 
 * También mantiene el identificador único de este complemento,
 * así como la versión actual del plugin.
 */
class LES_Master
{

    protected $pluggin_dir_path; //devuelve la ruta actual
    protected $plugin_dir_path_dir; //devuelve la ruta del plugin
    protected $plugin_name; //El identificador único de este plugin
    protected $version; //La versión actual del plugin
    protected $cargador; //Registra y mantiene todos los ganchos que alimentan al plugin
    protected $taxonomias; //Listado de taxonomias
    protected $menus; //listado de menus
    protected $metaboxes; //listado de metaboxes
    protected $cpts; //Listado de custon post types
    protected $les_admin; //Administra la zona de administracion 
    private $les_public; //Administra la zona pública
    protected $ajax; //Administra la zona Ajax

    public function __construct()
    {
        $this->plugin_name = 'Les_kanban'; //!CAMBIAR
        $this->version = '1.0.0';
        $this->pluggin_dir_path = plugin_dir_path(__FILE__);
        $this->plugin_dir_path_dir = plugin_dir_path(__DIR__);
        $this->cargar_dependencias();
        $this->cargar_instancias();
        $this->set_idiomas();
        $this->definir_admin_hooks();
        $this->definir_public_hooks();
    }
    public function cargar_dependencias()
    {
        //Parte para cargado de archivos
        require_once $this->pluggin_dir_path . 'class-les-cargador.php';
        //require_once $this->pluggin_dir_path . 'les-taxonomias.php';
        require_once $this->plugin_dir_path_dir . 'admin/class-les-admin.php'; //Administracion zona admin
        require_once $this->plugin_dir_path_dir . 'post-types/cpt-kanban.php'; //cpt kanban
        require_once $this->plugin_dir_path_dir . 'menus/les-menu.php';
        require_once $this->pluggin_dir_path . 'class-les-ajax.php';
    }
    private function cargar_instancias()
    {

        // Crea una instancia del cargador que se utilizará para registrar los ganchos con WordPress.
        $this->cargador     = new LES_cargador;
        $this->les_admin    = new LES_Admin($this->get_plugin_name(), $this->get_version());
        //$this->les_public   = new LES_Public($this->get_plugin_name(), $this->get_version());

    }
    public function definir_admin_hooks()
    {
        //$this->cargador->add_action('init', $this->taxonomias, 'tipo_comida');
        //$this->cargador->add_action('init', $this->cpts, 'tipo_comida');
        //Encolamientos css::// archivo class-les_master
        $this->cargador->add_action('admin_enqueue_scripts', $this->les_admin, 'enqueue_styles');
        //Encolamientos js::// archivo class-les_master
        $this->cargador->add_action('admin_enqueue_scripts', $this->les_admin, 'enqueue_scripts');
        //Metodo Ajax:://Archivo class-les-ajax
        $this->cargador->add_action('wp_ajax_ajax_menu_opciones', $this->ajax, 'ajax_menu_opciones');
        //Método Ajax para enviar datos:://Archivo class-les-ajax
        $this->cargador->add_action('wp_ajax_les_crud_table', $this->les_admin, 'ajax_crud_table');
    }

    /**
     * Registrar todos los ganchos relacionados con la funcionalidad del área de administración
     * Del plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function definir_public_hooks()
    {

        //$this->cargador->add_action('wp_enqueue_scripts', $this->les_public, 'enqueue_styles');
        //$this->cargador->add_action('wp_enqueue_scripts', $this->les_public, 'enqueue_scripts');

        //Shortcode
        //$this->cargador->add_shortcode('newdatos', $this->les_public, 'new_data_shortcode_id');
    }

    //recorre los ganchos de accion
    public function les_run()
    {
        $this->cargador->les_run();
    }

    private function set_idiomas()
    {

        //$new_i18n = new NEW_i18n();
        //$this->cargador->add_action('plugins_loaded', $new_i18n, 'load_plugin_textdomain');
    }


    /**
     * El nombre del plugin utilizado para identificarlo de forma exclusiva en el contexto de
     * WordPress y para definir la funcionalidad de internacionalización.
     *
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }
    /**
     * Retorna el número de la versión del plugin
     */
    public function get_version()
    {
        return $this->version;
    }
}
