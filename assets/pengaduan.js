// var url ="http://localhost:8080/puskesmas_admin/";

var table;
$(document).ready(function() {

  //datatables
  table = $('#table2').DataTable({ 
    "searching": true,
    "bLengthChange": true,
    "ordering": true,
    "processing": true, 
    "serverSide": true, 
    "order": [], 
     
    "ajax": {
      "url": url+"admin/tables/pengaduan",
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

$(document).off("click", ".lihat_informasi").on("click", ".lihat_informasi",async function () {
  var nama = $(this).data('nama');
  var email = $(this).data('email');
  var waktu = $(this).data('waktu');
  var subjek = $(this).data('subjek');
  var ket = $(this).data('ket').split('+').join('\n');;

  var body = '<div class="form-group"><label class="control-label">Nama</label><input class="form-control" value="'+nama+'" disabled=""><div>';
  body += '<div class="form-group"><label class="control-label">Email</label><input class="form-control" value="'+email+'" disabled=""><div>';
  body += '<div class="form-group"><label class="control-label">Subjek</label><input class="form-control" value="'+subjek+'" disabled=""><div>';
  body += '<div class="form-group"><label class="control-label">Waktu</label><input class="form-control" value="'+waktu+'" disabled=""><div>';
  body += '<div class="form-group"><label class="control-label">Keterangan</label><textarea class="form-control" style="resize :none" disabled="">'+ket+'</textarea><div>';
  
  $("#sini_input_edit").html(body);
  
  
})