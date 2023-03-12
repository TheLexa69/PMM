window.onload = function () {
    console.log("hola")
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