<?php
require 'config.php';

// Obtener el slug desde la URL
if (!isset($_GET['categoria_slug']) || !isset($_GET['slug'])) {
    echo "Producto no encontrado";
    exit;
}

$slug = $_GET['slug'];
$categoria_slug = $_GET['categoria_slug']; 


$stmt = $conn->prepare("
     SELECT p.*, c.nombre AS categoria_nombre, c.slug AS categoria_slug
    FROM productos p
    JOIN categorias c ON p.categoria_id = c.id
    WHERE c.slug = ? AND p.slug = ?
");
$stmt->bind_param("ss", $categoria_slug, $slug);
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

// Extraer los meta datos de la base de datos
$meta_title = $producto['meta_title'] ?: $producto['nombre'];
$meta_description = $producto['meta_description'] ?: $producto['descripcion_corta'];
$meta_keywords = $producto['meta_keywords'] ?: 'producto, tienda, braille, accesorios';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/tiflobraille/">
    <title><?= htmlspecialchars($producto['nombre']) ?> - Tiflobraille</title>
    
    <!-- TU CSS EXISTENTE -->
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/accessibility.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="plugins/themefisher-font/style.css">
    <!-- CSS DEL DETALLE DE PRODUCTO -->
    <style>
        /* Aquí pegas todo el CSS que te proporcioné arriba */
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
            <a class="nav-link" href="./">Inicio</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="nosotros">Nosotros</a>
          </li>
          <li class="nav-item  active ">
            <a class="nav-link" href="productos">Productos</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="servicios">Servicios</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="soporte">Soporte Técnico</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="contacto">Contacto</a>
          </li>
          
        
        </ul>
      </div>
    </nav>
    <!-- /main nav -->
  </div>
</header>
<section class="single-page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2>Detalles</h2>
			</div>
		</div>
	</div>
</section>

<!--
End Fixed Navigation
==================================== -->


<section class="product-detail-section">
    <div class="container">
        <div class="product-detail">
            <div class="product-images">
                <!-- La imagen principal -->
                <img src="<?= htmlspecialchars($producto['imagen_principal']) ?>" 
                     alt="<?= htmlspecialchars($producto['nombre']) ?>">
                
                <!-- Las imágenes adicionales -->
                <?php foreach ($imagenes as $img): ?>
                    <img src="<?= htmlspecialchars($img['ruta_imagen']) ?>" 
                         alt="<?= htmlspecialchars($img['alt_text']) ?>">
                <?php endforeach; ?>
            </div>

            <div class="product-info">
                <h1><?= htmlspecialchars($producto['nombre']) ?></h1>
                <p class="categoria">Categoría: <?= htmlspecialchars($producto['categoria_nombre']) ?></p>
                <p class="descripcion-corta"><?= htmlspecialchars($producto['descripcion_corta']) ?></p>
                <div class="descripcion-larga"><?= nl2br(htmlspecialchars($producto['descripcion_larga'])) ?></div>

                <!-- BOTONES DE ACCIÓN -->
                <div class="product-actions">
                    <a href="productos" class="back-btn">
                        <i class="fas fa-arrow-left"></i>
                        Volver a Productos
                    </a>
                    
                    <button class="add-to-cart-btn"
                        data-product-id="<?= htmlspecialchars($producto['slug']) ?>"
                        data-product-name="<?= htmlspecialchars($producto['nombre']) ?>"
                        data-product-image="<?= htmlspecialchars($producto['imagen_principal']) ?>">
                        <i class="fas fa-plus"></i>
                        Agregar a Cotización
                    </button>
                </div>

                <!-- CARACTERÍSTICAS ADICIONALES (OPCIONAL) -->
                <div class="product-features">
                    <h3><i class="fas fa-check-circle"></i> Características Principales</h3>
                    <ul class="feature-list">
                        <li><i class="fas fa-universal-access"></i> Diseñado para accesibilidad</li>
                        <li><i class="fas fa-award"></i> Alta calidad y durabilidad</li>
                        <li><i class="fas fa-shipping-fast"></i> Envío a todo el Perú</li>
                        <li><i class="fas fa-headset"></i> Soporte técnico especializado</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--
    Start Footer Area
    ===================================== -->


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
    ===================================== -->
     <!-- Botón flotante de WhatsApp -->
    <a href="https://api.whatsapp.com/send?phone=51979783905&text=Hola%20Tiflobraille,%20estoy%20interesado%20en%20sus%20servicios%20de%20accesibilidad%20visual." 
    class="whatsapp-float" target="_blank">
    <i class="fab fa-whatsapp"></i>
    </a>

<!-- TUS SCRIPTS EXISTENTES -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
<script src="js/carrito.js"></script>


<!-- SCRIPT PARA LA GALERÍA DE IMÁGENES -->
<script>
    // ===== JAVASCRIPT PARA DETALLE DE PRODUCTO =====

document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando galería de producto...');
    
    // Obtener todas las imágenes del producto
    const productImages = document.querySelector('.product-images');
    if (!productImages) return;
    
    const allImages = productImages.querySelectorAll('img');
    if (allImages.length <= 1) return; // Si solo hay una imagen, no crear galería
    
    console.log(`Encontradas ${allImages.length} imágenes`);
    
    // Crear la estructura de la galería
    createImageGallery(allImages);
});

