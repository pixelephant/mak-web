/**
 * Autotab - jQuery plugin 1.1b
 * http://www.lousyllama.com/sandbox/jquery-autotab
 * 
 * Copyright (c) 2008 Matthew Miller
 * 
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 * 
 * Revised: 2008-09-10 16:55:08
 */

(function($) {
// Look for an element based on ID or name
var check_element = function(name) {
	var obj = null;
	var check_id = $('#' + name);
	var check_name = $('input[name=' + name + ']');

	if(check_id.length)
		obj = check_id;
	else if(check_name != undefined)
		obj = check_name;

	return obj;
};

/**
 * autotab_magic automatically establishes autotabbing with the
 * next and previous elements as provided by :input.
 * 
 * autotab_magic should called after applying filters, if used.
 * If any filters are applied after calling autotab_magic, then
 * Autotab may not protect against brute force typing.
 * 
 * @name	autotab_magic
 * @param	focus	Applies focus on the specified element
 * @example	$(':input').autotab_magic();
 */
$.fn.autotab_magic = function(focus) {
	for(var i = 0; i < this.length; i++)
	{
		var n = i + 1;
		var p = i - 1;

		if(i > 0 && n < this.length)
			$(this[i]).autotab({ target: $(this[n]), previous: $(this[p]) });
		else if(i > 0)
			$(this[i]).autotab({ previous: $(this[p]) });
		else
			$(this[i]).autotab({ target: $(this[n]) });

		// Set the focus on the specified element
		if(focus != null && (isNaN(focus) && focus == $(this[i]).attr('id')) || (!isNaN(focus) && focus == i))
			$(this[i]).focus();
	}
	return this;
};

/**
 * This will take any of the text that is typed and
 * format it according to the options specified.
 * 
 * Option values:
 *	format		text|number|alphanumeric|all|custom
 *	- Text			Allows all characters except numbers
 *	- Number		Allows only numbers
 *	- Alphanumeric	Allows only letters and numbers
 *	- All			Allows any and all characters
 *	- Custom		Allows developer to provide their own filter
 *
 *	uppercase	true|false
 *	- Converts a string to UPPERCASE
 * 
 *	lowercase	true|false
 *	- Converts a string to lowecase
 * 
 *	nospace		true|false
 *	- Remove spaces in the user input
 * 
 *	pattern		null|(regular expression)
 *	- Custom regular expression for the filter
 * 
 * @name	autotab_filter
 * @param	options		Can be a string, function or a list of options. If a string or
 *						function is passed, it will be assumed to be a format option.
 * @example	$('#number1, #number2, #number3').autotab_filter('number');
 * @example	$('#product_key').autotab_filter({ format: 'alphanumeric', nospace: true });
 * @example	$('#unique_id').autotab_filter({ format: 'custom', pattern: '[^0-9\.]' });
 */
$.fn.autotab_filter = function(options) {
	var defaults = {
		format: 'all',
		uppercase: false,
		lowercase: false,
		nospace: false,
		pattern: null
	};

	if(typeof options == 'string' || typeof options == 'function')
		defaults.format = options;
	else
		$.extend(defaults, options);

	for(var i = 0; i < this.length; i++)
	{
		$(this[i]).bind('keyup', function(e) {
			var val = this.value;

			switch(defaults.format)
			{
				case 'text':
					var pattern = new RegExp('[0-9]+', 'g');
					val = val.replace(pattern, '');
					break;

				case 'alpha':
					var pattern = new RegExp('[^a-zA-Z]+', 'g');
					val = val.replace(pattern, '');
					break;

				case 'number':
				case 'numeric':
					var pattern = new RegExp('[^0-9]+', 'g');
					val = val.replace(pattern, '');
					break;

				case 'alphanumeric':
					var pattern = new RegExp('[^0-9a-zA-Z]+', 'g');
					val = val.replace(pattern, '');
					break;

				case 'custom':
					var pattern = new RegExp(defaults.pattern, 'g');
					val = val.replace(pattern, '');
					break;

				case 'all':
				default:
					if(typeof defaults.format == 'function')
						var val = defaults.format(val);

					break;
			}

			if(defaults.nospace)
			{
				var pattern = new RegExp('[ ]+', 'g');
				val = val.replace(pattern, '');
			}

			if(defaults.uppercase)
				val = val.toUpperCase();

			if(defaults.lowercase)
				val = val.toLowerCase();

			if(val != this.value)
				this.value = val;
		});
	}
};

/**
 * Provides the autotabbing mechanism for the supplied element and passes
 * any formatting options to autotab_filter.
 * 
 * Refer to autotab_filter's description for a detailed explanation of
 * the options available.
 * 
 * @name	autotab
 * @param	options
 * @example	$('#phone').autotab({ format: 'number' });
 * @example	$('#username').autotab({ format: 'alphanumeric', target: 'password' });
 * @example	$('#password').autotab({ previous: 'username', target: 'confirm' });
 */
$.fn.autotab = function(options) {
	var defaults = {
		format: 'all',
		maxlength: 2147483647,
		uppercase: false,
		lowercase: false,
		nospace: false,
		target: null,
		previous: null,
		pattern: null
	};

	$.extend(defaults, options);

	// Sets targets to element based on the name or ID
	// passed if they are not currently objects
	if(typeof defaults.target == 'string')
		defaults.target = check_element(defaults.target);

	if(typeof defaults.previous == 'string')
		defaults.previous = check_element(defaults.previous);

	var maxlength = $(this).attr('maxlength');

	// defaults.maxlength has not changed and maxlength was specified
	if(defaults.maxlength == 2147483647 && maxlength != 2147483647)
		defaults.maxlength = maxlength;
	// defaults.maxlength overrides maxlength
	else if(defaults.maxlength > 0)
		$(this).attr('maxlength', defaults.maxlength)
	// defaults.maxlength and maxlength have not been specified
	// A target cannot be used since there is no defined maxlength
	else
		defaults.target = null;

	if(defaults.format != 'all')
		$(this).autotab_filter(defaults);

	// Go to the previous element when backspace
	// is pressed in an empty input field
	return $(this).bind('keydown', function(e) {
		if(e.which == 8 && this.value.length == 0 && defaults.previous)
			defaults.previous.focus().val(defaults.previous.val());
	}).bind('keyup', function(e) {
		/**
		 * Do not auto tab when the following keys are pressed
		 * 8:	Backspace
		 * 9:	Tab
		 * 16:	Shift
		 * 17:	Ctrl
		 * 18:	Alt
		 * 19:	Pause Break
		 * 20:	Caps Lock
		 * 27:	Esc
		 * 33:	Page Up
		 * 34:	Page Down
		 * 35:	End
		 * 36:	Home
		 * 37:	Left Arrow
		 * 38:	Up Arrow
		 * 39:	Right Arrow
		 * 40:	Down Arrow
		 * 45:	Insert
		 * 46:	Delete
		 * 144:	Num Lock
		 * 145:	Scroll Lock
		 */
		var keys = [8, 9, 16, 17, 18, 19, 20, 27, 33, 34, 35, 36, 37, 38, 39, 40, 45, 46, 144, 145];

		if(e.which != 8)
		{
			var val = $(this).val();

			if($.inArray(e.which, keys) == -1 && val.length == defaults.maxlength && defaults.target)
				defaults.target.focus();
		}
	});
};

})(jQuery);


