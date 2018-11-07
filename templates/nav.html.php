<?php include_once __DIR__.'/../includes/constant.php'; ?>
<nav class="navbar navbar-inverse">
	  	<div class="container-fluid">
	    	<div class="navbar-header">
	    		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
	    			<span class="icon-bar"></span>
	    			<span class="icon-bar"></span>
	    			<span class="icon-bar"></span>
	    		</button>
	    		<a class="navbar-brand" href="/">Portal Event</a>
	    	</div>
	    	<div class="collapse navbar-collapse" id="myNavbar">
		    	<ul class="nav navbar-nav">
		    	  	<li class="active"><a href="/">Home</a></li>
		    	  	<?php if(isset($_SESSION['id']) && $_SESSION[MEMBER_HAK_AKSES]==HAK_AKSES_ADMIN): ?>
		    	  		<li><a href="/admin/event.php">Event</a></li>
		    	  		<li><a href="/admin/member.php">Member</a></li>
		    	  	<?php elseif(isset($_SESSION['id']) && $_SESSION[MEMBER_HAK_AKSES]==HAK_AKSES_MEMBER): ?>
		    	  		<li><a href="/member/event.php">Event</a></li>
		    	  	<?php endif ?>
		    	</ul>
		    	<ul class="nav navbar-nav navbar-right">
		    		<?php if(isset($_SESSION['id'])): ?>
		    			<li class="dropdown">
			    	    	<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?= $_SESSION['nama'] ?>
			    	    	<span class="caret"></span></a>
			    	    	<ul class="dropdown-menu">
			    	      		<li><a href="/logout.php">Keluar</a></li>
			    	    	</ul>
			    	  	</li>
		    		<?php else: ?>
			    	  	<li><a href="/signup.php">Daftar</a></li>
			    	  	<li><a href="/login.php">Masuk</a></li>
		    		<?php endif ?>
		    	</ul>
	    	</div>
	  	</div>
	</nav>
