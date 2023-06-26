<?php 
function les_mtb_kanban_add()
{
    add_meta_box(
        'les_mtb_kanban', // ID del metabox
        ' ', // Título del metabox
        'les_mtb_kanban_callback', // Función que se encarga de mostrar el contenido del metabox
        'les_kanban', // Tipo de contenido (slug del padre)al que se debe aplicar el metabox
        'normal', // Contexto del metabox (puede ser 'normal', 'advanced' o 'side')
        'default' // Prioridad del metabox (puede ser 'high', 'core', 'default' o 'low')

    );
}
add_action('add_meta_boxes', 'les_mtb_kanban_add');

// Función que muestra el contenido del metabox llamada en les_mtb_kanban_add
function les_mtb_kanban_callback($post)
{

    require_once('page-kanban.php');
}

// Función para guardar los datos del metabox
function les_mtb_kanban_save()
{
}
add_action('save_post', 'les_mtb_kanban_save');

