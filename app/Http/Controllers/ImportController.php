<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        $header = fgetcsv($handle); // 1行目（ヘッダー）
        DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle)) !== false) {
                Employee::create([
                    'name'     => $row[0] ?? null,
                    'email'    => $row[1] ?? null,
                    'position' => $row[2] ?? null,
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'インポート成功']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'インポート失敗'], 500);
        }
    }
}
