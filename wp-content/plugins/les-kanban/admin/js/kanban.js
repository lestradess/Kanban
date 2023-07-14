"use strict";
//:VARIABLES**************************
const nombrePagina = document.title;
let arrTareas = [];
let arrSubtareas = [];
let objTableros = {
    "pendientes": 0,
    "progreso": 0,
    "pruebas": 0,
    "completados": 0
};
const Sortable = window.Sortable;
var isScrolling = false;
var startX;
var scrollLeft;

function startScroll (event) {
    if (event.target.id === 'nombre') {
        isScrolling = false;
    } else {
        isScrolling = true;
        startX = event.pageX - event.target.offsetLeft;
        scrollLeft = event.target.scrollLeft;
    }
}

function scrollContent (event) {
    if (!isScrolling) return;
    var x = event.pageX - event.target.offsetLeft;
    var walk = (x - startX) * 1; // Ajusta la velocidad de desplazamiento según tus necesidades
    event.target.scrollLeft = scrollLeft - walk;
}

function stopScroll (event) {
    isScrolling = false;
}

//: Genera el codigo de inicio y el de coger soltar y arrastrar******
document.addEventListener('DOMContentLoaded', function () {
    // comprobando pagina correcta
    const pagina = document.querySelector(".container-kanban");
    if (pagina === null) {
        return;
    }

    inicializarTareas();
});
/**
     * Crea los divs definidos en el arrTareas.
     */
function inicializarTareas () {
    //console.log('inicializando tareas');
    colocarCpt();
    crearColumnas();
    //?Si LocalStorage está definido
    if (typeof localStorage !== 'undefined') {

        const jsonArray = localStorage.getItem(nombrePagina);
        try {
            if (jsonArray) {
                arrTareas = JSON.parse(jsonArray);
                //console.log('LocalStorage definido con ' + arrTareas.length + ' elementos');
            }
        } catch (error) {
            //console.log('Error al parsear los datos de localStorage');
        }
    }
    //Si no hay tareas en localStorage se crean unas de prueba
    if (arrTareas.length === 0) {
        //console.log('nuevo kanban definiendo tareas de prueba');
        for (let i = 0; i < 8; i++) {
            const tarea = {
                id: '168641623319' + i,
                nombre: 'Prueba' + (i + 1),
                descripcion: 'Para Eliminar',
                responsable: 'Lestrades',
                tablero: [ 'pendientes', 'progreso', 'pruebas', 'completados', 'pendientes', 'progreso', 'pruebas', 'completados' ][ i ]
            };
            guardarTarea(tarea);
        }
    }

    arrTareas.forEach(function (tarea) {
        crearDivTarea(tarea);
    });
}
function colocarCpt () {
    document.querySelector(".wp-heading-inline").remove();
    document.querySelector("#minor-publishing").remove();
    const divGeneral = document.getElementById("post-body-content");
    divGeneral.className = "p-0 m-0";
    const titulo = document.getElementById("titlediv");
    titulo.classList.add("col");
    titulo.classList.add("mb-3");
    const metabox = document.getElementById("postbox-container-2");
    const divKanban = document.querySelector(".container-kanban");
    const divKanbanTitle = document.querySelector(".kanban-title");
    metabox.remove();
    const containerPublicar = document.getElementById("postbox-container-1");
    divKanbanTitle.appendChild(titulo);
    divGeneral.appendChild(containerPublicar);
    divGeneral.appendChild(divKanban);
}
function crearColumnas () {
    const columnas = [
        document.getElementById("pendientes"),
        document.getElementById("progreso"),
        document.getElementById("pruebas"),
        document.getElementById("completados")
    ];

    columnas.forEach(function (columna) {
        new Sortable(columna, {
            group: 'shared',
            animation: 150,
            onStart: function (event) {
                const ui = event.item;
                const tablero = ui.parentElement.id;
                //console.log("Cojo del tablero: " + tablero);
                tableros(tablero, -1);
            },
            onEnd: function (event) {
                const ui = event.item;
                ui.classList.remove("task-dragging");
                const id = ui.id;
                const tarea = buscarTarea(id);
                if (tarea) {
                    const tablero = ui.parentElement.id;
                    //console.log("Pongo la tarea " + tarea.nombre + " en el tablero " + tablero);
                    tarea.tablero = tablero;
                    tableros(tablero, 1);
                }
            }
        });
    });
}

