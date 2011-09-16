<?php 
    /**
    * @desc P�lda olyan eredm�ny oldalra, melyre a h�romszerepl�s
    * fizet�s sikeres lefut�sa ut�n t�rt�nik a vez�rl�s�tad�s
    * b�ng�sz� oldali redirect utas�t�ssal.
    * 
    * Ilyenkor csup�n h�rom request GET param�ter �ll rendelkez�sre,
    * azokkal a nevekkel, amik a ketszereplosshop.conf f�jlban
    * tal�lhat�k, melyek alap�rtelmez�s szerint:
    * - posId
    * - tranzakcioAzonosito
    * - authKod
    * 
    * E h�rom param�ter azonban el�g arra, hogy ig�ny eset�n lek�rdezhet�
    * majd megjelen�thet� legyen a tranzakci� �sszes adata. Ehhez haszn�lhat�
    * k�zvetlen�l a WebShopService->tranzakcioStatuszLekerdezes
    * met�dus, de enn�l egyszer�bben kezelhet� a fiz3_control.php p�ld�ban szerepl�
    * processDirectedToBackUrl() f�ggv�nyh�v�s is! (Ut�bbi haszn�lja a 
    * fent eml�tett REQUEST param�tereket!)
    */

    require_once('_header_footer.php');
    demo_header('fiz3_main');
    demo_menu();
    demo_title(); 
?>

<h2 class="siker">Sikeres (teszt) v�s�rl�s</h2>

<table class="eredmenytabla1">
  <tr>
    <th>Tranzakci� azonosit�:</td>
    <td><?php echo $_REQUEST['posId'] ?></th>
  </tr>
  <tr>
    <th>Shop ID:</td>
    <td><?php echo $_REQUEST['tranzakcioAzonosito'] ?></th>
  </tr>
  <tr>
    <th>Authoriz�ci�s k�d:</th>
    <td><?php echo $_REQUEST['authKod'] ?></td>
  </tr>
</table>

<?php demo_footer(); ?>