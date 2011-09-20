<?php 

class mak extends db{
	
	private $_imageDir = 'img/';
	private $_imageDirLeft = 'img/ikonok/big/';
	private $_galleryDir = 'img/gallery/';
	private $_autoseletDir = 'media/autoselet/';
	private $_hirekDir = 'img/hirek/';
	private $_hirdetesDir = 'img/ad/';
	private $_enautoklubomDir = 'my_landing/';

	public function __construct($debug=false){
		parent::__construct('','','','','',$debug);
		
		if(isset($_COOKIE['user_id']) && isset($_COOKIE['tagsag']) && isset($_COOKIE['keresztnev'])){
			$_SESSION['user_id'] = $_COOKIE['user_id'];
			$_SESSION['tagsag'] = $_COOKIE['tagsag'];
			$_SESSION['keresztnev'] = $_COOKIE['keresztnev'];
		}
	}

	//SELECT
	
	protected function get_iranyitoszam($cond=''){
		
		/*
		 * A kondícióknak megfelelő irányítószámot és várost kérdezi le
		 * 
		 * @access protected
		 * @param array $cond - key: oszlop neve; value: oszlopra vonatkozó megkötés
		 * @return array
		 * 
		 */
	
		$table = 'mak_irsz';
		$col = 'irsz,varos';
		
		if($cond != ''){
			$cond = GUMP::sanitize($cond);
		}
		
		return $this->sql_select($table,$col,$cond);
		
	}
	
	public function get_varos_irsz($irsz){
	
		/*
		 * A paraméterben kapott irányítószámhoz tartozó város nevét adja vissza
		 * 
		 * @param string $irsz
		 * @return mixed
		 */
	
		if(strlen($irsz) != 4){
			return 'Az irányítószám 4 számjegyből áll!';
		}else{
			$irsz = (int)$irsz;
		}
		
		$cond['irsz'] = $irsz;
		
		return $this->get_iranyitoszam($cond);
	
	}
	
	public function get_gyartmany($cond=''){
	
		/*
		 * A paraméterben kapott kondícióknak megfelelő gyártmány(oka)t és típus(oka)t adja vissza
		 * 
		 * @param array $cond
		 * @return mixed
		 * 
		 */
	
		$table = 'mak_gyartmany';
		$col = 'mak_gyartmany.id AS id,mak_marka.marka AS marka,mak_gyartmany.tipus AS tipus,mak_marka.sap_kod AS marka_sap_kod,mak_gyartmany.sap_kod AS gyartmany_sap_kod,mak_gyartmany.display AS gyartmany_display,mak_marka.display AS marka_display';
		
		$join[0]['type'] = 'INNER JOIN';
		$join[0]['table'] = 'mak_marka';
		$join[0]['value'] = 'mak_marka.id=mak_gyartmany.marka';
		
		if($cond != ''){
			$cond = GUMP::sanitize($cond);
		}
		if($join != ''){
			$join = GUMP::sanitize($join);
		}
		
		$cond['mak_gyartmany.sap_kod']['val'] = '';
		$cond['mak_gyartmany.sap_kod']['rel'] = "<>";
		$cond['mak_gyartmany.sap_kod']['and_or'] = "AND";
		
		return $this->sql_select($table,$col,$cond,$join);
		
	}

	public function get_felhasznalo($cond='',$col=''){
	
		$table = 'mak_felhasznalo';
	
		if($cond != ''){
			$cond = GUMP::sanitize($cond);
		}
		
		$col = trim($col);
		
		if($col == ''){
			$col = 'id,nem,jelszo,tagsagi_szam,szuletesi_datum,anyja_neve,elonev,vezeteknev,cegnev,alapitas_eve,kapcsolattarto_keresztnev,kapcsolattarto_vezeteknev,keresztnev,allando_irsz,allando_helyseg,allando_kozterulet,allando_hazszam,levelezesi_irsz,levelezesi_helyseg,levelezesi_kozterulet,levelezesi_hazszam,vezetekes_telefon,mobil_telefon,e_mail,rendszam,gyartmany_sap,tipus_sap,gyartasi_ev,elso_forgalom,tagtipus,dijkategoria,statusz,belepes_datuma,ervenyesseg_datuma,befizetes_datuma,befizetett_osszeg,tranzakcio_kodja,modositas';
		}
		
		return $this->sql_select($table,$col,$cond);
	
	}
	
	public function get_adatok_regisztraciohoz($adatok){
		
		if(!is_array($adatok)){
			return FALSE;
		}
	
		$rules = array(
			'tagsagi_szam'    => 'required|alpha_numeric|exact_len,11',
			'e_mail'       => 'required|valid_email'
		);
		
		$filters = array(
			'tagsagi_szam' 	  => 'trim|sanitize_string',
			'e_mail'    	  => 'trim|sanitize_email'
		);
		
		$adatok = GUMP::filter($adatok, $filters);

		$validate = GUMP::validate($adatok, $rules);

		if($validate === TRUE){
			return $this->get_felhasznalo($adatok);
		}else{
			return FASLE;
		}
	
	}
	
	public function get_login($felhasznalo_nev){
	
		$cond['felhasznalonev'] = $felhasznalo_nev;
		$cond['megerositve'] = '1';
		//$cond['jelszo'] = $jelszo;
		
		$table = 'mak_felhasznalo';
		
		$cond = GUMP::sanitize($cond);
		
		$col = 'id,jelszo,nem,keresztnev,kapcsolattarto_keresztnev,dijkategoria';
		
		$filters = array(
			'felhasznalonev' => 'trim',
		);
		
		$rules = array(
			'felhasznalonev'    => 'required|max_len,100|min_len,6',
		);
		
		if(GUMP::validate(GUMP::filter($cond, $filters), $rules) === TRUE){
			return $this->sql_select($table,$col,$cond);
		}else{
			return FALSE;
		}
	
	}
	
	public function get_tartalom($cond='',$col='',$join=''){
		
		$table = 'mak_tartalom';
	
		if($cond != '' && !is_array($cond)){
			return FALSE;
		}
		
		if($cond != ''){
			$cond = GUMP::sanitize($cond);
		}
		
		if($join != ''){
			$join = GUMP::sanitize($join);
		}
		
		if(!isset($cond['orderby'])){
			$cond['orderby'] = 'mak_kategoria.sorrend ASC, mak_almenu.sorrend ASC, mak_tartalom.sorrend ASC';
		}
		
		if(!isset($_SESSION['user_id']) || $_SESSION['user_id'] == ''){
			$cond['mak_tartalom.regisztralt_tagnak'] = '0';
		}
		
		$join[0]['table'] = 'mak_almenu';
		$join[0]['value'] = 'mak_almenu.id=mak_tartalom.almenu_id';
		$join[0]['type'] = 'LEFT JOIN';
		$join[1]['table'] = 'mak_kategoria';		
		$join[1]['value'] = 'mak_kategoria.id=mak_almenu.kategoria_id';
		$join[1]['type'] = 'LEFT JOIN';
		
		
		if($col == ''){
			$col = 'mak_tartalom.id AS id,mak_tartalom.almenu_id AS almenu_id,mak_tartalom.cim AS cim,mak_tartalom.szoveg AS szoveg,mak_tartalom.kep AS kep,mak_tartalom.alt AS alt,mak_tartalom.url AS tartalom_url,';
			$col .= 'mak_kategoria.email AS email,mak_kategoria.telefon AS telefon,mak_kategoria.kategoria_nev AS kategoria_nev,mak_kategoria.azonosito AS azonosito,mak_almenu.url AS url,';
			$col .= 'mak_almenu.almenu AS almenu,mak_almenu.title AS title,mak_almenu.description AS description,mak_almenu.keywords AS keywords,mak_tartalom.publikalta AS publikalta,mak_almenu.szoveg AS almenu_szoveg,mak_almenu.kep AS almenu_kep,mak_almenu.alt AS almenu_alt';
		}
		
		return $this->sql_select($table,$col,$cond,$join);
	
	}

	public function get_kategoria_tartalom($kategoria){
	
		$join = '';
		$kategoria = trim($kategoria);
		
		$table = 'mak_kategoria';
		
		$join[0]['table'] = 'mak_almenu';
		$join[0]['value'] = 'mak_almenu.kategoria_id=mak_kategoria.id';
		$join[0]['type'] = 'LEFT JOIN';
		
		$cond['azonosito'] = $kategoria;
		
		$col = 'mak_kategoria.id AS id,kategoria_nev,azonosito,email,telefon,mak_kategoria.szoveg AS szoveg,mak_kategoria.kep AS kep,mak_kategoria.alt AS alt';
		$col .= ',mak_almenu.url AS almenu_url,mak_almenu.almenu AS almenu,mak_almenu.title AS almenu_title,mak_almenu.szoveg AS almenu_szoveg,mak_almenu.kep AS almenu_kep,mak_almenu.alt AS almenu_alt';
		
		return $this->sql_select($table,$col,$cond,$join);
	
	}
	
	public function get_oldal_tartalom($oldal,$cond=''){
	
		$join[2]['type'] = 'LEFT JOIN';
		$join[2]['table'] = 'mak_altartalom';		
		$join[2]['value'] = 'mak_altartalom.tartalom_id=mak_tartalom.id';
		
		
		$col = 'mak_kategoria.email AS email,mak_kategoria.telefon AS telefon,mak_kategoria.kategoria_nev AS kategoria_nev,mak_kategoria.azonosito AS azonosito,mak_almenu.url AS url,';
		$col .= 'mak_almenu.almenu AS almenu,mak_almenu.title AS title,mak_almenu.description AS description,mak_almenu.keywords AS keywords,mak_almenu.szoveg AS almenu_szoveg,';
		$col .= 'mak_altartalom.id AS altartalom_id,mak_altartalom.cim AS altartalom_cim,mak_altartalom.szoveg AS altartalom_szoveg,mak_altartalom.kep AS altartalom_kep,mak_altartalom.alt AS altartalom_alt,mak_altartalom.publikalta AS altartalom_publikalta,';
		$col .= 'mak_tartalom.id AS id,mak_tartalom.almenu_id AS almenu_id,mak_tartalom.cim AS cim,mak_tartalom.szoveg AS szoveg,mak_tartalom.kep AS kep,mak_tartalom.alt AS alt,mak_tartalom.url AS tartalom_url,mak_altartalom.url AS altartalom_url,';
		$col .= 'mak_tartalom.publikalta AS publikalta';
		
		if($cond == ''){
			$cond['mak_tartalom.url'] = $oldal;
		}
	
		return $this->get_tartalom($cond,$col,$join);
		
	}
	
	public function get_aloldal_altartalom($url){
	
		$join[2]['table'] = 'mak_altartalom';		
		$join[2]['value'] = 'mak_altartalom.tartalom_id=mak_tartalom.id';
	
		$cond['mak_altartalom.url'] = $url;
		
		$col = 'mak_kategoria.email AS email,mak_kategoria.telefon AS telefon,mak_kategoria.kategoria_nev AS kategoria_nev,mak_kategoria.azonosito AS azonosito,mak_almenu.url AS url,';
		$col .= 'mak_almenu.almenu AS almenu,mak_almenu.title AS title,mak_almenu.description AS description,mak_almenu.keywords AS keywords,';
		$col .= 'mak_altartalom.id AS id,mak_altartalom.tartalom_id AS tartalom_id,mak_altartalom.cim AS cim,mak_altartalom.szoveg AS szoveg,mak_altartalom.kep AS kep,mak_altartalom.alt AS alt,mak_altartalom.publikalta AS publikalta';
		
		return $this->get_tartalom($cond,$col,$join);
		
	}
	
	public function get_aloldal_tartalom($url){
	
		$cond['mak_tartalom.url'] = $url;
		
		/*
		$col = 'mak_kategoria.email AS email,mak_kategoria.telefon AS telefon,mak_kategoria.kategoria_nev AS kategoria_nev,mak_kategoria.azonosito AS azonosito,mak_almenu.url AS url,';
		$col .= 'mak_almenu.almenu AS almenu,mak_almenu.title AS title,mak_almenu.description AS description,mak_almenu.keywords AS keywords,mak_almenu.szoveg AS szoveg';
		$col .= 'mak_altartalom.id AS id,mak_altartalom.tartalom_id AS tartalom_id,mak_altartalom.cim AS cim,mak_altartalom.szoveg AS szoveg,mak_altartalom.kep AS kep,mak_altartalom.alt AS alt,mak_altartalom.publikalta AS publikalta';
		*/
		return $this->get_tartalom($cond,$col,$join);
	
	}
	
	public function get_tartalom_kereses($kereses,$cond=''){
	
		/*
		 * A szabadszavas keresőből érkező kifejezésnek megfelelő tartalmak
		 */
	
		$keres['kereses'] = $kereses;
	
		$keres = GUMP::sanitize($keres);
		
		//Validálás
		
		$rules = array(
			'kereses' => 'required',
		);
		
		$filters = array(
			'kereses' => 'trim|sanitize_string',
		);

		$keres = GUMP::filter($keres, $filters);
		
		$validate = GUMP::validate($keres, $rules);

		//Validálás vége
		
		if($validate === TRUE){
		
			$cond['mak_tartalom.cim']['val'] = '%'.$keres['kereses'].'%';
			$cond['mak_tartalom.cim']['rel'] = "LIKE";
			$cond['mak_tartalom.cim']['and_or'] = "OR";
			
			$cond['mak_tartalom.szoveg']['val'] = '%'.$keres['kereses'].'%';
			$cond['mak_tartalom.szoveg']['rel'] = "LIKE";
			$cond['mak_tartalom.szoveg']['and_or'] = "OR";
			/*
			$cond['mak_almenu.almenu']['val'] = '%'.$keres['kereses'].'%';
			$cond['mak_almenu.almenu']['rel'] = "LIKE";
			$cond['mak_almenu.almenu']['and_or'] = "OR";
		
			$cond['mak_kategoria.kategoria_nev']['val'] = '%'.$keres['kereses'].'%';
			$cond['mak_kategoria.kategoria_nev']['rel'] = "LIKE";
			$cond['mak_kategoria.kategoria_nev']['and_or'] = "OR";
			*/
			return $this->get_tartalom($cond);
		
		}else{
			return 'Invalid';
		}
	
	}
	
	public function get_galeria($cond='',$col='',$join=''){
		
		$table = 'mak_galeria';
		
		if($cond != ''){
			$cond = GUMP::sanitize($cond);
		}
		
		if($join != ''){
			$join = GUMP::sanitize($join);
		}
		
		if($cond != '' && !is_array($cond)){
			return FALSE;
		}
		
		if($col == ''){
			$col = 'id,kep_filenev,thumbnail_filenev,alt,mak_tartalom_id,modositas';
		}
		
		return $this->sql_select($table,$col,$cond,$join);
	
	}

