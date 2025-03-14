<?php
$l = get_field('link') ?? null;

$f = get_field('file') ?? null;

if ($f) {
    $title = get_field('file_button_title') ?: 'Download';
    ?>
<a href="<?=$f['url']?>" target="_blank" class="button"><?=$title?></a>
    <?php
} else {
    ?>
<a href="<?=$l['url']?>" target="<?=$l['target']?>" class="button"><?=$l['title']?></a>
<?php
}
