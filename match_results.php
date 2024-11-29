<?php include('db_connect.php'); ?>

<?php
// Fetch all matches
$matches = $conn->query("SELECT m.*, t1.team_name AS team1, t2.team_name AS team2, v.venue FROM matches m
                         JOIN team_registration t1 ON m.team1_id = t1.id
                         JOIN team_registration t2 ON m.team2_id = t2.id
                         JOIN venue v ON m.venue_id = v.id
                         ORDER BY m.date DESC");
?>

<div class="container-fluid">
    <div class="col-lg-12">
        <!-- Table to display match results -->
        <h3>Match Results</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Match Date</th>
                    <th>Tournament</th>
                    <th>Team 1</th>
                    <th>Team 2</th>
                    <th>Venue</th>
                    <th>Winner</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $matches->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo date('d-m-Y H:i', strtotime($row['date'])); ?></td>
                        <td><?php echo ucwords($row['tournament_id']); ?></td>
                        <td><?php echo ucwords($row['team1']); ?></td>
                        <td><?php echo ucwords($row['team2']); ?></td>
                        <td><?php echo ucwords($row['venue']); ?></td>
                        <td><?php echo ucwords($row['winner']); ?></td>
                        <td>
                            <a href="index.php?page=manage_match&id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Edit</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Button to Add Results -->
        <button class="btn btn-primary" onclick="location.href='index.php?page=manage_match'">Add Match Result</button>
    </div>
</div>

<?php
// If 'id' is passed in the URL, fetch match details to edit
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM matches WHERE id = {$_GET['id']}");
    $match = $qry->fetch_assoc();
}
?>

<!-- Form to manage match details -->
<?php if (isset($match)): ?>
<div class="container-fluid">
    <div class="col-lg-12">
        <form action="" id="manage-match">
            <input type="hidden" name="id" value="<?php echo isset($match['id']) ? $match['id'] : '' ?>">

            <!-- Tournament selection -->
            <div class="form-group">
                <label for="tournament_id">Tournament</label>
                <select name="tournament_id" id="tournament_id" class="custom-select" required>
                    <option value="" disabled selected>Select Tournament</option>
                    <?php
                    $tournaments = $conn->query("SELECT * FROM tournaments ORDER BY name ASC");
                    while ($row = $tournaments->fetch_assoc()):
                    ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo isset($match['tournament_id']) && $match['tournament_id'] == $row['id'] ? 'selected' : '' ?>>
                            <?php echo ucwords($row['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Match Date -->
            <div class="form-group">
                <label for="date">Match Date</label>
                <input type="datetime-local" name="date" id="date" class="form-control" value="<?php echo isset($match['date']) ? date('Y-m-d\TH:i', strtotime($match['date'])) : '' ?>" required>
            </div>

            <!-- Venue selection -->
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

            <!-- Team 1 selection -->
            <div class="form-group">
                <label for="team1_id">Team 1</label>
                <select name="team1_id" id="team1_id" class="custom-select" required>
                    <option value="" disabled selected>Select Team 1</option>
                    <?php
                    $teams = $conn->query("SELECT * FROM team_registration WHERE status = 1");
                    while ($row = $teams->fetch_assoc()):
                    ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo isset($match['team1_id']) && $match['team1_id'] == $row['id'] ? 'selected' : '' ?>>
                            <?php echo ucwords($row['team_name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Team 2 selection -->
            <div class="form-group">
                <label for="team2_id">Team 2</label>
                <select name="team2_id" id="team2_id" class="custom-select" required>
                    <option value="" disabled selected>Select Team 2</option>
                    <?php
                    $teams = $conn->query("SELECT * FROM team_registration WHERE status = 1");
                    while ($row = $teams->fetch_assoc()):
                    ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo isset($match['team2_id']) && $match['team2_id'] == $row['id'] ? 'selected' : '' ?>>
                            <?php echo ucwords($row['team_name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Match Description -->
            <div class="form-group">
                <label for="description">Match Description</label>
                <textarea name="description" id="description" cols="30" rows="3" class="form-control" required><?php echo isset($match['description']) ? $match['description'] : '' ?></textarea>
            </div>

            <!-- Winner selection -->
            <div class="form-group">
                <label for="winner">Winner</label>
                <select name="winner" id="winner" class="custom-select" required>
                    <option value="" disabled selected>Select Winner</option>
                    <option value="team1" <?php echo isset($match['winner']) && $match['winner'] == 'team1' ? 'selected' : '' ?>>Team 1</option>
                    <option value="team2" <?php echo isset($match['winner']) && $match['winner'] == 'team2' ? 'selected' : '' ?>>Team 2</option>
                </select>
            </div>

            <!-- Submit button -->
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
<?php endif; ?>
