<?php 
include('db_connect.php');
session_start();
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM users where id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-user">	
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required  autocomplete="off">
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
			<?php if(isset($meta['id'])): ?>
			<small><i>Leave this blank if you dont want to change the password.</i></small>
		<?php endif; ?>
		</div>
		<?php if(!isset($_GET['mtype'])): ?>
		<div class="form-group">
			<label for="type">User Type</label>
			<select name="type" id="type" class="custom-select">
				<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected': '' ?>>player</option>
				<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected': '' ?>>Admin</option>
			</select>
		</div>
		<?php endif; ?>
		

	</form>
</div>
<script>
    
    // Use AJAX to submit the form data
    $.ajax({
        url: 'ajax.php?action=save_user', // Backend endpoint to handle the request
        method: 'POST',
        data: $(this).serialize(), // Serialize form data
        success: function (resp) {
            // Check response to handle different scenarios
            if (resp == 1) { 
                alert_toast("Data successfully saved", 'success'); // Show success message
                setTimeout(function () {
                    location.reload(); // Reload the page after 1.5 seconds
                }, 1500);
            } else if (resp == 2) {
                $('#msg').html('<div class="alert alert-danger">Username already exists</div>'); // Error message
                end_load(); // End the loading indicator
            } else {
                $('#msg').html('<div class="alert alert-danger">An error occurred while saving the user information.</div>'); // Generic error message
                end_load();
            }
        },
        error: function () {
            $('#msg').html('<div class="alert alert-danger">An unexpected error occurred. Please try again later.</div>'); // Handle AJAX errors
            end_load();
        }

		})

</script>