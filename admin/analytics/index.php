<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <title>Analytics API test</title>
    
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="js/jquery-1.6.2.js"></script>
    <script type="text/javascript" src="js/analytics.js"></script>
  </head>
  <body>
    <div id="content">
		<div id="chart_div"></div>
		<div id="data_div">
			<p id="avg_time">Az oldalon eltöltött átlagos idő: <span id="avg_time_span"></span> másodperc<span id="avg_time_info_span"></span></p>
			<p id="bounce_rate">Visszafordulások aránya: <span id="bounce_rate_span"></span>%<span id="bounce_rate_info_span" title="A visszafordulási arány az egyoldalas látogatások, illetve az olyan látogatások százalékos aránya, amelyeknél a látogató a belépési (nyitó) oldalról elhagyja a webhelyet."> INFO</span></p>
			<p id="new_visits">Új látogatók aránya: <span id="new_visits_span"></span>%<span id="new_visits_info_span"></span></p>
			<p id="ret_visits">Visszatérő látogatók aránya: <span id="ret_visits_span"></span>%<span id="ret_visits_info_span"></span></p>
			<p id="pageviews">Leglátogatottabb 5 lap: <span id="pageviews_span"></span><span id="pageviews_info_span"></span></p>
		</div>
    </div>
 </body>
</html>