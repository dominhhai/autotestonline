<?php /*
*@test
*
*/
//var_dump($this->Session->read(array('Auth'=>'kind')));die;
?>
<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie ie8 no-js" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<head>

<link rel="stylesheet" type="text/css" media="all"
	href="http://fonts.googleapis.com/css?family=Open+Sans:300,300italic,regular,italic,600,600italic,700,700italic,800,800italic" />
<?php 
echo $this->Html->charset();
header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
header('Pragma: no-cache'); // HTTP 1.0.
header('Expires: 0'); // Proxies.
?>
<title><?php echo 'テスト '?>: <?php echo $title_for_layout; ?>
</title>
<?php echo $this->Html->meta('icon');
echo $this->Html->css('cake.generic');
echo $this->Html->css('main');
echo $this->Html->css('mediaelementplayer.min');
echo $this->Html->script('jquery-1.8.3.min');
echo $this->Html->script('jquery-ui.js');
echo $this->Html->script('head.min');
echo $this->fetch('css');
echo $this->fetch('meta');
echo $this->fetch('script');
?>

<!--[if IE 8]>

		<?php
		echo $this->Html->css('responsive');
		echo $this->Html->css('ie8');
		echo $this->fetch('css');
		?>
		<![endif]-->

<!--[if gte IE 8]>
		<?php
		echo $this->Html->css('ie');
		echo $this->fetch('css');
		?>
		<![endif]-->

<!--[if IE 8]>

		<?php
		echo $this->Html->script('html5.min');
		echo $this->Html->script('css3-mediaqueries');
		echo $this->Html->script('es5-shim.min');

		echo $this->fetch('script');
		?>
		<![endif]-->

</head>

