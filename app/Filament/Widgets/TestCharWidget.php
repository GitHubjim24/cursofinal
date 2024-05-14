<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class TestCharWidget extends ChartWidget

{

use InteractsWithPageFilters;

    protected static ?string $heading = ' Test Chart';
    protected int| string |array $columnSpan = 1;

    protected function getData(): array
    {

        $start =  $this->filters['startDate'];
        $end =  $this->filters['endDate'];


  $data = Trend::model(User::class)
        ->between(
            start: $start ? Carbon::parse($start) : now()->subMonth(6),
            end: $end ? Carbon::parse($end) : now(),
        )
        ->perMonth()
        ->count();

      //  dd($data);

        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),

                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
protected function getType(): string
{
    return 'line';
}
}
