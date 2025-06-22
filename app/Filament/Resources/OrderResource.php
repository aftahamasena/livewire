<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Sales Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Customer')
                    ->required()
                    ->searchable()
                    ->preload(),

                Select::make('status')
                    ->options([
                        OrderStatus::pending->value => 'Pending',
                        OrderStatus::paid->value => 'Paid',
                        OrderStatus::shipped->value => 'Shipped',
                        OrderStatus::completed->value => 'Completed',
                        OrderStatus::cancelled->value => 'Cancelled',
                        OrderStatus::reffunded->value => 'Refunded',
                    ])
                    ->required()
                    ->default(OrderStatus::pending->value),

                TextInput::make('total_price')
                    ->label('Total Price')
                    ->numeric()
                    ->prefix('$')
                    ->required()
                    ->minValue(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Order ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Customer')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(function ($state) {
                        if ($state instanceof OrderStatus) {
                            $state = $state->value;
                        }

                        return match ($state) {
                            OrderStatus::pending->value => 'gray',
                            OrderStatus::paid->value => 'blue',
                            OrderStatus::shipped->value => 'yellow',
                            OrderStatus::completed->value => 'green',
                            OrderStatus::cancelled->value => 'red',
                            OrderStatus::reffunded->value => 'orange',
                            default => 'gray',
                        };
                    })
                    ->sortable(),

                TextColumn::make('total_price')
                    ->label('Total Price')
                    ->money('USD')
                    ->sortable(),

                TextColumn::make('orderItems_count')
                    ->label('Items')
                    ->counts('orderItems')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Order Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        OrderStatus::pending->value => 'Pending',
                        OrderStatus::paid->value => 'Paid',
                        OrderStatus::shipped->value => 'Shipped',
                        OrderStatus::completed->value => 'Completed',
                        OrderStatus::cancelled->value => 'Cancelled',
                        OrderStatus::reffunded->value => 'Refunded',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OrderItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', OrderStatus::pending->value)->count();
    }
}
