<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();

if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == "save_settings"){
	$save = $crud->save_settings();
	if($save)
		echo $save;
}
if($action == "save_venue"){
	$save = $crud->save_venue();
	if($save)
		echo $save;
}
if($action == "save_book"){
	$save = $crud->save_book();
	if($save)
		echo $save;
}
if($action == "delete_book"){
	$save = $crud->delete_book();
	if($save)
		echo $save;
}

if($action == "save_register"){
	$save = $crud->save_register();
	if($save)
		echo $save;
}
if($action == "delete_register"){
	$save = $crud->delete_register();
	if($save)
		echo $save;
}
if($action == "delete_venue"){
	$save = $crud->delete_venue();
	if($save)
		echo $save;
}
if($action == "update_order"){
	$save = $crud->update_order();
	if($save)
		echo $save;
}
if($action == "delete_order"){
	$save = $crud->delete_order();
	if($save)
		echo $save;
}
if($action == "save_event"){
	$save = $crud->save_event();
	if($save)
		echo $save;
}
if($action == "delete_event"){
	$save = $crud->delete_event();
	if($save)
		echo $save;
}
if($action == "save_artist"){
	$save = $crud->save_artist();
	if($save)
		echo $save;
}
if($action == "delete_artist"){
	$save = $crud->delete_artist();
	if($save)
		echo $save;
}
if($action == "get_audience_report"){
	$get = $crud->get_audience_report();
	if($get)
		echo $get;
}
if($action == "get_venue_report"){
	$get = $crud->get_venue_report();
	if($get)
		echo $get;
}
if($action == "save_art_fs"){
	$save = $crud->save_art_fs();
	if($save)
		echo $save;
}
if($action == "delete_art_fs"){
	$save = $crud->delete_art_fs();
	if($save)
		echo $save;
}
if($action == "get_pdetails"){
	$get = $crud->get_pdetails();
	if($get)
		echo $get;
}
if(isset($_POST['action']) && $_POST['action'] == 'save_match') {
    $id = $_POST['id'];
    $data = " date = '{$_POST['date']}', 
              venue_id = '{$_POST['venue_id']}', 
              team1_id = '{$_POST['team1_id']}', 
              team2_id = '{$_POST['team2_id']}', 
              description = '{$_POST['description']}' ";
    if(empty($id)) {
        $save = $conn->query("INSERT INTO matches SET $data");
    } else {
        $save = $conn->query("UPDATE matches SET $data WHERE id = $id");
    }
    if($save) echo 1;
}
if (isset($_POST['action']) && $_POST['action'] == 'save_match') {
    $id = $_POST['id'];
    $date = $_POST['date'];
    $venue_id = $_POST['venue_id'];
    $team1_id = $_POST['team1_id'];
    $team2_id = $_POST['team2_id'];
    $description = $_POST['description'];
    $tournament_id = $_POST['tournament_id'];
    $winner = $_POST['winner'];

    if (empty($id)) {
        // Insert new match
        $conn->query("INSERT INTO matches (date, venue_id, team1_id, team2_id, description, tournament_id, winner)
                      VALUES ('$date', '$venue_id', '$team1_id', '$team2_id', '$description', '$tournament_id', '$winner')");
    } else {
        // Update existing match
        $conn->query("UPDATE matches SET date = '$date', venue_id = '$venue_id', team1_id = '$team1_id',
                      team2_id = '$team2_id', description = '$description', tournament_id = '$tournament_id',
                      winner = '$winner' WHERE id = $id");
    }

    echo 1; // Success
}



if ($_GET['action'] == 'save_registration') {
    $data = "";
    foreach ($_POST as $key => $value) {
        $value = $conn->real_escape_string($value);
        $data .= "$key='$value', ";
    }
    $data = rtrim($data, ", ");

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Update existing registration
        $id = $_POST['id'];
        $query = "UPDATE tournament_registration SET $data WHERE id = $id";
    } else {
        // Insert new registration
        $query = "INSERT INTO tournament_registration SET $data";
    }

    if ($conn->query($query)) {
        echo 1; // Success response
    } else {
        echo $conn->error; // Error response
    }
}


if (isset($_POST['action']) && $_POST['action'] == 'save_registration') {
    // Check if it's a new registration or updating an existing one
    if (!empty($_POST['id'])) {
        // Update existing registration
        $stmt = $conn->prepare("UPDATE tournament_registration SET tournament_id = ?, player_name = ?, email = ?, contact = ?, address = ?, status = ? WHERE id = ?");
        $stmt->bind_param("issssii", $_POST['tournament_id'], $_POST['player_name'], $_POST['email'], $_POST['contact'], $_POST['address'], $_POST['status'], $_POST['id']);
        $stmt->execute();
        $stmt->close();
    } else {
        // Insert new registration
        $stmt = $conn->prepare("INSERT INTO tournament_registration (tournament_id, player_name, email, contact, address, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssi", $_POST['tournament_id'], $_POST['player_name'], $_POST['email'], $_POST['contact'], $_POST['address'], $_POST['status']);
        $stmt->execute();
        $stmt->close();
    }
    echo 1; // Successfully saved
}
?>