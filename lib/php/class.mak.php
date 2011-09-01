<?php 

class mak extends db{
	
	private $_imageDir = 'img/';
	private $_galleryDir = 'img/gallery/';
	private $_autoseletDir = 'media/autoselet/';
	private $_hirekDir = 'img/hirek/';

	public function __construct($debug=false){
		parent::__construct('','','','','',$debug);
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
		$col = 'mak_gyartmany.id AS id,
				mak_marka.marka AS marka,
				tipus,mak_marka.sap_kod AS marka_sap_kod,
				mak_gyartmany.sap_kod AS gyartmany_sap_kod,
				mak_gyartmany.display AS gyartmany_display,
				mak_marka.display AS marka_display';
		
		$join[0]['type'] = 'INNER JOIN';
		$join[0]['table'] = 'mak_marka';
		$join[0]['value'] = 'mak_marka.id=mak_gyartmany.marka';
		
		if($cond != ''){
			$cond = GUMP::sanitize($cond);
		}
		if($join != ''){
			$join = GUMP::sanitize($join);
		}
		
		return $this->sql_select($table,$col,$cond,$join);
		
	}

	public function get_felhasznalo($cond='',$col=''){
	
		$table = 'mak_felhasznalo';
	
		if($cond != ''){
			$cond = GUMP::sanitize($cond);
		}
		
		$col = trim($col);
		
		if($col == ''){
			$col = 'mak_login_id,mak_login_id,nem,szuletesi_datum,anyja_neve,elonev,vezeteknev,keresztnev,allando_irsz,allando_helyseg,allando_kozterulet,allando_hazszam,levelezesi_irsz,levelezesi_helyseg,levelezesi_kozterulet,levelezesi_hazszam,vezetekes_telefon,mobil_telefon,e_mail,rendszam,gyartmany_sap,tipus_sap,gyartasi_ev,elso_forgalom,tagtipus,dijkategoria,statusz,belepes_datuma,ervenyesseg_datuma,befizetes_datuma,befizetett_osszeg,tranzakcio_kodja,modositas';
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
	
	public function get_login($felhasznalo_nev,$jelszo){
	
		$cond['felhasznalonev'] = $felhasznalo_nev;
		$cond['jelszo'] = $jelszo;
		
		$table = 'mak_login';
		
		$cond = GUMP::sanitize($cond);
		
		$col = 'id';
		
		$filters = array(
			'felhasznalonev' => 'trim|sanitize_string',
			'jelszo'	  	=> 'trim',
		);
		
		$rules = array(
			'felhasznalonev'    => 'required|alpha_numeric|max_len,100|min_len,6',
			'jelszo'    => 'required|max_len,100|min_len,6',
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
		
		if($col != ''){
			$col = GUMP::sanitize($col);
		}
		
		if($join != ''){
			$join = GUMP::sanitize($join);
		}
		
		$cond['orderby'] = 'mak_kategoria.sorrend ASC, mak_almenu.sorrend ASC, mak_tartalom.sorrend ASC';
		
		$join[0]['table'] = 'mak_almenu';
		$join[0]['value'] = 'mak_almenu.id=mak_tartalom.almenu_id';
		$join[1]['table'] = 'mak_kategoria';		
		$join[1]['value'] = 'mak_kategoria.id=mak_almenu.kategoria_id';
		
		if($col == ''){
			$col = 'mak_tartalom.id AS id,mak_tartalom.almenu_id AS almenu_id,mak_tartalom.cim AS cim,mak_tartalom.szoveg AS szoveg,mak_tartalom.kep AS kep,mak_tartalom.alt AS alt,';
			$col .= 'mak_kategoria.email AS email,mak_kategoria.telefon AS telefon,mak_kategoria.kategoria_nev AS kategoria_nev,mak_kategoria.azonosito AS azonosito,mak_almenu.url AS url,';
			$col .= 'mak_almenu.almenu AS almenu,mak_almenu.title AS title,mak_almenu.description AS description,mak_almenu.keywords AS keywords,mak_tartalom.publikalta AS publikalta';
		}
		
		return $this->sql_select($table,$col,$cond,$join);
	
	}

	public function get_oldal_tartalom($oldal){
	
		$cond['mak_almenu.url'] = $oldal;
	
		return $this->get_tartalom($cond);
		
	}
	
	public function get_tartalom_kereses($kereses){
	
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
		
			$cond['cim']['val'] = '%'.$keres['kereses'].'%';
			$cond['cim']['rel'] = "LIKE";
			
			$cond['szoveg']['val'] = '%'.$keres['kereses'].'%';
			$cond['szoveg']['rel'] = "LIKE";
			$cond['szoveg']['and_or'] = "OR";
		
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
		$kategoria = $this->get_kategoria_urlbol($almenu);
		
		$cond['mak_almenu.kategoria_id'] = $kategoria;
		
		return $this->get_tartalom($cond);
	
	}
	
	public function get_parameterek_urlbol($url){
		
		if($url == ''){
			return FALSE;
		}
	
		$table = 'mak_almenu';
		$col = 'mak_almenu.almenu AS almenu,mak_almenu.title AS title,mak_almenu.keywords AS keywords,mak_almenu.description AS description,mak_almenu.css AS css,mak_almenu.javascript AS javascript';
		$cond['mak_almenu.url'] = $url;
	
		$a = $this->sql_select($table,$col,$cond);
		
		return $a[0];
		
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
	
	public function get_autoselet($evfolyam=''){
	
		$table = 'mak_autoselet';
		
		$evfolyam = trim($evfolyam);
		
		if($evfolyam != ''){
			$cond['evfolyam'] = $evfolyam;
		}
		
		$cond['orderby'] = ' evfolyam desc, lapszam asc';
		
		if($col == ''){
			$col = 'id,kep_filenev,evfolyam,lapszam,embed_kod,modositas';
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
		
		$validate = GUMP::validate($felhasznalo_array, $rules);

		//Validálás vége
		
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
		 * Bejelentkezési adatok beillesztése a login táblába
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
			if($this->sql_insert('mak_login',$login_array)){
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
		
		$validate = GUMP::validate($felhasznalo_array, $rules);
		
		if($cond != ''){
			$cond = GUMP::filter($cond, $filters);
		
			$validate2 = GUMP::validate($cond, $rules);
		}else{
			$validate2 = TRUE;
		}
		
		//Validálás vége
		
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
	
	//RENDER
	
	public function render_aloldal_section($aloldal,$valtozo=''){

		/*
		 * @param string $aloldal : a megfelelő aloldal url-ben található azonosítója
		 * @return mixed : FALSE vagy a html-t tartalmazó string
		 */
	
		$aloldal = trim($aloldal);
		$valtozo = trim($valtozo);
		
		if($aloldal == ''){
			return FALSE;
		}
		
		switch($aloldal){
			
			case "autoselet":

				$position[0] = 'left';
				$position[1] = 'center';
				$position[2] = 'right';
			
				$tartalom = $this->get_autoselet($valtozo);
				
				if($tartalom === FALSE){
					return FALSE;
				}
				
				$html = '<div class="embed">';
				$html .= '</div>';
				
				for($i = 0; $i < $tartalom['count']; $i = $i + 3){
					
					$html .= '<div class="row">';
					$html .= '<div class="autoselet ';					
					$html .= $position[$i % 3];
					$html .= '">';
					
					$html .= '<div class="img">';
					$html .= '<img src="' . $this->_autoseletDir . $tartalom[$i]['kep_filenev'] . '" alt="Autosélet - ' . $tartalom[$i]['evfolyam'] . '/' . $tartalom[$i]['lapszam'] . '" />';					
					$html .= '</div>';
					
					$html .= '</div>';
					$html .= '</div>';
				
				}
				break;
			
			case "hosszabitas":
				
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
				break;

			case "enautoklubom":
				
				$tartalom = $this->get_oldal_tartalom($aloldal);
				
				if($tartalom === FALSE){
					return FALSE;
				}
			
				for($i = 0; $i < $tartalom['count']; $i++){
				
					$html = '<section>';
					$html .= '<h2>' . $tartalom[$i]['cim'] . '</h2>';
					
					$idopont = date("Y-m-d", strtotime($tartalom[$i]['modositas']));
					
					$html .= '<h3>' . $idopont . $tartalom[$i]['publikalta'] . '</h3>';
					$html .= '<p>' . $tartalom[$i]['szoveg'] . '</p>';
				    $html .= '<img src="' . $_hirekDir . $tartalom[$i]['kep'] . '" alt="' . $tartalom[$i]['alt'] . '" />';
					$html .=  '</section>';
					
					if($i != $tartalom['count'] - 1){
						$html .= '<div class="hr"></div>';
					}
					
				}
				
				break;
				
			default:
				$tartalom = $this->get_oldal_tartalom($aloldal);
				
				if($tartalom === FALSE){
					return FALSE;
				}
				
				$galeria = '';
				$html = '';
				
				for($i = 0; $i < $tartalom['count']; $i++){
				
					$html .= '<section id="' . $tartalom[$i]['cim'] . '">';
					$html .= '<h2>'.$tartalom[$i]['cim'].'</h2>';
					$html .= '<p>'.$tartalom[$i]['szoveg'].'</p>';
					$html .= '<img src="' . $this->_imageDir . 'aloldal/' . $tartalom[$i]['azonosito'] . '/' . $tartalom[$i]['url'] . '/' . $tartalom[$i]['kep'] . '" alt="' . $tartalom[$i]['alt'] . '" />';
				
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
			break;
		}

		return $html;
	}

	public function render_aloldal_bal_menu($aloldal){
		
		if($aloldal == ''){
			return FALSE;
		}
	
		$aloldal = trim($aloldal);
		$html = '';
		$almenu = '';
		
		$aloldalak = $this->get_menu_aktualis_almenuhoz($aloldal);
		
		if($aloldalak === FALSE){
			return FALSE;
		}
		
		$html .= '<h2 id="'. $aloldalak[0]['azonosito'] .'">';
		$html .= '<img src="' . $this->_imageDir . $aloldalak[0]['azonosito'] . '.png" alt="' . $aloldalak[0]['kategoria_nev'] . '" />';
		$html .= $aloldalak[0]['kategoria_nev'] . '</h2>';
		
		for($i = 0; $i < $aloldalak['count']; $i++){
			
			if($almenu != $aloldalak[$i]['url']){
				if($almenu != ''){
					$html .= '</ul>';
				}
				$almenu = $aloldalak[$i]['url'];
				$html .= '<h3 id="' . $aloldalak[$i]['url'] . '">' . $aloldalak[$i]['almenu'] . '</h3>';
				$html .= '<ul class="links">';	
			}
			
			$html .= '<li>';
			$html .= '<a href="' . $aloldalak[$i]['url'] . '#' . $tartalom[$i]['cim'] . '">' . $aloldalak[$i]['cim'] . '</a>';
			$html .= '</li>';
			
			if($i + 1 == $aloldalak['count']){
				$html .= '</ul>';
			}
		
		}
		
		return $html;
			
	}

	public function render_felso_menu(){
	
		$tartalom = $this->get_tartalom();
		$kategoria = '';
		$almenu = '';
		$html = '';
		
		for($i = 0; $i < $tartalom['count']; $i++){
		
			if($kategoria != $tartalom[$i]['azonosito']){
				$kategoria = $tartalom[$i]['azonosito'];
					
				$html .= '<li id="' . $kategoria . '-menu">';
				$html .= '<span>' . $tartalom[$i]['kategoria_nev'] . '</span>';
				$html .= '<div class="ldd_submenu">';
				$html .= '<div class="arrow"></div>';
				$html .= '<div class="in">';
			}
			
			if($almenu != $tartalom[$i]['url']){
				$almenu = $tartalom[$i]['url'];
			
				$html .= '<ul>';
				$html .= '<li class="ldd_heading">' . $tartalom[$i]['almenu'] . '</li>';
			}
			
			$html .= '<li><a href="' . $tartalom[$i]['url'] . '#' . $tartalom[$i]['cim'] . '">' . $tartalom[$i]['cim'] . '</a></li>';
			
			if($almenu != $tartalom[$i+1]['url']){
				$html .= '</ul>';
			}
			
			if($kategoria != $tartalom[$i+1]['azonosito']){
				$html .= '</div>';
				$html .= '</div>';
				$html .= '</li>';
			}
			
		}
		
		return $html;
		
	}

	public function render_also_menu(){
	
		$cond['mak_kategoria.azonosito']['and_or'] = 'AND';
		$cond['mak_kategoria.azonosito']['rel'] = ' != ';
		$cond['mak_kategoria.azonosito']['val'] = 'enautoklubom';
		
		$tartalom = $this->get_tartalom($cond);
		$kategoria = '';
		$almenu = '';
		$html = '';
		
		for($i = 0; $i < $tartalom['count']; $i++){
			if($kategoria != $tartalom[$i]['azonosito']){
				$html .= '<ul';
			
				if($kategoria == ''){
					$html .= ' class="first"';				
				}
				
				$kategoria = $tartalom[$i]['azonosito'];
				
				$html .= '>';
				$html .= '<li class="heading ' . $tartalom[$i]['azonosito'] . '">' . $tartalom[$i]['kategoria_nev'] . '</li>';
			}
			
			if($almenu != $tartalom[$i]['url']){
				
				$almenu = $tartalom[$i]['url'];
				
				$html .= '<li><a href="' . $tartalom[$i]['url'] . '#' . $tartalom[$i]['cim'] . '">' . $tartalom[$i]['almenu'] . '</a></li>';
			
			}
			
			if($tartalom[$i+1]['azonosito'] != $kategoria){
				$html .= '</ul>';
			}
		
		}
		
		return $html;
	
	}

}

?>