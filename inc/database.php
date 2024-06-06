<?php
	function open_database() {
		try {
			$conn = new PDO("mysql:host=". DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
	
	function close_database($conn) {
		$conn = null;
	}

	function find($table = null, $id = null) {
		$database = open_database();
		$found = null;
		try {
			if ($id) {
				$sql = "SELECT * FROM $table WHERE id = ?";
				$stmt = $database->prepare($sql);
				$stmt->execute([$id]);
				$found = $stmt->fetch(PDO::FETCH_ASSOC);/*corrigir codigo com o d prof */
			} else {
				$sql = "SELECT * FROM $table";
				$stmt = $database->query($sql);
				$found = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		} catch (PDOException $e) {
			$_SESSION['message'] = $e->getMessage();
			$_SESSION['type'] = 'danger';
		}
		close_database($database);
		return $found;
	}

	function find_all($table) {
		return find($table);
	}

	/**
	 *  Atualiza um registro em uma tabela, por ID
	 */
	function update($table = null, $id = 0, $data = null) {
		try {
			$database = open_database();
			$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			$items = '';
			foreach ($data as $key => $value) {
				$items .= trim($key, "'") . '=?,';
			}
			
			$items = rtrim($items, ',');
	
			$sql = "UPDATE $table SET $items WHERE id=?";
			$stmt = $database->prepare($sql);
	
			$values = array_values($data);
			$values[] = $id;
	
			$stmt->execute($values);
	
			$_SESSION['message'] = "Registro atualizado com sucesso.";
			$_SESSION['type'] = "success";
		} catch (PDOException $e) {
			$_SESSION['message'] = "Não foi possível realizar a operação.";
			$_SESSION['type'] = "danger";
		}
	}
	
	function remove($table = null, $id = null) {
		try {
			$database = open_database();
			$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			if ($id) {
				$sql = "DELETE FROM $table WHERE id = ?";
				$stmt = $database->prepare($sql);
				$stmt->execute([$id]);
	
				$_SESSION['message'] = "Registro Removido com Sucesso.";
				$_SESSION['type'] = "success";
			}
		} catch (PDOException $e) {
			$_SESSION['message'] = $e->getMessage();
			$_SESSION['type'] = 'danger';
		}
	}
	
	function criptografia($senha) {
		$custo = '08';
		$salt = 'Cf1f11ePArKlBJomM0F6aJ';
	
		
		$hash = crypt($senha, '$2a$' . $custo . '$' . $salt . '$');
	
		return $hash;
	}
	
	function clear_messages() {
		$_SESSION['message'] = null;
		$_SESSION['type'] = null;
	}	
?>