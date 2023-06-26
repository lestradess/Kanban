"use strict";
//:VARIABLES**************************
$ = jQuery.noConflict();

let tareaActual = {};
let arrTareas = [];

let btnEliminar;

//Si LocalStorage está definido
if (typeof localStorage !== 'undefined') {
    console.log('LocalStorage definido');
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
    console.log('nuevo kanban definiendo tareas de prueba');
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
    guardarTarea();
}



//: Genera el codigo de inicio y el de coger soltar y arrastrar******
document.addEventListener('DOMContentLoaded', function () {
    // comprobando pagina correcta
    const pagina = document.querySelector(".container-kanban");
    if (pagina === null) {
        return;
    }
    //Definir variables de botones que cambian
    btnEliminar = document.getElementById("btn-eliminar");


    //zona jQuey**************************
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
                guardarTarea();
                console.log(`tarea ${ actualizarTarea.nombre } movida a tablero ${ ui.item.parent().attr("id") }`);
            }
        });
    });

    function inicializarTareas () {
        console.log('inicializando tareas');
        //posicionarCabecera();
        arrTareas.forEach(function (tarea) {

            crearDivTarea(tarea, true);

        });
    }
    inicializarTareas();

    //funcion para mover el input dentro del metabox
    function posicionarCabecera () {
        const input = document.getElementById('title');
        input.className = "col ms-3";
        const divTitle = document.querySelector('#titlewrap');
        divTitle.className = "row";
        const btnSave = document.createElement("button");
        btnSave.id = "save-post-button";
        btnSave.className = "btn btn-primary col-1 ms-2 me-3";
        btnSave.type = "submit";
        btnSave.textContent = "Actualizar";
        //divNuevo.className = "row p-2";
        divTitle.appendChild(btnSave);
    }
});



function crearDivTarea (tarea, guardada = false) {
    console.log('Crear tarjeta');

    const tablero = document.getElementById(tarea.tablero);

    const divTarea = document.createElement('div');
    divTarea.className = 'tarea p-1 row task';
    divTarea.setAttribute('id', tarea.id);
    divTarea.setAttribute('draggable', true);
    divTarea.setAttribute('ondragstart', 'drag(event)');

    divTarea.onclick = function (e) {
        e.preventDefault();
        tarea.id = divTarea.getAttribute('id');
        tarea.fecha = formatearFecha(tarea.id);
        tarea.nombre = pNombre.textContent;
        tarea.descripcion = pDescripcion.textContent;
        tarea.responsable = pResponsable.textContent;
        rellenarCampos(tarea);
    };
    const pNombre = document.createElement('p');
    pNombre.className = 'col';
    pNombre.setAttribute('id', 'nombre');
    pNombre.textContent = tarea.nombre;

    const pDescripcion = document.createElement('p');
    pDescripcion.className = 'col';
    pDescripcion.setAttribute('id', 'descripcion');
    pDescripcion.textContent = tarea.descripcion;

    const pResponsable = document.createElement('p');
    pResponsable.className = 'col';
    pResponsable.setAttribute('id', 'responsable');
    pResponsable.textContent = tarea.responsable;

    //divTarea.appendChild(pFecha)
    divTarea.appendChild(pNombre);
    divTarea.appendChild(pDescripcion),
        //divTarea.appendChild(pResponsable)

        tablero.appendChild(divTarea);
    //*GUARDAR TAREA EN ARRAY
    if (!guardada) {
        arrTareas.push(tarea);
        guardarTarea();
    }
}
//:Funcion de creacción de tarea dentro del modal********
function crearEditarTarea () {
    console.log('Crear/Editar Tarea');
    const divTarea = document.getElementById(tareaActual.id);

    if (divTarea) {
        divTarea.childNodes[ 0 ].textContent = document.getElementById("tarea-nombre").value;
        divTarea.childNodes[ 1 ].textContent = document.getElementById("tarea-descripcion").value;
        btnEliminar.classList.remove("d-none");
        const actualizarTarea = arrTareas.find(t => t.id === tareaActual.id);
        if (actualizarTarea) {
            actualizarTarea.nombre = document.getElementById("tarea-nombre").value;
            actualizarTarea.descripcion = document.getElementById("tarea-descripcion").value;
            cerrarModal();
        } else {
            console.log("tarea no encontrada");
        }
    } else {
        let tarea = {};
        tarea.id = crearId();
        tarea.tablero = "pendientes";
        tarea.nombre = document.getElementById("tarea-nombre").value;
        tarea.descripcion = document.getElementById("tarea-descripcion").value;
        tarea.responsable = document.getElementById("tarea-responsable").value;
        crearDivTarea(tarea);
        cerrarModal();
    }
    
}