/*jQuery tooltip 1.3*/
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}(';(8($){j e={},9,m,B,A=$.2u.2g&&/29\\s(5\\.5|6\\.)/.1M(1H.2t),M=12;$.k={w:12,1h:{Z:25,r:12,1d:19,X:"",G:15,E:15,16:"k"},2s:8(){$.k.w=!$.k.w}};$.N.1v({k:8(a){a=$.1v({},$.k.1h,a);1q(a);g 2.F(8(){$.1j(2,"k",a);2.11=e.3.n("1g");2.13=2.m;$(2).24("m");2.22=""}).21(1e).1U(q).1S(q)},H:A?8(){g 2.F(8(){j b=$(2).n(\'Y\');4(b.1J(/^o\\(["\']?(.*\\.1I)["\']?\\)$/i)){b=1F.$1;$(2).n({\'Y\':\'1D\',\'1B\':"2r:2q.2m.2l(2j=19, 2i=2h, 1p=\'"+b+"\')"}).F(8(){j a=$(2).n(\'1o\');4(a!=\'2f\'&&a!=\'1u\')$(2).n(\'1o\',\'1u\')})}})}:8(){g 2},1l:A?8(){g 2.F(8(){$(2).n({\'1B\':\'\',Y:\'\'})})}:8(){g 2},1x:8(){g 2.F(8(){$(2)[$(2).D()?"l":"q"]()})},o:8(){g 2.1k(\'28\')||2.1k(\'1p\')}});8 1q(a){4(e.3)g;e.3=$(\'<t 16="\'+a.16+\'"><10></10><t 1i="f"></t><t 1i="o"></t></t>\').27(K.f).q();4($.N.L)e.3.L();e.m=$(\'10\',e.3);e.f=$(\'t.f\',e.3);e.o=$(\'t.o\',e.3)}8 7(a){g $.1j(a,"k")}8 1f(a){4(7(2).Z)B=26(l,7(2).Z);p l();M=!!7(2).M;$(K.f).23(\'W\',u);u(a)}8 1e(){4($.k.w||2==9||(!2.13&&!7(2).U))g;9=2;m=2.13;4(7(2).U){e.m.q();j a=7(2).U.1Z(2);4(a.1Y||a.1V){e.f.1c().T(a)}p{e.f.D(a)}e.f.l()}p 4(7(2).18){j b=m.1T(7(2).18);e.m.D(b.1R()).l();e.f.1c();1Q(j i=0,R;(R=b[i]);i++){4(i>0)e.f.T("<1P/>");e.f.T(R)}e.f.1x()}p{e.m.D(m).l();e.f.q()}4(7(2).1d&&$(2).o())e.o.D($(2).o().1O(\'1N://\',\'\')).l();p e.o.q();e.3.P(7(2).X);4(7(2).H)e.3.H();1f.1L(2,1K)}8 l(){B=S;4((!A||!$.N.L)&&7(9).r){4(e.3.I(":17"))e.3.Q().l().O(7(9).r,9.11);p e.3.I(\':1a\')?e.3.O(7(9).r,9.11):e.3.1G(7(9).r)}p{e.3.l()}u()}8 u(c){4($.k.w)g;4(c&&c.1W.1X=="1E"){g}4(!M&&e.3.I(":1a")){$(K.f).1b(\'W\',u)}4(9==S){$(K.f).1b(\'W\',u);g}e.3.V("z-14").V("z-1A");j b=e.3[0].1z;j a=e.3[0].1y;4(c){b=c.2o+7(9).E;a=c.2n+7(9).G;j d=\'1w\';4(7(9).2k){d=$(C).1r()-b;b=\'1w\'}e.3.n({E:b,14:d,G:a})}j v=z(),h=e.3[0];4(v.x+v.1s<h.1z+h.1n){b-=h.1n+20+7(9).E;e.3.n({E:b+\'1C\'}).P("z-14")}4(v.y+v.1t<h.1y+h.1m){a-=h.1m+20+7(9).G;e.3.n({G:a+\'1C\'}).P("z-1A")}}8 z(){g{x:$(C).2e(),y:$(C).2d(),1s:$(C).1r(),1t:$(C).2p()}}8 q(a){4($.k.w)g;4(B)2c(B);9=S;j b=7(2);8 J(){e.3.V(b.X).q().n("1g","")}4((!A||!$.N.L)&&b.r){4(e.3.I(\':17\'))e.3.Q().O(b.r,0,J);p e.3.Q().2b(b.r,J)}p J();4(7(2).H)e.3.1l()}})(2a);',62,155,'||this|parent|if|||settings|function|current||||||body|return|||var|tooltip|show|title|css|url|else|hide|fade||div|update||blocked|||viewport|IE|tID|window|html|left|each|top|fixPNG|is|complete|document|bgiframe|track|fn|fadeTo|addClass|stop|part|null|append|bodyHandler|removeClass|mousemove|extraClass|backgroundImage|delay|h3|tOpacity|false|tooltipText|right||id|animated|showBody|true|visible|unbind|empty|showURL|save|handle|opacity|defaults|class|data|attr|unfixPNG|offsetHeight|offsetWidth|position|src|createHelper|width|cx|cy|relative|extend|auto|hideWhenEmpty|offsetTop|offsetLeft|bottom|filter|px|none|OPTION|RegExp|fadeIn|navigator|png|match|arguments|apply|test|http|replace|br|for|shift|click|split|mouseout|jquery|target|tagName|nodeType|call||mouseover|alt|bind|removeAttr|200|setTimeout|appendTo|href|MSIE|jQuery|fadeOut|clearTimeout|scrollTop|scrollLeft|absolute|msie|crop|sizingMethod|enabled|positionLeft|AlphaImageLoader|Microsoft|pageY|pageX|height|DXImageTransform|progid|block|userAgent|browser'.split('|'),0,{}))

