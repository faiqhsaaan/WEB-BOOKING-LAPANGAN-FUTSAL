<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class ExampleChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LarapexChart
    {
        return $this->chart->pieChart()
            ->setTitle('Distribution of Sales')
            ->setSubtitle('Sales by Category')
            ->addData([30, 40, 25, 5])
            ->setLabels(['Category A', 'Category B', 'Category C', 'Category D']);
    }
}