	public function get_galeria_tartalomhoz($tartalom_id){
		
		$col = 'kep_filenev,thumbnail_filenev,alt';
		$cond['mak_tartalom_id'] = (int)$tartalom_id;
		
		return $this->get_galeria($cond,$col);
	}
	
	public function get_menu_aktualis_almenuhoz($almenu){
		
		/*
		 * @param string $almenu : az aktuális almenü url-ben található azonosítója
		 * @return mixed : FALSE vagy a lekérdezett elemek egy tömbben
		 * 
		 */
		
		$almenu = trim($almenu);
		
		if($almenu == ''){
			return FALSE;
		}
		
		$cond['mak_almenu.url']['val'] = $almenu;
		$cond['mak_almenu.url']['and_or'] = 'OR';
		$cond['mak_almenu.url']['rel'] = '=';
		
		$cond['mak_altartalom.url']['val'] = $almenu;
		$cond['mak_altartalom.url']['and_or'] = 'OR';
		$cond['mak_altartalom.url']['rel'] = '=';
		
		$cond['mak_kategoria.azonosito']['val'] = $almenu;
		$cond['mak_kategoria.azonosito']['and_or'] = 'OR';
		$cond['mak_kategoria.azonosito']['rel'] = '=';
		
		$cond['orderby'] = 'mak_kategoria.sorrend ASC,mak_almenu.sorrend ASC,mak_tartalom.sorrend ASC,mak_altartalom.sorrend ASC';

		$table = 'mak_kategoria';

		$col = 'mak_kategoria.email AS email,mak_kategoria.telefon AS telefon,mak_kategoria.kategoria_nev AS kategoria_nev,mak_kategoria.azonosito AS azonosito,mak_almenu.url AS url,';
		$col .= 'mak_almenu.almenu AS almenu,mak_almenu.title AS title,mak_almenu.description AS description,mak_almenu.keywords AS keywords,';
		$col .= 'mak_altartalom.id AS altartalom_id,mak_altartalom.tartalom_id AS tartalom_id,mak_altartalom.cim AS altartalom_cim,mak_altartalom.szoveg AS altartalom_szoveg,mak_altartalom.kep AS altartalom_kep,mak_altartalom.alt AS altartalom_alt,mak_altartalom.publikalta AS altartalom_publikalta,mak_altartalom.url AS altartalom_url,';
		$col .= 'mak_tartalom.id AS id,mak_tartalom.almenu_id AS almenu_id,mak_tartalom.cim AS cim,mak_tartalom.szoveg AS szoveg,mak_tartalom.kep AS kep,mak_tartalom.alt AS alt,mak_tartalom.url AS tartalom_url';
		$col .= ',mak_tartalom.regisztralt_tagnak';
		
		$join[0]['table'] = 'mak_almenu';		
		
		
		if(!isset($_SESSION['user_id']) || $_SESSION['user_id'] == ''){
			$join[0]['value'] = 'mak_almenu.kategoria_id=mak_kategoria.id AND mak_almenu.regisztralt_tagnak=0';
		}else{
			$join[0]['value'] = 'mak_almenu.kategoria_id=mak_kategoria.id';
		}
		
		$join[0]['type'] = 'LEFT JOIN';
		
		$join[1]['table'] = 'mak_tartalom';
		
		if(!isset($_SESSION['user_id']) || $_SESSION['user_id'] == ''){
			$join[1]['value'] = 'mak_tartalom.almenu_id=mak_almenu.id AND mak_tartalom.regisztralt_tagnak=0';
		}else{
			$join[1]['value'] = 'mak_tartalom.almenu_id=mak_almenu.id';
		}
		$join[1]['type'] = 'LEFT JOIN';
		
		$join[2]['table'] = 'mak_altartalom';		
		$join[2]['value'] = 'mak_altartalom.tartalom_id=mak_tartalom.id';
		$join[2]['type'] = 'LEFT JOIN';
	
		return $this->sql_select($table,$col,$cond,$join);
	}
	
	public function get_parameterek_urlbol($url,$aloldal='',$tartalom='',$altartalom=''){
	
		$parameterek = array();
		
		if($url == ''){
			return FALSE;
		}
		
		$parameterek = $this->get_kategoria_parameterek_urlbol($url);
		
		if($aloldal != ''){
			$parameterek = array_merge($parameterek , $this->get_aloldal_parameterek_urlbol($aloldal));
		}
		
		if($tartalom != ''){
			$parameterek = array_merge($parameterek , $this->get_tartalom_parameterek_urlbol($tartalom));
		}
		
		if($altartalom != ''){
			$parameterek = array_merge($parameterek , $this->get_altartalom_parameterek_urlbol($altartalom));
		}
		
		return $parameterek;
	
	}
	
	public function get_aloldal_parameterek_urlbol($url){
		
		if($url == ''){
			return FALSE;
		}
		
		/*
		 * A szervízőpontok id alapján kerülnek azonosításra, 
		 * más esetben nem használunk kizárólag numerikus karaktereket
		 * az aloldal meghatározására
		 */		
		
		
		if(is_numeric($url)){
		
			$a = $this->get_szervizpont_idbol($url);

			$parameterek = $a[0];
			
			$parameterek['h1'] = 'Szervízpont - ' . $a[0]['cim'];
			
			$kw = explode(" ",$a[0]['cim']);
			$kws = implode(",",$kw);
			
			$parameterek['keywords'] = 'szervizpont,' . $kws;
			$parameterek['description'] = 'Részletes információk az alábbi címen található Szervizpontunkról: ' . $a[0]['cim'];
			
		}else{
		
			$table = 'mak_almenu';
			$col = 'mak_almenu.almenu AS almenu,mak_almenu.title AS title,mak_almenu.keywords AS keywords,mak_almenu.description AS description,mak_almenu.css AS css,mak_almenu.javascript AS javascript';
			$cond['mak_almenu.url'] = $url;
		
			$a = $this->sql_select($table,$col,$cond);
			
			$parameterek = $a[0];
			
		}
		
		return $parameterek;
		
	}

	public function get_altartalom_parameterek_urlbol($aloldal_url){
	
		if($aloldal_url == ''){
			return FALSE;
		}
		
		$table = 'mak_altartalom';
		$col = 'mak_altartalom.title AS title,mak_altartalom.keywords AS keywords,mak_altartalom.description AS description,mak_altartalom.css AS css,mak_altartalom.javascript AS javascript';
		$cond['mak_altartalom.url'] = $aloldal_url;
		
		$a = $this->sql_select($table,$col,$cond);
		
		$parameterek = $a[0];
	
		return $parameterek;
	
	}
	
	public function get_tartalom_parameterek_urlbol($aloldal_url){
	
		if($aloldal_url == ''){
			return FALSE;
		}
		
		$table = 'mak_tartalom';
		$col = 'mak_tartalom.cim AS title,mak_tartalom.keywords AS keywords,mak_tartalom.description AS description,mak_tartalom.css AS css,mak_tartalom.javascript AS javascript';
		$cond['mak_tartalom.url'] = $aloldal_url;
		
		$a = $this->sql_select($table,$col,$cond);
		
		$parameterek = $a[0];
		
		return $parameterek;
	
	}
	
	public function get_kategoria_parameterek_urlbol($url){
	
		if($url == ''){
			return FALSE;
		}
		
		$table = 'mak_kategoria';
		$col = 'mak_kategoria.kategoria_nev AS title,mak_kategoria.keywords AS keywords,mak_kategoria.description AS description,mak_kategoria.css AS css,mak_kategoria.javascript AS javascript';
		$cond['mak_kategoria.azonosito'] = $url;
		
		$a = $this->sql_select($table,$col,$cond);
		
		$parameterek = $a[0];
		
		return $parameterek;
	
	
	}
	
	public function get_kategoria_urlbol($url){
	
		if($url == ''){
			return FALSE;
		}
	
		$table = 'mak_almenu';
		$col = 'mak_almenu.kategoria_id AS kategoria_id';
		$cond['mak_almenu.url'] = $url;
	
		$a = $this->sql_select($table,$col,$cond);
		
		return $a[0]['kategoria_id'];
	
	}
	
	public function get_autoselet($evfolyam='',$lapszam=''){
	
		$table = 'mak_autoselet';
		
		$evfolyam = trim($evfolyam);
		$lapszam = trim($lapszam);
		
		if($evfolyam != ''){
			$cond['evfolyam'] = $evfolyam;
		}
		
		if($lapszam != ''){
			$cond['lapszam'] = $lapszam;
		}
		
		$cond['orderby'] = ' evfolyam desc, lapszam asc';
		
		$col = 'id,kep_filenev,evfolyam,lapszam,modositas';
		
		if(isset($_SESSION['tagsag']) && $_SESSION['tagsag'] == 3){
			$col .= ',embed_kod';
		}else{
			$col .= ',embed_kod_rovid AS embed_kod';
		}
		
		return $this->sql_select($table,$col,$cond);
	
	}
	
	public function get_autoselet_utolso(){
	
		$utolso = $this->get_autoselet();
		
		$autoselet[0] = $utolso[0];
		$autoselet['count'] = 1;
		
		return $autoselet;
	
	}
	
	public function get_szervizpont($cond=''){
	
		if(!is_array($cond) && $cond != ''){
			return FALSE;
		}
		
		if($cond != ''){
			GUMP::sanitize($cond);
		}
		
		$table = 'mak_szervizpontok';
		
		$col = 'id,cim,telefon_fax,e_mail,nyitvatartas,szoveg,lat,lng,modositas';	
		
		return $this->sql_select($table,$col,$cond);
	
	}
	
	public function get_szervizpont_idbol($id){
	
		if($id == ''){
			return FALSE;
		}
	
		$id = (int)$id;
		$cond['id'] = $id;
	
		return $this->get_szervizpont($cond);
	
	}
	
	public function get_hirdetes($cond,$col=''){
	
		$table = 'mak_hirdetes';
		
		if($cond != ''){
			$cond = GUMP::sanitize($cond);
		}
		
		if($cond != '' && !is_array($cond)){
			return FALSE;
		}
		
		if($col == ''){
			$col = 'id,mak_url,kep,alt,cel_url,modositas,utolso_mutatas';
		}
		
		return $this->sql_select($table,$col,$cond);
	
	}

	public function get_hirdetes_urlhez($url){
	
		$url = trim($url);
		
		$cond['mak_url'] = $url;
		$cond['orderby'] = 'utolso_mutatas ASC';
		
		return $this->get_hirdetes($cond);
	
	}
	
	public function get_felmeres($cond,$col=''){
	
		$table = 'mak_felmeres';
		
		if($cond != ''){
			$cond = GUMP::sanitize($cond);
		}
		
		if($cond != '' && !is_array($cond)){
			return FALSE;
		}
		
		if($col == ''){
			$col = 'id,kerdes,valasz1,valasz2,valasz3,valasz1_db,valasz2_db,valasz3_db,modositas';
		}
		
		return $this->sql_select($table,$col,$cond);
	
	}
	
	public function get_felmeres_idbol($id){
	
		$id = trim($id);
	
		$cond['id'] = $id;
	
		return $this->get_felmeres($cond);
	
	}
	
	public function get_felmeres_legujabb_id(){
		
		$cond['limit'] = 1;
		$cond['orderby'] = 'modositas desc';
	
		$a = $this->get_felmeres($cond);
		
		return $a[0]['id'];
	
	}
	
	public function get_felmeres_felhasznalo($cond,$col=''){
	
		$table = 'mak_felmeres_felhasznalo';
		
		if($cond != ''){
			$cond = GUMP::sanitize($cond);
		}
		
		if($cond != '' && !is_array($cond)){
			return FALSE;
		}
		
		if($col == ''){
			$col = 'id,kerdes_id,felhasznalo_id,valasz';
		}
		
		return $this->sql_select($table,$col,$cond);
	
	}

	public function get_felmeres_felhasznalo_szavazott(){
	
		$cond['felhasznalo_id'] = $_SESSION['user_id'];
		$cond['kerdes_id'] = $this->get_felmeres_legujabb_id();
	
		$valasz = $this->get_felmeres_felhasznalo($cond);
		
		if($valasz === FALSE || $valasz['count'] == 0){
			return FALSE;
		}else{
			return TRUE;
		}
	
	}
	
	public function sorsolas($felmeres_id,$jo_valasz_szama,$felhasznalo_darab){
	
		$cond['kerdes_id'] = trim($felmeres_id);
		
		if($jo_valasz_szama > 0 && $jo_valasz_szama != ''){
			$cond['valasz'] = trim($jo_valasz_szama);
		}
		
		$felhasznalok = $this->get_felmeres_felhasznalo($cond);
		
		if($felhasznalok === FALSE){
			return FALE;
		}
		
		if($felhasznalo_darab > $felhasznalok['count']){
			$felhasznalo_darab = $felhasznalok['count'];
		}
		
		//$kisorsolt = array_rand($felhasznalok, $felhasznalo_darab);
		$kisorsolt = array();
		
		while(count($kisorsolt) < $felhasznalo_darab){
			$b = rand(0,$felhasznalok['count']-1);
			if(!in_array($b, $kisorsolt)){
				$kisorsolt[] = $b;	
			}
		}
		
		$html = '';
		
		//print_r($kisorsolt);
		
		foreach($kisorsolt as $key){
		
			$cond = array();
			$cond['id'] = $felhasznalok[$key]['felhasznalo_id'];
			$a = $this->get_felhasznalo($cond);
			
			if($a[0]['nem'] == 'C'){
				$nev = $a[0]['kapcsolattarto_vezeteknev'] . ' ' . $a[0]['kapcsolattarto_keresztnev'];
			}else{
				$nev = $a[0]['elonev'] . ' ' . $a[0]['vezeteknev'] . ' ' . $a[0]['keresztnev'];
			}
			
			if($nev != '' && $a[0]['tagsagi_szam'] != ''){
				$html .= '<div class="user">' . $nev . ' - ' . $a[0]['tagsagi_szam'] . '</div>';
			}
		}
		
		return $html;
	
	}
	
	public function get_oldalterkep(){
	
		$table = 'mak_kategoria';	
		
		if($col == ''){
			$col = 'mak_kategoria.kategoria_nev AS kategoria,mak_kategoria.azonosito AS kategoria_url,';
			$col .= 'mak_almenu.almenu AS almenu,mak_almenu.url AS almenu_url,';
			$col .= 'mak_tartalom.cim AS tartalom,mak_tartalom.url AS tartalom_url,';
			$col .= 'mak_altartalom.cim AS altartalom,mak_altartalom.url AS altartalom_url';
		}
		
		$cond = array();
		$cond['orderby'] = 'mak_kategoria.sorrend ASC,mak_almenu.sorrend ASC,mak_tartalom.sorrend ASC,mak_altartalom.sorrend ASC';
		
		$join[0]['table'] = 'mak_almenu';
		$join[0]['value'] = 'mak_kategoria.id=mak_almenu.kategoria_id';
		$join[0]['type'] = 'LEFT JOIN';
		$join[1]['table'] = 'mak_tartalom';		
		$join[1]['value'] = 'mak_almenu.id=mak_tartalom.almenu_id';
		$join[1]['type'] = 'LEFT JOIN';
		$join[2]['table'] = 'mak_altartalom';		
		$join[2]['value'] = 'mak_tartalom.id=mak_altartalom.tartalom_id';
		$join[2]['type'] = 'LEFT JOIN';
		
		return $this->sql_select($table,$col,$cond,$join);
	
	
	}
	
