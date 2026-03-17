// Shopping Cart JavaScript

class Cart {
    constructor() {
        this.items = this.loadCart();
        this.init();
    }
    
    init() {
        this.renderCart();
        this.attachEventListeners();
    }
    
    attachEventListeners() {
        // Add to cart buttons
        document.addEventListener('click', (e) => {
            if (e.target.closest('[data-add-to-cart]')) {
                e.preventDefault();
                const button = e.target.closest('[data-add-to-cart]');
                this.addItem(button);
            }
            
            // Remove from cart
            if (e.target.closest('[data-remove-from-cart]')) {
                e.preventDefault();
                const button = e.target.closest('[data-remove-from-cart]');
                const itemId = button.dataset.itemId;
                this.removeItem(itemId);
            }
            
            // Clear cart
            if (e.target.closest('[data-clear-cart]')) {
                e.preventDefault();
                this.clearCart();
            }
        });
        
        // Quantity changes
        document.addEventListener('change', (e) => {
            if (e.target.matches('[data-cart-quantity]')) {
                const itemId = e.target.dataset.itemId;
                const quantity = parseInt(e.target.value);
                this.updateQuantity(itemId, quantity);
            }
        });
        
        // Submit order
        const orderForm = document.querySelector('[data-order-form]');
        if (orderForm) {
            orderForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.submitOrder(orderForm);
            });
        }
    }
    
    addItem(button) {
        const itemId = button.dataset.itemId;
        const itemName = button.dataset.itemName;
        const itemPrice = parseFloat(button.dataset.itemPrice);
        const isAvailable = button.dataset.isAvailable === 'true';
        
        if (!isAvailable) {
            this.showNotification('This item is currently unavailable', 'error');
            return;
        }
        
        const existingItem = this.items.find(item => item.id === itemId);
        
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            this.items.push({
                id: itemId,
                name: itemName,
                price: itemPrice,
                quantity: 1
            });
        }
        
        this.saveCart();
        this.renderCart();
        this.showNotification(`${itemName} added to cart`, 'success');
    }
    
    removeItem(itemId) {
        this.items = this.items.filter(item => item.id !== itemId);
        this.saveCart();
        this.renderCart();
        this.showNotification('Item removed from cart', 'success');
    }
    
    updateQuantity(itemId, quantity) {
        const item = this.items.find(item => item.id === itemId);
        
        if (item) {
            if (quantity <= 0) {
                this.removeItem(itemId);
            } else if (quantity > 99) {
                item.quantity = 99;
                this.showNotification('Maximum quantity is 99', 'error');
            } else {
                item.quantity = quantity;
            }
            
            this.saveCart();
            this.renderCart();
        }
    }
    
    clearCart() {
        if (confirm('Are you sure you want to clear your cart?')) {
            this.items = [];
            this.saveCart();
            this.renderCart();
            this.showNotification('Cart cleared', 'success');
        }
    }
    
    renderCart() {
        const cartContainer = document.querySelector('[data-cart-container]');
        const cartCount = document.querySelector('[data-cart-count]');
        const cartTotal = document.querySelector('[data-cart-total]');
        
        if (cartCount) {
            const totalItems = this.items.reduce((sum, item) => sum + item.quantity, 0);
            cartCount.textContent = totalItems;
            cartCount.classList.toggle('hidden', totalItems === 0);
        }
        
        if (cartTotal) {
            const total = this.calculateTotal();
            cartTotal.textContent = `₱${total.toFixed(2)}`;
        }
        
        if (cartContainer) {
            if (this.items.length === 0) {
                cartContainer.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <p class="mt-2">Your cart is empty</p>
                    </div>
                `;
            } else {
                cartContainer.innerHTML = this.items.map(item => `
                    <div class="flex items-center justify-between py-3 border-b">
                        <div class="flex-1">
                            <h4 class="font-medium">${item.name}</h4>
                            <p class="text-sm text-gray-600">₱${item.price.toFixed(2)}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <input type="number" 
                                   value="${item.quantity}" 
                                   min="1" 
                                   max="99"
                                   data-cart-quantity
                                   data-item-id="${item.id}"
                                   class="w-16 px-2 py-1 border rounded text-center">
                            <button data-remove-from-cart 
                                    data-item-id="${item.id}"
                                    class="text-red-500 hover:text-red-700">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                `).join('');
            }
        }
    }
    
    calculateTotal() {
        return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    }
    
    async submitOrder(form) {
        if (this.items.length === 0) {
            this.showNotification('Your cart is empty', 'error');
            return;
        }
        
        const submitButton = form.querySelector('[type="submit"]');
        const originalText = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.textContent = 'Placing Order...';
        
        try {
            const formData = new FormData(form);
            
            // Add cart items to form data
            formData.append('items', JSON.stringify(this.items.map(item => ({
                menu_item_id: item.id,
                quantity: item.quantity
            }))));
            
            const response = await window.axios.post('/orders', Object.fromEntries(formData));
            
            if (response.data.success) {
                this.clearCart();
                window.location.href = response.data.redirect || '/my-orders';
            }
        } catch (error) {
            console.error('Order submission error:', error);
            
            if (error.response?.data?.message) {
                this.showNotification(error.response.data.message, 'error');
            } else {
                this.showNotification('Failed to place order. Please try again.', 'error');
            }
            
            submitButton.textContent = originalText;
            submitButton.disabled = false;
        }
    }
    
    loadCart() {
        const saved = localStorage.getItem('campuseats_cart');
        return saved ? JSON.parse(saved) : [];
    }
    
    saveCart() {
        localStorage.setItem('campuseats_cart', JSON.stringify(this.items));
    }
    
    showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        } text-white`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
}

export function initCart() {
    return new Cart();
}
