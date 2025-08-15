<?php
namespace App\Filament\Resources\Inquiries;

use App\Filament\Resources\Inquiries\Pages\CreateInquiry;
use App\Filament\Resources\Inquiries\Pages\EditInquiry;
use App\Filament\Resources\Inquiries\Pages\ListInquiries;
use App\Filament\Resources\Inquiries\Pages\ViewInquiry;
use App\Filament\Resources\Inquiries\Schemas\InquiryForm;
use App\Filament\Resources\Inquiries\Schemas\InquiryInfolist;
use App\Filament\Resources\Inquiries\Tables\InquiriesTable;
use App\Models\Inquiry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InquiryResource extends Resource
{
    protected static ?string $model = Inquiry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Inbox;

    protected static ?string $recordTitleAttribute = 'ticket_id';

    public static function form(Schema $schema): Schema
    {
        return InquiryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InquiryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InquiriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListInquiries::route('/'),
            'create' => CreateInquiry::route('/create'),
            'view'   => ViewInquiry::route('/{record}'),
            'edit'   => EditInquiry::route('/{record}/edit'),
        ];
    }

    /**
     * Custom record resolver for Filament
     */
    public static function getRecordRouteKeyName(): string
    {
        return 'ticket_id';
    }
}
