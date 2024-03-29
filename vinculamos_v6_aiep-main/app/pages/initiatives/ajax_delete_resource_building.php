<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	session_start();
	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
		return;
	}

	include_once("../../utils/user_utils.php");
	if(!canUpdateInitiatives()) {
		echo "<p><strong> Acceso no permitido.</strong></p>";
		return;
	}

	$institucion = getInstitution();

	if(false) {
		echo "<br>vg_initiative: " . noeliaDecode($_REQUEST['vg_initiative']);
		echo "<br>vg_source: " . noeliaDecode($_REQUEST['vg_source']);
		echo "<br>vg_usuario: " . noeliaDecode($_REQUEST['vg_usuario']);
		echo "<br>vg_id: " . noeliaDecode($_REQUEST['vg_id']);
		return;
	}

	if( isset($_REQUEST['vg_initiative']) && isset($_REQUEST['vg_source'])
 		&& isset($_REQUEST['vg_id']) && isset($_REQUEST['vg_usuario'])) {

		include_once("../../controller/medoo_initiatives_plan_resources_building.php");
		$result = deleteBuildingResourcePlan(noeliaDecode($_REQUEST['vg_id']),
			noeliaDecode($_REQUEST['vg_initiative']), noeliaDecode($_REQUEST['vg_usuario']));

		if($result != null) { ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				Recurso eliminado correctamente.
			</div>
	<?php
		} else { ?>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				No pudimos eliminar el recurso.
			</div>
	<?php
		}
	} else {
		echo "Falta info!";
	}
?>
