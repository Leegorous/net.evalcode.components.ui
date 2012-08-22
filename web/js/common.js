

  // PROPERTIES
  var components_panel_initialized=[];


  // IMPLEMENTATION
  function components_panel_form_submit(nodePanelSubmittable_)
  {
    var node=nodePanelSubmittable_;

    while(node=node.parentNode)
    {
      if(-1<node.tagName.toUpperCase().indexOf("FORM"))
        node.submit();
    }
  }

  function components_panel_loaded()
  {
    var elementsVar=document.getElementsByTagName("var");

    for(var elementVarIdx in elementsVar)
    {
      if(elementsVar[elementVarIdx].className
        && -1<elementsVar[elementVarIdx].className.indexOf("components_panel_loaded"))
      {
        var componentsPanelId=elementsVar[elementVarIdx].id.substring(
          0, elementsVar[elementVarIdx].id.length-7
        );

        if(!components_panel_initialized[componentsPanelId])
          components_panel_init(componentsPanelId);
      }
    }
  }

  function components_panel_init(componentsPanelId_)
  {
    var componentsPanelRoot=document.getElementById(componentsPanelId_);

    if(!componentsPanelRoot)
      return;

    components_panel_initialized[componentsPanelRoot.id]=componentsPanelRoot.id;

    components_panel_init_noscript(componentsPanelRoot);
  }
  
  function components_panel_init_noscript(componentsPanel_)
  {
    if(componentsPanel_.className
      && -1<componentsPanel_.className.indexOf("components_panel_button_submit_noscript"))
    {
      componentsPanel_.parentNode.removeChild(componentsPanel_);
    }
    else
    {
      if(componentsPanel_.className
        && -1<componentsPanel_.className.indexOf("components_panel_noscript"))
      {
        if(28==componentsPanel_.className.trim().length)
          componentsPanel_.removeAttribute("class");
        else
        {
          var className0=componentsPanel_.className.substring(0, componentsPanel_.className.indexOf("components_panel_noscript")).trim();
          var className1=componentsPanel_.className.substring(componentsPanel_.className.indexOf("components_panel_noscript")+25).trim();
          
          if(1>className1.length)
            componentsPanel_.className=className0;
          else
            componentsPanel_.className=className0+" "+className1;
        }
        
      }

      for(var componentsPanelIdx in componentsPanel_.childNodes)
        components_panel_init_noscript(componentsPanel_.childNodes[componentsPanelIdx]);
    }
  }


  // INITIALIZATION
  components_panel_loaded();
