<?php
session_start();
if (isset($_SESSION['checkkullanici_mail'])) {
	header("Location:hesabim.php");
	exit;
} ?>

<?php include 'header.php'; ?>


<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="page-title-wrap">
				<div class="page-title-inner">
					<div class="row">
						<div class="col-md-4">

							<div class="bread"><a href="#">Ana Sayfa</a> &rsaquo; login</div>
							<div class="bigtitle">Giriş Yap</div>
						</div>
						<div class="col-md-3 col-md-offset-5">		
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php 
	$token=$_GET['token'];
	$kullanicisor2=$db->prepare("SELECT * FROM kullanici where kullanici_token LIKE '%$token%'");
	$kullanicisor2->execute();
	$kullanicicek2=$kullanicisor2->fetch(PDO::FETCH_ASSOC);

	$kullanici_id=$db->lastInsertId();
	$kullanicisor3=$db->prepare("SELECT * FROM kullanici where kullanici_id=:id");
	$kullanicisor3->execute(array(
		'id'=>$_GET['id']
	));
	$kullanicicek3=$kullanicisor3->fetch(PDO::FETCH_ASSOC);
	if ($_GET['durum']=="no") {

		echo "<b style=color:red;>Mail veya Şifre yanlış.</b>";

	}elseif ($_GET['durum']=="ok") {
		echo "<b style=color:green;>Şifreniz Değişti. Artık Giriş Yapabilirsiniz. </b>";
	}elseif ($_GET['durum']=="kayitbasarili") { ?>
	<?php	echo "<b style=color:green;>Kaydınız Yapıldı. E-Postanızı Kontrol Ederek Üyeliğinizi Aktive Edebilirsiniz. </b>"; ?>

		<form method="POST" action="nedmin/netting/islem.php"><button class="btn btn-default btn-success" name="tekrarmailgonder" type="submit">Tekrar Gönder</button>
		<input type="hidden" name="kullanici_token" value="<?php echo $kullanicicek3['kullanici_token']; ?>">
		<input type="hidden" name="kullanici_id" value="<?php echo $kullanicicek3['kullanici_id']; ?>">
		<input type="hidden" name="kullanici_mail" value="<?php echo $kullanicicek3['kullanici_mail']; ?>">
		<input type="hidden" name="kullanici_ad" value="<?php echo $kullanicicek3['kullanici_ad']; ?>">
	</form>

	 <?php }elseif ($kullanicicek2['kullanici_token']==$token and $token!=NULL) {
		$kullaniciduzenle=$db->prepare("UPDATE kullanici set 


			kullanici_durum=:kullanici_durum

			where kullanici_id={$kullanicicek2['kullanici_id']}");
		$update=$kullaniciduzenle->execute(array(

			'kullanici_durum'=>1

		));
		echo "<b style=color:green;>Üyeliğinizi Aktif Ettiğiniz İçin Teşekkürler. Şimdi Giriş Yapabilirsiniz. </b>";?>
		
	<?php } ?>

	<form class="form-horizontal checkout" method="POST" action="nedmin/netting/islem.php" role="form">
		<div class="row">				
			<div class="col-md-6">
				<div class="title-bg">
					<div  class="title">Kullanıcı Bilgileri</div>
				</div>

				<div class="form-group">
					<div class="col-sm-8">
						<input type="email" class="form-control" name="kullanici_mail" placeholder="E-mail">
					</div>
				</div><br>
				<div class="form-group dob">
					<div class="col-sm-8">
						<input type="password" class="form-control" name="kullanici_password" placeholder="Şifre">
					</div>

				</div><br>

				<button type="submit" name="kullanicigiris2" class="btn btn-default btn-success">Giriş Yap</button>&nbsp;&nbsp;&nbsp;&nbsp;
				<div style="text-align: right;"><a style="text-decoration: none;" href="kullaniciekle.php"><h4 style="color:#a400ff; ">Hala Kaydolmadın mı?</h4></a></div>
			</div>
			<div class="col-md-6">
				<div class="col-md-6">
					<div class="title-bg">
						<div class="title">Şifremi Unuttum</div>
						<br>
						<a href="sifre-unuttum.php"><img style="width: 200px;" src="images/forgot.png"></a>
					</div>
				</div>
			</div>
		</form>
	</div>
	
	<div class="spacer"></div>
</div>
<br><br><br><br><br><br><br><br>
<?php include 'footer.php'; ?>
