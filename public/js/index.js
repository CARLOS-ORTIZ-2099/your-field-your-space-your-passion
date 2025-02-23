document.addEventListener("DOMContentLoaded", init);

let count = 0;

function init() {
  callApi();
  filterHandler();
}

// llamar a la api del backend para traer los campos deportivos
async function callApi(skip = 0) {
  try {
    const response = await fetch(
      `http://localhost:3000/getFields?skip=${skip}`
    );
    console.log(response);
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
  const fieldsContainer = document.querySelector(".fields-container");
  data.forEach((element) => {
    const div = document.createElement("DIV");
    div.innerHTML = `<h3>${element.name}</h3>
      <img src="<?= 'images/estadio.webp' ?>" alt="image-estadio">
      <div>
        <span> apertura: <strong>${element.opening_hours}</strong></span>
        <span> cierre: <strong>${element.closing_time}</strong></span>
      </div>
      <a href="/field?id=<?= $field['id'] ?>">ver sucursal</a>`;
    fieldsContainer.appendChild(div);
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
  const fieldsContainer = document.querySelector(".fields-container");
  const div = document.createElement("DIV");
  div.innerHTML = `
     <h2>${message}</h2>
  `;

  fieldsContainer.appendChild(div);
}

function filterHandler() {
  const formSubmit = document.querySelector(".form");
  const type = document.querySelector(".type");
  const district = document.querySelector(".district");
  formSubmit.addEventListener("submit", (e) => {
    // aqui armar los parametros que se le pasara a la consulta
    e.preventDefault();
    // primero ver si el submiter es limpira si es asi seteamos los valores de
    //los selecteds
    const submiter = e.submitter;
    console.log(submiter);
    if (submiter.value === "limpiar") {
      type.value = "";
      district.value = "";
    }
    console.log(type.value);
    console.log(district.value);
  });
}
