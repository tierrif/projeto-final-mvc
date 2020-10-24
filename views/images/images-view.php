<? if (!defined('ABSPATH')) exit ?>
<? // null == false, '0' == false. ?>
<img id="galery" src="<?= $this->getData('img') ?>" alt="Imagem"/>
<? if (arrayValue($this->getParams(), 0)): ?>
    <a id="previous" href="<?= HOME_URI ?>/images/index/<?= $this->getParams()[0] - 1 ?>">« Anterior</a>
<? endif ?>
<? if (($this->getData('lastPage') - 1) > arrayValue($this->getParams(), 0)): ?>
    <a id="next" href="<?= HOME_URI ?>/images/index/<?= arrayValue($this->getParams(), 0) + 1 ?>">Seguinte »</a>
<? endif ?>
