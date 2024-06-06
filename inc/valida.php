<?php
	// Esse é o validade.php
	include ("../config.php");
	include(DBAPI);
	include(HEADER_TEMPLATE);
	/*
	var_dump($_POST['login']);
	echo "<br><br>\n";
	var_dump($_POST['senha']);
	exit;
	*/
	if (!empty($_POST) AND (empty($_POST['login']) || empty($_POST['senha']))){
		//header("Location:" . BASEURL . "index.php");
	}
	try {
		$database = open_database();
	
		$usuario = $_POST['login'];
		$senha = $_POST['senha'];

		if (!empty($usuario) && !empty($senha)) {
			$senha = criptografia($_POST['senha']);

			$sql = "SELECT id, nome, user, password FROM usuarios WHERE (user = ?) AND (password = ?) LIMIT 1";
			$stmt = $database->prepare($sql);
			$stmt->bindParam(1, $usuario, PDO::PARAM_STR);
			$stmt->bindParam(2, $senha, PDO::PARAM_STR);
			$stmt->execute();
			//var_dump($stmt);
			//echo "<br><br>\n";
			$cont = $stmt->rowCount();
			//var_dump($cont);
			if ($cont > 0) {
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				if (!isset($_SESSION)) session_start();
				$_SESSION['message'] = "Bem Vindo " . $row['nome'] . "!";
				$_SESSION['type'] = "info";
				$_SESSION['id'] = $row['id'];
				$_SESSION['nome'] = $row['nome'];
				$_SESSION['user'] = $row['user'];
				
				//exit;
			} else {
				throw new Exception("Não foi possível se conectar!<br>Verifique seu usuário e senha.");
			}
			//header("Location: " . BASEURL . "index.php");
		} else {
			throw new Exception("Não foi possível se conectar!<br>Verifique seu usuário e senha.");
		}
	} catch (Exception $e) {
		$_SESSION['message'] = "Ocorreu um erro: " . $e->getMessage();
		$_SESSION['type'] = "danger";
	}
?>

<?php if (!empty($_SESSION['message'])) : ?>
    <div class=" mt-4 alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert" id="actions">
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php clear_messages(); ?>
<?php endif; ?>
<header>
    <a href="<?php echo BASEURL ?>index.php" class="btn btn-light"><i class="fa-solid fa-rotate-left"></i> Voltar</a>
</header>

<?php include(FOOTER_TEMPLATE); ?>
