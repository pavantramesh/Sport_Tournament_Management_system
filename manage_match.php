<?php include('db_connect.php'); ?>
<?php 
if(isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM matches WHERE id = {$_GET['id']}");
    $match = $qry->fetch_assoc();
}
?>
<div class="container-fluid">
    <div class="col-lg-12">
        <form action="" id="manage-match">
            <input type="hidden" name="id" value="<?php echo isset($match['id']) ? $match['id'] : '' ?>">
            <div class="form-group">
                <label for="date">Match Date</label>
                <input type="datetime-local" name="date" id="date" class="form-control" value="<?php echo isset($match['date']) ? date('Y-m-d\TH:i', strtotime($match['date'])) : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="venue_id">Venue</label>
                <select name="venue_id" id="venue_id" class="custom-select" required>
                    <option value="" disabled selected>Select Venue</option>
                    <?php
                    $venues = $conn->query("SELECT * FROM venue");
                    while($row = $venues->fetch_assoc()):
                    ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo isset($match['venue_id']) && $match['venue_id'] == $row['id'] ? 'selected' : '' ?>>
                            <?php echo ucwords($row['venue']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="team1_id">Team 1</label>
                <select name="team1_id" id="team1_id" class="custom-select" required>
                    <option value="" disabled selected>Select Team 1</option>
                    <?php
                    $teams = $conn->query("SELECT * FROM team_registration WHERE status = 1");
                    while($row = $teams->fetch_assoc()):
                    ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo isset($match['team1_id']) && $match['team1_id'] == $row['id'] ? 'selected' : '' ?>>
                            <?php echo ucwords($row['team_name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="team2_id">Team 2</label>
                <select name="team2_id" id="team2_id" class="custom-select" required>
                    <option value="" disabled selected>Select Team 2</option>
                    <?php
                    $teams = $conn->query("SELECT * FROM team_registration WHERE status = 1");
                    while($row = $teams->fetch_assoc()):
                    ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo isset($match['team2_id']) && $match['team2_id'] == $row['id'] ? 'selected' : '' ?>>
                            <?php echo ucwords($row['team_name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Match Description</label>
                <textarea name="description" id="description" cols="30" rows="3" class="form-control" required><?php echo isset($match['description']) ? $match['description'] : '' ?></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-sm" type="submit">Save</button>
                <button class="btn btn-secondary btn-sm" type="button" onclick="location.href='index.php?page=matches'">Cancel</button>
            </div>
        </form>
    </div>
</div>
<script>
    $('#manage-match').submit(function(e) {
        e.preventDefault();
        start_load();
        $.ajax({
            url: 'ajax.php?action=save_match',
            method: 'POST',
            data: $(this).serialize(),
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Match successfully saved", 'success');
                    setTimeout(function() {
                        location.href = 'index.php?page=matches';
                    }, 1500);
                }
            }
        });
    });
</script>
