const menuHidden=document.querySelector(".menu-hidden"),navbarMovil=document.querySelector(".navbar-movil");function showMenu(){navbarMovil.classList.toggle("navbar-movil")}menuHidden.addEventListener("click",showMenu),window.addEventListener("resize",(()=>{let e=window.innerWidth;window.innerHeight;e>=768&&document.querySelector(".navbar").classList.add("navbar-movil")}));