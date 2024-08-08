<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromoResource\Pages;
use App\Filament\Resources\PromoResource\RelationManagers;
use App\Models\Promo;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PromoResource extends Resource
{
    protected static ?string $model = Promo::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'Promo';
    protected static ?string $modelLabel = 'Promo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Judul Promo')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('promo_code')
                        ->label('Kode Promo')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('expired_at')
                        ->label('Masa Berlaku')
                        ->required(),

                    Select::make('discount_type')
                    ->label('Tipe Diskon')
                    ->prefixIcon('heroicon-o-currency-dollar')
                    ->options([
                        'Rupiah' => 'Rupiah',
                        'Persen' => 'Persen',
                    ])
                    ->native(false)
                    ->live()
                    ->afterStateUpdated(fn (Select $component) => $component
                        ->getContainer()
                        ->getComponent('dynamicDiscountFields')
                        ->getChildComponentContainer()
                        ->fill()
                    ),
                    Grid::make(2)->schema(fn (Get $get): array => match ($get('discount_type')) {
                        'Rupiah' => [
                            TextInput::make('discount_value')
                                ->numeric()
                                ->prefix('Rp')
                                ->label('Total Diskon (Rupiah)')
                                ->required(),
                        ],
                        'Persen' => [
                            TextInput::make('discount_value')
                                ->numeric()
                                ->label('Diskon Persen')
                                ->suffix('%')
                                ->required(),
                        ],
                        default => [],
                    })->key('dynamicDiscountFields'),


                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Promo')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('promo_code')
                    ->label('Kode Promo')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('discount_type')
                    ->label('Tipe Diskon')
                    ->sortable(),
                    Tables\Columns\TextColumn::make('discount_value')
                    ->label('Besar Diskon')
                    ->numeric()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('expired_at')
                    ->label('Masa Berlaku')
                    ->dateTime()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPromos::route('/'),
            'create' => Pages\CreatePromo::route('/create'),
            'edit' => Pages\EditPromo::route('/{record}/edit'),
        ];
    }
}
