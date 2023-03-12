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

}