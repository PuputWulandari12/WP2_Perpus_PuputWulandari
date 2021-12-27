<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6">
			<?php if(validation_errors()) { ?>
				<div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
				<?php } ?>
				<form action="<?= base_url('buku/editKategori'); ?>" method="post">
					<?php
					foreach ($kategori as $k) :  ?>
						<div class="form-group">
							<input type="hidden" name="id_kategori" id="id_kategori" value="<?php echo $k['id_kategori']; ?>">
							<input type="text" class="form-control form-control-user" id="nama_kategori" name="nama_kategori" placeholder="Masukan Kategori Buku" value="<?= $k['nama_kategori']; ?>">
						</div>
					<?php
					endforeach; ?>

						<div class="form-group">
							<input type="button" class="form-control form-control-user btn btn-dark col-lg-3 mt-3" value="Kembali" onclick="window.history.go(-1)">
							<input type="submit" class="form-control form-control-user btn btn-primary col-lg-3 mt-3" value="Update">
						</div>
					</form>
			</div>
		</div>
</div>