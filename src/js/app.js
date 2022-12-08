let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
  id: '',
  nombre: '',
  fecha: '',
  hora: '',
  servicios: [],
}

document.addEventListener('DOMContentLoaded', function () {
  inicarApp();
  paginaSiguiente();
  paginaAnterior();
  consultarApi();

});

function inicarApp() {
  mostarSeccion() // muestra y oculta la seccion
  tabs(); //Cambia la seccion cuandoo se precionan los tabs
  botonesPaginador(); //Ocultar botones paginacion
  idCliente(); /* agrega id al objeto de cita */
  nombreCliente(); /* agrega nombre al objeto de cita */
  seleccionarFecha(); /* agrega fecha al objeto de cita */
  seleccionarHora();
  mostrarResumen();

}

function mostarSeccion() {
  const seccionAnterior = document.querySelector('.mostrar');
  if (seccionAnterior) {
    seccionAnterior.classList.remove('mostrar');
  }

  const pasoSeccion = `#paso-${paso}`;
  const seccion = document.querySelector(pasoSeccion);
  seccion.classList.add('mostrar');

  const tabAnterir = document.querySelector('.actual');
  if (tabAnterir) {
    tabAnterir.classList.remove('actual');
  }
  const tab = document.querySelector(`[data-paso="${paso}"]`);
  tab.classList.add('actual');
}

function tabs() {

  const botones = document.querySelectorAll('.tabs button');
  botones.forEach(boton => {
    boton.addEventListener('click', function (e) {
      paso = parseInt(e.target.dataset.paso);
      mostarSeccion();

      botonesPaginador();
    })
  })
}

function botonesPaginador() {
  const anterior = document.querySelector('#anterior');
  const siguiente = document.querySelector('#siguiente');

  if (paso === 1) {
    anterior.classList.add('ocultar');
    siguiente.classList.remove('ocultar');
  } else if (paso === 3) {
    anterior.classList.remove('ocultar');
    siguiente.classList.add('ocultar');
    mostrarResumen();

  } else {
    anterior.classList.remove('ocultar');
    siguiente.classList.remove('ocultar');

  }
  mostarSeccion()
}

function paginaAnterior() {
  const paginaAnterior = document.querySelector('#anterior');
  paginaAnterior.addEventListener('click', function () {
    if (paso <= pasoInicial) return;
    paso--;
    botonesPaginador();
  })
}
function paginaSiguiente() {
  const paginaSiguiente = document.querySelector('#siguiente');
  paginaSiguiente.addEventListener('click', function () {
    if (paso >= pasoFinal) return;
    paso++;
    botonesPaginador();
  })
}

async function consultarApi() {
  try {
    const url = 'http://localhost:3000/api/servicios';
    const resultado = await fetch(url);
    const servicios = await resultado.json();
    mostrarServicios(servicios);
  } catch (error) {
    console.log(error)
  }
}

function mostrarServicios(servicios) {
  // const { id, nombre, precio } servicios;
  servicios.forEach(servicio => {
    const { id, nombre, precio } = servicio;

    const nombreServicio = document.createElement('P');
    nombreServicio.classList.add('nombre-servicio');
    nombreServicio.textContent = nombre;
    // console.log(nombreServicio);

    const precioServicio = document.createElement('P');
    precioServicio.classList.add('precio-servicio');
    precioServicio.textContent = `$${precio}`;
    // console.log(precioServicio);

    const servicioDiv = document.createElement('DIV');
    servicioDiv.classList.add('servicio');
    servicioDiv.dataset.idServicio = id;
    servicioDiv.appendChild(nombreServicio);
    servicioDiv.appendChild(precioServicio);

    // Agregar servicios
    servicioDiv.onclick = function () {
      seleccionarServicio(servicio);
    }

    // console.log(servicioDiv)
    document.querySelector('#servicios').appendChild(servicioDiv);
  })
}

function seleccionarServicio(servicio) {
  const { servicios } = cita;
  const { id, nombre, precio } = servicio;
  // Comprobar si un servicio ya esta agregado
  const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
  if (servicios.some(agregado => agregado.id === id)) {
    cita.servicios = servicios.filter(agregado => agregado.id != id);
    divServicio.classList.remove('seleccionado');

  } else {


    cita.servicios = [...servicios, servicio];
    divServicio.classList.add('seleccionado');
  }
  // console.log(cita)


  // Agregamos la clase de seleccionado


}

