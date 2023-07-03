"use strict";
//:VARIABLES**************************
$ = jQuery.noConflict();
const nombrePagina = document.title;
let arrTareas = [];
let arrSubtareas = [];
let btnEliminar;
let objTableros = {
    "pendientes": 0,
    "progreso": 0,
    "pruebas": 0,
    "completados": 0
};

//Si LocalStorage está definido
if (typeof localStorage !== 'undefined') {
    console.log('LocalStorage definido');
    const jsonArray = localStorage.getItem(nombrePagina);
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
                const tablero = ui.item.parent().attr("id");
                console.log(`cojo del tablero ${ tablero }`);
                tableros(tablero, -1);
            },
            stop: function (event, ui) {
                ui.item.removeClass("task-dragging");
                const id = ui.item[ 0 ].id;
                const tarea = buscarTarea(id);
                if (tarea) {
                    const tablero = ui.item.parent().attr("id");
                    console.log(`pongo la tarea ${ tarea.nombre } en el tablero ${ tablero }`);
                    tarea.tablero = tablero;
                    tableros(tablero, 1);
                }
            }
        });
    });

    function inicializarTareas () {
        console.log('inicializando tareas');
        //posicionarCabecera();
        arrTareas.forEach(function (tarea) {
            crearDivTarea(tarea.id);
        });
    }
    inicializarTareas();
});


function nuevaTarea (e) {
    console.log('Nueva tarea');
    e.preventDefault();
    abrirModal();
    limpiarCampos();
    const id = crearId();
    document.getElementById("tarea-fecha").textContent = 'Fecha: ' + formatearFecha(id);
    document.getElementById("tarea-id").textContent = String(id);
    document.getElementById("tarea-tablero").textContent = 'Pendientes';
}

function crearDivTarea (id) {
    console.log('Crear Div Tarea');
    let suma;
    const buscarDivTarea = document.getElementById(id);
    if (buscarDivTarea) {
        buscarDivTarea.remove();
        suma = 0;
    } else {
        suma = 1;
    }
    const tarea = buscarTarea(id);
    const tableroId = tarea.tablero.toLowerCase();
    const tablero = document.getElementById(tableroId);

    const divTarea = document.createElement('div');
    divTarea.className = 'tarea p-0 row task position-relative';
    divTarea.setAttribute('id', tarea.id);
    divTarea.setAttribute('draggable', true);
    divTarea.setAttribute('ondragstart', 'drag(event)');

    divTarea.onclick = function (e) {
        e.preventDefault();
        console.log('tarea desde onclick')
        rellenarCampos(tarea.id);
    };
    const pNombre = document.createElement('p');
    pNombre.className = 'col';
    pNombre.setAttribute('id', 'nombre');
    pNombre.textContent = tarea.nombre;
    divTarea.appendChild(pNombre);

    const posicion = document.createElement('p');
    posicion.className = 'col posicion p-0 m-0 d-none ';
    posicion.textContent = tarea.posicion;
    divTarea.appendChild(posicion);

    const divCheck = document.createElement("div");
    divCheck.className = "m-0 p-0";
    if (tarea.subTareas) {
        if (tarea.subTareas.length > 0) {
            const subtareas = tarea.subTareas;
            subtareas.forEach(function (subtarea) {
                const subtareaP = document.createElement("p");
                subtareaP.className = "text-overflow-ellipsis";
                const subtareaText = document.createElement("span");
                subtareaText.textContent = subtarea.nombre;
                const checkSpan = document.createElement("span");
                const svgElement = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                svgElement.setAttribute("xmlns", "http://www.w3.org/2000/svg");
                svgElement.setAttribute("width", "25");
                svgElement.setAttribute("height", "25");
                svgElement.setAttribute("viewBox", "0 0 16 16");
                let pathElement = document.createElementNS("http://www.w3.org/2000/svg", "path");;
                if (subtarea.check) {
                    svgElement.setAttribute("class", "bi bi-check2-circle me-1");
                    pathElement.setAttribute("d", "M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0");
                    subtareaText.classList.add('text-decoration-line-through');
                    pathElement.setAttribute("fill", "#50af3c");
                } else {
                    svgElement.setAttribute("width", "20");
                    svgElement.setAttribute("height", "20");
                    svgElement.setAttribute("class", "bi bi-circle me-2");
                    pathElement.setAttribute("fill", "#ca4552");
                    pathElement.setAttribute("d", "M11 2a3 3 0 0 1 3 3v6a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3V5a3 3 0 0 1 3-3h6zM5 1a4 4 0 0 0-4 4v6a4 4 0 0 0 4 4h6a4 4 0 0 0 4-4V5a4 4 0 0 0-4-4H5z");
                }
                svgElement.appendChild(pathElement);
                checkSpan.appendChild(svgElement);
                subtareaP.appendChild(checkSpan);
                if (subtarea.url) {
                    subtareaP.appendChild(subtareaText);
                    subtareaText.classList.add("enlace");
                    subtareaText.onclick = (e) => {
                        e.stopPropagation();
                        window.open(subtarea.url);
                    }
                } else {
                    subtareaP.appendChild(subtareaText);
                    subtareaP.classList.remove("enlace");
                }
                divCheck.appendChild(subtareaP);
            });
        }
    }
    divTarea.appendChild(divCheck);
    tablero.appendChild(divTarea);
    tableros(tableroId, suma);
}

