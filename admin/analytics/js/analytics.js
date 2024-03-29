	google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    
    function drawChart() {
    	
    	$.post("php/process.php", 
    			{ 
    				chart: "visits"
    			},
    			 function(resp) {
    				
    				var chartData = new google.visualization.DataTable();
    				chartData.addColumn('string', 'Nap');
    				chartData.addColumn('number', 'Látogatók');
    				chartData.addRows(32);
    				
    			    var i = 0;
    			    
    				 $.each(resp.data, function() {
    					 	
    		                chartData.setValue(i, 0, this.date.substr(0,4) + '-' + this.date.substr(4,2) + '-' + this.date.substr(6,2));
    		                chartData.setValue(i, 1, Number(this.visits));    		                
    		                i = i + 1;
    		         });
    				 /*
    				  * Grafikon létrehozás
    				  */
    				 var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
    			      chart.draw(chartData, {width: 940, height: 400, title: 'Látogatottság az elmúlt 30 napban',
    			                        hAxis: {title: 'Nap', titleTextStyle: {color: 'red'}}
    			                       });
    				 
    			 $("#avg_time_span").html(resp.avgTime.substr(0,5));
    			 $("#bounce_rate_span").html(resp.bounces.substr(0,5));
    			 $("#new_visits_span").html(resp.new_visits.substr(0,5));
    			 $("#ret_visits_span").html(resp.ret_visits.substr(0,5));
    			 
    			 var pagev = '<ol>';
    			 i = 0;
    			 /*
    			  * Látogatottsági adatok megjelenítése
    			  */
    			 $.each(resp.pageviews, function() {
    				 if(i < 5){
    					pagev += '<li>' + this.pagepath + ' -> ' + this.pageview + ' látogató </li>';
 		                i = i + 1; 
    				 }
		         });
    			 
    			 pagev += '</ol>';
    			 
    			 /*
    			  * Összeállított html beillesztése a megfelelő div-be
    			  */
    			 
    			 $("#pageviews_span").html(pagev);
    			 
    			 },"json"
    	);
      
    };