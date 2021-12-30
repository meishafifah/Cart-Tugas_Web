<?php

namespace App\Controllers;

class Produk extends BaseController
{
	protected $produkModel;

	function __construct()
	{
		$this->produkModel = new \App\Models\ProdukModel();
	}

	public function index()
	{

		// // jawaban responsi
		// if (isset($_COOKIE['produk'])) {
		// 	$arr_produk = json_decode($_COOKIE['produk'], true);
		// } else {
		// 	$arr_produk = [];
		// }
		// // end jawaban responsi

		$pencarian_id_produk = !isset($_GET['cari']) ? '' : $_GET['cari'];

		$arr_produk = $this->produkModel
			->like('kode_produk', $pencarian_id_produk)
			->get();

		$add_data = [
			'pencarian_id_produk' => $pencarian_id_produk,
			'arr_produk' => $arr_produk->getResult()
		];

		$data_view = [
			'judul' => 'List Produk',
			'page_konten' => 'produk/list',
		];

		return $this->load_template($data_view, $add_data);
	}

	public function form()
	{
		$default_id = isset($_GET['default_id']) ? $_GET['default_id'] : 'Pr-';
		$default_nama = isset($_GET['default_nama']) ? $_GET['default_nama'] : 'Produk A';
		$default_deskripsi = isset($_GET['default_deskripsi']) ? $_GET['default_deskripsi'] : '';
		$default_stok = isset($_GET['default_stok']) ? $_GET['default_stok'] : 0;
		$default_harga = isset($_GET['default_harga']) ? $_GET['default_harga'] : '0';

		$add_data = [
			'default_id' => $default_id,
			'default_nama' => $default_nama,
			'default_deskripsi' => $default_deskripsi,
			'default_stok' => $default_stok,
			'default_harga' => $default_harga,
		];

		$data_view = [
			'judul' => 'Form Produk',
			'page_konten' => 'produk/form',
		];

		return $this->load_template($data_view, $add_data);
	}

	public function proses_input()
	{
		$nama_produk = $this->request->getPost('nama_produk');
		$deskripsi_barang = $this->request->getPost('deskripsi');
		$stok = $this->request->getPost('stok_produk');
		$harga = $this->request->getPost('harga_jual');

		$id_produk_input = $_POST['id_produk'];

		$id_produk_pk = $this->request->getPost('id_produk_pk');
		if ($id_produk_pk == '') {
			$url_back_form = base_url("produk/form?default_id=$id_produk_input&default_nama=$nama_produk&default_deskripsi=$deskripsi_barang&default_stok=$stok&default_harga=$harga");
		} else {
			$url_back_form = base_url("produk/ubah?id_produk=$id_produk_pk");
		}

		if (($harga <= 0) && ($stok <= 0)) {
			return "<h2>Input Error, Harga dan Stok Minimal 1 !!!</h2>
			<a href='$url_back_form'>Klik untuk kembali ke form</a>";
		} elseif ($harga <= 0) {
			return "<h2>Input Error, Harga Minimal 1 !!!</h2>
			<a href='$url_back_form'>Klik untuk kembali ke form</a>";
		} elseif ($stok <= 0) {
			return "<h2>Input Error, Stok Minimal 1 !!!</h2>
			<a href='$url_back_form'>Klik untuk kembali ke form</a>";
		} else {
			$produk_baru = [
				'kode_produk' => $id_produk_input,
				'nama_produk' => $nama_produk,
				'deskripsi' => $deskripsi_barang,
				'stok' => $stok,
				'harga' => $harga,
				'id_produk' => $id_produk_pk,
			];

			$file_upload = $this->request->getFile('foto_produk');
			if ($file_upload->getName() != '') {
				$upload_img = $this->upload_image();

				if ($upload_img['sukses']) {
					$produk_baru['foto_produk'] = $upload_img['data'];
				} else {
					$pesan_error_kd = $upload_img['data'];
					return "<h2>Kesalahan Upload File</h2>
					$pesan_error_kd <hr/>
					<a href='$url_back_form'>Klik untuk kembali ke form</a>";
				}
			}

			if ($id_produk_pk == '') {
				$proses_db = $this->produkModel->insert($produk_baru);
			} else {
				$proses_db = $this->produkModel->update($id_produk_pk, $produk_baru);
				// $proses_db = $this->produkModel
				// ->where('id_produk', $id_produk_pk)
				// ->update($produk_baru);
			}

			if ($proses_db === false) {
				$error = $this->produkModel->errors();
				$pesan_error_kd = $error['kode_produk'];

				return "<h2>$pesan_error_kd</h2>
				<a href='$url_back_form'>Klik untuk kembali ke form</a>";
			} else {
				return redirect()->to(base_url('produk'));
			}

			// if ($this->produkModel->insert($produk_baru) === false) {
			// }
		}

		// jawaban responsi
		if (isset($_COOKIE['produk'])) {
			$arr_produk = json_decode($_COOKIE['produk'], true);

			$index_produk_unik = array_search($id_produk_input, array_column($arr_produk, 'id_produk'));
		} else {
			$arr_produk = [];
			$index_produk_unik = false;
		}

		if ($index_produk_unik === false || count($arr_produk) == 0) {

			if (($harga <= 0) && ($stok <= 0)) {
				echo "<h2>Input Error, Harga dan Stok Minimal 1 !!!</h2>
    			<a href='$url_back_form'>Klik untuk kembali ke form</a>";
			} elseif ($harga <= 0) {
				echo "<h2>Input Error, Harga Minimal 1 !!!</h2>
    			<a href='$url_back_form'>Klik untuk kembali ke form</a>";
			} elseif ($stok <= 0) {
				echo "<h2>Input Error, Stok Minimal 1 !!!</h2>
    			<a href='$url_back_form'>Klik untuk kembali ke form</a>";
			} else {

				$produk_baru = [
					'id_produk' => $id_produk_input,
					'nama_produk' => $nama_produk,
					'desk_produk' => $deskripsi_barang,
					'stok_produk' => $stok,
					'harga_produk' => $harga,
				];

				$arr_produk[] = $produk_baru;

				setcookie("produk", json_encode($arr_produk), strtotime('+7 days'), '/');

				// Load view hasil input

				$add_data = [
					'id_produk_input' => $id_produk_input,
					'nama_produk' => $nama_produk,
					'deskripsi_barang' => $deskripsi_barang,
					'stok' => $stok,
					'harga' => $harga,
				];

				$data_view = [
					'judul' => 'Detail Inputan Produk',
					'page_konten' => 'produk/detail',
				];

				return $this->load_template($data_view, $add_data);
			}
		} else {
			echo "<h2>Input Error, ID Produk '$id_produk_input' Sudah Ada !!!</h2>
    		<a href='$url_back_form'>Klik untuk kembali ke form</a>";
		}
	}

