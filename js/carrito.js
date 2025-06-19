class CartSystem {
    constructor() {
        this.storageKey = 'cotizacion_cart';
        this.cart = this.loadCart();
        this.init();
    }

    // Cargar carrito desde localStorage
    loadCart() {
        try {
            const savedCart = localStorage.getItem(this.storageKey);
            return savedCart ? JSON.parse(savedCart) : [];
        } catch (error) {
            console.error('Error al cargar el carrito:', error);
            return [];
        }
    }

    // Guardar carrito en localStorage
    saveCart() {
        try {
            localStorage.setItem(this.storageKey, JSON.stringify(this.cart));
        } catch (error) {
            console.error('Error al guardar el carrito:', error);
        }
    }

    // Limpiar carrito completo
    clearCart() {
        this.cart = [];
        this.saveCart();
        this.updateCartUI();
        this.renderCartItems();
    }

    init() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                this.bindEvents();
                this.updateCartUI();
            });
        } else {
            this.bindEvents();
            this.updateCartUI();
        }
    }

    bindEvents() {
        const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
        const cartButton = document.getElementById('cartButton');
        const closeCart = document.getElementById('closeCart');
        const cartModal = document.getElementById('cartModal');
        const quoteBtn = document.getElementById('quoteBtn');
        const clearCartBtn = document.getElementById('clearCartBtn');

        if (addToCartButtons.length > 0) {
            addToCartButtons.forEach(btn => {
                btn.addEventListener('click', (e) => this.addToCart(e));
            });
        } else {
            console.warn('No se encontraron botones .add-to-cart-btn');
        }

        if (cartButton) {
            cartButton.addEventListener('click', () => {
                this.openCart();
            });
        } else {
            console.error('No se encontró el elemento #cartButton');
        }

        if (closeCart) {
            closeCart.addEventListener('click', () => {
                this.closeCart();
            });
        } else {
            console.error('No se encontró el elemento #closeCart');
        }

        if (cartModal) {
            cartModal.addEventListener('click', (e) => {
                if (e.target.id === 'cartModal') {
                    this.closeCart();
                }
            });
        } else {
            console.error('No se encontró el elemento #cartModal');
        }

        if (quoteBtn) {
            quoteBtn.addEventListener('click', () => {
                this.generateQuote();
            });
        } else {
            console.error('No se encontró el elemento #quoteBtn');
        }

        // Botón para limpiar carrito (opcional)
        if (clearCartBtn) {
            clearCartBtn.addEventListener('click', () => {
                if (confirm('¿Estás seguro de que quieres vaciar el carrito?')) {
                    this.clearCart();
                }
            });
        }
    }

    addToCart(e) {
        e.preventDefault();
        const btn = e.currentTarget;
        const productId = btn.dataset.productId;
        const productName = btn.dataset.productName;
        const productImage = btn.dataset.productImage;

        const existingItem = this.cart.find(item => item.id === productId);

        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            this.cart.push({
                id: productId,
                name: productName,
                image: productImage || 'images/placeholder.jpg',
                quantity: 1
            });
        }

        // Guardar en localStorage
        this.saveCart();

        // Animación del botón
        btn.classList.add('added');
        btn.innerHTML = '<i class="fas fa-check"></i> Agregado';
        
        setTimeout(() => {
            btn.classList.remove('added');
            btn.innerHTML = '<i class="fas fa-plus"></i> Agregar a Cotización';
        }, 1500);

        // Animación del carrito
        const cartBtn = document.getElementById('cartButton');
        if (cartBtn) {
            cartBtn.classList.add('bounce');
            setTimeout(() => cartBtn.classList.remove('bounce'), 600);
        }

        this.updateCartUI();
        console.log('Carrito actualizado:', this.cart);
    }

    removeFromCart(productId) {
        this.cart = this.cart.filter(item => item.id !== productId);
        this.saveCart();
        this.updateCartUI();
        this.renderCartItems();
    }

    updateQuantity(productId, newQuantity) {
        if (newQuantity <= 0) {
            this.removeFromCart(productId);
            return;
        }

        const item = this.cart.find(item => item.id === productId);
        if (item) {
            item.quantity = newQuantity;
            this.saveCart();
            this.updateCartUI();
            this.renderCartItems();
        }
    }

    updateCartUI() {
        const totalItems = this.cart.reduce((sum, item) => sum + item.quantity, 0);
        const cartCount = document.getElementById('cartCount');
        
        if (cartCount) {
            cartCount.textContent = totalItems;
            cartCount.classList.toggle('show', totalItems > 0);
        }

        const cartTotal = document.getElementById('cartTotal');
        if (cartTotal) {
            cartTotal.textContent = `Total de productos: ${totalItems}`;
        }

        const cartFooter = document.getElementById('cartFooter');
        if (cartFooter) {
            cartFooter.style.display = totalItems > 0 ? 'block' : 'none';
        }
    }

    openCart() {
        const cartModal = document.getElementById('cartModal');
        if (cartModal) {
            cartModal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            this.renderCartItems();
        } else {
            console.error('No se puede abrir el carrito: elemento #cartModal no encontrado');
        }
    }

    closeCart() {
        const cartModal = document.getElementById('cartModal');
        if (cartModal) {
            cartModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }

    renderCartItems() {
        const cartBody = document.getElementById('cartBody');
        if (!cartBody) {
            console.error('No se encontró el elemento #cartBody');
            return;
        }

        if (this.cart.length === 0) {
            cartBody.innerHTML = `
                <div class="cart-empty">
                    <i class="fas fa-shopping-cart"></i>
                    <h4>Tu cotización está vacía</h4>
                    <p>Agrega productos para solicitar una cotización</p>
                </div>
            `;
            return;
        }

        cartBody.innerHTML = this.cart.map(item => `
            <div class="cart-item">
                <div class="cart-item-image">
                    <img src="${item.image}" alt="${item.name}" onerror="this.src='images/placeholder.jpg'">
                </div>
                <div class="cart-item-info">
                    <h5 class="cart-item-title">${item.name}</h5>
                    <div class="cart-item-quantity">
                        <button class="quantity-btn" onclick="cart.updateQuantity('${item.id}', ${item.quantity - 1})">
                            <i class="fas fa-minus"></i>
                        </button>
                        <span class="quantity-display">${item.quantity}</span>
                        <button class="quantity-btn" onclick="cart.updateQuantity('${item.id}', ${item.quantity + 1})">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <button class="remove-item" onclick="cart.removeFromCart('${item.id}')" title="Eliminar producto">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `).join('');
    }

    generateQuote() {
        if (this.cart.length === 0) {
            alert('El carrito está vacío');
            return;
        }

        let message = "🛒 *SOLICITUD DE COTIZACIÓN*%0A%0A";
        message += "Productos solicitados:%0A%0A";

        this.cart.forEach((item, index) => {
            message += `${index + 1}. *${item.name}*%0A`;
            message += `   Cantidad: ${item.quantity}%0A%0A`;
        });

        message += `📊 *Total de productos:* ${this.cart.reduce((sum, item) => sum + item.quantity, 0)}%0A%0A`;
        message += "Por favor, envíenme información sobre precios y disponibilidad.%0A%0A";
        message += "¡Gracias!";

        const whatsappNumber = "51979783905";
        const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${message}`;
        
        window.open(whatsappUrl, '_blank');
    }
}

// Inicializar el sistema de carrito
let cart;

function initializeCart() {
    cart = new CartSystem();
    console.log('Sistema de carrito inicializado con persistencia');
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeCart);
} else {
    initializeCart();
}

window.addEventListener('load', () => {
    if (!cart) {
        initializeCart();
    }
});