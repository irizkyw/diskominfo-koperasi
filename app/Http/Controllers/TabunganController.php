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
        $title = "Dashboard - Tabungan Anggota";
        return view("tabungan.index", compact('title'));
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
            "tabungan_tahunan" => 0,
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

    public function getTabunganByUserId($user_id)
    {
        $tabungan = Tabungan::where("user_id", $user_id)->first();
        if (!$tabungan) {
            return response()->json(["message" => "Tabungan not found"], 404);
        }
        return $tabungan;
    }

    public function updateTabungan(Request $request, $id)
    {
        $tabungan = Tabungan::find($id);
        $golongan = Golongan::find($request->group);
        if (!$tabungan || !$golongan) {
            return $golongan
                ? response()->json(
                    [
                        "message" => "Golongan not found",
                    ],
                    404
                )
                : response()->json(
                    [
                        "message" => "Tabungan not found",
                    ],
                    404
                );
        }

        $tabungan->update([
            "simp_pokok" => $golongan->simp_pokok,
            "simp_sukarela" => $request->simp_sukarela,
            "simp_wajib" => $request->simp_wajib,
        ]);

        return response()->json([
            "message" => "Tabungan updated successfully",
            "tabungan" => $tabungan,
        ]);
    }
}
