<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Imports\ProductsImport;
use Filament\Forms;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Session;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;

class ImportProducts extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;
    use WithFileUploads;

    protected static string $resource = \App\Filament\Resources\ProductResource::class;

    protected static string $view = 'filament.resources.product-resource.pages.import-products';

    public $file;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\FileUpload::make('file')
                ->label('Excel File')
                ->helperText('Upload file Excel (.xlsx) atau CSV (.csv) dengan maksimal 10MB')
                ->required()
                ->acceptedFileTypes(['.xlsx', '.csv'])
                ->maxSize(10240), // 10 MB max
        ];
    }

    public function import()
    {
        $this->validate([
            'file' => 'required|file|mimes:xlsx,csv|max:10240',
        ]);

        try {
            Excel::import(new ProductsImport, $this->file);

            Notification::make()
                ->title('Import Berhasil')
                ->body('Produk berhasil diimport!')
                ->success()
                ->send();

            return redirect(\App\Filament\Resources\ProductResource::getUrl());
        } catch (\Exception $e) {
            Notification::make()
                ->title('Import Gagal')
                ->body('Terjadi kesalahan: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }
}
