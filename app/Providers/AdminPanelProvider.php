<?php
namespace App\Providers;

use App\Filament\Widgets\MetricsOverview;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->colors([
                'primary' => Color::Indigo,
                'success' => Color::Emerald,
                'danger' => Color::Rose,
                'info' => Color::Blue,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->widgets([
                MetricsOverview::class,
                // d'autres widgets personnalisés...
            ]);
    }
}