<body class="home blog" data-branding="brandColor: #f74b00">

	<div id="topbar"></div>

	<!-- [header] -->

	<section id="header-bg">

		<header role="banner" id="header-wrap" class="container centered">

			<div id="header" class="sixteen columns logo-left"
				style="padding-top: 37px;">

				<ul class="social-icons hfloat"
					data-hover-color="red: 247, green: 85, blue: 14">
					<li class="text" style="color: red; font-size:16px">どこでもテストできる</li>
					<li class="icon"><a href="#twitter"><?php echo $this->Html->image("social-icons/twitter_alt.png", array(
							'fullBase' => true,
							'alt' => 'Twitter'
					));
					?>
					</a></li>
					<li class="icon"><a href="#facebook"> <?php echo $this->Html->image("social-icons/facebook.png", array(
							'fullBase' => true,
							'alt' => 'Facebook'
					));
					?>
					</a></li>
					<li class="icon"><a href="#vimeo"> <?php echo $this->Html->image("social-icons/vimeo.png", array(
							'fullBase' => true,
							'alt' => 'Vimeo'
					));
					?>
					</a></li>
					<li class="icon"><a href="#skype"> <?php echo $this->Html->image("social-icons/skype.png", array(
							'fullBase' => true,
							'alt' => 'Skype'
					));
					?>
					</a></li>
					<li class="icon"><a href="#dribbble"> <?php echo $this->Html->image("social-icons/dribbble.png", array(
							'fullBase' => true,
							'alt' => 'Dribbble'
					));
					?>
					</a></li>
					<?php if($this->Session->read('logged_in')):?>
					<li class="text">ようこそ, <?php
					if ($this->Session->read('username')) {
						echo $this->Session->read('username');
					} else {
						$test_tee = $this->Session->read('testtee');
						echo $test_tee['Testee']['name'];
					}
					echo " ";
					if($this->Session->read('kind') != 0) {
						echo $this->Html->link('パスワード変更', array(
								'controller' => 'users',
								'action' => 'change_pass'
						));
						echo " | ";
					}
					echo $this->Html->link('ログアウト', array(
							'controller' => 'users',
							'action' => 'logout'
					));
					?>
					</li>
					<?php else: ?>
					<li class="text"><?php echo $this->Html->link('ログイン', array(
							'controller' => 'users',
							'action' => 'login'
					));
					?>
					</li>
					<?php endif; ?>

				</ul>
				<!-- .social-icons -->

				<div id="logo" class="logo clearfix" style="padding-top: 2px;">
					<a href="#"> <?php echo $this->Html->image("logo.png", array(
							'fullBase' => true,
							'alt' => 'Logo'
					));
					?>
					</a>
				</div>
				<!-- logo -->

				<!-- [navigation] -->
				<?php if($this->Session->read('logged_in')):?>
				<ul class="navigation hfloat">

					<!-- <li class="menu-item current-menu-item current_page_item"><a href=<?php //echo $this->Html->url(array(
		//'controller' => 'users',
		//'action' => 'index'
	//));?>>ホーム</a></li> -->
					<?php if($this->Session->read(array('Auth'=>'kind'))==1): ?>
					<li class="menu-item"><a
						href=<?php echo $this->Html->url(array(
								'controller' => 'sys_managers',
								'action' => 'index'
						));
						?>>団体管理者</a>
					
					<li class="menu-item"><a
						href=<?php echo $this->Html->url(array(
								'controller' => 'contracts',
								'action' => 'index'
						));
						?>>契約管理</a></li>
					<li class="menu-item"><a
						href=<?php echo $this->Html->url(array(
								'controller' => 'sys_managers',
								'action' => 'payment'
						));
						?>> 請求データ</a></li>
					<?php endif; ?>


					<?php if($this->Session->read(array('Auth'=>'kind'))==2): ?>
					<li class="menu-item"><a
						href=<?php echo $this->Html->url(array(
								'controller' => 'org_managers',
								'action' => 'test_maker_manage'
						));
						?>>出題者</a></li>
					<li class="menu-item"><a
						href=<?php echo $this->Html->url(array(
								'controller' => 'org_managers',
								'action' => 'test_marker_manage'
						));
						?>>採点者</a></li>
					<?php endif; ?>
					<?php if($this->Session->read(array('Auth'=>'kind'))==3): ?>
					<li class="menu-item"><a
						href=<?php echo $this->Html->url(array(
								'controller' => 'test_markers',
								'action' => 'index'
						));
						?>>ホームページ</a></li>
					<?php endif; ?>
					<?php if($this->Session->read(array('Auth'=>'kind'))==4): ?>
					<li class="menu-item"><a
						href=<?php echo $this->Html->url(array(
								'controller' => 'test_makers',
								'action' => 'index'
						));
						?>>ホームページ</a></li>
					<?php endif; ?>
					
					<!-- <li class="search hoverable noselect"></li> -->

				</ul>
				<!-- .navigation -->
				<?php endif; ?>
				<!-- [/navigation] -->

				<select id="mobile-nav"></select>

			</div>
			<!-- header -->

		</header>
		<!-- header-wrap -->

	</section>
	<!-- header-bg -->

	<!-- [/header] -->

	<!-- Content -->

	<section class="block container">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
	</section>

	<!-- + -->
	<footer role="contentinfo" class="full-width ovh">

		<div class="container widgets-container">

			<div class="widget-column column-1 eight columns">

				<div id="latest-posts-component-2"
					class="widget latest-posts-component">
					<h3 class="title">自動テストと採点システム</h3>
					<ul>
						<li><a class="bordered"> <?php echo $this->Html->image("static/study.jpg", array(
								'fullBase' => true,
								'width' => '63',
								'height' => '50',
								'alt' => '勉強'
						));
						?>
						</a>
							<aside>
								<a class="title">自動テスト、便利な</a> <small
									class="desc"><?php echo date('H-m-d')?></small> 
							</aside></li>
					</ul>
				</div>
				<!-- .widget -->
			</div>
			<!-- .widget-column -->

			<!-- + -->

			<div class="widget-column column-3 four columns">

				<div class="widget widget_text">
					<h3 class="title">連絡</h3>
					<div class="textwidget">
						<p>
							ハノイ工科大学
							<br />HEDSPIプロジェクト・ICT学院
							<br /> Hai Ba Trung, Ha Noi
						</p>
						<p>
							<strong>Phone</strong>: +84 976026189 <br /> <strong>Fax</strong>:
							+33 (1) 55 66 77 88
						</p>
					</div>
				</div>
				<!-- .widget -->

			</div>
			<!-- .widget-column -->

			<!-- + -->

			<div class="widget-column column-4 four columns">

				<div class="widget">
					<div class="blocked-footer-logo" style="text-align: center;">
						<?php echo $this->Html->image("logo-footer.png", array(
								'fullBase' => true,
								'alt' => 'Logo-footer',
								'style' => array(
										'display' => 'block',
										'margin' => '0 auto 0.5em'
								)
						));
						?>
					</div>
				</div>
				<!-- .widget -->

			</div>
			<!-- .widget-column -->

		</div>
		<!-- .container -->

		<!-- + -->

		<section class="copyright full-width">
			<div class="container">
				<p class="sixteen columns">
					<span> Copyright &copy; 2013 Group 04. </span> <a
						class="back-to-top float-right" href="#top">Back to top</a>
				</p>
			</div>
		</section>

	</footer>
	<!-- footer -->
	<?php echo $this->Html->script('blocked-libs');
	echo $this->Html->script('core');
	echo $this->Html->script('core.util');
	echo $this->Html->script('core.maps');
	echo $this->Html->script('core.ui');
	echo $this->Html->script('client');

	echo $this->fetch('script');
	?>

	<!--[if IE 8 ]>

		<?php
		echo $this->Html->script('core.slider.default');
		echo $this->Html->script('ie8');

		echo $this->fetch('script');

		?>
		<![endif]-->

	<script type="text/javascript">
			(function() {
				var defaultRoot = window.location.toString().split('/').slice(0, -1).join('/') + '/';
				document.i18n = {
					enterSearchCriteria : "Search"
				};
				document.root = "" || defaultRoot;
				document.vsn = "1.0.0"
				jQuery(document).ready(function() {
					window.Core.initialize();
				});
			}).call(this);
		</script>
</body>
</html>
