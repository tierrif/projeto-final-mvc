<? if (!defined('ABSPATH')) exit ?>
<? $this->getModel()->getCurrentImage() or exit ?>
<br/>
<img src="<?= HOME_URI . '/views/_uploads/' . $this->getModel()->getCurrentImage() ?>" alt="Imagem"/>
