<?php

/**
 * *HTML de la pagina del menú
 */
$titulo = get_the_title();
//$dato = $_POST['dato'];
// Procesar los datos recibidos
//$tareas = $_POST['tareas'];
// ... realizar las operaciones necesarias ...

// Enviar la dato en formato JSON
//header('Content-Type: application/json');
// $dato debe contener los datos que deseas devolver

?>
<div class="contendorAjax">
    <?php 
    //echo json_encode($dato);
    
    ?>
</div>
<div class="container-kanban">
    <div class="d-flex flex-row mt-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#E70" class="m-2 bi bi-microsoft" viewBox="0 0 16 16">
            <path d="M7.462 0H0v7.19h7.462V0zM16 0H8.538v7.19H16V0zM7.462 8.211H0V16h7.462V8.211zm8.538 0H8.538V16H16V8.211z" />
        </svg>
        <p class="kanban-p">Tablero <?php echo $titulo; ?> </p>

        <button id="btn-tarea" type="button" class="btn-gris mt-0 mb-0 ms-2" onclick="abrirModal(event)">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg m-0 p-0" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                </svg>
                <text class="hidden-xs hidden-md hidden-sm">Tarea</text>
            </span>
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalTarea" tabindex="-1" aria-labelledby="modalTareaLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <p class="modal-title" id="tarea-fecha">Tarea</p>
                    <p class="id-tarea">id</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="tarea-nombre" class="strong-input">Nombre Tarea:</label>
                        </div>
                        <div class="col-12">
                            <input type="text" id="tarea-nombre" autocomplete="off" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="tarea-descripcion" autocomplete="off" class="strong-input">Descripción Tarea:</label>
                        </div>
                        <div class="col-12">
                            <textarea type="text" id="tarea-descripcion" class="w-100 form-control" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="tarea-responsable" class="strong-input">Responsable Tarea:</label>
                        </div>
                        <div class="col-12">
                            <input type="text" id="tarea-responsable" autocomplete="off" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-gris" onclick="cerrarModal(event)">Cancelar</button>
                    <button type="button" id="btn-eliminar" class="btn-gris d-none" onclick="eliminarTarea(event)">Eliminar</button>
                    <input class="btn-gris" id="btn-crear-editar" type="button" value="Nueva Tarea" onclick="crearTarea(event)" />
                </div>
            </div>
        </div>
    </div>


    <div class="overflow-auto overflow-x-visible overflow-x-scroll d-flex col h-100">
        <div class="kanban-block sortable" id="pendientes" ondrop="drop(event)" ondragover="allowDrop(event)">
            <div class="pendiente text-center d-flex w-100 mb-1 pb-1 mb-1 pb-1">
                <p class="mb-0 w-100"><span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16">
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                        </svg></span> Pendiente <span class="">0</span></p>
            </div>
        </div>

        <div class="kanban-block sortable" id="progreso" ondrop="drop(event)" ondragover="allowDrop(event)">
            <div class="progreso text-center d-flex w-100 mb-1 pb-1">
                <p class="mb-0 w-100"><span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wrench-adjustable" viewBox="0 0 16 16">
                            <path d="M16 4.5a4.492 4.492 0 0 1-1.703 3.526L13 5l2.959-1.11c.027.2.041.403.041.61Z" />
                            <path d="M11.5 9c.653 0 1.273-.139 1.833-.39L12 5.5 11 3l3.826-1.53A4.5 4.5 0 0 0 7.29 6.092l-6.116 5.096a2.583 2.583 0 1 0 3.638 3.638L9.908 8.71A4.49 4.49 0 0 0 11.5 9Zm-1.292-4.361-.596.893.809-.27a.25.25 0 0 1 .287.377l-.596.893.809-.27.158.475-1.5.5a.25.25 0 0 1-.287-.376l.596-.893-.809.27a.25.25 0 0 1-.287-.377l.596-.893-.809.27-.158-.475 1.5-.5a.25.25 0 0 1 .287.376ZM3 14a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" />
                        </svg></span> En Progreso <span class="">0</span></p>
            </div>
        </div>
        <div class="kanban-block sortable" id="pruebas" ondrop="drop(event)" ondragover="allowDrop(event)">
            <div class="prueba text-center d-flex w-100 mb-1 pb-1">
                <p class="mb-0 w-100"><span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-controller" viewBox="0 0 16 16">
                            <path d="M11.5 6.027a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1zm2.5-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1zm-6.5-3h1v1h1v1h-1v1h-1v-1h-1v-1h1v-1z" />
                            <path d="M3.051 3.26a.5.5 0 0 1 .354-.613l1.932-.518a.5.5 0 0 1 .62.39c.655-.079 1.35-.117 2.043-.117.72 0 1.443.041 2.12.126a.5.5 0 0 1 .622-.399l1.932.518a.5.5 0 0 1 .306.729c.14.09.266.19.373.297.408.408.78 1.05 1.095 1.772.32.733.599 1.591.805 2.466.206.875.34 1.78.364 2.606.024.816-.059 1.602-.328 2.21a1.42 1.42 0 0 1-1.445.83c-.636-.067-1.115-.394-1.513-.773-.245-.232-.496-.526-.739-.808-.126-.148-.25-.292-.368-.423-.728-.804-1.597-1.527-3.224-1.527-1.627 0-2.496.723-3.224 1.527-.119.131-.242.275-.368.423-.243.282-.494.575-.739.808-.398.38-.877.706-1.513.773a1.42 1.42 0 0 1-1.445-.83c-.27-.608-.352-1.395-.329-2.21.024-.826.16-1.73.365-2.606.206-.875.486-1.733.805-2.466.315-.722.687-1.364 1.094-1.772a2.34 2.34 0 0 1 .433-.335.504.504 0 0 1-.028-.079zm2.036.412c-.877.185-1.469.443-1.733.708-.276.276-.587.783-.885 1.465a13.748 13.748 0 0 0-.748 2.295 12.351 12.351 0 0 0-.339 2.406c-.022.755.062 1.368.243 1.776a.42.42 0 0 0 .426.24c.327-.034.61-.199.929-.502.212-.202.4-.423.615-.674.133-.156.276-.323.44-.504C4.861 9.969 5.978 9.027 8 9.027s3.139.942 3.965 1.855c.164.181.307.348.44.504.214.251.403.472.615.674.318.303.601.468.929.503a.42.42 0 0 0 .426-.241c.18-.408.265-1.02.243-1.776a12.354 12.354 0 0 0-.339-2.406 13.753 13.753 0 0 0-.748-2.295c-.298-.682-.61-1.19-.885-1.465-.264-.265-.856-.523-1.733-.708-.85-.179-1.877-.27-2.913-.27-1.036 0-2.063.091-2.913.27z" />
                        </svg></span> Pruebas <span class="">0</span></p>
            </div>
        </div>

        <div class="kanban-block sortable" id="completados" ondrop="drop(event)" ondragover="allowDrop(event)">
            <div class="completado text-center d-flex w-100 mb-1 pb-1">
                <p class="mb-0 w-100"><span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                        </svg></span> Completado <span class="">0</span></p>
            </div>
        </div>
    </div>

</div>