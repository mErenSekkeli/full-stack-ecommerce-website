<?php
session_start();
if (isset($_SESSION['checkkullanici_mail'])) {
  header("location:hesabim.php");
  exit;
}

 include 'header.php'; 

$token=$_GET['token'];
$kullanicisor2=$db->prepare("SELECT * FROM kullanici where kullanici_token LIKE '%$token%'");
$kullanicisor2->execute();
$kullanicicek2=$kullanicisor2->fetch(PDO::FETCH_ASSOC);

if ($token!=$kullanicicek2['kullanici_token']) {
header("location:sifre-unuttum.php?durum=token");
exit;

}else{ ?>



<title>Şifremi Düzenle</title>
<div class="container">
  <div class="row">
   <div class="col-md-12">
    <div class="page-title-wrap">
     <div class="page-title-inner">
       <div class="row">
        <div class="col-md-4">
         <div class="bigtitle"> Yeni Şifre </div> 
       </div>
     </div>
   </div>
 </div>
</div>
</div>
<div class="row">
 <div class="col-md-9"><!--Main content-->
<?php if ($_GET['durum']=="eslesmehata") { ?>
  <script type="text/javascript">alert("Şifreler Eşleşmiyor ");</script> 
 <?php }elseif($_GET['durum']=="eksiksifre"){ ?>
<script type="text/javascript">alert("Şifreniz En Az 6 Haneli Olmalı ");</script> 
  <?php } ?>
 <div class="title-bg">
          <div class="title">Şifremi Değiştir</div>
        </div>
        <div class="page-content">
          <form id="demo-form2" action="nedmin/netting/islem.php" method="POST" data-parsley-validate class="form-horizontal form-label-left">  

            <input type="hidden" readonly="" id="first-name" name="kullanici_id"  class="form-control col-md-7 col-xs-12" value="<?php echo $kullanicicek2['kullanici_id']; ?>">
                     

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
                          <button class="btn btn-primary" name="yenisifregir" type="submit">Değiştir</button> 
                        </div>
                      </div>

                  </form>

        </div>


</div>


</div>
<?php }?> 
<!--sidebar-->



</div>
</div>

<div class="spacer"></div>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php include 'footer.php' ?>