//:Funcion de creacción de tarea dentro del modal********
function crearEditarTarea (tarea) {
    console.log('Crear/Editar Tarea');
    const divTarea = document.getElementById(tarea.id);

    if (divTarea) {
        btnEliminar.classList.remove("d-none");
        const actualizarTarea = buscarTarea(tarea.id);
        if (actualizarTarea) {
            const indice = arrTareas.indexOf(actualizarTarea);
            arrTareas.splice(indice, 1, tarea);
        }
        guardarTarea();
        crearDivTarea(tarea.id);
        cerrarModal();

    } else {
        guardarTarea(tarea);
        crearDivTarea(tarea.id);
        cerrarModal();
    }

}

function recogerDatos () {
    console.log('Recoger datos');
    let tarea = {};
    tarea.fecha = document.getElementById("tarea-fecha").textContent;
    tarea.tablero = document.getElementById("tarea-tablero").textContent;
    tarea.id = document.getElementById("tarea-id").textContent;
    tarea.nombre = document.getElementById("tarea-nombre").value;
    const descripcion = document.getElementById("tarea-descripcion");
    tarea.descripcion = descripcion.value ? descripcion.value : 'Sin descripción';
    const responsable = document.getElementById("tarea-responsable")
    tarea.responsable = responsable.value ? responsable.value : "Sin responsable";
    tarea.subTareas = [];
    const divSubtareas = document.querySelectorAll(".subtarea");
    let contador = 0;
    if (divSubtareas.length > 0) {
        divSubtareas.forEach(function (subtarea) {
            let subTarea = {};
            const id = divSubtareas[ contador ].getAttribute("id");
            console.log(id);
            contador++;
            subTarea.id = id;
            const checkbox = subtarea.querySelector(".custom-checkbox");
            subTarea.check = checkbox.checked ? true : false;
            const nombreSubtarea = subtarea.querySelector(".nombre-subtarea");
            if (nombreSubtarea.value === "") return;
            subTarea.nombre = nombreSubtarea.value;
            const urlSubtarea = subtarea.querySelector(".url-subtarea");
            subTarea.url = urlSubtarea ? urlSubtarea.value : "";
            tarea.subTareas.push(subTarea);
        });
    };
    console.log(tarea);
    crearEditarTarea(tarea);
}



