<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this->load->view('admin/head') ?>
  <style type="text/css">
    .has-error .help-block {
      color: red;
    }
  </style>
  <style type="text/css">
    .swal-modal .swal-text{
      text-align: center
    }
  </style>  
  <link href="<?=base_url()?>assets/datatables/jquery.dataTables.min.css" rel="stylesheet">
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
                      <!-- <div class="form-group"> -->
                        <label>Foto </label>
                        <input data-bv-notempty="true" data-bv-notempty-message="Foto Minimal 1" type="file" name="files[]" id="files_edit" class="form-control" onchange="previewImage_edit();" multiple="" disabled style="display: none">
                        <div id="ubah_sini_edit1" style="text-align: center"></div>
                      <!-- </div> -->
                      <div id="ubah_sini_edit" style="text-align: center"></div>
                      <div id="div_upload_foto_edit" style="display: none">
                        <center>
                          <button type="button" class="btn_foto_edit btn btn-info btn-sm waves-effect waves-light" onclick="edit_foto()">Upload Foto Baru</button>
                        </center>
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

<!--                   <div class="row">
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
                  <input type="hidden" name="array_faskes" id="array_faskes_edit">

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
                <div id="sini_button_modal"></div>
                <button type="button" class="btn_edit btn btn-info btn-sm waves-effect waves-light" onclick="edit()">Edit ?</button>
                <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" onclick="hapus()">Hapus</button>
                <button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal">Close</button>
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
          <div class="col-md-5">
            <div class="card ">
              <div class="card-header ">
                <h5 class="card-title">Tambah Puskesmas</h5>
              </div>
              <div class="card-body">
                <input type="hidden" id="sini_js">
                <form id="sini_form">
                  
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="hidden" id="sini_htmlnya">
                        <label>Nama Puskesmas</label>
                        <input data-bv-notempty="true" data-bv-notempty-message="Nama Puskesmas Harus Terisi" type="text" name="nama"  id="nama" class="form-control" placeholder="Nama Puskesmas" >
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <!-- <div class="form-group"> -->
                        <label>Foto </label>
                        <input data-bv-notempty="true" data-bv-notempty-message="Foto Minimal 1" type="file" name="files[]" id="files" class="form-control" onchange="previewImage();" multiple="">
                      <!-- </div> -->
                      <div id="ubah_sini" style="text-align: center"></div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Alamat</label>
                        <textarea data-bv-notempty="true" data-bv-notempty-message="Alamat Puskesmas Harus Terisi" class="form-control textarea" name="alamat" id="alamat" placeholder="Alamat Puskesmas"></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Tanda Titik Lokasi Kordinat</label>
                        <select class="form-control" id="select_tanda_kordinat" onchange="changeTandaKordinat(value)">
                          <option disabled="" selected="">-Pilih Tanda Titik Kordinat</option>
                          <option value="1">Tanda Kordinat Lokasi Sekarang</option>
                          <option value="2">Tanda Kordinat Menggunakan Peta</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div id="div_kordinat_sekarang" style="display: none">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Peta Kordinat Sekarang</label>
                          <div id="sini_petanya_kordinat"></div>
                        </div>
                      </div>
                    </div>
                  </div> 

                  <div id="div_tanda_kordinat" style="display: none">
                    
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Kecamatan</label>
                          <select data-bv-notempty="false" data-bv-notempty-message="Kecamatan Harus Terpilih" class="form-control" name="kecamatan" id="kecamatan" onchange="changeKecamatan(value)">
                            <option selected="" disabled="">-Pilih Kecamatan</option>
                            <?php foreach ($kecamatan as $key => $value): ?>
                              <option value="<?=$value->no?>"><?=$value->kecamatan?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Kelurahan</label>
                          <select data-bv-notempty="false" data-bv-notempty-message="Kelurahan" class="form-control" name="kelurahan" id="kelurahan" onchange="changeKelurahan(value)">
                            <option selected="" disabled="">-Pilih Kecamatan Dulu</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Peta (Tanda Titik Puskesmas)</label>
                          <div id="sini_petanya1"><b>Pilih Kecamatan Dulu</b></div>
                          <input type="hidden" name="kordinat" id="kordinat">
                        </div>
                      </div>
                    </div>

                  </div>

                  <!-- <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Info Rawat Inap</label>
                        <textarea data-bv-notempty="true" data-bv-notempty-message="Info Rawat Inap Harus Terisi" class="form-control textarea" name="info" id="info" placeholder="Info Rawat Inap"></textarea>
                      </div>
                    </div>
                  </div> -->

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Kontak Puskesmas</label>
                        <input data-bv-notempty="true" data-bv-notempty-message="Kontak Harus Terisi" type="text" name="kontak" minlength="9" maxlength="13" id="kontak" class="form-control" placeholder="Kontak Puskesmas" >
                      </div>
                    </div>
                  </div>

                  <!-- <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Infomasi Faskes</label>
                        <textarea data-bv-notempty="true" data-bv-notempty-message="Informasi Faskes Harus Terisi" class="form-control textarea" name="info_faskes" id="info_faskes" placeholder="Infomasi Faskes"></textarea>
                      </div>
                    </div>
                  </div> -->

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Jumlah Perawat</label>
                        <input data-bv-notempty="true" data-bv-notempty-message="Jumlah Perawat Harus Terisi" type="text" name="jumlah_perawat"  id="jumlah_perawat" class="form-control" placeholder="Jumlah Perawat" minlength="1" maxlength="3">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Jumlah Fasilitas Kesehatan</label>
                        <input data-bv-notempty="true" data-bv-notempty-message="Jumlah Perawat Harus Terisi" type="text"  id="jumlah_faskes" name="jumlah_faskes" class="form-control" placeholder="Jumlah Fasilitas Kesehatan" minlength="1" maxlength="2">
                      </div>
                    </div>
                  </div>

                  <div id="div_sini_faskes"></div>
                  <input type="text" id="array_faskes" name="array_faskes" style="display: none">
                  
                </form>
                <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="button" id="usulkan" class="btn btn-primary btn-round">Tambah Puskesmas</button>
                    </div>
                  </div>
              </div>
              <div class="card-footer ">
                <hr>
               <!--  <div class="stats">
                  <i class="fa fa-history"></i> Updated 3 minutes ago
                </div> -->
              </div>
            </div>
          </div>

          <!-- <div class="col-md-7">
            <div class="card ">
              <div class="card-header ">
                <h5 class="card-title">Peta Puskesmas</h5>
              </div>
              <div class="card-body" id="sini_petanya">
                
              </div>
              <div class="card-footer ">
                <hr>
               
              </div>
            </div>
          </div> -->

          <div class="col-md-7">
            <div class="card" >
              <div class="card-header ">
                <h5 class="card-title">List Puskesmas</h5>
              </div>
              <div class="card-body" style="overflow-x: auto">
                <table id="table1" class="table table-striped table-bordered" width="100%">
                  <thead>
                    <tr>
                      <!-- <th>No</th> -->
                      <th>No</th>
                      <th>Nama</th>
                      <th>Alamat</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <div class="card-footer ">
                <hr>
               
              </div>
            </div>
          </div>
          
        </div>

        

      </div>
      
      <?php $this->load->view('admin/footer'); ?>
    </div>
  </div>
  
  <?php $this->load->view('admin/script'); ?>
  <!-- <script src="<?=base_url()?>assets/peta.js"></script> -->
  <script src="<?=base_url()?>assets/index.js"></script>
  <script src="<?=base_url()?>assets/puskesmas.js"></script>
  <!-- <script src="<?=base_url()?>assets/datatables/jquery.min.js"></script> -->
  <script src="<?=base_url()?>assets/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url('assets/bootstrap-validator/js/bootstrapValidator.min.js'); ?>"></script>
  <script type="text/javascript">
    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
      }
    hehe();
    async function hehe (){
      await sleep(1000);
      $("#sini_htmlnya").html('<script src="<?=base_url()?>assets/dist/js/lightbox.js"></'+'script>');
    }
  </script>
</body>

</html>
