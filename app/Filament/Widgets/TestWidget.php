<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestWidget extends BaseWidget

{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $start = $this->filters['startDate'] ?? null;
        $end = $this->filters['endDate'] ?? null;

        return [
            Stat::make('Nuevos Usuarios',
                User::
                when(
                    $start,
                    fn($query) => $query->whereDate('created_at', '>', $start)
                )
                ->when(
                    $end,
                    fn($query) => $query->whereDate('created_at', '<', $end)
                )
                ->count()
            )
            ->description('Nuevos usuarios que se han registrado')
            ->descriptionIcon('heroicon-m-users', IconPosition::Before)
            ->chart([1, 3, 5, 10, 20, 40])
            ->color('success'),
        ];
    }

}