function createImageGallery(images) {
    const productImages = document.querySelector('.product-images');
    
    // Crear array de URLs de imágenes
    const imageUrls =Array.from(images).slice(1).map(img => ({
        src: img.src,
        alt: img.alt
    }));

    // Limpiar el contenedor
    productImages.innerHTML = '';
    
    // Crear contenedor principal de imagen
    const mainContainer = document.createElement('div');
    mainContainer.className = 'main-image-container';
    
    // Crear imagen principal
    const mainImage = document.createElement('img');
    mainImage.className = 'main-image';
    mainImage.src = imageUrls[0].src;
    mainImage.alt = imageUrls[0].alt;
    mainContainer.appendChild(mainImage);
    
    // Crear botones de navegación si hay más de una imagen
    if (imageUrls.length > 1) {
        const prevBtn = document.createElement('button');
        prevBtn.className = 'image-navigation prev-btn';
        prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
        
        const nextBtn = document.createElement('button');
        nextBtn.className = 'image-navigation next-btn';
        nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
        
        mainContainer.appendChild(prevBtn);
        mainContainer.appendChild(nextBtn);
    }
    
    productImages.appendChild(mainContainer);
    
    // Crear galería de miniaturas si hay más de una imagen
    if (imageUrls.length > 1) {
        const thumbnailGallery = document.createElement('div');
        thumbnailGallery.className = 'thumbnail-gallery';
        
        imageUrls.forEach((img, index) => {
            const thumbnail = document.createElement('div');
            thumbnail.className = `thumbnail ${index === 0 ? 'active' : ''}`;
            
            const thumbImg = document.createElement('img');
            thumbImg.src = img.src;
            thumbImg.alt = img.alt;
            
            thumbnail.appendChild(thumbImg);
            thumbnailGallery.appendChild(thumbnail);
        });
        
        productImages.appendChild(thumbnailGallery);
    }
    
    // Inicializar funcionalidad
    initializeGalleryFunctionality(imageUrls);
}

