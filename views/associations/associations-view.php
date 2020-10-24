<? if (!defined('ABSPATH')) exit ?>
<main>
    <? while ($this->getModel()->hasNext()): ?>
        <? $association = $this->getModel()->next() ?>
        <article>
            <h2><?= $association->getNome() ?></h2>
            <a href="<?= HOME_URI ?>/associations/details/<?= $association->getId() ?>">Mais informações</a>
        </article>
    <? endwhile ?>
</main>
