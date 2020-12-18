<?php
	session_start();
	require 'koneksi.php';


	$logs = $db_connection->query('SELECT * FROM user');
	$count = 1;
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Dashboard</title>
		</head>
	<body>
		<div class="container-fluid my-3">
			<p>Selamat datang, <b><?= $_SESSION['username'] ?></b></p>
			<?= (isset($_SESSION['errlog'])) ? "<div class='alert alert-danger'>Username atau password anda salah.</div>" : "" ?>
			<div class="row">
				<?php if(isset($_SESSION['success'])): ?>
					<div class="col-md-12">
						<?php
							if($_SESSION['success']){
								echo "<div class='alert alert-success'>Gambar berhasil diunggah.</div>";
							}else{
								echo "<div class='alert alert-danger'>Gambar gagal diunggah bang.</div>";
							}
						?>
					</div>
				<?php endif; ?>
				<div class="col-md-6">
					<div class="card">
						<div class="card-body">
							<form method="POST" action="upload.php" enctype="multipart/form-data">
								<div class="form-group">
									<label>Gambar</label>
									<input type="file" name="gambar" class="form-control">
								</div>
								<input type="submit" value="Upload" class="btn btn-primary">
							</form>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Nama File</th>
									<th>Penggungah</th>
									<th>Waktu Unggah</th>
								</tr>
							</thead>
							<tbody>
								<?php while ($log = $logs->fetch_array()): ?>
								<tr>
									<?php $file = explode('/', $log['nama_file']); ?>
									<td><?= $count ?></td>
									<td><?= array_pop($file) ?></td>
									<td><?= $log['pengunggah'] ?></td>
									<td><?= $log['waktu_upload'] ?></td>
									<?php $count++; ?>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<?php unset($_SESSION['success']); ?>
