<?php
class Coindar_Grid {
    public static function render() {
        ob_start();
        ?>
        <div id="coindar-events-container">
            <div id="coindar-events-grid" class="coindar-events-grid">
                <div class="coindar-loading">Loading events...</div>
            </div>
            <div id="coindar-pagination"></div>
        </div>
        <?php
        return ob_get_clean();
    }
}