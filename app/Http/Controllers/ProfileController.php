<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf; // <- import facade PDF dengan benar

class ProfileController extends Controller
{
    // Tampilkan halaman profil
    public function index()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    // Update data profil
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }

    // Export data ke CSV
    public function exportCsv()
    {
        $user = Auth::user();
        $transactions = $user->transactions; // Pastikan relasi User->transactions sudah ada

        $filename = "data_{$user->name}.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Tanggal', 'Kategori', 'Jumlah', 'Tipe']);

        foreach ($transactions as $trx) {
            fputcsv($handle, [
                $trx->date,
                $trx->category,
                $trx->amount,
                $trx->type,
            ]);
        }

        fclose($handle);
        return response()->download($filename)->deleteFileAfterSend(true);
    }

    // Export profil ke PDF
    public function exportPdf()
    {
        $user = Auth::user();
        $pdf = Pdf::loadView('profile_pdf', compact('user'));
        return $pdf->download('profil_pengguna.pdf');
    }
}
