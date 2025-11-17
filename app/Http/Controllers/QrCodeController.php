<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use tbQuar\Facades\Quar;

class QrCodeController extends Controller
{
    public function index()
    {
        $qrcodes = QrCode::select('id', 'title', 'uuid', 'created_at', 'updated_at', 'views')
            ->orderBy('title')
            ->get();

        return view('qrcodes.index', compact('qrcodes'));
    }

    public function create()
    {
        return view('qrcodes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'fields' => 'nullable|array',
            'fields.*.label' => 'nullable|string|max:255',
            'fields.*.value' => 'nullable|string',
        ]);

        $fields = collect($request->input('fields', []))
            ->map(function ($f) {
                return [
                    'label' => trim($f['label'] ?? ''),
                    'value' => trim($f['value'] ?? ''),
                ];
            })
            ->filter(function ($f) {
                return $f['label'] !== '' || $f['value'] !== '';
            })
            ->values()
            ->all();

        $data['fields'] = $fields;

        $qrCode = QrCode::create($data);

        $this->generateFile($qrCode);

        return redirect()->route('qrcodes.index')->with('success', 'QR Code créé');
    }

    public function edit(QrCode $qrcode)
    {
        return view('qrcodes.edit', compact('qrcode'));
    }

    public function update(Request $request, QrCode $qrcode)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'fields' => 'nullable|array',
            'fields.*.label' => 'nullable|string|max:255',
            'fields.*.value' => 'nullable|string',
        ]);

        $fields = collect($request->input('fields', []))
            ->map(function ($f) {
                return [
                    'label' => trim($f['label'] ?? ''),
                    'value' => trim($f['value'] ?? ''),
                ];
            })
            ->filter(function ($f) {
                return $f['label'] !== '' || $f['value'] !== '';
            })
            ->values()
            ->all();

        $data['fields'] = $fields;

        $qrcode->update($data);

        $this->generateFile($qrcode);

        return redirect()->route('qrcodes.index')->with('success', 'QR Code modifié');
    }

    public function destroy(QrCode $qrcode)
    {
        $qrcode->delete();
        $path = "qrcodes/{$qrcode->uuid}.svg";
        Storage::disk('public')->delete($path);
        return redirect()->route('qrcodes.index')->with('success', 'QR Code supprimé');
    }

    public function show($uuid)
    {
        $qrcode = QrCode::where('uuid', $uuid)->firstOrFail();
        $qrcode->increment('views');
        return view('qrcodes.show', compact('qrcode'));
    }

    protected function generateFile(QrCode $qrcode)
    {
        $path = "qrcodes/{$qrcode->uuid}.svg";

        if (Storage::disk('public')->exists($path)) {
            return;
        }

        $url = route('qrcodes.show', $qrcode->uuid);

        $qr = Quar::size(1024)->generate($url);

        Storage::disk('public')->put($path, $qr);
    }

    public function download(QrCode $qrcode, string $format)
    {
        $svgPath = "qrcodes/{$qrcode->uuid}.svg";

        if (!Storage::disk('public')->exists($svgPath)) {
            abort(404, "QR Code SVG non trouvé.");
        }

        $svgContent = Storage::disk('public')->get($svgPath);

        if ($format === 'svg') {
            return response($svgContent, 200)
                ->header('Content-Type', 'image/svg+xml')
                ->header('Content-Disposition', "attachment; filename=\"{$qrcode->uuid}.svg\"");
        }

        if ($format === 'png') {
            $url = route('qrcodes.show', $qrcode->uuid);

            $pngContent = Quar::format('png')
                ->size(1024)
                ->generate($url);

            return response($pngContent, 200)
                ->header('Content-Type', 'image/png')
                ->header('Content-Disposition', "attachment; filename=\"{$qrcode->uuid}.png\"");
        }

        abort(400, "Format non supporté.");
    }
}