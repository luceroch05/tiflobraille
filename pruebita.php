
<?php
require 'config.php';

// Obtener el slug desde la URL
if (!isset($_GET['slug'])) {
    echo "Producto no encontrado";
    exit;
}

$slug = $_GET['slug'];

$stmt = $conn->prepare("
    SELECT p.*, c.nombre AS categoria_nombre, c.slug AS categoria_slug
    FROM productos p
    JOIN categorias c ON p.categoria_id = c.id
    WHERE p.slug = ?
");
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();
$producto = $result->fetch_assoc();

if (!$producto) {
    echo "Producto no encontrado";
    exit;
}

// Obtener imágenes adicionales
$stmt_imgs = $conn->prepare("SELECT * FROM producto_imagenes WHERE producto_id = ?");
$stmt_imgs->bind_param("i", $producto['id']);
$stmt_imgs->execute();
$result_imgs = $stmt_imgs->get_result();
$imagenes = $result_imgs->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html> <!--<![endif]-->
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="description" content="Tiflobraille se especializa en accesibilidad e inclusión para personas con discapacidad visual. Ofrecemos productos didácticos, deportivos y educativos, impresoras Braille y servicios de impresión en Braille. ¡Conoce más!">

  <meta name="keywords" content="accesibilidad visual, discapacidad visual, productos Braille, impresión Braille, materiales educativos para ciegos, herramientas para baja visión, inclusión, impresoras Braille">

  <meta name="author" content="Tiflobraille">

  <title>Tiflobraille | Accesibilidad e Inclusión para Personas con Discapacidad Visual</title>



<!-- Mobile Specific Meta
  ================================================== -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
<!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon_resultado.webp">
  <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32_resultado.webp">
  <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16_resultado.webp">
  <link rel="manifest" href="images/site.webmanifest">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  
  <!-- CSS
  ================================================== -->
  <!-- Themefisher Icon font -->
  <link rel="stylesheet" href="plugins/themefisher-font/style.css">
  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
  <!-- Lightbox.min css -->
  <link rel="stylesheet" href="plugins/lightbox2/dist/css/lightbox.min.css">
  <!-- animation css -->
  <link rel="stylesheet" href="plugins/animate/animate.css">
  <!-- Slick Carousel -->
  <link rel="stylesheet" href="plugins/slick/slick.css">
  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="css/style.css"> 
  <link rel="stylesheet" href="css/accessibility.css"> 

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <!-- Estilos adicionales para productos y nueva paleta de colores -->
  <style>
  /* Carrito flotante */

    
  </style>

</head>

<body id="body">

  
	<!-- Barra de accesibilidad -->
<div class="accessibility-toolbar" id="accessibilityToolbar">
  <button class="accessibility-toolbar-toggle" id="accessibilityToggle" aria-label="Abrir herramientas de accesibilidad">
    <i class="tf-ion-eye"></i>
  </button>
  <div class="accessibility-toolbar-content">
    <h3>Opciones de Accesibilidad</h3>
    
    <div class="accessibility-option">
      <label>Contraste</label>
      <button id="darkModeToggle" aria-pressed="false">Modo Oscuro</button>
    </div>
    
    <div class="accessibility-option">
      <label>Tamaño del Texto</label>
      <button id="decreaseText" aria-label="Reducir tamaño del texto">A-</button>
      <button id="normalText" aria-label="Tamaño normal de texto">A</button>
      <button id="increaseText" aria-label="Aumentar tamaño del texto">A+</button>
    </div>
    
    <div class="accessibility-option">
      <label>Otras Opciones</label>
      <button id="highlightLinks" aria-pressed="false">Resaltar Enlaces</button>
      <button id="spacedText" aria-pressed="false">Espaciar Texto</button>
      <button id="bigCursor" aria-pressed="false">Cursor Grande</button>
    </div>
    
    <div class="accessibility-option">
      <button id="resetAccessibility" aria-label="Restablecer todas las opciones de accesibilidad">Restablecer Todo</button>
    </div>
  </div>
</div>


 <!--
  Start Preloader
  ==================================== -->
  <div id="preloader">
    <div class='preloader'>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div> 
  <!--
  End Preloader
  ==================================== -->


  

<!--
Fixed Navigation
==================================== -->
<header class="navigation fixed-top">
  <div class="container">
    <!-- main nav -->
    <nav class="navbar navbar-expand-lg navbar-light">
       <!-- logo -->
       <a class="navbar-brand logo" href="index.html">
         <!-- Logo aquí -->
          <img src="images/logitofinal-nav_resultado.webp" alt="Tiflobraille Logo" class="img-fluid">
       </a>
     
      <!-- /logo -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
        aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navigation">
        <ul class="navbar-nav ml-auto text-center">
          <li class="nav-item ">
            <a class="nav-link" href="index.html">Inicio</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="about.html">Nosotros</a>
          </li>
          <li class="nav-item  active ">
            <a class="nav-link" href="product.html">Productos</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="service.html">Servicios</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="support.html">Soporte Técnico</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="contact.html">Contacto</a>
          </li>
          
        
        </ul>
      </div>
    </nav>
    <!-- /main nav -->
  </div>
</header>


<!--
End Fixed Navigation
==================================== -->

<section class="single-page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2>Productos</h2>
			</div>
		</div>
	</div>
</section>

<!-- 
  INICIO DE SECCIÓN DE PRODUCTOS
  ====================================== -->
  <section class="section-products">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="title text-center">
            <h2>Descubre nuestros productos</h2>
            <p>Productos diseñados para personas con discapacidad visual, mejorando su accesibilidad y autonomía</p>
            <div class="border"></div>
          </div>
        </div>
      </div>
      
      <!-- Filtro de categorías -->
      <div class="product-filter">
        <button class="btn active" data-filter="all">Todos los Productos</button>
        <button class="btn" data-filter="educativo">Educativo</button>
        <button class="btn" data-filter="deportivo">Deportivo y Recreativo</button>
        <button class="btn" data-filter="salud">Salud</button>
        <button class="btn" data-filter="tecnologia">Tecnología</button>
        <button class="btn" data-filter="impresoras">Impresoras</button>
      </div>
      
       
<div class="product-detail">
    <div class="product-images">
        <img src="<?= htmlspecialchars($producto['imagen_principal']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
        <?php foreach ($imagenes as $img): ?>
            <img src="<?= htmlspecialchars($img['ruta_imagen']) ?>" alt="<?= htmlspecialchars($img['alt_text']) ?>">
        <?php endforeach; ?>
    </div>

    <div class="product-info">
        <h1><?= htmlspecialchars($producto['nombre']) ?></h1>
        <p class="categoria">Categoría: <?= htmlspecialchars($producto['categoria_nombre']) ?></p>
        <p class="descripcion-corta"><?= htmlspecialchars($producto['descripcion_corta']) ?></p>
        <div class="descripcion-larga"><?= nl2br(htmlspecialchars($producto['descripcion_larga'])) ?></div>

        <button class="add-to-cart-btn"
            data-product-id="<?= htmlspecialchars($producto['slug']) ?>"
            data-product-name="<?= htmlspecialchars($producto['nombre']) ?>"
            data-product-image="<?= htmlspecialchars($producto['imagen_principal']) ?>">
            <i class="fas fa-plus"></i>
            Agregar a Cotización
        </button>
    </div>
</div>
    </div>
  </section>




  <footer id="footer" class="bg-one">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="footer-about">
            <h3>Tiflobraille</h3>
            <p>Somos una empresa especializada en soluciones de accesibilidad para personas con discapacidad visual, comprometidos con la inclusión y la autonomía.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="footer-social">
            <h3>Síguenos</h3>
            <div class="social-icons">
			  <a href="https://www.facebook.com/TIFLOPERU" class="social-icon" target="_blank"><i class="fab fa-facebook-f"></i></a>
			  <a href="https://www.instagram.com/tiflobra/" class="social-icon" target="_blank"><i class="fab fa-instagram"></i></a>
			  <a href="https://www.tiktok.com/@tiflobraille" class="social-icon" target="_blank"><i class="fab fa-tiktok"></i></a>
			  <a href="https://www.youtube.com/@Tiflobra" class="social-icon" target="_blank"><i class="fab fa-youtube"></i></a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="footer-contact">
            <h3>Contacto</h3>
            <p>Email: ventas@tiflobraperu.com</p>
            <p>Teléfono: +51 979 783 905</p>
          </div>
        </div>
      </div>
    
    </div>
  </footer>

  <!-- Carrito flotante -->
    <div class="cart-float">
        <button class="cart-button" id="cartButton">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-count" id="cartCount">0</span>
        </button>
    </div>

   

   
    <!-- Modal del carrito -->
    <div id="cartModal" class="cart-modal">
        <div class="cart-modal-content">
            <div class="cart-header">
                <h3><i class="fas fa-shopping-cart"></i> Mi Cotización</h3>
                <button class="close-cart" id="closeCart">&times;</button>
            </div>
            <div class="cart-body" id="cartBody">
                <div class="cart-empty">
                    <i class="fas fa-shopping-cart"></i>
                    <h4>Tu cotización está vacía</h4>
                    <p>Agrega productos para solicitar una cotización</p>
                </div>
            </div>
            <div class="cart-footer" id="cartFooter" style="display: none;">
                <div class="cart-total" id="cartTotal">
                    Total de productos: 0
                </div>
                <button class="quote-btn" id="quoteBtn">
                    <i class="fab fa-whatsapp"></i>
                    Solicitar Cotización por WhatsApp
                </button>
            </div>
        </div>
    </div>
    <!-- end Footer Area
    ========================================== -->



    <!-- 
    Essential Scripts
    =====================================-->
    <!-- Main jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu5nZKbeK-WHQ70oqOWo-_4VmwOwKP9YQ"></script>
    <script  src="plugins/google-map/gmap.js"></script>

    <!-- Form Validation -->
    <script src="plugins/form-validation/jquery.form.js"></script> 
    <script src="plugins/form-validation/jquery.validate.min.js"></script>
    
    <!-- Bootstrap4 -->
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- Parallax -->
    <script src="plugins/parallax/jquery.parallax-1.1.3.js"></script>
    <!-- lightbox -->
    <script src="plugins/lightbox2/dist/js/lightbox.min.js"></script>
    <!-- Owl Carousel -->
    <script src="plugins/slick/slick.min.js"></script>
    <!-- filter -->
    <script src="plugins/filterizr/jquery.filterizr.min.js"></script>
    <!-- Smooth Scroll js -->
    <script src="plugins/smooth-scroll/smooth-scroll.min.js"></script>
    
    <!-- Custom js -->
    <script src="js/script.js"></script>
    <script src="js/accessibility.js"></script>


   <!-- Script para el filtrado de productos -->
<script>
// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
  console.log("DOM cargado - Inicializando filtros y modales");
  
  // ===== FILTRADO DE PRODUCTOS =====
  const filterButtons = document.querySelectorAll('.product-filter .btn');
  const productItems = document.querySelectorAll('.product-gallery .product-item');
  
  // Función para manejar el filtrado
  function filterProducts(category) {
    console.log("Filtrando por:", category);
    
    productItems.forEach(function(item) {
      if (category === 'all') {
        // Mostrar todos los productos
        item.style.display = 'block';
      } else {
        // Comprobar si el elemento tiene la clase de la categoría
        if (item.classList.contains(category)) {
          item.style.display = 'block';
        } else {
          item.style.display = 'none';
        }
      }
    });
  }
  
  // Añadir eventos de clic a todos los botones de filtro
  filterButtons.forEach(function(button) {
    button.addEventListener('click', function() {
      // Quitar clase activa de todos los botones
      filterButtons.forEach(btn => btn.classList.remove('active'));
      
      // Añadir clase activa al botón clickeado
      this.classList.add('active');
      
      // Filtrar productos según la categoría seleccionada
      const filterValue = this.getAttribute('data-filter');
      filterProducts(filterValue);
    });
  });
  
  // Activar el filtro "Todos" por defecto
  document.querySelector('.product-filter .btn[data-filter="all"]').classList.add('active');
  filterProducts('all');

  // ===== MANEJO DE MODALES =====
const modals = document.querySelectorAll('.modal');
const closeButtons = document.querySelectorAll('.close-modal');

// Función para abrir el modal - CORREGIDA
function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.style.display = 'block';
    document.body.classList.add('modal-open');
  }
}

