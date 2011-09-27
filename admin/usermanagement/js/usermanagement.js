$(function(){ 
  $("#usermanagement").jqGrid({
    url:'php/process.php',
    datatype: 'json',
    mtype: 'POST',
    colNames:['Id','Tagsági szám','Nem', 'Születési dátum','Anyja neve','Előnév','Vezetéknév','Keresztnév',
              'Állandó irányítószám','Állandó helység','Állandó közterület','Állandó házszám',
              'Levelezési irányítószám','Levelezési helység','Levelezési közterület','Levelezési házszám',
              'Vezetékes telefon','Mobil telefon','E-mail','Rendszám','Tagtípus','Díjkategória','Státusz',
              'Belépés dátuma','Érvényesség dátuma','Befizetés dátuma','Befizetett összeg','Tranzakció kódja'],
    colModel :[ 
      {name:'id', index:'id', width:34, align:'center',editable:false},
      {name:'tagsagi_szam', index:'tagsagi_szam', width:90, editable:true}, 
      {
    	  name:'nem', 
    	  index:'nem', 
    	  width:34,
    	  editable:true,
    	  edittype:'select',
    	  editoptions:{
    		  value:'F:Férfi;N:Nő;C:Cég'
    	  },
      }, 
      {name:'szuletesi_datum', index:'szuletesi_datum', width:90, align:'center',editable:true}, 
      {name:'anyja_neve', index:'anyja_neve', width:100, align:'center',editable:true}, 
      {name:'elonev', index:'elonev', width:45, align:'center',editable:true}, 
      {name:'vezeteknev', index:'vezeteknev', width:85 , align:'center',editable:true},
      {name:'keresztnev', index:'keresztnev', width:85, align:'center',editable:true}, 
      {name:'allando_irsz', index:'allando_irsz', width:45, align:'center',editable:true}, 
      {name:'allando_helyseg', index:'allando_helyseg', width:90, align:'center',editable:true}, 
      {name:'allando_kozterulet', index:'allando_kozterulet', width:80, align:'center',editable:true}, 
      {name:'allando_hazszam', index:'allando_hazszam', width:45, align:'center',editable:true}, 
      {name:'levelezesi_irsz', index:'levelezesi_irsz', width:45,editable:true}, 
      {name:'levelezesi_helyseg', index:'levelezesi_helyseg', width:80, align:'center',editable:true}, 
      {name:'levelezesi_kozterulet', index:'levelezesi_kozterulet', width:80, align:'center',editable:true}, 
      {name:'levelezesi_hazszam', index:'levelezesi_hazszam', width:45, align:'center',editable:true},
      {name:'vezetekes_telefon', index:'vezetekes_telefon', width:90,editable:true}, 
      {name:'mobil_telefon', index:'mobil_telefon', width:80, align:'center',editable:true}, 
      {name:'e_mail', index:'e_mail', width:80, align:'center',editable:true}, 
      {name:'rendszam', index:'rendszam', width:80, align:'center',editable:true},
      {name:'tagtipus', index:'tagtipus', width:45,align:'center',editable:true}, 
      {name:'dijkategoria', index:'dijkategoria', width:45, align:'center',editable:true}, 
      {name:'statusz', index:'statusz', width:45, align:'center',editable:true}, 
      {name:'belepes_datuma', index:'belepes_datuma', width:80, align:'center',editable:true},
      {name:'ervenyesseg_datuma', index:'ervenyesseg_datuma', width:90, align:'center',editable:true}, 
      {name:'befizetes_datuma', index:'befizetes_datuma', width:80, align:'center',editable:true}, 
      {name:'befizetett_osszeg', index:'befizetett_osszeg', width:80, align:'center',editable:true}, 
      {name:'tranzakcio_kodja', index:'tranzakcio_kodja', width:45, align:'center',editable:true},
    ],
    pager: $('#pager'),
    rowNum:10,
    rowList:[10,20,30],
    sortname: 'tagsagi_szam',
    sortorder: 'desc',
    viewrecords: true,
    gridview: true,
    caption: 'Regisztrál felhasználók kezelése',
    editurl: 'php/edit.php',
    shrinkToFit: false
  });
  
  $("#usermanagement").jqGrid('navGrid', '#pager', {
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
  
  $("#usermanagement").jqGrid('navButtonAdd','#pager',{
      caption: "Oszlopok",
      title: "Oszlopok rendezése",
      onClickButton : function (){
        jQuery("#usermanagement").jqGrid('columnChooser');
    }
   });

  $("#usermanagement").jqGrid('navButtonAdd','#pager',{
      caption: "Információ",
      title: "Információ",
      onClickButton : function (){
	  $.post("edit.php",{
			"id" : jQuery('#usermanagement').jqGrid('getGridParam','selarrrow'),
			"action" : 'getuser'
			},function(resp){
				alert(resp);
			});
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
	  
	  $("#usermanagement").trigger("reloadGrid");
	  
	  return [success,message,new_id];
	  
  }
  
});