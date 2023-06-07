<?php
//crear una tabla en la BD
//Acceder a los métodos de las BD de Wordpress
global $wpdb;
$charset = $wpdb->get_charset_collate();
//creamos la tabla 
$tabla = $wpdb->prefix . 'mitabla';
//consulta
$wpdb->query(
    "CREATE TABLE IF NOT EXISTS  $tabla (
id mediumint(9) NOT NULL AUTO_INCREMENT,
nombre varchar(70) NOT NULL,
PRIMARY KEY(id)) $charset;"
);
require_once (ABSPATH . 'wp-admin/includes/upgrade.php');