<?php 
require_once ('conexion/MysqliDb.php');
require_once ('conexion/variables.php');
$db = new MysqliDb (SERVIDOR, USUARIO, CONTRASEÑA, 'prueba');
$movimientos = $db->ObjectBuilder()->where('activo',1)->orderBy("id","desc")->get('movimientos');
?>
<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

	<link rel="stylesheet" href="./bootstrap/css/bootstrap-datepicker.min.css" >


	<title>Prueba de conocimientos</title>
</head>
<body>
	<div class="container">
		<br>
		<div class="row">

			
			<div class="col-md-12">
				<strong>FILTROS</strong>
				<button type="button" onclick="imprimir()" class="btn btn-warning float-right">
					<i class="fas fa-print"></i> Imprimir</button>
				</div>
				<div class="col-md-12">


					<div class="form-row">
						<div class="form-group col-md-3">
							<label for="inputState">NATURALEZA</label>
							<select onchange="buscar_movimientos()" id="buscar_naturaleza" class="form-control">
								<option  value="" selected>Seleccione una opcion</option>
								<?php
								$filtro_naturaleza = $db->ObjectBuilder()->where('activo',1)->groupBy('naturaleza')->orderBy("id","desc")->get('movimientos');
								foreach ($filtro_naturaleza as $nat): 
									?>
									<option value="<?=$nat->naturaleza?>"><?=$nat->naturaleza?></option>
								<?php endforeach; ?>
							</select>
						</div> 
						<div class="form-group col-md-3">
							<label for="inputState">BENEFICIARIO</label>
							<select onchange="buscar_movimientos()" id="buscar_beneficiario" class="form-control ">
								<option value="" selected>Seleccione una opcion</option>
								<?php
								$filtro_beneficiario = $db->ObjectBuilder()->where('activo',1)->groupBy('beneficiario')->orderBy("id","desc")->get('movimientos');
								foreach ($filtro_beneficiario as $ben): 
									?>
									<option value="<?=$ben->beneficiario?>"><?=$ben->beneficiario?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="inputState"></label>
							<div class="alert alert-primary" role="alert">

								TOTAL SALDOS: <strong id ="total"></strong>
							</div>
						</div>
						
						<div class="form-group col-md-2">
							<br>
							<button type="button" onclick="mostrar_modal('crear',0)" class="btn btn-info float-right">
								<i class="fas fa-plus"></i> Agregar</button>

								
							</div>
						</div>
					</div>
					



					<table class="table table-bordered table-hover table-sm">
						<caption>Listado base de datos de prueba</caption>
						<thead>
							<tr>
								<th scope="col">Fecha</th>
								<th scope="col">Beneficiario</th>
								<th scope="col">Salidas</th>
								<th scope="col">Saldo</th>
								<th scope="col">Banco</th>
								<th scope="col">Tipo mov</th>
								<th scope="col">Empresa</th>
								<th scope="col">Naturaleza</th>
								<th scope="col">Accion</th>
							</tr>
						</thead>
						<tbody id="datos_tabla" style="   font-size: 14px;">
							<tr>
								<?php if ($db->count > 0):
									foreach ($movimientos as $mov): 
										?>
										<tr id="id_mov_<?=$mov->id?>" >
											<td><?=$mov->fecha?></td>
											<td ><?=$mov->beneficiario?></td>
											<td ><?=$mov->salidas?></td>
											<td class="saldo">$ <?=$mov->saldo?></td>
											<td ><?=$mov->banco?></td>
											<td ><?=$mov->tipo_mov?></td>
											<td ><?=$mov->empresa?></td>
											<td ><?=$mov->naturaleza?></td>
											<td>
												<button type="button" onclick="mostrar_modal('actualizar',this)" data='<?=json_encode($mov)?>' class="btn btn-primary btn-sm">
													<i class="fas fa-pen"></i></a>
												</button>  
												<button type="button" onclick="confirmar_eliminar(<?=$mov->id?>)" class="btn btn-danger btn-sm">

													<i class="fas fa-trash-alt"></i></a>
												</button>
											</tr>

										<?php  	endforeach; 
									endif;
									?>
								</tbody>
							</table>


							<div class="modal  fade"  id="modal_mov" tabindex="-1" role="dialog">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title">MOVIMIENTO</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<form id="form_guardar_mov">
												<input type="hidden" name="id" id="id">
												<input type="hidden" name="accion" id="accion">
												<div class="form-row">
													<div class="form-group col-md-6">
														<label for="fecha">Fecha</label>
														<input type="text" class="form-control" id="fecha" name="fecha" >
													</div>
													<div class="form-group col-md-6">
														<label for="beneficiario">Beneficiario</label>
														<input type="text" class="form-control " id="beneficiario" name="beneficiario">
													</div>
												</div> 

												<div class="form-row">
													<div class="form-group col-md-4">
														<label for="salidas">Salidas</label>
														<input type="number" class="form-control " id="salidas" name="salidas">
													</div>
													<div class="form-group col-md-4">
														<label for="saldo">Saldo</label>
														<input type="number" class="form-control" id="saldo" name="saldo" >
													</div>
													<div class="form-group col-md-4">
														<label for="banco">Banco</label>
														<input type="text" class="form-control" id="banco" name="banco" >
													</div>
												</div>
												<div class="form-row">
													<div class="form-group col-md-4">
														<label for="tipo_mov">Tipo de movimiento</label>
														<input type="text" class="form-control " id="tipo_mov" name="tipo_mov">
													</div>
													<div class="form-group col-md-4">
														<label for="empresa">Empresa</label>
														<input type="text" class="form-control" id="empresa" name="empresa" >
													</div>
													<div class="form-group col-md-4">
														<label for="banco">Naturaleza</label>
														<input type="text" class="form-control" id="naturaleza" name="naturaleza" >
													</div>
												</div>
											</form>
											<div class="alert alert-danger d-none" id="mensaje_error_modal" role="alert">
												Por favor ingrese los campos marcados en rojo.
											</div>

										</div>
										<div class="modal-footer">

											<button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
											<button type="button" class="btn btn-primary" onclick="guardar_movimiento()">GUARDAR</button>
										</div>
									</div>
								</div>
							</div>



							<div class="modal fade" tabindex="-1" id="modal_exito" role="dialog">
								<div class="modal-dialog" role="document">
									<div class="modal-content">

										<div class="modal-body">
											<div class="alert alert-success"  role="alert">
												DATOS GUARDADOS CON EXITO
											</div>
										</div>
										<div class="modal-footer">

											<button type="button" class="btn btn-success" onclick="location.reload();">ACEPTAR</button>
										</div>
									</div>
								</div>
							</div>	

							<div class="modal fade" tabindex="-1" id="modal_eliminar" role="dialog">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title"></h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<input type="hidden" id="id_eliminar" name="id_eliminar">
											<h4 class="text-danger">¿Está seguro que desea eliminar este registro? </h4>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
											<button type="button" class="btn btn-success" onclick="eliminar_movimiento();">ACEPTAR</button>
										</div>
									</div>
								</div>
							</div>




							<div class="alert alert-success col-md-12" role="alert">
								<h4 class="alert-heading">Prueba de conocimiento PHP</h4>
								<hr>
								<p class="mb-0">Realizada por : Orlando Marin Anaya - marin.1924@gmail.com </p>
							</div>
						</div> <!-- row -->
					</div> <!-- container -->

					<!-- Optional JavaScript -->
					<!-- jQuery first, then Popper.js, then Bootstrap JS -->
					<script
					src="https://code.jquery.com/jquery-3.3.1.min.js"
					integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
					crossorigin="anonymous"></script>
					<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
					<script src="./bootstrap/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

					<script src="./bootstrap/js/bootstrap-datepicker.min.js" ></script>
				</body>

				<script type="text/javascript">

					$(function(){

						$('#fecha').datepicker({
							format: "yyyy-mm-dd"
						});
						sumar_saldos()

					});
					function confirmar_eliminar(id){

						$('#modal_eliminar').modal('show');
						$('#id_eliminar').val(id)
					}

					function mostrar_modal(accion,btn){
						$('#form_guardar_mov input:text').val('')
						$
						$('#modal_mov').modal('show');
						$('#accion').val(accion);
						if(accion=='actualizar'){
							var data= JSON.parse($(btn).attr('data'));
							$('#id').val(data.id);
							$('#fecha').val(data.fecha);
							$('#beneficiario').val(data.beneficiario);
							$('#salidas').val(data.salidas);
							$('#saldo').val(data.saldo);
							$('#banco').val(data.banco);
							$('#tipo_mov').val(data.tipo_mov);
							$('#empresa').val(data.empresa);
							$('#naturaleza').val(data.naturaleza);

						}


					}  	


					function guardar_movimiento(){
						var error=false;
						$('.is-invalid').removeClass('is-invalid');
						$('#form_guardar_mov input').each(function (index, input) {
							if ($(input).val() == '') {
								$(input).addClass('is-invalid');
								error = true;
							}
						});
						if (error) {
							$('#mensaje_error_modal').removeClass('d-none');
							return false;
						} else {
							$('#mensaje_error_modal').addClass('d-none');
							$.post( "controller/controller.php", $('#form_guardar_mov').serialize()
								)
							.done(function( data ) {
								$('#modal_mov').modal('hide');
								$('#modal_exito').modal('show');

							});
						}
					}

					function eliminar_movimiento(){
						var id= $('#id_eliminar').val();
						$.post( "controller/controller.php", {id:id,accion:'eliminar'})
						.done(function( data ) {
							$('#modal_eliminar').modal('hide');
							$('#modal_exito').modal('show');
							console.log('ok')

						});
					}

					function buscar_movimientos(){
						var naturaleza=$('#buscar_naturaleza').val();
						var beneficiario=$('#buscar_beneficiario').val();
						$.post( "controller/controller.php", 
						{	

							beneficiario : beneficiario,
							naturaleza :naturaleza ,
							accion : "buscar",


						},function(data){
							$('#datos_tabla').html(data);
							sumar_saldos()
						});
					}
					function sumar_saldos(){
						sum=0;
						$('.saldo').each(function(i,val) {
							sum=sum + parseFloat($(val).html().replace('$ ',''));
						});
						sum=sum.toFixed(2);
						$('#total').html('$ '+ sum)
					}	

					function imprimir(){
						var naturaleza=$('#buscar_naturaleza').val();
						var beneficiario=$('#buscar_beneficiario').val();
						var win = window.open('/prueba/pdf.php?naturaleza='+naturaleza+'&beneficiario='+beneficiario, '_blank');
						win.focus();
					}
				</script>
				</html>