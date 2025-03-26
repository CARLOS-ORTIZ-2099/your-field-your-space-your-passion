document.addEventListener("DOMContentLoaded", init);

let count = 0;
const parameters = { type: "", district: "", previous: false };
const filtrar = document.querySelector(".filtrar");
const limpiar = document.querySelector(".limpiar");
const type = document.querySelector(".type");
const district = document.querySelector(".district");
const select = document.querySelectorAll(".select");
const fieldsContainer = document.querySelector(".fields-container");

function init() {
  callApi();
  filterHandler();
  showButtons();
}

async function callApi(skip = 0) {
  try {
    console.log(parameters);
    let url = parameters.previous
      ? `http://localhost:3000/api/getFieldsFilters?skip=${skip}&type=${parameters.type}&district=${parameters.district}`
      : `http://localhost:3000/api/getFields?skip=${skip}`;
    const response = await fetch(url);
    //console.log(response);
    if (!response.ok == 200) throw new Error("error desconocido");
    let fields = await response.json();
    count += fields.length;
    if (count === 0 && fields.length === 0) {
      createTemplateMessage("aun no hay campos");
    }
    renderViewFields(fields);
  } catch (error) {
    console.log(error);
    createTemplateMessage("ocurrio un error en el servidor, intenta luego");
  }
}

function renderViewFields(data) {
  data.forEach((element) => {
    const article = document.createElement("ARTICLE");
    article.classList.add("field-card");
    article.innerHTML = `
  <div class="field-card-image">
    <img src=${"/uploads/" + element.image} alt="imagen del estadio">
  </div>
  <div class="field-card-content">
    <h3 class="field-card-title">${element.name}</h3>
    <div class="field-card-schedule">
      <span><strong>Apertura:</strong> ${element.opening_hours}</span>
      <span><strong>Cierre:</strong> ${element.closing_time}</span>
    </div>
    <a href="/field?id=${element.id}" class="field-card-link">Ver sucursal</a>
  </div>
`;
    fieldsContainer.appendChild(article);
  });

  if (data.length === 0) {
    document.querySelector(".button-call-api")?.remove();
    return;
  }
  if (document.querySelector(".button-call-api")) return;
  const button = document.createElement("BUTTON");
  button.classList.add("button-call-api");
  button.innerText = "see more";
  button.addEventListener("click", () => callApi(count));
  fieldsContainer.insertAdjacentElement("afterend", button);
}

function createTemplateMessage(message) {
  const div = document.createElement("DIV");
  div.classList.add("message-empty");
  div.innerHTML = `
     <h2>${message}</h2>
  `;
  if (!document.querySelector(".message-empty")) {
    fieldsContainer.insertAdjacentElement("afterend", div);
  }
}

function showButtons() {
  select.forEach((element) => {
    element.addEventListener("input", (e) => {
      if (type.value !== "" || district.value !== "") {
        disabledButtons(false);
      } else {
        disabledButtons(true);
      }
    });
  });
}

function filterHandler() {
  const formSubmit = document.querySelector(".form");
  formSubmit.addEventListener("submit", (e) => {
    e.preventDefault();
    const action = e.submitter.value;
    if (action === "limpiar") {
      // si no existe una llamada previas entonces solo limpiar
      if (!parameters.previous) {
        disabledButtons(true, true);
      } else {
        disabledButtons(true, true);
        setearParameters("", "", false);
        callApi();
      }
    }
    //caso contrario llamamos a la api pero con los parametros
    else {
      setearParameters(district.value, type.value, true);
      callApi();
    }
  });
}

function disabledButtons(boolean, cb = false) {
  if (cb) select.forEach((element) => (element.value = ""));
  filtrar.disabled = boolean;
  limpiar.disabled = boolean;
}
function setearParameters(district, type, pre) {
  document.querySelector(".message-empty")?.remove();
  fieldsContainer.innerHTML = "";
  count = 0;
  parameters.district = district;
  parameters.type = type;
  parameters.previous = pre;
}
