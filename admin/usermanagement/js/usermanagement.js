$(function(){ 
  $("#usermanagement").jqGrid({
    url:'php/process.php',
    datatype: 'json',
    mtype: 'POST',
    colNames:['Id','Tagsági szám','Nem', 'Születési dátum','Anyja neve','Előnév','Vezetéknév','Keresztnév', 
              'Cégnév','Kapcsolattartó neve','Kapcsolattartó telefon','Kapcsolattartó e-mail',
              'Állandó irányítószám','Állandó helység','Állandó közterület','Állandó közterület típusa','Állandó házszám',
              'Állandó épület','Állandó lépcsőház','Állandó emelet','Állandó ajtó',
              'Levelezési irányítószám','Levelezési helység','Levelezési közterület','Levelezési közterület típusa','Levelezési házszám',
              'Levelezési épület','Levelezési lépcsőház','Levelezési emelet','Levelezési ajtó',
              'Vezetékes telefon','Mobil telefon','E-mail','Másodlagos e-mail','Rendszám','Gyártási év','Első forgalom','Műszaki vizsga',
              'Forgalmi engedély','Rendszám 2','Gyártási év 2','Első forgalom 2','Műszaki vizsga 2','Forgalmi engedély 2',
              'Tagtípus','Díjkategória','Státusz',
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
      {name:'cegnev', index:'cegnev', width:85, align:'center',editable:true},
      {name:'kapcsolattarto_vezeteknev', index:'kapcsolattarto_vezeteknev', width:85, align:'center',editable:true},
      {name:'kapcsolattarto_telefon', index:'kapcsolattarto_telefon', width:85, align:'center',editable:true},
      {name:'kapcsolattarto_email', index:'kapcsolattarto_email', width:85, align:'center',editable:true},
      {name:'allando_irsz', index:'allando_irsz', width:45, align:'center',editable:true}, 
      {name:'allando_helyseg', index:'allando_helyseg', width:90, align:'center',editable:true}, 
      {name:'allando_kozterulet', index:'allando_kozterulet', width:80, align:'center',editable:true}, 
      {name:'allando_kozterulet_jellege', index:'allando_kozterulet_jellege', width:80, align:'center',editable:true},
      {name:'allando_hazszam', index:'allando_hazszam', width:45, align:'center',editable:true},
      {name:'allando_epulet', index:'allando_epulet', width:45, align:'center',editable:true},
      {name:'allando_lepcsohaz', index:'allando_lepcsohaz', width:45, align:'center',editable:true},
      {name:'allando_emelet', index:'allando_emelet', width:45, align:'center',editable:true},
      {name:'allando_ajto', index:'allando_ajto', width:45, align:'center',editable:true},
      {name:'levelezesi_irsz', index:'levelezesi_irsz', width:45, align:'center',editable:true}, 
      {name:'levelezesi_helyseg', index:'levelezesi_helyseg', width:90, align:'center',editable:true}, 
      {name:'levelezesi_kozterulet', index:'levelezesi_kozterulet', width:80, align:'center',editable:true}, 
      {name:'levelezesi_kozterulet_jellege', index:'levelezesi_kozterulet_jellege', width:80, align:'center',editable:true},
      {name:'levelezesi_hazszam', index:'levelezesi_hazszam', width:45, align:'center',editable:true},
      {name:'levelezesi_epulet', index:'levelezesi_epulet', width:45, align:'center',editable:true},
      {name:'levelezesi_lepcsohaz', index:'levelezesi_lepcsohaz', width:45, align:'center',editable:true},
      {name:'levelezesi_emelet', index:'levelezesi_emelet', width:45, align:'center',editable:true},
      {name:'levelezesi_ajto', index:'levelezesi_ajto', width:45, align:'center',editable:true},
      {name:'vezetekes_telefon', index:'vezetekes_telefon', width:90,editable:true}, 
      {name:'mobil_telefon', index:'mobil_telefon', width:80, align:'center',editable:true}, 
      {name:'e_mail', index:'e_mail', width:80, align:'center',editable:true}, 
      {name:'e_mail_2', index:'e_mail_2', width:80, align:'center',editable:true},
      {name:'rendszam', index:'rendszam', width:80, align:'center',editable:true},
      {name:'gyartasi_ev', index:'gyartasi_ev', width:80, align:'center',editable:true},
      {name:'elso_forgalom', index:'elso_forgalom', width:80, align:'center',editable:true},
      {name:'muszaki_vizsga', index:'muszaki_vizsga', width:80, align:'center',editable:true},
      {name:'forgalmi_engedely', index:'forgalmi_engedely', width:80, align:'center',editable:true},
      {name:'rendszam_2', index:'rendszam_2', width:80, align:'center',editable:true},
      {name:'gyartasi_ev_2', index:'gyartasi_ev_2', width:80, align:'center',editable:true},
      {name:'elso_forgalom_2', index:'elso_forgalom_2', width:80, align:'center',editable:true},
      {name:'muszaki_vizsga_2', index:'muszaki_vizsga_2', width:80, align:'center',editable:true},
      {name:'forgalmi_engedely_2', index:'forgalmi_engedely_2', width:80, align:'center',editable:true},
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
    	 
    	  var id = $('#usermanagement').jqGrid('getGridParam','selrow');
    	  
	  $.post("php/edit.php",{
			"id" : id,
			"action" : 'getuser'
			},function(resp){
				//alert(resp);
				$("#modal").html(resp).dialog();
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