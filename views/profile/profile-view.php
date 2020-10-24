<? if (!defined('ABSPATH')) exit ?>
<h2>Tem
    <?
    if ($this->getData('notifs')) echo count($this->getData('notifs'));
    else echo 0;
    ?> notificação(s).</h2>
<? $this->getData('notifs') or exit ?>
<ul>
    <? foreach ($this->getData('notifs') as $notif): ?>
        <li>Quota com data início <?= $this->getModel()->invertDate($notif->getDataComeco()) ?> deve ser paga. Valor da quota: &euro;<?= $notif->getPreco() ?>.</li>
    <? endforeach ?>
</ul>
