<?php ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Construye tu hamburguesa</title>
        <style>
            canvas {
                border: 1px solid black;
            }
            .medal {
                display: inline-block;
                width: 20px;
                height: 20px;
                background-color: gold;
                margin-right: 5px;
            }
        </style>
    </head>
    <body>
        <div class="main container mt-5">
            <h1>Construye tu hamburguesa</h1>
            <div>
                <div id="burger-style"></div>
                <canvas id="canvas" width="200" height="300"></canvas>
            </div>
            <div>
                <button class="add-ingredient" data-ingredient="Pan">Añadir Pan</button>
                <button class="add-ingredient" data-ingredient="Carne">Añadir Carne</button>
                <button class="add-ingredient" data-ingredient="Queso">Añadir Queso</button>
                <button id="delete-ingredient">Borrar Último Ingrediente</button>
            </div>
            <div id="message"></div>
            <div id="medals-container"></div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const canvas = document.getElementById("canvas");
                const context = canvas.getContext("2d");

                const burgerStyle = document.getElementById("burger-style");
                const message = document.getElementById("message");
                const deleteIngredientButton = document.getElementById("delete-ingredient");
                const addIngredientButtons = document.getElementsByClassName("add-ingredient");
                const medalsContainer = document.getElementById("medals-container");

                const ingredients = ["Pan", "Carne", "Queso"];
                const burger = [];
                let score = 0;

                let burgerStyleIndex;
                let medalsEarned = 0;

                function getRandomBurgerStyle() {
                    burgerStyleIndex = Math.floor(Math.random() * ingredients.length);
                    burgerStyle.textContent = ingredients[burgerStyleIndex];
                }

                function clearCanvas() {
                    context.clearRect(0, 0, canvas.width, canvas.height);
                }

                function drawBurger() {
                    clearCanvas();

                    let yPos = 50;
                    for (let i = 0; i < burger.length; i++) {
                        context.fillText(burger[i], 80, yPos);
                        yPos += 30;
                    }
                }

                function checkBurger() {
                    if (JSON.stringify(burger) === JSON.stringify([ingredients[burgerStyleIndex]])) {
                        message.textContent = "¡Felicidades, has montado una hamburguesa!";
                        score++;
                        if (score % 5 === 0) {
                            medalsEarned++;
                            showMedal();
                        }
                        resetGame();
                    }
                }

                function resetGame() {
                    burger.length = 0;
                    clearCanvas();
                    message.textContent = "";
                    getRandomBurgerStyle();
                }

                function showMedal() {
                    const medal = document.createElement("span");
                    medal.classList.add("medal");
                    medalsContainer.appendChild(medal);
                }

                getRandomBurgerStyle();

                for (let i = 0; i < addIngredientButtons.length; i++) {
                    addIngredientButtons[i].addEventListener("click", function () {
                        const ingredient = this.dataset.ingredient;
                        burger.push(ingredient);
                        drawBurger();
                        checkBurger();
                    });
                }

                deleteIngredientButton.addEventListener("click", function () {
                    burger.pop();
                    drawBurger();
                });
            });


        </script>
    </body>
</html>