//:solo rellena los campos.
function rellenarCampos (e, iD = null) {
    let id;
    if (!(e instanceof MouseEvent)) {
        id = e
    } else {
        id = iD;
    }
    console.log('Rellenar campos');
    const tarea = buscarTarea(id);
    abrirModal();
    limpiarCampos();
    btnEliminar.classList.remove('d-none');
    document.getElementById("tarea-id").textContent = tarea.id;
    document.getElementById("tarea-fecha").textContent = 'Fecha: ' + formatearFecha(tarea.id);
    const tareaTablero = tarea.tablero;
    const tablero = tareaTablero.charAt(0).toUpperCase() + tareaTablero.slice(1);
    document.getElementById("tarea-tablero").textContent = tablero;
    document.getElementById("tarea-nombre").value = tarea.nombre;
    document.getElementById("tarea-descripcion").value = tarea.descripcion;
    document.getElementById("tarea-responsable").value = tarea.responsable;
    if (tarea.subTareas) {
        if (tarea.subTareas.length > 0) {
            tarea.subTareas.forEach(function (subtarea) {
                crearEditarSubtarea(subtarea);
            });
        }
    }
}
function eliminarTarea (e) {
    console.log('Elininar tarea');
    console.log(e);
    e.preventDefault();
    const tareaId = document.getElementById("tarea-id").textContent;
    const nombreTarea = document.getElementById("tarea-nombre").value;
    const respuesta = confirm(`Esta acción borrará la tarea "${ nombreTarea }". ¿Deseas continuar?`);
    if (respuesta) {
        // Código a ejecutar si el usuario hace clic en "Aceptar"
        console.log("El usuario ha hecho clic en Aceptar.");
        console.log('desde eliminar tarea');
        const index = buscarTarea(tareaId);
        if (index !== -1) {
            //borrada del array arrTareas
            const tareaBorrada = arrTareas.splice(index, 1);
            //borrar de localStorage
            guardarTarea();
            //borrar el div
            const borrarTareaDiv = document.getElementById(tareaId);
            if (borrarTareaDiv) {
                borrarTareaDiv.remove();
            }
            console.log('Tarea borrada:', tareaBorrada[ 0 ]);
        }
    }
}

function validarTarea (e) {
    const nombre = document.getElementById("tarea-nombre").value;
    console.log('validar Tarea');
    if (nombre === '') {
        alert('Debes asignar un nombre a la tarea');
    } else {
        recogerDatos();
    }
}
function guardarTarea (tarea = false) {
    console.log('Guardar tarea');

    if (tarea) {
        arrTareas.push(tarea);
    }
    //guardando en local storage
    const jsonTareas = JSON.stringify(arrTareas);
    localStorage.setItem(nombrePagina, jsonTareas);
    cerrarModal();
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

    if ($("#modalTarea").is(":visible")) {
        console.log('cerrar modal');
        $("#modalTarea").modal("hide");
    }
}
function limpiarCampos () {
    console.log('Limpiar campos');
    btnEliminar.classList.add("d-none");
    document.getElementById("tarea-nombre").value = '';
    document.getElementById("tarea-descripcion").value = '';
    document.getElementById("tarea-responsable").value = '';
    const divSubtareas = document.querySelectorAll(".subtarea");
    if (divSubtareas.length > 0) {
        divSubtareas.forEach(function (subtarea) {
            subtarea.remove();
        });
    }
}

