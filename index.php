
<?php
//conexao
require_once 'db_connect.php';

//iniciar sessao
session_start();

//verifica se botao "entrar" foi pressionado
//em seguida pega os valores de login e senha digitados pelo user
if(isset($_POST['btn-entrar'])):
	$erros = array();
	$login = mysqli_escape_string($connect, $_POST['login']);
	$senha = mysqli_escape_string($connect, $_POST['senha']);

	if(empty($login) or empty($senha)):
		$erros[] = "<li>O campo login/senha precisa ser preenchido</li>";
	else:
	//verifica se o login digitado existe na base de dados
	$sql = "SELECT login FROM usuarios WHERE login = '$login'";
	$resultado = mysqli_query($connect, $sql);

		if(mysqli_num_rows($resultado) > 0):
		//caso tenha o login cadastrado, vai verificar se a senha confere com o db
			//antes de inserir a senha, precisa criptografar
			$senha = md5($senha);
		$sql = "SELECT * FROM usuarios WHERE login = '$login' AND senha = '$senha'";
		$resultado = mysqli_query($connect, $sql);


			if(mysqli_num_rows($resultado) == 1):
			$dados = mysqli_fetch_array($resultado);
			mysqli_close($connect);
			$_SESSION['logado'] = true;
			$_SESSION['id_usuario'] = $dados['id'];
			header('Location: home.php');
			else:
				$erros[] = "<li>Usuário e senha não conferem</li>";
			endif;
		else:
			$erros[] = "<li>Usuário não cadastrado</li>";
		endif;
	endif;

endif;
?>

<html>
<head>
	<title>Login</title>
	<meta charset="utf-8">
</head>
<body>

	<h1>Login</h1>
<?php 
if(!empty($erros)):
	foreach ($erros as $erro) {
		echo $erro;
	}
endif;
?>
<hr>
<!-- qd nao coloca nada no action do formulario, ele processa a msm pagina.
para processar uma pagina, precisa especificar como feito abaixo -->
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		Login: <input type="text" name="login"><br>
		Senha: <input type="password" name="senha"><br>
		<button type="submit" name="btn-entrar">Entrar</button>

	</form>
</body>
</html>