	public function get_hirek($cond='',$col=''){
	
		$table = 'mak_hirek';
		
		if($cond != ''){
			$cond = GUMP::sanitize($cond);
		}
		
		if($cond != '' && !is_array($cond)){
			return FALSE;
		}
		
		if($col == ''){
			$col = 'id,cim,szoveg,kep,alt,publikalta,modositas';
		}
		
		return $this->sql_select($table,$col,$cond);
	
	}
	
	//INSERT
	
	public function insert_hirlevel($email){
		
		/*
		 * E-mail cím beillesztése a hírlevél táblába
		 * 
		 * @param string email
		 * @return string
		 */
	
		$col['email'] = $email;
		
		$col = GUMP::sanitize($col);
		
		//Validálás
		
		$rules = array(
			'email' => 'valid_email',
		);
		
		$filters = array(
			'email' => 'trim|sanitize_email',
		);

		$col = GUMP::filter($col, $filters);
		
		$validate = GUMP::validate($col, $rules);
	
		//Validálás vége
		
		if($validate === TRUE){
			if($this->sql_insert('mak_hirlevel',$col)){
				return 'Sikeres';
			}else{
				return 'Sikertelen';
			}	
		}
	}

	public function insert_tartalom($tartalom_array){

		/*
		 * Tartalom beillesztése a tartalom táblába
		 * 
		 * @param array tartalom_array - valid key értékek:
		 * 	oldal : char(255) - Melyik aloldalhoz tartozó tartalom
		 * 	cim : char(255) - Tartalom címe
		 * 	szoveg : text 
		 * 	kep : char(80) - a tartalomhoz tartozó képfájl
		 * 	alt : char(255) - a képfájl alt text-je
		 * @return string
		 */
	
		if(!is_array($tartalom_array)){
			return FALSE;
		}
		
		$tartalom_array = GUMP::sanitize($tartalom_array);
		
		//Validálás
		
		$rules = array(
			'oldal' => 'required|max_len,255',
			'cim' => 'required|max_len,255',
			'szoveg' => 'required',
			'kep' => 'required|max_len,80',
			'alt' => 'required|max_len,255',
		);
		
		$filters = array(
			'oldal' => 'trim|sanitize_string',
			'cim' => 'trim|sanitize_string',
			'szoveg' => 'trim|sanitize_string',
			'kep' => 'trim|sanitize_string',
			'alt' => 'trim|sanitize_string',
		);

		$tartalom_array = GUMP::filter($tartalom_array, $filters);
		
		$validate = GUMP::validate($tartalom_array, $rules);

		//Validálás vége
		
		if($validate === TRUE){
			if($this->sql_insert('mak_tartalom',$tartalom_array)){
				return 'Sikeres';
			}else{
				return 'Sikertelen';
			}	
		}else{
			if($this->debug){
				print_r($validate);
			}else{
				return 'Invalid adat';
			}
		}
	
	}

	public function insert_galeria($galeria_array){
	
		/*
		 * Kép beillesztése a galéria táblába
		 * 
		 * @param array galeria_array - valid key értékek:
		 * 	kep_filenev : char(255) - Kép file neve
		 * 	thumbnail_filenev : char(255) - Thumbnail file neve
		 * 	alt : char(255) - a képfájl alt text-je
		 * 	mak_tartalom_id : int(11) - mak_tartalom táblából vett id
		 * @return string
		 */
	
		if(!is_array($galeria_array)){
			return FALSE;
		}
		
		$galeria_array = GUMP::sanitize($galeria_array);
		
		//Validálás
		
		$rules = array(
			'kep_filenev' => 'required|max_len,255',
			'thumbnail_filenev' => 'required|max_len,255',
			'alt' => 'required|max_len,255',
			'mak_tartalom_id' => 'required|max_len,11|numeric',
		);
		
		$filters = array(
			'kep_filenev' => 'trim|sanitize_string',
			'thumbnail_filenev' => 'trim|sanitize_string',
			'alt' => 'trim|sanitize_string',
			'mak_tartalom_id' => 'trim|sanitize_numbers_only',
		);

		$galeria_array = GUMP::filter($galeria_array, $filters);
		
		$validate = GUMP::validate($galeria_array, $rules);

		//Validálás vége
		
		if($validate === TRUE){
			if($this->sql_insert('mak_galeria',$galeria_array)){
				return 'Sikeres';
			}else{
				return 'Sikertelen';
			}	
		}else{
			if($this->debug){
				print_r($validate);
			}else{
				return 'Invalid adat';
			}
		}
	
	}
	
	public function insert_felhasznalo($felhasznalo_array){
	
		/*
		 * Felhasználó beillesztése a felhasználó táblába
		 * 
		@param array felhasznalo_array - valid key értékek:
			mak_login_id : int(11)
		 	tagsagi_szam : char(11)
			nem : char(1)
			szuletesi_datum : date
			anyja_neve : char(40)
			elonev : char(30)
			vezeteknev : char(30)
			keresztnev : char(20)
			allando_irsz : char(4)
			allando_helyseg : char(30)
			allando_kozterulet : char(30)
			allando_hazszam : char(20)
			levelezesi_irsz : char(4)
			levelezesi_helyseg : char(30)
			levelezesi_kozterulet : char(30)
			levelezesi_hazszam : char(20)
			vezetekes_telefon : char(10)
			mobil_telefon : char(11)
			e_mail : char(100)
			rendszam : char(6)
			gyartmany_sap : char(4)
			tipus_sap : char(4)
			gyartasi_ev : year(4)
			elso_forgalom : date
			tagtipus : char(1)
			dijkategoria : char(1)
			statusz : char(2)
			belepes_datuma : date
			ervenyesseg_datuma : date
			befizetes_datuma : date
			befizetett_osszeg : int(5)
			tranzakcio_kodja : char(1)
		@return string
		 */
		
		if(!is_array($felhasznalo_array)){
			return FALSE;
		}
	
		$felhasznalo_array = GUMP::sanitize($felhasznalo_array);
		
		//Validálás
		
		$rules = array(
			'mak_login_id' => 'max_len,11',
			'tagsagi_szam' => 'exact_len,11',
			'nem' => 'exact_len,1',
			'szuletesi_datum' => 'exact_len,8',
			'anyja_neve' => 'max_len,40|alpha_dash',
			'elonev' => 'max_len,30',
			'vezeteknev' => 'max_len,30|alpha',
			'keresztnev' => 'max_len,20|alpha',
			'allando_irsz' => 'exact_len,4|numeric',
			'allando_helyseg' => 'max_len,30|alpha_dash',
			'allando_kozterulet' => 'max_len,30',
			'allando_hazszam' => 'max_len,20',
			'levelezesi_irsz' => 'exact_len,4|numeric',
			'levelezesi_helyseg' => 'max_len,30|alpha_dash',
			'levelezesi_kozterulet' => 'max_len,30',
			'levelezesi_hazszam' => 'max_len,20',
			'vezetekes_telefon' => 'exact_len,10|numeric',
			'mobil_telefon' => 'exact_len,11|numeric',
			'e_mail' => 'max_len,100|valid_email',
			'rendszam' => 'exact_len,6|alpha_numeric',
			'gyartmany_sap' => 'exact_len,4|numeric',
			'tipus_sap' => 'exact_len,4|numeric',
			'gyartasi_ev' => 'exact_len,4|numeric',
			'elso_forgalom' => 'exact_len,8|numeric',
			'tagtipus' => 'exact_len,1|numeric',
			'dijkategoria' => 'exact_len,1|numeric',
			'statusz' => 'exact_len,2|numeric',
			'belepes_datuma' => 'exact_len,8|numeric',
			'ervenyesseg_datuma' => 'exact_len,8|numeric',
			'befizetes_datuma' => 'exact_len,8|numeric',
			'befizetett_osszeg' => 'max_len,5|numeric',
			'tranzakcio_kodja' => 'exact_len,1|numeric',
		);
		
		$filters = array(
			'mak_login_id' => 'trim|sanitize_numbers_only',
			'tagsagi_szam' => 'trim|sanitize_numbers_only',
			'nem' => 'trim|sanitize_string',
			'szuletesi_datum' => 'trim|sanitize_numbers_only',
			'anyja_neve' => 'trim|sanitize_numbers_only',
			'elonev' => 'trim|sanitize_string',
			'vezeteknev' => 'trim|sanitize_string',
			'keresztnev' => 'trim|sanitize_string',
			'allando_irsz' => 'trim|sanitize_numbers_only',
			'allando_helyseg' => 'trim|sanitize_string',
			'allando_kozterulet' => 'trim|sanitize_string',
			'allando_hazszam' => 'trim|sanitize_string',
			'levelezesi_irsz' => 'trim|sanitize_numbers_only',
			'levelezesi_helyseg' => 'trim|sanitize_string',
			'levelezesi_kozterulet' => 'trim|sanitize_string',
			'levelezesi_hazszam' => 'trim|sanitize_string',
			'vezetekes_telefon' => 'trim|sanitize_numbers_only',
			'mobil_telefon' => 'trim|sanitize_numbers_only',
			'e_mail' => 'trim|sanitize_email',
			'rendszam' => 'trim|sanitize_string',
			'gyartmany_sap' => 'trim|sanitize_numbers_only',
			'tipus_sap' => 'trim|sanitize_numbers_only',
			'gyartasi_ev' => 'trim|sanitize_numbers_only',
			'elso_forgalom' => 'trim|sanitize_numbers_only',
			'tagtipus' => 'trim|sanitize_numbers_only',
			'dijkategoria' => 'trim|sanitize_numbers_only',
			'statusz' => 'trim|sanitize_numbers_only',
			'belepes_datuma' => 'trim|sanitize_numbers_only',
			'ervenyesseg_datuma' => 'trim|sanitize_numbers_only',
			'befizetes_datuma' => 'trim|sanitize_numbers_only',
			'befizetett_osszeg' => 'trim|sanitize_numbers_only',
			'tranzakcio_kodja' => 'trim|sanitize_numbers_only',
		);

		$felhasznalo_array = GUMP::filter($felhasznalo_array, $filters);
		
		//$validate = GUMP::validate($felhasznalo_array, $rules);		
		
		$validate = true;
		
		//Validálás vége
		
		if($felhasznalo_array['szuletesi_datum'] != ''){
			$felhasznalo_array['szuletesi_datum'] = $this->date_dash($felhasznalo_array['szuletesi_datum']);
		}
		
		$felhasznalo_array['ip_cim'] = sprintf("%u", ip2long($_SERVER['REMOTE_ADDR']));
		$felhasznalo_array['regisztracio_ideje'] = date('Y-m-d H:i:s');
		
		if($validate === TRUE){
			if($this->sql_insert('mak_felhasznalo',$felhasznalo_array)){
				return 'Sikeres';
			}else{
				return 'Sikertelen';
			}
		}else{
			if($this->debug){
				print_r($validate);
			}else{
				return 'Invalid adat';
			}
		}
	
	}

	public function insert_login($login_array){
	
		/*
		 * Bejelentkezési adatok beillesztése a felhasznalo táblába
		 * 
		 * @param array login_array - valid key értékek:
		 * 	felhasznalonev : char(50) - felhasználónév
		 * 	jelszo : char(40) - a felhasználó által kiválasztott jelszó sha1 kódolással
		 * @return string
		 */
	
		if(!is_array($login_array)){
			return FALSE;
		}
		
		$login_array = GUMP::sanitize($login_array);
		
		//Validálás
		
		$rules = array(
			'felhasznalonev' => 'required|max_len,50|alpha_numeric',
			'jelszo' => 'required|exact_len,40',
		);
		
		$filters = array(
			'felhasznalonev' => 'trim|sanitize_string',
			'jelszo' => 'trim|sha1',
		);

		$login_array = GUMP::filter($login_array, $filters);
		
		$validate = GUMP::validate($login_array, $rules);
		
		$login_array['ip_cim'] = sprintf("%u", ip2long($_SERVER['REMOTE_ADDR']));
		$login_array['regisztracio_ideje'] = strtotime('now');

		//Validálás vége
		
		if($validate === TRUE){
			if($this->sql_insert('mak_felhasznalo',$login_array)){
				return 'Sikeres';
			}else{
				return 'Sikertelen';
			}	
		}else{
			if($this->debug){
				print_r($validate);
			}else{
				return 'Invalid adat';
			}
		}
	
	}
	
	public function insert_hirdetes($hirdetes_array){
	
		if(!is_array($hirdetes_array)){
			return FALSE;
		}
	
		
		$hirdetes_array = GUMP::sanitize($hirdetes_array);
		
		//Validálás
		
		$rules = array(
			'mak_url' => 'required|max_len,255',
			'cel_url' => 'required|max_len,255',
			'alt' => 'required|max_len,80',
			'kep' => 'required|max_len,80',
		);
		
		$filters = array(
			'mak_url' => 'trim|sanitize_string',
			'cel_url' => 'trim|sanitize_string',
			'alt' => 'trim|sanitize_string',
			'kep' => 'trim|sanitize_string',
		);

		$hirdetes_array = GUMP::filter($hirdetes_array, $filters);
		
		$validate = GUMP::validate($hirdetes_array, $rules);
	
		//Validálás vége
		
		if($validate === TRUE){
			if($this->sql_insert('mak_hirdetes',$hirdetes_array)){
				return 'Sikeres';
			}else{
				return 'Sikertelen';
			}	
		}
	
	}
	
	public function insert_felmeres($felmeres_array){
	
		if(!is_array($felmeres_array)){
			return FALSE;
		}
	
		
		$felmeres_array = GUMP::sanitize($felmeres_array);
		
		//Validálás
		
		$rules = array(
			'kerdes' => 'required|max_len,255',
			'valasz1' => 'required|max_len,255',
			'valasz2' => 'required|max_len,255',
			'valasz3' => 'required|max_len,255',
		);
		
		$filters = array(
			'kerdes' => 'trim|sanitize_string',
			'valasz1' => 'trim|sanitize_string',
			'valasz2' => 'trim|sanitize_string',
			'valasz3' => 'trim|sanitize_string',
		);

		$felmeres_array = GUMP::filter($felmeres_array, $filters);
		
		$validate = GUMP::validate($felmeres_array, $rules);
	
		//Validálás vége
		
		if($validate === TRUE){
			if($this->sql_insert('mak_felmeres',$felmeres_array)){
				return 'Sikeres';
			}else{
				return 'Sikertelen';
			}	
		}
	
	}
	
