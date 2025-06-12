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
use Filament\Tables\Actions\Action;


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
                                        $set('color', null);
                                        $set('seats', null);
                                        $set('doors', null);
                                        $set('production_year', null);
                                        $set('weight', null);
                                    }
                                })
                                ->helperText('Voer het kenteken van de auto in.'),
                        ])
                        ->description('Stap 1 van 2: Voer het kenteken in.'),

                    Step::make('Car Details')
                        ->schema([
                            Forms\Components\TextInput::make('brand')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('bijv. Toyota, Volkswagen')
                                ->helperText('Automerk, vaak vooraf ingevuld door kenteken.'),
                            Forms\Components\TextInput::make('model')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('bijv. Corolla, Golf')
                                ->helperText('Automodel, vaak vooraf ingevuld door kenteken.'),
                            Forms\Components\TextInput::make('price')
                                ->required()
                                ->numeric()
                                ->minValue(0)
                                ->prefix('€')
                                ->helperText('Voer de vraagprijs voor de auto in.'),
                            Forms\Components\TextInput::make('mileage')
                                ->required()
                                ->numeric()
                                ->minValue(0)
                                ->suffix('km')
                                ->helperText('Huidige kilometerstand van de auto.'),
                            Forms\Components\TextInput::make('seats')
                                ->numeric()
                                ->nullable()
                                ->minValue(1)
                                ->maxValue(9)
                                ->helperText('Aantal zitplaatsen.'),
                            Forms\Components\TextInput::make('doors')
                                ->numeric()
                                ->nullable()
                                ->minValue(2)
                                ->maxValue(5)
                                ->helperText('Aantal deuren.'),
                            Forms\Components\TextInput::make('production_year')
                                ->numeric()
                                ->nullable()
                                ->minValue(1900)
                                ->maxValue(date('Y') + 1)
                                ->helperText('Productiejaar.'),
                            Forms\Components\TextInput::make('weight')
                                ->numeric()
                                ->nullable()
                                ->minValue(100)
                                ->suffix('kg')
                                ->helperText('Gewicht van de auto in kilogram.'),
                            Forms\Components\TextInput::make('color')
                                ->maxLength(255)
                                ->nullable()
                                ->helperText('Hoofdkleur van de auto.'),

                            Forms\Components\Hidden::make('user_id')
                                ->default(fn () => Auth::id()),

                            Forms\Components\Hidden::make('views')
                                ->default(0),
                        ])
                        ->description('Stap 2 van 2: Geef de gedetailleerde informatie van de auto op.'),
                ])
                ->columnSpanFull()
                ->skippable(false)
                ->submitAction(new HtmlString('<button type="submit" class="filament-button filament-button-size-md filament-button-color-primary filament-button-labeled-icon inline-flex items-center justify-center gap-1 font-semibold rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.5rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:ring-offset-primary-600 filament-footer-action-button">Aanbod indienen</button>'))
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable()
                    ->label('Aanbieder'),
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
                Tables\Columns\IconColumn::make('is_sold')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->color(fn (Car $record): string => $record->is_sold ? 'success' : 'danger')
                    ->sortable(),
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

            ])
            ->actions([

                Tables\Actions\EditAction::make(),


                Action::make('update_price_status')
                    ->label('Prijs/Status Aanpassen')
                    ->icon('heroicon-o-currency-euro')
                    ->fillForm(fn (Car $record): array => [
                        'price' => $record->price,
                        'is_sold' => $record->is_sold,
                    ])
                    ->form([
                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->prefix('€')
                            ->helperText('Pas de vraagprijs aan.'),
                        Forms\Components\Toggle::make('is_sold')
                            ->label('Markeer als verkocht')
                            ->helperText('Schakel in om de auto als verkocht te markeren.'),
                    ])
                    ->action(function (Car $record, array $data): void {
                        $record->price = $data['price'];
                        $record->is_sold = $data['is_sold'];
                        $record->save();
                        \Filament\Notifications\Notification::make()
                            ->title('Auto-aanbod bijgewerkt!')
                            ->success()
                            ->send();
                    })
                    ->modalSubmitActionLabel('Opslaan')
                    ->modalCancelActionLabel('Annuleren'),


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
