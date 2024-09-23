<p>Ini adalah email otomatis dari sistem. Mohon untuk tidak membalas email ini. Jika butuh bantuan, silakan hubungi <a href="{{ url('/') }}">Admin Balai Wilayah Sungai Kalimantan II</a>.</p>
<hr>
@if ($data->status == 'approve')
<p>Permintaan anda terkait berkas <strong>{{ $data->unduhan->title }}</strong> disetujui oleh Administrator.</p>
<p>Silakan gunakan link berikut untuk mengunduh berkas</p>
<a href="{{ $link }}">Unduh Berkas</a>
@elseif ($data->status == 'reject')
<p>Mohon maaf permintaan anda terkait berkas <strong>{{ $data->unduhan->title }}</strong> tidak disetujui oleh Administrator.</p>
@if ($data->admin_message)
<p>Alasan penolakan:<br>{{ $data->admin_message }}</p>
@endif    
@endif
