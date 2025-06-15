<?php include('header.php'); ?>
<style>
	body {
		background: none !important;
	}

	body#login::before {
		content: "";
		background: url(admin/images/indexx.jpg) no-repeat center center fixed;
		background-size: cover;
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		z-index: -2;
	}

	body#login::after {
		content: "";
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.5); /* efek gelap */
		z-index: -1;
	}

	/* CSS untuk memusatkan navigasi link.php */
	.index-footer .nav-collapse {
		text-align: center;
	}
	
	.index-footer .nav {
		display: inline-block;
		float: none !important;
		margin: 0 auto;
	}
	
	/* Memberikan jarak untuk navigasi */
	.index-footer {
		margin-top: 60px;
		margin-bottom: 40px;
	}
	
	/* Memberikan ruang untuk konten utama */
	.content-area {
		padding-top: 50px;
	}
</style>

<body id="login">
	<div class="container content-area" style="position: relative">
		<div class="row-fluid">
			<div class="span6">
				<div class="title_index">
					<?php include('title_index.php'); ?>
				</div>
			</div>
			<div class="span6">
				<div class="pull-right">
					<?php include('signup_teacher_form.php'); ?>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<div class="index-footer">
					<?php include('link.php'); ?>
				</div>
			</div>
		</div>
	</div>
	
	<?php include('footer.php'); ?>
<?php include('script.php'); ?>
</body>
</html>