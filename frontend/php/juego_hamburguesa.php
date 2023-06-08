<div id="mensaje" class="rounded" style="z-index: 4; position: absolute; transition: top 0.5s; top: -150%; right: 0; background-color: #BDECB6; color: black; padding: 10px;">
    ¡Felicidades, conseguiste una medalla!
</div>
<div class="card-header d-flex justify-content-between align-items-center">
    <h1>Construye tu hamburguesa</h1>

    <a onclick="document.getElementById('hamburguesa').classList.toggle('d-none')" class="btn btn-danger"> 
        <i class="fa-solid fa-x fa-2xl"></i>
    </a>
</div>
<div class="accordion" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                &nbsp;&nbsp;&nbsp;¿ Cómo se juega ?
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
             data-bs-parent="#accordionExample">
            <div class="accordion-body">
                &nbsp;&nbsp;&nbsp;El juego se inicia automáticamente cuando entras, para lograr hacer una hamburguesa tienes que seguir el orden de los ingredientes, de <b>izquierda a derecha</b>.
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                &nbsp;&nbsp;&nbsp;¿ Cómo gano puntos ?
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                &nbsp;&nbsp;&nbsp;Ganarás<strong>1 punto</strong> cada vez que una hamburguesa esté bien hecha.
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                &nbsp;&nbsp;&nbsp;¿ Cómo gano medallas ?
            </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                &nbsp;&nbsp;&nbsp;Ganarás <strong>1 medalla</strong> cada vez que <b>5 hamburguesas</b> estén bien hechas.
            </div>
        </div>
    </div>
</div>
<div class="card-body text-center">
    <div id="score">Hamburguesas bien hechas: <span id="burger-count">0</span></div>
    <div id="medals">Medallas conseguidas: <span id="medals-count">0</span></div>
    <div class="mt-2">
        <span class="fw-bold">Ingredientes:</span>
        <div id="burger-style"></div>
    </div>
    <canvas class="rounded shadow-lg my-2" id="canvas" width="200" height="300"></canvas>
    <div class="fw-bold pb-1" id="message"></div>
    <div id="medals-container"></div>
