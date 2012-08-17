<select <? $this->printElementAttributes(); ?>>
  <? if(null!==($noValueOptionName=$this->self->getNoValueOptionName())): ?>
    <option value="null"<? if(null===$this->self->getValue()): ?> selected="selected"<? endif; ?>><?= $noValueOptionName; ?></option>
  <? endif; ?>
  <? foreach($this->self->getOptions() as $key=>$option): ?>
    <option value="<?= $key; ?>"<? if($key==$this->self->getValue()): ?> selected="selected"<? endif; ?>><?= $option; ?></option>
  <? endforeach; ?>
</select>