/**
 * Abre el modal, limpia los campos y añade los campos fecha, id y tableros.
 * @param {Event} event - evento click.
 */
function nuevaTarea (e) {
    //console.log('Nueva tarea');
    const tablero = e.target.parentNode.parentNode.previousElementSibling.id;
    e.preventDefault();
    const id = crearId().toString();
    const tarea = {
        id: id,
        nombre: '',
        descripcion: '',
        responsable: '',
        tablero: tablero,
    };
    arrTareas.push(tarea);
    rellenarCampos(tarea);
}
/**
 * Crea el div ordenable que muestra la tarea en el tablero y lo rellena 
 * con la tarea que tenga el id que recibe.
 * @param {String} id - Id de la tarea.
 */
function crearDivTarea (tarea) {
    let suma;
    const divRemplazar = document.getElementById(tarea.id);
    const tableroId = tarea.tablero.toLowerCase();
    const tablero = document.getElementById(tableroId);
    const divTarea = document.createElement('div');
    divTarea.className = 'tarea p-0 row task position-relative list-group-item';
    divTarea.setAttribute('id', tarea.id);
    divTarea.setAttribute('draggable', true);
    divTarea.onclick = function (e) {
        e.preventDefault();
        rellenarCampos(tarea);
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
                const svgTrue = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                const pathTrue = document.createElementNS("http://www.w3.org/2000/svg", "path");
                svgTrue.setAttribute("xmlns", "http://www.w3.org/2000/svg");
                svgTrue.setAttribute("viewBox", "0 0 16 16");
                svgTrue.setAttribute("width", "24");
                svgTrue.setAttribute("height", "20");
                svgTrue.setAttribute("class", "bi bi-check2-circle me-1");
                pathTrue.setAttribute("fill", "#50af3c");
                pathTrue.setAttribute("d", "M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0");
                svgTrue.appendChild(pathTrue);

                const svgFalse = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                const pathFalse = document.createElementNS("http://www.w3.org/2000/svg", "path");
                svgFalse.setAttribute("xmlns", "http://www.w3.org/2000/svg");
                svgFalse.setAttribute("width", "20");
                svgFalse.setAttribute("height", "20");
                svgFalse.setAttribute("viewBox", "0 0 16 16");
                svgFalse.setAttribute("class", "bi bi-circle me-2");
                pathFalse.setAttribute("fill", "#ca4552");
                pathFalse.setAttribute("d", "M11 2a3 3 0 0 1 3 3v6a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3V5a3 3 0 0 1 3-3h6zM5 1a4 4 0 0 0-4 4v6a4 4 0 0 0 4 4h6a4 4 0 0 0 4-4V5a4 4 0 0 0-4-4H5z");
                svgFalse.appendChild(pathFalse);
                if (subtarea.check) {
                    checkSpan.appendChild(svgTrue);
                    subtareaText.classList.add('text-decoration-line-through');
                } else {
                    checkSpan.appendChild(svgFalse);
                }
                subtareaP.appendChild(checkSpan);

                checkSpan.onclick = function (e) {
                    e.stopPropagation();
                    if (subtarea.check) {
                        console.log('uncheck')
                        checkSpan.removeChild(svgTrue);
                        checkSpan.appendChild(svgFalse);
                        subtareaText.classList.remove("text-decoration-line-through");
                        subtarea.check = false;
                        console.log(tarea)

                    } else {
                        console.log('check')
                        checkSpan.removeChild(svgFalse);
                        checkSpan.appendChild(svgTrue);
                        subtareaText.classList.add("text-decoration-line-through");
                        subtarea.check = true;
                        console.log(tarea)
                    }
                }



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
    //para obtener la posicion y saber cuantos elementos tiene la columna.
    if (divRemplazar) {
        tablero.insertBefore(divTarea, divRemplazar);
        divRemplazar.remove();
        suma = 0;
    } else {
        suma = 1;
        tablero.appendChild(divTarea);
    };

    tableros(tableroId, suma);
}


/**
 * Guarda la tarea.
 * 
 * Crea el div ordenable de la tarea.
 * 
 * Cierra el modal.
 * 
 * @param {Object} tarea - Una tarea.
 */
function editarTarea (tarea) {
    //console.log('Editar Tarea');
    guardarTarea(tarea);
    crearDivTarea(tarea);
}
/**
 * Recoge todos los datos del modal. 
 * 
 * Los manda a editarTarea.
 */
function recogerDatos () {
    //console.log('Recoger datos');
    let tarea = {};
    tarea.fecha = document.getElementById("tarea-fecha").textContent;
    tarea.tablero = document.getElementById("tarea-tablero").textContent;
    tarea.id = document.getElementById("tarea-id").textContent;
    tarea.nombre = document.getElementById("tarea-nombre").value;
    const tareaDiv = document.getElementById(tarea.id);
    if (tareaDiv) {
        tarea.posicion = tareaDiv.querySelector(".posicion").textContent;
        console.log('posicion de la tarea: ' + tarea.posicion);
    }

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
    editarTarea(tarea);
}



/**
 * Rellena los campos del modal con la tarea que tenga el id recibido.
 * 
 * Abre el modal
 * 
 * Limpia los campos
 * 
 * Envia las subtareas a crearEditarSubtarea.
 * @param {String} id - Id de la tarea
 */
function rellenarCampos (tarea) {
    //console.log('Rellenar campos');
    abrirModal();
    limpiarCampos();
    const divTarea = document.getElementById(tarea.id);
    const btnEliminar = document.getElementById("btn-eliminar");
    if (divTarea) {
        btnEliminar.classList.remove("d-none");
    } else {
        btnEliminar.classList.add("d-none");
    }
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
/**
 * Elimina la tarea que busca el el modal que está abierto.
 * 
 * Guarda la tarea.
 * @param {Event} e -Evento click.
 */
function eliminarTarea (e) {
    //console.log('Elininar tarea');
    e.preventDefault();
    const tareaId = document.getElementById("tarea-id").textContent;
    const nombreTarea = document.getElementById("tarea-nombre").value;
    const respuesta = confirm(`Esta acción borrará la tarea "${ nombreTarea }". ¿Deseas continuar?`);
    if (respuesta) {
        // Código a ejecutar si el usuario hace clic en "Aceptar"
        //console.log("El usuario ha hecho clic en Aceptar.");
        //console.log('desde eliminar tarea');
        const tarea = buscarTarea(tareaId);
        if (tarea !== -1) {
            //borrada del array arrTareas
            const tareaBorrada = arrTareas.splice(tarea, 1);
            //borrar de localStorage
            guardarTarea();
            //borrar el div
            const borrarTareaDiv = document.getElementById(tareaId);
            if (borrarTareaDiv) {
                borrarTareaDiv.remove();
            }
            //console.log('Tarea borrada:', tareaBorrada[ 0 ]);
        }
    }
}
/**
 * Valida que la tarea  tenga un nonmbre.
 * @param {Event} e-Evento Click 
 */
function validarTarea (e) {
    const nombre = document.getElementById("tarea-nombre").value;
    //console.log('validar Tarea');
    if (nombre === '') {
        alert('Debes asignar un nombre a la tarea');
    } else {
        recogerDatos();
    }
}
/**
 * Crea un id.
 * @returns Los milisegundos de este momento.
 */
function crearId () {
    return new Date().getTime();
}
/**
 * Formatea un numero para que quede como una fecha.
 * @param {number} time -Milisegundos.  
 * @returns String Fecha.
 */
function formatearFecha (time) {
    const fecha = new Date(parseInt(time));
    const dia = fecha.getDate();
    const mes = fecha.getMonth() + 1; // Los meses empiezan en 0, por eso se suma 1
    const año = fecha.getFullYear();
    const hora = fecha.getHours();
    const minuto = fecha.getMinutes();
    const segundo = fecha.getSeconds();
    return `${ dia }/${ mes }/${ año } ${ hora }:${ minuto }:${ segundo }`;
}

/**
 * Abre el modal para añadir, borrar o editar una tarea.
 */
function abrirModal () {
    $('#modalTarea').modal('show');
}
/**
 * Cierra el modal.
 */
function cerrarModal () {

    if ($("#modalTarea").is(":visible")) {
        $("#modalTarea").modal("hide");
    }
}
/**
 * Limpia los campos para dejarlos vacios para su proximo uso.
 */
function limpiarCampos () {
    //console.log('Limpiar campos');
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

/**
 * Crea o edita las subtareas. 
 * @param {subTarea} subTarea o evento click
 */
function crearEditarSubtarea (subTarea) {
    console.log("Crear Editar subtarea");
    console.log(subTarea);

    let id;
    if (subTarea.id) {
        console.log('es objeto');
        id = subTarea.id
    } else {
        console.log('no es objeto');
        id = 'sub' + crearId().toString();
    }
    console.log(id);


    const divSubtareas = document.querySelector(".subtareas");
    const divSubtarea = document.createElement("div");
    divSubtarea.className = "row mb-2 d-flex align-items-center subtarea";
    divSubtarea.id = id;
    const divInput = document.createElement("div");
    divInput.className = "col flex-grow-1";
    const input = document.createElement("input");
    input.type = "text";
    input.className = "form-control nombre-subtarea";
    input.placeholder = "Nombre de la subtarea";
    if (typeof subTarea.nombre === "string") {
        console.log("no es instancia");
        input.value = subTarea.nombre;
    }
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
            accion: function () { urlSubtarea(divSubtarea) }
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
    divSubtarea.appendChild(divCheck);
    divSubtarea.appendChild(divInput);
    divSubtarea.appendChild(btnDivUrl);
    divSubtareas.appendChild(divSubtarea);
    if (subTarea && subTarea.url) {
        urlSubtarea(divSubtarea, subTarea.url);
    }
}
/**
 * Borra una subtarea.
 * @param {String} id -Id de la tarea. 
 */
function borrarSubtarea (id) {
    //console.log('borrarSubtarea ' + id);
    const divSubtarea = document.getElementById(id);
    divSubtarea.remove();
}
/**
 * Crea el input de la url de la subtarea.
 * @param {Event} e -Evento click 
 * @param {div} div -Div de la subtarea
 * @param {String} urL -Url de la subtarea
 */
function urlSubtarea (e, div = null, urL = null) {
    //console.log(' url Subtarea')
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
/**
 * Busca la tarea en arrTareas y la retorna
 * @param {String} id 
 * @returns La tarea buscada.
 */
function buscarTarea (id) {
    const tarea = arrTareas.find(t => String(t.id) === String(id));
    return tarea;
}
/**
 * Añade a la tarea la posicion en la que se encuentra actualmente.
 * 
 * Guarda la tarea.
 * @param {String} tableroid 
 * @param {number} suma 1suma, -1 resta y 0 no hace nada.
 */
function tableros (tableroid, suma) {

    const tablero = document.getElementById(tableroid);
    const cant = tablero.previousElementSibling.querySelector(".nTareas");
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
    //console.log('Tablero ' + tableroid + ' en posicion ' + suma);
    guardarTarea();
}
/**
 * Guarda la tarea en localStorage, en el arrTareas y en la BD.
 * 
 * @param {Object} tarea 
 */
function guardarTarea (tarea = false) {

    if (tarea) {
        const indice = arrTareas.findIndex(id => id.id === tarea.id);
        if (indice !== -1) {
            arrTareas.splice(indice, 1, tarea);
        } else {
            arrTareas.push(tarea);
        }

        //console.log('Guarda tarea ' + tarea.nombre);
        /* var subTareas = JSON.stringify(tarea.subTareas);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', lesdata.ajaxurl, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status >= 200 && xhr.status < 400) {
                    var res = JSON.parse(xhr.responseText);
                    //console.log('Datos insertados correctamente');
                } else {
                    console.error('Ocurrió un error en la solicitud:', xhr.status);
                }
            }
        };
        xhr.onerror = function () {
            console.error('Ocurrió un error en la solicitud');
        };
        var data = 'action=crud_table_kanban' +
            '&nonce=' + encodeURIComponent(lesdata.seguridad) +
            '&id=' + encodeURIComponent(tarea.id) +
            '&nombre=' + encodeURIComponent(tarea.nombre) +
            '&fecha=' + encodeURIComponent(tarea.fecha) +
            '&descripcion=' + encodeURIComponent(tarea.descripcion) +
            '&responsable=' + encodeURIComponent(tarea.responsable) +
            '&tablero=' + encodeURIComponent(tarea.tablero) +
            '&posicion=' + encodeURIComponent(tarea.posicion) +
            '&subtareas=' + encodeURIComponent(subTareas) +
            '&tipo=add';
        xhr.send(data); */
    } else {
        //console.log('Guarda tarea sin meter en el arrTareas');
    }
    //guardando en local storage
    const jsonTareas = JSON.stringify(arrTareas);
    localStorage.setItem(nombrePagina, jsonTareas);
    cerrarModal();
}



