<?php 

include 'header.php'; 


$slidersor=$db->prepare("SELECT * FROM slider where slider_id=:id");
$slidersor->execute(array(
  'id' => $_GET['slider_id']
  ));

$slidercek=$slidersor->fetch(PDO::FETCH_ASSOC);


?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Slider Düzenleme <small>
              <?php 
              if ($_GET['durum']=="img") { ?>
                <b style="color:red;">Yalnızca Resim Yüklenebilir.</b>
           <?php    } ?>
            </small></h2>
            
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />

            <!-- / => en kök dizine çık ... ../ bir üst dizine çık -->
            <form action="../netting/islem.php" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Yüklü Resim <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <img width="300" src="../../<?php echo $slidercek['slider_resimyol']; ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Resim Seç<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="file" id="first-name"  name="slider_resimyol"  class="form-control col-md-7 col-xs-12">
                </div>
              </div>


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Slider Ad <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="slider_ad"  required="required" value="<?php echo $slidercek['slider_ad'] ?>" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Slider Url <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="slider_link"   value="<?php echo $slidercek['slider_link'] ?>" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Slider Sıra <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="slider_sira"  required="required" value="<?php echo $slidercek['slider_sira'] ?>"  class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Slider Durum<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <select id="heard" class="form-control" name="slider_durum" required>

                  <option value="1" <?php echo $slidercek['slider_durum'] == '1' ? 'selected=""' : ''; ?>>Aktif</option>



                  <option value="0" <?php if ($slidercek['slider_durum']==0) { echo 'selected=""'; } ?>>Pasif</option>
                </select>
              </div>
            </div>

            
            <input type="hidden" name="slider_id" value="<?php echo $slidercek['slider_id'] ?>">
            <input type="hidden" name="old_slider" value="<?php echo $slidercek['slider_resimyol'] ?>">
            <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Slider Butonu <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select id="heard" class="form-control"  value="<?php echo $slidercek['slider_button']; ?>" name="slider_button">

                            <?php 

                            if ($slidercek['slider_button']==0) {?>

                              <option value="0">Pasif</option>
                              <option value="1">Aktif</option>


                           <?php } else { ?> 

                          <option value="1">Aktif</option>
                           <option value="0">Pasif</option>   



                          <?php } ?>

                           </select>
                        </div>
                      </div>

                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Fiyat Etiketi <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select id="heard" class="form-control"  value="<?php echo $slidercek['slider_deal']; ?>" name="slider_deal">

                            <?php 

                            if ($slidercek['slider_deal']==0) {?>

                              <option value="0">Pasif</option>
                              <option value="1">Aktif</option>


                           <?php } else { ?> 

                          <option value="1">Aktif</option>
                           <option value="0">Pasif</option>   



                          <?php } ?>

                           </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Sahte Fiyat<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="slider_fakefiyat" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $slidercek['slider_fakefiyat']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Gerçek Fiyat<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="slider_fiyat" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $slidercek['slider_fiyat']; ?>">
                        </div>
                      </div>

            <div class="ln_solid"></div>
            <div class="form-group">
              <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="submit" name="sliderduzenlekaydet" class="btn btn-success">Güncelle</button>
              </div>
            </div>

          </form>



        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- /page content -->

<?php include 'footer.php'; ?>
