<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model');
		$this->load->model('m_tabel_ss');
		$level = $this->session->userdata('level');
		if ($level != 'admin') {
			$html = '<script>localStorage.setItem("ket", "Silakan Login Terlebih Dahulu"); window.location.replace("'.base_url().'");</script>';
			print_r($html);
		}
	}
	
	function index()
	{
		if ($this->input->post('proses') == 'hapus_warkop') {
			// print_r('sini hapus');
			// print_r($this->input->post('id'));
			$dir = 'images/'.$this->input->post('id').'/';

			$files = glob($dir.'*'); // get all file names
			foreach($files as $file){ // iterate files
			  if(is_file($file))
			    unlink($file); // delete file
			}

			rmdir($dir);
			$this->model->delete('tb_list_puskesmas',array('no' => $this->input->post('id')));
			print_r("<script>localStorage.setItem('ket', 'Detail Puskesmas Berhasil Dihapus');localStorage.setItem('title', 'Sukses');</script>");
		}

		elseif ($this->input->post('proses') == 'edit_detail_puskesmas') {
			// print_r('sini_edit');
			$data = $this->model->serialize(json_decode($this->input->post('data')));
			// print_r($data);
			// print_r($this->input->post('id'));
			if ($this->input->post('foto') == 'ada') {
				// print_r('ada')
				$dir = 'images/'.$this->input->post('id').'/';

				$files = glob($dir.'*'); // get all file names
				foreach($files as $file){ // iterate files
				  if(is_file($file))
				    unlink($file); // delete file
				}


				$countfiles = count($_FILES['files']['name']);
				for($index = 0;$index < $countfiles;$index++){
				
					$filename = $_FILES['files']['name'][$index];
					$path = $dir.$filename;
					move_uploaded_file($_FILES['files']['tmp_name'][$index],$path);
				}
				// print_r($countfiles);
			}

			$this->model->update('tb_list_puskesmas',array('no' => $this->input->post('id')), $data);
			// print_r($this->db->affected_rows());
			if ($this->db->affected_rows() == 1) {
				print_r("<script>localStorage.setItem('ket', 'Detail Puskesmas Berhasil Diupdate');localStorage.setItem('title', 'Sukses');</script>");
			}
			elseif ($this->input->post('foto') == 'ada') {
				print_r("<script>localStorage.setItem('ket', 'Foto Berhasil Diupdate');localStorage.setItem('title', 'Sukses');</script>");
			}
			else{
				print_r("<script>localStorage.setItem('ket', 'Tiada Perubahan Yang Dilakukan');localStorage.setItem('title', 'Sukses');</script>");
			}
		}

		elseif ($this->input->post('proses') == 'cek_foto_detail') {
			// header('Access-Control-Allow-Origin: *');
			$html = '';
			foreach (glob('images/'.$this->input->post('id').'/*.*') as $key => $value){ 
				// print_r($key);
				if ($key == 0) {
					$html .= '<center> <a class="example-image-link" href="'.base_url().$value.'" data-lightbox="example-set" >Klik Untuk Melihat Foto</a></center>';
				}else{
					$html .= '<a class="example-image-link" href="'.base_url().$value.'" data-lightbox="example-set" ></a>';
				}
			}
			print_r($html);
		}

		elseif ($this->input->post('proses') == 'cek_data_detail') {
			$id = $this->input->post('id');
			// print_r($id);
			$data = $this->model->tampil_data_where('tb_list_puskesmas',array('no' => $id))->result();
			print_r(json_encode($data[0]));
		}

		elseif ($this->input->post('proses') == 'tambah') {
			$data = $this->model->serialize(json_decode($this->input->post('data')));
			$this->model->insert('tb_list_puskesmas',$data);
			$data_last = $this->model->tampil_data_last('tb_list_puskesmas','no')->result();
			// print_r($data_last[0]->no);
			$dir = 'images/'.$data_last[0]->no.'/';
			if(is_dir($dir) === false )
			{
			  mkdir($dir);
			}
			$countfiles = count($_FILES['files']['name']);
			for($index = 0;$index < $countfiles;$index++){
				
				$filename = $_FILES['files']['name'][$index];
				$path = $dir.$filename;
				move_uploaded_file($_FILES['files']['tmp_name'][$index],$path);
			}
			// print_r($_FILES['files']);
			// print_r($data);
			print_r("<script>localStorage.setItem('ket', 'Puskesmas Baru Telah Ditambah Dalam Sistem');localStorage.setItem('title', 'Sukses');</script>");
		}

		else{
			$main['header'] = "Halaman Utama Admin";
			$this->load->view('admin/index',$main);
		}
			
	}

	function puskesmas()
	{
		$main['kecamatan'] = $this->model->tampil_data_keseluruhan('tb_kecamatan')->result();
		$main['header'] = "Halaman List Puskesmas";
		$this->load->view('admin/menu/puskesmas',$main);
	}

	function ambil_peta_changing()
	{
		header('Access-Control-Allow-Origin: *');

		if ($this->input->post('posisi') != '' or $this->input->post('posisi') != null) {
			# code...
			// print_r($this->input->post('cek_peta'));
			if ($this->input->post('posisi') == 'kecamatan') {
				$cek_data = $this->model->tampil_data_where('tb_kecamatan',array('no' => $this->input->post('cek_peta')))->result();
				$cek_data_kelurahan = $this->model->tampil_data_where('tb_kelurahan',array('kecamatan' => $this->input->post('cek_peta')))->result();
				?>
				<script type="text/javascript">
					var html = "<option selected='' disabled=''>-Pilih Kelurahan</option>";
					<?php foreach ($cek_data_kelurahan as $key => $value): ?>
						html += "<option value='<?=$value->no?>'><?=$value->kelurahan?></option>";
					<?php endforeach ?>
					$("#kelurahan").html(html);
				</script>
				<?php
			}

			elseif ($this->input->post('posisi') == 'kelurahan') {
				$cek_data = $this->model->tampil_data_where('tb_kelurahan',array('no' => $this->input->post('cek_peta')))->result();
				$center = $cek_data[0]->center;

			}

			?>

			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBw6bnAk0C2jIDDbz_dVRso9gUEnHLTH68&libraries=drawing,places,geometry&callback=initialize"></script>

	    <script type="text/javascript" >
	      
	      var geocoder;
	      function updateMarkerPosition(latLng) {
	        // document.getElementById('info').value = [
	        return  [latLng.lat().toFixed(5),
	          latLng.lng().toFixed(5)
	        ].join(',');
	      }

	      function numberWithCommas(x) {
	        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	      }

	      function initialize() {
	        var geolib = google.maps.geometry.spherical;
	        var infowindow = new google.maps.InfoWindow({
		        size: new google.maps.Size(150, 50)
		      });

	        var myOptions = {
	          zoom: 13,
	          center: new google.maps.LatLng(-4.015210, 119.658241),
	          mapTypeControl: false,
	          // mapTypeControlOptions: {
	          // style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
	          // },
	          streetViewControl: true,
	          navigationControl: true,
	          mapTypeId: 'hybrid'
	        }
	        map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);

	        google.maps.event.addListener(map, 'click', function() {
	          infowindow.close();
	        });

	        bounds = new google.maps.LatLngBounds();

	        <?php foreach (json_decode($cek_data[0]->kordinat) as $key1 => $value1): ?>
	        	var polygon_<?=$key1?> = new google.maps.Polygon({
        			map: map,
        			path: [<?=$value1->kordinat?>],
        			strokeColor: "#000000",
							strokeOpacity: 2,
							strokeWeight: 1,
							fillColor: "#0D0822",
							fillOpacity: 0.4,
        		});
	        <?php endforeach ?>
	            
	                                         
	        <?php foreach (json_decode($cek_data[0]->kordinat) as $key1 => $value1): ?>  
	         	
	        	for (var i = 0; i < polygon_<?=$key1?>.getPath().getLength(); i++) {
              bounds.extend(polygon_<?=$key1?>.getPath().getAt(i));
            }
	        <?php endforeach ?>      


	        <?php if ($this->input->post('posisi') == 'kelurahan'): ?>
	       	 	var marker;
		        const myLatLng = <?=$center?>;
		        marker = new google.maps.Marker({position: myLatLng, map: map, draggable: true,});
	          // console.log(updateMarkerPosition(marker.getPosition()));
	          $("#kordinat").val(updateMarkerPosition(marker.getPosition()));

	          google.maps.event.addListener(marker, 'dragend', function() {
		          // updateMarkerStatus('Drag ended');
		          // geocodePosition(marker.getPosition());
		          // console.log(updateMarkerPosition(marker.getPosition()));
		          $("#kordinat").val(updateMarkerPosition(marker.getPosition()));
		        });
       	 	<?php endif ?> 
	       	
	       
	                
	        map.fitBounds(bounds);

	      }




	            
	         
	      // google.maps.event.addDomListener(window, 'load', initialize);

	    </script>
	    
	    <div id="map_canvas" style="height: 300px;width: 100%"></div>
	    
			<?php
		}else{
			redirect('/home');
		}
	}	

	function tables(){
		if ($this->uri->segment(3) == "pengaduan") {
			$list = $this->m_tabel_ss->get_datatables(array('nama','email' , 'waktu'),array(null, 'nama','email','waktu',null),array('no' => 'asc'),"tb_pengaduan",null);
	    $data = array();
	    $no = $_POST['start'];
	    foreach ($list as $field) {
	      $no++;
	      $row = array();
	      $ket = str_replace("\r\n",'+', $field->ket);
	      $row[] = $no;
	      $row[] = $field->nama;
	      $row[] = $field->email;
	      $row[] = $field->waktu;
	      $row[] = '<center><a data-toggle="modal" href="#sini_modalnya"><button type="button" title="Tampilan Pengaduan" data-nama="'.$field->nama.'" data-email="'.$field->email.'" data-waktu="'.$field->waktu.'" data-subjek="'.$field->subjek.'"  data-ket="'.$ket.'"class="lihat_informasi btn btn-primary btn-circle btn-sm waves-effect waves-light"><i class="ico fa fa-edit"></i></button></a> </center>';
	      $data[] = $row;
		  }

	    $output = array(
	      "draw" => $_POST['draw'],
	      "recordsTotal" => $this->m_tabel_ss->count_all("tb_pengaduan",null),
	      "recordsFiltered" => $this->m_tabel_ss->count_filtered(array('nama','email' , 'waktu'),array(null, 'nama','email','waktu',null),array('no' => 'asc'),"tb_pengaduan",null),
	      "data" => $data,
	    );
	    //output dalam format JSON
	    echo json_encode($output);
		}
		elseif ($this->uri->segment(3) == "puskesmas") {
			$list = $this->m_tabel_ss->get_datatables(array('nama','alamat' ,),array(null, 'nama','alamat',null),array('no' => 'asc'),'tb_list_puskesmas',null);
	    $data = array();
	    $no = $_POST['start'];
	    foreach ($list as $field) {
	      $no++;
	      $row = array();
	      // $ket = str_replace("\r\n",'+', $field->ket);
	      $row[] = $no;
	      $row[] = $field->nama;
	      $row[] = $field->alamat;
	      // $row[] = $field->kordinat;
	      // $row[] = '<center><button type="button" title="Tampilan Pengaduan" onclick="lihat_informasi('.$field->no.')" class="lihat_informasi btn btn-primary btn-circle btn-sm waves-effect waves-light"><i class="ico fa fa-edit"></i></button></center>';
	      $row[] = '<center><a data-toggle="modal" data-no="'.$field->no.'" title="Lihat Informasi Pengusulan Rencana Pembangunan" class="lihat_informasi btn btn-primary btn-sm nc-icon nc-zoom-split" href="#lihat_informasi" id="klik_15"></a></center>';
	      $data[] = $row;
		  }

	    $output = array(
	      "draw" => $_POST['draw'],
	      "recordsTotal" => $this->m_tabel_ss->count_all("tb_list_puskesmas",null),
	      "recordsFiltered" => $this->m_tabel_ss->count_filtered(array('nama','alamat' ,),array(null, 'nama','alamat',null),array('no' => 'asc'),'tb_list_puskesmas',null),
	      "data" => $data,
	    );
	    //output dalam format JSON
	    echo json_encode($output);
		}
		else{
			redirect('/admin');
		}
	}

	function pengaduan() {
		// print_r('sini pengaduan');
		$main['header'] = "Halaman Pengaduan User";
		$this->load->view('admin/menu/pengaduan',$main);
	}

	function logout() {
		if ($this->input->post('proses') == 'logout') {
			$this->session->unset_userdata('level');
		}
	}

	function ambil_kordinat_sekarang()
	{
		header('Access-Control-Allow-Origin: *');
		?>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBw6bnAk0C2jIDDbz_dVRso9gUEnHLTH68&libraries=drawing,places,geometry&callback=initialize"></script>
		<script type="text/javascript">
			let map, infoWindow;

			function initialize() {
			  map = new google.maps.Map(document.getElementById("map"), {
			    center: { lat: -34.397, lng: 150.644 },
			    mapTypeControl: false,
          // mapTypeControlOptions: {
          // style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
          // },
          streetViewControl: true,
          navigationControl: true,
          gestureHandling: "none",
  				zoomControl: false,
          mapTypeId: 'hybrid',
			    zoom: 16,
			  });
			  infoWindow = new google.maps.InfoWindow();
			  // const locationButton = document.createElement("button");
			  // locationButton.textContent = "Pan to Current Location";
			  // locationButton.classList.add("custom-map-control-button");
			  // map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);
			  // locationButton.addEventListener("click", () => {
			    // Try HTML5 geolocation.
			    if (navigator.geolocation) {
			      navigator.geolocation.getCurrentPosition(
			        (position) => {
			          const pos = {
			            lat: position.coords.latitude,
			            lng: position.coords.longitude,
			          };
			          let marker;
			          marker = new google.maps.Marker({position: pos, map: map, draggable: false});
			          // infoWindow.setPosition(pos);
			          // infoWindow.setContent("Location found.");
			          // infoWindow.open(map);
			          $("#kordinat").val(position.coords.latitude + ',' + position.coords.longitude)
			          map.setCenter(pos);
			        },
			        () => {
			          handleLocationError(true, infoWindow, map.getCenter());
			        }
			      );
			    } else {
			      // Browser doesn't support Geolocation
			      handleLocationError(false, infoWindow, map.getCenter());
			    }
			  // });
			}

			function handleLocationError(browserHasGeolocation, infoWindow, pos) {
			  infoWindow.setPosition(pos);
			  infoWindow.setContent(
			    browserHasGeolocation
			      ? "Error: The Geolocation service failed."
			      : "Error: Your browser doesn't support geolocation."
			  );
			  infoWindow.open(map);
			}
		</script>
		<div id="map" style="height: 300px;width: 100%"></div>
		<?php
	}
}
?>