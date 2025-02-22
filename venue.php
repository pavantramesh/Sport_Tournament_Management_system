<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>List of Tournaments</b>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<!-- <colgroup>
								<col width="5%">
								<col width="15%">
								<col width="40%">
								<col width="15%">
								<col width="10%">
								<col width="15%">
							</colgroup> -->
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Tournament Name</th>
									<th class="">Location</th>
									<th class="">description</th>
									<th class="">entry fee</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$venue = $conn->query("SELECT * from tournaments");
								while($row=$venue->fetch_assoc()):
									$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
									unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									
									<td class="">
										 <p> <b><?php echo ucwords($row['name']) ?></b></p>
									</td>
									<td class="">
										 <p class=""><?php echo $row['venue'] ?></p>
									</td>
									<td class="">
										 <p class="truncate"><?php echo $row['description'] ?></p>
									</td>
									<td class="">
										 <p class="text-right"><?php echo number_format($row['registration_fee'],2) ?></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-outline-primary edit_venue" type="button" data-id="<?php echo $row['id'] ?>" >Edit</button>
										<button class="btn btn-sm btn-outline-danger delete_venue" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height: :150px;
	}
</style>
<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
	$('.edit_venue').click(function(){
		location.href ="index.php?page=manage_venue&id="+$(this).attr('data-id')
		
	})
	$('.delete_venue').click(function(){
		_conf("Are you sure to delete this venue?","delete_venue",[$(this).attr('data-id')])
	})
	
	function delete_venue($id){
		stvenue_load()
		$.ajax({
			url:'ajax.php?action=delete_venue',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>