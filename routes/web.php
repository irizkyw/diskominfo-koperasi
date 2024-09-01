<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\AdminContoller;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;

use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;

use App\Http\Middleware\AdminMiddleware;

Route::get("/", function () {
    return view("landing.home");
})->name("landing.home");

Route::get("/authentication/sign-in", [
    AuthController::class,
    "showLoginForm",
])->name("login");
Route::post("/authentication/authenticated", [
    AuthController::class,
    "login",
])->name("login.submit");

Route::middleware(["auth"])->group(function () {
    Route::get("/profile", [ProfileController::class, "index"])->name(
        "profile"
    );
    Route::get("/profile/datatable", [
        ProfileController::class,
        "monthly",
    ])->name("profile.datatable");
    Route::post("/profile/updatePassword", [
        ProfileController::class,
        "updatePassword",
    ])->name("profile.updatePassword");
    Route::get("/logout", [AuthController::class, "logout"])->name("logout");
});

Route::get("/users/datatable", [UsersController::class, "datatable"])->name(
    "users.datatable"
);

Route::get("/roles/datatable", [RolesController::class, "datatable"])->name(
    "roles.datatable"
);
Route::middleware(["auth", AdminMiddleware::class])
    ->prefix("dashboard")
    ->group(function () {
        Route::get("/", [DashboardController::class, "index"])->name(
            "dashboard"
        );
        Route::get("/users", [UsersController::class, "index"])->name(
            "users.index"
        );
        Route::get("/users/datatable", [
            UsersController::class,
            "datatable",
        ])->name("users.datatable");
        Route::get("/users/generate", [
            UsersController::class,
            "getNewMemberNumber",
        ])->name("users.generate_number");
        Route::get("/users/detail/{num_member}", [
            UsersController::class,
            "cekUserByNumMember",
        ])->name("users.detail");
        Route::post("/users/create", [
            UsersController::class,
            "createUser",
        ])->name("users.create");
        Route::post("/users/update/{id}", [
            UsersController::class,
            "updateUser",
        ])->name("users.update");
        Route::delete("/users/destory/{id}", [
            UsersController::class,
            "deleteUser",
        ])->name("users.destroy");
        Route::delete("/users/forceDestroy/{id}", [
            UsersController::class,
            "forceDeleteUser",
        ])->name("users.forceDestroy");
        Route::get("/users/restore/{num_member}", [
            UsersController::class,
            "restoreUser",
        ])->name("users.restore");

        Route::get("/roles", [RolesController::class, "index"])->name(
            "roles.index"
        );
        Route::get("/roles/datatable", [
            RolesController::class,
            "datatable",
        ])->name("roles.datatable");
        Route::post("/roles/create", [RolesController::class, "store"])->name(
            "roles.create"
        );
        Route::post("/roles/update/{id}", [
            RolesController::class,
            "update",
        ])->name("roles.update");
        Route::delete("/roles/destroy/{id}", [
            RolesController::class,
            "destroy",
        ])->name("roles.destroy");
        Route::get("/roles/detail/{id}", [
            RolesController::class,
            "findById",
        ])->name("roles.findById");

        Route::get("/golongan", [GolonganController::class, "index"])->name(
            "golongan.index"
        );
        Route::get("/golongan/datatable", [
            GolonganController::class,
            "datatable",
        ])->name("golongan.datatable");
        Route::post("/golongan/create", [
            GolonganController::class,
            "store",
        ])->name("golongan.create");
        Route::post("/golongan/{id}/update", [
            GolonganController::class,
            "update",
        ])->name("golongan.update");
        Route::delete("/golongan/delete/{id}", [
            GolonganController::class,
            "destroy",
        ])->name("golongan.destroy");
        Route::get("/golongan/find/{id}", [
            GolonganController::class,
            "findById",
        ])->name("golongan.findById");

        Route::get("/savings", [TransaksiController::class, "index"])->name(
            "simpanan.index"
        );
        Route::get("/savings/datatable", [
            TransaksiController::class,
            "datatable",
        ])->name("simpanan.datatable");
        Route::post("/savings/create", [
            TransaksiController::class,
            "createSimpanan",
        ])->name("simpanan.create");
        Route::delete("/savings/destroy/{id}", [
            TransaksiController::class,
            "deleteSimpanan",
        ])->name("simpanan.destroy");
        Route::post("/savings/export", [
            TransaksiController::class,
            "exportSimpanan",
        ])->name("simpanan.export");
        Route::post("/savings/import", [
            TransaksiController::class,
            "importSimpanan",
        ])->name("simpanan.import");
        Route::get("/savings/export-template", [
            TransaksiController::class,
            "exportTemplate",
        ])->name("simpanan.export-template");
        Route::post("/savings/update/{id}", [
            TransaksiController::class,
            "updateSimpanan",
        ])->name("simpanan.update");
        Route::get("/savings/detail/{id}", [
            TransaksiController::class,
            "transaksiById",
        ])->name("simpanan.findById");
        Route::get("/savings/table", [
            TransaksiController::class,
            "table_simpanan",
        ])->name("simpanan.table");

        Route::get("/load-tabel-simpananan", [
            TransaksiController::class,
            "loadTabelSimpananan",
        ])->name("simpanan.loadTabelSimpananan");

        Route::get("/event", [
            EventController::class, 
            "index"
        ])->name("event.index");

        Route::get("/event/data", [
            EventController::class, 
            "getEventsData"
        ])->name("event.data");

        Route::get("/event/datatable", [
            EventController::class, 
            "datatable"
        ])->name("event.datatable");

        Route::post("/event/create", [
            EventController::class, 
            "store"
        ])->name("event.create");

        Route::post("/event/{id}/update", [
            EventController::class, 
            "update"    
        ])->name("event.update");

        Route::delete("/event/delete/{id}", [
            EventController::class, 
            "destroy"
        ])->name("event.destroy");

        Route::get("/event/find/{id}", [
            EventController::class, 
            "findById"
        ])->name("event.findById");
    });