</div>
<div class="card-footer text-center">
    <button class="add-ingredient btn btn-success my-1" data-ingredient="Pan">Añadir Pan</button>
    <button class="add-ingredient btn btn-success my-1" data-ingredient="Carne">Añadir Carne</button>
    <button class="add-ingredient btn btn-success my-1" data-ingredient="Queso">Añadir Queso</button>
    <button class="add-ingredient btn btn-success my-1" data-ingredient="Lechuga">Añadir Lechuga</button>
    <button class="add-ingredient btn btn-success my-1" data-ingredient="Tomate">Añadir Tomate</button>
    <button class="add-ingredient btn btn-success my-1" data-ingredient="Cebolla">Añadir Cebolla</button>
    <button class="btn btn-danger my-1" id="delete-ingredient">Borrar Último Ingrediente</button>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const canvas = document.getElementById("canvas");
        const ctx = canvas.getContext("2d");

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

            let burgerStyleText = burgerStyleIndices.map(index => ingredients[index]).join(", ");
            burgerStyle.textContent = burgerStyleText;
        }

        function clearCanvas() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }

        function drawBurger() {
            clearCanvas();

            let yPos = 40;
            for (let i = 0; i < burger.length; i++) {
                //context.fillText(burger[i], 80, yPos);

                yPos += drawIngredients(burger[i], yPos);
                if (i === burger.length - 1) {
                    drawPlate(yPos);
                }
            }
        }

        function drawPlate(yPos) {
            ctx.strokeStyle = "rgb(0, 0, 0)";
            ctx.fillStyle = "rgba(191, 191, 193)";
            ctx.beginPath();
            ctx.roundRect(canvas.width / 5, yPos, 125, 5, 10);
            ctx.stroke();
            ctx.fill();
        }

        function drawIngredients(ingredient, yPos) {
            switch (ingredient) {
                case "Pan":
                    ctx.strokeStyle = "rgb(0, 0, 0)";
                    ctx.fillStyle = "rgba(238,192,123)";
                    ctx.beginPath();
                    ctx.roundRect(canvas.width / 4, yPos, 100, 20, 10);
                    ctx.stroke();
                    ctx.fill();
                    return 20;
                    break;
                case "Carne":
                    ctx.strokeStyle = "rgb(0, 0, 0)";
                    ctx.fillStyle = "rgba(105,61,61)";
                    ctx.beginPath();
                    ctx.roundRect(canvas.width / 4, yPos, 100, 20, 10);
                    ctx.stroke();
                    ctx.fill();
                    return 20;
                    break;
                case "Queso":
                    ctx.strokeStyle = "rgb(0, 0, 0)";
                    ctx.fillStyle = "rgba(255, 255, 0)";
                    ctx.beginPath();
                    ctx.roundRect(canvas.width / 4, yPos, 100, 5, 10);
                    ctx.stroke();
                    ctx.fill();
                    return 5;
                    break;
                case "Lechuga":
                    ctx.strokeStyle = "rgb(0, 0, 0)";
                    ctx.fillStyle = "rgba(141, 176, 7)";
                    ctx.beginPath();
                    ctx.roundRect(canvas.width / 4, yPos, 100, 10, 10);
                    ctx.stroke();
                    ctx.fill();
                    return 10;
                    break;
                case "Tomate":
                    ctx.strokeStyle = "rgb(0, 0, 0)";
                    ctx.fillStyle = "rgba(255, 83, 48)";
                    ctx.beginPath();
                    ctx.roundRect((canvas.width / 4) + 5, yPos, 100 / 2, 10, 10);
                    ctx.stroke();
                    ctx.fill();

                    ctx.strokeStyle = "rgb(0, 0, 0)";
                    ctx.fillStyle = "rgba(255, 83, 48)";
                    ctx.beginPath();
                    ctx.roundRect((canvas.width / 2) - 5, yPos, 100 / 2, 10, 10);
                    ctx.stroke();
                    ctx.fill();
                    return 10;
                    break;
                case "Cebolla":
                    ctx.strokeStyle = "rgb(0, 0, 0)";
                    ctx.fillStyle = "rgba(177, 149, 169)";
                    ctx.beginPath();
                    ctx.roundRect((canvas.width / 4) + 5, yPos, 100 / 3, 10, 10);
                    ctx.stroke();
                    ctx.fill();
                    ctx.strokeStyle = "rgb(0, 0, 0)";
                    ctx.fillStyle = "rgba(177, 149, 169)";
                    ctx.beginPath();
                    ctx.roundRect((canvas.width / 3) + 15, yPos, 100 / 3, 10, 10);
                    ctx.stroke();
                    ctx.fill();
                    ctx.strokeStyle = "rgb(0, 0, 0)";
                    ctx.fillStyle = "rgba(177, 149, 169)";
                    ctx.beginPath();
                    ctx.roundRect(canvas.width / 1.8, yPos, 100 / 3, 10, 10);
                    ctx.stroke();
                    ctx.fill();
                    return 10;
                    break;
                default:
                    return "Perdón, algo ha fallado.";
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
                    showConfetti();
                    //alert('¡Felicidades, conseguiste una medalla!');
                }
                setTimeout(() => {
                    resetGame();
                }, 3000);
            }
        }

        function showConfetti() {
            var mensajeDiv = document.getElementById('mensaje');
            mensajeDiv.style.top = '20%';
            setTimeout(function () {
                mensajeDiv.style.top = '-150%';
            }, 5000);
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
            medal.classList.add("mx-4");
            medal.classList.add("border");
            medal.classList.add("border-dark");
            medal.classList.add("shadow");
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