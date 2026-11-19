// Integrantes: Adalid Gutiérrez Torricos y Carlos Matias Villarroel Tarraga

const productos = [
    { id: 1, nombre: "Empanadas de queso",  categoria: "Salados", precio: 6.00,  imagen: "empanadas.jpg" },
    { id: 2, nombre: "Papas fritas",        categoria: "Salados", precio: 8.00,  imagen: "papas.jpg" },
    { id: 3, nombre: "Hamburguesa clásica", categoria: "Salados", precio: 18.00, imagen: "hamburguesa.jpg" },
    { id: 4, nombre: "Sopa de pollo",       categoria: "Platos",  precio: 12.00, imagen: "sopa.jpg" },
    { id: 5, nombre: "Pollo al horno",      categoria: "Platos",  precio: 22.00, imagen: "pollo.jpg" },
    { id: 6, nombre: "Spaghetti carbonara", categoria: "Platos",  precio: 20.00, imagen: "espagueti.jpg" },
    { id: 7, nombre: "Flan casero",         categoria: "Postres", precio: 7.00,  imagen: "flan.jpg" },
    { id: 8, nombre: "Tiramisú",            categoria: "Postres", precio: 12.00, imagen: "tiramisu.jpg" },
    { id: 9, nombre: "Helado de vainilla",  categoria: "Postres", precio: 8.00,  imagen: "vainilla.jpg" }
];

