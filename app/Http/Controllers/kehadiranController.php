<?php

namespace App\Http\Controllers;

use App\Helpers\IpHelper; // ✅ Perbaikan import
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\JaringanKantor;
use App\Models\JenisKehadiran;
use App\Helpers\KehadiranHelper;
use App\Models\CatatanKehadiran;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class kehadiranController extends Controller
{
    public function dashboard() {
         $user = Auth::user();
        $today = Carbon::today();

        // Cek ke database HANYA untuk catatan hari ini yang sudah ada jam masuknya.
        $absenMasukHariIni = CatatanKehadiran::where('user_id', $user->id)
            ->whereDate('tanggal_masuk', $today)
            ->whereNotNull('jam_masuk')
            ->first();

        // Cek apakah sudah absen pulang HANYA JIKA sudah absen masuk hari ini.
        $absenPulangHariIni = $absenMasukHariIni && $absenMasukHariIni->jam_pulang;

        // Atur session dengan status yang BENAR berdasarkan data hari ini saja.
        session([
            'has_attended_today' => (bool)$absenMasukHariIni,
            'has_clocked_out_today' => (bool)$absenPulangHariIni,
        ]);


        // Sisa kode untuk statistik dan data lainnya (tidak perlu diubah)
        $currentMonthStart = $today->copy()->startOfMonth();
        $currentMonthEnd = $today->copy()->endOfMonth();

        $totalAttendance = CatatanKehadiran::where('user_id', $user->id)
            ->whereBetween('tanggal_masuk', [$currentMonthStart, $currentMonthEnd])
            ->whereNotNull('jam_masuk')->count();

        $totalTepatWaktu = CatatanKehadiran::where('user_id', $user->id)
            ->whereBetween('tanggal_masuk', [$currentMonthStart, $currentMonthEnd])
            ->whereNotNull('jam_masuk')->whereTime('jam_masuk', '<=', '10:00:00')->count();
        
        $onTimePercentage = ($totalAttendance > 0) ? round(($totalTepatWaktu / $totalAttendance) * 100) : 0;

        $jenisKehadiran = JenisKehadiran::whereIn('code', ['S', 'I', 'C', 'DL', 'TL'])->get();

        $leaveRequests = CatatanKehadiran::where('user_id', $user->id)
            ->whereHas('jenisKehadiran', fn($q) => $q->whereNotIn('code', ['H', 'P', 'T']))
            ->with('jenisKehadiran')->latest()->take(5)->get();

        $pegawaiInfo = [
            ['label' => 'Nama Lengkap', 'value' => $user->name],
            ['label' => 'Email', 'value' => $user->email],
            ['label' => 'NIP', 'value' => $user->nip],
            ['label' => 'Jabatan', 'value' => ucwords(str_replace('_', ' ', $user->role))],
        ];

        return view('dashboard', compact('totalAttendance', 'onTimePercentage', 'jenisKehadiran', 'leaveRequests', 'pegawaiInfo'));
    }

    // ✅ Method absenMasuk yang hilang
    public function absenMasuk(Request $request)
    {
        try {
              $user = Auth::user();
            $clientIp = IpHelper::getClientIp($request);
            $now = Carbon::now(); // Sekarang akan menggunakan timezone 'Asia/Makassar'
            $today = $now->today();

            // Aturan Waktu
            if ($now->hour < 8) {
                return response()->json(['success' => false, 'message' => 'Absen masuk baru dibuka pukul 08:00.'], 400);
            }

            // Cek jaringan kantor (logika Anda tetap dipertahankan)
            $jaringanKantor = JaringanKantor::all();
            $allowedCidrs = $jaringanKantor->pluck('ip_cidr')->toArray();
            if (!IpHelper::isIpInOfficeNetwork($clientIp, $allowedCidrs)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak berada dalam jaringan kantor. IP Anda: ' . $clientIp
                ], 403);
            }

             // Tentukan status Hadir (H) atau Terlambat (T)
            $jenisKehadiranCode = ($now->hour < 10) ? 'H' : 'T';
            $jenisKehadiran = JenisKehadiran::where('code', $jenisKehadiranCode)->firstOrFail();

            // Simpan data
            $kehadiran = CatatanKehadiran::create([
                'user_id' => $user->id,
                'tanggal_masuk' => $today,
                'jenis_kehadiran_id' => $jenisKehadiran->id,
                'jam_masuk' => $now,
                'ip_address_masuk' => $clientIp,
                'status_izin' => 'disetujui'
            ]);

            session(['has_attended_today' => true]);
            return response()->json(['success' => true, 'message' => 'Absen masuk berhasil. Status: ' . $jenisKehadiran->name]);

            return response()->json([
                'success' => true,
                'message' => 'Absen masuk berhasil dicatat',
                'data' => [
                    'jam_masuk' => $kehadiran->jam_masuk->format('H:i:s'),
                    'tanggal' => $kehadiran->tanggal_masuk->format('d-m-Y'),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error absen masuk: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server.'
            ], 500);
        }
    }

    // ✅ Method absenPulang yang hilang
    public function absenPulang(Request $request)
    {
        try {
             $user = Auth::user();
            $clientIp = IpHelper::getClientIp($request);
            $now = Carbon::now();
            $today = $now->today();

            // Aturan Waktu
            if ($now->hour < 16) {
                return response()->json(['success' => false, 'message' => 'Absen pulang baru bisa dilakukan setelah pukul 16:00.'], 400);
            }

            // Cek jaringan kantor
            $jaringanKantor = JaringanKantor::all();
            $allowedCidrs = $jaringanKantor->pluck('ip_cidr')->toArray();
            if (!IpHelper::isIpInOfficeNetwork($clientIp, $allowedCidrs)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak berada dalam jaringan kantor. IP Anda: ' . $clientIp
                ], 403);
            }

            // Cari catatan kehadiran hari ini yang belum ada jam pulangnya
            $kehadiran = CatatanKehadiran::where('user_id', $user->id)
                ->whereDate('tanggal_masuk', $today)
                ->whereNotNull('jam_masuk')
                ->whereNull('jam_pulang')
                ->first();

            if (!$kehadiran) {
                return response()->json(['success' => false, 'message' => 'Anda belum absen masuk atau sudah absen pulang hari ini.'], 400);
            }

            // Update jam pulang
            $kehadiran->update(['jam_pulang' => $now, 'ip_address_pulang' => $clientIp]);
            session(['has_clocked_out_today' => true]);
            return response()->json(['success' => true, 'message' => 'Absen pulang berhasil dicatat.']);

            session(['has_clocked_out_today' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Absen pulang berhasil dicatat',
                'data' => [
                    'jam_pulang' => $kehadiran->jam_pulang->format('H:i:s'),
                    'tanggal' => $kehadiran->tanggal_masuk->format('d-m-Y'),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error absen pulang: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server.'
            ], 500);
        }
    }

    // ✅ Method izin yang hilang
        public function izin()
        {
            dd('Method Izin Dijalankan!');
            
            $jenisKehadiran = JenisKehadiran::whereIn('code', ['S', 'I', 'C'])->get(); // Sakit, Izin, Cuti
            return view('kehadiran.izin', compact('jenisKehadiran'));
        }

        public function submitLeave(Request $request)
        {
            // dd($request->all());

            $validator = Validator::make($request->all(), [
                'jenis_izin' => 'required|string|exists:jenis_kehadiran,code', // Pastikan kode jenis izin ada di tabel
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'keterangan' => 'required|string|max:1000',
                'surat' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // max 5MB
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
            }

            $user = Auth::user();
            $clientIp = $request->ip();
            $now = Carbon::now();
            
            $jenisKehadiran = JenisKehadiran::where('code', $request->input('jenis_izin'))->first();
            if (!$jenisKehadiran) { // Seharusnya sudah divalidasi oleh 'exists' rule
                return response()->json(['success' => false, 'message' => 'Jenis izin tidak valid.'], 400);
            }

            $startDate = Carbon::parse($request->input('tanggal_mulai'));
            $endDate = Carbon::parse($request->input('tanggal_selesai'));

            $overlappingRecord = CatatanKehadiran::where('user_id', $user->id)
            ->whereIn('status_izin', ['menunggu', 'disetujui'])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($q) use ($startDate, $endDate) {
                    $q->where('tanggal_masuk', '<=', $endDate)
                        ->whereRaw('COALESCE(tanggal_selesai_izin, tanggal_masuk) >= ?', [$startDate]);
                });
            })
                ->exists();

            $filePath = null;
            if ($request->hasFile('surat')) {
                $filePath = $request->file('surat')->store('public/surat_izin'); // Simpan ke storage/app/public/surat_izin
            }

            CatatanKehadiran::create([
                'user_id' => $user->id,
                'jenis_kehadiran_id' => $jenisKehadiran->id,
                'tanggal_masuk' => $startDate, // Tanggal mulai izin
                'jam_masuk' => null, // Untuk izin, jam masuk bisa null
                'ip_address_masuk' => $clientIp,
                'tanggal_selesai_izin' => $endDate,
                'keterangan_izin' => $request->input('keterangan'),
                'file_pendukung_izin' => $filePath,
            ]);
            
            // Update session jika izin mencakup hari ini
            if ($now->betweenIncluded($startDate, $endDate->endOfDay())) {
                session(['has_attended_today' => true]);
                session()->forget('has_clocked_out_today');
            }

            return response()->json(['success' => true, 'message' => 'Pengajuan izin berhasil dikirim.']);
        }

         public function cekJaringan(Request $request)
    {
        $clientIp = IpHelper::getClientIp($request);
        $officeNetworks = JaringanKantor::pluck('ip_cidr')->all();

        if (IpHelper::isIpInOfficeNetwork($clientIp, $officeNetworks)) {
            // Jika IP valid, kirim status 'allowed'
            return response()->json(['status' => 'allowed', 'ip' => $clientIp]);
        } else {
            // Jika IP tidak valid, kirim status 'denied'
            return response()->json(['status' => 'denied', 'ip' => $clientIp]);
        }
    }
    
}