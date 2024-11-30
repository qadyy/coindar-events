<?php
require_once COINDAR_PLUGIN_PATH . 'includes/components/class-coindar-filters.php';
require_once COINDAR_PLUGIN_PATH . 'includes/components/class-coindar-grid.php';
require_once COINDAR_PLUGIN_PATH . 'includes/utils/date-formatter.php';

class Coindar_Shortcode {
    public function __construct() {
        add_shortcode('coindar_events', array($this, 'render_events'));
    }

    public function render_events($atts) {
        $tags = (new Coindar_Events())->get_tags();
        
        ob_start();
        ?>
        <div class="coindar-events-container">
            <?php 
            echo Coindar_Filters::render($tags);
            echo Coindar_Grid::render();
            ?>
        </div>
        <?php
        return ob_get_clean();
    }
}