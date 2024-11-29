<?php include('db_connect.php'); ?>

<div class="container-fluid">
<style>
	input[type=checkbox] {
		-ms-transform: scale(1.5); /* IE */
		-moz-transform: scale(1.5); /* FF */
		-webkit-transform: scale(1.5); /* Safari and Chrome */
		-o-transform: scale(1.5); /* Opera */
		transform: scale(1.5);
		padding: 10px;
	}
</style>
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				<!-- You can add some page title or introductory text here if necessary -->
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Tournament Registration List</b>
						<span class="">
							<button class="btn btn-primary btn-block btn-sm col-sm-2 float-right" type="button" id="new_registration">
								<i class="fa fa-plus"></i> New Registration
							</button>
						</span>
					</div>
					<div class="card-body">
						
						<table class="table table-bordered table-condensed table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Tournament Information</th>
									<th class="">Number of Teams Registered</th>
									<th class="">Tournament Revenue</th> <!-- New Column -->
									<th class="">Status</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$registration = $conn->query("SELECT t.id, t.name, t.schedule, t.status FROM tournaments t");
								while($row = $registration->fetch_assoc()):
									// Fetch the count of teams registered for this tournament
									$tournament_id = $row['id'];
									$count_query = $conn->query("SELECT getRegistrationCount($tournament_id) AS registration_count");
									$count_result = $count_query->fetch_assoc();
									$registration_count = $count_result['registration_count'];

									// Calculate tournament revenue using the stored procedure
									$conn->query("CALL CalculateTournamentRevenue($tournament_id, @revenue)");
									$revenue_query = $conn->query("SELECT @revenue AS tournament_revenue");
									$revenue_result = $revenue_query->fetch_assoc();
									$tournament_revenue = $revenue_result['tournament_revenue'];
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										 <p>Tournament: <b><?php echo ucwords($row['name']) ?></b></p>
										 <p><small>Schedule: <b><?php echo date("M d,Y h:i A", strtotime($row['schedule'])) ?></b></small></p>
									</td>
									<td class="text-center">
										<?php echo $registration_count ?> <!-- Displays number of teams registered -->
									</td>
									<td class="text-center">
										<?php echo number_format($tournament_revenue, 2) ?> <!-- Displays calculated revenue -->
									</td>
									<td class="text-center">
									<?php
										$currentDate = date('Y-m-d H:i:s');  // Current date and time in MySQL format
										$tournamentDate = $row['schedule'];   // Tournament's scheduled date

										if ($tournamentDate > $currentDate): ?>
											<span class="badge badge-info">Upcoming</span> <!-- Tournament is in the future -->
									<?php elseif ($tournamentDate <= $currentDate && strtotime($tournamentDate) > strtotime("-1 day")): ?>
											<span class="badge badge-primary">Ongoing</span> <!-- Tournament is ongoing (today or future) -->
									<?php else: ?>
											<span class="badge badge-success">Completed</span> <!-- Tournament date has passed -->
									<?php endif; ?>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-outline-primary edit_registration" type="button" data-id="<?php echo $row['id'] ?>" >Edit</button>
										<?php if(in_array($row['status'],array(0,2))): ?>
										<button class="btn btn-sm btn-outline-danger delete_registration" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
										<?php endif; ?>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	
</div>

<style>
	td {
		vertical-align: middle !important;
	}
	td p {
		margin: unset;
	}
	img {
		max-width: 100px;
		max-height: 150px;
	}
</style>

<script>
	$(document).ready(function() {
		$('table').dataTable();
	});
	
	$('#new_registration').click(function() {
		uni_modal("New Tournament Registration", "manage_register.php");
	});
	
	$('.edit_registration').click(function() {
		uni_modal("Edit Registration Details", "manage_register.php?id=" + $(this).attr('data-id'));
	});
	
	$('.delete_registration').click(function() {
		_conf("Are you sure to delete this registration?", "delete_registration", [$(this).attr('data-id')]);
	});

	function delete_registration(id) {
		start_load();
		$.ajax({
			url: 'ajax.php?action=delete_registration',
			method: 'POST',
			data: { id: id },
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully deleted", 'success');
					setTimeout(function() {
						location.reload();
					}, 1500);
				}
			}
		});
	}
</script>
