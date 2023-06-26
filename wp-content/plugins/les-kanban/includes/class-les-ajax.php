<?php

class LES_Ajax
{
    
    public function ajax_sacar_datos()
    {
        global $wpdb;
        $valor = $_POST['consulta'];
        
        $resultado = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}a_kanban WHERE nombre LIKE '%$valor%'", OBJECT);

        $respuesta = json_encode($resultado);

        echo $respuesta;
        die();
    }
    public function ajax_introducir_datos(){
        global $wpdb;
        $valor = $_POST['nombre'];
        $data = array(
            'nombre' => $valor
        );
        $wpdb->insert(LES_TABLE,$data);
        if ($wpdb->last_error !== '') {
            error_log('Error en la consulta de inserción: ' . $wpdb->last_error);
        }else{
            error_log('todo correcto');
        }

        die();
    }
    public function ajax_add_datos_kanban(){
        //es una variable global en WordPress que representa la clase wpdb (WordPress Database) y proporciona una interfaz para interactuar con la base de datos de WordPress.
        global $wpdb;
        
        $valor = $_POST['valor'];//se define en el data del ajax
        //datos del array
        $data = array(
            'nombre' => $valor
        );
        $wpdb->insert(LES_TABLE_KANBAN, $data);//Nombre de la tabla en el archivo principal
        if ($wpdb->last_error !== '') {
            error_log('Error en la consulta de inserción: ' . $wpdb->last_error);
        } else {
            error_log('todo correcto');
        }
        //cerrar la consulta
        wp_die();
    }
}
