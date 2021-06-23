<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model');
	}
	
	function index()
	{
		header('Access-Control-Allow-Origin: *');
		if ($this->input->post('proses') == 'cek_foto_detail') {
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
		elseif ($this->input->post('proses') == 'cek_id') {
			$data = $this->model->tampil_data_where('tb_list_puskesmas',array('no' => $this->input->post('id')))->result();
			print_r(json_encode($data));
		}
		elseif ($this->input->post('proses') == 'pengaduan') {

			// print_r($this->input->post('data'));
			// print_r("sini dia");
			$this->model->insert('tb_pengaduan',$this->model->serialize($this->input->post('data')));
		}else{
			print_r('sini user');
		}
		
	}

	function ambil_peta()
	{
		header('Access-Control-Allow-Origin: *');

		if ($this->input->post('posisi') != '' or $this->input->post('posisi') != null) {
			# code...
			// print_r($this->input->post('cek_peta'));
			if ($this->input->post('posisi') == 'kabupaten') {
				$cek_data = $this->model->tampil_data_keseluruhan('tb_kabupaten')->result();
				$cek_data_puskesmas = $this->model->tampil_data_keseluruhan('tb_list_puskesmas')->result();
			}elseif ($this->input->post('posisi') == 'ambil_data') {
				$cek_data = $this->model->tampil_data_keseluruhan('tb_kabupaten')->result();
				$cek_data_puskesmas = $this->model->tampil_data_where('tb_list_puskesmas',array('no' => $this->input->post('id')))->result();
			}

			?>

			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBw6bnAk0C2jIDDbz_dVRso9gUEnHLTH68&libraries=drawing,places,geometry&callback=initialize"></script>

	    <script type="text/javascript" >
	      
	      var geocoder;
	      function updateMarkerPosition(latLng) {
	        // document.getElementById('info').value = [
	        return  [latLng.lat().toFixed(5),
	          latLng.lng().toFixed(5)
	        ].join(', ');
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
	          center: new google.maps.LatLng(-4.48826504, 119.57169342),
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
        		<?php if (count($cek_data_puskesmas) == 0): ?>
        			for (var i = 0; i < polygon_<?=$key1?>.getPath().getLength(); i++) {
	              bounds.extend(polygon_<?=$key1?>.getPath().getAt(i));
	            }
        		<?php endif ?>
	        		
	        <?php endforeach ?>
	            
	      	<?php foreach ($cek_data_puskesmas as $key => $value): ?>
	        	marker<?=$value->no?> = new google.maps.Marker({
			        position: new google.maps.LatLng(<?=$value->kordinat?>),
			        map: map,
			        icon: '<?=base_url()?>icon.png'
			      });
			      bounds.extend(marker<?=$value->no?>.position);
	        <?php endforeach ?>
		            
		                                         
	        <?php foreach ($cek_data_puskesmas as $ke1 => $value): ?>  
	         	google.maps.event.addListener(marker<?=$value->no?>, 'click', function(event) {
	         		
							var contentString ="<div class='form-group'>"+
																	"<table>"+
																	"<tr><td>Puskesmas </td><td>&nbsp : &nbsp</td><td> <?=$value->nama?></td></tr>"+
																	"<tr><td>Alamat </td><td>&nbsp : &nbsp</td><td> <?=$value->alamat?></td></tr>"+
							                   	"</table>"+
							                   	<?php if ($this->input->post('level') == 2): ?>
							                   		'<center><br><button type="button" title="Tampilkan Lokasi Puskesmas" class="btn btn-primary  btn-sm waves-effect waves-light" onclick="route_puskesmas(<?=$value->no?>,'+"'<?=$value->kordinat?>'"+')">Informasi & Route</button></center>'+
						                   		<?php elseif ($this->input->post('level') == 1): ?>
						                   		'<center><br><button type="button" title="Tampilkan Lokasi Warkop" class="btn btn-primary  btn-sm waves-effect waves-light" onclick="lihat_puskesmas(<?=$value->no?>)">Detail Puskesmas</button></center>'+
							                   	<?php endif ?>
							                    "</div>";

							infowindow.setContent(contentString);
							infowindow.setPosition(event.latLng);
							infowindow.open(map);
						});
	        <?php endforeach ?>      

	        map.fitBounds(bounds);

	      }




	            
	         
	      // google.maps.event.addDomListener(window, 'load', initialize);

	    </script>
	    
	    <div id="map_canvas" style="height: 600px;width: 100%"></div>
	    
			<?php
		}else{
			redirect('/home');
		}
	}




	function petanya1() 
	{
		$peta = '';
		
		$peta = explode('<coordinates>',$peta);
		$arraynya = array();
		foreach ($peta as $key => $value) {
			if ($key != 0) {
				// print_r('<br><br>');
				$peta1 = $value;
		
				$peta1 = explode(",", $peta1);
				$last_key = array_key_last($peta1);
				$teks ='';
				foreach ($peta1 as $key1 => $value1) {
					if ($value1[0] == '-') {
						// print_r('lat : '.$value1.' },');
						$teks .= 'lat : '.$value1.' },';
					}else{
						// print_r($value);
						if ($key1 != $last_key) {
							if ($key1 != 0) {
								$value1 = substr($value1,2);
							}
							// print_r('{lng : '.$value1.' , ');
							$teks .= '{lng : '.$value1.' , ';
						}
						
					}
				}
				// print_r($teks);
				$array_sini[$key] = array( array( 'kordinat' => $teks));
				$arraynya = array_merge($arraynya,$array_sini[$key]);
			}
		}
		print_r(json_encode($arraynya));


		// $ini = '{"Kabupaten" : 2 , "Kecamatan" : 5 , "Kelurahan" : 22}';
		// print_r(json_decode($ini));
	}

}
?>