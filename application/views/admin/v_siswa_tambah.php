<?php if (validation_errors()) : ?>
  <div class="alert alert-danger" style="margin: 0 15px 15px 15px;">
    <?= validation_errors('<p class="mb-0">', '</p>'); ?>
  </div>
<?php endif; ?>

<form id="form-siswa" action="<?= base_url('siswa/create'); ?>" method="post" class="form-horizontal">
  <div class="box-body">
    <div class="form-group">
      <label class="col-sm-3 control-label">Nama</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="nama" value="<?= set_value('nama'); ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label">NIS</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="nis" value="<?= set_value('nis'); ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label">Kelas</label>
      <div class="col-sm-8">
        <select class="form-control" name="kelas">
          <option value="">--Pilih Kelas--</option>
          <?php foreach($kelas as $k) { ?>
            <option value="<?= $k->id_kelas ?>" <?= set_select('kelas', $k->id_kelas); ?>><?= $k->nama_kelas; ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label">Username</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="username" value="<?= set_value('username'); ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label">Password</label>
      <div class="col-sm-8">
        <input type="password" class="form-control" name="password">
      </div>
    </div>
  </div>
  <div class="box-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
    <button type="submit" class="btn btn-primary btn-flat pull-right">Simpan</button>
  </div>
</form>