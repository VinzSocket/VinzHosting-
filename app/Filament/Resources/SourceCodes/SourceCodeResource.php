<?php

namespace App\Filament\Resources\SourceCodes;

use App\Filament\Components\ImageInput;
use App\Filament\Resources\SourceCodes\Pages;
use App\Models\SourceCode;
use Filament\Actions;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SourceCodeResource extends Resource
{
    protected static ?string $model = SourceCode::class;

    protected static ?int $navigationSort = 1;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-code-bracket';

    protected static string|\BackedEnum|null $activeNavigationIcon = 'heroicon-s-code-bracket';

    public static function getNavigationGroup(): ?string
    {
        return trans('admin/navigation.content.title');
    }

    public static function getNavigationLabel(): string
    {
        return trans('admin/navigation.content.source_codes');
    }

    public static function getModelLabel(): string
    {
        return trans('admin/source_codes.label');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('admin/source_codes.plural-label');
    }

    public static function getNavigationBadge(): ?string
    {
        return SourceCode::count() > 0 ? (string) SourceCode::count() : null;
    }

    public static function form(Schema $form): Schema
    {
        return $form
            ->components([
                Section::make(trans('admin/source_codes.section.title'))
                    ->description(trans('admin/source_codes.section.description'))
                    ->schema([
                        TextInput::make('title')
                            ->label(trans('admin/source_codes.fields.title.label'))
                            ->placeholder(trans('admin/source_codes.fields.title.placeholder'))
                            ->required()
                            ->maxLength(191)
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label(trans('admin/source_codes.fields.description.label'))
                            ->placeholder(trans('admin/source_codes.fields.description.placeholder'))
                            ->rows(3)
                            ->maxLength(2000)
                            ->columnSpanFull(),

                        TextInput::make('link')
                            ->label(trans('admin/source_codes.fields.link.label'))
                            ->helperText(trans('admin/source_codes.fields.link.helper'))
                            ->placeholder('https://github.com/username/repo')
                            ->url()
                            ->required()
                            ->maxLength(500)
                            ->columnSpanFull(),

                        TextInput::make('category')
                            ->label(trans('admin/source_codes.fields.category.label'))
                            ->helperText(trans('admin/source_codes.fields.category.helper'))
                            ->placeholder(trans('admin/source_codes.fields.category.placeholder'))
                            ->maxLength(100),

                        ImageInput::make('thumbnail')
                            ->label(trans('admin/source_codes.fields.thumbnail.label'))
                            ->helperText(trans('admin/source_codes.fields.thumbnail.helper'))
                            ->placeholder('https://example.com/thumbnail.png')
                            ->maxLength(500),

                        TextInput::make('order')
                            ->label(trans('admin/source_codes.fields.order.label'))
                            ->helperText(trans('admin/source_codes.fields.order.helper'))
                            ->numeric()
                            ->default(0)
                            ->required(),

                        Toggle::make('is_active')
                            ->label(trans('admin/source_codes.fields.is_active.label'))
                            ->helperText(trans('admin/source_codes.fields.is_active.helper'))
                            ->default(true),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(trans('admin/source_codes.table.id'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ImageColumn::make('thumbnail')
                    ->label(trans('admin/source_codes.table.thumbnail'))
                    ->getStateUsing(fn (SourceCode $record) => $record->thumbnail ?: url('/reviactyl/icon.png')),

                TextColumn::make('title')
                    ->label(trans('admin/source_codes.table.title'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category')
                    ->label(trans('admin/source_codes.table.category'))
                    ->badge()
                    ->searchable()
                    ->placeholder('-'),

                TextColumn::make('link')
                    ->label(trans('admin/source_codes.table.link'))
                    ->limit(40)
                    ->url(fn (SourceCode $record) => $record->link)
                    ->openUrlInNewTab(),

                IconColumn::make('is_active')
                    ->label(trans('admin/source_codes.table.is_active'))
                    ->boolean(),

                TextColumn::make('order')
                    ->label(trans('admin/source_codes.table.order'))
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label(trans('admin/source_codes.table.updated'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order')
            ->actions([
                Actions\Action::make('edit')
                    ->label(trans('admin/source_codes.actions.edit'))
                    ->icon('heroicon-o-pencil')
                    ->url(
                        fn (SourceCode $record): string => static::getUrl('edit', ['record' => $record->getKey()])
                    ),

                Actions\DeleteAction::make()
                    ->label(trans('admin/source_codes.actions.delete'))
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSourceCodes::route('/'),
            'create' => Pages\CreateSourceCode::route('/create'),
            'edit' => Pages\EditSourceCode::route('/{record}/edit'),
        ];
    }
}
