<?php

function cek_login()
{
	$sci = get_instance();
	if (!$sci->session->userdata('email')) {
		$ci->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Akses ditolak. Anda belum login! </div>');
		redirect('autentifikasi');
	} else {
		$role_id = $sci->session->userdata('role_id');
	}
}
?>