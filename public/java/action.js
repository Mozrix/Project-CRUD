document.addEventListener('DOMContentLoaded', function() {
    const elements = {
        jamMulai: document.getElementById('jam_mulai'),
        jamAkhir: document.getElementById('jam_akhir'),
        durasiDisplay: document.getElementById('durasi_display'),
        submitBtn: document.getElementById('submitBtn'),
        form: document.getElementById('rescheduleForm'),
        tanggalInput: document.getElementById('tanggal_booking')
    };

    function hitungDurasi() {
        const jamMulai = elements.jamMulai.value;
        const jamAkhir = elements.jamAkhir.value;
        if (jamMulai && jamAkhir) {
            const mulaiInt = parseInt(jamMulai);
            const akhirInt = parseInt(jamAkhir);
            const durasi = akhirInt - mulaiInt;

            elements.durasiDisplay.textContent = durasi + ' jam';
            if (akhirInt <= mulaiInt) {
                elements.durasiDisplay.textContent = 'Jam akhir harus setelah jam mulai!';
                elements.durasiDisplay.className = 'duration-display duration-invalid';
                elements.submitBtn.disabled = true;
                elements.submitBtn.title = 'Jam akhir harus setelah jam mulai';
            } else {
                elements.durasiDisplay.className = 'duration-display duration-valid';
                elements.submitBtn.disabled = false;
            }
        } else {
            elements.durasiDisplay.textContent = '0 jam';
            elements.durasiDisplay.className = 'duration-display duration-valid';
            elements.submitBtn.disabled = false;
        }
    }
    if (elements.jamMulai) {
            elements.jamMulai.addEventListener('change', hitungDurasi);
        }

    if (elements.jamAkhir) {
            elements.jamAkhir.addEventListener('change', hitungDurasi);
        }
    if (elements.form) {
        elements.form.addEventListener('submit', function(event) {
        if (!elements.tanggalInput?.value) {
            event.preventDefault();
            alert('Silakan pilih tanggal booking!');
            return false;
        }

        if (!elements.jamMulai?.value || !elements.jamAkhir?.value) {
            event.preventDefault();
            alert('Silakan pilih jam mulai dan jam akhir!');
            return false;
        }
        const mulaiInt = parseInt(elements.jamMulai.value);
        const akhirInt = parseInt(elements.jamAkhir.value);
        const durasi = akhirInt - mulaiInt;

        if (akhirInt <= mulaiInt) {
            event.preventDefault();
            alert('Jam akhir harus setelah jam mulai!');
            return false;
        }
                return true;
    });
    }
        hitungDurasi();
});