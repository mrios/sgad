<?php
class pdf extends CI_Controller {


function index(){

   $this->load->helper('url');
   $mi_pdf = base_url() .'images\manual_de_usuario1.pdf';
   header('Content-type: application/pdf');
   header('Content-Disposition: attachment; filename="'.$mi_pdf.'"');
   readfile($mi_pdf);
}

}


?>