function idCliente() {
  const idCliente = document.querySelector('#id').value;
  cita.id = idCliente;
}

function nombreCliente(e) {
  const nombreCliente = document.querySelector('#nombre').value;
  cita.nombre = nombreCliente;
  // console.log(cita);
}

function seleccionarFecha() {
  const fecha = document.querySelector('#fecha');
  fecha.addEventListener('input', function (e) {
    const dia = new Date(e.target.value).getUTCDay();
    if ([6, 0].includes(dia)) {
      e.target.value = '';
      mostrarMensaje("Sabados y domingos no abrimos");
    } else {
      cita.fecha = e.target.value;
      // console.log("ok");
    }
    // console.log(dia);
  })
}

function seleccionarHora() {
  const Inputhora = document.querySelector('#hora');
  Inputhora.addEventListener('input', function (e) {
    const horaCita = e.target.value;
    const hora = horaCita.split(":")[0];
    if (hora < 10 || hora > 18) {
      e.target.value = " ";
      mostrarMensaje("Hora no valida")
    } else {
      cita.hora = horaCita;

    }
    // console.log(cita)
  })
}

function mostrarMensaje(mensaje, desaparece = true) {
  const alerta = document.querySelector('.errores');
  if (alerta) {
    alerta.remove();
  }
  const divMensaje = document.createElement('DIV');
  divMensaje.classList.add('alerta')
  divMensaje.classList.add('errores')
  divMensaje.textContent = mensaje
  const formulario = document.querySelector('.formulario, p');
  // consosle.log(formulario)
  formulario.appendChild(divMensaje);

  if (desaparece) {
    setTimeout(() => {
      divMensaje.remove();
    }, 3000)
  }


}

function mostrarResumen() {
  const resumen = document.querySelector('.contenido-resumen');

  if (Object.values(cita).includes('') || cita.servicios.length === 0) {

    if (paso === 3) {
      mostrarMensaje("Hacen falta datos o servicios", desaparece = false);
      return;
    }
  } else {
    // Formatear el div resumen
    const { nombre, fecha, hora, servicios } = cita;

    const nombreCita = document.createElement('P');
    nombreCita.innerHTML = `<span>Nombre: </span> ${nombre}`;

    // Formatear fecha
    const fechaObj = new Date(fecha); /* new Date nos aroja un desface de 1 dia  */
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year, mes, dia));

    const opciones = {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    }
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);
    // console.log(fechaFormateada);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha: </span> ${fechaFormateada}`;
    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora: </span> ${hora} Horas`;

    servicios.forEach(servicio => {
      const { id, nombre, precio } = servicio;
      const contenedorServicio = document.createElement('DIV');
      contenedorServicio.classList.add('contenedor-servicio');

      const textoServicio = document.createElement('P');
      textoServicio.textContent = nombre;

      const precioServicio = document.createElement('P');
      precioServicio.innerHTML = `<span>$${precio}</span>`

      contenedorServicio.appendChild(textoServicio);
      contenedorServicio.appendChild(precioServicio);

      resumen.appendChild(contenedorServicio);

    });


    // Boton para crear una cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar cita';
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCita);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
    resumen.appendChild(botonReservar);



  }
}

async function reservarCita() {
  const { nombre, fecha, hora, servicios, id } = cita;
  const idServicio = servicios.map(servicio => servicio.id);
  const datos = new FormData();
  datos.append('fecha', fecha);
  datos.append('hora', hora);
  datos.append('usuario_id', id);
  datos.append('servicios', idServicio);
  try {
    const url = 'http://localhost:3000/api/citas';
    const respuesta = await fetch(url, {
      method: 'POST',
      body: datos
    });
    const resultado = await respuesta.json();
    if (resultado.resultado) {
      Swal.fire({
        icon: 'success',
        title: 'Cita creada ',
        text: 'Tu cita fue creada correctamente',
        button: 'ok'
      }).then(() => {
        setTimeout(() => {
          window.location.reload();
        }, 2000)
      })
    }
  } catch (err) {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Cita no creada!',

    })
  }



  // console.log([...datos]);

}