// Función para cerrar el modal - CORREGIDA
function closeModal(modal) {
  modal.style.display = 'none';
  document.body.classList.remove('modal-open');
}

// Abrir modal SOLO al hacer clic en la IMAGEN del producto
const productImages = document.querySelectorAll('.product-item .product-thumb img');
productImages.forEach(img => {
  img.addEventListener('click', function(e) {
    e.stopPropagation(); // Evitar que se propague el evento
    const productItem = this.closest('.product-item');
    const productId = productItem.getAttribute('data-id');
    openModal('modal-' + productId);
  });
});

// Evento específico para botones "Ver detalles"
document.querySelectorAll('.ver-mas').forEach(button => {
  button.addEventListener('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    const productItem2 = this.closest('.product-item');
    const productId = productItem2.getAttribute('data-id');
    openModal('modal-' + productId);
  });
});

// Cerrar modal con el botón X
closeButtons.forEach(button => {
  button.addEventListener('click', function() {
    closeModal(this.closest('.modal'));
  });
});

// Cerrar modal haciendo clic fuera del contenido
window.addEventListener('click', function(e) {
  modals.forEach(modal => {
    if (e.target === modal) {
      closeModal(modal);
    }
  });
});

// ===== CORRECCIÓN DE ESTILOS PARA LISTAS EN MODAL =====
const modalInfoLists = document.querySelectorAll('.modal-info ul');

