$(function(){ 
  $("#hirdetesmanagement").jqGrid({
    url:'php/process.php',
    datatype: 'json',
    mtype: 'POST',
    colNames:['Id','Melyik oldalhoz?','Képfájl neve', 'Képfájl alt. szöveg','Hova mutat? (http://...)','Utolsó mutatás'],
    colModel :[ 
      {name:'id', index:'id', width:60, align:'center',editable:false}, 
      {name:'mak_url', index:'mak_url', width:200, align:'center',editable:true}, 
      {name:'kep', index:'kep', width:100, align:'center',editable:true}, 
      {name:'alt', index:'alt', width:100, align:'center',editable:true}, 
      {name:'cel_url', index:'cel_url', width:200 , align:'center',editable:true},
      {name:'utolso_mutatas', index:'utolso_mutatas', width:150, align:'center',editable:false}, 
    ],
    pager: $('#pager'),
    rowNum:10,
    rowList:[10,20,30],
    sortname: 'id',
    sortorder: 'desc',
    viewrecords: true,
    gridview: true,
    caption: 'Hírdetések kezelése',
    editurl: 'php/edit.php',
    shrinkToFit: false
  });
  
  /*
   * Szerkesztés,hozzáadás,törlés gombok
   */
  
  $("#hirdetesmanagement").jqGrid('navGrid', '#pager', {
      edit: true,
      add: true,
      del: true
  },{
		afterSubmit:processAddEdit,
		closeAfterAdd: true,
		closeAfterEdit: true
  },{
	  afterSubmit:processAddEdit,
		closeAfterAdd: true,
		closeAfterEdit: true
  },{
	  
  },{
	  multipleSearch:true
  });
  
  /*
   * Oszlopok gomb
   */
  
  $("#hirdetesmanagement").jqGrid('navButtonAdd','#pager',{
      caption: "Oszlopok",
      title: "Oszlopok rendezése",
      onClickButton : function (){
        jQuery("#hirdetesmanagement").jqGrid('columnChooser');
    }
   });
 
  
  function processAddEdit(response, postdata){
	  
	  var resp = response.responseText
	  var success = '';
	  var message = '';
	  var new_id = "1";
	  
	  if(resp == 'Sikeres'){
		  success = false;
		  message = 'Sikeres';
	  }else{
		  success = true;
		  message = 'Sikertelen. Hibás érték : ' + resp;
	  }
	  
	  alert(resp);
	  
	  $("#hirdetesmanagement").trigger("reloadGrid");
	  
	  return [success,message,new_id];
	  
  }
  
});