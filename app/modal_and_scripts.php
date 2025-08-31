    <!-- Modal for marking absent students -->
    <div class="modal fade" id="absentModal" tabindex="-1" aria-labelledby="absentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 16px;">
                <div class="modal-header" style="border-bottom: 1px solid #f0f0f0;">
                    <h5 class="modal-title" id="absentModalLabel">
                        <i class="fas fa-user-times me-2"></i>
                        Tandai Guru Tidak Masuk
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <p>Guru: <strong id="studentName"></strong></p>
                        <p class="text-muted">Tanggal: <?= date('d F Y'); ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Pilih Status Ketidakhadiran:</label>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-check" style="padding: 10px; border: 2px solid #E0E0E0; border-radius: 8px;">
                                    <input class="form-check-input" type="radio" name="absentStatus" id="statusAlpha" value="alpha">
                                    <label class="form-check-label" for="statusAlpha">
                                        <strong>Alpha</strong><br>
                                        <small class="text-muted">Tidak masuk tanpa keterangan</small>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-check" style="padding: 10px; border: 2px solid #E0E0E0; border-radius: 8px;">
                                    <input class="form-check-input" type="radio" name="absentStatus" id="statusSakit" value="sakit">
                                    <label class="form-check-label" for="statusSakit">
                                        <strong>Sakit</strong><br>
                                        <small class="text-muted">Tidak masuk karena sakit</small>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-check" style="padding: 10px; border: 2px solid #E0E0E0; border-radius: 8px;">
                                    <input class="form-check-input" type="radio" name="absentStatus" id="statusIzin" value="izin">
                                    <label class="form-check-label" for="statusIzin">
                                        <strong>Izin</strong><br>
                                        <small class="text-muted">Tidak masuk dengan izin</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f0f0f0;">
                    <button type="button" class="btn-modern secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                        Batal
                    </button>
                    <button type="button" class="btn-modern success" onclick="saveAbsentStatus()">
                        <i class="fas fa-save"></i>
                        Simpan Status
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>
        function toggleNavbar() {
            const navbar = document.querySelector('.col-navbar');
            const cover = document.querySelector('.screen-cover');
            navbar.classList.toggle('d-none');
            cover.classList.toggle('d-none');
        }

        function toggleActive(e) {
            const sidebar_items = document.querySelectorAll('.sidebar-item');
            sidebar_items.forEach(function(v, k) {
                v.classList.remove('active');
            });
            e.classList.add('active');
        }

        // Filter functions
        function filterAttendance(status, element) {
            const filterTabs = document.querySelectorAll('.filter-tab');
            filterTabs.forEach(tab => tab.classList.remove('active'));
            element.classList.add('active');

            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                if (status === 'all' || rowStatus === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Absent student functions
        let currentStudentNip = '';
        let currentStudentName = '';
        let editMode = false;

        function markAbsent(nip, name, currentStatus = '') {
            currentStudentNip = nip;
            currentStudentName = name;
            document.getElementById('studentName').textContent = name;
            
            // Reset radio buttons
            document.querySelectorAll('input[name="absentStatus"]').forEach(radio => {
                radio.checked = false;
            });
            
            // If editing, select current status
            if (currentStatus) {
                const radioToSelect = document.getElementById('status' + currentStatus.charAt(0).toUpperCase() + currentStatus.slice(1));
                if (radioToSelect) {
                    radioToSelect.checked = true;
                    editMode = true;
                }
            } else {
                editMode = false;
            }
            
            const modal = new bootstrap.Modal(document.getElementById('absentModal'));
            modal.show();
        }

        function saveAbsentStatus() {
            const selectedStatus = document.querySelector('input[name="absentStatus"]:checked');
            if (!selectedStatus) {
                alert('Pilih status ketidakhadiran terlebih dahulu!');
                return;
            }

            const status = selectedStatus.value;
            const today = new Date().toISOString().split('T')[0];

            // Send AJAX request to save status
            fetch('../controllers/save_absent_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `nip=${currentStudentNip}&status=${status}&tanggal=${today}&edit_mode=${editMode}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Status berhasil disimpan!');
                    location.reload();
                } else {
                    alert('Gagal menyimpan status: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan status!');
            });

            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('absentModal'));
            modal.hide();
        }

        // Add styles for checked radio buttons
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[name="absentStatus"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    document.querySelectorAll('.form-check').forEach(check => {
                        check.style.borderColor = '#E0E0E0';
                        check.style.backgroundColor = 'white';
                    });
                    
                    if (this.checked) {
                        this.closest('.form-check').style.borderColor = '#4640DE';
                        this.closest('.form-check').style.backgroundColor = 'rgba(70, 64, 222, 0.05)';
                    }
                });
            });
        });
    </script>
</body>

</html>
