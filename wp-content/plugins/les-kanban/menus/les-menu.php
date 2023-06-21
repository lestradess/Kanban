<?php
if (!function_exists('les_menu')) {
    function les_menu()
    {
        add_menu_page(
            'LES Page', // nombre del menu
            'Pruebas', // texto del menu
            'manage_options', //capacidad requerida para mostrar el menu
            'les_menu', //slug
            'les_menu_page_display', //callback
            'dashicons-admin-customizer', //icono
            '6' //posicion en el menu
        );
        /** Submenu de pagina */
        /* add_submenu_page(
            'les_menu', //slug del menu principal
            'Submenu 1', //titulo del menú
            'Submenu 1', //titulo del submenu
            'manage_options', //capability
            'les_submenu01', //slug
            'les_submenu01_display', //funcion callback
            1 //posicion
        ); */
    };
    add_action('admin_menu', 'les_menu');
};
//funcion callback del menú
if (!function_exists('les_menu_page_display')) {
    function les_menu_page_display()
    {
?>
        <!--html-->
        <div class="wrap">
            <form action="" method="post">
                <input type="text" placeholder="Nombre" name="nombre" id="nombre">
                <!-- <input type="text" placeholder="Apellidos" name="apellidos" id="apellidos"> -->
                <?php //do_action('res_extend_form'); 
                ?>
                <input id="enviar" class="btn btn-primary m-0 mt-1" type="submit" name="enviar" value="Enviar"">
            </form>
            <!--Aqui el contenedor donde mostraremos la info del ajax-->
            <div class=" contenidoAjax">
        </div>
        </div>
    <?php
    }
};

//Para remover un menu hay que insertar el código siguiente en la funcion donde se crea
// remove_menu_page('slug_del_menu')

//Funcion callback del submenu
if (!function_exists('les_submenu01_display')) {
    function les_submenu01_display()
    {
    ?>
        <div class="wap">
            <h3>Bienvenido al submenú</h3>
        </div>
<?php
    };
};
