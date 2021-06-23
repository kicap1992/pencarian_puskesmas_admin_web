// const url = 'http://localhost:8080/puskesmas_admin/'
// $.ajax({
//   url: url+"home/ambil_peta",
//   type: 'post',
//   data: {posisi : 'kabupaten', level : 1},
//   // dataType: 'json',
//   beforeSend: function(res) {                   
//     $.blockUI({ 
//       message: "Loading Peta", 
//       css: { 
//       border: 'none', 
//       padding: '15px', 
//       backgroundColor: '#000', 
//       '-webkit-border-radius': '10px', 
//       '-moz-border-radius': '10px', 
//       opacity: .5, 
//       color: '#fff' 
//     } });
//   },
//   success: function (response) {
//     $.unblockUI();
//     $("#sini_petanya").html(response);

//   },
//   error: function(XMLHttpRequest, textStatus, errorThrown) { 
//     // $(".sini_petanya").html("Peta Error");
//     $.unblockUI();
//     swal({
//       // title: "Submit Keperluan ?",
//       text: "Koneksi Internet Anda Mungkin Hilang Atau Terputus, Halaman Akan Terefresh Kembali",
//       icon: "warning",
//       buttons: {
//           cancel: false,
//           confirm: true,
//         },
//       // dangerMode: true,
//     })
//     .then((hehe) =>{
//       location.reload();
//     });

//   } 
// });

if (localStorage.getItem("ket") != null) {
  swal({
    text: localStorage.getItem("ket"),
    title: localStorage.getItem("title"),
    icon: "success",
    // buttons: false,
    showCancelButton: false, 
    timer: 5000
  });

  
  localStorage.removeItem("ket");
  localStorage.removeItem("title");
}



$(document).ready(function(){

  $('#sini_form').bootstrapValidator({
      message: 'This value is not valid',
      feedbackIcons: {
        // valid: 'fa fa-check',
        invalid: 'fa fa-close',
        validating: 'fa fa-circle-o-notch'
      },
    excluded: ':disabled'
  })
})


function blockUI(){
  
  $.blockUI({ 
      message: "Aktifkan \n GPS", 
      css: { 
      border: 'none', 
      padding: '15px', 
      backgroundColor: '#000', 
      '-webkit-border-radius': '10px', 
      '-moz-border-radius': '10px', 
      opacity: .5, 
      color: '#fff' 
    } });
}
if ('permissions' in navigator) {
  navigator.permissions.query({name:'geolocation'}).then(function(result) {
    if (result.state == 'granted') {
      report(result.state);
      // geoBtn.style.display = 'none';
      // 
      $.unblockUI();
    } else if (result.state == 'prompt') {
      
      blockUI();
      report(result.state);
      // geoBtn.style.display = 'none';
      // navigator.geolocation.getCurrentPosition(revealPosition,positionDenied,geoSettings);
    } else if (result.state == 'denied') {
      report(result.state);
      // geoBtn.style.display = 'inline';
      blockUI();
    }
    result.onchange = function() {
      // report(result.state);
      if (result.state == 'granted') {
          // $.noConflict();
        
        $.unblockUI();
      }else{
        blockUI();
      }
    }
  });
}

function report(state) {
  // console.log('Permission ' + state);
}