	public function insert_felmeres_felhasznalo($felmeres_id,$valasz){
	
		$felmeres_array['kerdes_id'] = $felmeres_id;
		$felmeres_array['valasz'] = $valasz;
		$felmeres_array['felhasznalo_id'] = $_SESSION['user_id'];
	
		if($this->sql_insert('mak_felmeres_felhasznalo',$felmeres_array)){
			return 'Sikeres';
		}else{
			return 'Sikertelen';
		}

	}
	
	//UPDATE
	
	public function update_tartalom($tartalom_array,$cond=''){
	
	/*
		 * Tartalom változtatása a tartalom táblában
		 * 
		 * @param array $cond
		 * @param array $tartalom_array - valid key értékek:
		 * 	oldal : char(255) - Melyik aloldalhoz tartozó tartalom
		 * 	cim : char(255) - Tartalom címe
		 * 	szoveg : text 
		 * 	kep : char(80) - a tartalomhoz tartozó képfájl
		 * 	alt : char(255) - a képfájl alt text-je
		 * @return string
		 */
	
		if(!is_array($tartalom_array) || (!is_array($cond) && $cond != '')){
			return FALSE;
		}
		
		$tartalom_array = GUMP::sanitize($tartalom_array);
		
		//Validálás
		
		$rules = array(
			'oldal' => 'max_len,255',
			'cim' => 'max_len,255',
			'kep' => 'max_len,80',
			'alt' => 'max_len,255',
		);
		
		$filters = array(
			'oldal' => 'trim|sanitize_string',
			'cim' => 'trim|sanitize_string',
			'szoveg' => 'trim|sanitize_string',
			'kep' => 'trim|sanitize_string',
			'alt' => 'trim|sanitize_string',
		);

		$tartalom_array = GUMP::filter($tartalom_array, $filters);
		
		$validate = GUMP::validate($tartalom_array, $rules);
		
		if($cond != ''){
			$cond = GUMP::filter($cond, $filters);
		
			$validate2 = GUMP::validate($cond, $rules);
		}else{
			$validate2 = TRUE;
		}

		//Validálás vége
		
		if($validate === TRUE && $validate2 === TRUE){
			if($this->sql_update('mak_tartalom',$tartalom_array,$cond)){
				return 'Sikeres';
			}else{
				return 'Sikertelen';
			}	
		}else{
			if($this->debug){
				print_r($validate);
				print_r($validate2);
			}else{
				return 'Invalid adat';
			}
		}
	
	}

	public function update_galeria($galeria_array,$cond=''){
		
		/*
		 * Galéria táblában lévő értékek változtatása
		 * 
		 * @param array $cond
		 * @param array $galeria_array - valid key értékek:
		 * 	kep_filenev : char(255) - Kép file neve
		 * 	thumbnail_filenev : char(255) - Thumbnail file neve
		 * 	alt : char(255) - a képfájl alt text-je
		 * 	mak_tartalom_id : int(11) - mak_tartalom táblából vett id
		 * @return string
		 */
	
		if(!is_array($galeria_array) || (!is_array($cond) && $cond != '')){
			return FALSE;
		}
		
		$galeria_array = GUMP::sanitize($galeria_array);
		
		//Validálás
		
		$rules = array(
			'kep_filenev' => 'max_len,255',
			'thumbnail_filenev' => 'max_len,255',
			'alt' => 'max_len,255',
			'mak_tartalom_id' => 'max_len,11|numeric',
		);
		
		$filters = array(
			'kep_filenev' => 'trim|sanitize_string',
			'thumbnail_filenev' => 'trim|sanitize_string',
			'alt' => 'trim|sanitize_string',
			'mak_tartalom_id' => 'trim|sanitize_numbers_only',
		);

		$galeria_array = GUMP::filter($galeria_array, $filters);
		
		$validate = GUMP::validate($galeria_array, $rules);

		if($cond != ''){
			$cond = GUMP::filter($cond, $filters);
		
			$validate2 = GUMP::validate($cond, $rules);
		}else{
			$validate2 = TRUE;
		}
		
		//Validálás vége
		
		if($validate === TRUE && $validate2 === TRUE){
			if($this->sql_update('mak_galeria',$galeria_array,$cond)){
				return 'Sikeres';
			}else{
				return 'Sikertelen';
			}	
		}else{
			if($this->debug){
				print_r($validate);
				print_r($validate2);
			}else{
				return 'Invalid adat';
			}
		}
	
	}
	
	public function update_felhasznalo($felhasznalo_array,$cond=''){
	
		if(!is_array($felhasznalo_array) || (!is_array($cond) && $cond != '')){
			return FALSE;
		}
	
		$felhasznalo_array = GUMP::sanitize($felhasznalo_array);
		
		//Validálás
		
		$rules = array(
			'mak_login_id' => 'max_len,11',
			'tagsagi_szam' => 'exact_len,11',
			'nem' => 'exact_len,1',
			'szuletesi_datum' => 'exact_len,8',
			'anyja_neve' => 'max_len,40',
			'elonev' => 'max_len,30',
			'vezeteknev' => 'max_len,30',
			'keresztnev' => 'max_len,20',
			'allando_irsz' => 'exact_len,4|numeric',
			'allando_helyseg' => 'max_len,30',
			'allando_kozterulet' => 'max_len,30',
			'allando_hazszam' => 'max_len,20',
			'levelezesi_irsz' => 'exact_len,4|numeric',
			'levelezesi_helyseg' => 'max_len,30',
			'levelezesi_kozterulet' => 'max_len,30',
			'levelezesi_hazszam' => 'max_len,20',
			'vezetekes_telefon' => 'exact_len,10|numeric',
			'mobil_telefon' => 'exact_len,11|numeric',
			'e_mail' => 'max_len,100|valid_email',
			'rendszam' => 'exact_len,6|alpha_numeric',
			'gyartmany_sap' => 'exact_len,4|numeric',
			'tipus_sap' => 'exact_len,4|numeric',
			'gyartasi_ev' => 'exact_len,4|numeric',
			'elso_forgalom' => 'exact_len,8|numeric',
			'tagtipus' => 'exact_len,1|numeric',
			'dijkategoria' => 'exact_len,1|numeric',
			'statusz' => 'max_len,2|numeric',
			'belepes_datuma' => 'exact_len,8|numeric',
			'ervenyesseg_datuma' => 'exact_len,8|numeric',
			'befizetes_datuma' => 'exact_len,8|numeric',
			'befizetett_osszeg' => 'max_len,5|numeric',
			'tranzakcio_kodja' => 'exact_len,1|numeric',
		);
		
		$filters = array(
			'mak_login_id' => 'trim|sanitize_numbers_only',
			'tagsagi_szam' => 'trim|sanitize_numbers_only',
			'nem' => 'trim|sanitize_string',
			'szuletesi_datum' => 'trim|sanitize_numbers_only',
			'anyja_neve' => 'trim|sanitize_string',
			'elonev' => 'trim|sanitize_string',
			'vezeteknev' => 'trim|sanitize_string',
			'keresztnev' => 'trim|sanitize_string',
			'allando_irsz' => 'trim|sanitize_numbers_only',
			'allando_helyseg' => 'trim|sanitize_string',
			'allando_kozterulet' => 'trim|sanitize_string',
			'allando_hazszam' => 'trim|sanitize_string',
			'levelezesi_irsz' => 'trim|sanitize_numbers_only',
			'levelezesi_helyseg' => 'trim|sanitize_string',
			'levelezesi_kozterulet' => 'trim|sanitize_string',
			'levelezesi_hazszam' => 'trim|sanitize_string',
			'vezetekes_telefon' => 'trim|sanitize_numbers_only',
			'mobil_telefon' => 'trim|sanitize_numbers_only',
			'e_mail' => 'trim|sanitize_email',
			'rendszam' => 'trim|sanitize_string',
			'gyartmany_sap' => 'trim|sanitize_numbers_only',
			'tipus_sap' => 'trim|sanitize_numbers_only',
			'gyartasi_ev' => 'trim|sanitize_numbers_only',
			'elso_forgalom' => 'trim|sanitize_numbers_only',
			'tagtipus' => 'trim|sanitize_numbers_only',
			'dijkategoria' => 'trim|sanitize_numbers_only',
			'statusz' => 'trim|sanitize_numbers_only',
			'belepes_datuma' => 'trim|sanitize_numbers_only',
			'ervenyesseg_datuma' => 'trim|sanitize_numbers_only',
			'befizetes_datuma' => 'trim|sanitize_numbers_only',
			'befizetett_osszeg' => 'trim|sanitize_numbers_only',
			'tranzakcio_kodja' => 'trim|sanitize_numbers_only',
		);

		$felhasznalo_array = GUMP::filter($felhasznalo_array, $filters);
		
		$validate = GUMP::validate($felhasznalo_array, $rules);
		
		if($cond != ''){
			$cond = GUMP::filter($cond, $filters);
		
			$validate2 = GUMP::validate($cond, $rules);
		}else{
			$validate2 = TRUE;
		}
		
		//Validálás vége
		
		$felhasznalo_array['ip_cim'] = sprintf("%u", ip2long($_SERVER['REMOTE_ADDR']));
		
		if($validate === TRUE && $validate2){
			if($this->sql_update('mak_felhasznalo',$felhasznalo_array,$cond)){
				return 'Sikeres';
			}else{
				return 'Sikertelen';
			}
		}else{
			if($this->debug){
				print_r($validate);
				print_r($validate2);
			}else{
				return 'Invalid adat';
			}
		}
	
	}
	
	public function update_hirdetes($hirdetes_array,$cond=''){
	
		if(($cond != '' && !is_array($cond)) || !is_array($hirdetes_array)){
			return FALSE;
		}
		
		$hirdetes_array = GUMP::sanitize($hirdetes_array);
		
		//Validálás
		
		$rules = array(
			'mak_url' => 'max_len,255',
			'cel_url' => 'max_len,255',
			'alt' => 'max_len,80',
			'kep' => 'max_len,80',
			'utolso_mutatas' => 'max_len,80',
		);
		
		$filters = array(
			'mak_url' => 'trim|sanitize_string',
			'cel_url' => 'trim|sanitize_string',
			'alt' => 'trim|sanitize_string',
			'kep' => 'trim|sanitize_string',
			'utolso_mutatas' => 'trim',
		);

		$hirdetes_array = GUMP::filter($hirdetes_array, $filters);
		
		$validate = GUMP::validate($hirdetes_array, $rules);
	
		//Validálás vége
		
		if($validate === TRUE){
			if($this->sql_update('mak_hirdetes',$hirdetes_array,$cond)){
				return 'Sikeres';
			}else{
				return 'Sikertelen';
			}	
		}else{
			if($this->debug){
				print_r($validate);
			}else{
				return 'Invalid adat';
			}
		}
	
	}

	public function update_hirdetes_utolso_mutatas($id){
	
		 //$id = (int)$id;
		 
		 $cond['id'] = $id;
		 $col['utolso_mutatas'] = date('Y-m-d H:i:s');
		 
		 return $this->update_hirdetes($col,$cond);
	
	}
	
	public function update_felmeres($felmeres_array,$cond=''){
	
		if(($cond != '' && !is_array($cond)) || !is_array($felmeres_array)){
			return FALSE;
		}
		
		$felmeres_array = GUMP::sanitize($felmeres_array);
		
		//Validálás
		
		$rules = array(
			'kerdes' => 'max_len,255',
			'valasz1' => 'max_len,255',
			'valasz2' => 'max_len,255',
			'valasz3' => 'max_len,255',
			'valasz1_db' => 'numeric',
			'valasz2_db' => 'numeric',
			'valasz3_db' => 'numeric',
		);
		
		$filters = array(
			'kerdes' => 'trim|sanitize_string',
			'valasz1' => 'trim|sanitize_string',
			'valasz2' => 'trim|sanitize_string',
			'valasz3' => 'trim|sanitize_string',
			'valasz1_db' => 'trim|sanitize_numbers_only',
			'valasz2_db' => 'trim|sanitize_numbers_only',
			'valasz3_db' => 'trim|sanitize_numbers_only',
		);

		$felmeres_array = GUMP::filter($felmeres_array, $filters);
		
		$validate = GUMP::validate($felmeres_array, $rules);
	
		//Validálás vége
		
		if($validate === TRUE){
			if($this->sql_update('mak_felmeres',$felmeres_array,$cond)){
				return 'Sikeres';
			}else{
				return 'Sikertelen';
			}	
		}else{
			if($this->debug){
				print_r($validate);
			}else{
				return 'Invalid adat';
			}
		}
	
	}
	
	public function update_felmeres_valasz($id,$valasz){
	
		$id = trim($id);
		$valasz = trim($valasz);
	
		$felmeres = $this->get_felmeres_idbol($id);
		
		$cond['id'] = $id;
		$col['valasz'.$valasz.'_db'] = $felmeres[0]['valasz'.$valasz.'_db'] + 1;
		
		$this->insert_felmeres_felhasznalo($id,$valasz);
		
		return $this->update_felmeres($col,$cond);
	
	}
	
	//RENDER

	public function render_aloldal_section_default($tart){
	
		$cond['mak_almenu.url'] = $tart;
	
		$tartalom = $this->get_oldal_tartalom($tart,$cond);
					
		if($tartalom == '' || !is_array($tartalom)){
			return FALSE;
		}
		
		$galeria = '';
		$html = '';
		$tartalom_url = '';
		
		for($i = 0; $i < $tartalom['count']; $i++){
		
			/*
			 * Almenü tartalom kiírása
			 */
		
			if($tartalom_url != $tartalom[$i]['url']){
				$html .= '<section id="' . $tartalom[$i]['azonosito'] . '">';
				$html .= '<h2>'.$tartalom[$i]['almenu'].'</h2>';
				
				if($tartalom[$i]['almenu_kep'] != ''){
					$html .= '<div class="rightside"><img src="' . $this->_imageDir . 'aloldal/' . $tartalom[$i]['azonosito'] . '/' . $tartalom[$i]['url'] . '/' . $tartalom[$i]['almenu_kep'] . '" alt="' . $tartalom[$i]['almenu_alt'] . '" /></div>';
				}
				
				$html .= '<p>'.$tartalom[$i]['almenu_szoveg'].'</p>';
				
				$galeria = $this->get_galeria_tartalomhoz($tartalom[$i]['id']);
				
				if($galeria === FALSE){
					return FALSE;
				}
				
				if($galeria['count'] > 0){
					$html .= '<div class="gallery">';
					for($j = 0; $j < $galeria['count']; $j++){
						$html .= '<a rel="' . $i . '" href="' . $this->_galleryDir . $galeria[$j]['kep_filenev'] .'"><img src="' . $this->_galleryDir . $galeria[$j]['thumbnail_filenev'] . '" alt="' . $galeria[$j]['thumbnail_filenev'] . '" /></a>';
					}
					$html .= '</div>';
				}
				
				$html .= '</section>';
				
				$html .= '<div class="hr"></div>';
				$tartalom_url = $tartalom[$i]['url'];
				
				/*
				 * Betekintő kiírása
				 */
				
			}
			if($tartalom[$i]['szoveg'] != ''){

				$html .= '<section id="' . $tartalom[$i]['id'] . '">';
				$html .= '<h2>'.$tartalom[$i]['cim'].'</h2>';
				
				if($tartalom[$i]['kep'] != ''){
					$html .= '<div class="rightside"><img src="' . $this->_imageDir . 'aloldal/' . $tartalom[$i]['azonosito'] . '/' . $tartalom[$i]['url'] . '/' . $tartalom[$i]['almenu_kep'] . '" alt="' . $tartalom[$i]['almenu_alt'] . '" /></div>';
				}
				
				$html .= '<p>'.$this->betekinto($tartalom[$i]['szoveg']).'</p>';
				
				/*
				 * Bővebben link
				 */
				
				$html .= '<a class="link hasarrow" href="' . $tartalom[$i]['azonosito'] . '/' . $tartalom[$i]['url'] . '/' . $tartalom[$i]['tartalom_url'] . '">Bővebben</a>';
				
				$html .= '</section>';
				
				$html .= '<div class="hr"></div>';
			
			}
		}
		
		return $html;
	
	}
	
