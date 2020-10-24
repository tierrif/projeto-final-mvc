<? if (!defined('ABSPATH')) exit ?>
<? $this->useNotif() ?>
<form method="post" action="">
    <label for="nome">Nome<span>*</span></label>
    <input id="nome" type="text" name="nome" placeholder="Nome..." value="<?= $this->formValue('nome') ?>"/>
    <label for="morada">Morada</label>
    <input id="morada" type="text" name="morada" placeholder="Morada..." value="<?= $this->formValue('morada') ?>"/>
    <label for="telefone">Telefone</label>
    <input id="telefone" type="text" name="telefone" placeholder="Telefone..." value="<?= $this->formValue('telefone') ?>"/>
    <label for="numContribuinte">Núm. Contribuinte<span>*</span></label>
    <input id="numContribuinte" type="text" name="numContribuinte" placeholder="Contribuinte..." value="<?= $this->formValue('numContribuinte') ?>"/>
    <input type="submit" value="Atualizar dados"/>
</form>

<table class="list-table">
    <thead>
    <tr>
        <th>Nome</th>
        <th>Morada</th>
        <th>Telefone</th>
        <th>Contribuinte</th>
        <th>Editar</th>
        <th>Eliminar</th>
    </tr>
    </thead>
    <tbody>
    <? foreach ($this->getModel()->getAll() as $association): ?>
        <tr>
            <td><?= $association->getNome() ?></td>
            <td><?= $association->getMorada() ?></td>
            <td><?= $association->getTelefone() ?></td>
            <td><?= $association->getNumContribuinte() ?></td>
            <td><a href="<?= HOME_URI ?>/manage/associations/edit/<?= $association->getId() ?>">Editar</a></td>
            <td><a href="<?= HOME_URI ?>/manage/associations/delete/<?= $association->getId() ?>">Eliminar</a></td>
        </tr>
    <? endforeach ?>
    </tbody>
</table>
