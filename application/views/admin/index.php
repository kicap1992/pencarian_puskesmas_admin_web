<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this->load->view('admin/head') ?>
</head>

<body class="">
  <div class="wrapper ">
    <?php $this->load->view('admin/sidebar') ?>

    <div class="main-panel">
      <?php $this->load->view('admin/navbar'); ?>

      <div class="content">
        <div class="modal fade" id="lihat_informasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-2">
          <div class="modal-dialog" role="document">
            <div class="modal-content">

              <div class="modal-body">
                <h5 class="card-title" id="judul_modal">Detail Puskesmas</h5>
                <form id="sini_form_edit">
                  
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="hidden" id="no_edit">
                        <label>Nama Puskesmas</label>
                        <input data-bv-notempty="true" data-bv-notempty-message="Nama Puskesmas Harus Terisi" type="text" name="nama"  id="nama_edit" class="form-control" placeholder="Nama Puskesmas" disabled>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Foto </label>
                        <div id="ubah_sini_edit" style="text-align: center"></div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Alamat</label>
                        <textarea data-bv-notempty="true" data-bv-notempty-message="Alamat Puskesmas Harus Terisi" class="form-control textarea" name="alamat" id="alamat_edit" placeholder="Alamat Puskesmas" disabled=""></textarea>
                      </div>
                    </div>
                  </div>

                  <!-- <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Info Rawat Inap</label>
                        <textarea data-bv-notempty="true" data-bv-notempty-message="Info Rawat Inap Harus Terisi" class="form-control textarea" name="info" id="info_edit" placeholder="Info Rawat Inap" disabled=""></textarea>
                      </div>
                    </div>
                  </div> -->

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Kontak Puskesmas</label>
                        <input data-bv-notempty="true" data-bv-notempty-message="Kontak Harus Terisi" type="text" name="kontak" minlength="9" maxlength="13" id="kontak_edit" class="form-control" placeholder="Kontak Puskesmas" disabled="">
                      </div>
                    </div>
                  </div>

                  <!-- <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Infomasi Faskes</label>
                        <textarea data-bv-notempty="true" data-bv-notempty-message="Informasi Faskes Harus Terisi" class="form-control textarea" name="info_faskes" id="info_faskes_edit" placeholder="Infomasi Faskes" disabled=""></textarea>
                      </div>
                    </div>
                  </div> -->

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Jumlah Perawat</label>
                        <input data-bv-notempty="true" data-bv-notempty-message="Jumlah Perawat Harus Terisi" type="text" name="jumlah_perawat"  id="jumlah_perawat_edit" class="form-control" placeholder="Jumlah Perawat" minlength="1" maxlength="3" disabled="">
                      </div>
                    </div>
                  </div>

                  <div id="sini_tampilkan_faskes_modal"></div>
                  
                  <div class="row">
                    <div class="col-md-12" >
                      <div class="form-group" >
                        <label>Peta Kordinat Puskesmas</label>
                        <div id="sini_peta_id"></div>
                      </div>
                    </div>
                  </div>
                </form>           
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal" onclick="cek_modal()">Close</button>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-globe text-warning"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <div id="sini_htmlnya" style="display: none"></div>
                      <p class="card-category">Jumlah Puskesmas</p>
                      <p class="card-title">50
                        <p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <!-- <i class="fa fa-refresh"></i> Update Now -->
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-money-coins text-success"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Admin Aktif</p>
                      <p class="card-title">1
                        <p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <!-- <i class="fa fa-calendar-o"></i> Last day -->
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header ">
                <h5 class="card-title">Peta Puskesmas</h5>
              </div>
              <div class="card-body" id="sini_petanya">
                
              </div>
              <div class="card-footer ">
                <hr>
               <!--  <div class="stats">
                  <i class="fa fa-history"></i> Updated 3 minutes ago
                </div> -->
              </div>
            </div>
          </div>
        </div>

        

      </div>
      
      <?php $this->load->view('admin/footer'); ?>
    </div>
  </div>
  
  <?php $this->load->view('admin/script'); ?>
  
  <script src="<?=base_url()?>assets/peta.js"></script>
  <script type="text/javascript">
    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
      }
    hehe();
    async function hehe (){
      await sleep(1000);
      $("#sini_htmlnya").html('<script src="<?=base_url()?>assets/dist/js/lightbox-plus-jquery.min.js"></'+'script>');
    }
  </script>
</body>

</html>