document.addEventListener("DOMContentLoaded", () => {
    const catalogo = document.querySelector("#catalogo");
    const resumen = document.querySelector("#resumen");
    const inputBuscar = document.querySelector("#buscar");
    const selectCategoria = document.querySelector("#categoria");
    const tbodyDetalle = document.querySelector("#detalle");
    const spanTotal = document.querySelector("#total");
    const spanContador = document.querySelector("#contador");
    const btnVaciar = document.querySelector("#btn-vaciar");

    const formEntrega = document.querySelector("#form-entrega");
    const inputNombre = document.querySelector("#nombre");
    const inputCelular = document.querySelector("#celular");
    const selectEntrega = document.querySelector("#entrega");
    const grupoAula = document.querySelector("#grupo-aula");
    const inputAula = document.querySelector("#aula");
    const errorNombre = document.querySelector("#error-nombre");
    const errorCelular = document.querySelector("#error-celular");
    const errorAula = document.querySelector("#error-aula");
    const divErrores = document.querySelector("#mensajes-error");
    const divConfirmacion = document.querySelector("#confirmacion");

    const regexNombre = /^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,50}$/;
    const regexCelular = /^[67]\d{7}$/;
    const regexAula = /^[A-Z]-\d{1,3}$/;

    let pedido = JSON.parse(localStorage.getItem("pedidoCafeteria")) || [];

    function claseCat(cat) {
        const c = cat.toLowerCase();
        return c.includes("salado") ? "et-salados" : c.includes("plato") ? "et-platos" : "et-postres";
    }

    function guardarPedido() {
        localStorage.setItem("pedidoCafeteria", JSON.stringify(pedido));
    }

    // Requisito 1: tarjetas con el DOM (sin innerHTML)
    function mostrarProductos(lista) {
        catalogo.textContent = "";
        resumen.textContent = `Mostrando ${lista.length} de ${productos.length} productos`;

        if (lista.length === 0) {
            const aviso = document.createElement("p");
            aviso.classList.add("aviso", "aviso-info");
            aviso.textContent = "No se encontraron productos.";
            catalogo.appendChild(aviso);
            return;
        }

        lista.forEach(p => {
            const tarjeta = document.createElement("article");
            tarjeta.classList.add("producto");

            const img = document.createElement("img");
            img.src = `../images/${p.imagen}`;
            img.alt = p.nombre;

            const cuerpo = document.createElement("div");
            cuerpo.classList.add("cuerpo");

            const etiqueta = document.createElement("span");
            etiqueta.classList.add("etiqueta", claseCat(p.categoria));
            etiqueta.textContent = p.categoria;

            const titulo = document.createElement("h4");
            titulo.textContent = p.nombre;

            const precio = document.createElement("div");
            precio.classList.add("precio");
            precio.textContent = `Bs ${p.precio.toFixed(2)}`;

            const acciones = document.createElement("div");
            acciones.classList.add("acciones");

            const btn = document.createElement("button");
            btn.type = "button";
            btn.classList.add("boton", "mini", "btn-agregar");
            btn.textContent = "Agregar";
            btn.dataset.id = p.id;

            acciones.appendChild(btn);
            cuerpo.appendChild(etiqueta);
            cuerpo.appendChild(titulo);
            cuerpo.appendChild(precio);
            cuerpo.appendChild(acciones);
            tarjeta.appendChild(img);
            tarjeta.appendChild(cuerpo);
            catalogo.appendChild(tarjeta);
        });
    }

    // Requisito 2: filtro combinado
    function filtrar() {
        const texto = inputBuscar.value.trim().toLowerCase();
        const cat = selectCategoria.value;

        const filtrados = productos.filter(p =>
            p.nombre.toLowerCase().includes(texto) &&
            (cat === "Todas" || p.categoria === cat)
        );
        mostrarProductos(filtrados);
    }

    // Requisito 3: tabla con map + join y totales con reduce
    function dibujarPedido() {
        if (pedido.length === 0) {
            tbodyDetalle.innerHTML = '<tr><td colspan="4" class="vacio">Aún no agregó productos.</td></tr>';
        } else {
            tbodyDetalle.innerHTML = pedido.map(item => `
                <tr>
                    <td>${item.nombre}</td>
                    <td class="num">${item.cantidad}</td>
                    <td class="num">Bs ${(item.precio * item.cantidad).toFixed(2)}</td>
                    <td class="num">
                        <button type="button" class="boton boton-no mini btn-quitar" data-id="${item.id}">-</button>
                    </td>
                </tr>
            `).join("");
        }

        const total = pedido.reduce((acc, item) => acc + item.precio * item.cantidad, 0);
        const unidades = pedido.reduce((acc, item) => acc + item.cantidad, 0);

        spanTotal.textContent = `Bs ${total.toFixed(2)}`;
        spanContador.textContent = unidades;
    }

    inputBuscar.addEventListener("input", filtrar);
    selectCategoria.addEventListener("change", filtrar);

    // Delegación en #catalogo (Agregar)
    catalogo.addEventListener("click", e => {
        if (!e.target.matches(".btn-agregar")) return;
        const id = Number(e.target.dataset.id);
        const prod = productos.find(p => p.id === id);
        const existe = pedido.find(item => item.id === id);

        if (existe) {
            existe.cantidad++;
        } else {
            pedido.push({ id: prod.id, nombre: prod.nombre, precio: prod.precio, cantidad: 1 });
        }

        guardarPedido();
        dibujarPedido();
    });

    // Delegación en #detalle (Quitar -)
    tbodyDetalle.addEventListener("click", e => {
        if (!e.target.matches(".btn-quitar")) return;
        const id = Number(e.target.dataset.id);
        const idx = pedido.findIndex(item => item.id === id);
        if (idx === -1) return;

        if (pedido[idx].cantidad > 1) {
            pedido[idx].cantidad--;
        } else {
            pedido.splice(idx, 1);
        }

        guardarPedido();
        dibujarPedido();
    });

    btnVaciar.addEventListener("click", () => {
        pedido = [];
        guardarPedido();
        dibujarPedido();
    });

    // Requisito 4: campo Aula condicional y validación
    selectEntrega.addEventListener("change", () => {
        const esAula = selectEntrega.value === "Llevar al aula";
        grupoAula.classList.toggle("oculto", !esAula);
        if (!esAula) {
            inputAula.value = "";
            inputAula.classList.remove("valido", "invalido");
            errorAula.textContent = "";
        }
    });

    function validarCampo(input, divErr, valido, msg) {
        input.classList.toggle("valido", valido);
        input.classList.toggle("invalido", !valido);
        divErr.textContent = valido ? "" : msg;
    }

    formEntrega.addEventListener("submit", e => {
        e.preventDefault();
        divErrores.textContent = "";
        divConfirmacion.textContent = "";

        const errores = [];
        if (pedido.length === 0) errores.push("El pedido está vacío.");

        const okNombre = regexNombre.test(inputNombre.value.trim());
        validarCampo(inputNombre, errorNombre, okNombre, "Solo letras y espacios (3 a 50).");
        if (!okNombre) errores.push("Revise el nombre.");

        const okCelular = regexCelular.test(inputCelular.value.trim());
        validarCampo(inputCelular, errorCelular, okCelular, "8 dígitos, empieza con 6 o 7.");
        if (!okCelular) errores.push("Revise el celular.");

        const esAula = selectEntrega.value === "Llevar al aula";
        if (esAula) {
            const okAula = regexAula.test(inputAula.value.trim());
            validarCampo(inputAula, errorAula, okAula, "Formato letra-número, ej. A-12.");
            if (!okAula) errores.push("Revise el aula.");
        }

        if (errores.length > 0) {
            const caja = document.createElement("div");
            caja.classList.add("aviso", "aviso-error");
            caja.textContent = "No se puede confirmar:";

            const ul = document.createElement("ul");
            ul.classList.add("lista-errores");
            errores.forEach(err => {
                const li = document.createElement("li");
                li.textContent = err;
                ul.appendChild(li);
            });

            caja.appendChild(ul);
            divErrores.appendChild(caja);
            return;
        }

        const datos = Object.fromEntries(new FormData(formEntrega));
        const total = pedido.reduce((acc, item) => acc + item.precio * item.cantidad, 0);
        const numero = Math.floor(10000 + Math.random() * 90000);
        const destino = esAula ? `Entrega en aula ${datos.aula.trim()}.` : "Recoger en caja.";

        console.log(JSON.stringify({ numero, datos, pedido, total: Number(total.toFixed(2)) }));

        const aviso = document.createElement("div");
        aviso.classList.add("aviso");
        aviso.textContent = `Pedido N.º ${numero} confirmado para ${datos.nombre.trim()} (${datos.celular.trim()}). Total Bs ${total.toFixed(2)}. ${destino}`;
        divConfirmacion.appendChild(aviso);

        pedido = [];
        guardarPedido();
        dibujarPedido();
        formEntrega.reset();
        grupoAula.classList.add("oculto");
        [inputNombre, inputCelular, inputAula].forEach(el => el.classList.remove("valido", "invalido"));
    });

    mostrarProductos(productos);
    dibujarPedido();
});
