if (localStorage.getItem("ket") != null) {
        
  swal({
    text: localStorage.getItem("ket"),
    // title: "Pendaftaran Sukses",
    icon: "info",
    buttons: false,
    timer : 3000
  });

  
  localStorage.removeItem("ket");
  // localStorage.removeItem("nik");
}

function loginnya() {
	var username = $("#username");
	var password = $("#password");
	if (username.val() == '' || username.val() == null) {
		toastnya('username','Username tidak boleh kosong')
	}
	else if (password.val() == '' || password.val() == null) {
		toastnya('password','Password tidak boleh kosong')
	}
	else{
		$.ajax({
      url: url,
      type: 'post',
      data: {username : username.val(), password : password.val(), proses : 'login'},
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
      	$.unblockUI();
        console.log(response);
        var response = JSON.parse(response);
        if (response.ket == '1') {
        	window.location.replace(url+'admin');
        }
        else if (response.ket == '0') {
        	swal({
		        text: "Username dan Password Salah",
		        title: "Login Gagal",
		        icon: "error",
		        buttons: false
		      });
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) { 
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