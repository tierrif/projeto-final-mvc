<? if (!defined('ABSPATH')) exit ?>

<?
/*
 * https://www.php.net/manual/en/language.basic-syntax.phptags.php
 * Em vez de digitar <? 'echo $var;' ?>, podemos usar <?= $var ?>.
 * Esta sintaxe existe desde PHP 5.4.0 e deve ser ativada em php.ini.
 */
?>

<nav class="menu clearfix">
    <ul>
        <li class="<?= $this->getNavPos() === '' ? 'active' : '' ?>"><a href="<?= HOME_URI ?>">Home</a></li>
        <li class="<?= $this->getNavPos() === 'eventos' ? 'active' : '' ?>"><a href="<?= HOME_URI ?>/eventos/">Eventos</a></li>
        <li class="<?= $this->getNavPos() === 'news' ? 'active' : '' ?>"><a href="<?= HOME_URI ?>/news/">Notícias</a></li>
        <li class="<?= $this->getNavPos() === 'associations' ? 'active' : '' ?>"><a href="<?= HOME_URI ?>/associations/">Associações</a></li>
        <li class="<?= $this->getNavPos() === 'images' ? 'active' : '' ?>"><a href="<?= HOME_URI ?>/images/">Galeria de Imagens</a></li>
        <? if ($this->isLoggedIn()
            && $this->getAuthManager()->hasPermission('admin')): ?>
            <li><a href="<?= HOME_URI ?>/manage/">Admin Dashboard</a></li>
        <? endif ?>
        <li class="right">
            <? if ($this->isLoggedIn()): ?>
                <a href="<?= HOME_URI ?>/profile">O meu perfil</a>
            <? else: ?>
                <a href="<?= HOME_URI ?>/login">Login</a>
            <? endif ?>
        </li>
    </ul>
</nav>
