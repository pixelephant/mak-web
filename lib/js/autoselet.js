/*Autósélet*/

function viewMag(id,embedcode){
		$(".embed").slideUp();
		$(".embed").html(embedcode);
     	$('html,body').animate({scrollTop: $("#"+id).offset().top},'slow',function(){
     		$(".embed").slideDown();
     	});
}

$(".autoselet").mouseenter(function(){
	$(this).find(".img").animate({
		"top" : "0px"
	},300);
});

$(".autoselet").mouseleave(function(){
		$(this).find(".img").animate({
			"top" : "10px"
		},300);
});

$(".autoselet").click(function(){
	var $this = $(this);
	if($(this).data("embed") == undefined){
		$.post("lib/php/autoselet.php",{
			"id" : $(this).attr("id")
		},function(resp){
			$this.data("embed",resp);
			viewMag("content",$this.data("embed"));
		});
	}
	else{
		viewMag("content",$(this).data("embed"));
	}
});