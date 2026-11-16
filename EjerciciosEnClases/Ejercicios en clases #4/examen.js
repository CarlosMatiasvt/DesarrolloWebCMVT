function pregunta4(){
   var contenedor;
   contenedor = document.getElementById("contenido");
   fetch("catalogo.php")
        .then(response => response.text())
        .then(data => contenedor.innerHTML=data);
}
function abrirmodal(){
    document.querySelector(".modal").style.display="block";
    document.getElementById("imagen-modal").src="images/"+fotografia;
}
function cerrar(){
    document.querySelector(".modal").style.display="none";
}