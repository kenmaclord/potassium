<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Analytics\Period;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function index()
    {
		// //retrieve visitors and pageview data for the current day and the last seven days
		// // $analyticsData = \Analytics::fetchVisitorsAndPageViews(Period::days(7));
		// //fetch the most visited pages for today and the past week
		// // $analyticsData = \Analytics::fetchMostVisitedPages(Period::months(1));
		// $analyticsData = \Analytics::fetchMostVisitedPages(Period::days(6));
		// dd($analyticsData);

		// //retrieve visitors and pageviews since the 6 months ago
		// $analyticsData = \Analytics::fetchVisitorsAndPageViews(Period::days(7));
		// $analyticsData = \Analytics::fetchUserTypes(Period::months(1));

		// //retrieve sessions and pageviews with yearMonth dimension since 1 year ago
		// $analyticsData = \Analytics::performQuery(
		//     Period::months(12),
		//     'ga:sessions',
		//     [
		//         'dimensions' => 'ga:language',
		// 		'sort' => '-ga:sessions',
  //               'max-results' => 20,
		//     ]
		// );
        return view('admin.pages.dashboard.index');
    }
}
