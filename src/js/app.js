//Variables cita--app
const agendarCita = document.getElementById("cita-app");
let paso = 1;
let cita = {
  usuarioId: document.getElementById("id").value,
  nombre: document.getElementById("nombre").value,
  fecha: "",
  hora: "",
  servicios: [],
};

//Funciones cita--app
if (agendarCita) {
  document.addEventListener("DOMContentLoaded", () => {
    Paginador();
    Tabs();
    mostrarServicios();
    horaAndFecha();
  });
}

function Paginador() {
  const botonAnterior = document.getElementById("anterior");
  const botonSiguiente = document.getElementById("siguiente");
  botonAnterior.addEventListener("click", () => {
    paso--;
    optimizar();
  });
  botonSiguiente.addEventListener("click", () => {
    paso++;
    optimizar();
  });
}

function Tabs() {
  const tabs = document.querySelectorAll("[data-paso]");

  tabs.forEach((button) =>
    button.addEventListener("click", (e) => {
      paso = parseInt(e.target.dataset.paso);
      optimizar();
    })
  );
}
function mostrarSeccion() {
  identificador = `paso-${paso}`;
  seccion = document.getElementById(identificador);

  //Eliminar seccion anterior
  const seccionAnterior = document.querySelector(".cita--visible");
  if (seccionAnterior) {
    seccionAnterior.classList.remove("cita--visible");
  }

  //Mostrar seccion
  seccion.classList.add("cita--visible");
}

function ocultarAndMarcar() {
  const botonAnterior = document.getElementById("anterior");
  const botonSiguiente = document.getElementById("siguiente");
  const tabs = document.querySelectorAll("[data-paso]");

  //Eliminar marca
  const tabAnterior = document.querySelector(".tabs--seleccionado");
  tabAnterior.classList.remove("tabs--seleccionado");

  //Marcar tabs seleccionado
  tabs.forEach((boton) =>
    parseInt(boton.dataset.paso) === paso
      ? boton.classList.add("tabs--seleccionado")
      : null
  );

  switch (paso) {
    case 1:
      botonAnterior.classList.add("boton--invisible");
      botonSiguiente.classList.remove("boton--invisible");
      break;
    case 2:
      botonAnterior.classList.remove("boton--invisible");
      botonSiguiente.classList.remove("boton--invisible");
      break;
    case 3:
      botonAnterior.classList.remove("boton--invisible");
      botonSiguiente.classList.add("boton--invisible");
      mostrarResumen();
      break;
    default:
      break;
  }
}

function optimizar() {
  mostrarSeccion();
  ocultarAndMarcar();
}

//Api
async function consultarApi(url) {
  try {
    const resultado = await fetch(url);
    const respuesta = await resultado.json();
    return respuesta;
  } catch (error) {
    console.log(error);
  }
}

async function mostrarServicios() {
  try {
    const servicios = await consultarApi(`${location.origin}/api/servicios`);

    servicios.forEach((servicio) => {
      const { id, nombre, precio } = servicio;

      //Crear el contenedor
      const servicioDiv = document.createElement("DIV");
      servicioDiv.classList.add("servicios__card");
      servicioDiv.dataset.idServicio = id;
      servicioDiv.addEventListener("click", () =>
        seleccionarServicio(servicio)
      );

      //Crear el contenido
      const servicioNombre = document.createElement("P");
      servicioNombre.textContent = nombre;
      const servicioPrecio = document.createElement("P");
      servicioPrecio.textContent = precio;

      //Agregar el contenido
      servicioDiv.appendChild(servicioNombre);
      servicioDiv.appendChild(servicioPrecio);

      document.getElementById("servicios").appendChild(servicioDiv);
    });
  } catch (error) {
    console.log(error);
  }
}

//Guardar datos

function horaAndFecha() {
  const inputFecha = document.querySelector("#fecha");
  const inputHora = document.querySelector("#hora");

  inputFecha.addEventListener("change", (e) => validarFecha(e));
  inputHora.addEventListener("change", (e) => validarHora(e));
}

function validarFecha(e) {
  const fechaElegida = new Date(e.target.value).getUTCDay();
  const datosDiv = document.getElementById("paso-2");
  if (fechaElegida === 0 || fechaElegida === 6) {
    mostrarAlerta("Los fines de semana no abrimos", "error", datosDiv);
    e.target.value = "";
  } else {
    cita.fecha = e.target.value;
  }
}
function validarHora(e) {
  const horaSelecta = e.target.value.split(":");
  const datosDiv = document.getElementById("paso-2");
  if (parseInt(horaSelecta[0]) < 9 || parseInt(horaSelecta[0]) > 17) {
    mostrarAlerta("El horario del salon es de 9:00 a 18:00", "error", datosDiv);
    e.target.value = "";
  } else {
    cita.hora = e.target.value;
  }
}

