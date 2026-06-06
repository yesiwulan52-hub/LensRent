// ==================== DATA AWAL (localStorage) ====================
const dataKameraAwal = [
    { kode: "K001", nama: "Fujifilm X100F", kategori: "Mirrorless", jumlah: 5, harga: 150000, foto: "/image/FujifilmX100F.jpg" },
    { kode: "K002", nama: "Sony A7 III", kategori: "Mirrorless", jumlah: 3, harga: 250000, foto: "/image/Sony_a7_III.jpg" },
    { kode: "K003", nama: "Canon R5", kategori: "Mirrorless", jumlah: 4, harga: 230000, foto: "/image/Canon_R5_camera.jpg" },
    { kode: "K004", nama: "Nikon D750", kategori: "DSLR", jumlah: 3, harga: 200000, foto: "/image/Nikon_d750.jpg" },
];

let daftarKamera = JSON.parse(localStorage.getItem("lensrent_kamera")) || dataKameraAwal;
let daftarSewa   = JSON.parse(localStorage.getItem("lensrent_sewa"))   || [];
let editIndex = -1;

const formatRupiah = (angka) => {
    return "Rp " + new Intl.NumberFormat("id-ID").format(angka);
};

const simpanData = () => {
    localStorage.setItem("lensrent_kamera", JSON.stringify(daftarKamera));
    localStorage.setItem("lensrent_sewa", JSON.stringify(daftarSewa));
};

const showNotification = (pesan, jenis = "success") => {
    const notif = document.createElement("div");
    notif.className = `notification notification-${jenis}`;
    notif.textContent = pesan;
    notif.style.cssText = `
        position: fixed; bottom: 20px; right: 20px;
        background: ${jenis === 'success' ? '#4CAF50' : '#f44336'};
        color: white; padding: 12px 24px; border-radius: 8px;
        z-index: 9999; font-weight: bold; box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        animation: fadeInOut 3s ease;
    `;
    document.body.appendChild(notif);
    setTimeout(() => notif.remove(), 3000);
};

const updateStatistik = () => {
    const totalKamera = daftarKamera.reduce((sum, k) => sum + k.jumlah, 0);
    const totalDisewa = daftarSewa.reduce((sum, s) => sum + s.jumlah, 0);
    const totalTersedia = Math.max(totalKamera - totalDisewa, 0);
    const totalPendapatan = daftarSewa.reduce((sum, s) => sum + s.total, 0);
    const stokMenipis = daftarKamera.filter(k => k.jumlah < 3).length;

    document.querySelectorAll("#statTotalKamera").forEach(el => el.textContent = totalKamera);
    document.querySelectorAll("#statTersedia").forEach(el => el.textContent = totalTersedia);
    document.querySelectorAll("#statDisewa").forEach(el => el.textContent = totalDisewa);
    document.querySelectorAll("#statStokMenipis").forEach(el => el.textContent = stokMenipis);
    document.querySelectorAll("#statPendapatan").forEach(el => el.textContent = formatRupiah(totalPendapatan));
};

const renderTabelKamera = (data = daftarKamera) => {
    const tbody = document.getElementById("tableBody");
    if (!tbody) return;

    if (data.length === 0) {
        tbody.innerHTML = `<tr><td colspan="6" style="text-align:center">Tidak ada data kamera</td></tr>`;
        return;
    }

    tbody.innerHTML = data.map((k, i) => `
        <tr data-index="${i}">
            <td>${k.kode}</td>
            <td>${k.nama}</td>
            <td><span class="kategori-badge ${k.kategori === 'Mirrorless' ? 'mirrorless' : 'dslr'}">${k.kategori}</span></td>
            <td class="${k.jumlah < 3 ? 'stok-menipis' : ''}">${k.jumlah} unit</td>
            <td>${formatRupiah(k.harga)}</td>
            <td>
                <button class="btn-edit" data-index="${i}">✏️ Edit</button>
                <button class="btn-hapus" data-index="${i}">🗑️ Hapus</button>
            </td>
        </tr>
    `).join("");
    updateStatistik();
};

