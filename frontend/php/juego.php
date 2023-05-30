<?php ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Construye tu hamburguesa</title>
        <style>
            canvas {
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        <h1>Minijuego de Construir una Hamburguesa</h1>
        <canvas id="canvas" width="400" height="400"></canvas>
        <div>
            <h3>Estilo de la Hamburguesa:</h3>
            <div id="burger-style">
                <!-- Aquí se mostrará el estilo de la hamburguesa generada -->
            </div>
        </div>
        <div>
            <h3>Ingredientes:</h3>
            <button class="add-ingredient" data-ingredient="Pan">Añadir Pan</button>
            <button class="add-ingredient" data-ingredient="Carne">Añadir Carne</button>
            <button class="add-ingredient" data-ingredient="Queso">Añadir Queso</button>
            <button id="delete-ingredient">Borrar Último Ingrediente</button>
        </div>
        <div id="message"></div>
        <script>
            window.onload = function () {
                // Obtener elementos del DOM
                var canvas = document.getElementById('canvas');
                var context = canvas.getContext('2d');
                var burgerStyleDiv = document.getElementById('burger-style');
                var addIngredientButtons = document.getElementsByClassName('add-ingredient');
                var deleteIngredientButton = document.getElementById('delete-ingredient');
                var messageDiv = document.getElementById('message');

                var burgerStyle = ['Pan', 'Carne', 'Queso']; // Estilo de la hamburguesa
                var userBurger = []; // Ingredientes seleccionados por el usuario

                // Función para dibujar la hamburguesa
                function drawBurger() {
                    context.clearRect(0, 0, canvas.width, canvas.height);

                    // Dibujar ingredientes
                    var yPos = 50;
                    for (var i = 0; i < userBurger.length; i++) {
                        context.fillText(userBurger[i], 20, yPos);
                        yPos += 30;
                    }
                }

                // Función para actualizar el estilo de la hamburguesa mostrado en pantalla
                function updateBurgerStyle() {
                    burgerStyleDiv.textContent = burgerStyle.join(' - ');
                }

                // Función para añadir un ingrediente a la hamburguesa
                function addIngredient(ingredient) {
                    userBurger.push(ingredient);
                    drawBurger();
                    checkBurger();
                }

                // Función para borrar el último ingrediente añadido
                function deleteLastIngredient() {
                    if (userBurger.length > 0) {
                        userBurger.pop();
                        drawBurger();
                    }
                }

                // Función para comprobar si la hamburguesa está montada correctamente
                function checkBurger() {
                    if (userBurger.length === burgerStyle.length) {
                        var isCorrect = true;
                        for (var i = 0; i < userBurger.length; i++) {
                            if (userBurger[i] !== burgerStyle[i]) {
                                isCorrect = false;
                                break;
                            }
                        }
                        if (isCorrect) {
                            messageDiv.textContent = "¡Felicidades! Has montado una hamburguesa";
                        } else {
                            messageDiv.textContent = "La hamburguesa no está montada correctamente";
                        }
                    } else {
                        messageDiv.textContent = "";
                    }
                }

                // Asignar eventos a los botones de añadir ingredientes
                for (var i = 0; i < addIngredientButtons.length; i++) {
                    addIngredientButtons[i].addEventListener('click', function () {
                        var ingredient = this.dataset.ingredient;
                        addIngredient(ingredient);
                    });
                }

                // Asignar evento al botón de borrar último ingrediente
                deleteIngredientButton.addEventListener('click', function () {
                    deleteLastIngredient();
                    checkBurger();
                });

                // Dibujar la hamburguesa inicial y actualizar el estilo mostrado en pantalla
                drawBurger();
                updateBurgerStyle();
            };

        </script>
    </body>
</html>