function seleccionarServicio(servicio, e) {
  const divSelecto = document.querySelector(
    `[data-id-servicio="${servicio.id}"]`
  );

  const servicioAgregado = cita.servicios.find(
    (agregado) => agregado.id === servicio.id
  );

  if (servicioAgregado) {
    divSelecto.classList.remove("servicios__card--selecto");
    const serviciosFiltrados = cita.servicios.filter(
      (agregado) => agregado.id !== servicioAgregado.id
    );
    cita.servicios = serviciosFiltrados;
  } else {
    divSelecto.classList.add("servicios__card--selecto");
    cita.servicios = [...cita.servicios, servicio];
  }
}
function mostrarAlerta(mensaje, tipo, contenedor, estatica = false) {
  const alertaP = document.createElement("P");
  alertaP.classList.add("alerta");
  alertaP.classList.add(`alerta__${tipo}`);
  alertaP.textContent = mensaje;

  contenedor.appendChild(alertaP);

  if (estatica) {
    return;
  }

  setTimeout(() => {
    alertaP.remove();
  }, 3000);
}

function mostrarResumen() {
  const resumenContenedor = document.querySelector("#resumen");

  //Limpiar HTML
  limpiarHTML(resumenContenedor);

  if (Object.values(cita).includes("") || cita.servicios.length === 0) {
    mostrarAlerta(
      "Los servicios o datos estan incompletos",
      "error",
      resumenContenedor,
      true
    );
    return;
  }

  //Resumen mensaje
  const mensajeP = document.createElement("P");
  mensajeP.textContent = "Verifica que la información sea correcta:";
  resumenContenedor.appendChild(mensajeP);

  //Resumen de servicios
  const tituloServicios = document.createElement("H3");
  tituloServicios.textContent = "Resumen de servicios";
  resumenContenedor.appendChild(tituloServicios);

  //Crear elementos: Resumen de servicios
  cita.servicios.forEach((servicio) => {
    const servicioDIV = document.createElement("DIV");

    const servicioP = document.createElement("P");
    servicioP.textContent = "Servicio: ";
    const servicioSPAN = document.createElement("SPAN");
    servicioSPAN.textContent = servicio.nombre;
    servicioP.appendChild(servicioSPAN);

    const precioP = document.createElement("P");
    precioP.textContent = "Precio: ";
    const precioSPAN = document.createElement("SPAN");
    precioSPAN.textContent = servicio.precio;
    precioP.appendChild(precioSPAN);

    const salto = document.createElement("HR");
    servicioDIV.appendChild(servicioP);
    servicioDIV.appendChild(precioP);
    servicioDIV.appendChild(salto);

    resumenContenedor.appendChild(servicioDIV);
  });

  //Resumen de datos
  const nombreP = document.createElement("P");
  nombreP.textContent = `Nombre: `;
  const nombreSPAN = document.createElement("SPAN");
  nombreSPAN.textContent = cita.nombre;
  nombreP.appendChild(nombreSPAN);

  const fechaP = document.createElement("P");
  fechaP.textContent = `Fecha: `;
  const fechaSPAN = document.createElement("SPAN");
  fechaSPAN.textContent = transformarFecha(cita.fecha);
  fechaP.appendChild(fechaSPAN);

  const horaP = document.createElement("P");
  horaP.textContent = `Hora: `;
  const horaSPAN = document.createElement("SPAN");
  horaSPAN.textContent = cita.hora;
  horaP.appendChild(horaSPAN);

  //Añadir elementos al resumen
  resumenContenedor.appendChild(nombreP);
  resumenContenedor.appendChild(fechaP);
  resumenContenedor.appendChild(horaP);

  //Añadir boton submit
  const submitBUTTON = document.createElement("BUTTON");
  submitBUTTON.classList.add("boton--azul");
  submitBUTTON.textContent = "Reservar cita";
  submitBUTTON.onclick = () => reservarCita();
  resumenContenedor.appendChild(submitBUTTON);
}

function limpiarHTML(lugar) {
  while (lugar.firstChild) {
    lugar.removeChild(lugar.firstChild);
  }
}

function transformarFecha(fecha) {
  const fechaObj = new Date(fecha);
  const mes = fechaObj.getMonth();
  const dia = fechaObj.getDate() + 2;
  const year = fechaObj.getFullYear();

  const fechaUTC = new Date(Date.UTC(year, mes, dia));
  const opciones = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  };
  const fechaFormateada = fechaUTC.toLocaleDateString("es-MX", opciones);
  return fechaFormateada;
}

async function reservarCita() {
  const { usuarioId, fecha, hora, servicios } = cita;

  const datos = new FormData();
  datos.append("usuarios_id", usuarioId);
  datos.append("fecha", fecha);
  datos.append("hora", hora);

  const serviciosId = servicios.map((servicio) => servicio.id);
  datos.append("servicios", serviciosId);

  const url = `${location.origin}/api/cita`;

  try {
    const respuesta = await fetch(url, {
      method: "POST",
      body: datos,
    });

    const resultado = await respuesta.json();

    if (resultado.resultado) {
      Swal.fire({
        icon: "success",
        title: "Cita creada",
        text: "Tu cita ha sido reservada correctamente.",
      }).then(setTimeout(() => window.location.reload(), 3000));
    }
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Lo sentimos, algo salió mal",
    }).then(window.location.reload());
  }
}