const renderGridKamera = (data = daftarKamera) => {
    const gridContainer = document.getElementById("kameraGrid");
    if (!gridContainer) return;

    if (data.length === 0) {
        gridContainer.innerHTML = `<p style="text-align:center; grid-column:1/-1">Tidak ada kamera tersedia</p>`;
        return;
    }

    gridContainer.innerHTML = data.map(k => `
        <div class="card" data-nama="${k.nama}" data-kategori="${k.kategori}">
            <img src="${k.foto || 'https://placehold.co/400x300/1B3A6B/white?text=Kamera'}"
                 alt="${k.nama}" loading="lazy"
                 onerror="this.src='https://placehold.co/400x300/1B3A6B/white?text=No+Image'">
            <h4>${k.nama}</h4>
            <p>${formatRupiah(k.harga)}<span style="font-size:12px">/hari</span></p>
            <small>${k.kategori} | Stok: ${k.jumlah}</small>
        </div>
    `).join("");
};

const filterKamera = () => {
    const searchInput = document.getElementById("searchInput");
    const searchKamera = document.getElementById("searchKamera");
    const keyword = (searchInput?.value || searchKamera?.value || "").toLowerCase();

    const checkboxes = document.querySelectorAll(".filter-kategori");
    const selectedKategori = Array.from(checkboxes)
        .filter(cb => cb.checked)
        .map(cb => cb.value);

    const filtered = daftarKamera.filter(k => {
        const matchKeyword = k.nama.toLowerCase().includes(keyword) || k.kode.toLowerCase().includes(keyword);
        const matchKategori = selectedKategori.length === 0 || selectedKategori.includes(k.kategori);
        return matchKeyword && matchKategori;
    });

    if (document.getElementById("tableBody")) renderTabelKamera(filtered);
    if (document.getElementById("kameraGrid")) renderGridKamera(filtered);
};

const initCRUDKamera = () => {
    const btnTambah = document.getElementById("btnTambah");
    const formWrapper = document.getElementById("formWrapper");
    const btnBatal = document.getElementById("btnBatal");
    const formKamera = document.getElementById("formKamera");
    const judulForm = document.getElementById("judulForm");

    if (!formKamera) return;

    if (btnTambah) {
        btnTambah.addEventListener("click", () => {
            editIndex = -1;
            formKamera.reset();
            judulForm.textContent = "Tambah Kamera";
            formWrapper.style.display = "block";
            formWrapper.scrollIntoView({ behavior: "smooth" });
        });
    }

    if (btnBatal) {
        btnBatal.addEventListener("click", () => {
            formWrapper.style.display = "none";
            formKamera.reset();
        });
    }

    formKamera.addEventListener("submit", (e) => {
        e.preventDefault();

        const kode = document.getElementById("fKode").value.trim();
        const nama = document.getElementById("fNama").value.trim();
        const kategori = document.getElementById("fKategori").value;
        const jumlah = parseInt(document.getElementById("fJumlah").value);
        const harga = parseInt(document.getElementById("fHarga").value);
        let foto = document.getElementById("fFoto")?.value.trim() || "";

        if (!kode) return showNotification("Kode kamera wajib diisi!", "error");
        if (!nama) return showNotification("Nama kamera wajib diisi!", "error");
        if (jumlah <= 0) return showNotification("Jumlah stok harus lebih dari 0!", "error");
        if (harga <= 0) return showNotification("Harga sewa harus lebih dari 0!", "error");

        const kodeExist = daftarKamera.findIndex(k => k.kode === kode);
        if (kodeExist !== -1 && kodeExist !== editIndex) {
            return showNotification(`Kode "${kode}" sudah terdaftar!`, "error");
        }

        if (!foto) {
            foto = `https://placehold.co/400x300/1B3A6B/white?text=${encodeURIComponent(nama)}`;
        } else if (!foto.startsWith("http") && !foto.startsWith("/")) {
            foto = "/" + foto;
        }

        const kameraBaru = { kode, nama, kategori, jumlah, harga, foto };

        if (editIndex === -1) {
            daftarKamera.push(kameraBaru);
            showNotification("Kamera berhasil ditambahkan!", "success");
        } else {
            daftarKamera[editIndex] = kameraBaru;
            showNotification("Kamera berhasil diupdate!", "success");
        }

        simpanData();
        renderTabelKamera();
        renderGridKamera();
        formWrapper.style.display = "none";
        formKamera.reset();
    });

    const tableBody = document.getElementById("tableBody");
    if (tableBody) {
        tableBody.addEventListener("click", (e) => {
            const btn = e.target;
            const index = btn.getAttribute("data-index");

            if (btn.classList.contains("btn-edit")) {
                const k = daftarKamera[index];
                editIndex = parseInt(index);
                document.getElementById("fKode").value = k.kode;
                document.getElementById("fNama").value = k.nama;
                document.getElementById("fKategori").value = k.kategori;
                document.getElementById("fJumlah").value = k.jumlah;
                document.getElementById("fHarga").value = k.harga;
                if (document.getElementById("fFoto")) document.getElementById("fFoto").value = k.foto || "";
                judulForm.textContent = "Edit Kamera";
                formWrapper.style.display = "block";
                formWrapper.scrollIntoView({ behavior: "smooth" });
            }

            if (btn.classList.contains("btn-hapus")) {
                if (confirm(`Hapus kamera "${daftarKamera[index].nama}"?`)) {
                    daftarKamera.splice(index, 1);
                    simpanData();
                    renderTabelKamera();
                    renderGridKamera();
                    showNotification("Kamera berhasil dihapus!", "success");
                }
            }
        });
    }
};

