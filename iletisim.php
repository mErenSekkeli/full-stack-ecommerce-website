<?php
 include 'header.php'; 


$kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail");
$kullanicisor->execute(array(
  'mail' => $_SESSION['checkkullanici_mail']

));
$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);


?>	

<title>İletişim</title>
<div class="container">
  <div class="row">
   <div class="col-md-12">
    <div class="page-title-wrap">
     <div class="page-title-inner">
       <div class="row">
        <div class="col-md-4">
         <div class="bigtitle"> İletişim  </div> 
       </div>
     </div>
   </div>
 </div>
</div>
</div>
<div class="row">
 <div class="col-md-9"><!--Main content-->
  <?php if ($_GET['durum']=="ok") { ?>
     <script type="text/javascript">alert("İletiniz Gönderildi. En Kısa Sürede Cevaplanacaktır. ");</script> 
 <?php } ?>
<?php if ($_GET['durum']=="posta") { ?>
  <script type="text/javascript">alert("Lütfen E-Postanızı Doğru Girin ");</script> 
 <?php }elseif($_GET['durum']=="token"){ ?>
  <script type="text/javascript">alert("Lütfen Tokenle Oynamayın ");</script> 
  <?php }elseif($_GET['durum']=="soru"){ ?>
<script type="text/javascript">alert("Lütfen Soruya Doğru Cevap Verin ");</script> 
<?php } ?>
 <script src="https://cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>

  <div class="title-bg">
   <div class="title">İletişim Bilgileri</div>
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
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ad Soyad <span class="required"> :</span>
      </label>
      <div class="col-md-8 col-sm-6 col-xs-12">
        <input type="text" id="first-name" name="kullanici_adsoyad" required="required" placeholder="İsminizi Girin" class="form-control col-md-7 col-xs-12" >
      </div>
    </div>

    <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">İçerik <span class="required">:</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                  <textarea class="ckeditor" id="editor1" name="kullanici_ileti"> </textarea>
                </div>
              </div>

              <script type="text/javascript">

               CKEDITOR.replace( 'editor1',

               {

                filebrowserBrowseUrl : 'ckfinder/ckfinder.html',

                filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',

                filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',

                filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',

                filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',

                filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',

                forcePasteAsPlainText: true

              } 

              );

            </script>

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
<button class="btn btn-primary pull-right" name="iletisimgonder" type="submit">Gönder</button>

  </form>

</div>


</div>


</div>
<!--sidebar-->



</div>
</div>

<div class="spacer"></div>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php include 'footer.php' ?>