jQuery.validator.addMethod("platehu", function(value, element) {
	return this.optional(element) || /^[A-Za-z]/i.test(value);
}, "Érvénytelen rendszám formátum");


$(function() {
		
		
	$('#cardNum1,#cardNum2,#cardNum3,#cardNum4,#cardNum5,#cardNum6,#cardNum7,#cardNum8,#cardNum9,#cardNum10,').autotab_magic();	
		
	$(".info").tooltip({
		   showURL: false,
			delay : false
	});	
	
	//Céges irányítószám
	$("#coZip").keyup(function(){
		if($(this).val().length === 4 && $("#coZip").valid()){
			$.post("lib/php/ir.php",{
				"num" : $(this).val()
			},function(resp){
				if(resp == ''){
					$("#coZipError").show();
				}else{
					$("#coZipError").hide();
					$("#coCity").val(resp);
				}
			});
		}
		else{
			$("#coZipError").hide();
			$("#coCity").val("");
		}
	});
	
	//Magán irányítószám
	$("#natZip").keyup(function(){
		if($(this).val().length === 4 && $("#natZip").valid()){
			$.post("lib/php/ir.php",{
				"num" : $(this).val()
			},function(resp){
				if(resp == ''){
					$("#natZipError").show();
				}else{
					$("#natZipError").hide();
					$("#natCity").val(resp);
				}
			});
		}
		else{
			$("#natZipError").hide();
			$("#natCity").val("");
		}
	});
	
	//Kártyaszám
	
	$("#cardNum, #oldEmail").keyup(function(){
			if($("#cardNum").val().length === 11 && $("#oldEmail").valid()){
				$.post("lib/php/reg.php",{
					"tagsagi_szam" : $("#cardNum").val(),
					"e_mail" : $("#oldEmail").val()
				},function(resp){
					if(resp != null && resp != 'null'){
						var response = $.parseJSON(resp);
						
						//Cégadatok
						$("#coName").val(response.cegnev);
						$("#coDate").val(response.alapitas_eve);
						$("#coCoFName").val(response.kapcsolattarto_vezeteknev);
						$("#coCoLName").val(response.kapcsolattarto_keresztnev);
						
						//Magánszemény adatok
						$("#natFName").val(response.vezeteknev);
						$("#natLName").val(response.keresztnev);
						$("#natDate").val(response.szuletesi_datum);
						
						$("#phone").val(response.mobil_telefon);
						if(response.mobil_telefon == ''){
							$("#phone").val(response.vezetekes_telefon);
						}
						
						$("#email").val($("#oldEmail").val());
						
						if(response.nem == "C"){
							$("#coZip").val(response.allando_irsz);
							$("#coCity").val(response.allando_helyseg);
							$("#coAddress").val(response.allando_kozterulet + " " + response.allando_hazszam);							
							$("#co").attr("checked", true); 
							$('#co').click();
						}else{
							
							$("#natGender").val(response.nem);
							$("#natZip").val(response.allando_irsz);
							$("#natCity").val(response.allando_helyseg);
							$("#natAddress").val(response.allando_kozterulet + " " + response.allando_hazszam);
							$("#nat").attr("checked", true);
							$('#nat').click();
						}
						
					}
				});
			}
		});	
	$("#coDate").datepicker({
		changeMonth : true,
		changeYear : true,
		maxDate : -1,
		constrainInput : true,
		dateFormat : 'yy-mm-dd',
		yearRange:"-100:+0"  
	});
	
	$("#natDate").datepicker({
		changeMonth : true,
		changeYear : true,
		maxDate : '0d',
		constrainInput : true,
		dateFormat : 'yy-mm-dd',
		yearRange:"-100:+0"
	});
			
	/*regisztrációs lépések adatai*/
	
	var registerFormData,
		memberFormData,
		standardFormData,
		komfortFormData,
		paymentFormData = null;
		
	$("#registerform").validate({
	
		submitHandler: function(form) {
		
			registerFormData = $("#registerform").serialize();
			
			var memberRadio = $("input[name='group1']:checked").attr("id");
			var registerRadio = $("input[name='group2']:checked").attr("id");	
			
			registerFormData += "&memberRadio="+memberRadio+"&registerRadio="+registerRadio;
			
			$.post("lib/php/register.php",{
				"formData" : registerFormData,
				"memberData" : memberFormData
			},function(resp){
				if(resp == "sikeres"){
					$("#memberform h2").prepend("<p>Sikeres regisztráció a weboldalra!</p>");
					$("#registerform").hide();
					$("#memberform").show();
					$('html,body').animate({scrollTop: $("#memberform").offset().top},'slow');
					$("aside h3").eq(1).addClass("active").siblings().removeClass("active");
				}
				else{
					$(".resp").html("<label class='error'>Hiba.</label>");					
					return false;
				}
			});
			
			return false;
		},
		rules: {
			"passRe" : {
				equalTo : "#pass"
			},
			"cardNum" : {
				required : "#old:checked"
			},
			"oldEmail" : {
				required : "#old:checked"
			},
			/* Cég */
			"coName" : {
				required : "#co:checked"	
			},
			"coZip" : {
				required : "#co:checked"	
			},
			"coCity" : {
				required : "#co:checked"	
			},
			"coAddress" : {
				required : "#co:checked"	
			},
			/*Természetes személy*/
			"natFName" : {
				required : "#nat:checked"	
			},
			"natLName" : {
				required : "#nat:checked"	
			},
			"natDate" : {
				required : "#nat:checked"	
			},
			"natMother" : {
				required : "#nat:checked"	
			},
			"natZip" : {
				required : "#nat:checked"	
			},
			"natCity" : {
				required : "#nat:checked"	
			},
			"natAddress" : {
				required : "#nat:checked"	
			},
			"group3" : {
				required : true
			},
			"group2" : {
				required : true
			},
			"group1" : {
				required : true
			},
			"email" : {
				required: true,
			    email: true,
			    remote: "lib/php/checkemail.php"
			}
		},
		errorPlacement: function(error, element) {
		     error.appendTo(element.parents(".row"));
		},
		messages: {
		    "group3" : {
		    	required : "Kérem válasszon tagsági típust"
		    },
		    "group2" : {
		    	required : "Kérem válasszon"
		    },
		    "group1" : {
		    	required : "Kérem válasszon"
		    },
		    "terms" : {
		    	required : "Elfogadása kötelező a regisztrációhoz"
		    },
			"email" : {
				remote : "Ezzel az email címmel már regisztráltak"
			}
		  }
	});
	
	
	$("#memberform input[type='radio']").click(function(){
		$(".sum").html(addSpaces($(this).data("price")) + " Ft / év");		
		$("#osszeg").val($(this).data("price"))
	});
	
	$("#memberform").validate({
		submitHandler: function(form) {
		
			memberFormData = $("#memberform").serialize();
			
			membershipRadio = $("input[name='membership']:checked").attr("id");
			
			memberFormData += "&membershipRadio=" + membershipRadio;
			
			if($("#standardMember").is(":checked")){
				if($("#co").is(":checked")){
					$("#memberform").hide();
					$("#standardform").show();
					$("aside h3").eq(2).addClass("active").siblings().removeClass("active");
					$('html,body').animate({scrollTop: $("#standardform").offset().top},'slow');
				}
				else{
					/*fizetés*/
					
					$("#memberform").hide();
					$("#paymentform").show();
					$("aside h3").eq(3).addClass("active").siblings().removeClass("active");
					$('html,body').animate({scrollTop: $("#paymentform").offset().top},'slow');
				}
			}	

			if($("#diszkontMember").is(":checked")){
				$("#memberform").hide();
				$("#paymentform").show();	
				$("aside h3").eq(3).addClass("active").siblings().removeClass("active");
				$('html,body').animate({scrollTop: $("#paymentform").offset().top},'slow');
			}
			
			if($("#komfortMember").is(":checked")){
				$("#memberform").hide();
				$("#komfortform").show();	
				$("aside h3").eq(2).addClass("active").siblings().removeClass("active");					
				$('html,body').animate({scrollTop: $("#komfortform").offset().top},'slow');
			}
			return false;
		},
		rules : {
			"membership" : {
				required : true
			}
		},
		messages : {
			"membership" : "Kérem válasszon tagsági szintet"
		},
		errorPlacement: function(error, element) {
		     error.appendTo(element.parents(".row"));
		}
	});
	
	
	$("#standardform").validate({
		submitHandler: function(form) {
			standardFormData = $("#standardform").serialize();
			
			var plateTypeRadio = $("input[name='platetype']:checked").attr("id");
			
			standardFormData += "&plateTypeRadio=" + plateTypeRadio;
			
			$("#standardform").hide();	
			$("#paymentform").show();
			$("aside h3").eq(3).addClass("active").siblings().removeClass("active");
			$('html,body').animate({scrollTop: $("#paymentform").offset().top},'slow');
			return false;
		},
		rules : {
			"platetype" : {
				required : true
			},
			"standardPlateHuInput" : {
				required : "#standardPlateHu:checked",
				platehu : true,
				minlength: 6,
				maxlength: 6
			},
			"standardPlateFoInput" : {
				required : "#standardPlateFo:checked",
				maxlength: 10
			}
		},
		messages : {
			"platetype" : {
				required : "Kérem válasszon"
			}
		},
		errorPlacement: function(error, element) {
		     error.appendTo(element.parents(".row"));
		}
	});
	
	$("#komfortform").validate({
		submitHandler: function(form) {
			komfortFormData = $("#komfortform").serialize();
			$("#komfortform").hide();	
			$("#paymentform").show();
			$("aside h3").eq(3).addClass("active").siblings().removeClass("active");
			$('html,body').animate({scrollTop: $("#paymentform").offset().top},'slow');
			return false;
		},
		errorPlacement: function(error, element) {
		     error.appendTo(element.parents(".row"));
		},
		rules : {
			"komfortPlateHuInput" : {
				platehu : true
			},
			"carAge" : {
				min : 1,
				max : 11
			}
		}
	});
	
	$("#paymentform").validate({
		submitHandler: function(form) {
			paymentFormData = $("#paymentform").serialize();
			
			var paymentmethodRadio = $("input[name='paymentmethod']:checked").attr("id");
			
			paymentFormData += "&paymentmethodRadio=" + paymentmethodRadio;
			
			/*
			 * Fizetés postolás
			 */
			
			$.post("lib/php/register.php",{
				"email" : $("#email").val(),
				"memberData" : memberFormData,
				"paymentData" : paymentFormData,
				"komfortData" : komfortFormData,
				"standardData" : standardFormData
			},function(resp){
				
				var msg = "";
				$("#message").html("").show();
				
				if($("#card").attr("checked") == 'checked' && resp == 'sikeres'){
					msg = 'Feldolgoztuk a kérést!';
					form.submit();
				}
				else{
					msg = 'Nem sikerült feldolgozni a kérést!';
				}
				
				$("#message").html(msg).delay(5000).fadeOut(600);
				
			});
			
			return false;
		},
		rules : {
			"paymentmethod" : {
				required : true
			}
		},
		messages : {
			"paymentmethod" : "Kérem válasszon fizetési módot"
		},
		errorPlacement: function(error, element) {
		     error.appendTo(element.parents(".row"));
		}
	});
	
	
	$("#paymentform input[type='radio']").click(function(){
		var id = $(this).attr("id");
		$("#"+id+"Details").show().siblings(".detail").hide();
	});
	
	
	$("#standardPlateHu,#standardPlateFo").click(function(){
		if($("#standardPlateHu").is(":checked")){
			$("#standardPlateHuInputRow").show();
			$("#standardPlateFoInputRow").hide();
		}
		if($("#standardPlateFo").is(":checked")){
			$("#standardPlateHuInputRow").hide();
			$("#standardPlateFoInputRow").show();
		}
	});
	
	
/*	$("#toStep2").click(function(){
		if ($("#registerform").valid()) {
			$(".step1").slideUp(300,function(){
				$(".step2").show();
				
			});
		}	
		return false;
	});*/
	
	
	
	$("#oldMember,#coSet,#natSet").hide();
	$("#membership input[type='radio']").click(function(){
		var $v = $("#membership").find("input[type='radio']:checked");
		if($v.attr("id") === "old"){
			$("#oldMember").show();
		}
		else{
			$("#oldMember").hide();
		}
	});
	
	$("#sex input[type='radio']").click(function(){
		var $v = $("#sex").find("input[type='radio']:checked");
		if($v.attr("id") === "co"){
			$("#coSet").show();
			$("#natSet").hide();
		}
		else{
			$("#coSet").hide();
			$("#natSet").show();
		}
	});
	
	 function addSpaces(nStr){
		  nStr += '';
		  x = nStr.split('.');
		  x1 = x[0];
		  x2 = x.length > 1 ? '.' + x[1] : '';
		  var rgx = /(\d+)(\d{3})/;
		  while (rgx.test(x1)) {
		    x1 = x1.replace(rgx, '$1' + '    ' + '$2');
		  }
		  return x1 + x2;
		 }
	
	
});