<?php

class LES_Activator
{
    /**
     * Método estatico que se ejecuta al activar el plugin
     *
     * Creacion de la tabla {$wpdb->prefix}newtheme_data
     * para guardar toda la información necesaria
     *
     */
    public static function activate()
    {
        /**Al utilizar global $wpdb;, puedes acceder al objeto $wpdb en cualquier parte de tu código dentro de WordPress y utilizar sus métodos para interactuar con la base de datos de manera segura y eficiente. */
        global $wpdb;

        //obtiene el conjunto de caracteres y la configuración de intercalación de la base de datos de WordPress y almacenarlos en la variable $charset para su uso posterior en consultas SQL.
        //$charset = $wpdb->get_charset_collate();

        //creamos la tabla 
        $sql = "CREATE TABLE IF NOT EXISTS " . LES_TABLE . " (
				id int(9) NOT NULL AUTO_INCREMENT, 
				nombre varchar(70) NOT NULL, 
				data longtext NOT NULL, 
				PRIMARY KEY (id) 
			);	
			";

        //Ejecutamos la consulta.
        $wpdb->query($sql);

        /**
         * Este archivo contiene funciones relacionadas con la actualización y migración de la base de datos de WordPress. Al incluir este archivo en un script, se obtiene acceso a estas funciones para realizar tareas como crear o modificar tablas de la base de datos, ejecutar consultas SQL, realizar actualizaciones de esquema, entre otras acciones relacionadas con la gestión de la base de datos de WordPress.
         */
        //require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    }
}
