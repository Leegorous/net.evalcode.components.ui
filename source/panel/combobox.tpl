<select <? $this->printElementAttributes(); ?>>
  <? if(is_array($this->self->getNoValueOption())): ?>
    <? $noValueOption=$this->self->getNoValueOption(); ?>
    <? $noValueKey=null===key($noValueOption)?'null':key($noValueOption); ?>
    <? $noValueName=null===reset($noValueOption)?'':reset($noValueOption); ?>
    <option value="<?= $noValueKey; ?>"<? if($noValueKey===$this->self->getValue()): ?> selected="selected"<? endif; ?>><?= $noValueName; ?></option>
  <? endif; ?>
  <? foreach($this->self->getOptions() as $key=>$option): ?>
    <option value="<?= $key; ?>"<? if($key===$this->self->getValue()): ?> selected="selected"<? endif; ?>><?= $option; ?></option>
  <? endforeach; ?>
</select>
