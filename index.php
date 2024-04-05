<?php 
include_once("check_login_status.php");
if($user_ok == true){
	header("location: sync&".$_SESSION["user_hash"]);
    exit();
}
?><?php
if(isset($_POST["email"])){
	$email = $_POST['email'];
	$p = md5($_POST['p']);
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));

	if($email == "" || $p == ""){
		echo "login_failed";
        exit();
	} else {
		$sql = "SELECT id, e_hash, password FROM user_account WHERE BINARY email = BINARY '$email' LIMIT 1";
        $query = mysqli_query($db_connection, $sql);
        $row = mysqli_fetch_row($query);
		$db_id = $row[0];
		$db_ehash = $row[1];
        $db_pass_str = $row[2];
		if($p != $db_pass_str){
			echo "login_failed";
            exit();
		} else {
			$_SESSION['userid'] = $db_id;
			$_SESSION['user_hash'] = $db_ehash;
			$_SESSION['password'] = $db_pass_str;
			setcookie("id", $db_id, strtotime( '+30 days' ), "/", "", "", TRUE);
			setcookie("e_hash", $db_ehash, strtotime( '+30 days' ), "/", "", "", TRUE);
    		setcookie("pass", $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE);

			$sql = "UPDATE user_account SET ip='$ip', last_login_date=now() WHERE e_hash='$db_ehash' LIMIT 1";
            $query = mysqli_query($db_connection, $sql);
			echo $db_ehash;
		    exit();
		}
	}
	exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<title>Cadastro de Currículo de Cuidador de Idosos</title>
<?php include_once("default_head.php");?>
<link href="css/p.index.css" rel="stylesheet">
<link href="css/_owlphin.css" rel="stylesheet">
</head>
<body class="index-body">
<?php //include_once("ext/pageloader.php");?>
<?php //include_once("ext/pageloader-starter.php");?>
<div class="navbar navbar-fixed-top" style="position: fixed;">
  <div class="navbar-inner">
    <div class="container"> 
	  <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	    <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
	  </a>
	  <a class="brand" href="javascript:void(0)" onclick="owlphinhome()">
	    <img src="imagem/owlphin_log.png" style="height:30px;" />
		<span></span>
      </a>
      <div class="nav-collapse index">
		<form class="navbar-search strict-mobile-no-show"  role="form" method="post" onSubmit="return false;">
          <input type="text" class="search-query" placeholder="Email" id="email" name="email" onkeyup="restrict('email')" /> 
		  <input type="password" class="search-query" placeholder="Senha" id="password" name="password" onkeyup="restrict('password')"/>
		   <span id="signinbtn"><button id="loginbtn" class="btn btn-primary" onclick="signin()" disabled>Entrar</button></span>&nbsp;&nbsp;
		   <button id="registerbtn" class="btn btn-inverse" onclick="register()">Novo Usuário? Cadastre-se</button>&nbsp;&nbsp;
		   <button id="registerbtn" class="btn btn-primary" onclick="help()"><span class="fa fa-info"></span> Leia Mais</button>
        </form>
      </div>
    </div>
  </div> 
</div>

<div class="banner">
  <div class="container">
	<div class="row">
	  <div class="span10 banner-span">
		<div class="banner-text">
		  <p class="banner-text-md ">Bem vindo ao Cadastro de Cuidadores de Idosos</p>
		  <p class="banner-text-lg" style="font-size: 3.4em;line-height: 40px;text-shadow:#000 -1px -1px;">Este é um portal de recrutamento de empregos que agiliza o atual processo de recrutamento de funcionários usando Inteligência Artificial.</p>
		  <p class="banner-text-md">
			<a href="javascript:void(0)" onclick="help()" style="color: #d2d2d2;">Clique aqui e ache os melhores cuidadores</a> ou 
			<a href="javascript:void(0)" onclick="register()" style="color: #d2d2d2;">Cadastre-se</a>
		  </p>
		</div>
	  </div>
    </div>
  </div>
