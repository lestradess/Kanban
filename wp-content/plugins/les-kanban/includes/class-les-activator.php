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

        $sqlKanban = "CREATE TABLE IF NOT EXISTS " . LES_TABLE . " (
				id int(9) NOT NULL AUTO_INCREMENT, 
				nombre varchar(70) NOT NULL, 
				data longtext NOT NULL, 
				PRIMARY KEY (id) 
			);	
			";

        //Ejecutamos la consulta.
        $wpdb->query($sqlKanban);

    }
}
