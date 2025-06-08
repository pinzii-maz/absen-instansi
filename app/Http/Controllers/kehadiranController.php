<?php

namespace App\Http\Controllers;

use IpHelper;
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
        $today = Carbon::now();
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOf('month');

        $hasAttendedToday = CatatanKehadiran::where('user_id', $user->id)
            ->where(function ($query) use ($today) {
                $query->whereDate('tanggal_masuk', $today) // Untuk absen harian
                      ->orWhere(function($q) use ($today) { // Untuk izin multi-hari
                          $q->whereDate('tanggal_masuk', '<=', $today)
                            ->whereDate('tanggal_selesai_izin', '>=', $today);
                      });
            })
            ->exists();

        $hasClockedOutToday = CatatanKehadiran::where('user_id', $user->id)
            ->whereDate('tanggal_masuk', $today)
            ->whereNotNull('jam_pulang')
            ->exists();

        session(['has_attended_today' => $hasAttendedToday]);
        session(['has_clocked_out_today' => $hasClockedOutToday]);

        $totalAttendance = CatatanKehadiran::where('user_id', $user->id)
            ->whereBetween('tanggal_masuk', [$currentMonthStart, $currentMonthEnd])
            ->whereHas('jenisKehadiran', function($q) {
                $q->where('code', 'H'); // Hanya hitung yang 'Hadir (Masuk)'
            })
            ->count();

        $jamMasukKantor = '08:00:00';
        $totalMasukBulanIni = $totalAttendance;

        $totalTepatWaktu = CatatanKehadiran::where('user_id', $user->id)
            ->whereBetween('tanggal_masuk', [$currentMonthStart, $currentMonthEnd])
            ->whereHas('jenisKehadiran', function($q) {
                $q->where('code', 'H');
            })
            ->whereTime('jam_masuk', '<=', $jamMasukKantor)
            ->count();
        
        $onTimePercentage = ($totalMasukBulanIni > 0) ? round(($totalTepatWaktu / $totalMasukBulanIni) * 100) : 0;

        // Get leave requests for the current user
        $leaveRequests = CatatanKehadiran::where('user_id', $user->id)
            ->whereNotNull('tanggal_selesai_izin') // Only get leave requests
            ->with('jenisKehadiran')
            ->orderBy('created_at', 'desc')
            ->take(5) // Show only the last 5 requests
            ->get();

        return view('dashboard', compact('totalAttendance', 'onTimePercentage', 'leaveRequests'));
    }

     public function submitLeave(Request $request)
    {
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
            ->where(function ($query) use ($startDate, $endDate) {
                // Cek jika tanggal mulai atau selesai izin baru berada di dalam rentang record yang sudah ada
                $query->where(function ($q) use ($startDate, $endDate) {
                    $q->where('tanggal_masuk', '<=', $endDate) // Tanggal mulai record lama <= tanggal selesai izin baru
                      ->whereRaw('COALESCE(tanggal_selesai_izin, tanggal_masuk) >= ?', [$startDate]); // Tanggal selesai record lama >= tanggal mulai izin baru
                });
            })
            ->exists();

        if ($overlappingRecord) {
            return response()->json(['success' => false, 'message' => 'Anda sudah memiliki catatan kehadiran/izin pada rentang tanggal tersebut.'], 400);
        }

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
}
