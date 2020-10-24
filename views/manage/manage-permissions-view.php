<? if (!defined('ABSPATH')) exit ?>
<? $this->useNotif() ?>
<form method="post" action="">
    <label for="idSocio">Sócio</label>
    <select id="idSocio" name="idSocio">
        <? foreach (Socio::getAll() as $socio): ?>
            <option value="<?= $socio->getId() ?>" <?= $socio->getId() === $this->formValue('idSocio') ? 'selected="selected"' : null ?>><?= $socio->getNome() ?></option>
        <? endforeach ?>
    </select>
    <label for="nome">Nome<span>*</span></label>
    <input id="nome" type="text" name="nome" placeholder="Nome..." value="<?= $this->formValue('nome') ?>"/>
    <input type="submit" value="Atualizar dados"/>
</form>

<table class="list-table">
    <thead>
    <tr>
        <th>Nome</th>
        <th>Username</th>
        <th>Editar</th>
        <th>Eliminar</th>
    </tr>
    </thead>
    <tbody>
    <? foreach ($this->getModel()->getAll() as $permission): ?>
        <tr>
            <td><?= $permission->getNome() ?></td>
            <td><?= $permission->findOwner() ?></td>
            <td><a href="<?= HOME_URI ?>/manage/permissions/edit/<?= $permission->getId() ?>">Editar</a></td>
            <td><a href="<?= HOME_URI ?>/manage/permissions/delete/<?= $permission->getId() ?>">Eliminar</a></td>
        </tr>
    <? endforeach ?>
    </tbody>
</table>
