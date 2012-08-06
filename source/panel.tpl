<div id="<?= $this->self->getId(); ?>"<?= $this->self->getAttributeString(); ?>>
  <? $isSubmittable=$this->self->isSubmittable(); ?>
  <? if($isSubmittable): ?>
    <form name="<?= $this->self->getId(); ?>">
  <? endif; ?>
  <? foreach($this->panels->values() as $panel): ?>
    <? $panel->display(); ?>
  <? endforeach; ?>
  <? if($isSubmittable): ?>
    </form>
  <? endif; ?>
</div>