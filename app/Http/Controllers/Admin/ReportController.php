<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use Mpdf\Mpdf;
use Illuminate\Http\Request;
use App\Models\Order;


class ReportController extends AdminController
{

    private $splitPageLimit = 400;

    public function goods($format, Request $request){
        $title = $request->input('title', 'Отчет');
        $data = [];

        if($format == 'excel')
            $orders =  Order::with('products')
                ->Filters($request->all())
                ->get();
        else{
            $orders =  Order::with('products')
                ->Filters($request->all())
                ->paginate($this->splitPageLimit);
        }


        foreach ($orders as $order)
        {
            foreach ($order->products as $product)
            {
                if(!isset($data[$product->id]['sum']))
                {
                    $data[$product->id]['sum'] = 0;
                    $data[$product->id]['quantity'] = 0;
                }

                $data[$product->id]['product']  = $product;
                $data[$product->id]['sum']      += $product->pivot->price * $product->pivot->quantity;
                $data[$product->id]['quantity'] += $product->pivot->quantity;
            }
        }

        $result = view('reports.goods', [
            'title'          => $title,
            'format'         => $format,
            'data'           => $data,
            'date_start'     => $request->input('created_at_start'),
            'date_end'       => $request->input('created_at_end')
        ]);

        return $this->render($format, $result, $title);
    }

