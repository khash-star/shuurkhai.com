<?
$this->session->sess_destroy();
log_write("Administrator амжилттай гарлаа","logout");
redirect('welcome', 'refresh');

?>