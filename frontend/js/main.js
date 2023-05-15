document.querySelectorAll(".nav-link").forEach((link) => {
    link.classList.remove("active");
    if (link.href === window.location.href || link.href === window.location.href.split('?')[0]) {
        link.classList.add("active");
        link.setAttribute("aria-current", "page");
    }
});

//var mensajeDiv2 = document.getElementById('cookie');
//mensajeDiv2.style.top = '-20%';

console.log('asdasdasd');
function getCookie(name) {
    const cookieValue = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
    return cookieValue ? cookieValue.pop() : '';
}

if (getCookie('cookie') === 'true') {
    if (document.getElementById('cookie') !== null) {
        document.getElementById('cookie').style.top = "-150vh";
    }
} else {
    document.getElementById('cookie').style.top = "60%";
}

function checkCookie() {
    const cookieBox = document.getElementById("cookie");
    cookieBox.style.top = "-150vh";
    document.cookie = "cookie=true; expires=" + new Date(Date.now() + 8 * 60 * 60 * 1000).toUTCString() + "; path=/";

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


function showHideNav() {
    const nav = document.getElementById('navbarNavAltMarkup');
    nav.style.top = nav.style.top == '0px' ? '-60vh' : '0px';
}

function changeTheme() {
    console.log(document.body.style.backgroundImage);
    if (document.body.style.background == "url(\"https://dl.dropboxusercontent.com/s/e2z1cqj7jc7q7j6/leonardo3.jpg\") no-repeat") {
        document.body.style.background = "url(\"https://dl.dropboxusercontent.com/s/jr28g3sfwre6dkf/leonardo2.jpg\") no-repeat";
        document.body.style.backgroundSize = "cover";
        document.body.style.backgroundPosition = "center center";
        document.body.style.backgAttachment = 'fixed';

    } else {
        document.body.style.background = "url(\"https://dl.dropboxusercontent.com/s/e2z1cqj7jc7q7j6/leonardo3.jpg\") no-repeat";

    }
}