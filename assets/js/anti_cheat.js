let pelanggaran = 0;
let timeoutPelanggaran = null;
let sedangSubmit = false;

// Deteksi jika user klik submit
document.getElementById("formSoal")?.addEventListener("submit", function () {
	sedangSubmit = true;
});

document.addEventListener("visibilitychange", function () {
	if (document.hidden && !sedangSubmit) {
		pelanggaran++;

		// Kirim log ke database
		fetch(base_url + "log/simpan", {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify({
				user_id: userId,
				jenis: "Pindah Tab",
				detail: `Pelanggaran ke-${pelanggaran}: siswa berpindah tab`,
			}),
		});

		// Jika pelanggaran 3 kali atau lebih, langsung dihentikan
		if (pelanggaran >= 3) {
			alert("⚠️ Anda terlalu sering berpindah tab. Ujian dihentikan!");
			document.getElementById("formSoal")?.submit();
			return;
		}

		// Peringatan biasa jika masih < 3
		alert(
			`⚠️ Peringatan! Anda telah pindah tab ${pelanggaran} kali.\nJika tidak kembali dalam 20 detik, ujian akan dihentikan!`
		);

		// Optional: Suara peringatan (aktifkan jika punya file MP3)
		// const audio = new Audio(base_url + "assets/sound/warning.mp3");
		// audio.play();

		// Timeout 20 detik
		timeoutPelanggaran = setTimeout(() => {
			alert(
				"⛔ Anda tidak kembali ke halaman ujian dalam 20 detik. Ujian dihentikan!"
			);
			document.getElementById("formSoal")?.submit();
		}, 20000);
	} else {
		// Jika kembali ke tab → batalkan timeout
		if (timeoutPelanggaran) {
			clearTimeout(timeoutPelanggaran);
			timeoutPelanggaran = null;
			console.log("✅ Siswa kembali dalam 20 detik, ujian lanjut.");
		}
	}
});

// Nonaktif klik kanan & shortcut
document.addEventListener("contextmenu", (e) => e.preventDefault());

document.addEventListener("keydown", (e) => {
	if (
		(e.ctrlKey && ["u", "U"].includes(e.key)) ||
		e.key === "F12" ||
		(e.ctrlKey && e.shiftKey && ["I", "C"].includes(e.key))
	) {
		e.preventDefault();
		alert("❌ Shortcut ini dinonaktifkan selama ujian!");
	}
});
