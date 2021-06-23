    <div class="sidebar" data-color="white" data-active-color="danger">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
      -->
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          <div class="logo-image-small">
            <img src="<?=base_url()?>assets/img/logo-small.png">
          </div>
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          PUSKESMAS
          <!-- <div class="logo-image-big">
            <img src="assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li <?php if ($this->uri->segment(2) == ''): ?>class="active "<?php endif ?>>
            <a href="<?=base_url()?>admin">
              <i class="nc-icon nc-bank"></i>
              <p>Halaman Utama</p>
            </a>
          </li>
          <li <?php if ($this->uri->segment(2) == 'puskesmas'): ?>class="active "<?php endif ?>>
            <a href="<?=base_url()?>admin/puskesmas">
              <i class="nc-icon nc-ambulance"></i>
              <p>List Puskesmas</p>
            </a>
          </li>
          <li <?php if ($this->uri->segment(2) == 'pengaduan'): ?>class="active "<?php endif ?>>
            <a href="<?=base_url()?>admin/pengaduan">
              <i class="nc-icon nc-bullet-list-67"></i>
              <p>Pengaduan User</p>
            </a>
          </li>
          <li>
            <a href="#" onclick="logout()">
              <i class="nc-icon nc-button-power"></i>
              <p>Logout</p>
            </a>
          </li>

        </ul>
      </div>
    </div>
    