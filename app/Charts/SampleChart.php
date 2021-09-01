<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class SampleChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */

   
    public function handler(Request $request): Chartisan
    {
        $agua= DB::table('aguas')->get();
        $labels = [];
        $count = [];
        foreach ($agua as $ag){
            array_push($labels,$ag->Semana);
            array_push($count,$ag->Agua);
        }
        
        return Chartisan::build()
            ->labels($labels)
            ->dataset('Sample', $count);
           
    }
}
