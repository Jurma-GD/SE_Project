// Menu Item Management JavaScript

/**
 * Toggle menu item availability via AJAX
 */
export function initAvailabilityToggle() {
    document.addEventListener('click', function(e) {
        if (e.target.closest('[data-toggle-availability]')) {
            e.preventDefault();
            const button = e.target.closest('[data-toggle-availability]');
            const itemId = button.dataset.itemId;
            const card = button.closest('[data-menu-item]');
            
            toggleAvailability(itemId, card, button);
        }
    });
}

async function toggleAvailability(itemId, card, button) {
    const originalText = button.textContent;
    button.disabled = true;
    button.textContent = 'Updating...';
    
    try {
        const response = await window.axios.post(`/vendor/menu-items/${itemId}/toggle`);
        
        if (response.data.success) {
            const isAvailable = response.data.is_available;
            
            // Update badge
            const badge = card.querySelector('[data-availability-badge]');
            if (badge) {
                badge.className = `px-3 py-1 rounded-full text-xs font-bold shadow-lg ${
                    isAvailable ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
                }`;
                badge.textContent = isAvailable ? 'Available' : 'Unavailable';
            }
            
            // Update button
            button.className = `flex-1 ${
                isAvailable ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600'
            } text-white px-4 py-2 rounded-lg font-medium transition transform hover:scale-105 text-sm`;
            button.textContent = isAvailable ? 'Mark Unavailable' : 'Mark Available';
            
            // Update stats
            updateStats(isAvailable);
            
            // Show success message
            showNotification('Availability updated successfully', 'success');
        }
    } catch (error) {
        console.error('Error toggling availability:', error);
        button.textContent = originalText;
        showNotification('Failed to update availability', 'error');
    } finally {
        button.disabled = false;
    }
}

function updateStats(isAvailable) {
    const availableCount = document.querySelector('[data-stat="available"]');
    const unavailableCount = document.querySelector('[data-stat="unavailable"]');
    
    if (availableCount && unavailableCount) {
        const currentAvailable = parseInt(availableCount.textContent);
        const currentUnavailable = parseInt(unavailableCount.textContent);
        
        if (isAvailable) {
            availableCount.textContent = currentAvailable + 1;
            unavailableCount.textContent = Math.max(0, currentUnavailable - 1);
        } else {
            availableCount.textContent = Math.max(0, currentAvailable - 1);
            unavailableCount.textContent = currentUnavailable + 1;
        }
    }
}

function showNotification(message, type = 'success') {
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
