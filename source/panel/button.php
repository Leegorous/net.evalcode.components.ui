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
   * Panel_Button
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
  class Panel_Button extends Panel
  {
    // PREDEFINED PROPERTIES
    const TYPE_PLAIN='button';
    const TYPE_SUBMIT='submit';
    const TYPE_RESET='reset';
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    protected function init()
    {
      parent::init();

      $this->setTemplate(__DIR__.'/button.tpl');

      $this->attributes->type=self::TYPE_PLAIN;
      $this->attributes->value=$this->m_title;
    }
    //--------------------------------------------------------------------------
  }


  /**
   * Panel_Button_Submit
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
  class Panel_Button_Submit extends Panel_Button
  {
    // IMPLEMENTATION
    protected function init()
    {
      parent::init();

      $this->attributes->type=self::TYPE_SUBMIT;
    }
    //--------------------------------------------------------------------------
  }


  /**
   * Panel_Button_Submit_NoScript
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
  class Panel_Button_Submit_NoScript extends Panel_Button_Submit
  {

  }
?>
