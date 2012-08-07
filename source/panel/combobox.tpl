<select <? $this->printElementAttributes(); ?>>
  <? foreach($this->self->getOptions() as $key=>$option): ?>
    <option value="<?= $key; ?>"<? if($this->self->getValue()==$key): ?> selected="selected"<? endif; ?>><?= $option; ?></option>
  <? endforeach; ?>
</select>
