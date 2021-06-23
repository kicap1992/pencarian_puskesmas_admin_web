function logout(){
  swal({
    title: "Yakin ingin Logout?",
    text: "Anda akan keluar dari sistem",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((logout) => {
    if (logout) {
      $.ajax({
        url: url+"admin/logout",
        type: 'post',
        data: {proses : 'logout'},
        // dataType: 'json',
        beforeSend: function(res) {     
          jQuery.noConflict()
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
          window.location.replace(url);

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
          // $(".sini_petanya").html("Peta Error");
          jQuery.noConflict()
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
    } else {
      swal("Terima kasih kerana masih di sistem");
    }
  });
}