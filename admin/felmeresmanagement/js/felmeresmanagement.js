$(function(){ 
  $("#felmeresmanagement").jqGrid({
    url:'php/process.php',
    datatype: 'json',
    mtype: 'POST',
    colNames:['Id','Kérdés','Válasz 1.', 'Válasz 2.','Válasz 3.','Összes válasz száma', 'Módosítás'],
    colModel :[ 
      {name:'id', index:'id', width:60, align:'center',editable:false}, 
      {name:'kerdes', index:'kerdes', width:200, align:'center',editable:true}, 
      {name:'valasz1', index:'valasz1', width:100, align:'center',editable:true}, 
      {name:'valasz2', index:'valasz2', width:100, align:'center',editable:true}, 
      {name:'valasz3', index:'valasz3', width:200 , align:'center',editable:true},
      {name:'osszes_valasz', index:'osszes_valasz', width:150, align:'center',editable:false, sortable:false},
      {name:'modositas', index:'modositas', width:200 , align:'center',editable:false},
    ],
    pager: $('#pager'),
    rowNum:10,
    rowList:[10,20,30],
    sortname: 'id',
    sortorder: 'desc',
    viewrecords: true,
    gridview: true,
    caption: 'Felmérések kezelése',
    editurl: 'php/edit.php',
    shrinkToFit: false
  });
  
  /*
   * Szerkesztés,hozzáadás,törlés gombok
   */
  
  $("#felmeresmanagement").jqGrid('navGrid', '#pager', {
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
   * Oszlopok gomb hozzáadása
   */
  
  $("#felmeresmanagement").jqGrid('navButtonAdd','#pager',{
      caption: "Oszlopok",
      title: "Oszlopok rendezése",
      onClickButton : function (){
        jQuery("#felmeresmanagement").jqGrid('columnChooser');
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
	  
	  $("#felmeresmanagement").trigger("reloadGrid");
	  
	  return [success,message,new_id];
	  
  }
  /*
   * Sorsolás gomb
   */
  $("#sorsolas").click(function(e){
	
	  e.preventDefault();
	  
	  var valasz = $("#valasz").val();
	  var darab = $("#darab").val();
	  var kerdes = $("#kerdes").val();
	  
		$.post("php/sorsolas.php",{
	    	"valasz" : valasz,
	    	"darab" : darab,
	    	"kerdes" : kerdes
	      },function(resp){
	    	  $("#eredmeny").html(resp);
	      });
		
	});
  
});