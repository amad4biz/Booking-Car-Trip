<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>XpressShuttles - Admin<?php $title_for_layout ?></title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<?php
			$cssFiles = array('','bootstrap.min',   'ace.min', 
								'ace-skins.min', 'ace-rtl.min', 'fullcalendar' , 'datepicker',
								'bootstrap-timepicker','lte_IE' => array('ace-ie.min', 'ace-part2.min'));
			foreach($cssFiles as $key => $file){
				if($key != 'lte_IE'){
					echo '<link rel="stylesheet" href="/app/admin/assets/css/'.$file.'.css" />' . "\n";
				}else{
					echo '<!--[if lte IE 9]>';
					/* foreach($file as $IE_file){
						echo '<link rel="stylesheet" href="/app/admin/assets/css/'.$IE_file.'.css" />' . "\n";
					} */
					echo '<![endif]-->';
				}
			}
			
		?>
		<?php
		echo  print_OctHeaderFooterCSSJS('header_js');
		echo  print_OctHeaderFooterCSSJS('header_css');
		?>
		<style>
			.skin-3 .page-content { background-color: #fff; }
			.req, .help-block{ color: red; }
			.dataTables_processing{
				display: block;
				z-index: 99999;
				position: absolute;
				width: 100%;
				height: 100%;
				text-align: center;
				top: 0;
				left: 0;
			}
			.form-group input:disabled, .form-group input[disabled],
			.form-group textarea[disabled], .form-group select[disabled]{background-color:#efefef !important;color:#000000  !important;}
		</style>
	</head>

<body class="skin-3 no-skin">

<!-- #section:basics/navbar.layout -->
		<div id="navbar" class="navbar navbar-default">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<!-- #section:basics/sidebar.mobile.toggle -->
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<!-- /section:basics/sidebar.mobile.toggle -->
				<div class="navbar-header pull-left">
					<!-- #section:basics/navbar.layout.brand -->
					<a href="#" class="navbar-brand">
						<small>
							<i class="fa fa-leaf"></i>
							XpressShuttles - Admin
						</small>
					</a>

					<!-- /section:basics/navbar.layout.brand -->

					<!-- #section:basics/navbar.toggle -->

					<!-- /section:basics/navbar.toggle -->
				</div>

				<!-- #section:basics/navbar.dropdown -->
				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<!--<li class="grey">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-tasks"></i>
								<span class="badge badge-grey">4</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-check"></i>
									4 Tasks to complete
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">Software Update</span>
											<span class="pull-right">65%</span>
										</div>

										<div class="progress progress-mini">
											<div style="width:65%" class="progress-bar"></div>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">Hardware Upgrade</span>
											<span class="pull-right">35%</span>
										</div>

										<div class="progress progress-mini">
											<div style="width:35%" class="progress-bar progress-bar-danger"></div>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">Unit Testing</span>
											<span class="pull-right">15%</span>
										</div>

										<div class="progress progress-mini">
											<div style="width:15%" class="progress-bar progress-bar-warning"></div>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">Bug Fixes</span>
											<span class="pull-right">90%</span>
										</div>

										<div class="progress progress-mini progress-striped active">
											<div style="width:90%" class="progress-bar progress-bar-success"></div>
										</div>
									</a>
								</li>

								<li class="dropdown-footer">
									<a href="#">
										See tasks with details
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="purple">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-bell icon-animated-bell"></i>
								<span class="badge badge-important">8</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-exclamation-triangle"></i>
									8 Notifications
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>
												New Comments
											</span>
											<span class="pull-right badge badge-info">+12</span>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<i class="btn btn-xs btn-primary fa fa-user"></i>
										Bob just signed up as an editor ...
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-success fa fa-shopping-cart"></i>
												New Orders
											</span>
											<span class="pull-right badge badge-success">+8</span>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-info fa fa-twitter"></i>
												Followers
											</span>
											<span class="pull-right badge badge-info">+11</span>
										</div>
									</a>
								</li>

								<li class="dropdown-footer">
									<a href="#">
										See all notifications
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="green">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-envelope icon-animated-vertical"></i>
								<span class="badge badge-success">5</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-envelope-o"></i>
									5 Messages
								</li>

								<li class="dropdown-content">
									<ul class="dropdown-menu dropdown-navbar">
										<li>
											<a href="#">
												<img src="/app/admin/assets/avatars/avatar.png" class="msg-photo" alt="Alex's Avatar" />
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">Alex:</span>
														Ciao sociis natoque penatibus et auctor ...
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>a moment ago</span>
													</span>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<img src="/app/admin/assets/avatars/avatar3.png" class="msg-photo" alt="Susan's Avatar" />
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">Susan:</span>
														Vestibulum id ligula porta felis euismod ...
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>20 minutes ago</span>
													</span>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<img src="/app/admin/assets/avatars/avatar4.png" class="msg-photo" alt="Bob's Avatar" />
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">Bob:</span>
														Nullam quis risus eget urna mollis ornare ...
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>3:15 pm</span>
													</span>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<img src="/app/admin/assets/avatars/avatar2.png" class="msg-photo" alt="Kate's Avatar" />
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">Kate:</span>
														Ciao sociis natoque eget urna mollis ornare ...
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>1:33 pm</span>
													</span>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<img src="/app/admin/assets/avatars/avatar5.png" class="msg-photo" alt="Fred's Avatar" />
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">Fred:</span>
														Vestibulum id penatibus et auctor  ...
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>10:09 am</span>
													</span>
												</span>
											</a>
										</li>
									</ul>
								</li>

								<li class="dropdown-footer">
									<a href="inbox.html">
										See all messages
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>-->

						<!-- #section:basics/navbar.user_menu -->
						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="/app/admin/assets/avatars/avatar2.png" alt="Photo" />
								<span class="user-info">
									<small>Welcome,</small>
											<?php 
										echo $this->session->userdata('userdata')->firstName;
									?>
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
							

								<li>
									<a href="/app/admin/index.php/login/logout">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>

						<!-- /section:basics/navbar.user_menu -->
					</ul>
				</div>

				<!-- /section:basics/navbar.dropdown -->
			</div><!-- /.navbar-container -->
		</div>

		<!-- /section:basics/navbar.layout -->
		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<!-- #section:basics/sidebar -->
			<div id="sidebar" class="sidebar                  responsive">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>
				
				<ul class="nav nav-list">
					<li class="<?php if($this->session->userdata("menuItem") == 'Dashboard'){echo'active';} ?>">
						<a href="/app/admin/">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="<?php if($this->session->userdata("menuItem") == 'Reservations'){echo'active';} ?>">
						<a href="/app/admin/index.php/reservation">
							<i class="menu-icon fa fa-calendar"></i>
							<span class="menu-text"> Reservations </span>
						</a>
						<b class="arrow"></b>
					</li>
					<!-- 
					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-calendar"></i>
							<span class="menu-text"> Reservations </span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="/app/admin/index.php/allreservations" class="">
									<i class="menu-icon fa fa-caret-right"></i>
									All							
								</a>
							</li>
							<li class="">
								<a href="/app/admin/index.php/currentreservations" class="">
									<i class="menu-icon fa fa-caret-right"></i>
									Current
								</a>
							</li>
							<li class="">
								<a href="/app/admin/index.php/pastreservations" class="">
									<i class="menu-icon fa fa-caret-right"></i>
									Past									
								</a>
							</li>
						</ul>
					</li>
					 -->
					
					<!-- 
					<li class="dropdown-toggle <?php if($this->session->userdata("menuItem") == 'Drivers'){echo'active';} ?>">
						<a href="/app/admin/index.php/driver">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Drivers </span>
						</a>

						<b class="arrow"></b>
						<ul class="submenu">
							<li class="">
								<a href="/app/admin/index.php/drivercompensation" class="">
									<i class="menu-icon fa fa-caret-right"></i>
									Compensation	
								</a>
								<b class="arrow fa fa-angle-down"></b>
							</li>
						</ul>
					</li>
					 -->
					 <li class="<?php if($this->session->userdata("menuItem") == 'Drivers'){echo'active';} ?>">
						<a href="/app/admin/index.php/driver">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Drivers </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="<?php if($this->session->userdata("menuItem") == 'Vehicles'){echo'active';} ?>">
						<a href="/app/admin/index.php/vehicle">
							<i class="menu-icon fa fa-truck"></i>
							<span class="menu-text"> Vehicles </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="<?php if($this->session->userdata("menuItem") == 'Reports'){echo'active';} ?>">
						<a href="/app/admin/index.php/reports">
							<i class="menu-icon fa fa-suitcase"></i>
							<span class="menu-text"> Reports </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="<?php if($this->session->userdata("menuItem") == 'Staff'){echo'active';} ?>">
						<a href="/app/admin/index.php/staff">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text"> Staff </span>
						</a>

						<b class="arrow"></b>
					</li>
					<!-- 
					<li class="<?php if($this->session->userdata("menuItem") == 'Auto Emails'){echo'active';} ?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Settings </span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>
						<ul class="submenu">
							<li class="">
								<a href="/app/admin/index.php/autoemails" class="">
									<i class="menu-icon fa fa-caret-right"></i>
									Auto Emails	
								</a>
							</li>
						</ul>
					</li>
					 -->
					 <li class="<?php if($this->session->userdata("menuItem") == 'Auto Emails'){echo'active';} ?>">
						<a href="/app/admin/index.php/autoemails">
							<i class="menu-icon fa fa-envelope"></i>
							<span class="menu-text"> Auto Emails	 </span>
						</a>

						<b class="arrow"></b>
					</li>
				</ul><!-- /.nav-list -->

				<!-- #section:basics/sidebar.layout.minimize -->
				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>

				<!-- /section:basics/sidebar.layout.minimize -->
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>

			<!-- /section:basics/sidebar -->
			<div class="main-content">
			<!-- #section:basics/content.breadcrumbs -->
				<div class="breadcrumbs" id="breadcrumbs">
					<script type="text/javascript">
						try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
					</script>

					<ul class="breadcrumb">
						<li>
							<i class="ace-icon fa fa-home home-icon"></i>
							<a href="#">Home</a>
						</li>						
						<li class="active"><?php echo $this->session->userdata("breadcrumb"); ?></li>
						
					</ul><!-- /.breadcrumb -->

					<!-- #section:basics/content.searchbox -->
					<div class="nav-search" id="nav-search">
						
					</div><!-- /.nav-search -->

					<!-- /section:basics/content.searchbox -->
				</div>

				<!-- /section:basics/content.breadcrumbs -->
				<div class="page-content">
					<div class="page-content-area">
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
					