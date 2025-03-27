const menuHidden = document.querySelector(".menu-hidden");
const navbarMovil = document.querySelector(".navbar-movil");

// tambien deberiamos corroborar si al manipular las dimensiones de la pantalla
// ya estamos en modo escritorio, si es asi deberiamos agregar la clase navbar-movil si previamente no la tenia, esto con el fin de que al pasar
// nuevamente a un dispositivo movil, mantenga oculto el menu, ya que caso contrario lo mantendria activo si en la interaccion anterior no se cerro el menu

menuHidden.addEventListener("click", showMenu);

function showMenu() {
  navbarMovil.classList.toggle("navbar-movil");
}

window.addEventListener("resize", () => {
  let width = window.innerWidth;
  let heigth = window.innerHeight;
  // comprobar si el ancho de pantalla es mayor o igual a 768, ese es el maximo soportado para los equipos moviles
  if (width >= 768) {
    document.querySelector(".navbar").classList.add("navbar-movil");
  }
});
