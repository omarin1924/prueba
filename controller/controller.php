<?php

require_once ('../conexion/MysqliDb.php');
require_once ('../conexion/variables.php');
$db = new MysqliDb (SERVIDOR, USUARIO, CONTRASEÑA, 'prueba');


if ($_POST) {
	switch ($_POST['accion']) {
		case 'crear':
		crear_movimiento($db);
		break;

		case 'actualizar':
		actualizar_movimiento($db);
		break;	
		
		case 'eliminar':
		eliminar_movimiento($db);
		break;	
		
		case 'buscar':
		buscar_movimientos($db);
		break;
		
		

		default:
		die;
		break;
	}



}

function crear_movimiento($db){
	extract($_POST, EXTR_SKIP);

	$data = Array ("fecha" => $fecha,
		"beneficiario" => $beneficiario,
		"salidas" => $salidas,
		"saldo" => $saldo,
		"banco" => $banco,
		"tipo_mov" => $tipo_mov,
		"empresa" => $empresa,
		"naturaleza" => $naturaleza
	);

	$id = $db->insert ('movimientos', $data);
	if($id)
		echo 'new id' . $id;
	else
		echo 'insert failed: ' . $db->getLastError();
}

function actualizar_movimiento($db){
	extract($_POST, EXTR_SKIP);

	$data = Array ("fecha" => $fecha,
		"beneficiario" => $beneficiario,
		"salidas" => $salidas,
		"saldo" => $saldo,
		"banco" => $banco,
		"tipo_mov" => $tipo_mov,
		"empresa" => $empresa,
		"naturaleza" => $naturaleza
	);
	$db->where ('id', $id);
	if ($db->update ('movimientos', $data))
		echo 'new id';
	else
		echo 'update failed: ' . $db->getLastError();
}

function eliminar_movimiento($db){

	$db->where ('id', $_POST['id']);
	if ($db->update ('movimientos',array('activo'=>0)))
		echo 'new id';
	else
		echo 'update failed: ' . $db->getLastError();
}

function buscar_movimientos($db){
	extract($_POST, EXTR_SKIP);
	
	if($naturaleza!='')
		$db->where ('naturaleza', $naturaleza);

	if($beneficiario!='')
		$db->where ('beneficiario', $beneficiario);

	$movimientos = $db->ObjectBuilder()->get('movimientos');
	$html='';
	if ($db->count > 0){
		echo json_encode($movimientos);
		foreach ($movimientos as  $mov) {
			$html.='<tr>
			<td>'.$mov->fecha.'</td>
			<td >'.$mov->beneficiario.'</td>
			<td >'.$mov->salidas.'</td>
			<td class="saldo" >$ '.$mov->saldo.'</td>
			<td >'.$mov->banco.'</td>
			<td >'.$mov->tipo_mov.'</td>
			<td >'.$mov->empresa.'</td>
			<td >'.$mov->naturaleza.'</td>
			<td>
			<button type="button" onclick="mostrar_modal(\'actualizar\',this)" data=\''.json_encode($mov).'\' class="btn btn-primary btn-sm">
			<i class="fas fa-pen"></i></a>
			</button>  
			<button type="button" onclick="confirmar_eliminar('.$mov->id.')" class="btn btn-danger btn-sm">

			<i class="fas fa-trash-alt"></i></a>
			</button>
			</tr>';
		}
	}else{
		$html='<tr>
		<td colspan=9>NO SE HAN ENCONTRADO REGISTROS EN LA BASE DE DATOS QUE CUMPLAN LAS CONDICIONES DEL FILTRO</td>
		</tr>';
	}
	echo $html;

}
