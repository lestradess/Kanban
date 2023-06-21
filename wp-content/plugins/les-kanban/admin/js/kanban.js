"use strict";
//:VARIABLES**************************
$ = jQuery.noConflict();

let isEditando = false;
let isValido = false;
//?
let tareaActual = {};
let arrTareas = [];



//Si LocalStorage está definido
if (typeof localStorage !== 'undefined') {
    const jsonArray = localStorage.getItem("arrTareas");
    try {
        if (jsonArray) {
            arrTareas = JSON.parse(jsonArray);
        }
    } catch (error) {
        console.log('Error al parsear los datos de localStorage');
    }
}
//Si no hay tareas en localStorage se crean unas de prueba
if (arrTareas.length === 0) {
    for (let i = 0; i < 4; i++) {
        const tarea = {
            id: '168641623319' + i,
            nombre: 'Prueba' + (i + 1),
            descripcion: 'Para Eliminar',
            responsable: 'Lestrades',
            tablero: [ 'pendientes', 'progreso', 'pruebas', 'completados' ][ i ]
        };
        arrTareas.push(tarea);
    }
    guardarLocalStorage();
}



//: Genera el codigo de inicio y el de coger soltar y arrastrar******
document.addEventListener('DOMContentLoaded', function () {
    // comprobando pagina correcta
    const pagina = document.querySelector(".container-kanban");
    if (pagina == null) {
        return;
    }

    
    console.log(pagina);
    $(document).ready(function () {
        $(".sortable").sortable({
            items: ".task",
            connectWith: ".sortable",
            tolerance: "pointer",
            start: function (event, ui) {
                ui.placeholder.height(ui.item.height());
                ui.item.addClass("task-dragging");
            },
            stop: function (event, ui) {
                ui.item.removeClass("task-dragging");
                tareaActual.id = ui.item[ 0 ].id;
                const actualizarTarea = arrTareas.find(t => t.id === tareaActual.id);
                actualizarTarea.tablero = ui.item.parent().attr("id");
                guardarLocalStorage();
                console.log(`tarea ${ actualizarTarea.nombre } movida a tablero ${ ui.item.parent().attr("id") }`)
            }
        });

    });

    //:Funcion para poder arrastrar el elemento
    function drag (event) {
        event.dataTransfer.setData("text", event.target.id)
    }

    /* function allowDrop (event) {
        event.preventDefault();
        $(event.target).addClass('drop-area'); // Agrega una clase para resaltar el área de soltar
    } */

    //:Funcion para soltar el elemento *******
    function drop (event) {
        event.preventDefault();
        const data = event.dataTransfer.getData("text");
        const droppedElement = document.getElementById(data);
        $(event.currentTarget).append(droppedElement);
        //$(event.currentTarget).removeClass('drop-area'); // Elimina la clase de resaltado
        $('.sortable-list').sortable({
            connectWith: '.sortable-list' // Habilita la conexión entre las listas
        });
    }
    function inicializarTareas () {
        arrTareas.forEach(function (tarea) {
            //moverInput();
            registrarTarea(tarea, true);

        })
    }
    inicializarTareas();

    //funcion para mover el input dentro del metabox
    function moverInput () {
        const input = document.getElementById('title');
        const metabox = document.querySelector('.postbox-header');
        const titleMetabox = document.querySelector('.hndle');
        const divNuevo = document.createElement("div");
        divNuevo.className = "row p-2";
        titleMetabox.classList.add("col");
        input.classList.add("col");
        divNuevo.appendChild(titleMetabox);
        divNuevo.appendChild(input);
        metabox.insertBefore(divNuevo, metabox.firstChild);
    }
});
function registrarTarea (tarea, guardada = false) {

    const tablero = document.getElementById(tarea.tablero);

    const divTarea = document.createElement('div')
    divTarea.className = 'tarea p-1 row task';
    divTarea.setAttribute('id', tarea.id)
    divTarea.setAttribute('draggable', true)
    divTarea.setAttribute('ondragstart', 'drag(event)')
    divTarea.onclick = function (e) {
        e.preventDefault();
        isEditando = true;
        tarea.id = divTarea.getAttribute('id')
        tarea.fecha = formatearFecha(tarea.id)
        tarea.nombre = pNombre.textContent
        tarea.descripcion = pDescripcion.textContent
        tarea.responsable = pResponsable.textContent
        $('#modalTarea').modal('show');
        editarTarea(tarea);
    }
    const pNombre = document.createElement('p')
    pNombre.className = 'col';
    pNombre.setAttribute('id', 'nombre')
    pNombre.textContent = tarea.nombre

    const pDescripcion = document.createElement('p')
    pDescripcion.className = 'col';
    pDescripcion.setAttribute('id', 'descripcion')
    pDescripcion.textContent = tarea.descripcion

    const pResponsable = document.createElement('p')
    pResponsable.className = 'col';
    pResponsable.setAttribute('id', 'responsable')
    pResponsable.textContent = tarea.responsable

    //divTarea.appendChild(pFecha)
    divTarea.appendChild(pNombre)
    divTarea.appendChild(pDescripcion)
    //divTarea.appendChild(pResponsable)
    //divTarea.appendChild(inputEditar)
    //divTarea.appendChild(inputBorrar)
    tablero.appendChild(divTarea)
    //*GUARDAR TAREA EN ARRAY
    if (!guardada) {
        arrTareas.push(tarea);
        guardarLocalStorage();
    }
}
//:Funcion de creacción de tarea dentro del modal********
function crearTarea (event) {
    event.preventDefault();
    abrirModal();
    validarCampos(
        document.getElementById("tarea-nombre").value,
        document.getElementById("tarea-descripcion").value
    )
    if (isValido) {
        if (isEditando) {
            const divTarea = document.getElementById(tareaActual.id);
            divTarea.childNodes[ 0 ].textContent = document.getElementById("tarea-nombre").value
            divTarea.childNodes[ 1 ].textContent = document.getElementById("tarea-descripcion").value
            btnEditar.textContent = "Editar Tarea"
            btnEliminar.classList.remove("d-none");
            const actualizarTarea = arrTareas.find(t => t.id === tareaActual.id);
            if (actualizarTarea) {
                actualizarTarea.nombre = document.getElementById("tarea-nombre").value
                actualizarTarea.descripcion = document.getElementById("tarea-descripcion").value
                console.log(arrTareas);
            } else {
                console.log("tarea no encontrada");
            }
        } else {
            let tarea = {};
            tarea.id = new Date().getTime();
            tarea.tablero = "pendientes";
            tarea.nombre = document.getElementById("tarea-nombre").value
            tarea.descripcion = document.getElementById("tarea-descripcion").value
            tarea.responsable = document.getElementById("tarea-responsable").value
            registrarTarea(tarea);
        }
    }
}

