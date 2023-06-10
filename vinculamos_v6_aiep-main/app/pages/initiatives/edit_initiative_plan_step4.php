<!-- ?php/*
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
	}

	include_once("../../utils/user_utils.php");
	if(!canUpdateInitiatives()) {
		header('Location: ../../index.php');
	}

	$nombre_usuario = $_SESSION["nombre_usuario"];
	$institution = getInstitution();

	$id = str_replace("data", "", noeliaDecode($_GET["data"]));

	include_once("../../controller/medoo_initiatives_plan.php");
	$datas = getInitiativePlan($id);
	$dataEncoded = noeliaEncode("data" . $datas[0]['id']);

	if($datas[0]["estado"] == "En Revisión") {
		if(!canSuperviseInitiatives()) {
			header('Location: ../../index.php');
		}
	}

	include_once("../../controller/medoo_params_resource_human.php");
	$humanTypes = getVisibleHumanResourcesTypes();

	include_once("../../controller/medoo_params_resource_building.php");
	$buildingTypes = getVisibleBuildingResourcesTypes();
	*/
?> -->

<!-- <!DOCTYPE html>
<html>
	?php include_once("../include/header.php")?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
	?php
		$activeMenu = "initiatives";
		include_once("../include/menu_side.php");

		include_once("modal_add_resource_cash.php");
		include_once("modal_edit_resource_cash.php");
		include_once("modal_delete_resource_cash.php");

		include_once("modal_add_resource_human.php");
		include_once("modal_edit_resource_human.php");
		include_once("modal_delete_resource_human.php");

		include_once("modal_add_resource_building.php");
		include_once("modal_edit_resource_building.php");
		include_once("modal_delete_resource_building.php");

		include_once("modal_finish_initiative.php");
		include_once("modal_ask_revision.php");
		include_once("modal_give_approve.php");
		include_once("modal_give_decline.php");
	?> -->

  	<!-- Content Wrapper. Contains page content -->
	<!--<div class="content-wrapper"> -->
    	<!-- Content Header (Page header) -->
    	<!--<section class="content-header">
      		<h1>
        		Iniciativas
        		<small>editar iniciativa</small>
      		</h1>
      		<ol class="breadcrumb">
						<li><a href="../home/index.php"><i class="fa fa-home"></i> Inicio</a></li>
        		<li><a href="../initiatives/view_initiatives_plan.php">Iniciativas</a></li>
        		<li class="active">Editar Iniciativa - Recursos</li>
      		</ol>
    	</section> -->

    	<!-- Main content -->
			<!-- <section class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
	    						<h3 class="box-title"> ?php echo ($datas[0]["nombre"] == "" ? "Editar iniciativa" : $datas[0]["nombre"]);?> - Recursos</h3>
							</div> -->
							<!-- /.box-header -->

							<!-- <div class="box-body">
								<div id='mensaje_eliminar'></div>
								<div id='resultados_presupuesto'></div>
							</div> -->
							<!-- /.box -->

							<!-- <div class="modal-footer">
								<a href="view_initiatives_plan.php" class="btn btn-default" data-dismiss="modal">Ir al listado</a>
								<a href="edit_initiative_plan_step3.php?data=?php echo$dataEncoded;?>" class="btn btn-orange" data-dismiss="modal"> <i class="fa fa-fw fa-chevron-left"></i> Volver al paso anterior</a>
								?php
									if($datas[0]["estado"] == "" || $datas[0]["estado"] == "Rechazada") { ?>
										<a class="btn btn-primary" data-toggle="modal" data-target="#askRevision"> <i class="fa fa-asterisk"></i> Pedir revisión</a>
										<script>
											$("#ask_revision").submit(function( event ) {
												$('#ask_revision').attr("disabled", true);
												var parametros = $(this).serialize();
												$.ajax({
													type: "POST",
													url: "./ajax_edit_ask_revision.php",
													data: parametros,
													beforeSend: function(objeto) {
														$("#resultados_modal_ask_revision").html("Cargando...");
													},
													success: function(datos) {
														//$("#resultados_modal_ask_revision").html(datos);
														if(datos != "-1") {
															$('#askRevision').modal('hide');
															window.location.href = "./view_initiatives_plan.php";
														}
													},
													error: function() {
														$("#resultados_modal_ask_revision").html("Error en el registro");
													}
												});

												event.preventDefault();
											})
										</script>
								?php
									}

									if($datas[0]["estado"] == "Aprobada") {
										echo "<span>&nbsp;&nbsp; <i class='text-green fa fa-check'></i> Aprobada &nbsp;&nbsp;</span>";
									}
									if($datas[0]["estado"] == "Rechazada") {
										echo "<span>&nbsp;&nbsp; <i class='text-red fa fa-close'></i> Rechazada &nbsp;&nbsp;</span>";
									}

									if($datas[0]["estado"] == "En Revisión" && canSuperviseInitiatives()) { ?>
										<a class="btn btn-primary" data-toggle="modal" data-target="#giveApprove"> <i class="text-green fa fa-check"></i> Aprobar iniciativa</a>
										<a class="btn btn-primary" data-toggle="modal" data-target="#giveDecline"> <i class="text-red fa fa-check"></i> Rechazar iniciativa</a>
										<script>
										$("#give_approve").submit(function( event ) {
											$('#give_approve').attr("disabled", true);
											var parametros = $(this).serialize();
											$.ajax({
												type: "POST",
												url: "./ajax_edit_give_approve.php",
												data: parametros,
												beforeSend: function(objeto) {
													$("#resultados_modal_give_approve").html("Cargando...");
												},
												success: function(datos) {
													//$("#resultados_modal_ask_revision").html(datos);
													if(datos != "-1") {
														$('#askRevision').modal('hide');
														window.location.href = "./view_initiatives_plan.php";
													}
												},
												error: function() {
													$("#resultados_modal_give_approve").html("Error en el registro");
												}
											});

											event.preventDefault();
										})

										$("#give_decline").submit(function( event ) {
											$('#give_decline').attr("disabled", true);
											var parametros = $(this).serialize();
											$.ajax({
												type: "POST",
												url: "./ajax_edit_give_decline.php",
												data: parametros,
												beforeSend: function(objeto) {
													$("#resultados_modal_give_decline").html("Cargando...");
												},
												success: function(datos) {
													//$("#resultados_modal_give_decline").html(datos);
													if(datos != "-1") {
														$('#askRevision').modal('hide');
														window.location.href = "./view_initiatives_plan.php";
													}
												},
												error: function() {
													$("#resultados_modal_give_decline").html("Error en el registro");
												}
											});

											event.preventDefault();
										})
										</script>
								?php
									}
								?>
								<a class="btn btn-success" data-toggle="modal" data-target="#finishInitiative"> Finalizar</a>
							</div>

							<hr style="height: 2px; border: 0;" class="btn-orange"/>

					</div> -->
					<!-- /.col -->
				<!-- </div> -->
				<!-- /.row -->
			<!-- </section> -->
	    	<!-- /.content -->
	<!-- </div> -->
  	<!-- /.content-wrapper -->

  <!--	?php include_once("../include/footer.php")?>
