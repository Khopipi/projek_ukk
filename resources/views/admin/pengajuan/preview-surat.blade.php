@extends('layouts.dashboard')
@section('title', 'Preview Surat Hasil')
@section('content')
    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.pengajuan.index') }}">Verifikasi Pengajuan</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.pengajuan.show', $pengajuan->id) }}">Detail</a></li>
                            <li class="breadcrumb-item" aria-current="page">Preview Surat</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="ti ti-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <!-- Action Buttons -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-md-3">
                                <form action="{{ route('admin.pengajuan.generate-surat', $pengajuan->id) }}" method="POST" class="d-grid" onsubmit="return showConfirmPopup(event, 'Generate PDF dari preview ini?', '🖨️', '#3b82f6')">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti ti-printer me-1"></i> Generate PDF
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-3">
                                @if($pengajuan->file_surat_hasil)
                                <a href="{{ route('admin.pengajuan.download-pdf', $pengajuan->id) }}" class="btn btn-success w-100">
                                    <i class="ti ti-download me-1"></i> Download PDF
                                </a>
                                @else
                                <button type="button" class="btn btn-success w-100" disabled title="Generate PDF terlebih dahulu">
                                    <i class="ti ti-download me-1"></i> Download PDF
                                </button>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <form action="{{ route('admin.pengajuan.send-pdf', $pengajuan->id) }}" method="POST" class="d-grid" onsubmit="return showConfirmPopup(event, 'Kirim PDF ke email user?', '📧', '#f59e0b')">
                                    @csrf
                                    <button type="submit" class="btn btn-warning">
                                        <i class="ti ti-mail-forward me-1"></i> Kirim Email
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.pengajuan.show', $pengajuan->id) }}" class="btn btn-secondary w-100">
                                    <i class="ti ti-arrow-left me-1"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preview Surat -->
                <div class="card">
                    <div class="card-header">
                        <h5>Preview Surat Hasil</h5>
                    </div>
                    <div class="card-body" style="background:#f8f9fa;min-height:800px;padding:40px;overflow:auto;">
                        <!-- Render template surat dari pdf.blade.php tanpa wrapper HTML -->
                        <style>
                            .surat { 
                                max-width: 800px; 
                                margin: 0 auto; 
                                background: #fff; 
                                padding: 40px 50px; 
                                display: flex; 
                                flex-direction: column; 
                                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                                font-family: 'Calibri', 'Arial', sans-serif;
                                color: #000;
                                font-size: 12px;
                                line-height: 1.6;
                            }
                            .content { flex: 1; }
                            .footer-content { flex-grow: 1; margin-top: 40px; }
                            .header { 
                                text-align: center; 
                                margin-bottom: 25px; 
                                border-bottom: 3px solid #000; 
                                padding-bottom: 15px; 
                            }
                            .header-title { 
                                font-size: 14px; 
                                font-weight: bold; 
                                color: #000; 
                                margin-bottom: 3px; 
                                letter-spacing: 0.5px; 
                            }
                            .header-subtitle { 
                                font-size: 13px; 
                                font-weight: bold;
                                color: #000; 
                                margin-bottom: 5px; 
                                letter-spacing: 0.3px; 
                            }
                            .nomor { 
                                font-size: 11px; 
                                color: #333; 
                                margin-top: 8px; 
                            }
                            table { 
                                width: 100%; 
                                border-collapse: collapse; 
                                margin: 10px 0;
                            }
                            td {
                                padding: 5px 0;
                                font-size: 11px;
                                line-height: 1.6;
                            }
                            p {
                                margin: 10px 0;
                                font-size: 11px;
                                line-height: 1.8;
                                text-align: justify;
                            }
                            .signature-section {
                                font-size: 11px; 
                                color: #333; 
                                margin-top: 8px; 
                            }
                            .section { margin-bottom: 18px; }
                            .section-title { 
                                font-size: 11px; 
                                font-weight: bold; 
                                color: #000; 
                                text-transform: uppercase; 
                                letter-spacing: 1px; 
                                margin-bottom: 10px; 
                                padding-bottom: 6px; 
                                border-bottom: 1px solid #999; 
                            }
                            .field-row { 
                                margin-bottom: 8px; 
                                display: flex; 
                                gap: 15px; 
                            }
                            .field-label { 
                                font-weight: bold; 
                                color: #000; 
                                font-size: 11px; 
                                width: 120px; 
                                flex-shrink: 0;
                            }
                            .field-value { 
                                color: #333; 
                                font-size: 11px; 
                                flex: 1; 
                            }
                            .signature-section { 
                                margin-top: 40px; 
                                display: flex; 
                                justify-content: flex-end; 
                            }
                            .signature-box { 
                                text-align: center; 
                                width: 200px; 
                            }
                            .signature-line { 
                                border-top: 1px solid #000; 
                                width: 100%; 
                                margin: 50px 0 3px 0; 
                            }
                            .signature-name { 
                                font-weight: bold; 
                                margin-top: 3px; 
                                font-size: 11px; 
                            }
                            .signature-nip { 
                                font-size: 10px; 
                                color: #333; 
                                margin-top: 2px; 
                            }
                            .date-place { 
                                text-align: right; 
                                margin-bottom: 30px; 
                                font-size: 11px; 
                            }
                            .date-place-label { margin-bottom: 2px; }
                            .date-place-value { 
                                font-weight: bold; 
                                margin-top: 3px; 
                            }
                        </style>
                        @include('pengajuan.surat-template', ['pengajuan' => $pengajuan])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts_content')
