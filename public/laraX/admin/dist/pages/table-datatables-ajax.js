var TableDatatablesAjax=function(){var handleRecords=function(options){function restoreRow(e,a){for(var t=e.fnGetData(a),n=$(">td",a),o=0,i=n.length;o<i;o++)e.fnUpdate(t[o],a,o,!1);e.api().ajax.reload()}function editRow(e,a){var t=e.fnGetData(a),n=$("> td",a);null!=t&&($.each(options.editableFields,function(e,a){var o=0;t[a].toString().indexOf("</span>")!=-1&&(o=t[a].toString().indexOf("</span>")+7),n[a].innerHTML='<input type="text" class="form-control" value="'+t[a].toString().substr(o)+'">'}),n[options.actionPosition].innerHTML='<a class="fast-edit" title="Fast edit">Save</a><br><a class="cancel">Cancel</a>')}function saveRow(oTable,nRow){var jqTds=$("> td",nRow),jqInputs=$("input",nRow),dataPost={};$.each(jqInputs,function(index,val){var currentValue=jqInputs[index].value||"";eval("dataPost.args_"+index+' = "'+currentValue+'"')}),$.each(options.editableFields,function(e,a){oTable.fnUpdate($(jqTds[a]).find("input").val(),nRow,a,!1)}),oTable.fnUpdate('<a class="edit">Fast edit</a>',nRow,options.actionPosition,!1),$.ajax({url:options.ajaxUrlSaveRow,type:"POST",dataType:"json",data:dataPost,beforeSend:function(){App.blockUI({message:options.loadingMessage||"Loading...",target:grid.getTableWrapper(),overlayColor:"none",cenrerY:!0,boxed:!0})},complete:function(e){grid.getTableWrapper().find(".blockUI").remove(),"undefined"!=typeof e.responseJSON?e.responseJSON.error?Utility.showNotification(e.responseJSON.message,"danger"):Utility.showNotification(e.responseJSON.message,"success"):Utility.showNotification("Some error occurred!","danger"),oTable.api().ajax.reload()}})}var grid=new MyDataTable;grid.init({src:options.src||$("#datatable_ajax"),onSuccess:function(e,a){App.initAjax(),options.onSuccess(e,a)},onError:function(e){options.onError(e)},onDataLoad:function(e){App.initAjax(),options.onDataLoad(e)},loadingMessage:options.loadingMessage||"Loading...",dataTableParams:{bStateSave:options.saveOnCookie||!0,lengthMenu:options.defaultLengthMenu||[[10,20,50,100,150,-1],[10,20,50,100,150,"All"]],pageLength:options.defaultPageLength||10,ajax:{url:options.ajaxGet||null},order:[[1,"asc"]]}}),grid.getTableWrapper().on("confirmed.bs.confirmation",".table-group-action-submit",function(e){e.preventDefault();var a=$(".table-group-action-input",grid.getTableWrapper());""!=a.val()&&grid.getSelectedRowsCount()>0?(grid.setAjaxParam("customActionType","group_action"),grid.setAjaxParam("customActionValue",a.val()),grid.setAjaxParam("id",grid.getSelectedRows()),grid.getDataTable().api().ajax.reload(),grid.clearAjaxParams()):""==a.val()?Utility.showNotification("Please select an action","danger"):0===grid.getSelectedRowsCount()&&Utility.showNotification("No record selected","warning")});var nEditing=null,nNew=!1,oTable=grid.getDataTable();grid.getTableWrapper().on("click",".fast-edit",function(e){e.preventDefault();var a=$(this).parents("tr")[0];null!==nEditing&&nEditing!=a?(restoreRow(oTable,nEditing),editRow(oTable,a),nEditing=a):nEditing==a&&"Save"==this.innerHTML?(saveRow(oTable,nEditing),nEditing=null):(editRow(oTable,a),nEditing=a)}),grid.getTableWrapper().on("click",".cancel",function(e){e.preventDefault(),nNew?(oTable.fnDeleteRow(nEditing),nEditing=null,nNew=!1):(restoreRow(oTable,nEditing),nEditing=null)}),grid.getTableWrapper().on("confirmed.bs.confirmation",".ajax-link",function(e){e.preventDefault();var a=$(this);$.ajax({url:a.attr("data-ajax"),type:a.attr("data-method")||"POST",dataType:"json",beforeSend:function(){App.blockUI({message:"Loading...",target:grid.getTableWrapper(),overlayColor:"none",cenrerY:!0,boxed:!0})},complete:function(e){grid.getTableWrapper().find(".blockUI").remove(),"undefined"!=typeof e.responseJSON?e.responseJSON.error?Utility.showNotification(e.responseJSON.message,"danger"):Utility.showNotification(e.responseJSON.message,"success"):Utility.showNotification("Some error occurred!","danger"),oTable.api().ajax.reload()}})})};return{init:function(e){handleRecords(e)}}}();