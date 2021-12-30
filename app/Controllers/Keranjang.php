<?php

namespace App\Controllers;

class Keranjang extends BaseController
{

    function __construct()
    {
        if (isset($_COOKIE['keranjang'])) {
            $_SESSION['keranjang'] = json_decode($_COOKIE['keranjang'], true);
        }
    }

    public function index()
    {

    	if (isset($_COOKIE['keranjang'])) {
            $_SESSION['keranjang'] = json_decode($_COOKIE['keranjang'], true);
        }

        if (!isset($_SESSION['keranjang'])) {
            $_SESSION['keranjang'] = array();
        }

		$add_data = [
			'data_keranjang' => $_SESSION['keranjang']
		];

		$data_view = [
			'judul' => 'List Keranjang Belanja',
			'page_konten' => 'keranjang/list',
		];

        return $this->load_template($data_view, $add_data);
    }

    public function proses()
    {
        if ($_GET['aksi'] == 'hapus') {
            $this->hapus_keranjang($_GET['id_produk']);
        } else {
            $this->tambahkan_keranjang();
        }

        // untuk redirect menggantikan header location
        return redirect()->to(base_url('keranjang'));
    }

    private function tambahkan_keranjang()
    {
        if (!isset($_SESSION['keranjang'])) {
            $_SESSION['keranjang'] = array();
        } else {
            $index_produk = array_search($_GET['id_produk'], array_column($_SESSION['keranjang'], 'id_produk'));
        }

        if (count($_SESSION['keranjang']) == 0 || $index_produk === false) {
            $keranjang_baru = [
                'id_produk' => $_GET['id_produk'],
                'nama_produk' => $_GET['nama_produk'],
                'harga_produk' => $_GET['harga_produk'],
                'jumlah' => 1,
            ];

            $_SESSION['keranjang'][] = $keranjang_baru;
        } else {
            $_SESSION['keranjang'][$index_produk]['jumlah']++;
        }

        setcookie("keranjang", json_encode($_SESSION['keranjang']), strtotime('+7 days'), '/');

        // header('Location: http://localhost:8081/cart_online/keranjang.php');
        // exit();

              
    }

    private function hapus_keranjang($id_produk)
    {
        $index_produk = array_search($id_produk, array_column($_SESSION['keranjang'], 'id_produk'));

        if ($index_produk !== false) {          
            array_splice($_SESSION['keranjang'], $index_produk, 1);
        }   

        setcookie("keranjang", json_encode($_SESSION['keranjang']), strtotime('+7 days'), '/'); 

        // header('Location: http://localhost:8081/cart_online/keranjang.php');
        // exit(); 
    }
}
