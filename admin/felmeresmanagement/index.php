<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <title>felmeres Management</title>
    
    <link rel="stylesheet" href="smoothness/smoothness.css" />
    <link rel="stylesheet" href="css/ui.jqgrid.css" />
    <script type="text/javascript" src="js/jquery-1.6.2.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.9.js"></script>
    <script type="text/javascript" src="js/grid.locale-hu.js"></script>
	<script type="text/javascript" src="js/jquery.jqGrid.min.js"></script>
    <script type="text/javascript" src="js/felmeresmanagement.js"></script>
  </head>
  <body>
    <div id="content">
		<table id="felmeresmanagement"></table>
		<div id="pager"></div>
		<div id="sorsolasContent">
			<div id="gombok">
				Hány felhasználót sorsoljunk ki?<input type="text" id="darab"/><br />
				Melyik kérdés?<input type="text" id="kerdes"/><br />
				Jó válasz sorszáma: 
				<select id="valasz" name="valasz">
					<option value="0">Nem kell jó válasz</option>
					<option value="1">1. válasz</option>
					<option value="2">2. válasz</option>
					<option value="3">3. válasz</option>
				</select>
				<button id="sorsolas">Sorsolás</button>
				<br />
			</div>
			<div id="eredmeny"></div>
		</div>
    </div>
  </body>
</html>