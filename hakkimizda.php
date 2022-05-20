<?php 
 include 'header.php';
 
	$hakkimizdasor=$db-> prepare("SELECT * from hakkimizda where hakkimizda_id=:id");
    $hakkimizdasor->execute(array(
'id' => 0

    ));
$hakkimizdacek=$hakkimizdasor->fetch(PDO::FETCH_ASSOC);

 
	?>	
<title>Hakkımızda</title>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-title-wrap">
					<div class="page-title-inner">
					<div class="row">
						<div class="col-md-4">
							<div class="bread"><a href="#">Ana Sayfa</a> &rsaquo; Hakkımızda</div>
							<div class="bigtitle">Hakkımızda</div>
						</div>
						
					</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-9"><!--Main content-->
				<div class="title-bg">
					<div class="title"><?php echo $hakkimizdacek['hakkimizda_baslik']; ?></div>
				</div>
				<div class="page-content">
					<p>
					<?php echo $hakkimizdacek['hakkimizda_icerik']; ?>
					</p>

				</div>
				<div class="title-bg">
					<div class="title">Misyon</div>
					</div>
					<div class="page-content">
					<p>
					<?php echo $hakkimizdacek['hakkimizda_misyon']; ?>
					</p>

				</div>
				<div class="title-bg">
					<div class="title">Vizyon</div>
					</div>
					<div class="page-content">
					<p>
					<?php echo $hakkimizdacek['hakkimizda_vizyon']; ?>
					</p>

				</div>
				<div class="title-bg">
					<div class="title">Tanıtım Videosu</div>
					<br><br>
				<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $hakkimizdacek['hakkimizda_video'] ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

				</div>	
			</div>
			<!--sidebar-->
			
             <?php include 'side-bar.php' ?>

		</div>
		<div class="spacer"></div>
	</div>
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<?php include 'footer.php'; ?>