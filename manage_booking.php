<?php 
include('db_connect.php');

if(isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM tournament_registration WHERE id = ".$_GET['id']);
    foreach($qry->fetch_assoc() as $k => $v) {
        $$k = $v;
    }
}
?>

<div class="container-fluid">
    <form action="" id="manage-registration">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="form-group">
            <label for="tournament_id">Select Tournament</label>
            <select name="tournament_id" id="tournament_id" class="custom-select" required>
                <option value="" disabled <?php echo !isset($tournament_id) ? "selected" : "" ?>>-- Select Tournament --</option>
                <?php 
                $tournaments = $conn->query("SELECT id, name FROM tournaments ORDER BY name ASC");
                while($row = $tournaments->fetch_assoc()):
                ?>
                <option value="<?php echo $row['id'] ?>" 
                    <?php echo isset($tournament_id) && $tournament_id == $row['id'] ? "selected" : "" ?>>
                    <?php echo $row['name'] ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="player_name">Team Captain Name</label>
            <input type="text" name="player_name" id="player_name" class="form-control" 
                   value="<?php echo isset($player_name) ? $player_name : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Captain Email</label>
            <input type="email" name="email" id="email" class="form-control" 
                   value="<?php echo isset($email) ? $email : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="contact">Contact</label>
            <input type="text" name="contact" id="contact" class="form-control" 
                   value="<?php echo isset($contact) ? $contact : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="address">Captain Address</label>
            <textarea name="address" id="address" class="form-control" required><?php echo isset($address) ? $address : '' ?></textarea>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="custom-select" required>
                <option value="0" <?php echo isset($status) && $status == 0 ? "selected" : "" ?>>Pending Verification</option>
                <option value="1" <?php echo isset($status) && $status == 1 ? "selected" : "" ?>>Confirmed</option>
                <option value="2" <?php echo isset($status) && $status == 2 ? "selected" : "" ?>>Cancelled</option>
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-block" type="submit">Save</button>
        </div>
    </form>
</div>

<script>
    $('#manage-registration').submit(function(e) {
        e.preventDefault();
        start_load(); // Optional function to show a loading spinner
        $.ajax({
            url: 'ajax.php?action=save_registration',
            method: 'POST',
            data: $(this).serialize(),
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully saved", 'success'); // Optional toast notification
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            }
        });
    });
</script>
