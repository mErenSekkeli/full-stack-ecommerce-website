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




        <form id="demo-form2" method="POST" action="../netting/islem.php" data-parsley-validate class="form-horizontal form-label-left"> 
          <?php
          $sayi=$_GET['renk_sayi'];
          while($sayi>0){ $sayi--; ?>
           <input type="hidden" id="first-name" name="renk_id" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $renkcek['renk_id']; ?>">

           <input type="hidden" id="first-name" name="urun_id" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $uruncek['urun_id']; ?>">



           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?php echo $say2."."."Renk";  ?><span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="first-name" name="renk_ad[]" required="required" class="form-control col-md-7 col-xs-12" >
            </div>
          </div>

        <?php   } ?>

        <div class="ln_solid"></div>
        <div class="form-group">
          <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <button type="submit" name="renkekle" class="btn btn-success">Güncelle</button>
         </div>
       </div>     
     </form>

   </div>
 </div>
</div>
</div>


<div >       

</div></div>


<!-- /page content -->

<!-- footer content -->
<?php include 'footer.php'; ?>