<!DOCTYPE html>
<?php 
//conexao com banco de dados
require_once 'db_connect.php';

//iniciar sessao
session_start();

//verificação (pra impedir acesso atraves do url, por exemplo)
if(!isset($_SESSION['logado'])):
	header('Location: index.php');
endif;


//dados
//dica: sempre que fizer consulta no DB, fecha a conexao após a consulta
$id = $_SESSION['id_usuario'];
$sql = "SELECT * FROM usuarios WHERE id = '$id'";
$resultado = mysqli_query($connect, $sql);
$dados = mysqli_fetch_array($resultado);
//fechando conexao após consulta
mysqli_close($connect);
?>


<html>
<head>
	<title>Página restrita</title>
	<meta charset="utf-8">
</head>
<body>
<h1>Olá <?php echo $dados['nome']; ?></h1>
<a href="logout.php">Sair</a>
</body>
</html>