	public function ubah()
	{
		$id = $this->request->getGet('id_produk');

		$data_produk = $this->produkModel
			->where('id_produk', $id)
			->first();

		$default_id = $data_produk['kode_produk'];
		$default_nama = $data_produk['nama_produk'];
		$default_deskripsi = $data_produk['deskripsi'];
		$default_stok = $data_produk['stok'];
		$default_harga = $data_produk['harga'];

		$add_data = [
			'default_id' => $default_id,
			'default_nama' => $default_nama,
			'default_deskripsi' => $default_deskripsi,
			'default_stok' => $default_stok,
			'default_harga' => $default_harga,
			'id_produk' => $id
		];

		$data_view = [
			'judul' => 'Form Produk',
			'page_konten' => 'produk/form',
		];

		return $this->load_template($data_view, $add_data);
	}

	public function hapus()
	{
		$id = $this->request->getGet('id_produk');
		$this->produkModel->delete($id);
		return redirect()->to(base_url('produk'));
	}

	private function upload_image()
	{
		$validation = \Config\Services::validation();

		$validation->setRules([
			'foto_produk' => 'max_size[foto_produk,500]|mime_in[foto_produk,image/png,image/jpg,image/jpeg]|ext_in[foto_produk,png,jpg,jpeg]',
		]);

		if ($validation->run() !== FALSE) {

			$file = $this->request->getFile('foto_produk');

			$nama_produk = $this->request->getPost('nama_produk');

			$waktu_skrg = date("Y_m_d_H_i_s");
			$newName = $nama_produk.'_'.$waktu_skrg.'.'.$file->guessExtension();
			$folder = 'foto_produk';
			$path = $folder.'/'.$newName;
			$file->move(WRITEPATH.'../public/'.$folder, $newName);

			$fullpath = WRITEPATH.'../public/'.$path;
			$watermark = $this->watermark_foto($fullpath);

			$return_data = [
				'sukses' => true,
				'data' => $path,
			];
			
		} else {
			$return_data = [
				'sukses' => false,
				'data' => $validation->listErrors(),
			];
		}

		return $return_data;
	}

	private function watermark_foto($fullpath)
	{
		$image = \Config\Services::image()
			->withFile($fullpath)
			->text('Copyright by aku', [
				'color' => '#fff',
				'opacity' => 0.5,
				'withShadow' => true,
				'hAlign' => 'center',
				'vAlign' => 'middle',
				'fontSize' => 20
			])
			->save($fullpath);

		return true;
	}
}
