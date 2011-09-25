	/*
* jQuery.fn.rand();
*
* Return a random, but defined numbers of elements from a jQuery Object.
* $('element').rand(); // returns one element from the jQuery Object.
* $('element').rand(4); // returns four elements from the jQuery Object.
*
* Version 0.8.5
* www.labs.skengdon.com/rand
* www.labs.skengdon.com/rand/js/rand.min.js
*
* And:
* http://phpjs.org/functions/array_rand:332
*/
;(function($){$.fn.rand=function(number){var array_rand=function(input,num_req){var indexes=[];var ticks=num_req||1;var checkDuplicate=function(input,value){var exist=false,index=0;while(index<input.length){if(input[index]===value){exist=true;break;};index++;};return exist;};while(true){var rand=Math.floor((Math.random()*input.length));if(indexes.length===ticks){break;};if(!checkDuplicate(indexes,rand)){indexes.push(rand);}};return((ticks==1)?indexes.join():indexes);};if(typeof number!=='number')var number=1;if(number>this.length)number=this.length;var numbers=array_rand(this,number);var $return=[];for(var i=0;i<number;i++){$return[i]=this.get(numbers[i]);};return $($return);};}(jQuery));
	
	$("#jatek-bg").find("img").hide();
	
	var correctNo = 0;
	
	
	$("#startgame").click(function(){
		startGame();
	});
	
	function startGame(){
		correctNo = 0;
		var $items = $("#jatek-bg").find("img").rand(9);      
		$("#jatek-bg").empty().append($items);
		$("#jatek-bg img:last").addClass("last");
		$items.eq(0).addClass("current").fadeIn();
		$("#endscore").hide();
		$("#startgame").hide();
		$("#currentscore span").html(0).end().css("color","black");
		$("#currentscore,#choices").fadeIn();
	}
	
	$("#tipp").click(function(){
		
		if($("#jatek-bg .current").data("correct") == $("#choice-select").find("option:selected").val()){
			correctNo++;
			$("#currentscore span").css("color","green").html(correctNo);
			if($("#jatek-bg .current").hasClass("last")){      
				$("#choices").hide();
				$("#currentscore").hide();
				$("#startgame").show();
				$("#endscore").show().find("span").html(correctNo);
			}
			$("#jatek-bg .current").fadeOut().removeClass("current").next("img").addClass("current").fadeIn();
		}
		else{
			if($("#jatek-bg .current").hasClass("last")){      
				$("#choices").hide();
				$("#currentscore").hide();
				$("#startgame").show();
				$("#endscore").show().find("span").html(correctNo);
			}
			$("#jatek-bg .current").fadeOut().removeClass("current").next("img").addClass("current").fadeIn();
			$("#currentscore span").css("color","red");
		}
		
		
		
	});