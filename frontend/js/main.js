window.onload = function () {
    document.querySelectorAll(".nav-link").forEach((link) => {
        link.classList.remove("active");
        if (link.href === window.location.href || link.href === window.location.href.split('?')[0]) {
            link.classList.add("active");
            link.setAttribute("aria-current", "page");
        }
    });
    
    var mensajeDiv2 = document.getElementById('cookie');
    mensajeDiv2.style.top = '-20%';

    console.log('asdasdasd');
    function checkCookie() {
        const cookieBox = document.querySelector(".cookie"), acceptBtn = cookieBox.querySelector("button");
        if (document.cookie) { // Si la cookie está configurada
            cookieBox.classList.add("d-none"); // Escondemos la caja de las cookies
        } else { // Si la cookie no se puede configurar, se muestra el siguiente error
            alert("¡No se puede configurar la cookie! Por favor, desbloquea este sitio desde la configuración de cookies de tu navegador.");
            cookieBox.classList.remove("d-none");
        }
    }


    /**
     Obtiene los elementos del DOM que tienen el nombre "inlineRadioOptions" y asigna un manejador de eventos onclick
     que alterna entre dos estados de visualización. Si está visible, desactiva ambos botones de radio, y si está oculto,
     activa el primer botón de radio.
     @param radio Los elementos del DOM que tienen el nombre "inlineRadioOptions".
     @param mostrar El estado de visualización actual de los elementos.
     @return void
     */
    radio = document.getElementsByName('inlineRadioOptions');
    radio.onclick = () => {
        mostrar = !mostrar;
        if (mostrar) {
            radio[0].checked = false;
            radio[1].checked = false;
        } else {
            radio.checked = true;
        }
    }

// Obtener todos los elementos <img> del documento
    const imagenes = document.getElementsByClassName('img-select');
// Crear un array vacío para almacenar los nombres de las imágenes seleccionadas
    const seleccionadas = [];

// Recorrer todas las imágenes y agregar un listener de click a cada una
    for (let i = 0; i < imagenes.length; i++) {
        imagenes[i].addEventListener("click", function () {
            // Obtener el valor del atributo "alt" de la imagen
            const nombre = this.getAttribute("alt");
            // Si el nombre ya está en el array, eliminarlo
            if (seleccionadas.includes(nombre)) {
                seleccionadas.splice(seleccionadas.indexOf(nombre), 1);
                imagenes[i].style.border = 'none';
            }
            // Si no está en el array, agregarlo
            else {
                seleccionadas.push(nombre);
                imagenes[i].style.border = '1px solid red';
                imagenes[i].setAttribute('checked', '');
            }

            // Actualizar el contenido del contenedor de alérgenos
            /*const contenedor = document.getElementById("contenedorAlergenos");
             contenedor.innerHTML = seleccionadas.join(", ");*/
        });
    }

}