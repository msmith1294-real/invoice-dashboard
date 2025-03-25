<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\InvoiceDashboard;

Route::get('/invoices', InvoiceDashboard::class)->name('invoices');

require __DIR__.'/auth.php';
