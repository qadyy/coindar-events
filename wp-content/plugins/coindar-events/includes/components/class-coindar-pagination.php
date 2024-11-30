<?php
class Coindar_Pagination {
    public static function render($current_page, $total_pages) {
        if ($total_pages <= 1) {
            return '';
        }

        ob_start();
        ?>
        <div class="coindar-pagination">
            <?php if ($current_page > 1): ?>
                <button 
                    class="pagination-button" 
                    data-page="<?php echo esc_attr($current_page - 1); ?>"
                >
                    Previous
                </button>
            <?php endif; ?>

            <span class="pagination-info">
                Page <?php echo esc_html($current_page); ?> of <?php echo esc_html($total_pages); ?>
            </span>

            <?php if ($current_page < $total_pages): ?>
                <button 
                    class="pagination-button" 
                    data-page="<?php echo esc_attr($current_page + 1); ?>"
                >
                    Next
                </button>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }
}