// ========================
// 📢 Fitur Alert Animasi
// ========================
function showAlert(message, type = "success") {
    const alertBox = document.createElement("div");
    alertBox.classList.add("custom-alert", type);
    alertBox.innerText = message;

    document.body.appendChild(alertBox);

    // Animasi masuk
    setTimeout(() => {
        alertBox.classList.add("show");
    }, 10);

    // Hapus setelah 3 detik
    setTimeout(() => {
        alertBox.classList.remove("show");
        setTimeout(() => alertBox.remove(), 500);
    }, 3000);
}

// ========================
// 💾 Simpan Data Asesmen
// ========================
function saveAssessment() {
    showAlert("Data asesmen berhasil disimpan!", "success");
}

// ========================
// 📂 Upload File
// ========================
function handleFileUpload(event) {
    const file = event.target.files[0];
    if (file) {
        showAlert("File terpilih: " + file.name, "info");
    }
}

window.addEventListener("load", () => {
  const canvases = ["ttd-asesi", "ttd-asesor"];

  canvases.forEach(id => {
    const canvas = document.getElementById(id);
    if (!canvas) return; // <--- tambahin ini biar skip kalau canvas ga ada

    const ctx = canvas.getContext("2d");

    canvas.width = canvas.clientWidth;
    canvas.height = canvas.clientHeight;

    ctx.strokeStyle = "#000";
    ctx.lineWidth = 2;
    ctx.lineJoin = "round";
    ctx.lineCap = "round";

    let drawing = false;
    let strokes = [];
    let currentStroke = [];

    function redraw() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      strokes.forEach(points => {
        if (points.length < 2) return;
        ctx.beginPath();
        ctx.moveTo(points[0].x, points[0].y);
        for (let i = 1; i < points.length - 2; i++) {
          const xc = (points[i].x + points[i + 1].x) / 2;
          const yc = (points[i].y + points[i + 1].y) / 2;
          ctx.quadraticCurveTo(points[i].x, points[i].y, xc, yc);
        }
        const last = points.length - 1;
        ctx.quadraticCurveTo(points[last - 1].x, points[last - 1].y, points[last].x, points[last].y);
        ctx.stroke();
      });
    }

    // Mouse events
    canvas.addEventListener("mousedown", (e) => {
      drawing = true;
      currentStroke = [{ x: e.offsetX, y: e.offsetY }];
      strokes.push(currentStroke);
    });
    canvas.addEventListener("mousemove", (e) => {
      if (!drawing) return;
      currentStroke.push({ x: e.offsetX, y: e.offsetY });
      redraw();
    });
    canvas.addEventListener("mouseup", () => (drawing = false));
    canvas.addEventListener("mouseleave", () => (drawing = false));

    // Touch events
    canvas.addEventListener("touchstart", (e) => {
      e.preventDefault();
      drawing = true;
      const rect = canvas.getBoundingClientRect();
      currentStroke = [{ x: e.touches[0].clientX - rect.left, y: e.touches[0].clientY - rect.top }];
      strokes.push(currentStroke);
    });
    canvas.addEventListener("touchmove", (e) => {
      e.preventDefault();
      if (!drawing) return;
      const rect = canvas.getBoundingClientRect();
      currentStroke.push({ x: e.touches[0].clientX - rect.left, y: e.touches[0].clientY - rect.top });
      redraw();
    });
    canvas.addEventListener("touchend", () => (drawing = false));

    // Bikin fungsi global
    window[`clearCanvas_${id}`] = () => {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      strokes = [];
    };

    window[`downloadTTD_${id}`] = (namaId, tglId) => {
      const nama = document.getElementById(namaId).value || "User";
      const tanggal = document.getElementById(tglId).value || "Tanggal";
      const link = document.createElement("a");
      link.download = `${nama}_${tanggal}_tanda_tangan.png`;
      link.href = canvas.toDataURL();
      link.click();
    };
  });

  // Alias fungsi supaya tombol bisa jalan
  window.clearCanvas = (id) => window[`clearCanvas_${id}`]?.();
  window.downloadTTD = (canvasId, namaId, tglId) => window[`downloadTTD_${canvasId}`]?.(namaId, tglId);
});





function handleFileUpload(event) {
    const file = event.target.files[0];
    const previewBox = event.target.closest("td").querySelector(".preview-box");

    // Kosongkan dulu isi preview
    previewBox.innerHTML = "";

    if (file) {
        // Buat elemen nama file
        const fileName = document.createElement("p");
        fileName.textContent = file.name;
        fileName.classList.add("file-name");
        previewBox.appendChild(fileName);

        // Kalau file gambar, tampilkan thumbnail img
        if (file.type.startsWith("image/")) {
            const img = document.createElement("img");
            img.src = URL.createObjectURL(file);
            img.classList.add("thumbnail");
            previewBox.appendChild(img);

            // Klik thumbnail untuk buka modal
            img.addEventListener("click", () => openImageModal(img.src));
        }
    }
}

// Fungsi buka modal
function openImageModal(src) {
    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("modalImage");

    modal.style.display = "flex";
    modalImg.src = src;
}

// Fungsi tutup modal
function closeImageModal() {
    document.getElementById("imageModal").style.display = "none";
}



