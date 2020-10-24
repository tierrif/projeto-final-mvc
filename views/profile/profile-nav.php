<? if (!defined('ABSPATH')) exit ?>

<nav class="menu clearfix">
    <ul>
        <li class="<?= $this->getNavPos() === 'profile' ? 'active' : '' ?>"><a href="<?= HOME_URI ?>/profile">Perfil</a></li>
        <li class="<?= $this->getNavPos() === '' ? 'active' : '' ?>"><a href="<?= HOME_URI ?>">Home</a></li>
        <li class="<?= $this->getNavPos() === 'profile/subscriptions' ? 'active' : '' ?>"><a href="<?= HOME_URI ?>/profile/subscriptions">As minhas inscrições</a></li>
        <li class="<?= $this->getNavPos() === 'profile/quotas' ? 'active' : '' ?>"><a href="<?= HOME_URI ?>/profile/quotas">Quotas</a></li>
        <li class="right"><a href="<?= HOME_URI ?>/login/logout">Logout</a></li>
    </ul>
</nav>