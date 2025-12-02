<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Daftar Booking</title>
    <style>
        body { background-color: #f8f9fa; }
        .booking-card { transition: transform 0.2s; }
        .booking-card:hover { transform: translateY(-2px); }
        .action-buttons .btn { padding: 0.25rem 0.5rem; font-size: 0.875rem; }
        .badge-status { font-size: 0.75rem; }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Daftar Booking</h1>
            <a href="/" class="btn btn-outline-primary">
                <i class="fas fa-home"></i> Kembali ke Home
            </a>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($bookings->count() > 0)
        <div class="card shadow">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Lapangan</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>No. HP</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $index => $booking)
                        @php
                            $bookingTime = \Carbon\Carbon::parse($booking->tanggal_booking . ' ' . $booking->jam_mulai . ':00');
                            $now = \Carbon\Carbon::now();
                            $Edit = $now->diffInHours($bookingTime) >= 2;
                            $Delete = $now->diffInHours($bookingTime) >= 3;
                        @endphp
                        
                        <tr class="booking-card">
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $booking->nama }}</strong></td>
                            <td>
                                <span class="badge bg-info text-white">
                                    {{ ucwords(str_replace('-', ' ', $booking->lapangan)) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ date('d-m-Y', strtotime($booking->tanggal_booking)) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $booking->jam_mulai }}:00</span>
                                <span class="text-muted">→</span>
                                <span class="badge bg-success">{{ $booking->jam_akhir }}:00</span>
                            </td>
                            <td>{{ $booking->nomer_hp }}</td>
                            <td>
                                @if($Edit)
                                    <span class="badge bg-success badge-status">Aktif</span>
                                @else
                                    <span class="badge bg-secondary badge-status">Sudah Lewat</span>
                                @endif
                            </td>
                            <td class="text-center action-buttons">
                                @if($Edit)
                                    <a href="{{ route('booking.edit', $booking->id) }}" 
                                       class="btn btn-warning btn-sm" 
                                       title="Reschedule">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @else
                                    <button class="btn btn-warning btn-sm" disabled title="Tidak dapat di-reschedule">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                @endif

                                @if($Delete)
                                    <button class="btn btn-danger btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModel{{ $booking->id }}"
                                            title="Cancel Booking">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @else
                                    <button class="btn btn-danger btn-sm" disabled title="Tidak dapat di-cancel">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>

                        <div class="modal fade" id="deleteModel{{ $booking->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Konfirmasi Pembatalan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin membatalkan booking ini?</p>
                                        <div class="alert alert-warning">
                                            <strong>Detail Booking:</strong><br>
                                            Nama: {{ $booking->nama }}<br>
                                            Lapangan: {{ ucwords(str_replace('-', ' ', $booking->lapangan)) }}<br>
                                            Tanggal: {{ date('d-m-Y', strtotime($booking->tanggal_booking)) }}<br>
                                            Jam: {{ $booking->jam_mulai }}:00 - {{ $booking->jam_akhir }}:00
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times"></i> Batal
                                        </button>
                                        <form action="{{ route('booking.delete', $booking->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash"></i> Ya, Batalkan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            <div class="row">
                <div class="col-md-6">
                    <small class="text-muted">Total: {{ $bookings->count() }} booking</small>
                </div>
                <div class="col-md-6 text-end">
                    <small class="text-muted">
                        <i class="fas fa-info-circle text-primary"></i>
                        Booking hanya bisa di-reschedule minimal 2 jam dan dibatalkan minimal 3 jam sebelum waktu mulai.
                    </small>
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="fas fa-calendar-times fa-4x text-muted"></i>
            </div>
            <h4 class="text-muted">Belum ada booking</h4>
            <p class="text-muted">Silakan booking lapangan terlebih dahulu</p>
            <a href="/" class="btn btn-primary">
                <i class="fas fa-calendar-plus"></i> Booking Sekarang
            </a>
        </div>
        @endif
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('form[action*="delete"]');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Yakin ingin membatalkan booking?',
                    text: "Booking yang dibatalkan tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, batalkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
    </script>
</body>
</html>