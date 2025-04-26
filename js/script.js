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
  // Datos de proyectos
  const projects = [
    {
      id: 1,
      image: 'images/portfolio/portfolio-1.jpg',
      title: 'Accesibilidad urbana',
      description: 'Implementación de rampas, elevadores y señalización especial para personas con movilidad reducida en espacios públicos.'
    },
    {
      id: 2,
      image: 'images/portfolio/portfolio-2.jpg',
      title: 'Inclusión digital',
      description: 'Desarrollo de plataformas digitales accesibles con opciones para personas con discapacidad visual y auditiva.'
    },
    {
      id: 3,
      image: 'images/portfolio/portfolio-3.jpg',
      title: 'Movilidad sostenible',
      description: 'Soluciones de transporte público inclusivo con espacios adaptados y señalización para todas las personas.'
    },
    {
      id: 4,
      image: 'images/portfolio/portfolio-4.jpg',
      title: 'Tecnología adaptativa',
      description: 'Dispositivos especializados que mejoran la calidad de vida de personas con diferentes tipos de discapacidad.'
    },
    {
      id: 5,
      image: 'images/portfolio/portfolio-5.jpg',
      title: 'Espacios inclusivos',
      description: 'Diseño universal que permite a todas las personas disfrutar de espacios públicos y privados sin barreras.'
    },
    {
      id: 6,
      image: 'images/portfolio/portfolio-6.jpg',
      title: 'Comunicación accesible',
      description: 'Materiales informativos y educativos en múltiples formatos: braille, lengua de señas, audioguías y más.'
    }
  ];
  
  // Elementos del DOM
  const modal = document.getElementById('projectModal');
  const modalImage = document.getElementById('modalImage');
  const modalTitle = document.getElementById('modalTitle');
  const modalDescription = document.getElementById('modalDescription');
  const closeBtn = document.querySelector('.modal-close');
  const prevBtn = document.getElementById('prevProject');
  const nextBtn = document.getElementById('nextProject');
  const projectItems = document.querySelectorAll('.project-item');
  
  // Variable para mantener el índice actual
  let currentIndex = 0;
  
  // Función para abrir el modal
  function openModal(index) {
    currentIndex = index;
    const project = projects[index];
    
    modalImage.src = project.image;
    modalTitle.textContent = project.title;
    modalDescription.textContent = project.description;
    
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden'; // Evitar scroll
    
    // Efecto de animación
    modalImage.classList.add('fade-in');
    setTimeout(() => {
      modalImage.classList.remove('fade-in');
    }, 500);
  }
  
  // Función para cerrar el modal
  function closeModal() {
    modal.style.display = 'none';
    document.body.style.overflow = 'auto'; // Restaurar scroll
  }
  
  // Navegación entre proyectos
  function prevProject() {
    currentIndex = (currentIndex - 1 + projects.length) % projects.length;
    openModal(currentIndex);
  }
  
  function nextProject() {
    currentIndex = (currentIndex + 1) % projects.length;
    openModal(currentIndex);
  }
  
  // Asignar eventos
  projectItems.forEach((item, index) => {
    item.addEventListener('click', () => openModal(index));
  });
  
  closeBtn.addEventListener('click', closeModal);
  
  prevBtn.addEventListener('click', prevProject);
  nextBtn.addEventListener('click', nextProject);
  
  // Cerrar modal al hacer clic fuera de la imagen
  modal.addEventListener('click', function(e) {
    if (e.target === modal) {
      closeModal();
    }
  });
  
  // Manejar eventos de teclado
  document.addEventListener('keydown', function(e) {
    if (modal.style.display === 'block') {
      if (e.key === 'Escape') {
        closeModal();
      } else if (e.key === 'ArrowLeft') {
        prevProject();
      } else if (e.key === 'ArrowRight') {
        nextProject();
      }
    }
  });
});


