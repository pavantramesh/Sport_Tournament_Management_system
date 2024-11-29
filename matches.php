<?php include('db_connect.php'); ?>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row mb-4 mt-4">
            <div class="col-md-12"></div>
        </div>
        <div class="row">
            <!-- Table Panel -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>List of Matches</b>
                        <span class="float:right">
                            <a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="index.php?page=manage_match" id="new_match">
                                <i class="fa fa-plus"></i> New Match
                            </a>
                        </span>
                    </div>
                    <div class="card-body">
                        <table class="table table-condensed table-bordered table-hover">
                            <colgroup>
                                <col width="5%">
                                <col width="20%">
                                <col width="20%">
                                <col width="20%">
                                <col width="25%">
                                <col width="10%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="">Match Date</th>
                                    <th class="">Venue</th>
                                    <th class="">Teams</th>
                                    <th class="">Description</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $matches = $conn->query("SELECT 
                                                            m.id,
                                                            m.date,
                                                            v.venue,
                                                            t1.team_name as team1_name,
                                                            t2.team_name as team2_name,
                                                            m.description 
                                                        FROM matches m 
                                                        INNER JOIN venue v ON v.id = m.venue_id 
                                                        INNER JOIN team_registration t1 ON t1.id = m.team1_id 
                                                        INNER JOIN team_registration t2 ON t2.id = m.team2_id 
                                                        ORDER BY m.id ASC");
                                while ($row = $matches->fetch_assoc()):
                                    $desc = strip_tags($row['description']);
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td>
                                        <p><b><?php echo date("M d, Y h:i A", strtotime($row['date'])) ?></b></p>
                                    </td>
                                    <td>
                                        <p><b><?php echo ucwords($row['venue']) ?></b></p>
                                    </td>
                                    <td>
                                        <p><b><?php echo ucwords($row['team1_name']) ?> vs <?php echo ucwords($row['team2_name']) ?></b></p>
                                    </td>
                                    <td>
                                        <p class="truncate"><?php echo $desc ?></p>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary view_match" type="button" data-id="<?php echo $row['id'] ?>">View</button>
                                        <button class="btn btn-sm btn-outline-primary edit_match" type="button" data-id="<?php echo $row['id'] ?>">Edit</button>
                                        <button class="btn btn-sm btn-outline-danger delete_match" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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

    $('.view_match').click(function() {
        location.href = "index.php?page=view_match&id=" + $(this).attr('data-id');
    });
    $('.edit_match').click(function() {
        location.href = "index.php?page=manage_match&id=" + $(this).attr('data-id');
    });
    $('.delete_match').click(function() {
        _conf("Are you sure to delete this match?", "delete_match", [$(this).attr('data-id')]);
    });

    function delete_match($id) {
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_match',
            method: 'POST',
            data: { id: $id },
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