function nuevaTarea (e) {
    console.log('Nueva tarea');
    e.preventDefault();
    abrirModal();
    limpiarCampos();
    const id = crearId();
    document.getElementById("tarea-fecha").textContent = 'Fecha: ' + formatearFecha(id);
    document.getElementById("tarea-id").textContent = id;
    tareaActual.id = id;
}
//:solo rellena los campos.
function rellenarCampos (tarea) {
    console.log('Rellenar campos');
    abrirModal();
    btnEliminar.classList.remove('d-none');
    document.getElementById("tarea-id").textContent = tarea.id;
    document.getElementById("tarea-fecha").textContent = 'Fecha: ' + formatearFecha(tarea.id);
    document.getElementById("tarea-nombre").value = tarea.nombre;
    document.getElementById("tarea-descripcion").value = tarea.descripcion;
    document.getElementById("tarea-responsable").value = tarea.responsable;
    tareaActual.id = tarea.id;
    tareaActual.nombre = tarea.nombre;
    tareaActual.responsable = tarea.responsable;
    tareaActual.fecha = tarea.fecha;
}
function eliminarTarea (e) {
    console.log('Elininar tarea');
    e.preventDefault();
    const respuesta = confirm(`Esta acción borrará la tarea "${ tareaActual.nombre }". ¿Deseas continuar?`);

    if (respuesta) {
        // Código a ejecutar si el usuario hace clic en "Aceptar"
        console.log("El usuario ha hecho clic en Aceptar.");
        console.log('desde eliminar tarea');
        console.log(tareaActual);
        const index = arrTareas.findIndex(t => t.id === tareaActual.id);
        if (index !== -1) {
            //borrada del array arrTareas
            const tareaBorrada = arrTareas.splice(index, 1);
            //borrar de localStorage
            guardarTarea();
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

function validarTarea () {
    const nombre = document.getElementById("tarea-nombre").value;
    console.log('validar Tarea');
    if (nombre === '') {
        alert('Debes asignar un nombre a la tarea');
    } else {
        crearEditarTarea();
    }
}
function guardarTarea () {
    console.log('Guardar tarea');
    //guardando en local storage
    console.log('Guardar localStorage');
    const jsonTareas = JSON.stringify(arrTareas);
    localStorage.setItem("arrTareas", jsonTareas);
    console.log('Guardar tarea');
    //TODO guardamos tarea sin importar si es edicion o nueva
}
function crearId () {
    return new Date().getTime();
}
function formatearFecha (timestamp) {
    console.log('Formatea fecha');
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
    console.log('Abrir modal');
    $('#modalTarea').modal('show');
}
function cerrarModal () {
    console.log('cerrar modal');
    $("#modalTarea").modal("hide");
}
function limpiarCampos () {
    console.log('Limpiar campos');
    btnEliminar.classList.add("d-none");
    document.getElementById("tarea-fecha").textContent = '';
    document.getElementById("tarea-nombre").value = '';
    document.getElementById("tarea-descripcion").value = '';
    document.getElementById("tarea-responsable").value = '';

}

function subtarea (e) {
    const divSubtarea = document.querySelector(".subtareas");
    const divRow = document.createElement("div");
    divRow.className = "row mb-2";
    const divCheck = document.createElement("div");
    divCheck.className = "col-auto d-flex align-items-center ms-2 pt-1 ";
    const divInput = document.createElement("div");
    divInput.type = "text";
    divInput.className = "col";
    const check = document.createElement("input");
    check.type = "checkbox";
    check.className = "custom-checkbox";
    const input = document.createElement("input");
    input.type = "text";
    input.className = "form-control";
    divCheck.appendChild(check);
    divInput.appendChild(input);
    divRow.appendChild(divCheck);
    divRow.appendChild(divInput);
    divSubtarea.appendChild(divRow);

}
