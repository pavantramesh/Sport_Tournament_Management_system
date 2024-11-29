<?php 
include 'admin/db_connect.php'; 
?>
<style>
    #portfolio .img-fluid{
        width: calc(100%);
        height: 30vh;
        z-index: -1;
        position: relative;
        padding: 1em;
    }
    .event-list{
        cursor: pointer;
    }
    span.highlight{
        background: yellow;
    }
    .banner{
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 26vh;
        width: calc(30%);
    }
    .banner img{
        width: calc(100%);
        height: calc(100%);
        cursor :pointer;
    }
    .event-list{
        cursor: pointer;
        border: unset;
        flex-direction: inherit;
    }
    .event-list .banner {
        width: calc(40%)
    }
    .event-list .card-body {
        width: calc(60%)
    }
    .event-list .banner img {
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        min-height: 50vh;
    }
    span.highlight{
        background: yellow;
    }
    .banner{
        min-height: calc(100%)
    }
</style>

<header class="masthead">
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end mb-4 page-title">
                <h3 class="text-white">Welcome to Sports Tournament System</h3>
                <hr class="divider my-4" />

                <div class="col-md-12 mb-2 justify-content-center">
                </div>                        
            </div>
        </div>
    </div>
</header>

<div class="container mt-3 pt-2">
    <h4 class="text-center text-white">Upcoming Tournaments</h4>
    <hr class="divider">

    <?php
    // Query to fetch upcoming tournaments
    $tournaments = $conn->query("
        SELECT * 
        FROM tournaments 
        WHERE DATE(schedule) >= '" . date('Y-m-d') . "' 
        AND status = 'Open' 
        ORDER BY schedule ASC
    ");
    
    // Loop through the fetched tournaments
    while ($row = $tournaments->fetch_assoc()):
        // Sanitize description for display
        $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
        unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
        $desc = strtr(html_entity_decode($row['description']), $trans);
        $desc = str_replace(array("<li>", "</li>"), array("", ","), $desc);
    ?>
    <div class="card tournament-list" data-id="<?php echo $row['id'] ?>">
        <div class='banner'>
            <!-- Optional: Add a tournament-specific banner here -->
        </div>
        <div class="card-body">
            <div class="row align-items-center justify-content-center text-center h-100">
                <div class="">
                    <h3><b class="filter-txt"><?php echo ucwords($row['name']) ?></b></h3>
                    <div><small><p><b><i class="fa fa-calendar"></i> <?php echo date("F d, Y h:i A", strtotime($row['schedule'])) ?></b></p></small></div>
                    <hr>
                    <larger class="truncate filter-txt"><?php echo strip_tags($desc) ?></larger>
                    <br>
                    <hr class="divider" style="max-width: calc(80%)">
                    <button class="btn btn-primary float-right register-btn" data-tournament-id="<?php echo $row['id'] ?>">Register</button>
                </div>
            </div>
        </div>
    </div>
    <br>
    <?php endwhile; ?>
</div>

<script>
    // Handle the Register button click
    $('.register-btn').click(function() {
        var tournamentId = $(this).data('tournament-id');
        // Redirect to the registration page for the selected tournament
        location.href = "view_tournament.php?id=" + tournamentId;
    });

    $('.banner img').click(function(){
        viewer_modal($(this).attr('src'));
    });

    $('#filter').keyup(function(e){
        var filter = $(this).val();

        $('.card.event-list .filter-txt').each(function(){
            var txto = $(this).html();
            txt = txto;
            if((txt.toLowerCase()).includes((filter.toLowerCase())) == true){
                $(this).closest('.card').toggle(true);
            }else{
                $(this).closest('.card').toggle(false);
            }
        });
    });
</script>