function validarCampos (nombre, descripcion) {
    if (nombre === '' || descripcion === '') {
        alert('Debes asignar el nombre y la descripción de la tarea')
        isValido = false
        
    } else {
        isValido = true
    }
}

function editarTarea (tarea) {
    console.log(tarea);
    const btnEditar = document.getElementById("btn-crear-editar")
    btnEditar.value = "Editar Tarea"
    btnEditar.classList.remove('btn-crear')
    btnEditar.classList.add('btn-editar')
    const btnEliminar = document.getElementById("btn-eliminar");
    btnEliminar.classList.remove('d-none');
    document.getElementById("tarea-fecha").textContent = 'Fecha: ' + formatearFecha(tarea.id)
    document.getElementById("tarea-nombre").value = tarea.nombre
    document.getElementById("tarea-descripcion").value = tarea.descripcion
    document.getElementById("tarea-responsable").value = tarea.responsable
    tareaActual.id = tarea.id;
    tareaActual.id = tarea.id;
    tareaActual.nombre = tarea.nombre;
    tareaActual.responsable = tarea.responsable;
    tareaActual.fecha = tarea.fecha;
}

function formatearFecha (timestamp) {
    const fecha = new Date(parseInt(timestamp));
    const dia = fecha.getDate();
    const mes = fecha.getMonth() + 1; // Los meses empiezan en 0, por eso se suma 1
    const año = fecha.getFullYear();
    const hora = fecha.getHours();
    const minuto = fecha.getMinutes();
    const segundo = fecha.getSeconds();
    return `${ dia }/${ mes }/${ año } ${ hora }:${ minuto }:${ segundo }`;
}

function abrirModal () {
    limpiarCampos();
    $('#modalTarea').modal('show');
}
function cerrarModal () {
    limpiarCampos();
    $("#modalTarea").modal("hide");
}
function limpiarCampos () {
    const btnEditar = document.getElementById("btn-crear-editar")
    btnEditar.value = "Nueva Tarea"
    const btnEliminar = document.getElementById("btn-eliminar");
    btnEliminar.classList.add("d-none");
    document.getElementById("tarea-fecha").value = ''
    document.getElementById("tarea-nombre").value = ''
    document.getElementById("tarea-descripcion").value = ''
    document.getElementById("tarea-responsable").value = ''

}
function eliminarTarea (e) {
    e.preventDefault();
    const respuesta = confirm(`Esta acción borrará la tarea "${ tareaActual.nombre }". ¿Deseas continuar?`);

    if (respuesta) {
        // Código a ejecutar si el usuario hace clic en "Aceptar"
        console.log("El usuario ha hecho clic en Aceptar.");
        console.log('desde eliminar tarea')
        console.log(tareaActual)
        const index = arrTareas.findIndex(t => t.id === tareaActual.id);
        if (index !== -1) {
            //borrada del array arrTareas
            const tareaBorrada = arrTareas.splice(index, 1);
            //borrar de localStorage
            guardarLocalStorage();
            //borrar el div
            const borrarTareaDiv = document.getElementById(tareaActual.id);
            if (borrarTareaDiv) {
                borrarTareaDiv.remove();
            } else {
                console.log('no hay div que borrar');
            }

            cerrarModal();
            console.log('Tarea borrada:', tareaBorrada[ 0 ]);
        } else {
            console.log('No se encontró la tarea:', tareaActual.id);
        }

    } else {
        // Código a ejecutar si el usuario hace clic en "Cancelar"
        console.log("El usuario ha hecho clic en Cancelar.");
        cerrarModal();
    }

}
function guardarLocalStorage () {
    const jsonTareas = JSON.stringify(arrTareas);
    localStorage.setItem("arrTareas", jsonTareas);
    //console.log(jsonTareas);
    
    // Realizar la solicitud AJAX
    $.ajax({
        url: datos_kanban.ajaxurl, // URL del archivo PHP que recibirá los datos
        method: 'POST',
        //dataType: 'json', // Método de solicitud (POST o GET)
        data: { 
            action: 'mi_funcion_ajax', 
            dato: jsonTareas }, 
        
        
        // Datos a enviar al servidor
        success: function (response) {
            // Callback que se ejecuta cuando la solicitud se completa exitosamente
            console.log('Los datos se guardaron correctamente en el servidor');
            console.log('Respuesta del servidor:', response);
        },
        error: function (xhr, status, error) {
            // Callback que se ejecuta cuando se produce un error en la solicitud
            console.error('Ocurrió un error en la solicitud:', error);
        }
    });
}