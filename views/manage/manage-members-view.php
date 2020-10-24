<? if (!defined('ABSPATH')) exit ?>
<? $this->useNotif() ?>
<form method="post" action="">
    <label for="idAssociacao">Associação</label>
    <select id="idAssociacao" name="idAssociacao">
        <? foreach (Associacao::getAll() as $associacao): ?>
            <option value="<?= $associacao->getId() ?>" <?= $associacao->getId() === $this->formValue('idAssociacao') ? 'selected="selected"' : null ?>><?= $associacao->getNome() ?></option>
        <? endforeach ?>
    </select>
    <label for="nome">Nome<span>*</span></label>
    <input id="nome" type="text" name="nome" placeholder="Nome..." value="<?= $this->formValue('nome') ?>"/>
    <label for="email">Email</label>
    <input id="email" name="email" type="text" placeholder="Email..." value="<?= $this->formValue('email') ?>"/>
    <label for="login">Login<span>*</span></label>
    <input id="login" name="login" type="text" placeholder="Login..." value="<?= $this->formValue('login') ?>"/>
    <label for="password">Password</label>
    <input id="password" name="password" type="password" placeholder="Password...""/>
    <input type="submit" value="Atualizar dados"/>
</form>

<table class="list-table">
    <thead>
    <tr>
        <th>Nome</th>
        <th>Email</th>
        <th>Login</th>
        <th>Editar</th>
        <th>Eliminar</th>
    </tr>
    </thead>
    <tbody>
    <? foreach ($this->getModel()->getAll() as $member): ?>
        <tr>
            <td><?= $member->getNome() ?></td>
            <td><?= $member->getEmail() ?></td>
            <td><?= $member->getLogin() ?></td>
            <td><a href="<?= HOME_URI ?>/manage/members/edit/<?= $member->getId() ?>">Editar</a></td>
            <td><a href="<?= HOME_URI ?>/manage/members/delete/<?= $member->getId() ?>">Eliminar</a></td>
        </tr>
    <? endforeach ?>
    </tbody>
</table>
