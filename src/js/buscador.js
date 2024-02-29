const buscador = document.querySelector('#fecha');

document.addEventListener('DOMContentLoaded', () => {
    buscador.addEventListener('change', filtrarPorFecha);
})

//Funciones del buscador
function filtrarPorFecha(e) {
    window.location = `?fecha=${e.target.value}`;
}