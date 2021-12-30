<table border="1">
	<tr>
		<th>Nama Produk</th>
		<th>Jumlah Beli</th>
		<th>Harga</th>
		<th>Opsi</th>
	</tr>
	<?php foreach ($data_keranjang as $index => $row) { ?>
	<tr>
		<td><?= $row['nama_produk'] ?></td>
		<td><?= $row['jumlah'] ?></td>
		<td><?= ($row['harga_produk']*$row['jumlah']) ?></td>
		<td>
			<a href="<?= 'keranjang/proses?id_produk='.$row['id_produk'].'&aksi=hapus' ?>">Hapus</a>
		</td>
	</tr>
	<?php } ?>
</table>