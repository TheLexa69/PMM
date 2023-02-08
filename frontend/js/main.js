window.onload = function () {
    console.log("hola")
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

    function resetRadios() {
        var radios = document.getElementsByName('inlineRadioOptions');
        for (var i = 0; i < radios.length; i++) {
            radios[i].checked = false;
        }
    }

}