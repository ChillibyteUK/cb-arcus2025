<?php
$l = get_field('link') ?? null;

$f = get_field('file') ?? null;

$class = $block['className'] ?? null;

if ($f) {
    $title = get_field('file_button_title') ?: 'Download';
    ?>
<a href="<?=$f['url']?>" target="_blank" class="button <?=$class?>"><?=$title?></a>
    <?php
} else {
    ?>
<a href="<?=$l['url']?>" target="<?=$l['target']?>" class="button <?=$class?>"><?=$l['title']?></a>
<?php
}
