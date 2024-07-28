<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('member_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('invoice_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('discount_type')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('discount_price')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('grand_total')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('payment_method')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DateTimePicker::make('done_at'),
                Forms\Components\TextInput::make('paid_amount')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('return_amount')
                    ->numeric()
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('member_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('discount_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('discount_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grand_total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->searchable(),
                Tables\Columns\TextColumn::make('done_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('paid_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('return_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
