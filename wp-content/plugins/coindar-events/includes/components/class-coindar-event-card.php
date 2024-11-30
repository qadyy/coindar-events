<?php
require_once COINDAR_PLUGIN_PATH . 'includes/utils/date-formatter.php';

class Coindar_Event_Card {
    public static function render($event) {
        ob_start();
        ?>
        <div class="event-card">
            <h3 class="event-title"><?php echo esc_html($event->caption); ?></h3>
            <div class="event-date">
                <span>Start: <?php echo esc_html(Coindar_Date_Formatter::format_date($event->date_start)); ?></span>
                <?php if (!empty($event->date_end)): ?>
                    <br><span>End: <?php echo esc_html(Coindar_Date_Formatter::format_date($event->date_end)); ?></span>
                <?php endif; ?>
            </div>
            <p class="event-description"><?php echo esc_html($event->description); ?></p>
            <?php if (!empty($event->tags)): ?>
                <div class="event-tags">
                    <?php foreach ($event->tags as $tag): ?>
                        <span class="event-tag"><?php echo esc_html($tag); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }
}