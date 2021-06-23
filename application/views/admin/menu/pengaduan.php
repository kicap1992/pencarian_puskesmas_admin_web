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

        <div class="modal fade" id="sini_modalnya" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-2">
          <div class="modal-dialog" role="document">
            <div class="modal-content">

              <div class="modal-body">
                <h5 class="card-title" id="judul_modal">Detail Pengaduan</h5>
                <div id="sini_input_edit">
                    
                </div>          
              </div>
              <div class="modal-footer">
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
          

          <div class="col-md-12">
            <div class="card" >
              <div class="card-header ">
                <h5 class="card-title">List Pengaduan User</h5>
              </div>
              <div class="card-body" style="overflow-x: auto">
                <table id="table2" class="table table-striped table-bordered" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>Waktu</th>
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
  <script src="<?=base_url()?>assets/pengaduan.js"></script>
  <script src="<?=base_url()?>assets/index.js"></script>
  <!-- <script src="<?=base_url()?>assets/puskesmas.js"></script> -->
  <!-- <script src="<?=base_url()?>assets/datatables/jquery.min.js"></script> -->
  <script src="<?=base_url()?>assets/datatables/jquery.dataTables.min.js"></script>
  
</body>

</html>
