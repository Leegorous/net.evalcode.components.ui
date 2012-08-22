<div <? $this->printElementAttributes(); ?>>
  <? if($isActiveForm=$this->self->isActiveForm()): ?>
    <form id="<?= $this->self->getId(); ?>-form" name="<?= $this->self->getId(); ?>-form" method="post" action="#" enctype="multipart/form-data" accept-charset="utf-8" class="components_panel_form">
      <input type="hidden" name="<?= $this->self->getId(); ?>-ie" value="1"/>
      <input type="hidden" name="<?= $this->self->getId(); ?>-submitted" value="1"/>
  <? endif; ?>
  <? foreach($this->panels->values() as $panel): ?>
    <? $panel->display(); ?>
  <? endforeach; ?>
  <? if($isActiveForm): ?>
    <? if(false===$this->self->isSubmittable()): ?>
      <input type="submit" name="<?= $this->self->getId(); ?>-submit" value="Submit" class="components_panel_button_submit_noscript"/>
    <? endif; ?>
    </form>
  <? endif; ?>
  <? if(false===$this->self->hasParent()): ?>
    <var id="<?= $this->self->getId(); ?>-loaded" class="components_panel_loaded"></var>
    <link rel="stylesheet" href="/components/ui/css/common.css" type="text/css"/>
    <script type="text/javascript">
      (function() {
        var uriComponentsUiCommons="/components/ui/js/common.js";
        var elementsScript=document.getElementsByTagName("script");

        for(elementScript in elementsScript)
        {
          if(elementsScript[elementScript].src
            && 0<elementsScript[elementScript].src.length
            && -1<elementsScript[elementScript].src.indexOf(uriComponentsUiCommons))
            return;
        }

        var componentsUiCommons=document.createElement("script");
        componentsUiCommons.async=true;
        componentsUiCommons.type="text/javascript";
        componentsUiCommons.src=uriComponentsUiCommons;

        elementsScript[0].parentNode.insertBefore(componentsUiCommons, elementsScript[0]);
      })();
    </script>
  <? endif; ?>
</div>