$("#usulkan").click(function (){
  
  $('#sini_form').submit();

  var error = $('#sini_form').find(".has-error").length;

  if (error == 0) {
    // console.log('jalankan')
    if ($("#files")[0].files.length == 0) {
      $('#files').val(null);
      toastnya('files','Maksimal 1 Foto diupload')
      $('#ubah_sini').html("");
    }else{
      const totalfiles = $("#files")[0].files.length
      var form_data = new FormData();
      var data = $('#sini_form').serializeArray();
      data = jQuery.grep(data, function(value) {
        return value['name'] != 'kecamatan' && value['name'] != 'kelurahan' && value['name'] != 'jumlah_faskes' ;
      });

      data = JSON.stringify(data);
      form_data.append('data', data);
      for (var index = 0; index < totalfiles; index++) {
        form_data.append("files[]", document.getElementById('files').files[index]);
      }
      form_data.append('proses', 'tambah');
      // console.log(data)
      let array_faskes = $('#array_faskes').val();

      if (array_faskes != null && array_faskes != '') 
      {
        array_faskes = JSON.parse(array_faskes);
        console.log(array_faskes)
        if (array_faskes.length != $("#jumlah_faskes").val()) {
          // toastnya('faskesnya_1','Semua Inputan Fasilitas Harus Terisi')

          toastnya('faskesnya_'+idnya,'Semua Inputan Fasilitas Harus Terisi')

        }
        else
        {
          let kosong = 'tidak_kosong';
          let idnya;
          for (var i = 0; i < array_faskes.length; ++i) {
            if (array_faskes[i].nama == '' || array_faskes[i].buka == '' || array_faskes[i].tutup == '') {
              kosong = 'kosong'
              idnya = array_faskes[i].id;
              break;
            }
          }

          if (kosong == 'kosong') {
            toastnya('faskesnya_'+idnya,'Inputan Harus Terisi');
          }
          else if (kosong == 'tidak_kosong') {
            // console.log(data)
            $.ajax({
              url: url+"admin/",
              type: 'post',
              data: form_data,
              // data: {proses : 'tambah_warkop', id : localStorage.getItem("nik"), data : data},
              contentType: false,
              processData: false,
              // dataType: 'json',
              beforeSend: function(res) {                   
                $.blockUI({ 
                  message: "Sedang Diproses", 
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
                // $.unblockUI();
                $("#sini_js").html(response);
                // console.log(response)
                location.reload()

              },
              error: function(XMLHttpRequest, textStatus, errorThrown) { 
                $.unblockUI();
                swal({
                  // title: "Submit Keperluan ?",
                  text: "Peta Gagal Ditampilkan, Koneksi Internet Anda Mungkin Hilang Atau Terputus, Halaman Akan Terefresh Kembali",
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
        }
          
      }
      else
      {
        toastnya('faskesnya_1','Semua Inputan Fasilitas Harus Terisi')
      }
        
    }
    
  }else{
    toastnya('nama','Isi Semua Inputan Dengan Benar')
  }
})

function changeTandaKordinat(e){
  
  // console.log(e);
  if (e == 1) {
    $('#kecamatan').val(null);
    $('#kelurahan').val(null);
    $('#kordinat').val(null);
    $('#div_tanda_kordinat').attr({
      'style' : 'display : none'
    });
    $("#sini_petanya1").html(null);
    $.ajax({
      url: url+"admin/ambil_kordinat_sekarang",
      type: 'post',
      // data: {cek_peta : e, posisi : 'kecamatan'},
      // dataType: 'json',
      beforeSend: function(res) {   

        $.blockUI({ 
          message: "Loading Kordinat", 
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
        console.log(response);
        $.unblockUI();
        $("#sini_petanya_kordinat").html(response);

      },
      error: function(XMLHttpRequest, textStatus, errorThrown) { 
        $.unblockUI();
        swal({
          // title: "Submit Keperluan ?",
          text: "Peta Gagal Ditampilkan, Koneksi Internet Anda Mungkin Hilang Atau Terputus, Halaman Akan Terefresh Kembali",
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
    $('#div_kordinat_sekarang').attr({
      'style' : 'display : block'
    });
  }
  else if (e == 2) {
    $('#kordinat').val(null);
    $('#div_tanda_kordinat').attr({
      'style' : 'display : block'
    });
    $('#div_kordinat_sekarang').attr({
      'style' : 'display : none'
    });
    $("#sini_petanya_kordinat").html(null);
  }
}

var text;
$('#jumlah_faskes').on('input', function() {
  text = $('#jumlah_faskes').val();
  console.log(text)
  if (text == undefined || text == null || text == '') {
    toastnya('jumlah_faskes','Jumlah Fasilitas Harus Terisi');
    $('#jumlah_faskes').val(null)
    $('#div_sini_faskes').html(null)
    $('#array_faskes').val(null)
    
  }
  else if (text > 20) {
    toastnya('jumlah_faskes','Jumlah Fasilitas Maksimal 20');
    $('#jumlah_faskes').val(null)
    $('#div_sini_faskes').html(null)
    $('#array_faskes').val(null)
  }
  else if (text <= 0) {
    toastnya('jumlah_faskes','Jumlah Fasilitas Minimal 1');
    $('#jumlah_faskes').val(null)
    $('#div_sini_faskes').html(null)
    $('#array_faskes').val(null)
  }
  else
  {
    let html = '';
    for (var i = 1; i <= text; i++) {
      
      html += '<div class="row"><div class="col-md-12"><div class="form-group"><label>Fasilitas '+i+'</label><input  type="text"  id="faskesnya_'+i+'" class="form-control" placeholder="Nama Fasilitas Kesehatan '+i+'" onkeyup="dapatkan('+i+','+text+' ,'+"'"+'nama'+"'"+')"></div></div></div>';
      html += '<div class="row"><div class="col-md-6 pr-1"><div class="form-group"><label>Jam Buka Pelayanan</label><input type="time" class="form-control" id="buka_faskes_'+i+'" oninput="dapatkan('+i+','+text+' ,'+"'"+'buka'+"'"+')"></div></div><div class="col-md-6 pr-1"><div class="form-group"><label>Jam Tutup Pelayanan</label><input type="time"  id="tutup_faskes_'+i+'" class="form-control" oninput="dapatkan('+i+','+text+' ,'+"'"+'tutup'+"'"+')"></div></div></div>'

      $("#div_sini_faskes").html(html)

      

    }
  }
});


function dapatkan(idnya,jum,kat){
  // console.log(i)
  let array_faskes = $('#array_faskes').val();
  

  if (array_faskes != null && array_faskes != '') {
    // console.log(JSON.parse(array_faskes))
    array_faskes = JSON.parse(array_faskes);
          // for (const [key, value] of Object.entries(array_faskes)) {
    //   if (value.id == ) {}
    // }

    let ada = 'tiada';
    let id_perlu ;
    for (var i = 0; i < array_faskes.length; ++i) {
      if (array_faskes[i].id == idnya) {
        ada = 'ada';
        id_perlu = i;
        break;
      }
      // console.log(array_faskes[i].id)
    }

    // console.log(ada)
    if (ada == 'ada') {
      // 
      // console.log(array_faskes[id_perlu]);
      if (kat == 'nama') {
        array_faskes[id_perlu].nama = $("#faskesnya_"+idnya).val();
      }
      else if (kat == 'buka') {
        array_faskes[id_perlu].buka = $("#buka_faskes_"+idnya).val();
      }
      else if (kat == 'tutup') {
        array_faskes[id_perlu].tutup = $("#tutup_faskes_"+idnya).val();
      }
      
      $('#array_faskes').val(JSON.stringify(array_faskes))

    }
    else if ('tiada') {
      let buka;
      if (kat == 'nama') {
        buka = [{"id" : idnya ,"nama" : $("#faskesnya_"+idnya).val() , 'buka' : '' , 'tutup' : ''}];
      }
      else if (kat == 'buka') {
        buka = [{"id" : idnya ,"nama" : '', 'buka' : $("#buka_faskes_"+idnya).val() , 'tutup' : ''}];
      }
      else if (kat == 'tutup') {
        buka = [{"id" : idnya ,"nama" : '', 'buka' : '' , 'tutup' : $("#tutup_faskes_"+idnya).val()}];
      }
      
      array_faskes = array_faskes.concat(buka)
      $('#array_faskes').val(JSON.stringify(array_faskes))
    }
    console.log(array_faskes)

  }
  else
  {
    let buka;
    if (kat) {}
    buka = [{"id" : idnya ,"nama" : '' , 'buka' : $("#buka_faskes_"+idnya).val() , 'tutup' : ''}];
    $('#array_faskes').val(JSON.stringify(buka))
  }

}

function editkan(idnya,jum,kat){
  // console.log(i)
  let array_faskes = $('#array_faskes_edit').val();
  array_faskes = JSON.parse(array_faskes)
  

  if (kat == 'nama') {
    array_faskes[idnya].nama = $("#faskesnya_edit_"+idnya).val();
  }
  else if (kat == 'buka') {
    array_faskes[idnya].buka = $("#buka_faskes_edit_"+idnya).val();
  }
  else if (kat == 'tutup') {
    array_faskes[idnya].tutup = $("#tutup_faskes_edit_"+idnya).val();
  }
  
  $('#array_faskes_edit').val(JSON.stringify(array_faskes))

}

function changeKecamatan(e){
  // $.noConflict();
  
  // console.log(e);
  $.ajax({
    url: url+"admin/ambil_peta_changing",
    type: 'post',
    data: {cek_peta : e, posisi : 'kecamatan'},
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
      // console.log(response);
      $.unblockUI();
      $("#sini_petanya1").html(response);

    },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
      $.unblockUI();
      swal({
        // title: "Submit Keperluan ?",
        text: "Peta Gagal Ditampilkan, Koneksi Internet Anda Mungkin Hilang Atau Terputus, Halaman Akan Terefresh Kembali",
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

function changeKelurahan(e){

  // console.log(e);
  $.ajax({
    url: url+"admin/ambil_peta_changing",
    type: 'post',
    data: {cek_peta : e, posisi : 'kelurahan'},
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
      // console.log(response);
      $.unblockUI();
      $("#sini_petanya1").html(response);

    },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
      $.unblockUI();
      swal({
        // title: "Submit Keperluan ?",
        text: "Peta Gagal Ditampilkan, Koneksi Internet Anda Mungkin Hilang Atau Terputus, Halaman Akan Terefresh Kembali",
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

function previewImage() {
  var file = document.getElementById('files');
  if ($("#files")[0].files.length == 0) {        
    $('#files').val(null);
    toastnya('files','Maksimal 1 Foto diupload')
    $('#ubah_sini').html("");
  }
  else if (cek_nama_foto(0) == 0) {
    // console.log('foto salah')
    $('#ubah_sini').html("");
    $('#files').val(null);
    toastnya('files','Foto harus berektensi .jpg , .jpeg dan .png')
  }
  else if (cek_nama_foto(0) == 2) {
    // console.log('foto salah')
    $('#ubah_sini').html("");
    $('#files').val(null);
    toastnya('files','Saiz foto maksimal 1.5 mb')
  }
  else{
    var text = ''
    ii = 0 ;
    for (var i = 0; i < file.files.length; i++) {
      var oFReader = new FileReader();
      oFReader.readAsDataURL(document.getElementById("files").files[i]);

      oFReader.onload = function(oFREvent) {
        // document.getElementById("image-preview").src = oFREvent.target.result;
        // console.log(oFREvent.target.result);

        // text+='<center><img class="example-image" src="'+oFREvent.target.result+'" width="100px" height="100px" alt=""/></center>';
        if (ii==0) {
          text +='<center> <a class="example-image-link" href="'+oFREvent.target.result+'" data-lightbox="example-set" >Klik Untuk Melihat Foto</a></center>';
          console.log(ii);
        }
        if (ii > 0) {
          text+='<center> <a class="example-image-link" href="'+oFREvent.target.result+'" data-lightbox="example-set" ></a></center>';
          console.log('heeh');
        }
        // console.log(ii);
        $('#ubah_sini').html(text);
        ii += 1;
      };
      // console.log(i);
    }
  }      
}

function cek_nama_foto(e){
  let id;
  if (e == 0) {
    id = "#files";
  }else if (e == 1) {
    id = "#files_edit";
  }
  var kembali = 0
  for (var i = 0; i < $(id)[0].files.length; i++) {
    var name = $(id)[0].files[i].name;
    var size = $(id)[0].files[i].size;
    name = name.split('.').pop().trim();
      // console.log(name);
    if (name !== 'jpg' && name !== 'jpeg' && name !== 'png') {
      kembali = 0
    }
    else if (size > 1000000) {
      kembali = 2
    }
    else{
      kembali = 1
    }
  }
  return kembali
}

function toastnya(id,mesej){
  toastr.options = {
    "closeButton": true,
    "debug": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  };

  toastr.error("<center>"+mesej+"</center>");
  $("#"+id).focus();
}

function setInputFilter(textbox, inputFilter) {
  ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
    textbox.addEventListener(event, function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    });
  });
}


// Install input filters.
setInputFilter(document.getElementById("kontak"), function(value) { return /^-?\d*$/.test(value); });
setInputFilter(document.getElementById("jumlah_perawat"), function(value) { return /^-?\d*$/.test(value); });
setInputFilter(document.getElementById("kontak_edit"), function(value) { return /^-?\d*$/.test(value); });
setInputFilter(document.getElementById("jumlah_perawat_edit"), function(value) { return /^-?\d*$/.test(value); });
setInputFilter(document.getElementById("jumlah_faskes"), function(value) { return /^-?\d*$/.test(value); });

var table;
$(document).ready(function() {

  //datatables
  table = $('#table1').DataTable({ 
    // "searching": false,
    "ordering": false,
    "processing": true, 
    "serverSide": true, 
    "order": [], 
     
    "ajax": {
      "url": url+"admin/tables/puskesmas",
      "type": "POST"
    },

     
    "columnDefs": [
      { 
        "targets": [ 0 ], 
        "orderable": false, 
      },
    ],

  });

});


$(document).on("click", ".lihat_informasi", function () {
  $('#ubah_sini').html("");
  $("#files").val(null)
  $(".btn_edit").attr('class','btn_edit btn btn-info btn-sm waves-effect waves-light')
  $(".btn_edit").attr('onclick','edit()')
  $(".btn_edit").html('Edit?')
  const no = $(this).data('no');
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
  $("#kontak_edit").val(data.kontak)
  $("#jumlah_perawat_edit").val(data.jumlah_perawat)
  $("#array_faskes_edit").val(data.array_faskes)
  let array_faskes = JSON.parse(data.array_faskes);
  // console.log(array_faskes);
  let html = '';
  for (var i = 0; i < array_faskes.length; i++) {
    let ii = i+1;
    
    html += '<div class="row"><div class="col-md-12"><div class="form-group"><label>Fasilitas '+ii+'</label><input  type="text"  id="faskesnya_edit_'+i+'" class="form-control" placeholder="Nama Fasilitas Kesehatan '+i+'" onkeyup="editkan('+i+','+text+' ,'+"'"+'nama'+"'"+')" disabled="" value="'+array_faskes[i].nama+'"></div></div></div>';
    html += '<div class="row"><div class="col-md-6 pr-1"><div class="form-group"><label>Jam Buka Pelayanan</label><input type="time" class="form-control" id="buka_faskes_edit_'+i+'" oninput="editkan('+i+','+text+' ,'+"'"+'buka'+"'"+')" disabled="" value="'+array_faskes[i].buka+'"></div></div><div class="col-md-6 pr-1"><div class="form-group"><label>Jam Tutup Pelayanan</label><input type="time"  id="tutup_faskes_edit_'+i+'" class="form-control" oninput="editkan('+i+','+text+' ,'+"'"+'tutup'+"'"+')" disabled="" value="'+array_faskes[i].tutup+'"></div></div></div>'

    $("#sini_tampilkan_faskes_modal").html(html)
  }

  let foto = $.ajax({
    url: url+"admin/",
    type: 'post',
    async : false,
    data: {id : no, proses : 'cek_foto_detail'},
  });
  // console.log(foto.responseText)
  $("#ubah_sini_edit").html(foto.responseText)

  let peta = $.ajax({
    url: url+"home/ambil_peta",
    type: 'post',
    async : false,
    data: {posisi : 'ambil_data', id : no},
  });

  // console.log(peta.responseText)
  $("#sini_peta_id").html(peta.responseText)
})

var foto_ada = 0;

function edit() {
  $(".btn_edit").html("Edit");
  $(".btn_edit").attr('class','btn_edit btn btn-success btn-sm waves-effect waves-light')
  $(".btn_edit").attr('onclick','konfirm_edit()')
  $("#div_upload_foto_edit").attr('style','display: block')
  $("#sini_form_edit input").prop("disabled", false);
  $("#sini_form_edit textarea").prop("disabled", false);
  $("#nama_edit").focus() 
  foto_ada = 0;
}

function edit_foto() {
  $("#files_edit").val(null)
  $("#ubah_sini_edit").attr('style',"display : none")
  $('#ubah_sini_edit').html("");
  $("#files_edit").attr('style',"display : block")
  $(".btn_foto_edit").attr('class',"btn_foto_edit btn btn-warning btn-sm waves-effect waves-light")
  $(".btn_foto_edit").attr('onclick',"batal_foto_edit()")
  $(".btn_foto_edit").html("Batal Upload Foto Baru")
  foto_ada = 1;
}

function batal_foto_edit() {
  $('#ubah_sini_edit1').html("");
  $("#ubah_sini_edit").attr('style',"display : block")
  $("#files_edit").attr('style',"display : none")
  $(".btn_foto_edit").attr('class',"btn_foto_edit btn btn-info btn-sm waves-effect waves-light")
  $(".btn_foto_edit").attr('onclick',"edit_foto()")
  $(".btn_foto_edit").html("Upload Foto Baru")

  let data = $.ajax({
    url: url+"admin/",
    type: 'post',
    async : false,
    data: {id : $("#no_edit").val(), proses : 'cek_foto_detail'},
  });
  $("#ubah_sini_edit").html(data.responseText)

  foto_ada = 0
}

$(document).ready(function(){

  $('#sini_form_edit').bootstrapValidator({
      message: 'This value is not valid',
      feedbackIcons: {
        // valid: 'fa fa-check',
        invalid: 'fa fa-close',
        validating: 'fa fa-circle-o-notch'
      },
    excluded: ':disabled'
  })
})

function konfirm_edit() {
  
  $('#sini_form_edit').submit();
  var form_data = new FormData();
  var data = $('#sini_form_edit').serializeArray();
  var error = $('#sini_form_edit').find(".has-error").length;

  if (error == 0) {
    data = JSON.stringify(data);
    form_data.append('data', data);
    form_data.append('id', $("#no_edit").val());
    form_data.append('proses', 'edit_detail_puskesmas');
    console.log(data)
    // console.log(foto_ada)
    if (foto_ada == 0) {
      // console.log('jalankan')

      form_data.append('foto', 'tiada');
      $.ajax({
        url: url+"admin/",
        type: 'post',
        data: form_data,
        // data: {proses : 'tambah_warkop', id : localStorage.getItem("nik"), data : data},
        contentType: false,
        processData: false,
        // dataType: 'json',
        beforeSend: function(res) {    
          $('#lihat_informasi').modal('hide');               
          $.blockUI({ 
            message: "Sedang Diproses", 
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
          // $.unblockUI();
          $("#sini_js").html(response);
          // console.log(response)
          location.reload()

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
          $.unblockUI();
          swal({
            // title: "Submit Keperluan ?",
            text: "Request Gagal Dilakukan, Sila Refresh Kembali Halaman Ini",
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
    else if (foto_ada == 1) {
      if ($("#files_edit")[0].files.length == 0) {
        $('#files_edit').val(null);
        toastnya('files_edit','Maksimal 1 Foto diupload')
        $('#ubah_sini_edit1').html("");
        $('#ubah_sini_edit').html("");
      }
      else{
        const totalfiles = $("#files_edit")[0].files.length
        for (var index = 0; index < totalfiles; index++) {
          form_data.append("files[]", document.getElementById('files_edit').files[index]);
        }

        form_data.append('foto', 'ada');
        // console.log('jalankan');
        $.ajax({
          url: url+"admin/",
          type: 'post',
          data: form_data,
          // data: {proses : 'tambah_warkop', id : localStorage.getItem("nik"), data : data},
          contentType: false,
          processData: false,
          // dataType: 'json',
          beforeSend: function(res) {  
            $('#lihat_informasi').modal('hide');                  
            $.blockUI({ 
              message: "Sedang Diproses", 
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
            // $.unblockUI();
            $("#sini_js").html(response);
            // console.log(response)
            location.reload()

          },
          error: function(XMLHttpRequest, textStatus, errorThrown) { 
            $.unblockUI();
            swal({
              // title: "Submit Keperluan ?",
              text: "Request Gagal Dilakukan, Sila Refresh Kembali Halaman Ini",
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
    }
  }
}

function previewImage_edit() {
  var file = document.getElementById('files_edit');
  if ($("#files_edit")[0].files.length == 0) {        
    $('#files_edit').val(null);
    toastnya('files_edit','Maksimal 1 Foto diupload')
    $('#ubah_sini_edit1').html("");
    $('#ubah_sini_edit').html("");
  }
  else if (cek_nama_foto(1) == 0) {
    // console.log('foto salah')
    $('#ubah_sini_edit1').html("");
    $('#ubah_sini_edit').html("");
    $('#files_edit').val(null);
    toastnya('files_edit','Foto harus berektensi .jpg , .jpeg dan .png')
  }
  else if (cek_nama_foto(1) == 2) {
    // console.log('foto salah')
    $('#ubah_sini_edit1').html("");
    $('#ubah_sini_edit').html("");
    $('#files_edit').val(null);
    toastnya('files_edit','Saiz foto maksimal 1.5 mb')
  }
  else{
    var text = ''
    ii = 0 ;
    for (var i = 0; i < file.files.length; i++) {
      var oFReader = new FileReader();
      oFReader.readAsDataURL(document.getElementById("files_edit").files[i]);

      oFReader.onload = function(oFREvent) {
        // document.getElementById("image-preview").src = oFREvent.target.result;
        // console.log(oFREvent.target.result);

        // text+='<center><img class="example-image" src="'+oFREvent.target.result+'" width="100px" height="100px" alt=""/></center>';
        if (ii==0) {
          text +='<center> <a class="example-image-link" href="'+oFREvent.target.result+'" data-lightbox="example-set" >Klik Untuk Melihat Foto</a></center>';
          // console.log(ii);
        }
        if (ii > 0) {
          text+='<center> <a class="example-image-link" href="'+oFREvent.target.result+'" data-lightbox="example-set" ></a></center>';
          // console.log('heeh');
        }
        // console.log(text);
        $('#ubah_sini_edit1').html(text);
        $('#ubah_sini_edit').html("");
        ii += 1;
      };
      // console.log(i);
    }
  }      
}

function hapus() {
  
  const id = $("#no_edit").val();
  // console.log(id)
  swal({
    title: "Yakin ingin hapus detail puskesmas?",
    text: "Detail puskesmas akan terhapus permanen dari sistem",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((logout) => {
    if (logout) {
      // localStorage.removeItem("nik");
      // localStorage.removeItem("level");
      // window.location.href ='../index.html';
      // alert('terhapus')
      $.ajax({
        url: url+"admin/",
        type: 'post',
        // data: form_data,
        data: {proses : 'hapus_warkop', id : id},
        // contentType: false,
        // processData: false,
        // dataType: 'json',
        beforeSend: function(res) {  
          $('#lihat_informasi').modal('hide');                  
          $.blockUI({ 
            message: "Sedang Diproses", 
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
          // $.unblockUI();
          $("#sini_js").html(response);
          // console.log(response)
          location.reload()

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
          $.unblockUI();
          swal({
            // title: "Submit Keperluan ?",
            text: "Request Gagal Dilakukan, Sila Refresh Kembali Halaman Ini",
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
  });
}