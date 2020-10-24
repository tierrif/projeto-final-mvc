<? if (!defined('ABSPATH')) exit ?>
<ul class="details">
    <? foreach ($this->getAllData() as $key => $value): ?>
        <li><span><?= $key ?>:</span> <?= $value ?></li>
    <? endforeach ?>
    <? $this->loadExtraViews() ?>
</ul>
