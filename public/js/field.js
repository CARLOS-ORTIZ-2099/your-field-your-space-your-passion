document.addEventListener("DOMContentLoaded", init);

function init() {
  showFreeHours();
}

function showFreeHours() {
  const inputDate = document.querySelector(".date");
  inputDate.addEventListener("change", (e) => {
    let date = e.target.value;
    console.log(date);
    callApi(date);
  });
}

async function callApi(date) {
  try {
    let url = `http://localhost:3000/api/getReservations?date=${date}`;
    const response = await fetch(url);
    //console.log(response);
    if (!response.ok == 200) throw new Error("error desconocido");
    let fields = await response.json();
    console.log(fields);
  } catch (error) {
    console.log(error);
    createTemplateMessage("ocurrio un error en el servidor, intenta luego");
  }
}
