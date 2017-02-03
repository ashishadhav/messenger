<html>
<head>
	<title>Messenger</title>
	<style type="text/css">
	html {
		height: 100%;
	}
	body {
		margin: 0px;
		padding: 0px;
		height: 100%;
		font-family: Helvetica, Arial, Sans-serif;
		font-size: 14px;
	}
	.msg-container {
		width: 100%;
		height: 100%;
	}
	.header {
		width: 100%;
		height: 30px;
		border-bottom: 1px solid #CCC;
		text-align: center;
		padding: 15px 0px 5px;
		font-size: 20px;
		font-weight: normal;
	}
	.msg-area {
		height: calc(100% - 102px);
		width: 100%;
		background-color:#FFF;
		overflow-y: scroll;
	}
	.msginput {
		padding: 5px;
		margin: 10px;
		font-size: 14px;
		width: calc(100% - 20px);
		outline: none;
	}
	.bottom {
		width: 100%;
		height: 50px;
		position: fixed;
		bottom: 0px;
		border-top: 1px solid #CCC;
		background-color: #EBEBEB;
	}
	#whitebg {
		width: 100%;
		height: 100%;
		background-color: #FFF;
		overflow-y: scroll;
		opacity: 0.6;
		display: none;
		position: absolute;
		top: 0px;
		z-index: 1000;
	}
	#loginbox {
		width: 600px;
		height: 350px;
		border: 1px solid #CCC;
		background-color: #FFF;
		position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
		z-index: 1001;
		display: none;
	}
	h1 {
		padding: 0px;
		margin: 20px 0px 0px 0px;
		text-align: center;
		font-weight: normal;
	}
	button {
		background-color: #43ACEC;
		border: none;
		color: #FFF;
		font-size: 16px;
		margin: 0px auto;
		width: 150px;
	}
	.buttonp {
		width: 150px;
		margin: 0px auto;
	}
	.msg {
		margin: 10px 10px;
		background-color: #f1f0f0;
		max-width: calc(45% - 20px);
		color: #000;
		padding: 10px;
		font-size: 14px;
	}
	.msgfrom {
		background-color: #0084ff;
		color: #FFF;
		margin: 10px 10px 10px 55%;
	}
	.msgarr {
		width: 0;
		height: 0;
		border-left: 8px solid transparent;
		border-right: 8px solid transparent;
		border-bottom: 8px solid #f1f0f0;
		transform: rotate(315deg);
		margin: -12px 0px 0px 45px;
	}
	.msgarrfrom {
		border-bottom: 8px solid #0084ff;
		float: right;
		margin-right: 45px;
	}
	.msgsentby {
		color: #8C8C8C;
		font-size: 12px;
		margin: 4px 0px 0px 10px;
	}
	.msgsentbyfrom {
		float: right;
		margin-right: 12px;
	}
	</style>
</head>
<body onload="checkcookie(); update();">
<div id="whitebg"></div>
<div id="loginbox">
<h1>Pick a username:</h1>
<p><input type="text" name="pickusername" id="cusername" placeholder="Pick a username" class="msginput"></p>
<p class="buttonp"><button onclick="chooseusername()">Choose Username</button></p>
</div>
<div class="msg-container">
	<div class="header">Messenger</div>
	<div class="msg-area" id="msg-area"></div>
	<div class="bottom"><input type="text" name="msginput" class="msginput" id="msginput" onkeydown="if (event.keyCode == 13) sendmsg()" value="" placeholder="Enter your message here ... (Press enter to send message)"></div>
</div>
<script type="text/javascript">
var msginput = document.getElementById("msginput");
var msgarea = document.getElementById("msg-area");

//sets cookie to prevent opening the login name
function chooseusername() {
	var user = document.getElementById("cusername").value;
	document.cookie="mUname=" + user
	checkcookie()
}


//displays the login page 
function showlogin() {
	document.getElementById("whitebg").style.display = "inline-block";
	document.getElementById("loginbox").style.display = "inline-block";
}

//hides the login page
function hideLogin() {
	document.getElementById("whitebg").style.display = "none";
	document.getElementById("loginbox").style.display = "none";
}

//check if cookie set 
//-1 means cookie not set
//if set hidelogin
function checkcookie() {
	if (document.cookie.indexOf("mUname") == -1) {
		showlogin();
	} else {
		hideLogin();
	}
}

function getcookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}
function escapehtml(text) {
  return text
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
}
function update() {
	var xmlhttp=new XMLHttpRequest();
	var username = getcookie("mUname");
	var output = "";
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				//get individual message , separated by new line
				var response = xmlhttp.responseText.split("\n")
				var rl = response.length
				var item = "";
				for (var i = 0; i < rl; i++) {
					item = response[i].split("\\")
						if (item[1] != undefined) {
						// blue messages	
						if (item[0] == username) {
							output += "<div class=\"msgc\" style=\"margin-bottom: 30px;\"> <div class=\"msg msgfrom\">" + item[1] + "</div> <div class=\"msgarr msgarrfrom\"></div> <div class=\"msgsentby msgsentbyfrom\">Sent by " + item[0] + "</div> </div>";
						} else {
							//grey messages
							output += "<div class=\"msgc\"> <div class=\"msg\">" + item[1] + "</div> <div class=\"msgarr\"></div> <div class=\"msgsentby\">Sent by " + item[0] + "</div> </div>";
						}
					}
				}

				//set the output to the area
				msgarea.innerHTML = output;
				//if scrolling push scrollbar at the bottom
				msgarea.scrollTop = msgarea.scrollHeight;
			}
		}
		//call get-messages to populate messages from database
	      xmlhttp.open("GET","get-messages.php?username=" + username,true);
	      xmlhttp.send();
}

// sends an ajax request to our server
function sendmsg() {
	var message = msginput.value;
	if (message != "") {
		// alert(msgarea.innerHTML)
		// alert(getcookie("messengerUname"))
		var username = getcookie("mUname");
		var xmlhttp=new XMLHttpRequest();
		//anonymous function
		xmlhttp.onreadystatechange=function() {
			//run this only after u send the request and get a reply
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				message = escapehtml(message)
					//this is for formatting
					msgarea.innerHTML += "<div class=\"msgc\" style=\"margin-bottom: 30px;\"> <div class=\"msg msgfrom\">" + message + "</div> <div class=\"msgarr msgarrfrom\"></div> <div class=\"msgsentby msgsentbyfrom\">Sent by " + username + "</div> </div>";
				msginput.value = "";
			}
		}

		//actually call our server to set messages in our DB
	      	xmlhttp.open("GET","update-messages.php?username=" + username + "&message=" + message,true);
		//send our request
		xmlhttp.send();
  	}
}

//auto update the chat window
setInterval(function(){ update() }, 2500);
</script>
</body>
</html>
