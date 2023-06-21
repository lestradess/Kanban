<?php
class LES_Ajax
{
    public function ajax_sacar_datos()
    {
        $valor = $_POST['consulta'];
        global $wpdb;
        $resultado = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}a_kanban WHERE nombre LIKE '%$valor%'", OBJECT);

        $respuesta = json_encode($resultado);

        echo $respuesta;
        die();
    }
    public function ajax_introducir_datos(){
        global $wpdb;
        $valor = $_POST['valor'];
        error_log('Este es el valor de los datos'.$valor);
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
}
