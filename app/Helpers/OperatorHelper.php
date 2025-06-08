<?php

namespace App\Helpers;

use App\Models\Operator;
use Illuminate\Support\Facades\Http;

class OperatorHelper
{

    /**
     * Mencari operator berdasarkan keyword.
     * 
     * Pertama-tama, ambil data lokal yang aktif, lalu fetch data dari API eksternal.
     * Gabungkan hasilnya, hindari duplikat berdasarkan NIK.
     *
     * @param string $keyword
     * @return array
     */
    public static function search($keyword)
    {
        // Ambil dulu data lokal yang aktif
        $local = Operator::active()
            ->search(['nik', 'nama'], $keyword)
            ->get();

        // Lalu fetch data dari API eksternal
        $response = Http::withToken(env('API_TOKEN'))
            ->get(env('API_SPISY'), [
                'type' => 'flow',
                'status' => 'active',
                'q' => $keyword
            ]);

        $remote = collect();
        if ($response->successful()) {
            $remote = collect($response->json());
        }

        // Gabungkan hasil, hindari duplikat
        $combined = $local->map(fn($op) => [
            'nik' => $op->nik,
            'nama' => $op->nama,
            'source' => 'local'
        ])->concat(
                $remote->reject(fn($item) => $local->contains('nik', $item['nik']))
                    ->map(fn($op) => [
                        'nik' => $op['nik'],
                        'nama' => $op['nama'],
                        'source' => 'remote'
                    ])
            );

        return $combined->values()->all();
    }

    // simpan data operator dari API eksternal ke database lokal
    public static function saveFromApi(string $nik, string $nama)
    {
        Operator::updateOrCreate(
            [
                'nik' => $nik
            ],
            [
                'nama' => $nama,
                'is_active' => true
            ]
        );

    }

}
