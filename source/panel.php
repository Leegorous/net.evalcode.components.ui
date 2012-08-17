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
   * @subpackage ui
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
      $this->m_name=$this->m_id=$name_;

      $this->m_value=$value_;
      $this->m_title=$title_;

      $this->m_children=HashMap::createEmpty();

      $this->m_template=__DIR__.'/panel.tpl';

      $this->attributes=HashMap::createEmpty();
      $this->params=HashMap::createEmpty();
    }
    //--------------------------------------------------------------------------


    // ACCESSORS/MUTATORS
    public function add(Panel $panel_)
    {
      $this->m_children->put($panel_->m_name, $panel_);

      $panel_->setParent($this);
    }

    public function remove(Panel $panel_)
    {
      $this->m_children->remove($panel_->m_name);
    }

    public function getParent()
    {
      return $this->m_parent;
    }

    public function setParent(Panel $parent_)
    {
      $this->m_parent=$parent_;

      foreach($this->m_children->values() as $panel)
        $panel->setParent($this);

      $this->initialize(true);
    }

    public function getPath()
    {
      return $this->m_path;
    }


    public function getId()
    {
      return $this->m_id;
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


    public function getTemplate()
    {
      return $this->m_template;
    }

    public function setTemplate($template_)
    {
      $this->m_template=$template_;
    }

    public function isForm()
    {
      foreach($this->m_children->values() as $panel)
      {
        if($panel->hasCallback())
          return true;
      }

      return false;
    }

    public function isActiveForm()
    {
      if($this->isForm())
      {
        $panel=$this;
        while($panel=$panel->m_parent)
        {
          if($panel->isForm())
            return false;
        }

        return true;
      }

      return false;
    }

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


    public function getAttributesAsString()
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
      $engine->isActiveForm=$this->isActiveForm();
      $engine->panels=$this->m_children;
      $engine->params=$this->params;
      $engine->self=$this;

      $engine->printElementAttributes=function()
      {
        echo 'id="';
        echo $this->m_id;
        echo '"';
        if($attributeString=$this->getAttributesAsString())
          echo ' ';
        echo $attributeString;
      };

      $engine->display($this->m_template);
    }

    public function render()
    {
      ob_start();
      $this->display();

      return ob_get_clean();
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
    /**
     * @var string
     */
    protected $m_name;
    /**
     * @var string
     */
    protected $m_title;
    /**
     * @var mixed
     */
    protected $m_value;

    /**
     * @var array|string
     */
    private $m_path=array();
    /**
     * @var string
     */
    private $m_id;
    /**
     * @var \Components\HashMap<string, \Components\Panel>
     */
    private $m_children;
    /**
     * @var \Components\Panel
     */
    private $m_parent;
    /**
     * @var \Callable
     */
    private $m_callback;
     //-----


    protected function init()
    {
      // Override ...
    }

    protected function afterInit()
    {
      // Override ...
    }

    protected function onRetrieveValue()
    {
      if(isset($_REQUEST[$this->getId()]) && 'null'!==($value=$_REQUEST[$this->getId()]))
        $this->m_value=$value;
    }


    private function initialize()
    {
      $path=array();
      $panel=$this;

      do
      {
        array_unshift($path, $panel->m_name);
      }
      while($panel=$panel->m_parent);

      $this->m_path=$path;
      $this->m_id=implode('-', $path);

      $this->init();

      $this->onRetrieveValue();

      $this->afterInit();

      if($this->hasCallback() && $this->hasBeenSubmitted())
      {
        $callback=$this->m_callback;
        $callback($this);
      }
    }
    //--------------------------------------------------------------------------
  }
?>
