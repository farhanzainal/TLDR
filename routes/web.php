<?php

use App\Livewire\Pdfread\Index;
use Illuminate\Support\Facades\Route;

Route::get('/', Index::class)->name('pdfread');

