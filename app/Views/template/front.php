<!DOCTYPE html>
<html>
<head>
	<title><?= $judul ?></title>
</head>
<body>
	<?= $menu ?>
	<hr/>
	<h1><?= $judul ?></h1>
	<hr/>

	<!-- Konten -->
	<?= view($page_konten, $add_data) ?>
</body>
</html>