<? if (!defined('ABSPATH')) exit ?>
<main>
    <? while ($this->getModel()->hasNext()): ?>
        <? $noticia = $this->getModel()->next() ?>
        <article>
            <h2><?= $noticia->getTitulo() ?></h2>
            <a href="<?= HOME_URI ?>/associations/details/<?= $noticia->getIdAssociacao() ?>">Associação</a> |
            <a href="<?= HOME_URI ?>/news/details/<?= $noticia->getId() ?>">Ler artigo</a>
        </article>
    <? endwhile ?>
</main>
