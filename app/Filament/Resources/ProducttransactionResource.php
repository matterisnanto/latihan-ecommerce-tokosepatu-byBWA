<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Shoe;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\PromoCode;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\Producttransaction;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProducttransactionResource\Pages;
use App\Filament\Resources\ProducttransactionResource\RelationManagers;

class ProducttransactionResource extends Resource
{
    protected static ?string $model = Producttransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Wizard::make([
                    Wizard\Step::make('product and price')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    
                                
                                Select::make('shoe_id')
                                    ->relationship('shoe', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $get, callable $set){
                                        $shoe = Shoe::find($state);
                                        $price = $shoe ? $shoe->price : 0;
                                        $quantity = $get('quantity') ?? 1;
                                        $subTotalAmount = $price * $quantity;

                                        $set('price', $price);
                                        $set('sub_total_amount', $subTotalAmount);

                                        $discount = $get('discount_amount') ?? 0;
                                        $grandTotalAmount = $subTotalAmount - $discount;
                                        $set('grand_total_amount', $grandTotalAmount);

                                        $sizes = $shoe ? $shoe->sizes->pluck('size', 'id')->toArray() : [];
                                        $set('shoe_sizes', $sizes);
                                    })
                                    ->afterStateHydrated(function (callable $get, callable $set, $state){
                                        $shoeId = $state;
                                        if ($shoeId) {
                                            $shoe = Shoe::find($shoeId);
                                            $sizes = $shoe ? $shoe->sizes->pluck('size', 'id')->toArray() : [];
                                            $set('shoe_sizes', $sizes);
                                        }
                                    }),
                                    Select::make('shoe_size')
                                        ->label('shoe_size')
                                        ->options(function (callable $get){
                                            $sizes = $get('shoe_sizes');
                                            return is_array($sizes) ? $sizes : [];

                                        })
                                        ->required()
                                        ->live(),
                                            
                                    TextInput::make('quantity')
                                    ->required()
                                    ->numeric()
                                    ->prefix('qty')
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $get, callable $set){
                                        $price = $get('price')?? 0;
                                        $quantity = $state;
                                        $subTotalAmount = $price * $quantity;

                                        $set('sub_total_amount', $subTotalAmount);

                                        $discount = $get('discount_amount') ?? 0;
                                        $grandTotalAmount = $subTotalAmount - $discount;
                                        $set('grand_total_amount', $grandTotalAmount);
                                    }),
                                    Select::make('promo_code_id')
                                    ->relationship('promoCode', 'code')
                                    ->searchable()
                                    ->preload()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $get, callable $set){
                                        $subTotalAmount = $get('sub_total_amount');
                                        $promoCode = PromoCode::find($state);
                                        $discount = $promoCode ? $promoCode->discount_amount : 0;

                                        $set('discount_amount', $discount);

                                        $$grandTotalAmount = $subTotalAmount - $discount;
                                        $set('grand_total_amount', $grandTotalAmount);
                                    }),
                                    TextInput::make('sub_total_amount')
                                    ->required()
                                    ->readOnly()
                                    ->numeric()
                                    ->prefix('IDR'),
                                    TextInput::make('grand_total_amount')
                                    ->required()
                                    ->readOnly()
                                    ->numeric()
                                    ->prefix('IDR'),
                                    TextInput::make('discount_amount')
                                    ->readOnly()
                                    ->required()
                                    ->numeric()
                                    ->prefix('IDR'),

                                ]),
                        ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListProducttransactions::route('/'),
            'create' => Pages\CreateProducttransaction::route('/create'),
            'edit' => Pages\EditProducttransaction::route('/{record}/edit'),
        ];
    }
}
