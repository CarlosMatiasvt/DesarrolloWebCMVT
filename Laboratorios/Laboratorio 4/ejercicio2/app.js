//Integrantes: Villarroel tarraga carlos matias y Gutierrez Torricos Adalid
document.addEventListener("DOMContentLoaded", () => {
    const contenido = document.querySelector("#contenido");
    const botonesNav = document.querySelectorAll(".cabecera nav button[data-vista]");
    const modal = document.querySelector("#modal");
    const modalTitulo = document.querySelector("#modal-titulo");
    const modalCuerpo = document.querySelector("#modal-cuerpo");
    const modalPie = document.querySelector("#modal-pie");

    let timerBusqueda = null;
    let totalProd = 0;

    function escapar(str) {
        if (!str) return "";
        return String(str).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#39;");
    }

    function claseCat(cat) {
        const c = cat.toLowerCase();
        return c.includes("salado") ? "et-salados" : c.includes("plato") ? "et-platos" : c.includes("postre") ? "et-postres" : "";
    }

    async function cargarVista(url) {
        contenido.innerHTML = '<p class="cargando">Cargando...</p>';
        try {
            const resp = await fetch(url);
            if (!resp.ok) throw new Error(`Error ${resp.status}`);
            contenido.innerHTML = await resp.text();
        } catch (err) {
            contenido.innerHTML = `<div class="aviso aviso-error">${escapar(err.message)}</div>`;
        }
    }

    botonesNav.forEach(btn => {
        btn.addEventListener("click", () => {
            botonesNav.forEach(b => b.classList.remove("activo"));
            btn.classList.add("activo");
            const vista = btn.dataset.vista;
            if (vista === "inicio") cargarVista("inicio.html");
            else if (vista === "menu") prepararMenu();
            else if (vista === "nuevo") prepararNuevo();
        });
    });

    async function llenarSelect(sel, def) {
        try {
            const resp = await fetch("categorias.php");
            const cats = await resp.json();
            sel.innerHTML = `<option value="${def === "Todas" ? "0" : ""}">${def}</option>`;
            cats.forEach(c => {
                sel.innerHTML += `<option value="${c.id}">${escapar(c.nombre)}</option>`;
            });
        } catch (e) {}
    }

    async function prepararMenu() {
        contenido.innerHTML = `
            <div id="aviso-menu"></div>
            <h2>Menú <span id="contador-productos" class="contador">0</span></h2>
            <div class="barra">
                <div class="campo"><label>Buscar</label><input type="search" id="txt-buscar" placeholder="Ej.: pollo"></div>
                <div class="campo"><label>Categoría</label><select id="sel-categoria"><option value="0">Todas</option></select></div>
            </div>
            <div id="grilla-productos" class="grilla"></div>
        `;
        await llenarSelect(document.querySelector("#sel-categoria"), "Todas");
        
        document.querySelector("#txt-buscar").addEventListener("input", () => {
            clearTimeout(timerBusqueda);
            timerBusqueda = setTimeout(cargarProductos, 300);
        });
        document.querySelector("#sel-categoria").addEventListener("change", cargarProductos);
        cargarProductos();
    }

    async function cargarProductos() {
        const txt = document.querySelector("#txt-buscar").value.trim();
        const cat = document.querySelector("#sel-categoria").value;
        const grilla = document.querySelector("#grilla-productos");
        const cont = document.querySelector("#contador-productos");
        
        grilla.innerHTML = '<p class="cargando">Cargando productos...</p>';
        try {
            const resp = await fetch(`productos.php?buscar=${encodeURIComponent(txt)}&categoria=${cat}`);
            const prods = await resp.json();
            totalProd = prods.length;
            cont.textContent = totalProd;

            if (prods.length === 0) {
                grilla.innerHTML = '<p class="vacio">No hay productos.</p>';
                return;
            }

            grilla.innerHTML = prods.map(p => `
                <article class="producto ${p.disponible ? "" : "agotado"}" data-id="${p.id}">
                    ${p.imagen ? `<img src="../images/${escapar(p.imagen)}">` : '<div class="sin-imagen">SIN FOTO</div>'}
                    <div class="cuerpo">
                        <span class="etiqueta ${claseCat(p.categoria)}">${escapar(p.categoria)}</span>
                        <h4>${escapar(p.nombre)}</h4>
                        <div class="precio">Bs ${Number(p.precio).toFixed(2)}</div>
                        ${p.disponible ? "" : '<span class="etiqueta et-agotado">Agotado</span>'}
                        <div class="acciones">
                            <button class="boton mini btn-detalle" data-id="${p.id}">Detalle</button>
                            <button class="boton boton-no mini btn-eliminar" data-id="${p.id}" data-nombre="${escapar(p.nombre)}">Eliminar</button>
                        </div>
                    </div>
                </article>
            `).join("");
        } catch (err) {
            grilla.innerHTML = `<div class="aviso aviso-error">${escapar(err.message)}</div>`;
        }
    }

    async function prepararNuevo() {
        await cargarVista("form_producto.html");
        await llenarSelect(document.querySelector("#categoria_id"), "-- Seleccione --");
    }

    function mostrarModal(tit, cuerpo, pie) {
        modalTitulo.textContent = tit;
        modalCuerpo.innerHTML = cuerpo;
        modalPie.innerHTML = pie;
        modal.classList.add("abierto");
    }

    function cerrarModal() {
        modal.classList.remove("abierto");
    }

    modal.addEventListener("click", e => {
        if (e.target === modal || e.target.matches(".btn-cerrar-modal")) cerrarModal();
    });
    document.addEventListener("keydown", e => { if (e.key === "Escape") cerrarModal(); });

    contenido.addEventListener("click", async e => {
        if (e.target.matches(".btn-detalle")) {
            const id = e.target.dataset.id;
            mostrarModal("Cargando...", '<p class="cargando">Cargando...</p>', '<button class="boton boton-sec btn-cerrar-modal">Cerrar</button>');
            try {
                const resp = await fetch(`producto.php?id=${id}`);
                const p = await resp.json();
                if (!resp.ok) throw new Error(p.mensaje);
                mostrarModal(p.nombre, `
                    ${p.imagen ? `<img src="../images/${escapar(p.imagen)}">` : '<div class="sin-imagen">SIN FOTO</div>'}
                    <p><span class="etiqueta ${claseCat(p.categoria)}">${escapar(p.categoria)}</span></p>
                    <p>${escapar(p.descripcion || "Sin descripción")}</p>
                    <p><strong>Precio:</strong> Bs ${Number(p.precio).toFixed(2)}</p>
                `, '<button class="boton boton-sec btn-cerrar-modal">Cerrar</button>');
            } catch (err) {
                mostrarModal("Error", `<div class="aviso aviso-error">${escapar(err.message)}</div>`, '<button class="boton boton-sec btn-cerrar-modal">Cerrar</button>');
            }
        }

        if (e.target.matches(".btn-eliminar")) {
            const id = e.target.dataset.id;
            const nombre = e.target.dataset.nombre;
            const tarjeta = e.target.closest(".producto");
            mostrarModal("Confirmar eliminación", `<p>¿Eliminar <strong>${nombre}</strong>?</p>`, `
                <button class="boton boton-sec btn-cerrar-modal">Cancelar</button>
                <button id="conf-eliminar" class="boton boton-no">Eliminar</button>
            `);

            document.querySelector("#conf-eliminar").addEventListener("click", async () => {
                const fd = new FormData();
                fd.append("id", id);
                try {
                    const resp = await fetch("eliminar.php", { method: "POST", body: fd });
                    const res = await resp.json();
                    if (!resp.ok) throw new Error(res.mensaje);
                    cerrarModal();
                    tarjeta.remove();
                    totalProd = Math.max(0, totalProd - 1);
                    document.querySelector("#contador-productos").textContent = totalProd;
                    document.querySelector("#aviso-menu").innerHTML = `<div class="aviso">${escapar(res.mensaje)}</div>`;
                } catch (err) {
                    cerrarModal();
                    document.querySelector("#aviso-menu").innerHTML = `<div class="aviso aviso-error">${escapar(err.message)}</div>`;
                }
            });
        }
    });

    contenido.addEventListener("submit", async e => {
        if (!e.target.matches("#form-producto")) return;
        e.preventDefault();
        const form = e.target;
        const btn = form.querySelector("#btn-guardar");
        const msg = document.querySelector("#mensajes-form");

        const nombre = form.querySelector("#nombre").value.trim();
        const cat = form.querySelector("#categoria_id").value;
        const precio = form.querySelector("#precio").value;

        let errores = [];
        if (nombre.length < 3) errores.push("El nombre debe tener al menos 3 caracteres.");
        if (!cat || cat === "") errores.push("Seleccione una categoría.");
        if (Number(precio) <= 0) errores.push("El precio debe ser mayor a cero.");

        if (errores.length > 0) {
            msg.innerHTML = `<div class="aviso aviso-error"><ul>${errores.map(err => `<li>${escapar(err)}</li>`).join("")}</ul></div>`;
            return;
        }

        btn.disabled = true;
        btn.textContent = "Guardando...";
        msg.innerHTML = "";

        try {
            const resp = await fetch("insertar.php", { method: "POST", body: new FormData(form) });
            const res = await resp.json();
            if (resp.status === 201 && res.exito) {
                msg.innerHTML = `<div class="aviso">${escapar(res.mensaje)}</div>`;
                form.reset();
            } else if (resp.status === 422) {
                msg.innerHTML = `<div class="aviso aviso-error"><ul>${res.errores.map(err => `<li>${escapar(err)}</li>`).join("")}</ul></div>`;
            } else {
                throw new Error(res.mensaje || "Error al guardar");
            }
        } catch (err) {
            msg.innerHTML = `<div class="aviso aviso-error">${escapar(err.message)}</div>`;
        } finally {
            btn.disabled = false;
            btn.textContent = "Guardar producto";
        }
    });

    cargarVista("inicio.html");
});