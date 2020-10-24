<? if (!defined('ABSPATH')) exit ?>
<main>
    <? while ($this->getModel()->hasNext()): ?>
        <? $evento = $this->getModel()->next() ?>
        <article>
            <h2><?= $evento->getTitulo() ?></h2>
            <a href="<?= HOME_URI ?>/associations/details/<?= $evento->getIdAssociacao() ?>">Associação organizadora</a> |
            <a href="<?= HOME_URI ?>/eventos/details/<?= $evento->getId() ?>">Saber mais</a>
        </article>
    <? endwhile ?>
</main>
