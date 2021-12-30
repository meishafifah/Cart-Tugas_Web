<h3>Pencarian Produk : <?= $pencarian_id_produk==''?'Tidak ada pencarian':$pencarian_id_produk ?></h3>
<hr/>

<form>
	<label>Masukkan ID</label>
	<input type="text" name="cari">
	<input type="submit" value="Cari ID">
</form>

<table border="1">
	<tr>
		<th>No.</th>
		<th>ID</th>
		<th>Nama</th>
		<th>Stok</th>
		<th>Harga</th>
		<th>Deskripsi</th>
		<th>Gambar</th>
		<th>OPSI</th>
	</tr>
	<?php 
	foreach ($arr_produk as $index => $row) { ?>

		<!-- if ($row['id_produk'] == $pencarian_id_produk || $pencarian_id_produk == '') {
			$found++;
			$no = ($found>0)?$found:($index+1);
			?> -->

			<tr>
				<td><?= $index+1 ?></td>
				<td><?= $row->kode_produk ?></td>
				<td><?= $row->nama_produk ?></td>
				<td><?= $row->stok ?></td>
				<td><?= $row->harga ?></td>
				<td><?= $row->deskripsi ?></td>
				<td>
					<img width="150" src="<?= base_url($row->foto_produk) ?>">
				</td>
				<td>
					<a href="<?= base_url('keranjang/proses?aksi=add&id_produk='.$row->id_produk); ?>">Tambahkan Ke Keranjang</a>
					
					<a href="<?= base_url('produk/ubah?id_produk='.$row->id_produk); ?>">Ubah Produk</a>

					<a href="<?= base_url('produk/hapus?id_produk='.$row->id_produk); ?>">Hapus Produk</a>
				</td>
			</tr>

			<?php 
		}		

	if (count($arr_produk) == 0) {

		echo '<td colspan="7"><b>Data Produk Tidak Ditemukan</b></td>';

	}
	?>

</table>