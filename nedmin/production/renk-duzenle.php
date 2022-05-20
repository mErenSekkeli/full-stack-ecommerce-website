<?php include 'header.php';

$urunsor=$db->prepare("SELECT * FROM urun where urun_id=:id");
$urunsor->execute(array(
  'id' => $_GET['urun_id']

));
$uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);
$urun_id=$uruncek['urun_id'];

$renksor=$db->prepare("SELECT * FROM renk where urun_id=:id");
$renksor->execute(array(
  'id' => $urun_id
));


?>
<script src="https://cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
  </div>


  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">

          <h2>Renk Bilgileri</h2>&nbsp;&nbsp;&nbsp;
          <small>&nbsp;<?php
          if (isset($_GET['durum'])) {


           if ($_GET['durum']=="ok") {
            ?><b style="color:green;">İşlem Başarılı.</b>                        
          <?php } elseif ($_GET['durum']=="no") {
           ?><b style="color:red;">İşlem Başarısız.</b><?php
         } }?></small>

         <div class="clearfix"></div>
       </div>
       <div class="x_content">
        <br />


        <?php

        while($renkcek=$renksor->fetch(PDO::FETCH_ASSOC)){  ?>

         <form id="demo-form2" method="POST" action="../netting/islem.php" data-parsley-validate class="form-horizontal form-label-left"> 
           <input type="hidden" id="first-name" name="renk_id" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $renkcek['renk_id']; ?>">

           <input type="hidden" id="first-name" name="urun_id" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $uruncek['urun_id']; ?>">



           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Renk İsmi<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="first-name" name="renk_ad" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $renkcek['renk_ad']; ?>">
            </div>
          </div>      

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Renk Stoğu<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="first-name" name="renk_stok" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $renkcek['renk_stok']; ?>">
            </div>
          </div>
          
            
          <input type="hidden" name="renk_id" value="<?php echo $renkcek['renk_id']; ?>">
          <div class="form-group">
            <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <button type="submit" name="renk_sil" class="btn btn-danger">Sil</button>
           </div>
         </div>
         <div class="ln_solid"></div>

         
         <div class="form-group">
          <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
           <button type="submit" name="renkduzenlekaydet" class="btn btn-success">Güncelle</button>
         </div>
       </div>     
     </form>
 <?php   } ?>
 </div>
</div>
</div>
</div>

<div class="x_panel">
  <div class="x_title">

    <h2>Renk Ekle</h2>

    <div class="clearfix"></div>
  </div>
  <div class="x_content">

    <div>    <form action="renk-ekle.php" method="GET">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Renk Adedi<span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="number" id="first-name" name="renk_sayi" required="required" class="form-control col-md-7 col-xs-12">
        <input type="hidden" name="urun_id" value="<?php echo $urun_id ?>">
      </div>
    </div>
    <div class="ln_solid"></div>

    <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
      <a href="renk-ekle.php"> <button class="btn btn-success">Renk Ekle</button></a>
    </div>     
  </form>

</div>
</div>
</div>


<!-- /page content -->

<!-- footer content -->
<?php include 'footer.php'; ?>