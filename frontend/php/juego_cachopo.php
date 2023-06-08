<div id = "mensajeC" class = "rounded" style = "z-index: 4; position: absolute; transition: top 0.5s; top: -150%; right: 0; background-color: #BDECB6; color: black; padding: 10px;">
    ¡Felicidades, conseguiste una medalla!
</div>
<div class = "card-header d-flex justify-content-between align-items-center">
    <h1>Construye tu Cachopo</h1>

    <a onclick = "document.getElementById('cachopo').classList.toggle('d-none')" class = "btn btn-danger">
        <i class = "fa-solid fa-x fa-2xl"></i>
    </a>
</div>
<div class = "accordion" id = "accordionExample">
    <div class = "accordion-item">
        <h2 class = "accordion-header" id = "headingOne">
            <button class = "accordion-button" type = "button" data-bs-toggle = "collapse"
                    data-bs-target = "#collapseOne" aria-expanded = "true" aria-controls = "collapseOne">
                &nbsp;
                &nbsp;
                &nbsp;
                ¿ Cómo se juega ?
            </button>
        </h2>
        <div id = "collapseOne" class = "accordion-collapse collapse show" aria-labelledby = "headingOne"
             data-bs-parent = "#accordionExample">
            <div class = "accordion-body">
                &nbsp;
                &nbsp;
                &nbsp;
                El juego se inicia automáticamente cuando entras, para lograr hacer una hamburguesa tienes que seguir el orden de los ingredientes, de <b>izquierda a derecha</b>.
            </div>
        </div>
    </div>
    <div class = "accordion-item">
        <h2 class = "accordion-header" id = "headingTwo">
            <button class = "accordion-button collapsed" type = "button" data-bs-toggle = "collapse" data-bs-target = "#collapseTwo" aria-expanded = "false" aria-controls = "collapseTwo">
                &nbsp;
                &nbsp;
                &nbsp;
                ¿ Cómo gano puntos ?
            </button>
        </h2>
        <div id = "collapseTwo" class = "accordion-collapse collapse" aria-labelledby = "headingTwo" data-bs-parent = "#accordionExample">
            <div class = "accordion-body">
                &nbsp;
                &nbsp;
                &nbsp;
                Ganarás<strong>1 punto</strong> cada vez que un cachopo esté bien hecho.
            </div>
        </div>
    </div>
    <div class = "accordion-item">
        <h2 class = "accordion-header" id = "headingThree">
            <button class = "accordion-button collapsed" type = "button" data-bs-toggle = "collapse" data-bs-target = "#collapseThree" aria-expanded = "false" aria-controls = "collapseThree">
                &nbsp;
                &nbsp;
                &nbsp;
                ¿ Cómo gano medallas ?
            </button>
        </h2>
        <div id = "collapseThree" class = "accordion-collapse collapse" aria-labelledby = "headingThree" data-bs-parent = "#accordionExample">
            <div class = "accordion-body">
                &nbsp;
                &nbsp;
                &nbsp;
                Ganarás <strong>1 medalla</strong> cada vez que <b>5 cachopos</b> estén bien hechos.
            </div>
        </div>
    </div>
</div>
<div class = "card-body text-center">
    <div id = "score">Cachopos bien hechas: <span id = "cachopo-count-c">0</span></div>
    <div id = "medals">Medallas conseguidas: <span id = "medals-count-c">0</span></div>
    <div class = "mt-2">
        <span class = "fw-bold">Ingredientes:</span>
        <div id = "cahopo-style"></div>
    </div>
    <canvas class = "rounded shadow-lg my-2" id = "canvas-c" width = "300" height = "200"></canvas>
    <div class = "fw-bold pb-1" id = "message-c"></div>
    <div id = "medals-container-c"></div>
