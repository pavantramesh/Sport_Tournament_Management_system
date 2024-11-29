

<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tournament_name = $_POST['tournament_name'];
    $description = $_POST['description'];
    $schedule = $_POST['schedule'];
    $registration_fee = $_POST['registration_fee'];
    $venue = $_POST['venue'];
    $max_players = $_POST['max_players'];
    $status = $_POST['status'];

    try {
        $stmt = $conn->prepare("INSERT INTO tournaments (name, description, schedule, registration_fee, venue, max_players, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssis", $tournament_name, $description, $schedule, $registration_fee, $venue, $max_players, $status);
        $stmt->execute();
        $stmt->close();

        header("Location: tournament_list.php");
        exit;
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row mb-4 mt-4">
            <div class="col-md-12">
                <h3>Create New Tournament Registration</h3>
            </div>
        </div>

        <form method="POST" action="manage_register.php">
            <div class="form-group">
                <label for="tournament_name">Tournament Name</label>
                <input type="text" name="tournament_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Tournament Description</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="schedule">Tournament Schedule</label>
                <input type="datetime-local" name="schedule" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="registration_fee">Registration Fee</label>
                <input type="number" name="registration_fee" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="venue">Venue</label>
                <input type="text" name="venue" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="max_players">Max Players</label>
                <input type="number" name="max_players" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control">
                    <option value="Open">Open</option>
                    <option value="Closed">Closed</option>
                </select>
            </div>

            
        </form>
    </div>
</div>
