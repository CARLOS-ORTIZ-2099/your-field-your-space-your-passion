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
  isEditMode();
}

function isEditMode() {
  const edit = getUrlParams("edit");
  if (edit) {
    const inputDate = document.querySelector(".date");
    const quantityHours = document.querySelector(".quantity-hours");
    let pricePerHours = quantityHours.value.split("-");
    reservation.rental_date = inputDate.value;
    reservation.total_pay = parseInt(pricePerHours[0] * pricePerHours[1]);
    reservation.rental_time = pricePerHours[1];
    callApi(reservation.rental_date);
  }
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
  /*  console.log(reservation);
  console.log(busyHours); */
  const initTime = parseInt(start_time.slice(0, 3));
  for (let i = initTime; i < initTime + parseInt(rental_time); i++) {
    if (i >= parseInt(closing_time)) {
      alert("elige una cantidad de horas menor");
      return;
    }
    let hour = i < 10 ? `0${i}:00:00` : `${i}:00:00`;
    if (checkHours(busyHours, hour)) {
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
  console.log(reservation);
  // aqui corroborar si estamos en modo edicion o creacion
  const edit = getUrlParams("edit");
  const url = edit
    ? `http://localhost:3000/api/updateReservation?id=${edit}`
    : `http://localhost:3000/api/saveReservation`;
  try {
    response = await fetch(url, {
      method: "POST",
      body: formData,
    });
    const result = await response.json();
    console.log(result);
    if (!result.result) {
      throw new Error("error inesperado");
    }
    alert(
      edit ? "reserva editada correctamente" : "reserva creada correctamente"
    );
    if (edit) {
      location.replace("http://localhost:3000/profile/my-reservations");
    } else {
      location.reload();
    }
  } catch (error) {
    alert("error inesperado intenta luego");
  }
}

function getUserId() {
  const userId = document.querySelector("#user-id");
  reservation.user_id = userId.value;
}

function getFieldId() {
  reservation.field_id = getUrlParams("id");
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
  const id = getUrlParams("id");
  const edit = getUrlParams("edit");
  try {
    let url = `http://localhost:3000/api/getReservations?date=${date}&field=${id}`;
    if (edit) {
      url += `&edit=${edit}`;
    }
    console.log(url);
    const response = await fetch(url);
    //console.log(response);
    if (!response.ok == 200) throw new Error("error desconocido");
    busyHours = await response.json();
    //console.log(busyHours);
    renderViewHours(busyHours);
  } catch (error) {
    console.log(error);
    alert("ocurrio un error en el servidor, intenta luego");
  }
}

function renderViewHours(busyHours) {
  console.log(busyHours);
  const freeHoursContainer = document.querySelector(".free-hours-container");
  const title = document.createElement("H2");
  title.classList.add("title-hours");

  freeHoursContainer.innerHTML = ``;
  const hours = getHoursOpeningClose();
  console.log(hours);
  let init = 0;
  while (init < hours.length) {
    const result = checkHours(busyHours, hours[init]);
    //console.log(result);
    if (result) {
      const buttonDisabled = document.createElement("BUTTON");
      buttonDisabled.disabled = true;
      buttonDisabled.classList.add("button-disabled");
      buttonDisabled.innerText = `${hours[init]}`;
      buttonDisabled.id = hours[init];
      freeHoursContainer.appendChild(buttonDisabled);
      init++;
      continue;
    }
    const button = document.createElement("BUTTON");
    button.innerText = `${hours[init]}`;
    button.id = hours[init];
    button.addEventListener("click", selectHour);
    freeHoursContainer.appendChild(button);
    init++;
  }
  if (!document.querySelector(".title-hours")) {
    freeHoursContainer.insertAdjacentElement("beforebegin", title);
  }
  if (freeHoursContainer.childElementCount === 0) {
    document.querySelector(".title-hours").innerText =
      "no hay horas disponibles";
  } else {
    document.querySelector(".title-hours").innerText =
      "estas son las horas disponibles de la sucursal";
  }
}

function checkHours(busyHours, hour) {
  let hourText = hour.slice(0, 2);
  for (let key in busyHours) {
    let keyText = key.slice(0, 2);
    let valueText = busyHours[key].slice(0, 2);
    if (parseInt(hourText) >= keyText && parseInt(hourText) < valueText) {
      return true;
    }
  }
  return false;
}

function getHoursOpeningClose() {
  let openingHours = document.getElementById("opening_hours").value;
  let closing_time = document.getElementById("closing_time").value;

  let fullDate = getFullDate();
  if (fullDate === reservation.rental_date) {
    const hourCurrent = new Date().getHours() + 1;
    openingHours = hourCurrent;
  }
  const hours = [];
  for (let i = parseInt(openingHours); i < parseInt(closing_time); i++) {
    let insert = i < 10 ? `0${i}:00:00` : `${i}:00:00`;
    hours.push(insert);
  }
  return hours;
}

function getFullDate() {
  const today = new Date();
  const year = today.getFullYear();
  const month = String(today.getMonth() + 1).padStart(2, "0");
  const day = String(today.getDate()).padStart(2, "0");
  const fullDate = `${year}-${month}-${day}`;
  return fullDate;
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

function getUrlParams(value) {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const param = urlParams.get(value);
  return param;
}

function createTemplateMessage(message) {
  const div = document.createElement("DIV");
  div.innerHTML = `
     <h2>${message}</h2>
  `;
  fieldsContainer.appendChild(div);
}

function showReservationButton() {
  console.log(reservation);
  const button = document.querySelector(".button-reservation");
  for (let key in reservation) {
    if (!reservation[key]) {
      button.classList.add("hidden");
      return;
    }
  }
  button.classList.remove("hidden");
}
