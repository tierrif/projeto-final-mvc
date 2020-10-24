<? if ($this->getFormError() !== ''): ?>
    <div class="alert alert-error"><?= $this->getFormError() ?></div>
<? elseif ($this->getFormNotif() !== ''): ?>
    <div class="alert alert-notif"><?= $this->getFormNotif() ?></div>
<? endif ?>
