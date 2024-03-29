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

	function eliminar_acentos($cadena){
	    //Reemplazamos la A y a
		$cadena = str_replace(
		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
		$cadena
		);

		//Reemplazamos la E y e
		$cadena = str_replace(
		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
		$cadena );

		//Reemplazamos la I y i
		$cadena = str_replace(
		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
		$cadena );

		//Reemplazamos la O y o
		$cadena = str_replace(
		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
		$cadena );

		//Reemplazamos la U y u
		$cadena = str_replace(
		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
		$cadena );

		//Reemplazamos la N, n, C y c
		$cadena = str_replace(
		array('Ñ', 'ñ', 'Ç', 'ç'),
		array('N', 'n', 'C', 'c'),
		$cadena
		);

		return $cadena;
	}

	include_once("../../controller/medoo_environment.php");
	$myEnvironmentsInternal = getInternalEnvironmentsByInitiativePlanPOC(noeliaDecode($_REQUEST['vg_id']));
	//echo "<br> internal: " . sizeof($myEnvironmentsInternal);
	$myEnvironmentsExternal = getExternalEnvironmentsByInitiativePlanPOC(noeliaDecode($_REQUEST['vg_id']));
	//echo "<br> external: " . sizeof($myEnvironmentsExternal);
	if(sizeof($myEnvironmentsInternal) == 0 || sizeof($myEnvironmentsExternal) == 0) { ?>
		<div class="alert alert-warning alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			Se debe ingresar un entorno interno y uno externo antes de continuar.
		</div>
	<?php
	return;
	}
		// Linea 79 despues de vg_id && isset($_REQUEST['vg_objetivo'])
		// Linea 84 despues de vg_descripcion $_REQUEST['vg_objetivo'],
	if( isset($_REQUEST['vg_id']) 
		&& isset($_REQUEST['vg_descripcion']) && isset($_REQUEST['vg_usuario'])) {

		include_once("../../controller/medoo_initiatives_plan.php");
		$result = editInitiativePlanStep2(noeliaDecode($_REQUEST['vg_id']), $_REQUEST['vg_descripcion'],
		 noeliaDecode($_REQUEST['vg_usuario']));

		//include_once("../../controller/medoo_environment.php");
		//updateEnvironmentsByInitiativePlan(noeliaDecode($_REQUEST['vg_id']), $_REQUEST['vg_entorno'], noeliaDecode($_REQUEST['vg_usuario']));

		//include_once("../../controller/medoo_environment_sub.php");
		//updateEnvironmentsSubsByInitiativePlan(noeliaDecode($_REQUEST['vg_id']), $_REQUEST['vg_entorno_sub'], noeliaDecode($_REQUEST['vg_usuario']));

		//$detail_arr = explode(",", $_REQUEST['vg_entorno_detalle']);
		//include_once("../../controller/medoo_environment_detail.php");
		//updateEnvironmentDetailsByInitiativePlan(noeliaDecode($_REQUEST['vg_id']), $detail_arr, noeliaDecode($_REQUEST['vg_usuario']));

		include_once("../../controller/medoo_impact_internal.php");
		updateInternalImpactByInitiativePlan(noeliaDecode($_REQUEST['vg_id']), $_REQUEST['vg_tipo_impacto_interno'], noeliaDecode($_REQUEST['vg_usuario']));

		include_once("../../controller/medoo_impact_external.php");
		updateExternalImpactByInitiativePlan(noeliaDecode($_REQUEST['vg_id']), $_REQUEST['vg_tipo_impacto_externo'], noeliaDecode($_REQUEST['vg_usuario']));

		//include_once("../../controller/medoo_measures.php");
		//$misMetas = getVisibleMeasuresByInitiative(noeliaDecode($_REQUEST['vg_id']));
		include_once("../../controller/medoo_initiatives_plan_ods.php");
		//updateODSByInitiativePlan(noeliaDecode($_REQUEST['vg_id']), $misMetas, noeliaDecode($_REQUEST['vg_usuario']));

		$datas = getInitiativePlan(noeliaDecode($_REQUEST['vg_id']));
		$salida = array();
		$entrada = eliminar_acentos($datas[0]["nombre"] . " " . $datas[0]["objetivo"] . " " . $datas[0]["descripcion"]);
		//exec("python /Applications/MAMP/htdocs/vinculamos_v5_ucm/test/AlgoritmoODS.py '$entrada'", $salida);
		exec("python /home/vinculam/public_html/algoritmoODS/AlgoritmoODSv5.py '$entrada'", $salida);
		$arrayMetas = array();
		$arrayObjetivos = array();
		for($j = 0; $j < count($salida); $j++){
			if(substr($salida[$j], 0, 5) === "Meta ") {
				$arrayMetas[] = substr($salida[$j], 5);
			}
			if(substr($salida[$j], 0, 4) === "ODS ") {
				$idODS = substr(strtok($salida[$j], ":"), 4);
				$ods["nombre"] = $idODS;
				for ($x=0; $x < sizeof($arrayMetas); $x++) {
					$metaX = $arrayMetas[$x];
					$metaX = str_replace($idODS.".", "", $metaX);
					$idMeta = strtok($metaX, ":");
					$arrayMetas[$x] = $idMeta;
				}
				$ods["metas"] = $arrayMetas;
				$arrayObjetivos[] = $ods;
				$arrayMetas = array();
			}
		}
		updateODSByInitiativePlanFromPython(noeliaDecode($_REQUEST['vg_id']), $arrayObjetivos, "superadmin");

		if($result != null) { ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				Iniciativa guardada correctamente.
			</div>
		<?php
		} else { ?>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				No pudimos actualizar la información.
			</div>
		<?php
		}
	} else {
		echo "Falta info!";
	}
?>