const hitungHari = (tglSewa, tglKembali) => {
    const start = new Date(tglSewa);
    const end = new Date(tglKembali);
    const diffTime = Math.abs(end - start);
    return Math.ceil(diffTime / (1000 * 60 * 60 * 24)) || 1;
};

const updatePreviewTotal = () => {
    const kode = document.getElementById("kode")?.value.trim();
    const jumlah = parseInt(document.getElementById("jumlah")?.value) || 0;
    const tglSewa = document.getElementById("tanggal_sewa")?.value;
    const tglKembali = document.getElementById("tanggal_kembali")?.value;
    const preview = document.getElementById("previewTotal");

    if (!preview) return;

    if (kode && jumlah > 0 && tglSewa && tglKembali) {
        const kamera = daftarKamera.find(k => k.kode === kode);
        if (kamera) {
            const hari = hitungHari(tglSewa, tglKembali);
            const total = kamera.harga * jumlah * hari;
            preview.innerHTML = `<strong>💰 Estimasi Total: ${formatRupiah(total)} (${hari} hari)</strong>`;
            return;
        }
    }
    preview.innerHTML = `<strong>💰 Estimasi Total: —</strong>`;
};

const renderRiwayatSewa = () => {
    const container = document.getElementById("riwayatSewa");
    if (!container) return;

    if (daftarSewa.length === 0) {
        container.innerHTML = `<p style="color:#999; text-align:center">Belum ada riwayat penyewaan.</p>`;
        return;
    }

    container.innerHTML = `
        <div class="table-container">
            <table class="riwayat-table">
                <thead>
                    <tr><th>ID</th><th>Nama</th><th>Kamera</th><th>Jml</th><th>Tgl Sewa</th><th>Tgl Kembali</th><th>Total</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    ${daftarSewa.map((s, i) => `
                        <tr>
                            <td>${s.id}</td>
                            <td>${s.nama}</td>
                            <td>${s.kamera}</td>
                            <td>${s.jumlah}</td>
                            <td>${s.tanggalSewa}</td>
                            <td>${s.tanggalKembali}</td>
                            <td>${formatRupiah(s.total)}</td>
                            <td><button class="btn-hapus-sewa" data-index="${i}">Hapus</button></td>
                        </tr>
                    `).join("")}
                </tbody>
            </table>
        </div>
    `;
};