</div>
<div class="second-section">
  <div class="container">
	<div class="row">
	  <div class="span3 second-section-span">
	    <div class="second-section-text">
		   	<p><span class="fa fa-search fa-4x" style="color: gray;"></span></p>
			<p><b>Lista de trabalhos</b></p>
			<p>Vamos oferecer uma maneira mais rápida de encontrar a carreira que você deseja. Obtenha controle total de seus interesses.</p>
		 </div>
	  </div>
	  <div class="span3 second-section-span">
	     <div class="second-section-text">
		   	<p><span class="fa fa-binoculars fa-4x" style="color: gray;"></span></p>
			<p><b>Ache Cuidadores</b></p>
			<p>Usamos IA para vasculhar nosso conjunto de candidatos existentes em buscaremos os melhores candidatos.</p>
		 </div>
	  </div>
	  <div class="span3 second-section-span">
	     <div class="second-section-text">
		   	<p><span class="fa fa-file-text fa-4x" style="color: gray;"></span></p>
			<p><b>Triagem de Cuidadores</b></p>
			<p>Selecionamos candidatos automaticamente, em tempo real, com incrível precisão. Coloque a triagem no controle de cruzeiro.</p>
		 </div>
	  </div>
	  <div class="span3 second-section-span">
	    <div class="second-section-text">
		   	<p><span class="fa fa-comment fa-4x" style="color: gray;"></span></p>
			<p><b>Chatbot do Recrutador</b></p>
			<p>Interaja com os candidatos em grande escala, 24 horas por dia, 7 dias por semana! Aumente drasticamente as taxas de resposta e elimine as chamadas de triagem iniciais.</p>
		 </div>
	  </div>
	</div>
  </div>
</div>
<div class="third-section">
  <div class="container">
	<div class="row">
	  <div class="span6 third-section-span-1">
		<div class="third-section-text" style="text-align:left;">
		  <p class="third-section-text-md">A melhor maneira de encontrar um profissional</p><br/>
		  <a href="javascript:void()" style="color: #fff;font-size: 1.4em;" onclick="login()">Entrar &nbsp;<span class="fa fa-arrow-left"></span></a>
		 </div>
	  </div>
	  <div class="span6 third-section-span-2">
	    <div class="third-section-text" style="text-align:right;">
		  <p class="third-section-text-md">Preciso de um emprego? <br/> Conte-nos sua história</p><br/>
		  <a href="javascript:void()" style="color: #fff;font-size: 1.4em;" onclick="register()"><span class="fa fa-arrow-right"></span>&nbsp; Sign up</a>
		</div>
	  </div>
	</div>
  </div>
</div>
<div class="footer"><?php include_once("ext/footer.php");?></div>
<?php include_once("ext/default_js.php");?>
<script type="text/javascript">
function restrict(elem){
	var tf = _(elem);
	var e = _("email").value;
	var pass = _("password").value;
	var rx = new RegExp;
	if(elem == "email"){
		rx = /[' "]/gi;
	}
	if(e != "" && pass != ""){
		_("loginbtn").disabled = false;
	}else{
		_("loginbtn").disabled = true;
	}
	tf.value = tf.value.replace(rx, "");
}
function signin(){
	var email = _("email").value;
	var p = _("password").value;
	if(email != "" || p != ""){
		_("signinbtn").innerHTML = '<button id="loginbtn" class="btn btn-primary" disabled><i class="fa fa-spinner"></i></button>';
		var ajax = ajaxObj("POST", "index.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText == "login_failed"){
					login();
				} else {
					_("loginbtn").disabled = true;
					_("registerbtn").disabled = true;
					_("email").disabled = true;
					 _("password").disabled = true;
					window.location = "sync&"+ajax.responseText;
				}
	        }
        }
        ajax.send("email="+email+"&p="+encodeURIComponent(p));
	}else {
		login();
	}
}
</script>
</body>
</html>