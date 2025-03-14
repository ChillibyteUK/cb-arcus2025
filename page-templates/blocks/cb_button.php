<?php
$l = get_field('link');
$f = get_field('file');
$class = $block['className'] ?? '';

if (!empty($f) && is_array($f) && isset($f['url'])) {
    $title = get_field('file_button_title') ?: 'Download';
    ?>
    <a href="<?= esc_url($f['url']) ?>" target="_blank" class="button <?= esc_attr($class) ?>"><?= esc_html($title) ?></a>
    <?php
} elseif (!empty($l) && is_array($l) && isset($l['url'], $l['title'])) {
    ?>
    <a href="<?= esc_url($l['url']) ?>" target="<?= esc_attr($l['target'] ?? '_self') ?>" class="button <?= esc_attr($class) ?>"><?= esc_html($l['title']) ?></a>
    <?php
}
?>