<?php
$l = get_field('link') ?? null;

$f = get_field('file') ?? null;

if ($f) {
    ?>
<a href="<?=$f['url']?>" target="_blank" class="button">Download</a>
    <?php
} else {
    ?>
<a href="<?=$l['url']?>" target="<?=$l['target']?>" class="button"><?=$l['title']?></a>
<?php
}
