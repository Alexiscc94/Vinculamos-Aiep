<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
		return;
	}

	include_once("../../utils/user_utils.php");
	if(!canCreateParameters()) {
		echo "<p><strong> Acceso no permitido.</strong></p>";
		return;
	}

	$institucion = getInstitution();

	if( isset($_REQUEST['vg_nombre']) && isset($_REQUEST['vg_descripcion'])
		&& isset($_REQUEST['vg_id_unidad']) && isset($_REQUEST['vg_usuario']) ) {

		include_once("../../controller/medoo_units_subs.php");
		$result = addUnitSub($_REQUEST['vg_nombre'], $_REQUEST['vg_descripcion'], $_REQUEST['vg_director'],
			noeliaDecode($_REQUEST['vg_id_unidad']), noeliaDecode($_REQUEST['vg_usuario']), $institucion);

		if($result != null) { ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				Sub unidad cargada correctamente.
			</div>
		<?php
		} else { ?>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				La sub unidad que intenta agregar ya existe.
			</div>
		<?php
		}
	} else {
		echo "<br>Falta info!";
	}
?>
