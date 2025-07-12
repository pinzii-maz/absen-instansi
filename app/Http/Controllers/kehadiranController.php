<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\JenisKehadiran;
use App\Models\CatatanKehadiran;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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

        // Sisa kode untuk statistik dan data lainnya
        $currentMonthStart = $today->copy()->startOfMonth();
        $currentMonthEnd = $today->copy()->endOfMonth();

        $totalAttendance = CatatanKehadiran::where('user_id', $user->id)
            ->whereBetween('tanggal_masuk', [$currentMonthStart, $currentMonthEnd])
            ->whereNotNull('jam_masuk')
            ->whereNotNull('jam_pulang')
            ->count();

        $totalTepatWaktu = CatatanKehadiran::where('user_id', $user->id)
            ->whereBetween('tanggal_masuk', [$currentMonthStart, $currentMonthEnd])
            ->whereNotNull('jam_masuk')
            ->whereNotNull('jam_pulang')
            ->whereTime('jam_masuk', '<=', '10:00:00')->count();
        
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

    public function absenMasuk(Request $request)
    {
        try {
            $user = Auth::user();
            $now = Carbon::now();
            $today = $now->today();

            // Aturan Waktu
            if ($now->hour < 8) {
                return response()->json(['success' => false, 'message' => 'Absen masuk baru dibuka pukul 08:00.'], 400);
            }

            // Cek apakah sudah ada catatan kehadiran hari ini
            $existingAbsen = CatatanKehadiran::where('user_id', $user->id)
                ->whereDate('tanggal_masuk', $today)
                ->first();

            if ($existingAbsen) {
                return response()->json(['success' => false, 'message' => 'Anda sudah tercatat hadir atau mengajukan izin hari ini.'], 400);
            }

            // Tentukan status Hadir (H) atau Terlambat (T)
            $jenisKehadiranCode = ($now->hour < 10) ? 'H' : 'T';
            $jenisKehadiran = JenisKehadiran::where('code', $jenisKehadiranCode)->firstOrFail();

            // Simpan data
            CatatanKehadiran::create([
                'user_id' => $user->id,
                'tanggal_masuk' => $today,
                'jenis_kehadiran_id' => $jenisKehadiran->id,
                'jam_masuk' => $now,
                'status_izin' => 'disetujui'
            ]);

            session(['has_attended_today' => true]);
            return response()->json(['success' => true, 'message' => 'Absen masuk berhasil. Status: ' . $jenisKehadiran->name]);

        } catch (\Exception $e) {
            Log::error('Error absen masuk: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan pada server.'], 500);
        }
    }

    public function absenPulang(Request $request)
    {
        try {
            $user = Auth::user();
            $now = Carbon::now();
            $today = $now->today();

            // Aturan Waktu
            if ($now->hour < 16) {
                return response()->json(['success' => false, 'message' => 'Absen pulang baru bisa dilakukan setelah pukul 16:00.'], 400);
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
            $kehadiran->update(['jam_pulang' => $now]);
            session(['has_clocked_out_today' => true]);
            return response()->json(['success' => true, 'message' => 'Absen pulang berhasil dicatat.']);

        } catch (\Exception $e) {
            Log::error('Error absen pulang: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan pada server.'], 500);
        }
    }

    public function izin()
    {
        $jenisKehadiran = JenisKehadiran::whereIn('code', ['S', 'I', 'C'])->get(); // Sakit, Izin, Cuti
        return view('kehadiran.izin', compact('jenisKehadiran'));
    }

    public function submitLeave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_izin' => 'required|string|exists:jenis_kehadiran,code',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'required|string|max:1000',
            'surat.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $user = Auth::user();
        $now = Carbon::now();
        
        $jenisKehadiran = JenisKehadiran::where('code', $request->input('jenis_izin'))->first();
        if (!$jenisKehadiran) {
            return response()->json(['success' => false, 'message' => 'Jenis izin tidak valid.'], 400);
        }

        $startDate = Carbon::parse($request->input('tanggal_mulai'));
        $endDate = Carbon::parse($request->input('tanggal_selesai'));

        $filePaths = []; // Siapkan array kosong untuk menampung path file.

        if ($request->hasFile('surat')) {
            // Lakukan perulangan untuk setiap file yang diunggah.
            foreach ($request->file('surat') as $file) {
                // Simpan file dan tambahkan path-nya ke array $filePaths.
                $path = $file->store('public/surat_izin');
                $filePaths[] = str_replace('public/', '', $path); // Hapus 'public/' agar URL-nya benar
            }
        }

        $overlappingRecord = CatatanKehadiran::where('user_id', $user->id)
            ->whereIn('status_izin', ['menunggu', 'disetujui'])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($q) use ($startDate, $endDate) {
                    $q->where('tanggal_masuk', '<=', $endDate)
                      ->whereRaw('COALESCE(tanggal_selesai_izin, tanggal_masuk) >= ?', [$startDate]);
                });
            })
            ->exists();

        CatatanKehadiran::create([
            'user_id' => $user->id,
            'jenis_kehadiran_id' => $jenisKehadiran->id,
            'tanggal_masuk' => $startDate,
            'jam_masuk' => null,
            'tanggal_selesai_izin' => $endDate,
            'keterangan_izin' => $request->input('keterangan'),
            'file_pendukung_izin' => count($filePaths) > 0 ? json_encode($filePaths) : null,
            'status_izin' => 'menunggu',
        ]);
        
        if ($now->betweenIncluded($startDate, $endDate->endOfDay())) {
            session(['has_attended_today' => true]);
            session()->forget('has_clocked_out_today');
        }

        return response()->json(['success' => true, 'message' => 'Pengajuan izin berhasil dikirim.']);
    }
}