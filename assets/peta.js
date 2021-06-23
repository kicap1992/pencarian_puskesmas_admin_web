function jalankan_peta() {
  // jQuery.noConflict();
  $.ajax({
    url: url+"home/ambil_peta",
    type: 'post',
    data: {posisi : 'kabupaten', level : 1},
    // dataType: 'json',
    beforeSend: function(res) {     

      $.blockUI({ 
        message: "Loading Peta", 
        css: { 
        border: 'none', 
        padding: '15px', 
        backgroundColor: '#000', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius': '10px', 
        opacity: .5, 
        color: '#fff' 
      } });
    },
    success: function (response) {
      $.unblockUI();
      $("#sini_petanya").html(response);

    },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
      // $(".sini_petanya").html("Peta Error");
      $.unblockUI();
      swal({
        // title: "Submit Keperluan ?",
        text: "Koneksi Internet Anda Mungkin Hilang Atau Terputus, Halaman Akan Terefresh Kembali",
        icon: "warning",
        buttons: {
            cancel: false,
            confirm: true,
          },
        // dangerMode: true,
      })
      .then((hehe) =>{
        location.reload();
      });

    } 
  });
}

jalankan_peta()

function lihat_puskesmas(e) {
  jQuery.noConflict();
  // $.blockUI();
  const no = e;
  let data = $.ajax({
    url: url+"admin/",
    type: 'post',
    async : false,
    data: {id : no, proses : 'cek_data_detail'},
  });
  data = JSON.parse(data.responseText);
  // console.log(data.no)
  $("#no_edit").val(data.no)
  $("#nama_edit").val(data.nama)
  $("#alamat_edit").val(data.alamat)
  // $("#info_edit").val(data.info)
  $("#kontak_edit").val(data.kontak)
  // $("#info_faskes_edit").val(data.info_faskes)
  $("#jumlah_perawat_edit").val(data.jumlah_perawat)
  let array_faskes = JSON.parse(data.array_faskes);
  let html = ''
  for (var i = 0; i < array_faskes.length; i++) {
    let ii = i+1;
    
    html += '<div class="row"><div class="col-md-12"><div class="form-group"><label>Fasilitas '+ii+'</label><input  type="text"  id="faskesnya_edit_'+i+'" class="form-control" placeholder="Nama Fasilitas Kesehatan '+i+'"  disabled="" value="'+array_faskes[i].nama+'"></div></div></div>';
    html += '<div class="row"><div class="col-md-6 pr-1"><div class="form-group"><label>Jam Buka Pelayanan</label><input type="time" class="form-control" id="buka_faskes_edit_'+i+'"  disabled="" value="'+array_faskes[i].buka+'"></div></div><div class="col-md-6 pr-1"><div class="form-group"><label>Jam Tutup Pelayanan</label><input type="time"  id="tutup_faskes_edit_'+i+'" class="form-control"  disabled="" value="'+array_faskes[i].tutup+'"></div></div></div>'

    $("#sini_tampilkan_faskes_modal").html(html)

    

  }

  let foto = $.ajax({
    url: url+"admin/",
    type: 'post',
    async : false,
    data: {id : no, proses : 'cek_foto_detail'},
  });
  console.log(foto.responseText)
  $("#ubah_sini_edit").html(foto.responseText)

  let peta = $.ajax({
    url: url+"home/ambil_peta",
    type: 'post',
    async : false,
    data: {posisi : 'ambil_data', id : no},
  });

  // console.log(peta.responseText)
  $("#sini_peta_id").html(peta.responseText)
  $('#lihat_informasi').modal({
      backdrop: 'static',
      keyboard: false
  });
  $('#lihat_informasi').modal('show'); 

}

function cek_modal() {
  location.reload()
}