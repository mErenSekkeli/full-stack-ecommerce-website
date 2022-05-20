<?php include 'header.php';

$entegresor=$db->prepare("SELECT * FROM entegre ");
$entegresor->execute();




?>
<head>
  <script src="https://cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>
</head>

<!-- page content -->
<div class="right_col" role="main">


  <h2>Entegre İşlemleri</h2>&nbsp;&nbsp;&nbsp;
  <small>&nbsp;<?php
  if (isset($_GET['durum'])) {


   if ($_GET['durum']=="ok") {
    ?><b style="color:green;">İşlem Başarılı.</b>                        
  <?php } elseif ($_GET['durum']=="no") {
   ?><b style="color:red;">İşlem Başarısız.</b><?php
 } }?></small>

 <?php                   
 if ($_GET['menu_sil']=="ok") {
  ?><b style="color:green;">Entegre Silindi.</b>                        
<?php } elseif ($_GET['menu_sil']=="no") {
 ?><b style="color:red;">İşlem Başarısız.</b><?php
} ?></small>




<div class="x_panel">
  <div class="x_title">
    <h2>Entegre Listesi <small>Entegreler</small></h2>
    <br>

    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <p class="text-muted font-13 m-b-30">

    </p>
    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>Sıra No</th>
          <th>Havale İşlemi</th>
          <th>Kapida Ödeme İşlemi</th>
          <th>Kredi Kartı İşlemi</th>                       
        </tr>
      </thead>
      <tbody>

        <?php 
        $say=0;
        while ( $entegrecek=$entegresor->fetch(PDO::FETCH_ASSOC)) { $say++;?>

          
          <tr>
            <form action="../netting/islem.php" method="POST">
              <input type="hidden" name="entegre_id" value="<?php echo $entegrecek['entegre_id']; ?>">
            <td width="20"><?php echo $say; ?></td>
            <td><?php if ($entegrecek['entegre_havale']==1) { ?>
              <input type="hidden" name="entegre_havale" value="0">
              <button type="submit" name="havaleetkin" class="btn btn-warning btn-sm">Devre Dışı Bırak</button>
            <?php   }elseif ($entegrecek['entegre_havale']==0) { ?>
              <input type="hidden" name="entegre_havale" value="1">
             <button type="submit" name="havaleetkin" class="btn btn-success btn-sm">Aktifleştir</button>
             <?php   } ?></td>
             <td><?php if ($entegrecek['entegre_kapida']==1) { ?>
               <input type="hidden" name="entegre_kapida" value="0">
              <button type="submit" name="kapidaetkin" class="btn btn-warning btn-sm">Devre Dışı Bırak</button>
            <?php   }elseif ($entegrecek['entegre_kapida']==0) { ?>
              <input type="hidden" name="entegre_kapida" value="1">
             <button type="submit" name="kapidaetkin" class="btn btn-success btn-sm">Aktifleştir</button>
             <?php   } ?></td>
             <td><?php if ($entegrecek['entegre_kart']==1) { ?>
              <input type="hidden" name="entegre_kart" value="0">
              <button type="submit" name="kartetkin" class="btn btn-warning btn-sm">Devre Dışı Bırak</button>
            <?php   }elseif ($entegrecek['entegre_kart']==0) { ?>
              <input type="hidden" name="entegre_kart" value="1">
             <button type="submit" name="kartetkin" class="btn btn-success btn-sm">Aktifleştir</button>
             <?php   } ?></td>
              </form>
                          <!--
                            success -> yeşil buton
                            warning -> turuncu buton
                            danger -> kırmızı buton
                            default -> beyaz buton
                            primary -> mavi buton
                            btn-xs -> butonu küçültür.
                            çıkartır.(Bootstrap4) -->


                          </tr>

                        <?php } ?>



                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>





        <div class="col-md-12 col-sm-12 col-xs-12">


        </div></div>


        <!-- /page content -->

        <!-- footer content -->
        <footer>
         <?php include 'footer.php'; ?>
       </footer>
       <!-- /footer content -->
     </div>
   </div>
   </html>
