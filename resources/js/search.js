// Real-time Search JavaScript

async function performSearch(query, form) {
    const resultsContainer = document.querySelector('[data-search-results]');
    const loadingIndicator = document.querySelector('[data-search-loading]');

    if (!resultsContainer || !form) return;

    // Show loading state
    if (loadingIndicator) {
        loadingIndicator.classList.remove('hidden');
    }

    try {
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);

        const response = await window.axios.get(`/search?${params.toString()}`);

        // Update results container with new HTML
        if (response.data.html) {
            resultsContainer.innerHTML = response.data.html;
        }
    } catch (error) {
        console.error('Search error:', error);
    } finally {
        if (loadingIndicator) {
            loadingIndicator.classList.add('hidden');
        }
    }
}

/**
 * Initialize real-time search with debouncing
 */
export function initSearch() {
    const searchInput = document.querySelector('[data-search-input]');
    const searchForm = document.querySelector('[data-search-form]');

    if (!searchInput) return;

    let debounceTimer;

    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            performSearch(searchInput.value, searchForm);
        }, 300); // 300ms debounce
    });
}

/**
 * Initialize filter changes
 */
export function initFilters() {
    const filterSelects = document.querySelectorAll('[data-filter]');
    const searchForm = document.querySelector('[data-search-form]');

    filterSelects.forEach(select => {
        select.addEventListener('change', function () {
            if (searchForm) {
                performSearch('', searchForm);
            }
        });
    });
}
