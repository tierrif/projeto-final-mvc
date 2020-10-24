<? if (!defined('ABSPATH')) exit ?>
<? $this->useNotif() ?>
<form method="post" action="" enctype="multipart/form-data">
    <label for="idAssociacao">Associação</label>
    <select id="idAssociacao" name="idAssociacao">
        <? foreach (Associacao::getAll() as $associacao): ?>
            <option value="<?= $associacao->getId() ?>" <?= $associacao->getId() === $this->formValue('idAssociacao') ? 'selected="selected"' : null ?>><?= $associacao->getNome() ?></option>
        <? endforeach ?>
    </select>
    <label for="titulo">Título<span>*</span></label>
    <input id="titulo" type="text" name="titulo" placeholder="Título..." value="<?= $this->formValue('titulo') ?>"/>
    <label for="noticia">Notícia</label>
    <textarea id="noticia" name="noticia" placeholder="Notícia..."><?= $this->formValue('noticia') ?></textarea>
    <label for="imagem">Imagem</label>
    <input id="imagem" type="file" name="imagem" placeholder="Selecione uma imagem..."/>
    <input type="submit" value="Atualizar dados"/>
</form>

<table class="list-table">
    <thead>
    <tr>
        <th>Título</th>
        <th>Notícia</th>
        <th>Imagem</th>
        <th>Editar</th>
        <th>Eliminar</th>
    </tr>
    </thead>
    <tbody>
    <? foreach ($this->getModel()->getAll() as $noticia): ?>
        <tr>
            <td><?= $noticia->getTitulo() ?></td>
            <td>...</td>
            <td><a href="<?= HOME_URI . '/views/_uploads/' . $noticia->getImagem()->getNome() ?>">Link</a></td>
            <td><a href="<?= HOME_URI ?>/manage/news/edit/<?= $noticia->getId() ?>">Editar</a></td>
            <td><a href="<?= HOME_URI ?>/manage/news/delete/<?= $noticia->getId() ?>">Eliminar</a></td>
        </tr>
    <? endforeach ?>
    </tbody>
</table>
