<?php

namespace App\Filament\Resources\WoocommerceProductVariationResource\Pages;

use App\Filament\Resources\WoocommerceProductVariationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWoocommerceProductVariation extends EditRecord
{
    protected static string $resource = WoocommerceProductVariationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