<script>
    // Confirmation popup dengan custom dialog
    function showConfirmPopup(event, message, icon = '❓', bgColor = '#3b82f6') {
        event.preventDefault();
        const form = event.target;
        
        // Hapus popup lama jika ada
        const existingModal = document.getElementById('custom-confirm-popup');
        if (existingModal) existingModal.remove();
        
        // Buat backdrop
        const backdrop = document.createElement('div');
        backdrop.id = 'custom-confirm-popup';
        backdrop.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 99998;
            animation: fadeIn 0.3s ease-out;
        `;
        
        // Buat modal
        const modal = document.createElement('div');
        modal.style.cssText = `
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 400px;
            width: 90%;
            text-align: center;
            animation: popupIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        `;
        
        modal.innerHTML = `
            <div style="font-size: 48px; margin-bottom: 20px; animation: bounce 0.6s ease-out;">${icon}</div>
            <h3 style="color: #2d3748; font-size: 20px; font-weight: 700; margin: 0 0 12px 0;">${message}</h3>
            <p style="color: #718096; margin: 0 0 30px 0; line-height: 1.5; font-size: 14px;">Anda yakin dengan tindakan ini?</p>
            <div style="display: flex; gap: 12px;">
                <button id="cancelBtn" type="button" style="flex: 1; padding: 10px; border: 1px solid #ccc; background: white; color: #2d3748; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                    Batal
                </button>
                <button id="confirmBtn" type="button" style="flex: 1; padding: 10px; border: none; background: ${bgColor}; color: white; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                    Ya, Lanjutkan
                </button>
            </div>
        `;
        
        backdrop.appendChild(modal);
        document.body.appendChild(backdrop);
        
        // Add animations if not exists
        let styleSheet = document.getElementById('popup-animations');
        if (!styleSheet) {
            styleSheet = document.createElement('style');
            styleSheet.id = 'popup-animations';
            styleSheet.textContent = `
                @keyframes fadeIn {
                    from { opacity: 0; }
                    to { opacity: 1; }
                }
                @keyframes popupIn {
                    0% { opacity: 0; transform: scale(0.3); }
                    100% { opacity: 1; transform: scale(1); }
                }
                @keyframes bounce {
                    0%, 100% { transform: scale(1); }
                    50% { transform: scale(1.2); }
                }
            `;
            document.head.appendChild(styleSheet);
        }
        
        const cancelBtn = document.getElementById('cancelBtn');
        const confirmBtn = document.getElementById('confirmBtn');
        
        cancelBtn.addEventListener('click', function() {
            backdrop.remove();
        });
        
        confirmBtn.addEventListener('click', function() {
            backdrop.remove();
            form.submit();
        });
        
        return false;
    }

    // Auto-hide alerts
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(alert => {
            try {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            } catch (e) {}
        });
    }, 5000);
</script>
@endsection