modalInfoLists.forEach(list => {
  // Asegurar que las listas tengan el estilo adecuado
  list.style.display = 'block';
  list.style.listStyleType = 'disc';
  list.style.paddingLeft = '20px';
  
  // Asegurar que los elementos de lista se muestren correctamente
  const listItems = list.querySelectorAll('li');
  listItems.forEach(item => {
    item.style.display = 'list-item';
    item.style.marginBottom = '8px';
  });
});

// Añadir tecla Escape para cerrar modal
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    const openModal = document.querySelector('.modal[style="display: block;"]');
    if (openModal) {
      closeModal(openModal);
    }
  }
});

  
});
// ===== GALERÍA DE IMÁGENES EN MODALES (VERSIÓN DEPURADA) =====
document.addEventListener('DOMContentLoaded', function() {
  console.log('DOM cargado, iniciando código de galería');
  
  const modalsWithGallery = document.querySelectorAll('.modal');
  console.log(`Encontrados ${modalsWithGallery.length} modales`);

  modalsWithGallery.forEach((modal, modalIndex) => {
    console.log(`Configurando modal #${modalIndex}`);
    
    // Miniaturas
    const thumbs = modal.querySelectorAll('.gallery-thumb');
    const mainImg = modal.querySelector('.gallery-main img');
    
    console.log(`Modal #${modalIndex}: ${thumbs.length} miniaturas encontradas`);
    console.log(`Modal #${modalIndex}: Imagen principal encontrada: ${mainImg ? 'Sí' : 'No'}`);
    
    if (!thumbs.length || !mainImg) {
      console.log(`Modal #${modalIndex}: No hay galería completa, saltando.`);
      return; // Si no hay galería, no hacer nada
    }
    
    // Flechas de navegación
    const prevArrow = modal.querySelector('.gallery-arrow.prev');
    const nextArrow = modal.querySelector('.gallery-arrow.next');
    
    console.log(`Modal #${modalIndex}: Flecha previa encontrada: ${prevArrow ? 'Sí' : 'No'}`);
    console.log(`Modal #${modalIndex}: Flecha siguiente encontrada: ${nextArrow ? 'Sí' : 'No'}`);
    
    // Variable para rastrear el índice actual
    let currentIndex = 0;
    
    // Función para actualizar la imagen principal
    function updateMainImage(index) {
      console.log(`Actualizando a imagen: ${index}`);
      
      // Asegura que el índice esté en el rango
      if (index < 0 || index >= thumbs.length) {
        console.error(`Índice fuera de rango: ${index}`);
        return;
      }
      
      // Quita la clase active de todas las miniaturas
      thumbs.forEach((t, i) => {
        t.classList.remove('active');
        console.log(`Quitando 'active' de miniatura ${i}`);
      });
      
      // Añade la clase active a la miniatura actual
      thumbs[index].classList.add('active');
      console.log(`Añadiendo 'active' a miniatura ${index}`);
      
      // Obtiene la URL de la imagen desde la miniatura
      const selectedThumb = thumbs[index];
      const imgSrc = selectedThumb.getAttribute('data-img');
      console.log(`Imagen seleccionada URL: "${imgSrc}"`);
      
      if (!imgSrc) {
        console.error('¡Error! data-img está vacío o no existe');
        
        // Plan B: intentar obtener la URL directamente de la miniatura img
        const thumbImg = selectedThumb.querySelector('img');
        if (thumbImg) {
          const thumbSrc = thumbImg.getAttribute('src');
          console.log(`Usando src de imagen miniatura: "${thumbSrc}"`);
          mainImg.src = thumbSrc;
        }
      } else {
        // Actualiza la imagen principal
        console.log(`Cambiando imagen principal a: "${imgSrc}"`);
        mainImg.src = imgSrc;
      }
      
      // Actualiza el índice actual
      currentIndex = index;
      console.log(`Índice actual actualizado a: ${currentIndex}`);
    }
    
    // Evento click para las miniaturas
    thumbs.forEach((thumb, index) => {
      console.log(`Configurando evento click para miniatura ${index}`);
      thumb.addEventListener('click', function() {
        console.log(`Miniatura ${index} clickeada`);
        updateMainImage(index);
      });
    });
    
    // Evento click para la flecha anterior
    if (prevArrow) {
      prevArrow.addEventListener('click', function() {
        console.log('Click en flecha previa');
        let newIndex = currentIndex - 1;
        if (newIndex < 0) newIndex = thumbs.length - 1; // Circular
        console.log(`Navegando a índice: ${newIndex}`);
        updateMainImage(newIndex);
      });
    }
    
    // Evento click para la flecha siguiente
    if (nextArrow) {
      nextArrow.addEventListener('click', function() {
        console.log('Click en flecha siguiente');
        let newIndex = currentIndex + 1;
        if (newIndex >= thumbs.length) newIndex = 0; // Circular
        console.log(`Navegando a índice: ${newIndex}`);
        updateMainImage(newIndex);
      });
    }
    
    // Inicializar con la primera imagen
    console.log(`Inicializando modal #${modalIndex} con la primera imagen`);
    updateMainImage(0);
  });
});
</script>
<script src="js/carrito.js"></script>
    <!-- Botón flotante de WhatsApp -->
    <a href="https://api.whatsapp.com/send?phone=51979783905&text=Hola%20Tiflobraille,%20estoy%20interesado%20en%20sus%20servicios%20de%20accesibilidad%20visual." 
    class="whatsapp-float" target="_blank">
    <i class="tf-ion-social-whatsapp-outline"></i>
    </a>
  </body>
  </html>