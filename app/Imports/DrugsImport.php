<?php

namespace App\Imports;

use App\Drug;
use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DrugsImport implements ToModel, WithStartRow,WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Drug([
            'sponsored_product'=>$row['0'],
            'sponsor_source'=>$row['1'],
            'sponsor_item'=>$row['2'],
            'order_web_link'=>$row['3'],
            'gcn_seq'=>$row['4'],
            'ndc'=>$row['5'],
            'upc'=>$row['6'],
            'rx_label_name'=>$row['7'],
            'strength'=>$row['8'],
            'dosage_form'=>$row['9'],
            'unit_price'=>$row['10'],
            'default_rx_qty'=>$row['11'],
            
        ]);
    }
    // public function headingRow(): int
    // {
    //     return 1;
    // }
    public function startRow(): int
    {
        return 2;
    }
    public function rules(): array
    {
        return [
            '5' => 'required|max:13|unique:drugs_new,ndc',
            '7'=>'required',
            '8'=>'required|max:15',
            '9'=>'required',
            // '10'=>'required|numeric|between:0,99.9999',
            '10'=>'required|max:7',
            '11'=>'required|numeric|digits_between:1,6'
        ];
    }
    public function customValidationMessages()
	{
	    return [
	        // '5.required' => 'NDC is required',
	        // '7.required' => 'Rx Label name is required',
         //    '8.required' => 'Rx Label name is required',
         //    '9.required' => 'Strength is required',
            '10.max' => 'Ing Cost may not be greater than 6 digits',
            // '11.required' => 'Rx Quantity is required'
	    ];
	}
	public function customValidationAttributes()
	{
	    return ['5' => 'NDC number','7'=>'Rx Label Name','8'=>'Strength','9'=>'Dosage Form',
        '10'=>'Ing Cost','11'=>'Rx Quantity'];
	}

}
