<?php 
  include('functions.php'); 
  add();
  include(HEADER_TEMPLATE);
?>

<h2>Novo Cliente</h2>

<form action="add.php" method="post">
	  <!-- area de campos do form -->
	  <hr>
		<div class="row">
			<div class="form-group col-md-7">
			  <label for="name">Nome / Razão Social</label>
			  <input type="text" class="form-control" name="customer['name']">
			</div>

			<div class="form-group col-md-3">
			  <label for="campo2">Quantidade</label>
			  <input type="text" class="form-control" name="customer['quantidade']">
			</div>

			<div class="form-group col-md-2">
			  <label for="campo3">Data de Nascimento</label>
			  <input type="date" class="form-control" name="customer['birthdate']">
			</div>
	 
			
			<div class="form-group col-md-2">
			  <label for="campo3">Data de Cadastro</label>
			  <input type="text" class="form-control" name="customer['created']" disabled>
			</div>
		</div>
	  
	  <div id="actions" class="row mt-2">
			<div class="col-md-12">
			  <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-sd-card"></i> Salvar</button>
			  <a href="index.php" class="btn btn-light"><i class="fa-solid fa-circle-arrow-left"></i> Cancelar</a>
			</div>
	  </div>
</form>

<?php include(FOOTER_TEMPLATE); ?>