	public function render_kategoria_section_default($kat){
		
		if(!isset($_SESSION['user_id']) && $kat == 'enautoklubom'){
			$kategoria[0]['szoveg'] = 'Amennyiben nem tagunk, <a href="regisztralas">regisztráljon</a>';
			$kategoria[0]['cim'] = 'Kérjük jelentkezzen be!';
			$kategoria['count'] = 1;
			$kategoria[0]['id'] = 1;
		}else{
			$kategoria = $this->get_kategoria_tartalom($kat);
		}
		
		if($kategoria == '' || !is_array($kategoria)){
			return FALSE;
		}
		
		$galeria = '';
		$html = '';
		$kateg = '';
		
		for($i = 0; $i < $kategoria['count']; $i++){
			
			/*
			 * Ha az első elem, akkor a kategória tartalmát írjuk ki
			 */
		
			if($kateg != $kategoria[$i]['id']){
			
				$html .= '<section id="' . $kategoria[$i]['cim'] . '">';
				$html .= '<h2>'.$kategoria[$i]['cim'].'</h2>';
				
				if($kategoria[$i]['almenu_kep'] != ''){
					$html .= '<div class="rightside"><img src="' . $this->_imageDir . 'aloldal/' . $kategoria[$i]['azonosito'] . '/' . $kategoria[$i]['url'] . '/' . $kategoria[$i]['almenu_kep'] . '" alt="' . $kategoria[$i]['almenu_alt'] . '" /></div>';
				}
				
				$html .= '<p>'.$kategoria[$i]['szoveg'].'</p>';
				
				$galeria = $this->get_galeria_tartalomhoz($kategoria[$i]['id']);
				
				if($galeria === FALSE){
					return FALSE;
				}
				
				if($galeria['count'] > 0){
					$html .= '<div class="gallery">';
					for($j = 0; $j < $galeria['count']; $j++){
						$html .= '<a rel="' . $i . '" href="' . $this->_galleryDir . $galeria[$j]['kep_filenev'] .'"><img src="' . $this->_galleryDir . $galeria[$j]['thumbnail_filenev'] . '" alt="' . $galeria[$j]['thumbnail_filenev'] . '" /></a>';
					}
					$html .= '</div>';
				}
				
				$html .= '</section>';
				
				if($i + 1 < $kategoria['count']){
					$html .= '<div class="hr"></div>';
				}
				
				$kateg = $kategoria[$i]['id'];
				
				/*
				 * Egyéb esetben az almenük "betekintői" kerülenk kiiratásra
				 */
				
			}
			if($kategoria[$i]['almenu_szoveg'] != ''){

				$html .= '<section id="' . $kategoria[$i]['almenu_title'] . '">';
				$html .= '<h2>'.$kategoria[$i]['almenu_title'].'</h2>';
				
				if($kategoria[$i]['almenu_kep'] != ''){
					$html .= '<div class="rightside"><img src="' . $this->_imageDir . 'aloldal/' . $kategoria[$i]['azonosito'] . '/' . $kategoria[$i]['url'] . '/' . $kategoria[$i]['kep'] . '" alt="' . $kategoria[$i]['alt'] . '" /></div>';
				}
				
				$html .= '<p>'.$this->betekinto($kategoria[$i]['almenu_szoveg']).'</p>';
				
				$galeria = $this->get_galeria_tartalomhoz($kategoria[$i]['almenu_id']);
				
				if($galeria === FALSE){
					return FALSE;
				}
				
				if($galeria['count'] > 0){
					$html .= '<div class="gallery">';
					for($j = 0; $j < $galeria['count']; $j++){
						$html .= '<a rel="' . $i . '" href="' . $this->_galleryDir . $galeria[$j]['kep_filenev'] .'"><img src="' . $this->_galleryDir . $galeria[$j]['thumbnail_filenev'] . '" alt="' . $galeria[$j]['thumbnail_filenev'] . '" /></a>';
					}
					$html .= '</div>';
				}
				
				/*
				 * Bővebben link
				 */
				
				$html .= '<a class="link hasarrow" href="' . $kategoria[$i]['azonosito'] . '/' . $kategoria[$i]['almenu_url'] . '">Bővebben</a>';
				
				$html .= '</section>';
				
				if($i + 1 < $kategoria['count']){
					$html .= '<div class="hr"></div>';
				}
			
			}
		}
		
		return $html;
	
	}
	
	public function render_altartalom_section_default($altart){
	
		$tartalom = $this->get_aloldal_altartalom($altart);
					
		if($tartalom == '' || !is_array($tartalom)){
			return FALSE;
		}
		
		$galeria = '';
		$html = '';
		
		for($i = 0; $i < $tartalom['count']; $i++){
		
			$html .= '<section id="' . $tartalom[$i]['cim'] . '">';
			$html .= '<h2>'.$tartalom[$i]['cim'].'</h2>';
			
			if($tartalom[$i]['kep'] != ''){
				$html .= '<div class="rightside"><img src="' . $this->_imageDir . 'aloldal/' . $tartalom[$i]['azonosito'] . '/' . $tartalom[$i]['url'] . '/' . $tartalom[$i]['kep'] . '" alt="' . $tartalom[$i]['alt'] . '" /><div>';
			}
			
			$html .= '<p>'.$tartalom[$i]['szoveg'].'</p>';			
		
			$galeria = $this->get_galeria_tartalomhoz($tartalom[$i]['id']);
			
			if($galeria === FALSE){
				return FALSE;
			}
			
			if($galeria['count'] > 0){
				$html .= '<div class="gallery">';
				for($j = 0; $j < $galeria['count']; $j++){
					$html .= '<a rel="' . $i . '" href="' . $this->_galleryDir . $galeria[$j]['kep_filenev'] .'"><img src="' . $this->_galleryDir . $galeria[$j]['thumbnail_filenev'] . '" alt="' . $galeria[$j]['thumbnail_filenev'] . '" /></a>';
				}
				$html .= '</div>';
			}
			
			$html .= '</section>';
			
			if($i + 1 < $tartalom['count']){
				$html .= '<div class="hr"></div>';
			}
		
		}
		
		return $html;
	
	}
	
	public function render_tartalom_section_default($tar){
	
		//$cond['mak_tartalom.url'] = $tart;
	
		$tartalom = $this->get_oldal_tartalom($tar);
					
		if($tartalom == '' || !is_array($tartalom)){
			return FALSE;
		}
		
		$galeria = '';
		$html = '';
		$tart = '';
		
		for($i = 0; $i < $tartalom['count']; $i++){
			
			/*
			 * Tartalmi elemek kirajzolása
			 */
		
			if($tart != $tartalom[$i]['cim']){
				
				$html .= '<section id="' . $tartalom[$i]['cim'] . '">';
				//$html .= '<h2>'.$tartalom[$i]['cim'].'</h2>';
				
				if($tartalom[$i]['kep'] != ''){
					$html .= '<div class="rightside"><img src="' . $this->_imageDir . 'aloldal/' . $tartalom[$i]['azonosito'] . '/' . $tartalom[$i]['url'] . '/' . $tartalom[$i]['kep'] . '" alt="' . $tartalom[$i]['alt'] . '" /></div>';
				}
				
				if($tar == 'profilszerkesztes'){
					$tartalom[$i]['szoveg'] = $this->adatmodosito_template($tartalom[$i]['szoveg']);
				}
				
				if($tar == 'tagsag'){
					$tartalom[$i]['szoveg'] = $this->upgrade_extend_template($tartalom[$i]['szoveg']);
				}
				
				
				
				$html .= '<p>'.$tartalom[$i]['szoveg'].'</p>';
			
				$galeria = $this->get_galeria_tartalomhoz($tartalom[$i]['id']);
				
				if($galeria === FALSE){
					return FALSE;
				}
				
				if($galeria['count'] > 0){
					$html .= '<div class="gallery">';
					for($j = 0; $j < $galeria['count']; $j++){
						$html .= '<a rel="' . $i . '" href="' . $this->_galleryDir . $galeria[$j]['kep_filenev'] .'"><img src="' . $this->_galleryDir . $galeria[$j]['thumbnail_filenev'] . '" alt="' . $galeria[$j]['thumbnail_filenev'] . '" /></a>';
					}
					$html .= '</div>';
				}
				
				$html .= '</section>';
				
				if($i + 1 < $tartalom['count']){
					$html .= '<div class="hr"></div>';
				}
				
				$tart = $tartalom[$i]['cim'];
			
				/*
				 * Betekintő
				 */
				
			}
			if($tartalom[$i]['altartalom_szoveg'] != ''){
			
				$html .= '<section id="' . $tartalom[$i]['altartalom_cim'] . '">';
				$html .= '<h2>' . $tartalom[$i]['altartalom_cim'] . '</h2>';
				
				if($tartalom[$i]['altartalom_kep'] != ''){
					$html .= '<div class="rightside"><img src="' . $this->_imageDir . 'aloldal/' . $tartalom[$i]['azonosito'] . '/' . $tartalom[$i]['url'] . '/' . $tartalom[$i]['altartalom_kep'] . '" alt="' . $tartalom[$i]['altartalom_alt'] . '" /></div>';
				}
				
				$html .= '<p>'.$this->betekinto($tartalom[$i]['altartalom_szoveg']).'</p>';
				
				$html .= '<a class="link hasarrow" href="' . $tartalom[$i]['azonosito'] . '/' . $tartalom[$i]['almenu'] . '/' . $tartalom[$i]['tartalom_url'] . '/' . $tartalom[$i]['altartalom_url'] . '">Bővebben</a>';
				
				$html .= '</section>';
			
			}
		
		}
		
		return $html;
	
	}
	
	public function render_szervizpont($szervizpont_id){
	
		$szervizpont = $this->get_szervizpont_idbol($szervizpont_id);
		$szervizpont = $szervizpont[0];
	
		$html = '<div id="map"></div>';
		$html .='<div id="szervizpont-data">';
		$html .= '<p><span>Cím: </span>' . $szervizpont['cim'] . '</p>';
		$html .= '<p>' . $szervizpont['telefon_fax'] . '</p>';
		$html .= '<p><span>Email: </span><a href="mailto:' . $szervizpont['e_mail'] . '" class="mailto">' . $szervizpont['e_mail'] . '</a></p>';
		$html .= '</div>';
		$html .= $szervizpont['nyitvatartas'];

		return $html;
		
	}
	
