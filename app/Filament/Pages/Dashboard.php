<?php
namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BasePage;
use Filament\Pages\Actions\FilterAction;
use Filament\Forms\Components\Select;

class Dashboard extends BasePage
{
    protected static string $view = 'filament.pages.dashboard';

    public function getActions(): array
    {
        return [
            FilterAction::make()
                ->modalHeading('Filtrer le dashboard')
                ->form([
                    Select::make('period')
                        ->options([
                            'week' => "Cette semaine",
                            'month' => "Ce mois",
                            'year' => "Cette année",
                        ])
                        ->default('week'),
                ]),
        ];
    }

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\MetricsOverview::class,
            // Ajoutez ici un ChartWidget personnalisé selon le filtre
        ];
    }
}
