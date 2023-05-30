<?php
session_start();
require (dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "nav.php");
?>
<head>
    <title>Contacto</title>
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
    <div class="main container mt-5 card p-0">
        <div class="card-header"><h1>Construye tu hamburguesa</h1></div>
        <div class="card-body text-center">
            <div id="score">Hamburguesas bien hechas: <span id="burger-count">0</span></div>
            <div id="medals">Medallas conseguidas: <span id="medals-count">0</span></div>
            <div id="burger-style"></div>
            <canvas id="canvas" width="200" height="300"></canvas>
        </div>
        <div class="card-footer text-center">
            <button class="add-ingredient btn btn-success my-1" data-ingredient="Pan">Añadir Pan</button>
            <button class="add-ingredient btn btn-success my-1" data-ingredient="Carne">Añadir Carne</button>
            <button class="add-ingredient btn btn-success my-1" data-ingredient="Queso">Añadir Queso</button>
            <button class="add-ingredient btn btn-success my-1" data-ingredient="Lechuga">Añadir Lechuga</button>
            <button class="add-ingredient btn btn-success my-1" data-ingredient="Tomate">Añadir Tomate</button>
            <button class="add-ingredient btn btn-success my-1" data-ingredient="Cebolla">Añadir Cebolla</button>
            <button class="btn btn-danger my-1" id="delete-ingredient">Borrar Último Ingrediente</button>

            <div id="message"></div>
            <div id="medals-container"></div>
        </div>
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
            const medalsScore = document.getElementById("medals-count");
            const burgerScore = document.getElementById("burger-count");

            const ingredients = ["Pan", "Carne", "Queso", "Lechuga", "Tomate", "Cebolla"];
            const burger = [];
            let score = 0;

            let burgerStyleIndices = [];
            let medalsEarned = 0;

            function getRandomBurgerStyle() {
                burgerStyleIndices.length = 0;
                let numIngredients = Math.floor(Math.random() * 4) + 1; // Generar de 1 a 4 ingredientes

                burgerStyleIndices.push(0); // Agregar "Pan" al inicio

                for (let i = 0; i < numIngredients; i++) {
                    let ingredientIndex = Math.floor(Math.random() * (ingredients.length - 1)) + 1; // Excluir "Pan" en la generación aleatoria
                    burgerStyleIndices.push(ingredientIndex);
                }

                burgerStyleIndices.push(0); // Agregar "Pan" al final

                let burgerStyleText = burgerStyleIndices.map(index => ingredients[index]).join(" ");
                burgerStyle.textContent = burgerStyleText;
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
                if (JSON.stringify(burger) === JSON.stringify(burgerStyleIndices.map(index => ingredients[index]))) {
                    message.textContent = "¡Felicidades, has montado una hamburguesa!";
                    score++;
                    burgerScore.innerHTML = score;
                    if (score % 5 === 0) {
                        medalsEarned++;
                        showMedal(medalsEarned);
                        alert('¡Felicidades, conseguiste una medalla!')
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

            function showMedal(countMedals) {
                const medal = document.createElement("span");
                medal.classList.add("medal");
                medalsContainer.appendChild(medal);
                medalsScore.innerHTML = countMedals;
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


    <?php require (dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "footer.php"); ?>