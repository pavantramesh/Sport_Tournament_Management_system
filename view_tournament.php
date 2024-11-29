<?php include 'admin/db_connect.php' ?> 
<?php  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {     
    $tournament_id = $_POST['tournament_id'];     
    $player_name = $_POST['player_name'];     
    $email = $_POST['email'];     
    $contact = $_POST['contact'];     
    $address = $_POST['address'];     
    $status = $_POST['status'];      

    try {         
        $stmt = $conn->prepare("INSERT INTO tournament_registration (tournament_id, player_name, email, contact, address, status) VALUES (?, ?, ?, ?, ?, ?)");         
        $stmt->bind_param("isssss", $tournament_id, $player_name, $email, $contact, $address, $status);                 
        $stmt->execute();         
        $stmt->close();          

        header("Location: view_tournament.php");         
        exit;     
    } catch (mysqli_sql_exception $e) {         
        echo "Error: " . $e->getMessage();     
    } 
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Registration</title>
    <!-- Add CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container-fluid {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h3 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 4px rgba(0, 123, 255, 0.25);
            outline: none;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        textarea.form-control {
            resize: none;
            height: 100px;
        }
        select.form-control {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row mb-4 mt-4">
                <div class="col-md-12">
                    <h3>Tournament Registration</h3>
                </div>
            </div>
            <form method="POST" action="view_tournament.php">
                <div class="form-group">
                    <label for="tournament_id">Select Tournament</label>
                    <select name="tournament_id" class="form-control" required>
                        <option value="" disabled selected>-- Select Tournament --</option>
                        <?php
                        $tournaments = $conn->query("SELECT id, name FROM tournaments ORDER BY name ASC");
                        while ($row = $tournaments->fetch_assoc()) :
                        ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="player_name">Team Captain Name</label>
                    <input type="text" name="player_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Captain Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="contact">Contact Number</label>
                    <input type="text" name="contact" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="address">Captain Address</label>
                    <textarea name="address" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="status">Registration Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Pending Verification">Pending Verification</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