	public function render_szervizpontok(){
	
		$html = '<div id="map"></div>';
		$html .= '<br />';
		$html .= '<table class="mak-table"><thead><tr><th colspan="3">Szerviz Pontok</th></tr></thead><tfoot colspan="2"><tr><td></td></tr></tfoot><tbody><tr><td>Szervizpont, Műszaki állomás</td><td><a class="link" href="szervizpont/1">1112 Budapest, Budaörsi út 138.</a></td><td>1/310-2958</td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/2">1095 Budapest, Soroksári út 158/a</a></td><td>1/358-1491</td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/allomas">1183 Budapest, Nefelejcs u. 4.</a></td><td>1/295-0871</td></tr><tr><td>Szervizpont, Műszaki állomás</td><td><a class="link" href="szervizpont/4">1043 Budapest, Berda J. u. 15. </a></td><td>1/231-1170 </td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/5">1044 Budapest, Megyeri út 15/a </a></td><td>1/272-1477 </td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/6">9027 Győr,  Tompa u. 2. </a></td><td>96/317-900 </td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/7">9200 Mosonmagyaróvár, Gabona rkp. 2-6.</a></td><td>96/315-708 </td></tr><tr><td>Szervizpont, Műszaki állomás</td><td><a class="link" href="szervizpont/8">2500 Esztergom, Schweidel u. 5.</a></td><td>33/411-908 </td></tr><tr><td>Szervizpont, Műszaki állomás</td><td><a class="link" href="szervizpont/9">2800 Tatabánya, Komáromi u. 68.</a></td><td>34/310-504 </td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/10">2084 Pilisszentiván, Bánki D. u. 1. </a></td><td>26/367-888 </td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/11">2310 Szigetszentmiklós, Gyári út 9. kapu</a></td><td>24/465-407</td></tr><tr><td>Szervizpont, Műszaki állomás</td><td><a class="link" href="szervizpont/12">2049 Diósd, Vadrózsa u. 19. (Ipari park)</a></td><td>23/545-107</td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/13">2760 Nagykáta, Jászberényi út 1.</a></td><td>29/440-385 </td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/14">5000 Szolnok, Thököly út 48-56. </a></td><td>56/420-801 </td></tr><tr><td>Szervizpont, Műszaki állomás</td><td><a class="link" href="szervizpont/14">6724 Szeged, Kossuth Lajos sgt. 114.</a></td><td>62/ 474-874</td></tr><tr><td>Szervizpont, Műszaki állomás</td><td><a class="link" href="szervizpont/13">6800 Hódmezővásárhely, Lévai u. 48.</a></td><td>62/533-220 </td></tr><tr><td>Szervizpont, Műszaki állomás</td><td><a class="link" href="szervizpont/15">6600 Szentes, Villogó u. 20.</a></td><td>63/560-130 </td></tr><tr><td>Szervizpont, Műszaki állomás</td><td><a class="link" href="szervizpont/16">6000 Kecskemét, Izzó u.1.</a></td><td>76/ 486-840</td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/1">6300 Kalocsa, Miskei u. 5.</a></td><td>78/461-854 </td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/4">6100 Kiskunfélegyháza, Szegedi út 38.</a></td><td>76/560-058 </td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/0">6060 Tiszakécske, Szolnoki út 79.</a></td><td>76/540-005 </td></tr><tr><td>Szervizpont, Műszaki állomás</td><td><a class="link" href="szervizpont/17">5600 Békéscsaba, Szarvasi út 82.</a></td><td>66/325-653, 66/325-658 </td></tr><tr><td>Szervizpont, Műszaki állomás</td><td><a class="link" href="szervizpont/18">4400 Nyíregyháza, Debreceni út 155.</a></td><td>42/409-319, 42/463-521 </td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/9">4465 Rakamaz, Szent István u. 148.</a></td><td>42/370-245 </td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/8">4765 Csenger, Ady Endre u. 86.</a></td><td>44/342-346 </td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/22">2660 Balassagyarmat, Mikszáth u. 26.</a></td><td>35/300-197 </td></tr><tr><td>Szervizpont, Műszaki állomás</td><td><a class="link" href="szervizpont/19">3100 Salgótarján, Bartók B. u. 14/a</a></td><td>32/310-662 </td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/23">3200 Gyöngyös, Déli Külhatár út 6.</a></td><td>37/311-097 </td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/24">3300 Eger, Kistályai út 6.</a></td><td>36/410-437 </td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/25">3531 Miskolc, Győri kapu 32.</a></td><td>46/412-854 </td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/21">3600 Ózd, Vasvári u. 110. </a></td><td>48/471-614 </td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/17">5350 Tiszafüred, Fürdő út 21. </a></td><td>59/352-355 </td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/16">7630 Pécs, Hengermalom u. 3. </a></td><td>72/516-083 </td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/15">7100 Szekszárd, Tolnai L. u. 2/a </a></td><td>74/315-630 </td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/12">7400 Kaposvár, Dombóvári u. 6. </a></td><td>82/319-232 </td></tr><tr><td>Szervizpont, Műszaki állomás</td><td><a class="link" href="szervizpont/6">8600 Siófok, Vak Bottyán u. 55.  </a></td><td>84/311-992 </td></tr><tr><td>Szervizpont, Műszaki állomás</td><td><a class="link" href="szervizpont/10">8000 Székesfehérvár, Sárkeresztúri u. 8. </a></td><td>22/311-365 </td></tr><tr><td>Szervizpont, Műszaki állomás</td><td><a class="link" href="szervizpont/11">2400 Dunaújváros, Kenyérgyári út. 7. </a></td><td>25/ 413-311</td></tr><tr><td>Szervizpont, Műszaki állomás</td><td><a class="link" href="szervizpont/7">8200 Veszprém, Aradi Vértanúk u. 1. </a></td><td>88/421-006 </td></tr><tr><td>Szervizpont, Műszaki állomás</td><td><a class="link" href="szervizpont/5">8900 Zalaegerszeg, Alsóerdei út 3/a </a></td><td>92/550-195 </td></tr><tr><td>Szervizpont, Műszaki állomás</td><td><a class="link" href="szervizpont/3">8800 Nagykanizsa, Ligeti u. 21. </a></td><td>93/311-256 </td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/20">8960 Lenti, Táncsics u. 17 </a></td><td>92/351-365 </td></tr><tr><td>Szervizpont, Műszaki állomás</td><td><a class="link" href="szervizpont/allomas">9900 Körmend,  Nap u. 1.</a></td><td>94/410-411</td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/19">9700 Szombathely, Csaba u. 7. </a></td><td>94/314-754 </td></tr><tr><td>Szervizpont, Műszaki állomás</td><td><a class="link" href="szervizpont/0">9730 Kőszeg, Szombathelyi út 3. </a></td><td>94/360-592 </td></tr><tr><td>Műszaki állomás</td><td><a class="link" href="szervizpont/18">9500 Celldömölk,  Zalka M. úti garázssor </a></td><td>95/420-538 </td></tr><tr><td>Szervizpont, Műszaki állomás</td><td><a class="link" href="szervizpont/2">9400 Sopron, Lackner Kristóf u. 60. </a></td><td>99/311-352 </td></tr></tbody></table>';
	
		return $html;
	
	}
	
	public function render_autoselet($evfolyam){
	
		$position[0] = 'left';
		$position[1] = 'center';
		$position[2] = 'right';
	
		if($evfolyam == ''){
			$evfolyam = 2010;
		}
		
		$tartalom = $this->get_autoselet($evfolyam);
		
		if($tartalom === FALSE){
			return FALSE;
		}
		
		$html = '';
		
		for($i = 0; $i < $tartalom['count']; $i++){
			
			if($i % 3 == 0){
				$html .= '<div class="row">';
			}
			$html .= '<div class="autoselet ';					
			$html .= $position[$i % 3];
			$html .= '" id="' . $tartalom[$i]['evfolyam'] . '/' . $tartalom[$i]['lapszam'] . '">';
			
			$html .= '<div class="img">';
			$html .= '<img src="' . $this->_autoseletDir . $tartalom[$i]['kep_filenev'] . '" alt="Autosélet - ' . $tartalom[$i]['evfolyam'] . '/' . $tartalom[$i]['lapszam'] . '" />';
			$html .= '</div>';
			$html .= '<div class="title">' . $tartalom[$i]['evfolyam'] . '. évfolyam ' . $tartalom[$i]['lapszam'] . '. szám</div>';	
			
			$html .= '</div>';
			
			if($i % 3 == 2 || $i + 1 == $tartalom['count']){
				$html .= '</div>';
			}
			
		
		}
		
		$html .= '<div class="embed">';
		$html .= '</div>';
		
		return $html;
	
	}
	
	public function render_hosszabitas(){
	
		$html = '<section class="full">';
		$html .= '<p>A Magyar Autóklub lehetőséget biztosít meglévő tagjai számára, hogy klubtagsági szintjüket megváltoztassák, valamint arra, hogy a tagságukat online meghosszabbítsák. Kérjük vegye figyelembe, hogy amennyiben tagsági szintet változtat, úgy extra adatok megadására is szükség lehet.</p>';
		$html .= '</section>';
		$html .= '<section id="extend-cta">';
		$html .= '<h2>Tagságomból hátra van még</h2>';
		$html .= '<div id="countdown">';
		$html .= '<p class="timeleft"></p>';
		$html .= '</div>';
		$html .= '<a href="#" id="extendButton">Hosszabbítás</a>';
		$html .= '<a href="#" id="levelButton">Szintváltás</a>';
		$html .= '</section>';
		$html .= '<section id="formHolder">';
		$html .= '</section>';
	
	}
	
	public function render_enautoklubom(){
	
		if(isset($_SESSION['user_id'])){
			$tartalom = $this->get_hirek();
							
			if($tartalom === FALSE){
				return FALSE;
			}
			
			$pos[0] = '';
			$pos[1] = ' right';
		
			for($i = 0; $i < $tartalom['count']; $i++){
			
				$html .= '<div class="block' . $pos[$i % 2] . '">';
				$html .= '<h2>' . $tartalom[$i]['cim'] . '</h2>';
				
				//$idopont = date("Y-m-d", strtotime($tartalom[$i]['modositas']));
				
				//$html .= '<h3>' . $idopont . ' - írta: ' . $tartalom[$i]['publikalta'] . '</h3>';
				$html .= '<img src="' . $this->_enautoklubomDir . $tartalom[$i]['kep'] . '" alt="' . $tartalom[$i]['alt'] . '" />';
				$html .= '<p>' . $tartalom[$i]['szoveg'] . '</p>';
				$html .=  '</div>';
				
				/*
				if($i != $tartalom['count'] - 1){
					$html .= '<div class="hr"></div>';
				}
				*/
			}
			
			return $html;
		}
	
	}

	public function render_hirek(){
	
		$tartalom = $this->get_hirek();
						
		if($tartalom === FALSE){
			return FALSE;
		}
	
		$html = '';
		
		for($i = 0; $i < $tartalom['count']; $i++){
		
			$html .= '<section>';
			$html .= '<h2>' . $tartalom[$i]['cim'] . '</h2>';
			$html .= '<h3>' . $tartalom[$i]['modositas'] . ' - ' . $tartalom[$i]['kep'] . '</h3>';
			$html .= '<p>' . $tartalom[$i]['szoveg'] . '</p>';
			$html .= '<img src="' . $this->_hirekDir . $tartalom[$i]['kep'] . '" alt="' . $tartalom[$i]['kep'] . '">';
			$html .= '</section>';
			$html .= '<div class="hr"></div>';
			
		}
		
		return $html;
	
	}
	
	public function render_oldalterkep(){
	
		$html = '';
		
		$oldalterkep = $this->get_oldalterkep();
		
		$kat = '';
		$alm = '';
		$tart = '';
		$altart = '';
		
		$k = array();
		$a = array();
		$t = array();
		$at = array();
		
		$html .= '<ul>';
		
		for($i = 0;$i < $oldalterkep['count'];$i++){
		
			if($kat != $oldalterkep[$i]['kategoria_url']){
				$kat = $oldalterkep[$i]['kategoria_url'];
				$k[$kat] = '<li class="kategoria"><a href="' . $oldalterkep[$i]['kategoria_url'] . '">' . $oldalterkep[$i]['kategoria'] . '</a>';
			}
			
			if($alm != $oldalterkep[$i]['almenu_url'] && $oldalterkep[$i]['almenu_url'] != ''){
				$alm = $oldalterkep[$i]['almenu_url'];	
				$a[$kat][$alm] = '<li class="almenu"><a href="' . $oldalterkep[$i]['kategoria_url'] . '/' . $oldalterkep[$i]['almenu_url'] . '">' . $oldalterkep[$i]['almenu'] . '</a>';
			}
			
			if($tart != $oldalterkep[$i]['tartalom_url'] && $oldalterkep[$i]['tartalom_url'] != ''){
				$tart = $oldalterkep[$i]['tartalom_url'];
				$t[$kat][$alm][$tart] = '<li class="tartalom"><a href="' . $oldalterkep[$i]['kategoria_url'] . '/' . $oldalterkep[$i]['almenu_url'] . '/' . $oldalterkep[$i]['tartalom_url'] . '">' . $oldalterkep[$i]['tartalom'] . '</a>';
			}
			
			if($altart != $oldalterkep[$i]['altartalom_url'] && $oldalterkep[$i]['altartalom_url'] != ''){
				$altart = $oldalterkep[$i]['altartalom_url'];
				$at[$kat][$alm][$tart][$altart] = '<li class="altartalom"><a href="' . $oldalterkep[$i]['kategoria_url'] . '/' . $oldalterkep[$i]['almenu_url'] . '/' . $oldalterkep[$i]['tartalom_url'] . '/' . $oldalterkep[$i]['altartalom_url'] . '">' . $oldalterkep[$i]['altartalom'] . '</a>';
			}
		
		}
		
		foreach($k as $kategoria => $text){
			$html .= $text;
			if(isset($a[$kategoria])){
				$html .= '<ul>';
				foreach($a[$kategoria] as $almenu => $alm_text){
					$html .= $alm_text;
					if(isset($t[$kategoria][$almenu])){
						$html .= '<ul>';
						foreach($t[$kategoria][$almenu] as $tartalom => $tart_text){
							$html .= $tart_text;
							if(isset($at[$kategoria][$almenu][$tartalom])){
								$html .= '<ul>';
								foreach($at[$kategoria][$almenu][$tartalom] as $altartalom => $altart_text){
									$html .= $altart_text;
								}
								$html .= '</ul></li>';
							}
						}
						$html .= '</ul></li>';
					}
				}
				$html .= '</ul></li>';
			}
		}
		
		$html .= '</ul>';
		
		return $html;
	
	}
	
	public function render_section($kategoria,$almenu='',$tartalom='',$altartalom=''){

		/*
		 * @param string $kategoria : a megfelelő aloldal url-ben található azonosítója
		 * @return mixed : FALSE vagy a html-t tartalmazó string
		 */
	
		$kategoria = trim($kategoria);
		$tartalom = trim($tartalom);
		$altartalom = trim($altartalom);
		$almenu = trim($almenu);
		
		$html = '';
		
		if($kategoria == ''){
			return FALSE;
		}
		
		$szint = 'kategoria';
		
		if($almenu != ''){
			$szint = 'almenu';	
		}
		
		if($tartalom != ''){
			$szint = 'tartalom';	
		}
		
		if($altartalom != ''){
			$szint = 'altartalom';	
		}
		
		switch($szint){
		
			case "kategoria":

				if($kategoria == 'szervizpontok'){
					$html = $this->render_szervizpontok();
				}elseif($kategoria == 'oldalterkep'){
					$html = $this->render_oldalterkep();
				}else{
					$html =  $this->render_kategoria_section_default($kategoria);
				}
			
			break;
			
			case "almenu":
				
				if(is_numeric($almenu)){
					$html = $this->render_szervizpont($almenu);
				}else{
					$html =  $this->render_aloldal_section_default($almenu);
				}
			
			break;
			
			case "tartalom":
				
				if($tartalom == 'autoselet'){
					$html = $this->render_autoselet();
				}elseif($tartalom == 'hirek'){
					$html =  $this->render_hirek();
				}else{
					$html =  $this->render_tartalom_section_default($tartalom);
				}
			
			break;
			
			case "altartalom":
				
				$html =  $this->render_altartalom_section_default($altartalom);
				
			break;
			
		}

		return $html;
	}

	public function render_aloldal_bal_menu($aloldal,$subpage,$tartalom='',$subsubpage=''){
		
		if($aloldal == ''){
			return FALSE;
		}
		
		$aloldal = trim($aloldal);
		$html = '';
		$almenu = '';
		$aloldal_azonosito = '';
		$altartalom_id = '';
		$subpage = trim($subpage);
		$tartalom = trim($tartalom);
		$subsubpage = trim($subsubpage);
		
		$aloldalak = $this->get_menu_aktualis_almenuhoz($aloldal);
		
		if($aloldalak === FALSE){
			return FALSE;
		}
		
		$html .= '<h2 id="'. $aloldalak[0]['azonosito'] .'">';
		$html .= '<img src="' . $this->_imageDirLeft . $aloldalak[0]['azonosito'] . '.png" alt="' . $aloldalak[0]['kategoria_nev'] . '" />';
		$html .= $aloldalak[0]['kategoria_nev'] . '</h2>';
		
		for($i = 0; $i < $aloldalak['count']; $i++){
			
			if($almenu != $aloldalak[$i]['url']){
				if($almenu != ''){
					$html .= '</ul>';
				}
				$almenu = $aloldalak[$i]['url'];
				$html .= '<h3 id="' . $aloldalak[$i]['url'] . '"><a href="' . $aloldalak[0]['azonosito'] . '/' . $aloldalak[$i]['url'] . '">' . $aloldalak[$i]['almenu'] . '</a></h3>';
				$html .= '<ul class="links">';	
			}
			
			if($aloldal_azonosito != $aloldalak[$i]['id']){
				$html .= '<li';
				
				/*
				 * Aktuális almenü kijelölése
				 */
				
				if($aloldalak[$i]['tartalom_url'] == $tartalom){
					$html .= ' class="active"';
				}
				
				$html .= '>';
				$html .= '<a href="' . $aloldalak[0]['azonosito'] . '/' . $aloldalak[$i]['url'] . '/' . $aloldalak[$i]['tartalom_url'] . '">' . $aloldalak[$i]['cim'] . '</a>';
				$aloldal_azonosito = $aloldalak[$i]['id'];
			}
			
			if($aloldalak[$i]['altartalom_id'] != null){
				if($altartalom_id != $aloldalak[$i]['tartalom_id']){
					$html .= '<ul class="subsub">';
					$altartalom_id = $aloldalak[$i]['tartalom_id'];
				}
				
				$html .= '<li';
				
				if($aloldalak[$i]['altartalom_url'] == $subsubpage){
					$html = str_replace('class="active"','',$html);
					$html .= ' class="active"';
				}
				
				$html .= '><a href="' . $aloldalak[0]['azonosito'] . '/' . $aloldalak[$i]['url'] . '/' . $aloldalak[$i]['tartalom_url'] . '/' . $aloldalak[$i]['altartalom_url'] . '">' . $aloldalak[$i]['altartalom_cim'] . '</a></li>';
				
				if($altartalom_id != $aloldalak[$i+1]['tartalom_id']){
					$html .= '</ul>';
				}
			}
			
			if($aloldal_azonosito != $aloldalak[$i+1]['id']){
				$html .= '</li>';
			}
			
			if($i + 1 == $aloldalak['count']){
				$html .= '</ul>';
			}
		
		}
		
		return $html;
			
	}