const initFormSewa = () => {
    const kodeInput = document.getElementById("kode");
    const kameraSelect = document.getElementById("kameraSelect");

    if (kodeInput && kameraSelect) {
        kodeInput.addEventListener("blur", () => {
            const kode = kodeInput.value.trim();
            const kamera = daftarKamera.find(k => k.kode === kode);
            if (kamera) {
                let optionExists = false;
                for (let opt of kameraSelect.options) {
                    if (opt.value === kamera.nama) optionExists = true;
                }
                if (!optionExists) {
                    const newOption = document.createElement("option");
                    newOption.value = kamera.nama;
                    newOption.textContent = kamera.nama;
                    kameraSelect.appendChild(newOption);
                }
                kameraSelect.value = kamera.nama;
                const jumlahInput = document.getElementById("jumlah");
                if (jumlahInput) jumlahInput.max = kamera.jumlah;
                showNotification(`Kamera ditemukan: ${kamera.nama} (Stok: ${kamera.jumlah})`, "success");
            } else if (kode) {
                showNotification("Kode kamera tidak ditemukan!", "error");
            }
        });
    }

    const previewInputs = ["kode", "jumlah", "tanggal_sewa", "tanggal_kembali"];
    previewInputs.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener("input", updatePreviewTotal);
    });

    const formSewa = document.getElementById("formSewa");
    if (formSewa) {
        formSewa.addEventListener("submit", (e) => {
            e.preventDefault();

            const id = parseInt(document.getElementById("id").value);
            const nama = document.getElementById("nama").value.trim();
            const telepon = document.getElementById("telepon").value.trim();
            const email = document.getElementById("email")?.value.trim() || "";
            const alamat = document.getElementById("alamat")?.value.trim() || "";
            const kode = document.getElementById("kode").value.trim();
            const kameraNama = document.getElementById("kameraSelect").value;
            const jumlah = parseInt(document.getElementById("jumlah").value);
            const tglSewa = document.getElementById("tanggal_sewa").value;
            const tglKembali = document.getElementById("tanggal_kembali").value;
            const pembayaran = document.getElementById("pembayaran").value;
            const catatan = document.getElementById("catatan")?.value || "";

            // Validasi
            if (!id) return showNotification("ID Penyewaan wajib diisi!", "error");
            if (!nama) return showNotification("Nama penyewa wajib diisi!", "error");
            if (nama.length < 3) return showNotification("Nama minimal 3 karakter!", "error");
            if (!telepon) return showNotification("No. Telepon wajib diisi!", "error");
            if (!/^[0-9]{10,13}$/.test(telepon)) return showNotification("No. Telepon harus 10-13 digit angka!", "error");
            if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) return showNotification("Format email tidak valid!", "error");
            if (!kode) return showNotification("Kode kamera wajib diisi!", "error");
            if (!kameraNama) return showNotification("Pilih kamera yang valid!", "error");
            if (!jumlah || jumlah <= 0) return showNotification("Jumlah unit harus lebih dari 0!", "error");
            if (!tglSewa || !tglKembali) return showNotification("Tanggal sewa dan kembali wajib diisi!", "error");

            const tgl1 = new Date(tglSewa);
            const tgl2 = new Date(tglKembali);
            if (tgl2 <= tgl1) return showNotification("Tanggal kembali harus setelah tanggal sewa!", "error");

            const kamera = daftarKamera.find(k => k.kode === kode);
            if (!kamera) return showNotification("Kode kamera tidak ditemukan!", "error");
            if (jumlah > kamera.jumlah) return showNotification(`Stok tidak mencukupi! Tersedia: ${kamera.jumlah} unit`, "error");
            if (daftarSewa.some(s => s.id === id)) return showNotification(`ID Penyewaan ${id} sudah terdaftar!`, "error");

            const hari = hitungHari(tglSewa, tglKembali);
            const total = kamera.harga * jumlah * hari;

            // Kurangi stok
            kamera.jumlah -= jumlah;

            const sewaBaru = {
                id, nama, telepon, email, alamat, kode, kamera: kameraNama,
                jumlah, tanggalSewa: tglSewa, tanggalKembali: tglKembali,
                pembayaran, catatan, total
            };
            daftarSewa.push(sewaBaru);
            simpanData();

            showNotification(`Penyewaan berhasil! Total: ${formatRupiah(total)}`, "success");
            formSewa.reset();
            renderRiwayatSewa();
            renderTabelKamera();
            renderGridKamera();
            updateStatistik();

            const preview = document.getElementById("previewTotal");
            if (preview) preview.innerHTML = `<strong>💰 Estimasi Total: —</strong>`;
        });
    }

    const riwayatContainer = document.getElementById("riwayatSewa");
    if (riwayatContainer) {
        riwayatContainer.addEventListener("click", (e) => {
            if (e.target.classList.contains("btn-hapus-sewa")) {
                const index = e.target.getAttribute("data-index");
                if (confirm(`Hapus penyewaan ini?`)) {
                    const sewa = daftarSewa[index];
                    const kamera = daftarKamera.find(k => k.kode === sewa.kode);
                    if (kamera) kamera.jumlah += sewa.jumlah;
                    daftarSewa.splice(index, 1);
                    simpanData();
                    renderRiwayatSewa();
                    renderTabelKamera();
                    renderGridKamera();
                    updateStatistik();
                    showNotification("Penyewaan dihapus!", "success");
                }
            }
        });
    }

    renderRiwayatSewa();
};

const initPencarianHome = () => {
    const searchInput = document.getElementById("searchKamera");
    const searchBtn = document.getElementById("btnCari");
    if (searchInput) {
        const filterCard = () => {
            const keyword = searchInput.value.toLowerCase();
            document.querySelectorAll(".card").forEach(card => {
                const nama = card.getAttribute("data-nama") || "";
                // Gunakan '' (default) agar grid tetap fleksibel
                card.style.display = nama.toLowerCase().includes(keyword) ? '' : 'none';
            });
        };
        searchInput.addEventListener("input", filterCard);
        if (searchBtn) searchBtn.addEventListener("click", filterCard);
    }
};

