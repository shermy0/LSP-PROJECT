// Contoh fungsi tombol simpan
function saveAssessment() {
  alert("Data asesmen berhasil disimpan!");
  // Tambahkan logic simpan ke backend (AJAX/Fetch) kalau perlu
}


document.addEventListener("DOMContentLoaded", function () {
    const btnNext = document.getElementById("btnNext");

    if (btnNext) {
        btnNext.addEventListener("click", function (e) {
            e.preventDefault(); // stop dulu

            let isValid = true;

            const fields = [
                { el: document.getElementById("judul"), msg: "Judul wajib dipilih" },
                { el: document.getElementById("nomor"), msg: "Nomor wajib diisi" },
                { el: document.getElementById("skema"), msg: "Skema wajib dipilih" }
            ];

            fields.forEach(f => {
                const errorEl = f.el.nextElementSibling; // cari pesan error di bawahnya
                if (!f.el.value || f.el.value.includes("Pilih")) {
                    f.el.classList.add("input-error");
                    f.el.classList.remove("input-success");
                    if (errorEl) {
                        errorEl.textContent = f.msg;
                        errorEl.classList.add("show");
                    }
                    isValid = false;
                } else {
                    f.el.classList.remove("input-error");
                    f.el.classList.add("input-success");
                    if (errorEl) {
                        errorEl.textContent = "";
                        errorEl.classList.remove("show");
                    }
                }
            });

            // Kalau semua valid → pindah halaman
            if (isValid) {
                window.location.href = btnNext.getAttribute("href");
            }
        });
    }
});









