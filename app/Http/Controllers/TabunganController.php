<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Golongan;
use App\Models\Tabungan;
use App\Models\Transaksi;
class TabunganController extends Controller
{
    public function index()
    {
        return view("tabungan.index");
    }

    public function createTabungan(Request $request)
    {
        $golongan = Golongan::find($request->group);
        if (!$golongan) {
            return response()->json(
                [
                    "message" => "Golongan not found",
                ],
                404
            );
        }

        $tabungan = Tabungan::create([
            "user_id" => $request->user_id,
            "simp_pokok" => $golongan->simp_pokok,
            "simp_sukarela" => $request->simp_sukarela ?? 0,
            "simp_wajib" => $request->simp_wajib ?? 0,
        ]);

        if (!$tabungan) {
            return response()->json(
                [
                    "message" => "Failed to create savings account",
                ],
                500
            );
        }

        return response()->json(
            [
                "message" => "Savings account created successfully",
                "tabungan" => $tabungan,
            ],
            200
        );
    }
}
