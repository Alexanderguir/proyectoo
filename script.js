// JavaScript para la animación de revelado al hacer scroll

// Selecciona todos los elementos con la clase 'reveal'
function reveal() {
    const elements = document.querySelectorAll('.reveal');
    // Itera sobre cada elemento 'reveal'
    for (let el of elements) {
      // Obtiene la altura de la ventana del navegador
      const windowHeight = window.innerHeight;
      // Obtiene la posición superior del elemento respecto a la ventana
      const elementTop = el.getBoundingClientRect().top;
      // Define un punto de visibilidad (150px desde el borde inferior de la ventana)
      const visible = 150;
      // Si el elemento está dentro del área visible de la ventana
      if (elementTop < windowHeight - visible) {
        el.classList.add("active"); // Añade la clase 'active' para activar la animación
      } else {
        el.classList.remove("active"); // Remueve la clase 'active' si el elemento sale del área visible
      }
    }
  }
  
  // Añade el evento 'scroll' a la ventana para llamar a la función 'reveal'
  window.addEventListener("scroll", reveal);
  
  // Llama a 'reveal' una vez al cargar la página para los elementos que ya están visibles
  reveal();
  
  // JavaScript para mostrar/ocultar el botón "volver arriba"
  window.onscroll = function() {
    // Selecciona el botón de "volver arriba"
    const btnTop = document.querySelector(".btn-top");
    // Muestra el botón si el scroll vertical es mayor a 300px, de lo contrario, lo oculta
    btnTop.style.display = window.scrollY > 300 ? "block" : "none";
  };
  
  // JavaScript para el desplegable del mapa y estadísticas
  function toggleDropdown() {
    // Selecciona el contenedor del contenido desplegable
    const dropdownContent = document.getElementById('chimalhuacanDropdown');
    // Si el estilo de visualización es 'block' (visible), lo oculta; de lo contrario, lo muestra
    if (dropdownContent.style.display === 'block') {
      dropdownContent.style.display = 'none';
    } else {
      dropdownContent.style.display = 'block';
    }
  }
  
  // Script para manejar la clase 'active' en la navegación (menú principal y lateral)
  document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.header .menu a');
    const sideNavLinks = document.querySelectorAll('.cont-menu nav a');
    function setActiveLink(event) {
      // Remove 'active' from all main nav links
      navLinks.forEach(link => link.classList.remove('active'));
      // Remove 'active' from all side nav links
      sideNavLinks.forEach(link => link.classList.remove('active'));
      // Add 'active' to the clicked link
      event.target.classList.add('active');
      // Find the corresponding link in the other navigation and set it active
      const targetId = event.target.getAttribute('href');
      if (targetId) {
        // For main nav
        navLinks.forEach(link => {
          if (link.getAttribute('href') === targetId) {
            link.classList.add('active');
          }
        });
        // For side nav
        sideNavLinks.forEach(link => {
          if (link.getAttribute('href') === targetId) {
            link.classList.add('active');
          }
        });
      }
      // If it's a side nav link, also close the menu
      if (event.target.closest('.cont-menu')) {
        document.getElementById('btn-menu').checked = false;
      }
    }
    // Attach click listener to all main nav links
    navLinks.forEach(link => {
      link.addEventListener('click', setActiveLink);
    });
    // Attach click listener to all side nav links
    sideNavLinks.forEach(link => {
      link.addEventListener('click', setActiveLink);
    });
    // Set initial active link based on URL hash or default to 'welcome'
    const initialHash = window.location.hash || '#welcome';
    document.querySelector(`.header .menu a[href="${initialHash}"]`)?.classList.add('active');
    document.querySelector(`.cont-menu nav a[href="${initialHash}"]`)?.classList.add('active');
  });