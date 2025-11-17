<?php

namespace App\Http\Controllers;

use App\Models\QrCode;

class DashboardController extends Controller
{
    public function index()
    {
        $totalQrCodes = QrCode::count();
        $lastQrCodes = QrCode::select('id', 'title', 'uuid', 'created_at', 'views')
            ->latest()
            ->take(5)
            ->get();
        
        $totalScans = QrCode::sum('views');
        
        return view('dashboard', compact('totalQrCodes', 'lastQrCodes', 'totalScans'));
    }
}