    /*
    public function byDining($format, Request $request){
        $serviceVisitorLog = new ServiceVisitorLog();
        $filters_logs     = $serviceVisitorLog->splitReq($request->all(), 'l_');
        $filters_visitors = $serviceVisitorLog->splitReq($request->all(), 'v_');



        if($format == 'excel')
            $visitorLog = $serviceVisitorLog->visitorLogMore($filters_logs, $filters_visitors)->get();
        else{
            $visitorLog = $serviceVisitorLog->visitorLogMore($filters_logs, $filters_visitors)->paginate($this->splitPageLimit);
            $this->splitRedirect($request, $visitorLog);
        }

        $data = $canteens = [];

        foreach ($visitorLog as $item)
        {
            $canteens[  $item->canteen_id ]    = $item->canteen_id;
            $data[  $item->canteen_id ][]      = $item;
        }
        $canteens       = Canteen::WhereIn('id', $canteens)->get()->keyBy('id');

        $result = view('reports.by_dining', [
            'format'         => $format,
            'data'           => $data,
            'canteens'       => $canteens,
            'date_start'     => $filters_logs['date_start'] ?? '',
            'date_end'       => $filters_logs['date_end']   ?? ''
        ]);

        return $this->render($format, $result);
    }

    public function byCompany($format, Request $request){
         $serviceVisitorLog = new ServiceVisitorLog();
         $filters_logs     = $serviceVisitorLog->splitReq($request->all(), 'l_');
         $filters_visitors = $serviceVisitorLog->splitReq($request->all(), 'v_');



        if($format == 'excel')
            $visitorLog = $serviceVisitorLog->visitorLogMore($filters_logs, $filters_visitors)->get();
        else{
            $visitorLog = $serviceVisitorLog->visitorLogMore($filters_logs, $filters_visitors)->paginate($this->splitPageLimit);
            $this->splitRedirect($request, $visitorLog);
        }

        $data = $canteens = [];
        foreach ($visitorLog as $item)
        {
            if($item->company_id > 0){
                $company_id = $item->company_id;
            }else{
                $company_id = $item->visitor->company_id ?? 0;
            }

            $canteens[$item->canteen_id] = $item->canteen_id;
            $data[$item->canteen_id][ $company_id ][] = $item;
        }

        $canteens       = Canteen::WhereIn('id', $canteens)->get()->keyBy('id');

        $result = view('reports.by_company', [
            'format'         => $format,
            'data'           => $data,
            'canteens'       => $canteens,
            'date_start'     => $filters_logs['date_start'] ?? '',
            'date_end'       => $filters_logs['date_end']   ?? ''
        ]);

        return $this->render($format, $result);
    }

    public function byViolators($format, Request $request){
        $serviceVisitorLog = new ServiceVisitorLog();
        $filters_logs     = $serviceVisitorLog->splitReq($request->all(), 'l_');
        $filters_visitors = $serviceVisitorLog->splitReq($request->all(), 'v_');

        if($format == 'excel')
            $visitorLog = $serviceVisitorLog->visitorLogMore($filters_logs, $filters_visitors)->get();
        else{
            $visitorLog = $serviceVisitorLog->visitorLogMore($filters_logs, $filters_visitors)->paginate($this->splitPageLimit);
            $this->splitRedirect($request, $visitorLog);
        }

        $result = view('reports.by_violators', [
            'format'         => $format,
            'visitorLog'     => $visitorLog,
            'date_start'     => $filters_logs['date_start'] ?? '',
            'date_end'       => $filters_logs['date_end']   ?? ''
        ]);

        return $this->render($format, $result);

    }

    public function byRoute($format, Request $request){
        $serviceVisitorLog = new ServiceVisitorLog();
        $filters_logs     = $serviceVisitorLog->splitReq($request->all(), 'l_');
        $filters_visitors = $serviceVisitorLog->splitReq($request->all(), 'v_');


        $serviceVisitor = new ServiceVisitor();



        if($format == 'excel')
            $visitorsMore = $serviceVisitor->visitorsMore($filters_visitors, $filters_logs, true)->get();
        else{
            $visitorsMore = $serviceVisitor->visitorsMore($filters_visitors, $filters_logs, true)->paginate($this->splitPageLimit);
            $this->splitRedirect($request, $visitorsMore);
        }


        $result = view('reports.by_route', [
            'format'         => $format,
            'visitorsMore'   => $visitorsMore,
            'date_start'     => $filters_logs['date_start'] ?? '',
            'date_end'       => $filters_logs['date_end']   ?? ''
        ]);

        return $this->render($format, $result);

        //delete photo
        foreach ($visitorsMore as $item)
            $item->deleteBasePhoto();
    }


    public function userLogs($format, Request $request){
        $serviceUserLog = new ServiceUserLog();


        if($format == 'excel')
            $user_logs = $serviceUserLog->moreFilters($request->all())->get();
        else{
            $user_logs = $serviceUserLog->moreFilters($request->all())->paginate($this->splitPageLimit);
            $this->splitRedirect($request, $user_logs);
        }

        $result = view('reports.user_logs', [
            'format'         => $format,
            'user_logs'      => $user_logs,
            'date_start'     => $filters_logs['date_start'] ?? '',
            'date_end'       => $filters_logs['date_end']   ?? ''
        ]);

        return $this->render($format, $result);
    }


    public function visitors($format, Request $request){
        $serviceVisitor = new ServiceVisitor();


        if($format == 'excel')
            $visitors = $serviceVisitor->visitorsMore($request->all())->get();
        else{
            $visitors = $serviceVisitor->visitorsMore($request->all())->paginate($this->splitPageLimit);
            $this->splitRedirect($request, $visitors);
        }

        $result = view('reports.visitors', [
            'format'         => $format,
            'visitors'       => $visitors,
            'date_start'     => $filters_logs['date_start'] ?? '',
            'date_end'       => $filters_logs['date_end']   ?? ''
        ]);

       return $this->render($format, $result);
    }



    public function groupingByIpCanteenAndShowTimeNutrition($format, Request $request){
        $serviceVisitorLog = new ServiceVisitorLog();
        $filters_logs     = $serviceVisitorLog->splitReq($request->all(), 'l_');
        $filters_visitors = $serviceVisitorLog->splitReq($request->all(), 'v_');

        if($format == 'excel')
            $visitorLog = $serviceVisitorLog->visitorLogMore($filters_logs, $filters_visitors)->get();
        else{
            $visitorLog = $serviceVisitorLog->visitorLogMore($filters_logs, $filters_visitors)->paginate($this->splitPageLimit);
            $this->splitRedirect($request, $visitorLog);
        }

        $data = $arr_nutrition_time_id = [];

        foreach ($visitorLog as $item)
        {
            if($item->company_id > 0){
                $company_id = $item->company_id;
            }else{
                $company_id = $item->visitor->company_id ?? 0;
            }

            $data[ $company_id ][ $item->canteen_id ][] = $item;

            if($item->nutrition_time_id)
                $arr_nutrition_time_id[ $item->nutrition_time_id ] = $item->nutrition_time_id;
        }

        $nutrition_time = NutritionTime::WhereIn('id', $arr_nutrition_time_id)->OrderBy('start')->get()->keyBy('id');

        $result = view('reports.grouping-by-ip-canteen-and-show-time-nutrition', [
            'format'         => $format,
            'data'           => $data,
            'nutrition_time' => $nutrition_time,
            'date_start'     => $filters_logs['date_start'] ?? '',
            'date_end'       => $filters_logs['date_end']   ?? ''
        ]);

        return $this->render($format, $result);
    }
*/







    private function splitRedirect($request, $data){
            if(!$request->input('page') and $data->lastPage() > 1)
            {
                for ($i = 1; $i <= $data->lastPage(); $i++)
                {
                    $s = strpos($request->fullUrl(), '?') !== false ? '&' : '?';
                    $fullURL = $request->fullUrl() . $s . 'page=' . $i;

                    echo <<<HTML
                      <script>
                            window.open('$fullURL', '_blank');
                            setTimeout(function () {
                                window.close(); 
                            }.bind(this), 1000);
                      </script>
HTML;
                }
                exit();
            }
    }


    private function render($format, $result, $title){
        if($format == 'excel')
        {
            header("Content-Type: application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=$title.xls");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);
            return $result;
        }else{
            $mpdf = new Mpdf(['orientation' => 'L']);
            $mpdf->WriteHTML($result);
            $mpdf->Output();
        }
    }



}