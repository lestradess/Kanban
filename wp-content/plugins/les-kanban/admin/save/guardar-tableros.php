
<?php
function my_ajax_action_handler()
{
    $jsonData = $_POST['jsonData']; // Obtener los datos JSON enviados desde JavaScript

    // Procesar los datos recibidos
    $data = json_decode($jsonData, true);
    // ... realizar las operaciones necesarias ...

    // Enviar una respuesta en formato JSON
    $respuesta = array('mensaje' => 'Datos recibidos correctamente');
    header('Content-Type: application/json');
    echo json_encode($respuesta);

    // Importante: Detener la ejecución de WordPress después de enviar la respuesta
    wp_die();
}
add_action('wp_ajax_my_ajax_action', 'my_ajax_action_handler');
add_action('wp_ajax_nopriv_my_ajax_action', 'my_ajax_action_handler');
