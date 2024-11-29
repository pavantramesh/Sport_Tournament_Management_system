
<style>
	.collapse a{
		text-indent:10px;
	}
	nav#sidebar{
		background: url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>) !important
	}
</style>

<nav id="sidebar" class='mx-lt-5 bg-dark' >
		
		<div class="sidebar-list">
				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
				<a href="index.php?page=Tournament_List" class="nav-item nav-Tournament_List"><span class='icon-field'><i class="fa fa-th-list"></i></span> Tournament Registrarions List</a>
				<a href="index.php?page=Team_info" class="nav-item nav-Team_info"><span class='icon-field'><i class="fa fa-th-list"></i></span> Tournament Team Info</a>
				<a href="index.php?page=venue" class="nav-item nav-venue"><span class='icon-field'><i class="fa fa-map-marked-alt"></i></span> Venues</a>
				<a href="index.php?page=matches" class="nav-item nav-matches"><span class='icon-field'><i class="fa fa-calendar"></i></span> Matches</a>
				<a href="index.php?page=match_results" class="nav-item nav-match_results"><span class='icon-field'></span> Results</a>
				<?php if($_SESSION['login_type'] == 1): ?>
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
				<a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-cogs"></i></span> System Settings</a>
			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
