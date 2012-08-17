<?php
/**
 * Copyright (C) 2012 evalcode.net
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package net.evalcode.components
 */
namespace Components;


  /**
   * Panel_Bound_Combobox
   *
   * @package net.evalcode.components
   * @subpackage ui.panel
   *
   * @since 1.0
   * @access public
   *
   * @author Carsten Schipke <carsten.schipke@evalcode.net>
   * @copyright Copyright (C) 2012 evalcode.net
   * @license GNU General Public License 3
   */
  class Panel_Bound_Combobox extends Panel_Combobox implements Panel_Bound
  {
    // CONSTRUCTION
    public function __construct($name_, View $view_, $propertyValue_,
      $value_=null, $title_=null, $propertyKey_=null, $noValueOptionName_=null)
    {
      parent::__construct($name_, $value_, $title_, array(), $noValueOptionName_);

      if(null===$propertyKey_)
        $propertyKey_=$view_->container()->primaryKey;

      $this->m_view=$view_;
      $this->m_propertyValue=$propertyValue_;
      $this->m_propertyKey=$propertyKey_;
    }
    //--------------------------------------------------------------------------


    // OVERRIDES/IMPLEMENTS
    /**
     * @see Components.Panel_Bound::getBoundView()
     */
    public function getBoundView()
    {
      return $this->m_view;
    }

    /**
     * @see Components.Panel_Bound::getBoundValue()
     */
    public function getBoundValue()
    {
      if(null===$this->m_value)
        return null;

      // TODO Cache local
      return $this->m_view->findFirst(array('select'=>array(
        $this->m_propertyKey.' = ?', $this->m_value
      )));
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    /**
     * @var \Components\View
     */
    protected $m_view;
    /**
     * @var string
     */
    protected $m_propertyKey;
    /**
     * @var string
     */
    protected $m_propertyValue;
    //-----


    protected function init()
    {
      parent::init();

      foreach($this->m_view->find() as $record)
        $this->m_options[$record->{$this->m_propertyKey}]=$record->{$this->m_propertyValue};
    }
    //--------------------------------------------------------------------------
  }
?>
