<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MailSetting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\CartOrder;
use App\Cart;
use PdfReport;
use ExcelReport;

class AdminReportController extends Controller
{
        
    public function __construct()
    {
        $this->middleware('auth:admin');

    }

    //all order report
    public function allOrder(Request $request)
{
    //pdf report
    if($request->type=="pdf"){
        $fromDate =strval($request->from);
        $toDate =strval($request->to);
    
        $title = 'All Order Report'; // Report title
    
        $meta = [ // For displaying filters description on header
            'Registered on' => $fromDate . ' To ' . $toDate
        ];
    
        $queryBuilder = CartOrder::select(['date', 'datetime', 'customername','phonenumber','email','location','totalcost','status']) // Do some querying..
                            ->whereBetween('date', [$fromDate, $toDate]);
    
        $columns = [ // Set Column to be displayed
            'date', 'datetime', 'customername','phonenumber','email','location','totalcost','status'
        ];
    
        // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
        return PdfReport::of($title, $meta, $queryBuilder, $columns)
                        ->editColumns(['totalcost','status'], [ // Mass edit column
                            'class' => 'right bolder  italic-red'
                        ]) ->setOrientation('portrait')
                        ->setCss([
                            '.bolder' => 'font-weight: 800;',
                            '.italic-red' => 'color: red;font-style: italic;'
                        ])
                        ->limit(20) // Limit record to be showed
                        ->stream();  // other available method: download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
    //return response($queryBuilder);
    }
    //csv report
    else{
        $fromDate =strval($request->from);
        $toDate =strval($request->to);
    
        $title = 'All Order Report'; // Report title
    
        $meta = [ // For displaying filters description on header
            'Registered on' => $fromDate . ' To ' . $toDate
        ];
    
        $queryBuilder = CartOrder::select(['date', 'datetime', 'customername','phonenumber','email','location','totalcost','status']) // Do some querying..
                            ->whereBetween('date', [$fromDate, $toDate]);
    
        $columns = [ // Set Column to be displayed
            'date', 'datetime', 'customername','phonenumber','email','location','totalcost','status'
        ];
    
        // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
         $csv= ExcelReport::of($title, $meta, $queryBuilder, $columns)
                        ->editColumns(['totalcost','status'], [ // Mass edit column
                            'class' => 'right bolder  italic-red'
                        ]) ->setOrientation('portrait')
                        ->setCss([
                            '.bolder' => 'font-weight: 800;',
                            '.italic-red' => 'color: red;font-style: italic;'
                        ])
                        ->limit(20) // Limit record to be showed
                        ->download("orders");  // other available method: download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
    } 
}
public function approvedOrders(Request $request)
{
    $fromDate =strval($request->from);
    $toDate =strval($request->to);

    $title = 'All Approved Orders'; // Report title

    $meta = [ // For displaying filters description on header
        'Registered on' => $fromDate . ' To ' . $toDate
    ];

    $queryBuilder = CartOrder::select(['date', 'datetime', 'customername','phonenumber','email','location','totalcost','status']) // Do some querying..
                        ->where('status','confirm')->whereBetween('date', [$fromDate, $toDate]);

    $columns = [ // Set Column to be displayed
        'date', 'datetime', 'customername','phonenumber','email','location','totalcost','status'
    ];

    // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
    return PdfReport::of($title, $meta, $queryBuilder, $columns)
                    ->editColumns(['totalcost','status'], [ // Mass edit column
                        'class' => 'right bolder  italic-red'
                    ]) ->setOrientation('portrait')
                    ->setCss([
                        '.bolder' => 'font-weight: 800;',
                        '.italic-red' => 'color: red;font-style: italic;'
                    ])
                    ->limit(20) // Limit record to be showed
                    ->download('customers');  // other available method: download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
}
public function customers(Request $request)
{
    $fromDate =strval($request->from);
    $toDate =strval($request->to);

    $title = 'Customers Report'; // Report title

    $meta = [ // For displaying filters description on header
        'Registered on' => $fromDate . ' To ' . $toDate
    ];

    $queryBuilder = User::select(['fname', 'name', 'location','phonenumber','email','idno','cap','balance','status']) // Do some querying..
                        ->whereBetween('registered_at', [$fromDate, $toDate]);

    $columns = [ // Set Column to be displayed
        'fname', 'name', 'location','phonenumber','email','idno','cap','balance','status'
    ];

    // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
    return PdfReport::of($title, $meta, $queryBuilder, $columns)
                     ->editColumns(['balance','cap'], [ // Mass edit column
                         'class' => 'right bolder  italic-red'
                     ]) ->setOrientation('portrait')
                     ->setCss([
                         '.bolder' => 'font-weight: 800;',
                         '.italic-red' => 'color: red;font-style: italic;'
                     ])
                    ->limit(20) // Limit record to be showed
                    ->download('customers');  // other available method: download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
}
}
