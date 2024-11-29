<?php 
include('db_connect.php');
?>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row mb-4 mt-4">
            <div class="col-md-12">
                <!-- Optional: Add additional content here if needed -->
            </div>
        </div>
        <div class="row">
            <!-- Table Panel -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>Registered Teams</b>
                        <span class="">
                            <button class="btn btn-primary btn-block btn-sm col-sm-2 float-right" type="button" id="new_register">
                                <i class="fa fa-plus"></i> New</button>
                        </span>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="">Tournament Name</th>
                                    <th class="">Team Information</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            $i = 1;
                            // Query to fetch data from tournament_registration and tournaments tables
                            $registrations = $conn->query("SELECT tr.*, 
                                                                t.name AS tournament_name
                                                          FROM tournament_registration tr
                                                          INNER JOIN tournaments t ON t.id = tr.tournament_id");
                            while($row = $registrations->fetch_assoc()):
                            ?>

                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td class="">
                                         <p><b><?php echo ucwords($row['tournament_name']) ?></b></p>
                                    </td>
                                    <td class="">
                                        
                                         <p>Captain Name: <b><?php echo ucwords($row['player_name']) ?></b></p>
                                         <p><small>Email: <b><?php echo $row['email'] ?></b></small></p>
                                         <p><small>Contact: <b><?php echo $row['contact'] ?></b></small></p>
                                         <p><small>Address: <b><?php echo ucwords($row['address']) ?></b></small></p>
                                    </td>
                                    <td class="text-center">
                                         <p><b><?php 
                                         if ($row['status'] == 0) {
                                             echo "Pending Verification";
                                         } elseif ($row['status'] == 1) {
                                             echo "Confirmed";
                                         } else {
                                             echo "Cancelled";
                                         }
                                         ?></b></p>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary edit_register" type="button" data-id="<?php echo $row['id'] ?>">Edit</button>
                                        <button class="btn btn-sm btn-outline-danger delete_register" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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

<script>
    $(document).ready(function(){
        $('table').dataTable(); // Initialize DataTables plugin
    });

    $('#new_register').click(function(){
        uni_modal("New Team Registration", "manage_booking.php");
    });

    $('.edit_register').click(function(){
        uni_modal("Manage Team Registration", "manage_booking.php?id=" + $(this).attr('data-id'));
    });

    $('.delete_register').click(function(){
        _conf("Are you sure to delete this registration?", "delete_register", [$(this).attr('data-id')]);
    });

    function delete_register($id){
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_register',
            method: 'POST',
            data: {id: $id},
            success: function(resp){
                if(resp == 1){
                    alert_toast("Registration successfully deleted", 'success');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>

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
