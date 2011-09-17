/*Táblázat színezés*/

$.each($(".mak-table"),function(){
	$(this).find("tbody tr").eq(0).addClass("first");
	$(this).find("tbody tr:last").addClass("last");
})

$.each($(".mak-table tr"),function(){
	$(this).find("td:odd").addClass("odd");
});

/*Galéria init*/

if($(".gallery").length){
	$(".gallery a").colorbox();
}


/* 2.5D */
$.timeout(1000).done(function() {
	
	//háttér animálása
	$(".head").animate({
		"backgroundPositionX" : 0
	},1000);
		
	//vontatós kocsis
	
	$(".segelyszolgalat .head .layer1").animate({
		"left" : "155px"
	},2000);
	
	$(".segelyszolgalat .head .layer2").animate({
		"left" : "-150px"
	},2000);
	
	//szerelőcsávós
	 
	$(".szervizpontok .head .layer1").animate({
		"left" : 0
	},2000);
		
	$(".szervizpontok .head .layer2").animate({
		"left" : 0
	},2000);   
});