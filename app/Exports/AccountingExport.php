<?php

namespace App\Exports;

use App\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use auth;
use Session;

class AccountingExport implements FromView,ShouldAutoSize,WithEvents
{
	use RegistersEventListeners;
	public $data;
	public function __construct( $data )
	{

	    $this->data = $data;
	}
    /**
    * @return \Illuminate\Support\Collection
    */
   	public function view(): View
    {
        return view('reports.export', $this->data);
    }


    public static function afterSheet(AfterSheet $event)
    {
        // Add styling here
        $sheet = $event->sheet->getDelegate();
        // $cellRange = 'A3:Y3'; // All headers
        // $sheet->getStyle($cellRange)->getFont()->setSize(15);
        // $sheet->getStyle($cellRange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('808080');
        // $sheet->getStyle($cellRange)->getFont()->getColor()->setARGB('FFFFFF');
        if((isset(auth::user()->practices->first()->id) && !auth::user()->hasRole('practice_super_group')) || Session::has('practice'))
        {
           $sheet->getRowDimension('10')->setRowHeight(30); 
       }else{
            $sheet->getRowDimension('3')->setRowHeight(30);
       }
        
        $sheet->getStyle('E1')->getFont()->setSize(20);
        $sheet->getStyle('E1')->getFont()->getColor()->setARGB('FF0000');
        $sheet->getStyle('E1')->getFont()->setBold(true);
        // $sheet->getStyle('F4:F300')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        // $sheet->getStyle('G4:G300')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        // $sheet->getStyle('H4:H300')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        // $sheet->getStyle('I4:I300')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        // $sheet->getStyle('J4:J300')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        // $sheet->getStyle('K4:K300')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getRowDimension('1')->setRowHeight(50);

        // $sheet->row(6, function($row) { $row->setBackground('#CCCCCC'); });
    }
    // public function registerEvents(): array
    // {
    	
    //     return [
    //         AfterSheet::class    => function(AfterSheet $event) {
    //             $cellRange = 'A3:K3'; // All headers
    //             $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(15);
    //             $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('808080');
    //             $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->getColor()->setARGB('FFFFFF');
    //             $event->sheet->getDelegate()->getStyle('E1')->getFont()->setSize(20);
    //             $event->sheet->getDelegate()->getStyle('E1')->getFont()->getColor()->setARGB('FF0000');
    //             $event->sheet->getDelegate()->getStyle('F4:F300')->getFont()->getColor()->setARGB('FF0000');
    //             // $event->sheet->getDelegate()->getColumnDimension('D');

                
    //         },
    //     ];
    // }
}