function crearEditarSubtarea (e = null, subT = null) {
    console.log("Crear Editar subtarea");
    let subTarea;

    if (e instanceof MouseEvent) {
        subTarea = subT;
    } else {

        subTarea = e
    }
    const id = subTarea ? 'sub' + subTarea.id : 'sub' + crearId();
    const divSubtarea = document.querySelector(".subtareas");
    const divRow = document.createElement("div");
    divRow.className = "row mb-2 d-flex align-items-center subtarea";
    divRow.id = id;
    const divInput = document.createElement("div");
    divInput.className = "col flex-grow-1";
    const input = document.createElement("input");
    input.type = "text";
    input.className = "form-control nombre-subtarea";
    input.placeholder = "Nombre de la subtarea";
    if (subTarea) { input.value = subTarea.nombre; }
    divInput.appendChild(input);
    const divCheck = document.createElement("div");
    divCheck.className = "col-auto d-flex align-items-center";
    const check = document.createElement("input");
    check.type = "checkbox";
    check.className = "custom-checkbox m-2";
    if (subTarea) {
        if (subTarea.check) {
            check.checked = true;
            input.style.textDecoration = "line-through";
        }
    }
    check.onclick = () => {
        if (check.checked) {
            input.style.textDecoration = "line-through";
        } else {
            input.style.textDecoration = "none";
        }
    }
    divCheck.appendChild(check);
    const btnDivUrl = document.createElement("div");
    btnDivUrl.className = "dropdown col-auto d-flex align-items-center";
    const btnUrl = document.createElement("button");
    btnUrl.type = "button";
    btnUrl.id = "btnMenuUrl";
    btnUrl.className = "btn btn-gris dropdown-toggle";
    btnUrl.setAttribute("data-bs-toggle", "dropdown");
    btnUrl.setAttribute("aria-haspopup", "true");
    btnUrl.setAttribute("aria-expanded", "false");
    const ulDropdownMenu = document.createElement("ul");
    ulDropdownMenu.className = "dropdown-menu custom-menu";
    ulDropdownMenu.setAttribute("aria-labelledby", "btnMenuUrl");
    const opciones = [
        {
            texto: "Crear Url",
            accion: function () { urlSubtarea(divRow) }
        },
        {
            texto: "Borrar subtarea",
            accion: function () { borrarSubtarea(id); }
        }
    ];
    opciones.forEach((opcion) => {
        const li = document.createElement("li");
        const a = document.createElement("a");
        a.className = "dropdown-item";
        a.href = "#";
        a.textContent = opcion.texto;
        a.onclick = opcion.accion;
        li.appendChild(a);
        ulDropdownMenu.appendChild(li);
    });
    btnDivUrl.appendChild(btnUrl);
    btnDivUrl.appendChild(ulDropdownMenu);
    btnDivUrl.appendChild(btnUrl);
    divRow.appendChild(divCheck);
    divRow.appendChild(divInput);
    divRow.appendChild(btnDivUrl);
    divSubtarea.appendChild(divRow);
    if (subTarea && subTarea.url) {
        urlSubtarea(divRow, subTarea.url);
    }
}

function borrarSubtarea (id) {
    console.log('borrarSubtarea ' + id);
    const divSubtarea = document.getElementById(id);
    divSubtarea.remove();
}

function urlSubtarea (e, div = null, urL = null) {
    console.log(' url Subtarea')
    let url;
    let divSubtarea
    if (!(e instanceof MouseEvent)) {
        url = div ? div : null;
        divSubtarea = e;
    } else {
        url = urL;
        divSubtarea = div;
    }
    const divInputUrl = document.createElement("div");
    divInputUrl.className = "col-12 mt-1";
    const inputUrl = document.createElement("input");
    inputUrl.type = "text";
    inputUrl.className = "form-control url-subtarea";
    inputUrl.placeholder = "Ingresa la URL";
    if (url) { inputUrl.value = url; }
    divInputUrl.appendChild(inputUrl);
    divSubtarea.appendChild(divInputUrl);
}
function buscarTarea (id) {
    const tarea = arrTareas.find(t => String(t.id) === String(id));
    return tarea;
}
function tableros (tableroid, suma) {
    console.log('Tablero')
    const tablero = document.getElementById(tableroid);
    const cant = tablero.querySelector(".nTareas");
    if (suma > 0) {
        objTableros[ tableroid ]++;
        const nTareas = tablero.querySelectorAll(".tarea");
        let contador = 0;
        nTareas.forEach(e => {
            contador++;
            const id = e.id;
            const tarea = buscarTarea(id);
            tarea.posicion = contador;
            const divTarea = document.getElementById(id);
            divTarea.querySelector('.posicion').innerHTML = contador;
        });
    } else if (suma < 0) {
        objTableros[ tableroid ]--;
    }
    cant.innerHTML = objTableros[ tableroid ];
    arrTareas.sort(function (a, b) {
        return a.posicion - b.posicion;
    });
    guardarTarea();
}
