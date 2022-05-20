
<?php include 'header.php'; 
	

$kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail");
  $kullanicisor->execute(array(
    'mail' => $_SESSION['checkkullanici_mail']
    
    ));
  $kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);

	?>	
	
		<title>Hesabım</title>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-title-wrap">
					<div class="page-title-inner">
					<div class="row">
						<div class="col-md-4">
							<div class="bread"><a href="#">Ana Sayfa</a> &rsaquo; Menüler</div>
							<div class="bigtitle"> Hesabım </div> 
						</div>
						<?php
                    if (isset($_GET['durum'])) {
                   
                    
                     if ($_GET['durum']=="ok") {
                      ?><b style="color:green;">Başarıyla Değiştirildi.</b>                        
                    <?php } elseif ($_GET['durum']=="no") {
                     ?><b style="color:red;">İşlem Başarısız.</b><?php
                    }elseif($_GET['durum']=="eslesmehata"){ ?>
                    	<b style="color:red;">Şifreler Eşleşmiyor.</b>

                  <?php  }elseif ($_GET['durum']=="eksiksifre") { ?>
                  	<b style="color:red;">Yeni Şifre En Az 6 Haneli Olmalı.</b>
                  

               <?php }   }?>
					</div>
					</div>
				</div>
				</div>
			</div>
			<div class="row">
			<div class="col-md-9"><!--Main content-->
				
				<div class="title-bg">
					<div class="title">Hesap Bilgilerim</div>
				</div>
				<div class="page-content">
					<form id="demo-form2" action="nedmin/netting/islem.php" method="POST" data-parsley-validate class="form-horizontal form-label-left">	

						<input type="hidden" readonly="" id="first-name" name="kullanici_id"  class="form-control col-md-7 col-xs-12" value="<?php echo $kullanicicek['kullanici_id']; ?>">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Adım ve Soyadım<span class="required"> :</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                          <input type="text" disabled="" id="first-name" name="kullanici_adsoyad" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $kullanicicek['kullanici_ad']." ".$kullanicicek['kullanici_soyad']; ?>">
                        </div>
                      </div>

                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">E-Mailim <span class="required"> :</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="kullanici_mail" required="required" disabled="" class="form-control col-md-7 col-xs-12" value="<?php echo $kullanicicek['kullanici_mail']; ?>">
                        </div>
                      </div>

                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Telefon Numaram <span class="required"> :</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="kullanici_gsm" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $kullanicicek['kullanici_gsm']; ?>">
                          <button class="btn btn-primary" name="gsmdegistir" type="submit">Değiştir</button>
                        </div>
                      </div>

                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Adresim <span class="required"> :</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="kullanici_adres" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $kullanicicek['kullanici_adres']; ?>" >
                         	<button class="btn btn-primary" name="adresdegistir" type="submit">Değiştir</button> 
                        </div>
                      </div>

                  </form>

				</div>

				<div class="title-bg">
					<div class="title">Şifremi Değiştir</div>
				</div>
				<div class="page-content">
					<form id="demo-form2" action="nedmin/netting/islem.php" method="POST" data-parsley-validate class="form-horizontal form-label-left">	

						<input type="hidden" readonly="" id="first-name" name="kullanici_id"  class="form-control col-md-7 col-xs-12" value="<?php echo $kullanicicek['kullanici_id']; ?>">
						<input type="hidden" readonly="" id="first-name" name="kullanici_password"  class="form-control col-md-7 col-xs-12" value="<?php echo $kullanicicek['kullanici_password']; ?>">
                     
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Eski Şifrenizi Girin<span class="required"> :</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                          <input type="password" id="first-name" name="kullanici_oldpass" required="required" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Yeni Şifre <span class="required"> :</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                          <input type="password" id="first-name" name="kullanici_newpassword" required="required" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Yeni Şifre Tekrar <span class="required"> :</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                          <input type="password" id="first-name" name="kullanici_newpassword2" required="required" class="form-control col-md-7 col-xs-12" ><br><br><br><br>
                         	<button class="btn btn-primary" name="sifredegistir" type="submit">Değiştir</button> 
                        </div>
                      </div>

                  </form>

				</div>
				
				
			</div>
			<!--sidebar-->
			


		</div>
		</div>
		
		<div class="spacer"></div>
	</div>
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<?php include 'footer.php' ?>