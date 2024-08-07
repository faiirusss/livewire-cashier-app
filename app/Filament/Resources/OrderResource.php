<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Member;
use App\Models\Order;
use App\Models\Promo;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Pesanan';
    protected static ?string $modelLabel = 'Pesanan';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([

                    Forms\Components\Select::make('member_id')
                        ->label('Member')
                        ->options(Member::all()->pluck('name', 'id'))
                        ->optionsLimit(3)
                        ->searchable()
                        ->required()
                        ->native(false),
                    Forms\Components\TextInput::make('invoice_number')
                        ->label('No. Invoice')
                        ->prefix('#')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('discount_type')
                        ->options(Promo::all()->pluck('discount_type', 'discount_type'))
                        ->default(null),
                    Forms\Components\TextInput::make('discount_price')
                        ->label('Total Diskon')
                        ->numeric()
                        ->default(null),
                        Forms\Components\TextInput::make('grand_total')
                        ->label('Total Bayar')
                        ->numeric()
                        ->default(null),
                        Forms\Components\TextInput::make('payment_method')
                        ->label('Metode Bayar')
                        ->maxLength(255)
                        ->default(null),
                        Forms\Components\DateTimePicker::make('done_at')
                        ->label('Tanggal Bayar'),
                    Forms\Components\TextInput::make('paid_amount')
                    ->label('Total Bayar')
                    ->numeric()
                    ->default(null),
                    Forms\Components\TextInput::make('return_amount')
                        ->label('Kembalian')
                        ->numeric()
                        ->default(null),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('member.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('invoice_number')
                    ->label('No. Invoice')
                    ->searchable(),
                Tables\Columns\TextColumn::make('discount_type')
                    ->label('Diskon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('discount_price')
                    ->label('Total Diskon')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Qris' => 'success',
                        'Cash' => 'warning',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('paid_amount')
                    ->label('Total Bayar')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('return_amount')
                    ->label('Kembalian')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grand_total')
                    ->label('Harga Total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('done_at')
                    ->label('Tanggal')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('payment_method')
                    ->options([
                        'Qris' => 'Qris',
                        'Cash' => 'Cash',
                    ])
                    ->label('Metode Pembayaran')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
