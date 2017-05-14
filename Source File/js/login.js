var okMsg = {};
		var errMsg = {};
		var funMap = {};
		
		$("document").ready(function(){
			buildMsgMap();
			buildFunMap();
			bind();
			ajaxEmail();
			
		});
		
		function buildFunMap(){
			var email = $("#email").attr("id");
			var passwd = $("#passwd").attr("id");
			var rettyPasswd = $("#rettyPasswd").attr("id");
			var fname = $("#firstname").attr("id");
			var lname = $("#lastname").attr("id");

			funMap[email] = validateEmail;
			funMap[passwd] = validatePassword;
			funMap[rettyPasswd] = validateRettyPasswd;
			funMap[fname] = valudateFirstName;
			funMap[lname] = valudateLastName;
		}
		
		function buildMsgMap(){
			var email = $("#email").attr("id");
			var passwd = $("#passwd").attr("id");
			var rettyPasswd = $("#rettyPasswd").attr("id");
			var fname = $("#firstname").attr("id");
			var lname = $("#lastname").attr("id");
			
			okMsg[email] = "ok";
			okMsg[passwd] = "ok";
			okMsg[rettyPasswd] = "ok";
			okMsg[fname] = "ok";
			okMsg[lname] = "ok";
			
			errMsg[email] = "email should contain @";
			errMsg[passwd] = "the password should be at least length 8";
			errMsg[rettyPasswd] = "does not match";
			errMsg[firstname] = "can't be empty";
			errMsg[lastname] = "can't be empty";
			
		}
		
		function bind(){
			$("#email").blur(ajaxEmail);
			$(".valid").blur(onblur);
		}
		
		var ajaxCheck = false;
		
		
		function onblur(){
			var key = $(this).attr("id");
			var fun = funMap[key];
			var val = $(this).val();
			var msg = "";
			if(val.length>0){
				if(fun(val)){
					msg = okMsg[key];
					$(this).removeClass("error").removeClass("ok").removeClass("info").addClass("ok");
				}else{
					msg = errMsg[key];
					$(this).removeClass("error").removeClass("ok").removeClass("info").addClass("error");
				}
			}else{
				$(this).removeClass("error").removeClass("ok").removeClass("info").addClass("info");
			}
			
			$(this).next().text(msg);
			return false;
		}
		
		function ajaxEmail(){
			var e = $("#email").val();
			if(e==""||!validateEmail(e)){
				ajaxCheck = false;
			}else{
				$.ajax({
					method:"GET",
					data:{email:e},
					url:"emailValidate.php",
					dataType:"json",
					type:"GET",
					success:function(data){
						var res = eval(data);
						var suc = res["suc"];
						if(suc == true){
							ajaxCheck = true;
						}else{
							ajaxCheck = false;
							$("#email").removeClass("info").removeClass("error").removeClass("ok").addClass("error").next().text("The email has been used");
						}
					}
				});
			}
		}
			
		function onSubmit(){
		
			if(checkBeforeSubmit()&&ajaxCheck){
				$("#reg").submit();
			}else{
				alert("Error: Illegal Input!");
			}
			
		}
		
		
		
		function validateEmail(email){
			if(email.indexOf("@")>0){
				return true;
			}
		
			return false;
		}
	
		function checkBeforeSubmit(){
			var email =  $("#email").val();
			var passwd = $("#passwd").val();
			var rettyPasswd = $("#rettyPasswd").val();
			var firstName = $("#firstname").val();
			var lastName = $("#lastname").val();
			if(!validateEmail(email)){
				return false;
			}
			if(!validatePassword(passwd)){
				return false;
			}
			if(!validateRettyPasswd(rettyPasswd)){
				return false;
			}
			if(!valudateFirstName(firstName)){
				return false;
			}
			if(!valudateLastName(lastName)){
				return false;
			}
			return true;
		}

		function validatePassword(password){
			if(password.length>=8){
				return true;
			}
			return false;
		}
		
		function validateRettyPasswd(rettyPasswd){
			var passwd =  $("#passwd").val();
			if(rettyPasswd==passwd){
				return true;
			}
			return false;
		}
		
		function valudateFirstName(firstName){
			if(firstName==null||firstName==""){
				return false;
			}
			return true;
		}
		
		function valudateLastName(lastName){
		
			if(lastName==null||lastName==""){
				return false;
			}
			return true;
		}
		