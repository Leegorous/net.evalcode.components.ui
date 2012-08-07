<div <? $this->printElementAttributes(); ?>>
  <? if($this->isActiveForm): ?>
    <!-- TODO Implement dynamic mapping & resolving of resource URIs-->
    <script type="text/javascript" src="/components/ui/js/common.js" async="async"></script>
    <form name="<?= $this->self->getId(); ?>" method="post" action="#" enctype="multipart/form-data" accept-charset="utf-8">
      <input type="hidden" name="<?= $this->self->getId(); ?>-ie" value="1"/>
      <input type="hidden" name="<?= $this->self->getId(); ?>-submitted" value="1"/>
  <? endif; ?>
  <? foreach($this->panels->values() as $panel): ?>
    <? $panel->display(); ?>
  <? endforeach; ?>
  <? if($this->isActiveForm): ?>
    </form>
  <? endif; ?>
</div>
