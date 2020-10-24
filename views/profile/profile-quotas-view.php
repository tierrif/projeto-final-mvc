<? if (!defined('ABSPATH')) exit ?>
<ul>
<? foreach (Quota::getAllFromSocio($this->getId()) as $quota): ?>
    <li><b>Quota:</b> Data início <?= $this->getModel()->invertDate($quota->getDataComeco()) ?>, data término
        <?= $this->getModel()->invertDate($quota->getDataTermino()) ?>, com valor &euro;<?= $quota->getPreco() ?>.</li>
<? endforeach ?>
</ul>
