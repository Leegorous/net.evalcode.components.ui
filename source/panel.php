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
   * Panel
   *
   * <p>
   *   UI Panel super type.
   * </p>
   *
   * @package net.evalcode.components
   * @subpackage io
   *
   * @since 1.0
   * @access public
   *
   * @author Carsten Schipke <carsten.schipke@evalcode.net>
   * @copyright Copyright (C) 2012 evalcode.net
   * @license GNU General Public License 3
   */
  class Panel implements Object
  {
    // PROPERTIES

    /**
     * @var \Components\HashMap<string, mixed>
     */
    public $params;

    /**
     * @var \Components\HashMap<string, mixed>
     */
    public $attributes;
    //--------------------------------------------------------------------------


    // CONSTRUCTION
    public function __construct($name_, $value_=null, $title_=null)
    {
      $this->m_name=$name_;
      $this->m_value=$value_;
      $this->m_title=$title_;

      $this->m_children=HashMap::createEmpty();

      $this->m_template=__DIR__.'/panel.tpl';

      $this->attributes=HashMap::createEmpty();
      $this->params=HashMap::createEmpty();
    }
    //--------------------------------------------------------------------------


    // ACCESSORS/MUTATORS
    public function init()
    {
      // Do nothing ...
    }


    public function add(Panel $panel_)
    {
      $this->m_children->put($panel_->m_name, $panel_);

      $panel_->m_parent=$this;
      $panel_->initialize(true);
    }

    public function remove(Panel $panel_)
    {
      $this->m_children->remove($panel_->m_name);
    }


    public function getId()
    {
      return implode('-', $this->getPath());
    }

    public function getName()
    {
      return $this->m_name;
    }

    public function getValue()
    {
      return $this->m_value;
    }

    public function setValue($value_)
    {
      $this->m_value=$value_;
    }

    public function getTitle()
    {
      return $this->m_title;
    }

    public function setTitle($title_)
    {
      $this->m_title=$title_;
    }


    public function getPath()
    {
      $path=array();
      $panel=$this;

      do
      {
        array_unshift($path, $panel->m_name);
      }
      while($panel=$panel->m_parent);

      return $path;
    }


    public function getTemplate()
    {
      return $this->m_template;
    }

    public function setTemplate($template_)
    {
      $this->m_template=$template_;
    }

    public function getAttributeString()
    {
      $attributes=array();
      foreach($this->attributes->arrayValue() as $key=>$value)
        array_push($attributes, "$key=\"$value\"");

      return implode(' ', $attributes);
    }

    public function display()
    {
      if(null===$this->m_parent)
        $this->initialize();

      $engine=new Text_Template_Engine();
      $engine->panels=$this->m_children;
      $engine->params=$this->params;
      $engine->self=$this;

      $engine->display($this->m_template);
    }

    public function render()
    {
      ob_start();
      $this->display();

      return ob_get_clean();
    }


    public function isSubmittable()
    {
      foreach($this->m_children->values() as $panel)
      {
        if($panel->hasCallback())
          return true;
      }

      return false;
    }

    public function hasBeenSubmitted()
    {
      return isset($_REQUEST[$this->getId()]);
    }

    public function hasCallback()
    {
      return is_callable($this->m_callback);
    }

    public function getCallback()
    {
      return $this->m_callback;
    }

    public function setCallback(callable $callback_)
    {
      $this->m_callback=$callback_;
    }

    public function addValidator(/*Validator*/ $validator_)
    {
      $this->m_validators[$validator_->hashCode()]=$validator_;
    }

    public function removeValidator(/*Validator*/ $validator_)
    {
      unset($this->m_validators[$validator_->hashCode()]);
    }

    public function hasErrors()
    {
      return 0<count($this->m_errors);
    }

    public function getErrors()
    {
      return $this->m_errors;
    }
    //--------------------------------------------------------------------------


    // OVERRIDES/IMPLEMENTS
    public function hashCode()
    {
      return spl_object_hash($this);
    }

    public function equals($object_)
    {
      if($object_ instanceof self)
        return String::equal($this->hashCode(), $object_->hashCode());

      return false;
    }

    public function __toString()
    {
      return sprintf('%s@%s{name: %s}',
        __CLASS__, $this->hashCode(), $this->m_name
      );
    }

    public function __get($name_)
    {
      if('root'===$name_)
      {
        $panel=$this;
        while($panel->m_parent)
          $panel=$panel->m_parent;

        return $panel;
      }

      return $this->m_children->get($name_);
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    protected $m_name;
    protected $m_title;
    protected $m_value;

    private $m_initialized=false;
    private $m_validators=array();
    private $m_errors=array();
    /**
     * @var callable
     */
    private $m_callback;
    /**
     * @var \Components\HashMap<string, \Components\Panel>
     */
    private $m_children;
    /**
     * @var \Components\Panel
     */
    private $m_parent;
    //-----


    protected function validate()
    {

    }

    protected function afterInit()
    {
      if($this->hasBeenSubmitted())
      {
        $this->validate();

        if($this->hasCallback())
          call_user_func_array($this->getCallback(), array($this));
      }
    }


    private function initialize($force_=false)
    {
      if(false===$this->m_initialized || $force_)
      {
        $this->init();

        $this->m_initialized=true;

        $this->afterInit();
      }
    }
    //--------------------------------------------------------------------------
  }
?>
