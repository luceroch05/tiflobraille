(function ($) {
  'use strict';

  /* ========================================================================= */
  /*	Page Preloader
  /* ========================================================================= */

  // window.load = function () {
  // 	document.getElementById('preloader').style.display = 'none';
  // }

  $(window).on('load', function () {
    $('#preloader').fadeOut('slow', function () {
      $(this).remove();
    });
  });

  
  $(document).ready(function () {
    // Hero Slider
    $('.hero-slider').slick({
      autoplay: true,
      infinite: true,
      arrows: true,
      prevArrow: '<button type="button" class="prevArrow"></button>',
      nextArrow: '<button type="button" class="nextArrow"></button>',
      dots: false,
      autoplaySpeed: 7000,
      pauseOnFocus: false,
      pauseOnHover: false
    });
  
    // Solo si estás usando slick-animation.js
    if ($.fn.slickAnimation) {
      $('.hero-slider').slickAnimation();
    }
  });
  
  $(document).ready(function () {
    $('.client-carousel').slick({
      slidesToShow: 5,
      slidesToScroll: 1,
      autoplay: true,
      speed: 4000,               // Más lento = más suave
      autoplaySpeed: 0,          // 0 = sin espera entre scrolls
      cssEase: 'linear',         // Animación constante y suave
      arrows: false,
      dots: false,
      infinite: true,
      fade: false,               // 🔥 IMPORTANTE: desactiva el efecto fade
      pauseOnHover: false,
      pauseOnFocus: false,
      responsive: [
        {
          breakpoint: 1200,
          settings: { slidesToShow: 4 }
        },
        {
          breakpoint: 992,
          settings: { slidesToShow: 3 }
        },
        {
          breakpoint: 768,
          settings: { slidesToShow: 2 }
        },
        {
          breakpoint: 576,
          settings: { slidesToShow: 1 }
        }
      ]
    });
  });


  /* ========================================================================= */
  /*	Header Scroll Background Change
  /* ========================================================================= */

  $(window).scroll(function () {
    var scroll = $(window).scrollTop();
    //console.log(scroll);
    if (scroll > 200) {
      //console.log('a');
      $('.navigation').addClass('sticky-header');
    } else {
      //console.log('a');
      $('.navigation').removeClass('sticky-header');
    }
  });

  /* ========================================================================= */
  /*	Portfolio Filtering Hook
  /* =========================================================================  */

    // filter
    setTimeout(function(){
      var containerEl = document.querySelector('.filtr-container');
      var filterizd;
      if (containerEl) {
        filterizd = $('.filtr-container').filterizr({});
      }
    }, 500);

  /* ========================================================================= */
  /*	Testimonial Carousel
  /* =========================================================================  */

  //Init the slider
  $('.testimonial-slider').slick({
    infinite: true,
    arrows: false,
    autoplay: true,
    autoplaySpeed: 2000
  });


  /* ========================================================================= */
  /*	Clients Slider Carousel
  /* =========================================================================  */

  //Init the slider
  $('.clients-logo-slider').slick({
    infinite: true,
    arrows: false,
    autoplay: true,
    autoplaySpeed: 2000,
    slidesToShow: 5,
    slidesToScroll: 1
  });




  /* ========================================================================= */
  /*	Company Slider Carousel
  /* =========================================================================  */
  $('.company-gallery').slick({
    infinite: true,
    arrows: false,
    autoplay: true,
    autoplaySpeed: 2000,
    slidesToShow: 5,
    slidesToScroll: 1
  });


  /* ========================================================================= */
  /*   Contact Form Validating
  /* ========================================================================= */

  $('#contact-form').validate({
      rules: {
        name: {
          required: true,
          minlength: 4
        },
        email: {
          required: true,
          email: true
        },
        subject: {
          required: false
        },
        message: {
          required: true
        }
      },
      messages: {
        user_name: {
          required: 'Come on, you have a name don\'t you?',
          minlength: 'Your name must consist of at least 2 characters'
        },
        email: {
          required: 'Please put your email address'
        },
        message: {
          required: 'Put some messages here?',
          minlength: 'Your name must consist of at least 2 characters'
        }
      },
      submitHandler: function (form) {
        $(form).ajaxSubmit({
          type: 'POST',
          data: $(form).serialize(),
          url: 'sendmail.php',
          success: function () {
            $('#contact-form #success').fadeIn();
          },
          error: function () {
            $('#contact-form #error').fadeIn();
          }
        });
      }
    }

  );

  /* ========================================================================= */
  /*	On scroll fade/bounce effect
  /* ========================================================================= */
  var scroll = new SmoothScroll('a[href*="#"]');

  // -----------------------------
  //  Count Up
  // -----------------------------
  function counter() {
    if ($('.counter').length !== 0) {
      var oTop = $('.counter').offset().top - window.innerHeight;
    }
    if ($(window).scrollTop() > oTop) {
      $('.counter').each(function () {
        var $this = $(this),
          countTo = $this.attr('data-count');
        $({
          countNum: $this.text()
        }).animate({
          countNum: countTo
        }, {
          duration: 1000,
          easing: 'swing',
          step: function () {
            $this.text(Math.floor(this.countNum));
          },
          complete: function () {
            $this.text(this.countNum);
          }
        });
      });
    }
  }
  // -----------------------------
  //  On Scroll
  // -----------------------------
  $(window).scroll(function () {
    counter();
  });

})(jQuery);

