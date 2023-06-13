document.querySelectorAll(".nav-link").forEach((link) => {
    link.classList.remove("active");
    if (link.href === window.location.href || link.href === window.location.href.split('?')[0]) {
        link.classList.add("active");
        link.setAttribute("aria-current", "page");
    }
});

/*============================= NURIA ==================================*/
/**
 *
 * Actualiza la cantidad de un producto en el carrito a través de una petición AJAX
 * @param {number} id_comida - El ID del producto a actualizar
 * @param {number} cantidad - La nueva cantidad del producto
 * @return {void}
 */
function updateCantidad(id_comida, cantidad) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../cart/actualizar_carrito.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = () => {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // Actualizar la página para reflejar los cambios
            window.location.reload();
        }
    };
    xhr.send('id_comida=' + id_comida + '&cantidad=' + cantidad);
}
function showCarritoFlotante() {
    document.getElementById('carritoFlotante').style.top = "70px";
}
function closeCarritoFlotante() {
    document.getElementById('carritoFlotante').style.top = "150vh";
}
$(document).ready(function () {
    $('[data-toggle="popover"]').popover();
});

document.addEventListener("DOMContentLoaded", function (event) {
    // Obtener el botón de realizar compra
    const miEnlace = document.getElementById("log");
    // Añadir un evento de clic al botón
    if (miEnlace !== null) {
        miEnlace.addEventListener("click", function () {
            // Comprobar si el usuario ha iniciado sesión
            if (!usuarioIniciado()) {
                // Mostrar un alerta y redirigir a la página de inicio de sesión
                window.location.href = "../login/indexLogin.php";

                confirm("Tienes que iniciar sesión");
                window.location.href = "../login/indexLogin.php?redirigido=si";

            }
        });
    }


    /**
     *
     * Verifica si el usuario ha iniciado sesión.
     *
     * @return {boolean} true si el usuario no ha iniciado sesión, false si ha iniciado sesión.
     */
    function usuarioIniciado() {
        // Obtener todas las cookies del sitio
        var cookies = document.cookie.split(";");

        // Buscar la cookie de sesión específica
        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i].trim();
            if (cookie.indexOf("carrito=") == 0) {
                // La cookie de sesión específica existe
                return false;
            }
        }

        // Si no, el usuario no ha iniciado sesión
        return true;
    }
});
/*====================================================*/


console.log('JS funcionando');

const input = document.querySelector("#phone");
const errorMsg = document.querySelector("#error-msg");
const validMsg = document.querySelector("#valid-msg");

// here, the index maps to the error code returned from getValidationError - see readme
const errorMap = ["Número incorrecto", "Código incorrecto", "Muy corto", "Muy largo", "Número incorrecto"];

// initialise plugin
if (input) {
    const iti = window.intlTelInput(input, {
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
        initialCountry: "ES",
        separateDialCode: true,
        geoIpLookup: function (callback) {
            fetch("https://ipapi.co/json")
                    .then(function (res) {
                        return res.json();
                    })
                    .then(function (data) {
                        callback(data.country_code);
                    })
                    .catch(function () {
                        callback("us");
                    });
        },
        preferredCountries: ["es", "pt", "us", "gb", ]
    });
    console.log(document.querySelector(".iti__selected-dial-code").innerHTML);

    const reset = () => {
        input.classList.remove("error");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("hide");
        validMsg.classList.add("hide");
    };

// on blur: validate
    input.addEventListener('blur', () => {
        reset();
        if (input.value.trim()) {
            if (iti.isValidNumber()) {
                validMsg.classList.remove("hide");
            } else {
                input.classList.add("error");
                const errorCode = iti.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode];
                errorMsg.classList.remove("hide");
            }
        }
    });

// on keyup / change flag: reset
    input.addEventListener('change', reset);
    input.addEventListener('keyup', reset);
}

/*window.intlTelInput(telInput2, {
 utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
 initialCountry: "ES",
 geoIpLookup: function (callback) {
 fetch("https://ipapi.co/json")
 .then(function (res) {
 return res.json();
 })
 .then(function (data) {
 callback(data.country_code);
 })
 .catch(function () {
 callback("us");
 });
 },
 preferredCountries: ["es", "pt","us", "gb",],
 separateDialCode: true,
 autoInsertDialCode: true
 });*/

/*==================================================*/

function setCode() {
    document.getElementById('codPais').value = document.querySelector(".iti__selected-dial-code").innerHTML;
}

function getCookie(name) {
    const cookieValue = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
    return cookieValue ? cookieValue.pop() : '';
}

if (getCookie('cookie') === 'true') {
    if (document.getElementById('cookie') !== null) {
        document.getElementById('cookie').style.top = "150vh";
    }
} else {
    if (document.getElementById('cookie') !== null) {
        //document.getElementById('cookie').style.top = "60%";
    }
}

function ocultarBarraCookies() {
    const cookieBox = document.getElementById("cookie");
    cookieBox.style.top = "150vh";
    document.cookie = "cookie=true; expires=" + new Date(Date.now() + 8 * 60 * 60 * 1000).toUTCString() + "; path=/";

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
/**
 * Función que muestra o oculta la barra de navegación.
 * @param {none}
 * @return {none}
 */
function showHideNav() {
    const nav = document.getElementById('navbarNavAltMarkup');
    nav.style.top = nav.style.top === '0px' ? '-150vh' : '0px';
}
/**
 * Función que cambia el tema de la página.
 * @param {none}
 * @return {none}
 */
function changeTheme() {
    var body = document.querySelector('body');
    var currentBackground = getComputedStyle(body).getPropertyValue('background-image');
    var newBackground;

    if (currentBackground === 'url("https://dl.dropboxusercontent.com/s/e2z1cqj7jc7q7j6/leonardo3.jpg")') {
        newBackground = 'url("https://dl.dropboxusercontent.com/s/jr28g3sfwre6dkf/leonardo2.jpg")';
    } else {
        newBackground = 'url("https://dl.dropboxusercontent.com/s/e2z1cqj7jc7q7j6/leonardo3.jpg")';
    }

    body.style.backgroundImage = newBackground;
    body.style.backgroundSize = 'cover';
    body.style.backgroundPosition = 'center center';
    body.style.backgroundAttachment = 'fixed';
}