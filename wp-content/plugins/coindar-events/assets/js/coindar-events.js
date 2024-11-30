jQuery(document).ready(function($) {
    let currentPage = 1;
    let isLoading = false;
    
    function loadEvents(page = 1) {
        if (isLoading) return;
        
        isLoading = true;
        const container = $('#coindar-events-container');
        container.find('.coindar-events-grid').html('<div class="coindar-loading">Loading events...</div>');

        const params = {
            action: 'get_coindar_events',
            nonce: coindarAjax.nonce,
            page: page,
            filter_date_start: $('#coindar-start-date').val(),
            filter_date_end: $('#coindar-end-date').val(),
            filter_tags: $('#coindar-tags').val(),
            sort_by: $('#coindar-sort').val(),
            order_by: 0
        };

        $.get(coindarAjax.ajaxurl, params)
            .done(function(response) {
                if (response.success && response.data) {
                    renderEvents(response.data);
                } else {
                    const errorMessage = response.message || 'Error loading events. Please try again.';
                    showError(errorMessage);
                }
            })
            .fail(function() {
                showError('Error loading events. Please try again.');
            })
            .always(function() {
                isLoading = false;
            });
    }

    function renderEvents(events) {
        const container = $('#coindar-events-grid');
        container.empty();

        if (!events || !events.length) {
            container.html('<div class="coindar-error">No events found.</div>');
            return;
        }

        events.forEach(function(event) {
            const eventCard = $('<div>', {
                class: 'event-card',
                html: `
                    <h3 class="event-title">${escapeHtml(event.caption)}</h3>
                    <div class="event-date">
                        <span>Start: ${formatDate(event.date_start)}</span>
                        ${event.date_end ? `<br><span>End: ${formatDate(event.date_end)}</span>` : ''}
                        ${event.source ? `<br><a href="${escapeHtml(event.source)}" target="_blank" rel="noopener noreferrer">Source</a>` : ''}
                    </div>
                    <p class="event-description">${escapeHtml(event.description || '')}</p>
                    ${event.coin_price_changes ? `
                        <p class="event-price-change">Price Change: ${event.coin_price_changes}%</p>
                    ` : ''}
                    <div class="event-tags">
                        ${Array.isArray(event.tags) ? 
                            event.tags.map(tag => `<span class="event-tag">${escapeHtml(tag)}</span>`).join('') : 
                            `<span class="event-tag">${escapeHtml(event.tags)}</span>`}
                    </div>
                `
            });
            container.append(eventCard);
        });
    }

    function showError(message) {
        const container = $('#coindar-events-grid');
        container.html(`<div class="coindar-error">${escapeHtml(message)}</div>`);
    }

    function formatDate(dateString) {
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function escapeHtml(unsafe) {
        if (!unsafe) return '';
        return unsafe
            .toString()
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Event listeners
    $('.coindar-filter').on('change', debounce(function() {
        currentPage = 1;
        loadEvents(currentPage);
    }, 300));

    // Initial load
    loadEvents(currentPage);
});