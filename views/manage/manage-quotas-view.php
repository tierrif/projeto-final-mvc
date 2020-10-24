<? if (!defined('ABSPATH')) exit ?>
<? $this->useNotif() ?>
<form method="post" action="">
    <label for="idSocio">Sócio</label>
    <select id="idSocio" name="idSocio">
        <? foreach (Socio::getAll() as $socio): ?>
            <option value="<?= $socio->getId() ?>" <?= $socio->getId() === $this->formValue('idSocio') ? 'selected="selected"' : null ?>><?= $socio->getNome() ?></option>
        <? endforeach ?>
    </select>
    <label for="dataComeco">Data de começo<span>*</span></label>
    <input id="dataComeco" type="text" name="dataComeco" placeholder="Data de começo..." value="<?= $this->getModel()->invertDate($this->formValue('dataComeco')) ?>"/>
    <label for="dataTermino">Data de término<span>*</span></label>
    <input id="dataTermino" type="text" name="dataTermino" placeholder="Data de término..." value="<?= $this->getModel()->invertDate($this->formValue('dataTermino')) ?>"/>
    <label for="preco">Preço<span>*</span></label>
    <input id="preco" type="text" name="preco" placeholder="Preço..." value="<?= $this->formValue('preco') ?>"/>
    <input type="submit" value="Atualizar dados"/>
</form>

<table class="list-table">
    <thead>
    <tr>
        <th>Data de começo</th>
        <th>Data de término</th>
        <th>Preço</th>
        <th>Editar</th>
        <th>Eliminar</th>
    </tr>
    </thead>
    <tbody>
    <? foreach ($this->getModel()->getAll() as $quota): ?>
        <tr>
            <td><?= $this->getModel()->invertDate($quota->getDataComeco()) ?></td>
            <td><?= $this->getModel()->invertDate($quota->getDataTermino()) ?></td>
            <td><?= $quota->getPreco() ?></td>
            <td><a href="<?= HOME_URI ?>/manage/quotas/edit/<?= $quota->getId() ?>">Editar</a></td>
            <td><a href="<?= HOME_URI ?>/manage/quotas/delete/<?= $quota->getId() ?>">Eliminar</a></td>
        </tr>
    <? endforeach ?>
    </tbody>
</table>