</div> -->
<!-- ./wrapper -->

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script> -->

<!-- <script>
	/*
	$(document).ready(function(){
		loadBudget();
	});

	function loadBudget(tipo) {
		var parametros = {
			"id_initiative" : btoa(' ?php echo$id;?>')
    };
		var url = "./ajax_view_budget_plan.php";
		$.ajax({
			type: "POST",
      url: url,
      data:  parametros,
      beforeSend: function () {
          $("#resultados_presupuesto").html("Obteniendo información, espere por favor.");
      },
      success:  function (response) {
          $("#resultados_presupuesto").html(response);
      	},
				error: function() {
					$("#resultados_presupuesto").html(response);
				}
      });
	}
	*/



	/* DINERO */
	/*$('#addCash').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');
		var id_source = button.data('source');

		var modal = $(this);
		modal.find('.modal-body #vg_id').val(id);
		modal.find('.modal-body #vg_source').val(id_source);
		modal.find('.modal-body #vg_type_cash').val("");
		modal.find('.modal-body #vg_amount_cash').val("0");
		$("#resultados_modal_agregar_dinero").html("");
	})

	$("#add_cash").submit(function( event ) {
		$('#add_cash').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_add_resource_cash.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#resultados_modal_agregar_dinero").html("Cargando...");
			},
			success: function(datos) {
				$("#resultados_modal_agregar_dinero").html(datos);
				//$('#addCash').modal('hide');
				loadBudget();
			},
			error: function() {
				$("#resultados_modal_agregar_dinero").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#editCash').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');
		var id_source = button.data('source');
		var name = button.data('name');
		var total = button.data('total');

		var modal = $(this);
		modal.find('.modal-body #vg_id').val(id);
		modal.find('.modal-body #vg_source').val(id_source);
		modal.find('.modal-body #vg_type_cash').val(name);
		modal.find('.modal-body #vg_amount_cash').val(total);
		$("#resultados_modal_editar_dinero").html("");
	})

	$("#edit_cash").submit(function( event ) {
		$('#edit_cash').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_edit_resource_cash.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#resultados_modal_editar_dinero").html("Cargando...");
			},
			success: function(datos) {
				$("#resultados_modal_editar_dinero").html(datos);
				loadBudget();
			},
			error: function() {
				$("#resultados_modal_editar_dinero").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#deleteCash').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');
		var id_source = button.data('source');

		var modal = $(this);
		modal.find('.modal-body #vg_id').val(id);
		modal.find('.modal-body #vg_source').val(id_source);
		$("#resultados_modal_eliminar_recurso_financiero").html("");
		$("#mensaje_eliminar").html("");
	})

	$("#delete_cash").submit(function( event ) {
		$('#delete_cash').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_delete_resource_cash.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#mensaje_eliminar").html("Cargando...");
			},
			success: function(datos) {
				$('#deleteCash').modal('hide');
				$("#mensaje_eliminar").html(datos);
				//$('#addCash').modal('hide');
				loadBudget();
			},
			error: function() {
				$("#mensaje_eliminar").html("Error en el registro");
			}
		});

		event.preventDefault();
	})
	*/

	/* RECURSO HUMANO */
	/*$('#addHuman').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');
		var id_source = button.data('source');

		var modal = $(this);
		modal.find('.modal-body #vg_id').val(id);
		modal.find('.modal-body #vg_source').val(id_source);
		modal.find('.modal-body #vg_type_human').selectpicker('val', '');
		modal.find('.modal-body #vg_amount_human').val("1");
		modal.find('.modal-body #vg_total_human').val("");
		$("#resultados_modal_agregar_humano").html("");
	})

	$("#add_human").submit(function( event ) {
		$('#add_human').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_add_resource_human.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#resultados_modal_agregar_humano").html("Cargando...");
			},
			success: function(datos) {
				$("#resultados_modal_agregar_humano").html(datos);
				//$('#addHuman').modal('hide');
				loadBudget();
			},
			error: function() {
				$("#resultados_modal_agregar_humano").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#editHuman').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');
		var id_source = button.data('source');
		var name = button.data('name');
		var amount = button.data('amount');
		var total = button.data('total');

		var modal = $(this);
		modal.find('.modal-body #vg_id').val(id);
		modal.find('.modal-body #vg_source').val(id_source);
		modal.find('.modal-body #vg_type_human').selectpicker("val", name);
		modal.find('.modal-body #vg_amount_human').val(amount);
		modal.find('.modal-body #vg_total_human').val(total);
		$("#resultados_modal_editar_humano").html("");
	})

	$("#edit_human").submit(function( event ) {
		$('#edit_human').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_edit_resource_human.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#resultados_modal_editar_humano").html("Cargando...");
			},
			success: function(datos) {
				$("#resultados_modal_editar_humano").html(datos);
				loadBudget();
			},
			error: function() {
				$("#resultados_modal_editar_humano").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#deleteHuman').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');
		var id_source = button.data('source');

		var modal = $(this);
		modal.find('.modal-body #vg_id').val(id);
		modal.find('.modal-body #vg_source').val(id_source);
		$("#resultados_modal_eliminar_recurso_humano").html("");
		$("#mensaje_eliminar").html("");
	})

	$("#delete_human").submit(function( event ) {
		$('#delete_human').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_delete_resource_human.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#mensaje_eliminar").html("Cargando...");
			},
			success: function(datos) {
				$('#deleteHuman').modal('hide');
				$("#mensaje_eliminar").html(datos);
				//$('#addCash').modal('hide');
				loadBudget();
			},
			error: function() {
				$("#mensaje_eliminar").html("Error en el registro");
			}
		});

		event.preventDefault();
	})
	*/
	/* INFRAESTRUCTURA Y EQUIPAMIENTO */
	/*$('#addBuilding').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');
		var id_source = button.data('source');

		var modal = $(this);
		modal.find('.modal-body #vg_id').val(id);
		modal.find('.modal-body #vg_source').val(id_source);
		modal.find('.modal-body #vg_type_building').selectpicker('val', '');
		modal.find('.modal-body #vg_amount_building').val("1");
		modal.find('.modal-body #vg_total_building').val("");
		$("#resultados_modal_agregar_edificio").html("");
	})

	$("#add_building").submit(function( event ) {
		$('#add_building').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_add_resource_building.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#resultados_modal_agregar_edificio").html("Cargando...");
			},
			success: function(datos) {
				$("#resultados_modal_agregar_edificio").html(datos);
				//$('#addBuilding').modal('hide');
				loadBudget();
			},
			error: function() {
				$("#resultados_modal_agregar_edificio").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#editBuilding').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');
		var id_source = button.data('source');
		var name = button.data('name');
		var amount = button.data('amount');
		var total = button.data('total');

		var modal = $(this);
		modal.find('.modal-body #vg_id').val(id);
		modal.find('.modal-body #vg_source').val(id_source);
		modal.find('.modal-body #vg_type_building').selectpicker("val", name);
		modal.find('.modal-body #vg_amount_building').val(amount);
		modal.find('.modal-body #vg_total_building').val(total);
		$("#resultados_modal_editar_edificio").html("");
	})

	$("#edit_building").submit(function( event ) {
		$('#edit_building').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_edit_resource_building.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#resultados_modal_editar_edificio").html("Cargando...");
			},
			success: function(datos) {
				$("#resultados_modal_editar_edificio").html(datos);
				loadBudget();
			},
			error: function() {
				$("#resultados_modal_editar_edificio").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#deleteBuilding').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');
		var id_source = button.data('source');

		var modal = $(this);
		modal.find('.modal-body #vg_id').val(id);
		modal.find('.modal-body #vg_source').val(id_source);
		$("#resultados_modal_eliminar_recurso_infraestructura").html("");
		$("#mensaje_eliminar").html("");
	})

	$("#delete_building").submit(function( event ) {
		$('#delete_building').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_delete_resource_building.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#mensaje_eliminar").html("Cargando...");
			},
			success: function(datos) {
				$('#deleteBuilding').modal('hide');
				$("#mensaje_eliminar").html(datos);
				//$('#addCash').modal('hide');
				loadBudget();
			},
			error: function() {
				$("#mensaje_eliminar").html("Error en el registro");
			}
		});

		event.preventDefault();
	})
 */
///script>

</body>
</html>
