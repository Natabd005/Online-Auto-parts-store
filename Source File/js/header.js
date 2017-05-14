$("document").ready(function(){
			$("#logout").hide();
			$("#logout").click = logout;
			checkLogin();
		});
		
function checkLogin(){
	
	$.ajax({
		method:"POST",
		url:"loginCheck.php",
		success:function(data){

			var res =eval(data);
			
			if(res){
				$("#signin").hide();
				$("#logout").show();
			}else{
				
			}
		}
	});
}

function logout(){
	createCookie("email","",-1);
	createCookie("passwd","",-1);
	$("#signin").show();
	$("#logout").hide();
	window.location.href="/index.php";
}