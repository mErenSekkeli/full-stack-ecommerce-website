<?php
session_start();
if (isset($_SESSION['checkkullanici_mail'])) {
  header("location:hesabim.php");
  exit;
}

 include 'header.php'; 


$kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail");
$kullanicisor->execute(array(
  'mail' => $_SESSION['checkkullanici_mail']

));
$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);

?>	

<title>Şifremi Unuttum</title>
<div class="container">
  <div class="row">
   <div class="col-md-12">
    <div class="page-title-wrap">
     <div class="page-title-inner">
       <div class="row">
        <div class="col-md-4">
         <div class="bigtitle"> Şifremi Unuttum </div> 
       </div>
     </div>
   </div>
 </div>
</div>
</div>
<div class="row">
 <div class="col-md-9"><!--Main content-->
<?php if ($_GET['durum']=="posta") { ?>
  <script type="text/javascript">alert("Lütfen E-Postanızı Doğru Girin ");</script> 
 <?php }elseif($_GET['durum']=="token"){ ?>
  <script type="text/javascript">alert("Lütfen Tokenle Oynamayın ");</script> 
  <?php }elseif($_GET['durum']=="soru"){ ?>
<script type="text/javascript">alert("Lütfen Soruya Doğru Cevap Verin ");</script> 
<?php } ?>

 <?php if ($_GET['durum']=="ok") { ?>
  <?php 
$a=rand(5,20); $b=rand(1,5); $c=$a+$b;
 ?>
 <form method="POST" action="nedmin/netting/islem.php">
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Soru <span class="required"> :</span>
      </label>
      <div class="col-md-8 col-sm-6 col-xs-12">
        <input type="text" id="first-name" name="kullanici_soru" required="required" placeholder="<?php echo $a." +"." ".$b." "."= ?";  ?>" class="form-control col-md-7 col-xs-12" >
      </div>
    </div><br><br>
  <input type="hidden" name="soru_cevap" value="<?php echo $c; ?>"><input type="hidden" name="kullanici_mail" value="<?php echo $_GET['mail']; ?>">
    <button class="btn btn-default btn-success pull-right" name="tekrarsifregönder" type="submit">Tekrar Gönder</button>
    
  </form><br><br>
   <div class="title-bg">
   <div class="title" style="color:#249623">Şifreni Değiştirebilmen için mailine link bıraktık. Linke tıklayarak şifreni değiştirebilirsin.  <br><br><span style="color:#DC143C"> Önemli Not: </span><span style="color:black;">Lütfen Spam veya Gereksiz kutusuna bakmayı unutma!!</span></div>


 </div>



 <?php }else{ ?>

  <div class="title-bg">
   <div class="title">Şifremi Değiştir</div>
 </div>
 <div class="page-content">
   <form id="demo-form2" action="nedmin/netting/islem.php" method="POST" data-parsley-validate class="form-horizontal form-label-left">	

    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">E-Posta <span class="required"> :</span>
      </label>
      <div class="col-md-8 col-sm-6 col-xs-12">
        <input type="email" id="first-name" name="kullanici_mail" required="required" placeholder="E-postanızı Girin" class="form-control col-md-7 col-xs-12" >
      </div>
    </div>
<?php 
$a=rand(5,20); $b=rand(1,5); $c=$a+$b;
 ?>
 <input type="hidden" name="soru_cevap" value="<?php echo $c; ?>">
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Soru <span class="required"> :</span>
      </label>
      <div class="col-md-8 col-sm-6 col-xs-12">
        <input type="text" id="first-name" name="kullanici_soru" required="required" placeholder="<?php echo $a." +"." ".$b." "."= ?";  ?>" class="form-control col-md-7 col-xs-12" >
      </div>
    </div>
<button class="btn btn-primary pull-right" name="sifremiunuttum" type="submit">Gönder</button>

  </form>

</div>



</div>


</div>
 <?php } ?>
<!--sidebar-->



</div>
</div>

<div class="spacer"></div>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php include 'footer.php' ?>