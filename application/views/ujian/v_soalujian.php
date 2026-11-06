<?php
$this->load->view('ujian/head');
?>

<style>
    #timer_place{
        margin:0 auto;
        text-align:center;
    }
    #counter{
        border-radius:7px;
        border:2px solid gray;
        padding:7px;
        font-size:2em;
        font-weight:bolder;
    }
</style>

<?php
$this->load->view('ujian/topbar');

// Logika ini sudah ditangani oleh controller Ruang_ujian, jadi di sini tidak diperlukan lagi
// if(isset($_SESSION["waktu_start"])){
//  $lewat = time() - $_SESSION["waktu_start"];
// }else{
//  $_SESSION["waktu_start"] = time();
//  $lewat = 0;
// }
?>

<section class="content">
  <div class="row">
    <div class="col-md-3">
        <div class="box box-success">
            <div class="box-header text-center">
                <h4 class="box-title">Waktu Anda</h4>
            </div>
            <div class="box-body" id="timer_place">
                <span id="counter" align="center"></span>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="box box-success box-solid">
            <div class="box-header with-border">
               <center> <h3 class="box-title">Soal Ujian</h3> </center>
            </div>
            <div class="box-body" style="overflow-y: scroll;height: 525px;">
                <form id="formSoal" role="form" action="<?php echo base_url(); ?>ruang_ujian/jawab_aksi" method="post" onsubmit="return confirm('Anda Yakin Ingin Mengakhiri Ujian?')">

                    <input type="hidden" name="id_peserta" value="<?php echo $id['id_peserta']; ?>">
                    <input type="hidden" name="jumlah_soal" value="<?php echo $total_soal; ?>">

                    <?php $no = 0;
                    foreach ($soal as $s) {
                        $no++ ?>
                        <div class="form-group">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td width="1%"><?php echo $no; ?>.</td>
                                        <td>
                                            <?php echo $s->pertanyaan; ?>
                                            <input type='hidden' name='soal[]' value='<?php echo $s->id_soal_ujian; ?>' />
                                            <hr>
                                            <input type="radio" name="jawaban[<?php echo $s->id_soal_ujian; ?>]" value="A" required /> <?php echo $s->a; ?><br>
                                            <input type="radio" name="jawaban[<?php echo $s->id_soal_ujian; ?>]" value="B" required /> <?php echo $s->b; ?><br>
                                            <input type="radio" name="jawaban[<?php echo $s->id_soal_ujian; ?>]" value="C" required /> <?php echo $s->c; ?><br>
                                            <input type="radio" name="jawaban[<?php echo $s->id_soal_ujian; ?>]" value="D" required /> <?php echo $s->d; ?><br>
                                            <input type="radio" name="jawaban[<?php echo $s->id_soal_ujian; ?>]" value="E" required /> <?php echo $s->e; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                    <button type="submit" class="btn btn-primary btn-flat pull-right">Selesai Ujian</button>
                </form>
            </div>
        </div>
    </div>      
</div>
</section><?php
$this->load->view('ujian/js');
?>

<script type="text/javascript">
$(function(){
    // Inisialisasi Timer Countdown
    var sisa_waktu = <?= $max_time; ?>;
    $("#counter").countdown({
        until: sisa_waktu,
        compact: true,
        onExpiry: function() {
            alert('Waktu Anda telah habis, jawaban akan disimpan secara otomatis.');
            document.getElementById("formSoal").submit(); 
        },
        onTick: function(periods) {
            if ($.countdown.periodsToSeconds(periods) === 60) {
                $(this).css({color: "red"});
            }
        }
    });

    // --- Kode Anti-Contek ---
    var base_url = "<?= base_url() ?>";
    var userId = "<?= $id['id_peserta'] ?>";
    let pelanggaran = 0;
    let timeoutPelanggaran = null;
    let sedangSubmit = false;

    document.getElementById("formSoal").addEventListener("submit", function () {
        sedangSubmit = true;
    });

    document.addEventListener("visibilitychange", function () {
        if (document.hidden && !sedangSubmit) {
            pelanggaran++;
            fetch(base_url + "log/simpan", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    user_id: userId,
                    jenis: "Pindah Tab",
                    detail: `Pelanggaran ke-${pelanggaran}: siswa berpindah tab`,
                }),
            });
            if (pelanggaran >= 3) {
                alert("⚠️ Anda terlalu sering berpindah tab. Ujian dihentikan!");
                document.getElementById("formSoal")?.submit();
                return;
            }
            alert(`⚠️ Peringatan! Anda telah pindah tab ${pelanggaran} kali.\nJika tidak kembali dalam 20 detik, ujian akan dihentikan!`);
            timeoutPelanggaran = setTimeout(() => {
                alert("⛔ Anda tidak kembali ke halaman ujian dalam 20 detik. Ujian dihentikan!");
                document.getElementById("formSoal")?.submit();
            }, 20000);
        } else {
            if (timeoutPelanggaran) {
                clearTimeout(timeoutPelanggaran);
                timeoutPelanggaran = null;
            }
        }
    });

    document.addEventListener("contextmenu", (e) => e.preventDefault());

    document.addEventListener("keydown", (e) => {
        if ((e.ctrlKey && ["u", "U"].includes(e.key)) || e.key === "F12" || (e.ctrlKey && e.shiftKey && ["I", "C"].includes(e.key))) {
            e.preventDefault();
            alert("❌ Shortcut ini dinonaktifkan selama ujian!");
        }
    });

    // Mencegah tombol back
    window.location.hash = "no-back-button";
    window.location.hash = "Again-No-back-button"; //
    window.onhashchange = function () {
        window.location.hash = "no-back-button";
    }
});
</script>


<?php
$this->load->view('ujian/foot');
?>