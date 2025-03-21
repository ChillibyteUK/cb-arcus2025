<?php
$colour_field = get_field('colour');
$colour = ($colour_field === 'Red' || $colour_field === null) ? 'plain_quote__red' : 'plain_quote__gold';
?>
<section class="plain_quote <?=$colour?>">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-4 d-flex flex-column">
                <div class="plain_quote__quote-container">
                    <div class="h2 plain_quote__quote">
                        <?=get_field('quote')?>
                    </div>
                    <div class="plain_quote__attribution">
                        <?=get_field('attribution')?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>