	public function render_felso_menu($aktualis_menu){
	
		$cond['mak_kategoria.menu_elem'] = '1';
		$cond['mak_almenu.menu_elem'] = '1';
	
		$tartalom = $this->get_tartalom($cond);
		$kategoria = '';
		$almenu = '';
		$html = '';
		
		$html .= '<ul id="ldd_menu" class="ldd_menu wrapper">';
		$html .= '<li id="home-menu"><span><a href="">Főoldal</a></span></li>';
		$html .= '<!--<li><span><a href="#">Aktualitások</a></span></li>-->';
		
		for($i = 0; $i < $tartalom['count']; $i++){
		
			if($kategoria != $tartalom[$i]['azonosito']){
				$kategoria = $tartalom[$i]['azonosito'];
					
				$html .= '<li id="' . $kategoria . '-menu"';
				
				if($kategoria == $aktualis_menu){
					$html .= ' class="active_menu"';
				}
				
				$html .= '>';
				$html .= '<span><a href="' . $kategoria . '"';
				
				if($kategoria == 'enautoklubom' && !isset($_SESSION['user_id'])){
					$html .= ' data-reveal-id="loginModal"';
				}
				
				$html .= '>' . $tartalom[$i]['kategoria_nev'] . '</a></span>';
				$html .= '<div class="ldd_submenu">';
				$html .= '<div class="arrow"></div>';
				$html .= '<div class="in">';
			}
			
			if($almenu != $tartalom[$i]['url']){
				$almenu = $tartalom[$i]['url'];
			
				$html .= '<ul>';
				$html .= '<li class="ldd_heading"><a href="' . $kategoria . '/' . $tartalom[$i]['url'] . '">' . $tartalom[$i]['almenu'] . '</a></li>';
			}
			
			$html .= '<li><a href="' . $kategoria . '/' . $tartalom[$i]['url'] . '/' . $tartalom[$i]['tartalom_url'] . '">' . $tartalom[$i]['cim'] . '</a></li>';
			
			if($almenu != $tartalom[$i+1]['url']){
				$html .= '</ul>';
			}
			
			if($kategoria != $tartalom[$i+1]['azonosito']){
				$html .= '</div>';
				$html .= '</div>';
				$html .= '</li>';
			}
			
		}
		
		/*
		$html .= '<li id="travel-menu">';
		$html .= '<span>Travel</span>';
		$html .= '</li>';
		*/
		$html .= '</ul>';
		
		return $html;
		
	}

	public function render_also_menu(){
	
		$cond['mak_kategoria.menu_elem'] = '1';
		$cond['mak_kategoria.azonosito']['and_or'] = 'AND';
		$cond['mak_kategoria.azonosito']['rel'] = ' != ';
		$cond['mak_kategoria.azonosito']['val'] = 'enautoklubom';
		
		$tartalom = $this->get_tartalom($cond);
		$kategoria = '';
		$almenu = '';
		$html = '';
		
		for($i = 0; $i < $tartalom['count']; $i++){
			if($kategoria != $tartalom[$i]['azonosito']){
				$html .= '<div class="footer-sep"></div><ul';
			
				if($kategoria == ''){
					$html .= ' class="first"';				
				}
				
				$kategoria = $tartalom[$i]['azonosito'];
				
				$html .= '>';
				$html .= '<li class="heading ' . $tartalom[$i]['azonosito'] . '"><a href="' . $tartalom[$i]['azonosito'] . '">' . $tartalom[$i]['kategoria_nev'] . '</a></li>';
			}
			
			if($almenu != $tartalom[$i]['url']){
				
				$almenu = $tartalom[$i]['url'];
				
				$html .= '<li><a href="' . $kategoria . '/' . $tartalom[$i]['url'] . '">' . $tartalom[$i]['almenu'] . '</a></li>';
			
			}
			
			if($tartalom[$i+1]['azonosito'] != $kategoria){
				$html .= '</ul>';
			}
		
		}
		
		/*
		$html .= '<div class="footer-sep"></div><ul class="last">';
		$html .= '<li class="heading travel">Travel</li>';
		$html .= '<li><a href="">Külföldi utak</a></li>';
		$html .= '<li><a href="">Belföldi utak</a></li>';
		$html .= '<li><a href="">Exkluzív utak</a></li>';
		$html .= '</ul><div class="footer-sep"></div>';
		*/
		
		return $html;
	
	}

	public function render_search_checkbox(){
	
		$tartalom = $this->get_tartalom();
		$kategoria = '';
		$html = '';
		
		for($i = 0; $i < $tartalom['count']; $i++){
		
			if($kategoria != $tartalom[$i]['azonosito'] && $tartalom[$i]['azonosito'] != 'travel'){
				$kategoria = $tartalom[$i]['azonosito'];
					
				$html .= '<label for="only-' . $tartalom[$i]['azonosito'] . '">' . $tartalom[$i]['kategoria_nev'] . '</label><input type="checkbox" name="only-' . $tartalom[$i]['azonosito'] . '" id="only-' . $tartalom[$i]['azonosito'] . '" checked="checked" />';
			}
		}
		
		return $html;		
	
	}

	public function render_search_results($query,$advanced=''){
	
		if($query == ''){
			return FALSE;
		}
		
		$adv = '';
		
		$kereses[0] = $query;
		
		$kereses = GUMP::sanitize($kereses);
		
		/*
		 * Összetett kereső
		 */
		
		
		
		$col = "mak_tartalom.id AS id,mak_tartalom.almenu_id AS almenu_id,mak_tartalom.cim AS cim,mak_tartalom.szoveg AS szoveg,mak_tartalom.kep AS kep,mak_tartalom.alt AS alt,mak_kategoria.email AS email,mak_kategoria.telefon AS telefon,mak_kategoria.kategoria_nev AS kategoria_nev,mak_kategoria.azonosito AS azonosito,mak_almenu.url AS url,mak_almenu.almenu AS almenu,mak_almenu.title AS title,mak_almenu.description AS description,mak_almenu.keywords AS keywords,mak_tartalom.publikalta AS publikalta, mak_tartalom.url AS tartalom_url, mak_altartalom.url AS altartalom_url";
	
		$sql = "SELECT DISTINCT " . $col . " FROM mak_tartalom LEFT JOIN mak_almenu ON mak_almenu.id=mak_tartalom.almenu_id LEFT JOIN mak_kategoria ON mak_kategoria.id=mak_almenu.kategoria_id LEFT JOIN mak_altartalom ON mak_altartalom.tartalom_id=mak_tartalom.id";

		$cols = explode(",",$col);

		if($advanced != '' && isset($advanced['advanced-search-input'])){
			
			if($advanced['only-enautoklubom'] == 'on'){
				$adv .= " OR mak_kategoria.azonosito='enautoklubom'";
			}
			if($advanced['only-klubtagsag'] == 'on'){
				$adv .= " OR mak_kategoria.azonosito='klubtagsag'";
			}
			if($advanced['only-kozlekedesbiztonsag'] == 'on'){
				$adv .= " OR mak_kategoria.azonosito='kozlekedesbiztonsag'";
			}
			if($advanced['only-segelyszolgalat'] == 'on'){
				$adv .= " OR mak_kategoria.azonosito='segelyszolgalat'";
			}
			if($advanced['only-szervizpontok'] == 'on'){
				$adv .= " OR mak_kategoria.azonosito='szervizpontok'";
			}
			
			$adv = preg_replace('/ OR /',' WHERE (',$adv,1);
			
			$adv .= ")";

		}
			
		$sql = $sql . $adv;
		
		$sql .= " AND (mak_tartalom.cim LIKE '%" . $kereses[0] . "%' OR mak_tartalom.szoveg LIKE '%" . $kereses[0] . "%'";
		$sql .= " OR mak_kategoria.kategoria_nev LIKE '%" . $kereses[0] . "%' OR mak_kategoria.szoveg LIKE '%" . $kereses[0] . "%'";
		$sql .= " OR mak_almenu.almenu LIKE '%" . $kereses[0] . "%' OR mak_almenu.szoveg LIKE '%" . $kereses[0] . "%'";
		$sql .= " OR mak_altartalom.cim LIKE '%" . $kereses[0] . "%' OR mak_altartalom.szoveg LIKE '%" . $kereses[0] . "%'";
		$sql .= ")";
		
		$sql .= " ORDER BY mak_kategoria.sorrend ASC, mak_almenu.sorrend ASC, mak_tartalom.sorrend ASC, mak_altartalom.sorrend";
		
		if($advanced == '' || !isset($advanced['advanced-search-input'])){
			$sql = preg_replace('/ AND /',' WHERE ',$sql,1);
		}
		
		$eredmenyek = $a = $this->results($this->query($sql),$cols);	
		
		$html = '';
		
		$class[0] = 'even';
		$class[1] = 'odd';
		
		$c = 0;
		
		$kat = '';
		$sub = '';
		$tart = '';
		$subsub = '';
		
		for($i = 0;$i<$eredmenyek['count'];$i++){

			if($kat != $eredmenyek[$i]['azonosito'] || $sub != $eredmenyek[$i]['url']){
				
			//|| $tart != $eredmenyek[$i]['cim'] || $subsub != $eredmenyek[$i]['altartalom_url']
			
				$kat = $eredmenyek[$i]['azonosito'];
				$sub = $eredmenyek[$i]['url'];
				$tart = $eredmenyek[$i]['cim'];
				$subsub = $eredmenyek[$i]['altartalom_url'];
			
				$html .= '<li class="' . $class[$c % 2] . '">';
				$html .= '<h3>' . $eredmenyek[$i]['cim'] . '</a></h3>';
				$html .= '<div>' . $this->mark_search_result($kereses[0],$eredmenyek[$i]['szoveg']);
				
				$html .= '<div><a href="' . $this->href($eredmenyek[$i]['azonosito'],$eredmenyek[$i]['url'],$eredmenyek[$i]['tartalom_url'],$eredmenyek[$i]['altartalom_url']) . '" class="link">Bővebben</a></div>';
				
				$html .= '</div>';
				$html .= '</li>';

				$c++;
			}
		
		}
		
		return $html;
	
	}
	
	public function render_breadcrumb($kategoria,$almenu='',$tartalom='',$altartalom=''){
	
		$kategoria = trim($kategoria);
		$almenu = trim($almenu);
		$tartalom = trim($tartalom);
		$altartalom = trim($altartalom);
	
		
		/*
		 * Szervizpont
		 */
		
		if($kategoria == 'szervizpont'){
		
			$html = '<ul id="breadcrumb">';
			$html .= '<li class="first"><a href="">Főoldal</a></li>';
			
			if($kategoria != ''){
				$html .= '<li><a href="szervizpontok">Szervízpontok</a></li>';
			}
			
			if($almenu != ''){
				$html .= '<li><a>Szervízpont</a></li>';
			}
			
			$html .= '</ul>';
		
		}else{
		
			$table = 'mak_kategoria,mak_almenu,mak_tartalom,mak_altartalom';
			$col = 'mak_kategoria.kategoria_nev AS kategoria,mak_almenu.almenu AS almenu,mak_tartalom.cim AS tartalom,mak_altartalom.cim AS altartalom';
			$cond['mak_kategoria.azonosito'] = $kategoria;
			$cond['mak_almenu.url'] = $almenu;
			$cond['mak_tartalom.url'] = $tartalom;
			$cond['mak_altartalom.url'] = $altartalom;
			
			$breadcrumb = $this->sql_select($table,$col,$cond);
			
			$html = '<ul id="breadcrumb">';
			$html .= '<li class="first"><a href="">Főoldal</a></li>';
			
			if($kategoria != ''){
				$link = $kategoria;
				$html .= '<li><a href="' . $link . '">' . $breadcrumb[0]['kategoria'] . '</a></li>';
			}
			
			if($almenu != ''){
				$link .= '/' . $almenu;
				$html .= '<li><a href="' . $link . '">' . $breadcrumb[0]['almenu'] . '</a></li>';
			}
			
			if($tartalom != ''){
				$link .= '/' . $tartalom;
				$html .= '<li><a href="' . $link . '">' . $breadcrumb[0]['tartalom'] . '</a></li>';
			}
			
			if($altartalom != ''){
				$link .= '/' . $altartalom;
				$html .= '<li><a href="' . $link . '">' . $breadcrumb[0]['altartalom'] . '</a></li>';
			}
		
			$html .= '</ul>';
			
		}
		
		return $html;
	
	}
	
