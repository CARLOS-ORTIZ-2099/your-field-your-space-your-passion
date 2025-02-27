document.addEventListener("DOMContentLoaded", init);

const reservation = {
  total_pay: "",
  rental_time: "",
  start_time: "",
  rental_date: "",
};
let busyHours = {};

function init() {
  selectDate();
  selectQuantityHours();
  makeReservation();
}

function makeReservation() {
  const button = document.querySelector(".button-reservation");
  button.addEventListener("click", (e) => {
    // antes de generar la reserva debemos validar que la cantidad de horas
    // sean validas, es decir que no hallan cruze de horarios
    const result = validateData();
    if (!result) return;
    getFieldId();
    getUserId();
    const data = createNewFormData();
    saveReservation(data);
  });
}

function validateData() {
  const closing_time = document.getElementById("closing_time").value;
  const { rental_time, start_time } = reservation;
  const initTime = parseInt(start_time.slice(0, 3));
  for (let i = initTime; i < initTime + parseInt(rental_time); i++) {
    if (i >= parseInt(closing_time)) {
      alert("elige una cantidad de horas menor");
      return;
    }
    let hour = i < 10 ? `0${i}:00:00` : `${i}:00:00`;
    if (busyHours[hour]) {
      alert("hay un cruce de horarios");
      return;
    }
  }
  return true;
}

function createNewFormData() {
  const data = new FormData();
  for (let key in reservation) {
    data.append(key, reservation[key]);
  }
  return data;
}

async function saveReservation(formData) {
  try {
    response = await fetch(`http://localhost:3000/api/saveReservation`, {
      method: "POST",
      body: formData,
    });
    const result = await response.json();
    console.log(result);
    if (!result.result) {
      throw new Error("error inesperado");
    }
    alert("reserva creada correctamente");
    location.reload();
  } catch (error) {
    alert("error inesperado intenta luego");
  }
}
function getUserId() {
  const userId = document.querySelector("#user-id");
  reservation.user_id = userId.value;
}

function getFieldId() {
  reservation.field_id = getIdUrlParams();
}

function selectQuantityHours() {
  const quantityHours = document.querySelector(".quantity-hours");
  quantityHours.addEventListener("input", ({ target }) => {
    if (target.value == "") {
      reservation.total_pay = "";
      reservation.rental_time = "";
      showReservationButton();
      return;
    }
    let pricePerHours = target.value.split("-");
    reservation.total_pay = parseInt(pricePerHours[0] * pricePerHours[1]);
    reservation.rental_time = pricePerHours[1];
    showReservationButton();
  });
}

function selectDate() {
  const inputDate = document.querySelector(".date");
  inputDate.addEventListener("change", ({ target }) => {
    let date = target.value;
    reservation.rental_date = date;
    reservation.start_time = "";
    showReservationButton();
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
    busyHours = await response.json();
    console.log(busyHours);
    renderViewHours(busyHours);
  } catch (error) {
    console.log(error);
    alert("ocurrio un error en el servidor, intenta luego");
  }
}

function renderViewHours(busyHours) {
  console.log(busyHours);
  // CONTINUAR AQUI
  const freeHoursContainer = document.querySelector(".free-hours-container");
  const title = document.createElement("H2");
  title.innerText = "estas son las horas disponibles de la sucursal";
  title.classList.add("title-hours");
  if (!document.querySelector(".title-hours")) {
    freeHoursContainer.insertAdjacentElement("beforebegin", title);
  }

  freeHoursContainer.innerHTML = ``;
  const hours = getHoursOpeningClose();
  let init = 0;
  while (init < hours.length) {
    if (busyHours[hours[init]]) {
      substract = subtractHours(busyHours[hours[init]], hours[init]);
      init += substract;
      continue;
    }
    const button = document.createElement("BUTTON");
    button.innerText = `${hours[init]}`;
    button.id = hours[init];
    button.addEventListener("click", selectHour);
    freeHoursContainer.appendChild(button);
    init++;
  }
}

function getHoursOpeningClose() {
  const openingHours = document.getElementById("opening_hours").value;
  const closing_time = document.getElementById("closing_time").value;
  const hours = [];
  for (let i = parseInt(openingHours); i < parseInt(closing_time); i++) {
    let insert = i < 10 ? `0${i}:00:00` : `${i}:00:00`;
    hours.push(insert);
  }
  return hours;
}

function selectHour({ target }) {
  reservation.start_time = target.id;
  const buttonSelected = document.querySelector(".select-hour");
  if (buttonSelected) {
    if (target.id == buttonSelected.id) {
      buttonSelected.classList.remove("select-hour");
      reservation.start_time = "";
    } else {
      buttonSelected.classList.remove("select-hour");
      target.classList.add("select-hour");
    }
  } else {
    target.classList.add("select-hour");
  }
  showReservationButton();
}

function getIdUrlParams() {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const id = urlParams.get("id");
  return id;
}

function subtractHours(horaFinal, horaInicio) {
  //console.log(horaFinal, horaInicio);
  const convertirASegundos = (hora) => {
    const partes = hora.split(":");
    return (
      parseInt(partes[0], 10) * 3600 +
      parseInt(partes[1], 10) * 60 +
      parseInt(partes[2], 10)
    );
  };
  const segundosFinal = convertirASegundos(horaFinal);
  const segundosInicio = convertirASegundos(horaInicio);
  const diferencia = segundosFinal - segundosInicio;

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

function showReservationButton() {
  const button = document.querySelector(".button-reservation");
  for (let key in reservation) {
    if (!reservation[key]) {
      button.classList.add("hidden");
      return;
    }
  }
  button.classList.remove("hidden");
}