function initializeGalleryFunctionality(imageUrls) {
    let currentImageIndex = 0;
    
    const mainImage = document.querySelector('.main-image');
    const thumbnails = document.querySelectorAll('.thumbnail');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    
    // Función para cambiar imagen principal
    function changeMainImage(index) {
        if (index < 0 || index >= imageUrls.length) return;
        
      
        
        // Actualizar imagen principal con efecto fade
        mainImage.style.opacity = '0.5';
        
        setTimeout(() => {
            mainImage.src = imageUrls[index].src;
            mainImage.alt = imageUrls[index].alt;
            mainImage.style.opacity = '1';
        }, 150);
        
        // Actualizar miniaturas activas
        thumbnails.forEach(thumb => thumb.classList.remove('active'));
        if (thumbnails[index]) {
            thumbnails[index].classList.add('active');
        }
        
        currentImageIndex = index;
    }
    
    // Función para siguiente imagen
    function nextImage() {
        const nextIndex = (currentImageIndex + 1) % imageUrls.length;
        changeMainImage(nextIndex);
    }
    
    // Función para imagen anterior
    function previousImage() {
        const prevIndex = currentImageIndex === 0 ? imageUrls.length - 1 : currentImageIndex - 1;
        changeMainImage(prevIndex);
    }
    
    // Event listeners para botones de navegación
    if (prevBtn) {
        prevBtn.addEventListener('click', previousImage);
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', nextImage);
    }
    
    // Event listeners para miniaturas
    thumbnails.forEach((thumbnail, index) => {
        thumbnail.addEventListener('click', () => {
            changeMainImage(index);
        });
        
        // Hover effect para miniaturas
        thumbnail.addEventListener('mouseenter', () => {
            if (!thumbnail.classList.contains('active')) {
                thumbnail.style.transform = 'scale(1.05)';
                thumbnail.style.borderColor = 'var(--naranja)';
            }
        });
        
        thumbnail.addEventListener('mouseleave', () => {
            if (!thumbnail.classList.contains('active')) {
                thumbnail.style.transform = 'scale(1)';
                thumbnail.style.borderColor = 'transparent';
            }
        });
    });
    
    // Navegación por teclado
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            previousImage();
        } else if (e.key === 'ArrowRight') {
            e.preventDefault();
            nextImage();
        }
    });
    
    // Touch/swipe para móviles
    let touchStartX = 0;
    let touchEndX = 0;
    
    mainImage.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });
    
    mainImage.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });
    
    function handleSwipe() {
        const swipeThreshold = 50;
        const swipeDistance = touchEndX - touchStartX;
        
        if (Math.abs(swipeDistance) > swipeThreshold) {
            if (swipeDistance > 0) {
                previousImage(); // Swipe right = imagen anterior
            } else {
                nextImage(); // Swipe left = siguiente imagen
            }
        }
    }
    
    // Auto-play opcional (descomenta si lo quieres)
    /*
    let autoPlayInterval;
    
    function startAutoPlay() {
        autoPlayInterval = setInterval(nextImage, 4000);
    }
    
    function stopAutoPlay() {
        clearInterval(autoPlayInterval);
    }
    
    // Iniciar auto-play
    startAutoPlay();
    
    // Pausar auto-play cuando el usuario interactúa
    [mainImage, ...thumbnails, prevBtn, nextBtn].forEach(element => {
        if (element) {
            element.addEventListener('mouseenter', stopAutoPlay);
            element.addEventListener('mouseleave', startAutoPlay);
        }
    });
    */
    
    console.log('Galería inicializada correctamente');
}

// Función adicional para zoom de imagen (opcional)
function initializeImageZoom() {
    const mainImage = document.querySelector('.main-image');
    if (!mainImage) return;
    
    mainImage.addEventListener('click', function() {
        if (this.classList.contains('zoomed')) {
            this.classList.remove('zoomed');
            this.style.transform = 'scale(1)';
            this.style.cursor = 'zoom-in';
        } else {
            this.classList.add('zoomed');
            this.style.transform = 'scale(1.5)';
            this.style.cursor = 'zoom-out';
            this.style.transition = 'transform 0.3s ease';
        }
    });
    
}
if (document.body.classList.contains('detalle-page')) {
    // Forzar nav con fondo desde el inicio
    document.querySelector('.navigation').classList.add('scrolled');
}
// Inicializar zoom (opcional)
// initializeImageZoom();
    // Aquí pegas todo el JavaScript que te proporcioné arriba
</script>

</body>
</html>