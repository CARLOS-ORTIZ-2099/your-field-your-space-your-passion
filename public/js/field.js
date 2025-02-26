document.addEventListener("DOMContentLoaded", init);

const reservation = {
  total_pay: "",
  rental_time: "",
  start_time: "",
  rental_date: "",
};

function init() {
  showFreeHours();
  selectQuantityHours();
}

function selectQuantityHours() {
  const quantityHours = document.querySelector(".quantity-hours");
  quantityHours.addEventListener("input", (e) => {
    let pricePerHours = e.target.value.split("-");
    reservation.total_pay = parseInt(pricePerHours[0] * pricePerHours[1]);
    reservation.rental_time = pricePerHours[1];
    console.log(reservation);
  });
}

function showFreeHours() {
  const inputDate = document.querySelector(".date");
  inputDate.addEventListener("change", (e) => {
    let date = e.target.value;
    reservation.rental_date = date;
    console.log(reservation);
    callApi(date);
  });
}

async function callApi(date) {
  let id = getIdUrlParams();
  try {
    let url = `http://localhost:3000/api/getReservations?date=${date}&field=${id}`;
    const response = await fetch(url);
    //console.log(response);
    if (!response.ok == 200) throw new Error("error desconocido");
    let busyHours = await response.json();
    //console.log(busyHours);
    renderViewHours(busyHours);
  } catch (error) {
    console.log(error);
    createTemplateMessage("ocurrio un error en el servidor, intenta luego");
  }
}

function renderViewHours(busyHours) {
  const freeHoursContainer = document.querySelector(".free-hours-container");
  const title = document.createElement("H2");
  title.innerText = "estas son las horas disponibles de la sucursal";
  title.classList.add("title-hours");
  if (!document.querySelector(".title-hours")) {
    freeHoursContainer.insertAdjacentElement("beforebegin", title);
  }

  freeHoursContainer.innerHTML = ``;
  hours = [
    "07:00:00",
    "08:00:00",
    "09:00:00",
    "10:00:00",
    "11:00:00",
    "12:00:00",
    "13:00:00",
    "14:00:00",
    "15:00:00",
    "16:00:00",
    "17:00:00",
    "18:00:00",
    "19:00:00",
    "20:00:00",
    "21:00:00",
    "22:00:00",
    "23:00:00",
  ];
  console.log(busyHours);
  let init = 0;
  /* aqui lo que hacemos es que comprobamos si el arreglod e horas ocupadas esta la hora que estamos iterando 
     actualmente si es asi slatamos tantas posiciones como la diferencia de las hora de incio y fin esto para
     que el usuario no pueda seleccionar horas ya reservadas 
  */
  while (init < hours.length) {
    if (busyHours[hours[init]]) {
      substract = subtractHours(busyHours[hours[init]], hours[init]);
      console.log(substract);
      init += substract;
      continue;
    }
    const button = document.createElement("BUTTON");
    button.innerText = `${hours[init]}`;
    button.value = hours[init];
    button.addEventListener("click", selectHour);
    freeHoursContainer.appendChild(button);
    init++;
  }
}

function selectHour(e) {
  reservation.start_time = e.target.value;
  console.log(reservation);
  console.log(e.target);
  // si ya existe el boton con la clse seleccionada
  const buttonSelected = document.querySelector(".select-hour");
  if (buttonSelected) {
    // lo quitamos
    buttonSelected.classList.remove("select-hour");
    e.target.classList.add("select-hour");
  } else {
    //buttonSelected.classList.add("select-hour");
    e.target.classList.add("select-hour");
  }
  //const buttonSelected = e.target.classList.add("select-hour");
  // CONTINUAR AQUI
}

function getIdUrlParams() {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const id = urlParams.get("id");
  return id;
}

function subtractHours(horaFinal, horaInicio) {
  console.log(horaFinal, horaInicio);
  // Función para convertir una hora "HH:MM:SS" a segundos
  const convertirASegundos = (hora) => {
    const partes = hora.split(":");
    //console.log(partes);
    return (
      //convirtiendo las horas en segundos 10*3600 = 36000
      parseInt(partes[0], 10) * 3600 +
      // conviertiendo los minutos en segundos
      parseInt(partes[1], 10) * 60 +
      // los segundos ya estan en segundos
      parseInt(partes[2], 10)
    );
  };

  const segundosFinal = convertirASegundos(horaFinal);
  const segundosInicio = convertirASegundos(horaInicio);
  const diferencia = segundosFinal - segundosInicio;

  // convertir la diferencia a horas, minutos y segundos
  const horas = Math.floor(diferencia / 3600);
  return horas;
}

function createTemplateMessage(message) {
  const div = document.createElement("DIV");
  div.innerHTML = `
     <h2>${message}</h2>
  `;
  fieldsContainer.appendChild(div);
}
