<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reschedule Booking - Lifesport</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">    
    <link rel="stylesheet" href="{{ asset('css/action.css') }}">
<!--    <style>
        body {
            background-color: #f8f9fa;
        }
        .booking-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .booking-header {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }
        .alert-box {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .duration-display {
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
        .duration-valid {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        .duration-invalid {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .btn-warning {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
        }
        .btn-warning:hover {
            background: linear-gradient(135deg, #e67e22, #d35400);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
    </style> -->
</head>
<body>
    <div class="container">
        <div class="booking-container">
            <div class="booking-header mb-4">
                <h2><i class="fas fa-calendar-alt me-2"></i>Reschedule Booking</h2>
                <p class="mb-0">Ubah jadwal booking Anda</p>
            </div>
            @if(session('success'))
                <div class="alert alert-success alert-box">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-box">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                </div>
            @endif
            <div class="alert alert-info alert-box">
                <h5><i class="fas fa-info-circle me-2"></i>Booking Saat Ini</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nama:</strong><br>{{ $booking->nama }}</p>
                        <p><strong>Lapangan:</strong><br>{{ ucwords(str_replace('-', ' ', $booking->lapangan)) }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Tanggal:</strong><br>{{ date('d-m-Y', strtotime($booking->tanggal_booking)) }}</p>
                        <p><strong>Jam:</strong><br>{{ $booking->jam_mulai }}:00 - {{ $booking->jam_akhir }}:00</p>
                    </div>
                </div>
            </div>
            <form action="{{ route('booking.update', $booking->id) }}" method="POST" id="rescheduleForm">
                @csrf
                <div class="mb-3">
                    <label for="tanggal_booking" class="form-label">Tanggal Baru <span class="text-danger">*</span></label>
                    <input type="date" 
                           class="form-control @error('tanggal_booking') is-invalid @enderror" 
                           id="tanggal_booking" 
                           name="tanggal_booking" 
                           value="{{ old('tanggal_booking', $booking->tanggal_booking) }}" 
                           min="{{ date('Y-m-d') }}"
                           required>
                    <div class="invalid-feedback">
                        @error('tanggal_booking') {{ $message }} @else Pilih tanggal yang valid @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="jam_mulai" class="form-label">Jam Mulai <span class="text-danger">*</span></label>
                        <select class="form-control @error('jam_mulai') is-invalid @enderror" 
                                id="jam_mulai" 
                                name="jam_mulai" 
                                required>
                            <option value="">-- Pilih Jam --</option>
                            @for($i = 8; $i <= 22; $i++)
                                @php $jam = str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
                                <option value="{{ $jam }}" {{ old('jam_mulai', $booking->jam_mulai) == $jam ? 'selected' : '' }}>
                                    {{ $jam }}:00
                                </option>
                            @endfor
                        </select>
                        <div class="invalid-feedback">
                            @error('jam_mulai') {{ $message }} @else Pilih jam mulai @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="jam_akhir" class="form-label">Jam Akhir <span class="text-danger">*</span></label>
                        <select class="form-control @error('jam_akhir') is-invalid @enderror" 
                                id="jam_akhir" 
                                name="jam_akhir" 
                                required>
                            <option value="">-- Pilih Jam --</option>
                            @for($i = 8; $i <= 22; $i++)
                                @php $jam = str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
                                <option value="{{ $jam }}" {{ old('jam_akhir', $booking->jam_akhir) == $jam ? 'selected' : '' }}>
                                    {{ $jam }}:00
                                </option>
                            @endfor
                        </select>
                        <div class="invalid-feedback">
                            @error('jam_akhir') {{ $message }} @else Pilih jam akhir @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Durasi Booking</label>
                    <div id="durasi_display" class="duration-display">0 jam</div>
                    <input type="hidden" id="durasi_hours" value="0">
                </div>                
                <div class="d-grid gap-3">
                    <button type="submit" class="btn btn-danger btn-save btn-lg" id="submitBtn">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                    <a href="{{ route('booking.index') }}" class="btn btn-outline-danger btn-lg">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                </div>                
                <div class="mt-4 text-center" id="debugInfo" style="display: none;">
                    <small class="text-muted">
                        <i class="fas fa-bug me-1"></i>
                        Form ID: {{ $booking->id }} | 
                        Route: {{ route('booking.update', $booking->id) }} | 
                        Method: POST
                    </small>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('java/action.js') }}"></script>
</body>
</html>