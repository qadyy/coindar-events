<?php
class Coindar_Filters {
    public static function render($tags) {
        if (!is_array($tags)) {
            $tags = array();
        }
        
        ob_start();
        ?>
        <div class="coindar-filters">
            <div class="filter-group">
                <input 
                    type="date" 
                    id="coindar-start-date" 
                    class="coindar-filter" 
                    value="<?php echo esc_attr(date('Y-m-d')); ?>"
                >
                <input 
                    type="date" 
                    id="coindar-end-date" 
                    class="coindar-filter" 
                    value="<?php echo esc_attr(date('Y-m-d', strtotime('+30 days'))); ?>"
                >
                
                <select id="coindar-tags" class="coindar-filter">
                    <option value="">All Tags</option>
                    <?php 
                    if (!empty($tags)) {
                        foreach ($tags as $tag) {
                            if (isset($tag->id) && isset($tag->name)) {
                                printf(
                                    '<option value="%s">%s</option>',
                                    esc_attr($tag->id),
                                    esc_html($tag->name)
                                );
                            }
                        }
                    }
                    ?>
                </select>

                <select id="coindar-sort" class="coindar-filter">
                    <option value="date_start">Start Date</option>
                    <option value="date_end">End Date</option>
                    <option value="important">Importance</option>
                </select>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}