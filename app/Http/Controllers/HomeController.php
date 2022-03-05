<?php

namespace App\Http\Controllers;
use App\invoices;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $count = invoices::count();
        $count2 = invoices::where('Value_status', 2)->count();
        $count1 = invoices::where('Value_status', 1)->count();
        $count3 = invoices::where('Value_status', 3)->count();


      

        if ($count2 == 0) {
            $unpaid = 0;
        } else {
            $unpaid = number_format($count2 / $count * 100, 0);
        }

        if ($count1 == 0) {
            $paid = 0;
        } else {
            $paid = number_format($count1 / $count * 100, 0);
        }

        if ($count3 == 0) {
            $Partial = 0;
        } else {
            $Partial = number_format($count3 / $count * 100, 0);
        }



        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#f93a5a'],
                    'data' => [$unpaid]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#029666'],
                    'data' => [$paid]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#f76a2d'],
                    'data' => [$Partial]
                ],


            ])
            ->options([]);


        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#f93a5a', '#029666', '#f76a2d'],
                    'data' => [$unpaid, $paid, $Partial]
                ]
            ])
            ->options([]);


        return view('home',compact('unpaid', 'paid', 'Partial', 'chartjs', 'chartjs_2'));
    }
}
