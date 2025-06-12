<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarResource\Pages;
use App\Filament\Resources\CarResource\RelationManagers;
use App\Models\Car;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'license_plate';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('License Plate')
                        ->schema([
                            Forms\Components\TextInput::make('license_plate')
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, $state) {
                                    if ($state === 'SAMPLE-RDW-1') {
                                        $set('brand', 'Toyota');
                                        $set('model', 'Corolla');
                                        $set('production_year', 2018);
                                        $set('color', 'Black');
                                        $set('seats', 5);
                                        $set('doors', 4);
                                        $set('weight', 1200);
                                    } else if ($state === 'TEST-CAR-2') {
                                         $set('brand', 'Volkswagen');
                                         $set('model', 'Golf');
                                         $set('production_year', 2020);
                                         $set('color', 'Blue');
                                         $set('seats', 5);
                                         $set('doors', 5);
                                         $set('weight', 1350);
                                    }
                                    else {
                                        $set('brand', null);
                                        $set('model', null);
                                        $set('production_year', null);
                                        $set('color', null);
                                        $set('seats', null);
                                        $set('doors', null);
                                        $set('weight', null);
                                    }
                                })
                                ->helperText('Enter the car\'s license plate..'),
                        ])
                        ->description('Step 1 of 2: Enter the car\'s license plate.'),

                    Step::make('Car Details')
                        ->schema([
                            Forms\Components\TextInput::make('brand')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('e.g., Toyota, Volkswagen')
                                ->helperText('Car brand.'),
                            Forms\Components\TextInput::make('model')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('e.g., Corolla, Golf')
                                ->helperText('Car model.'),
                            Forms\Components\TextInput::make('price')
                                ->required()
                                ->numeric()
                                ->minValue(0)
                                ->prefix('€')
                                ->helperText('Enter the asking price for the car.'),
                            Forms\Components\TextInput::make('mileage')
                                ->required()
                                ->numeric()
                                ->minValue(0)
                                ->suffix('km')
                                ->helperText('Current mileage of the car.'),
                            Forms\Components\TextInput::make('seats')
                                ->numeric()
                                ->nullable()
                                ->minValue(1)
                                ->maxValue(9)
                                ->helperText('Number of seats.'),
                            Forms\Components\TextInput::make('doors')
                                ->numeric()
                                ->nullable()
                                ->minValue(2)
                                ->maxValue(5)
                                ->helperText('Number of doors.'),
                            Forms\Components\TextInput::make('production_year')
                                ->numeric()
                                ->nullable()
                                ->minValue(1900)
                                ->maxValue(date('Y') + 1)
                                ->helperText('Year of production.'),
                            Forms\Components\TextInput::make('weight')
                                ->numeric()
                                ->nullable()
                                ->minValue(100)
                                ->suffix('kg')
                                ->helperText('Weight of the car in kilograms.'),
                            Forms\Components\TextInput::make('color')
                                ->maxLength(255)
                                ->nullable()
                                ->helperText('Main color of the car.'),

                            Forms\Components\Hidden::make('user_id')
                                ->default(fn () => Auth::id()),

                            Forms\Components\Hidden::make('views')
                                ->default(0),
                        ])
                        ->description('Step 2 of 2: Provide the car\'s detailed information.'),

                ])
                ->columnSpanFull()
                ->skippable(false)
                ->submitAction(new HtmlString('<button type="submit" class="filament-button filament-button-size-md filament-button-color-primary filament-button-labeled-icon inline-flex items-center justify-center gap-1 font-semibold rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.5rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:ring-offset-primary-600 filament-footer-action-button">Submit Offer</button>'))
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable()
                    ->label('Provider'),

                Tables\Columns\TextColumn::make('license_plate')
                    ->searchable(),

                Tables\Columns\TextColumn::make('brand')
                    ->searchable(),

                Tables\Columns\TextColumn::make('model')
                    ->searchable(),

                Tables\Columns\TextColumn::make('price')
                    ->money('EUR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('mileage')
                    ->numeric()
                    ->sortable()
                    ->suffix(' km'),

                Tables\Columns\TextColumn::make('seats')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('doors')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('production_year')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('weight')
                    ->numeric()
                    ->sortable()
                    ->suffix(' kg'),

                Tables\Columns\TextColumn::make('color')
                    ->searchable(),

                Tables\Columns\ImageColumn::make('image'),

                Tables\Columns\TextColumn::make('sold_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('views')
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
            'index' => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'edit' => Pages\EditCar::route('/{record}/edit'),
        ];
    }
}
