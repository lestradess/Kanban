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
        global $wpdb;
        $kanban = $_POST['kanban'];//se define en el data del ajax
        //datos del array
        $data = array(
            'nombre' => $kanban
            
        );
        $wpdb->insert(LES_TABLE_KANBAN, $data);
        if ($wpdb->last_error !== '') {
            error_log('Error en la consulta de inserción: ' . $wpdb->last_error);
        } else {
            error_log('todo correcto');
        }
        wp_die();
    }
    
}
