<!-- Modal -->
<div class="modal fade" id="deleteParticipationPlan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
					<i class='glyphicon glyphicon-edit'></i> Eliminar participantes esperados
				</h4>
			</div>
			<div class="modal-body">
				<div id="resultados_modal_eliminar"></div>
				<p class="text-center">
					<strong>Se eliminará detalle de participantes seleccionado.<br>¿Desea continuar?</strong>
				</p>
				<form class="form-horizontal" method="post" id="delete_participation_plan" name="delete_participation_plan">
					<?php echo "<input type='hidden' value='".$_SESSION['nombre_usuario']."' id='vg_usuario' name='vg_usuario' />"; ?>
					<?php echo "<input type='hidden' value='' id='vg_initiative' name='vg_initiative' />"; ?>
					<?php echo "<input type='hidden' value='' id='vg_id' name='vg_id' />"; ?>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-orange">Continuar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
