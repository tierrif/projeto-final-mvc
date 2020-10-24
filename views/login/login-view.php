<? if (!defined('ABSPATH')) exit ?>
<main>
    <?= $this->useNotif() ?>
    <form method="post" action="<?= HOME_URI . '/login/redirect/' . arrayValue($this->getParams(), 0) ?>">
        <label for="username">Username</label>
        <input id="username" type="text" name="username" placeholder="Username..." value="<?= $this->formValue('username') ?>"/>
        <label for="password">Password</label>
        <input id="password" type="password" name="password" placeholder="Password..."/>
        <input type="submit" value="Login"/>
    </form>
</main>