document.addEventListener('DOMContentLoaded', function() {
  // Array de imágenes de proyectos
  const projectImages = [
    'images/projects/foto4.jpg',
    'images/projects/foto2.jpg',
    'images/projects/foto1.jpg',
    'images/projects/foto5.jpg',
    'images/projects/foto3.jpg',
    'images/projects/foto6.jpg'
  ];
  
  // Elementos del DOM
  const modal = document.getElementById('projectModal');
  const modalImage = document.getElementById('modalImage');
  const closeBtn = document.querySelector('.modal-close');
  const prevBtn = document.getElementById('prevProject');
  const nextBtn = document.getElementById('nextProject');
  const projectItems = document.querySelectorAll('.project-item');
  
  let currentIndex = 0;
  let isModalOpen = false;
  
  // Función para abrir el modal
  function openModal(index) {
    if (isModalOpen) return;
    
    currentIndex = index;
    isModalOpen = true;
    
    // Configurar imagen
    modalImage.src = projectImages[index];
    modalImage.alt = `Proyecto ${index + 1} - Vista completa`;
    
    // Mostrar modal
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    // Activar con delay para animación
    requestAnimationFrame(() => {
      modal.classList.add('active');
    });
  }
  
  // Función para cerrar el modal
  function closeModal() {
    if (!isModalOpen) return;
    
    modal.classList.remove('active');
    
    // Esperar animación antes de ocultar
    setTimeout(() => {
      modal.style.display = 'none';
      document.body.style.overflow = 'auto';
      isModalOpen = false;
    }, 300);
  }
  
  // Función para navegar entre proyectos
  function navigateProject(direction) {
    if (!isModalOpen) return;
    
    // Calcular nuevo índice
    if (direction === 'prev') {
      currentIndex = (currentIndex - 1 + projectImages.length) % projectImages.length;
    } else if (direction === 'next') {
      currentIndex = (currentIndex + 1) % projectImages.length;
    }
    
    // Efecto de transición suave
    modalImage.style.opacity = '0';
    
    setTimeout(() => {
      modalImage.src = projectImages[currentIndex];
      modalImage.alt = `Proyecto ${currentIndex + 1} - Vista completa`;
      modalImage.style.opacity = '1';
    }, 150);
  }
  
  // Event listeners para abrir modal
  projectItems.forEach((item, index) => {
    // Click en el proyecto
    item.addEventListener('click', () => openModal(index));
    
    // Soporte para teclado (accesibilidad)
    item.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        openModal(index);
      }
    });
    
    // Hacer los items focusables
    item.setAttribute('tabindex', '0');
  });
  
  // Event listeners para controles del modal
  if (closeBtn) {
    closeBtn.addEventListener('click', closeModal);
  }
  
  if (prevBtn) {
    prevBtn.addEventListener('click', () => navigateProject('prev'));
  }
  
  if (nextBtn) {
    nextBtn.addEventListener('click', () => navigateProject('next'));
  }
  
  // Cerrar modal al hacer clic en el fondo
  modal.addEventListener('click', function(e) {
    if (e.target === modal) {
      closeModal();
    }
  });
  
  // Controles de teclado
  document.addEventListener('keydown', function(e) {
    if (!isModalOpen) return;
    
    switch(e.key) {
      case 'Escape':
        closeModal();
        break;
      case 'ArrowLeft':
        e.preventDefault();
        navigateProject('prev');
        break;
      case 'ArrowRight':
        e.preventDefault();
        navigateProject('next');
        break;
    }
  });
  
  // Soporte para gestos táctiles (swipe)
  let startX = 0;
  let startY = 0;
  let endX = 0;
  let endY = 0;
  
  modalImage.addEventListener('touchstart', function(e) {
    startX = e.touches[0].clientX;
    startY = e.touches[0].clientY;
  }, { passive: true });
  
  modalImage.addEventListener('touchmove', function(e) {
    e.preventDefault(); // Prevenir scroll
  }, { passive: false });
  
  modalImage.addEventListener('touchend', function(e) {
    endX = e.changedTouches[0].clientX;
    endY = e.changedTouches[0].clientY;
    
    const diffX = startX - endX;
    const diffY = startY - endY;
    const absDiffX = Math.abs(diffX);
    const absDiffY = Math.abs(diffY);
    
    // Solo procesar swipes horizontales significativos
    if (absDiffX > absDiffY && absDiffX > 50) {
      if (diffX > 0) {
        navigateProject('next'); // Swipe izquierda = siguiente
      } else {
        navigateProject('prev'); // Swipe derecha = anterior
      }
    }
    
    // Reset valores
    startX = 0;
    startY = 0;
    endX = 0;
    endY = 0;
  }, { passive: true });
  
  // Prevenir el zoom con doble tap en la imagen del modal
  let lastTouchEnd = 0;
  modalImage.addEventListener('touchend', function(e) {
    const now = (new Date()).getTime();
    if (now - lastTouchEnd <= 300) {
      e.preventDefault();
    }
    lastTouchEnd = now;
  }, { passive: false });
  
  // Optimización: precargar la siguiente imagen
  function preloadNextImage() {
    if (!isModalOpen) return;
    
    const nextIndex = (currentIndex + 1) % projectImages.length;
    const prevIndex = (currentIndex - 1 + projectImages.length) % projectImages.length;
    
    // Precargar siguiente y anterior
    [nextIndex, prevIndex].forEach(index => {
      const img = new Image();
      img.src = projectImages[index];
    });
  }
  
  // Precargar cuando se abre el modal
  modal.addEventListener('transitionend', function() {
    if (modal.classList.contains('active')) {
      preloadNextImage();
    }
  });
  
  // Manejo de errores de carga de imágenes
  modalImage.addEventListener('error', function() {
    console.warn(`Error cargando imagen: ${this.src}`);
    // Aquí podrías mostrar una imagen de placeholder si quieres
  });
  
  // Accesibilidad: anunciar cambios de imagen para lectores de pantalla
  modalImage.addEventListener('load', function() {
    if (isModalOpen) {
      // Crear mensaje para lectores de pantalla
      const announcement = document.createElement('div');
      announcement.setAttribute('aria-live', 'polite');
      announcement.setAttribute('aria-atomic', 'true');
      announcement.className = 'sr-only';
      announcement.textContent = `Proyecto ${currentIndex + 1} de ${projectImages.length}`;
      
      // Agregar temporalmente al DOM
      document.body.appendChild(announcement);
      setTimeout(() => {
        document.body.removeChild(announcement);
      }, 1000);
    }
  });
  
  console.log('Sistema de proyectos inicializado correctamente');
});

