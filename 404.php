<?php include 'header.php'; 

	$menusor=$db-> prepare("SELECT * from menu where menu_seourl=:sef");
    $menusor->execute(array(
    	'sef'=>$_GET['sef']

    ));

$menucek=$menusor->fetch(PDO::FETCH_ASSOC);

	?>	
<title><?php echo $menucek['menu_ad']; ?></title>
	
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-title-wrap">
					<div class="page-title-inner">
					<div class="row">
						<div class="col-md-4">
							<div class="bread"><a href="#">Ana Sayfa</a> &rsaquo; Menüler</div>
							<div class="bigtitle"><?php echo $menucek['menu_ad']; ?></div> 
						</div>
						
					</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-9"><!--Main content-->
				
				<div class="page-content">
					<p>
					<?php echo $menucek['menu_detay']; ?>
					</p>

				</div>
				
				
			</div>
			<!--sidebar-->
			


		</div>
		<div class="spacer"></div>
	</div>
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<?php include 'footer.php' ?>