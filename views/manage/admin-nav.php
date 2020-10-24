<? if (!defined('ABSPATH')) exit ?>
<? debug($this->getNavPos()) ?>
<nav class="menu menu-admin clearfix">
    <ul>
        <li class="<?= $this->getNavPos() === 'manage/dashboard' ? 'admin-active' : '' ?>"><a href="<?= HOME_URI ?>/manage/dashboard">Dashboard</a></li>
        <li class="<?= $this->getNavPos() === 'manage/associations' ? 'admin-active' : '' ?>"><a href="<?= HOME_URI ?>/manage/associations">Associações</a></li>
        <li class="<?= $this->getNavPos() === 'manage/eventos' ? 'admin-active' : '' ?>"><a href="<?= HOME_URI ?>/manage/eventos">Eventos</a></li>
        <li class="<?= $this->getNavPos() === 'manage/news' ? 'admin-active' : '' ?>"><a href="<?= HOME_URI ?>/manage/news">Notícias</a></li>
        <li class="<?= $this->getNavPos() === 'manage/quotas' ? 'admin-active' : '' ?>"><a href="<?= HOME_URI ?>/manage/quotas">Quotas</a></li>
        <li class="<?= $this->getNavPos() === 'manage/members' ? 'admin-active' : '' ?>"><a href="<?= HOME_URI ?>/manage/members">Sócios</a></li>
        <li class="<?= $this->getNavPos() === 'manage/permissions' ? 'admin-active' : '' ?>"><a href="<?= HOME_URI ?>/manage/permissions">Permissões</a></li>
        <li class="right"><a href="<?= HOME_URI ?>">Home</a></li>
    </ul>
</nav>