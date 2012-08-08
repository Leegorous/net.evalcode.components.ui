

  function components_ui_panel_submittable_form_submit(nodePanelSubmittable_)
  {
    var node=nodePanelSubmittable_;

    while(node=node.parentNode)
    {
      if(-1<node.tagName.toUpperCase().indexOf("FORM"))
        node.submit();
    }
  }
