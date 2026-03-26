<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromptController;
use App\Models\Prompt;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    $history = [];

    if (auth()->check()) {
        $history = Prompt::where('user_id', auth()->id())
            ->latest()
            ->limit(10)
            ->get();
    }

    return view('dashboard', compact('history'));

})->middleware('auth')->name('dashboard');


/*
|--------------------------------------------------------------------------
| Generate Prompt
|--------------------------------------------------------------------------
*/

Route::post('/generate', [PromptController::class, 'generate'])
    ->middleware('auth');


/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

require __DIR__.'/auth.php';