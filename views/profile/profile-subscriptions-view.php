<? if (!defined('ABSPATH')) exit ?>
<? $this->getData('subscriptions') or exit ?>
<ul class="details">
    <? foreach ($this->getData('subscriptions') as $idEvento => $titulo): ?>
        <li><span>Inscrição:</span> Evento de título <?= $titulo ?> com inscrição agendada.
            <a href="../eventos/details/<?= $idEvento ?>">Detalhes</a> | <a href="../subscribe/delete/<?= $idEvento ?>">Cancelar</a></li>
    <? endforeach ?>
</ul>