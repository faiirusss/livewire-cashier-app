<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Forms;
use Filament\Actions;
use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make()->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password(),
                Forms\Components\Select::make('role')
                    ->options(User::ROLES)
                    ->native(false)
                    ->required()
            ])->columns(2),
        ]);
    }
}
