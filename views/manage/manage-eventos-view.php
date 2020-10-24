<? if (!defined('ABSPATH')) exit ?>
<? $this->useNotif() ?>
<form method="post" action="">
    <label for="idAssociacao">Associação</label>
    <select id="idAssociacao" name="idAssociacao">
        <? foreach (Associacao::getAll() as $associacao): ?>
            <option value="<?= $associacao->getId() ?>" <?= $associacao->getId() === $this->formValue('idAssociacao') ? 'selected="selected"' : null ?>><?= $associacao->getNome() ?></option>
        <? endforeach ?>
    </select>
    <label for="titulo">Título<span>*</span></label>
    <input id="titulo" type="text" name="titulo" placeholder="Título..." value="<?= $this->formValue('titulo') ?>"/>
    <label for="evento">Evento</label>
    <textarea id="evento" name="evento" placeholder="Evento..."><?= $this->formValue('evento') ?></textarea>
    <label for="data">Data<span>*</span></label>
    <input id="data" type="text" name="data" placeholder="Data..." value="<?= $this->getModel()->invertDate($this->formValue('data')) ?>"/>
    <input type="submit" value="Atualizar dados"/>
</form>

<table class="list-table">
    <thead>
    <tr>
        <th>Título</th>
        <th>Evento</th>
        <th>Data</th>
        <th>Editar</th>
        <th>Eliminar</th>
    </tr>
    </thead>
    <tbody>
    <? foreach ($this->getModel()->getAll() as $event): ?>
        <tr>
            <td><?= $event->getTitulo() ?></td>
            <td>...</td>
            <td><?= $this->getModel()->invertDate($event->getData()) ?></td>
            <td><a href="<?= HOME_URI ?>/manage/eventos/edit/<?= $event->getId() ?>">Editar</a></td>
            <td><a href="<?= HOME_URI ?>/manage/eventos/delete/<?= $event->getId() ?>">Eliminar</a></td>
        </tr>
    <? endforeach ?>
    </tbody>
</table>
