document.addEventListener("DOMContentLoaded",init);let count=0;const parameters={type:"",district:"",previous:!1},filtrar=document.querySelector(".filtrar"),limpiar=document.querySelector(".limpiar"),type=document.querySelector(".type"),district=document.querySelector(".district"),select=document.querySelectorAll(".select"),fieldsContainer=document.querySelector(".fields-container");function init(){callApi(),filterHandler(),showButtons()}async function callApi(e=0){try{console.log(parameters);let t=parameters.previous?`http://localhost:3000/api/getFieldsFilters?skip=${e}&type=${parameters.type}&district=${parameters.district}`:`http://localhost:3000/api/getFields?skip=${e}`;const r=await fetch(t);if(200==!r.ok)throw new Error("error desconocido");let n=await r.json();count+=n.length,0===count&&0===n.length&&createTemplateMessage("aun no hay campos"),renderViewFields(n)}catch(e){console.log(e),createTemplateMessage("ocurrio un error en el servidor, intenta luego")}}function renderViewFields(e){if(e.forEach((e=>{const t=document.createElement("ARTICLE");t.classList.add("field-card"),t.innerHTML=`\n  <div class="field-card-image">\n    <img src="/build/img/estadio.webp" alt="imagen del estadio">\n  </div>\n  <div class="field-card-content">\n    <h3 class="field-card-title">${e.name}</h3>\n    <div class="field-card-schedule">\n      <span><strong>Apertura:</strong> ${e.opening_hours}</span>\n      <span><strong>Cierre:</strong> ${e.closing_time}</span>\n    </div>\n    <a href="/field?id=${e.id}" class="field-card-link">Ver sucursal</a>\n  </div>\n`,fieldsContainer.appendChild(t)})),0===e.length)return void document.querySelector(".button-call-api")?.remove();if(document.querySelector(".button-call-api"))return;const t=document.createElement("BUTTON");t.classList.add("button-call-api"),t.innerText="see more",t.addEventListener("click",(()=>callApi(count))),fieldsContainer.insertAdjacentElement("afterend",t)}function createTemplateMessage(e){const t=document.createElement("DIV");t.innerHTML=`\n     <h2>${e}</h2>\n  `,fieldsContainer.appendChild(t)}function showButtons(){select.forEach((e=>{e.addEventListener("input",(e=>{""!==type.value||""!==district.value?disabledButtons(!1):disabledButtons(!0)}))}))}function filterHandler(){document.querySelector(".form").addEventListener("submit",(e=>{e.preventDefault();"limpiar"===e.submitter.value?parameters.previous?(disabledButtons(!0,!0),setearParameters("","",!1),callApi()):disabledButtons(!0,!0):(setearParameters(district.value,type.value,!0),callApi())}))}function disabledButtons(e,t=!1){t&&select.forEach((e=>e.value="")),filtrar.disabled=e,limpiar.disabled=e}function setearParameters(e,t,r){fieldsContainer.innerHTML="",count=0,parameters.district=e,parameters.type=t,parameters.previous=r}