const initHamburger = () => {
    const hamburger = document.getElementById("hamburger");
    const menu = document.getElementById("menu");
    if (hamburger && menu) {
        hamburger.addEventListener("click", () => menu.classList.toggle("show"));
    }
};

const initResetData = () => {
    const btnReset = document.getElementById("btnResetData");
    if (btnReset) {
        btnReset.addEventListener("click", () => {
            if (confirm("Reset semua data ke awal? Data yang tersimpan akan hilang!")) {
                localStorage.removeItem("lensrent_kamera");
                localStorage.removeItem("lensrent_sewa");
                daftarKamera = JSON.parse(JSON.stringify(dataKameraAwal));
                daftarSewa = [];
                simpanData();
                renderTabelKamera();
                renderGridKamera();
                renderRiwayatSewa();
                updateStatistik();
                showNotification("Data berhasil direset ke awal!", "success");
            }
        });
    }
};

document.addEventListener("DOMContentLoaded", () => {
    const path = window.location.pathname;

    initHamburger();
    initResetData();

    document.querySelectorAll(".filter-kategori").forEach(cb => cb.addEventListener("change", filterKamera));
    const searchInput = document.getElementById("searchInput");
    if (searchInput) searchInput.addEventListener("input", filterKamera);

    if (path.includes("/kamera")) {
        renderTabelKamera();
        initCRUDKamera();
    } else if (path.includes("/sewa")) {
        initFormSewa();
        renderTabelKamera();
        renderGridKamera();
        updateStatistik();
    } else {
        // ========== PERBAIKAN UNTUK HALAMAN HOME ==========
        // Hapus panggilan renderGridKamera() dan renderTabelKamera()
        // agar grid kamera populer tidak ditimpa oleh localStorage.
        // Grid sudah dirender oleh backend (Laravel) di home.blade.php.
        // Cukup jalankan initPencarianHome() untuk live search,
        // dan updateStatistik() jika diperlukan.
        initPencarianHome();
        updateStatistik(); // opsional, untuk statistik dari localStorage
    }
});

// ==================== FETCH CUACA (wttr.in) ====================
async function fetchWeather() {
    const loadingDiv = document.getElementById('weather-loading');
    const contentDiv = document.getElementById('weather-content');
    const errorDiv = document.getElementById('weather-error');
    if (!loadingDiv) return;

    loadingDiv.style.display = 'block';
    contentDiv.style.display = 'none';
    errorDiv.style.display = 'none';

    try {
        const response = await fetch('https://wttr.in/Surabaya?format=j1');
        if (!response.ok) throw new Error();
        const data = await response.json();
        const current = data.current_condition[0];
        document.getElementById('city-name').innerText = 'Surabaya';
        document.getElementById('temperature').innerHTML = `${current.temp_C}°C`;
        document.getElementById('description').innerText = current.weatherDesc[0].value;
        contentDiv.style.display = 'block';
    } catch (error) {
        errorDiv.innerText = 'Gagal memuat data cuaca.';
        errorDiv.style.display = 'block';
    } finally {
        loadingDiv.style.display = 'none';
    }
}
document.addEventListener('DOMContentLoaded', fetchWeather);

// ==================== DARK MODE & COOKIE HELPERS ====================
function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}
function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function setTheme(theme) {
    if (theme === 'dark') {
        document.documentElement.classList.add('dark');
        setCookie('theme', 'dark', 30);
        const toggleBtn = document.getElementById('darkModeToggle');
        if (toggleBtn) toggleBtn.textContent = '☀️';
    } else {
        document.documentElement.classList.remove('dark');
        setCookie('theme', 'light', 30);
        const toggleBtn = document.getElementById('darkModeToggle');
        if (toggleBtn) toggleBtn.textContent = '🌙';
    }
}
function toggleDarkMode() {
    const isDark = document.documentElement.classList.contains('dark');
    setTheme(isDark ? 'light' : 'dark');
}

// Initial load (cookie > system preference)
const savedTheme = getCookie('theme');
if (savedTheme === 'dark') {
    setTheme('dark');
} else if (savedTheme === 'light') {
    setTheme('light');
} else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    setTheme('dark');
} else {
    setTheme('light');
}

// Event listener untuk tombol toggle (pastikan id="darkModeToggle" ada di navbar)
document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('darkModeToggle');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleDarkMode);
    }
});