	public function render_hirdetes($page,$subpage='',$tartalom='',$subsubpage=''){
	
		$url = trim($page);
		
		if(trim($subpage) != ''){
			$url = trim($subpage);
		}
		
		if(trim($tartalom) != ''){
			$url = trim($tartalom);
		}
		
		if(trim($subsubpage) != ''){
			$url = trim($subsubpage);
		}
		
		/*
		 * Hány darab hírdetés jelenik meg maximálisan az oldalon
		 */
		
		$limit = 3;
		
		$hirdetes = $this->get_hirdetes_urlhez($url);
		$html = '';
		
		if($hirdetes === FALSE || $hirdetes['count'] == 0 || $url == ''){
		
			/*
			 * Default hírdetés
			 */
		
			$html .= '<a target="_blank" href="http://www.arceurope.com/EN/memberservices.aspx"><img class="ad" src="img/ad/arc.gif" alt="ARC europe - Show your card!" /></a>';
			$html .= '<a target="_blank" href="http://www.erscharter.eu/"><img class="ad" src="img/ad/ersc.gif" alt="European road safety charter" /></a>';
			$html .= '<a target="_blank" href="https://www.generali.hu/GeneraliBiztosito.aspx"><img class="ad" src="img/ad/generali.gif" alt="Generali biztosító" /></a>';
		
		}else{
		
			for($i = 0; $i < $hirdetes['count']; $i++){
			
				$html .= '<a target="_blank" href="' . $hirdetes[$i]['cel_url'] . '"><img class="ad" src="' . $this->_hirdetesDir . $hirdetes[$i]['kep'] . '" alt="' . $hirdetes[$i]['alt'] . '" /></a>';
				
				$this->update_hirdetes_utolso_mutatas($hirdetes[$i]['id']);
			
			}
		
		}

		/*
		 * Facebook social plugin
		 */
		
		$html .= '<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FFrontline-m%25C3%25A9dia-Kft%2F134495689944678&amp;width=200&amp;colorscheme=light&amp;show_faces=true&amp;border_color=black&amp;stream=true&amp;header=true&amp;height=427" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:427px; background:white; margin: 0 auto; display: block;" allowTransparency="true"></iframe>';
	
		/*
		 * Twitter plugin
		 */
		
		$html .= '<script src="http://widgets.twimg.com/j/2/widget.js"></script>';
		$html .= "<script>
				new TWTR.Widget({
				  version: 2,
				  type: 'profile',
				  rpp: 3,
				  interval: 30000,
				  width: 200,
				  height: 200,
				  theme: {
				    shell: {
				      background: '#00A0D1',
				      color: '#1c1c1c'
				    },
				    tweets: {
				      background: '#ffffff',
				      color: '#1c1c1c',
				      links: '#0081b0'
				    }
				  },
				  features: {
				    scrollbar: false,
				    loop: false,
				    live: false,
				    hashtags: true,
				    timestamp: true,
				    avatars: true,
				    behavior: 'all'
				  }
				}).render().setUser('cultofmac').start();
				</script>";
		
		return $html;
		
	}
	
	public function render_poll(){
	
		$cond['limit'] = 1;
		$cond['orderby'] = 'modositas desc';
	
		$felm = $this->get_felmeres($cond);
		
		if($felm !== FALSE && $felm['count'] != 0 && isset($_SESSION['user_id'])){
		
			if($this->get_felmeres_felhasznalo_szavazott()){
				
				$sum = $felm[0]['valasz1_db'] + $felm[0]['valasz2_db'] + $felm[0]['valasz3_db'];
				$perc[1]  = substr($felm[0]['valasz1_db'] / $sum, 0 ,4);
				$perc[2]  = substr($felm[0]['valasz2_db'] / $sum, 0 ,4);
				$perc[3]  = 1 - ($perc[1] + $perc[2]);
			
				$html = '<div id="poll-container">';
				$html .= '<h3>' . $felm[0]['kerdes'] . '</h3>';
				$html .= '<div id="pollChoices" class="result">';
				$html .= '<div id="choice1-wrap"><label for="choice1">' . $felm[0]['valasz1'] . '</label><span class="color1" style="width: ' . 215 * $perc[1] . 'px;">' . $perc[1] * 100 . '</span></div>';
				$html .= '<div id="choice2-wrap"><label for="choice2">' . $felm[0]['valasz2'] . '</label><span class="color2" style="width: ' . 215 * $perc[2] . 'px;">' . $perc[2] * 100 . '</span></div>';
				$html .= '<div id="choice3-wrap"><label for="choice3">' . $felm[0]['valasz3'] . '</label><span class="color3" style="width: ' . 215 * $perc[3] . 'px;">' . $perc[3] * 100 . '</span></div>';
				$html .= '</div>';
				$html .= '</div>';
			
			}else{
		
				$html = '<div id="poll-container">';
				$html .= '<h3>' . $felm[0]['kerdes'] . '</h3>';
				$html .= '<div id="pollChoices">';
				$html .= '<div id="choice1-wrap">';
				$html .= '<label for="choice1">' . $felm[0]['valasz1'] . '</label><input type="radio" name="poll-choice" id="valasz1" />';
				$html .= '</div>';
				$html .= '<div id="choice2-wrap">';
				$html .= '<label for="choice2">' . $felm[0]['valasz2'] . '</label><input type="radio" name="poll-choice" id="valasz2" />';
				$html .= '</div>';
				$html .= '<div id="choice3-wrap">';
				$html .= '<label for="choice3">' . $felm[0]['valasz3'] . '</label><input type="radio" name="poll-choice" id="valasz3" />';
				$html .= '</div>';
				$html .= '</div>';
				$html .= '<button class="yellow-button" id="vote">Szavazok</button>';
				$html .= '</div>';
				
			}
			
			return $html;
			
		}
	
	}

	
	//Kiegészítő függvények
	
	public function mark_search_result($query_string,$result_string){
	
		$mark_start = '<span class="mark">';
		$mark_end = '</span>';
		$max_hossz = '200';
		
		$result_string = strip_tags($result_string,'<h3>');
		
		$pozicio = stripos($result_string,$query_string);
		
		$eleje = substr($result_string, 0, $pozicio);
		$kozepe = substr($result_string, $pozicio, strlen($query_string));
		$vege = substr($result_string, $pozicio + strlen($query_string));
		
		$string = $eleje . $mark_start . $kozepe . $mark_end . $vege;
		
		if($pozicio === FALSE){
			$a = substr($result_string, 0, $max_hossz);
		}else{
			if($pozicio - 100 < 0){
				$pozicio = 0;
			}else{
				$pozicio = $pozicio - 100;
			}
			$b = substr($string, $pozicio, $max_hossz);
			$utolso = strpos($b,' ');
			$a = substr($b,$utolso);
		}
		
		$string = substr($a, 0, strrpos($a,' '));
		
		return $string;
	}
	
	public function date_dash($date_string){
	
		if(strlen($date_string) != 8){
			return false;
		}
		
		$date = substr($date_string,0,4) . "-";
		$date .= substr($date_string,4,2) . "-";
		$date .= substr($date_string,6,2);
		
		return $date;
	
	}
	
	public function betekinto($string){
	
		$max_len = 800;
	
		$text[0] = trim($string);
		$text = GUMP::sanitize($text);
		
		if(strlen($string) > $max_len){
			$str = substr($string,0,$max_len);
			$poz[] = strrpos($str,".");
			$poz[] = strrpos($str,"!");
			$poz[] = strrpos($str,"?");
			return substr($str,0,max($poz)+1);
		}else{
			return strip_tags($string);
		}
	
	}

	public function href($page,$sub='',$tartalom='',$subsub=''){
		
		if($page == ''){
			return FALSE;
		}
		
		$url = '';
		
		$url .= $page;
		
		if($sub != ''){
			return $url .= '/' . $sub;
		}
	
		if($tartalom != ''){
			return $url .= '/' . $tartalom;
		}
		
		if($subsub != ''){
			return $url .= '/' . $subsub;
		}
		
		return $url;
	}
	
	public function poll($valasz){

		$valasz = trim($valasz);
		$poll_id = $this->get_felmeres_legujabb_id();
		
		$this->update_felmeres_valasz($poll_id,$valasz);
		
		$poll = $this->get_felmeres_idbol($poll_id);
		
		$val[1] = $poll[0]['valasz1_db'];
		$val[2] = $poll[0]['valasz2_db'];
		$val[3] = $poll[0]['valasz3_db'];
		
		$full = array_sum($val);
		$perc[1] = substr($val[1] / $full, 0, 4);
		$perc[2] = substr($val[2] / $full, 0, 4);
		$perc[3] = 1 - ($perc[1] + $perc[2]);

		$json = '[{"choice":"choice1","votes":"' . $val[1] . '","percent":"' . $perc[1] . '"},';
		$json .= '{"choice":"choice2","votes":"' . $val[2] . '","percent":"' . $perc[2] . '"},';
		$json .= '{"choice":"choice3","votes":"' . $val[3] . '","percent":"' . $perc[3] . '"}]';
		
		return $json;
	
	}

	public function randomString(){

	    $length = 10;
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $string = '';    
	    for ($p = 0; $p < $length; $p++) {
	        $string .= $characters[mt_rand(0, strlen($characters))];
	    }
	    return $string;
		
	}
	
	public function adatmodosito_template($form){
	
		$userid = $_SESSION['user_id'];
		$cond['id'] = $userid;
		$tags = array('%coSetStart%', '%coSetEnd%', '%natSetStart%', '%natSetEnd%');
		
		$adatok = $this->get_felhasznalo($cond);
	
		if($adatok[0]['rendszam'] != ''){
			$adatok[0]['rendszam'] = substr($adatok[0]['rendszam'], 0, 3) . '-' . substr($adatok[0]['rendszam'], 3);
		}
		
		if($adatok[0]['nem'] != 'C'){
			$form = $this->replaceTags('%coSetStart%', '%coSetEnd%', '', $form);
			
			if($adatok[0]['nem'] == 'N'){
				$no = ' selected="selected"';
				$ferfi = '';
			}else{
				$no = '';
				$ferfi = ' selected="selected"';
			}
			
			$nem_opt = '<option value="N"' . $no . '>Nő</option>';
			$nem_opt .= '<option value="F"' . $ferfi . '>Férfi</option>';
			
			$form = str_replace('%nem_options%', $nem_opt,$form);
		}else{
			$form = $this->replaceTags('%natSetStart%', '%natSetEnd%', '', $form);
		}
		
		$form = str_replace($tags,"",$form);
		
		//print_r($adatok);
		
		foreach($adatok[0] as $key => $val){
			$form = str_replace("%" . $key . "%", $val, $form);
		}
		
		//$form = str_replace("%allando_telepules%", $adatok[0]['allando_kozterulet'] . " " . $adatok[0]['allando_hazszam'] . ".", $form);
		
		$cond = array();
		$cond['mak_gyartmany.display'] = 1;
		$cond['mak_marka.display'] = 1;
		
		$gyartmany = $this->get_gyartmany($cond);
		
		$gy = '';
		$t = '';

		$gyart_opt = '';
		$tip_opt = '';
		
		//print_r($gyartmany);
		
		for($i=0;$i<$gyartmany['count'];$i++){
		
			if($gy != $gyartmany[$i]['marka']){
				$gyart_opt .= '<option value="' . $gyartmany[$i]['marka_sap_kod'] . '"';
				
				if($gyartmany[$i]['marka_sap_kod'] == $adatok[0]['gyartmany_sap']){
					$gyart_opt .= ' selected="selected"';
				}
				
				$gyart_opt .= '>' . $gyartmany[$i]['marka'] . '</option>';
				$gy = $gyartmany[$i]['marka'];
			}
			
			if($gyartmany[$i]['marka_sap_kod'] == $adatok[0]['gyartmany_sap']){
				$tip_opt .= '<option value="' . $gyartmany[$i]['gyartmany_sap_kod'] . '"';
				
				if($gyartmany[$i]['gyartmany_sap_kod'] == $adatok[0]['tipus_sap']){
					$tip_opt .= ' selected="selected"';
				}
				
				$tip_opt .= '>' . $gyartmany[$i]['tipus'] . '</option>';
			}
		
		}
		
		$form = str_replace('%marka_options%', $gyart_opt,$form);
		$form = str_replace('%tipus_options%', $tip_opt,$form);
		
		$_SESSION['email'] = $adatok[0]['e_mail'];
		
		return $form;
		
	}
	
	public function replaceTags($startPoint, $endPoint, $newText, $source) {
    	return preg_replace('#('.preg_quote($startPoint).')(.*)('.preg_quote($endPoint).')#si', '$1'.$newText.'$3', $source);
	}

	public function upgrade_extend_template($form){
	
		$kartya[1] = 'Kék (régi)';
		$kartya[2] = 'Diszkont';
		$kartya[3] = 'Standard';
		$kartya[4] = 'Komfort';
		$kartya[5] = 'Diszkont plusz';
	
		$ar[1] = '0';
		$ar[2] = '1000';
		$ar[3] = '10000';
		$ar[4] = '100000';
		$ar[5] = '1500';
		
		$col = 'gyartasi_ev,rendszam';
		$cond['id'] = $_SESSION['user_id'];
		
		$adat = $this->get_felhasznalo($cond,$col);
		
		if($adat[0]['rendszam'] != ''){
			$form = str_replace("%rendszam%",substr($adat[0]['rendszam'],0,3) . "-" . substr($adat[0]['rendszam'],3),$form);
		}else{
			$form = str_replace("%rendszam%",'',$form);
		}
		
		if($adat[0]['gyartasi_ev'] != ''){
			$form = str_replace("%gepjarmu_kora%",date("Y") - $adat[0]['gyartasi_ev'],$form);
		}else{
			$form = str_replace("%gepjarmu_kora%",'',$form);
		}
		
		$form = str_replace("%backUrl%",'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/lib/php/otpwebshop/web_demo/pdf/visszaigazolas.php',$form);
		
		$form = str_replace("%currentLevel%",strtolower((isset($kartya[$_SESSION['tagsag']]) ? $kartya[$_SESSION['tagsag']] : 'nem')),$form);
		$form = str_replace("%currentPrice%",strtolower((isset($ar[$_SESSION['tagsag']]) ? $ar[$_SESSION['tagsag']] : '0')),$form);
		
		if($_SESSION['tagsag'] > 1){
			$form = $this->replaceTags('%diszkontRadioStart%', '%diszkontRadioEnd%', '', $form);
		}
		
		if($_SESSION['tagsag'] > 2){
			$form = $this->replaceTags('%standardRadioStart%', '%standardRadioEnd%', '', $form);
		}
		
		if($_SESSION['tagsag'] > 3){
			$form = $this->replaceTags('%komfortRadioStart%', '%komfortRadioEnd%', '', $form);
		}
		
		if($_SESSION['tagsag'] == 4){
			$form = $this->replaceTags('%szintvaltasStart%', '%szintvaltasEnd%', '', $form);
		}
	
		$form = str_replace("%diszkontRadioStart%","",$form);
		$form = str_replace("%diszkontRadioEnd%","",$form);
		
		$form = str_replace("%standardRadioStart%","",$form);
		$form = str_replace("%standardRadioEnd%","",$form);
		
		$form = str_replace("%komfortRadioStart%","",$form);
		$form = str_replace("%komfortRadioEnd%","",$form);
		
		$form = str_replace("%szintvaltasStart%","",$form);
		$form = str_replace("%szintvaltasEnd%","",$form);
		
		$form = str_replace("%standardMemberStart%","",$form);
		$form = str_replace("%standardMemberEnd%","",$form); 
		
		$form = str_replace("%komfortMemberStart%","",$form);
		$form = str_replace("%komfortMemberEnd%","",$form);
		
		return $form;
	}
	
}

?>