</div>
<div class = "card-footer text-center">
    <button class = "add-ingredient-c btn btn-success my-1" data-ingredient = "Pan Rallado">Pan Rallado</button>
    <button class = "add-ingredient-c btn btn-success my-1" data-ingredient = "Carne">Carne</button>
    <button class = "add-ingredient-c btn btn-success my-1" data-ingredient = "Queso">Queso</button>
    <button class = "add-ingredient-c btn btn-success my-1" data-ingredient = "Jamón Serrano">Jamón Serrano</button>
    <button class = "add-ingredient-c btn btn-success my-1" data-ingredient = "Salsa BBQ">Salsa BBQ</button>
    <button class = "add-ingredient-c btn btn-success my-1" data-ingredient = "Cebolla Caramelizada">Cebolla Caramelizada</button>
    <button class = "add-ingredient-c btn btn-success my-1" data-ingredient = "Setas">Setas</button>
    <button class = "btn btn-danger my-1" id = "delete-ingredient-c">Borrar Último Ingrediente</button>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const canvas = document.getElementById("canvas-c");
        const ctx = canvas.getContext("2d");

        const cachopoStyle = document.getElementById("cahopo-style");
        const message = document.getElementById("message-c");
        const deleteIngredientButton = document.getElementById("delete-ingredient-c");
        const addIngredientButtons = document.getElementsByClassName("add-ingredient-c");
        const medalsContainer = document.getElementById("medals-container-c");
        const medalsScore = document.getElementById("medals-count-c");
        const cachopoScore = document.getElementById("cachopo-count-c");

        const ingredients = ["Pan Rallado", "Carne", "Queso", "Jamón Serrano", "Salsa BBQ", "Cebolla Caramelizada", "Setas"];
        const cachopo = [];
        let score = 0;

        let cachopoStyleIndices = [];
        let medalsEarned = 0;

        function getRandomCachopoStyle() {
            cachopoStyleIndices.length = 0;
            let numIngredients = Math.floor(Math.random() * 4) + 1; // Generar de 1 a 4 ingredientes

            cachopoStyleIndices.push(0); // Agregar "Pan" al inicio
            cachopoStyleIndices.push(1); // Agregar "Carne" al inicio

            for (let i = 0; i < numIngredients; i++) {
                let ingredientIndex = Math.floor(Math.random() * (ingredients.length - 1)) + 1; // Excluir "Pan" en la generación aleatoria
                cachopoStyleIndices.push(ingredientIndex);
            }

            cachopoStyleIndices.push(1); // Agregar "Carne" al final
            cachopoStyleIndices.push(0); // Agregar "Pan" al final

            let burgerStyleText = cachopoStyleIndices.map(index => ingredients[index]).join(", ");
            cachopoStyle.textContent = burgerStyleText;
        }

        function clearCanvas() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }

        function drawCachopo() {
            clearCanvas();

            let yPos = 40;
            for (let i = 0; i < cachopo.length; i++) {
                //context.fillText(burger[i], 80, yPos);

                yPos += drawIngredientsC(cachopo[i], yPos);
                if (i === cachopo.length - 1) {
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

        function drawIngredientsC(ingredient, yPos) {
            console.log('dib' + ingredient)

            switch (ingredient) {
                case "Pan Rallado":
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
                case "Jamón Serrano":
                    ctx.strokeStyle = "rgb(0, 0, 0)";
                    ctx.fillStyle = "rgba(141, 176, 7)";
                    ctx.beginPath();
                    ctx.roundRect(canvas.width / 4, yPos, 100, 10, 10);
                    ctx.stroke();
                    ctx.fill();
                    return 10;
                    break;
                case "Salsa BBQ":
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
                case "Cebolla Caramelizada":
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
                case "Setas":
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

        function checkCachopo() {
            console.log(JSON.stringify(cachopo))
            console.log(JSON.stringify(cachopoStyleIndices.map(index => ingredients[index])))

            if (JSON.stringify(cachopo) === JSON.stringify(cachopoStyleIndices.map(index => ingredients[index]))) {
                message.textContent = "¡Felicidades, has montado un cachopo!";
                score++;
                cachopoScore.innerHTML = score;
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
            cachopo.length = 0;
            clearCanvas();
            message.textContent = "";
            getRandomCachopoStyle();
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

        getRandomCachopoStyle();

        for (let i = 0; i < addIngredientButtons.length; i++) {
            addIngredientButtons[i].addEventListener("click", function () {
                const ingredient = this.dataset.ingredient;
                cachopo.push(ingredient);
                drawCachopo();
                checkCachopo();
            });
        }

        deleteIngredientButton.addEventListener("click", function () {
            cachopo.pop();
            drawCachopo();
        });
    });
</script>