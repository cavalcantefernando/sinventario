<!DOCTYPE html>
<html>
<head>
	<!-- META TAG'S -->
	<meta charset="utf-8" />	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title> Totalização de Estoque (Produtos Negativos) </title>

	<!-- STYLE CSS -->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css" />

	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h3> Totalização de Estoque (Produtos Negativos) </h3>
				<hr />
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Filial</label>
								<select id="filiais" class="form-control">
									<option>  ------------  </option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<label> &nbsp; <br /></label>
							<p><button id="exportar" class="btn btn-success"> Exportar </button></p>
						</div>
					</div> 
				<hr />
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered" id="tb-lista-produtos">
					<thead>
						<th> Cod. </th>
						<th> Descricao </th>
						<th> Estoque </th>
						<th> Pedido Pendente </th>
						<th> Quantidade </th>
					</thead>
					<tbody id="lista-produtos"></tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- SCRIPT'S JS -->
	<script src="js/jquery.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="js/bootstrap.min.js"></script>
	<script type="module" src="js/table2csv.js"></script>
	<script src="js/inventario.js"></script>
</body>
</html>