
function extraerBody(htmlCompleto) {
    var inicio = htmlCompleto.indexOf('<body>');
    var fin    = htmlCompleto.indexOf('</body>');

    if (inicio === -1 || fin === -1) {
        return htmlCompleto;
    }

    return htmlCompleto.substring(inicio + 6, fin);
}

/**

 * @param {string} archivo  
 */
function cargarPagina(archivo) {
    var contenedor = document.getElementById('contenedor-principal');

    contenedor.innerHTML = '<p>Cargando...</p>';

    var xhr = new XMLHttpRequest();
    xhr.open('GET', archivo, true);   

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200 || xhr.status === 0) {
                var soloBody = extraerBody(xhr.responseText);
                contenedor.innerHTML = soloBody;
            } else {
                contenedor.innerHTML =
                    '<p style="color:red;">Error al cargar: ' + archivo + '</p>';
            }
        }
    };

    xhr.send();
}

function mostrarInicio() {
    var contenedor = document.getElementById('contenedor-principal');
    contenedor.innerHTML = '';
}
