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
   * Panel_Combobox
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
  class Panel_Combobox extends Panel implements Panel_Submittable
  {
    // CONSTRUCTION
    public function __construct($name_, array $options_, $value_=null, $title_=null)
    {
      parent::__construct($name_, $value_, $title_);

      $this->m_options=$options_;
    }
    //--------------------------------------------------------------------------


    // ACCESSORS/MUTATORS
    public function getOptions()
    {
      return $this->m_options;
    }

    public function setOptions(array $options_)
    {
      $this->m_options=$options_;
    }
    //--------------------------------------------------------------------------


    // OVERRIDES/IMPLEMENTS
    public function hasCallback()
    {
      return $this->m_callback instanceof \Closure;
    }

    public function getCallback()
    {
      return $this->m_callback;
    }

    public function setCallback(\Closure $callback_)
    {
      $this->m_callback=$callback_;
    }

    public function hasBeenSubmitted()
    {
      return isset($_REQUEST[$this->getId()]);
    }

    public function display()
    {
      if($this->hasCallback())
        $this->attributes->onchange='components_ui_panel_submittable_form_submit(this); return false;';

      parent::display();
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    private $m_callback;
    //-----


    protected function init()
    {
      parent::init();

      $this->setTemplate(__DIR__.'/combobox.tpl');

      $this->attributes->name=$this->getId();
    }

    protected function onRetrieveValue()
    {
      if(isset($_REQUEST[$this->getID()]))
        $this->m_value=(int)$_REQUEST[$this->getID()];

      if($this->m_callback instanceof \Closure)
      {
        $callback=$this->m_callback;
        $callback($this);
      }
    }
    //--------------------------------------------------------------------------
  }
?>
