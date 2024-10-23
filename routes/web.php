<?php

use App\Livewire\Pdfread\Index;
use Illuminate\Support\Facades\Route;
use App\Livewire\Pdfread\Chat;

Route::get('/', Index::class)->name('pdfread');
Route::get('/chat/{id}', Chat::class)->name('chat');

