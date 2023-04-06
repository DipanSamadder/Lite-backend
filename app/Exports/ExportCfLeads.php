<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\ContactForm;

class ExportCfLeads implements FromCollection, WithMapping
{
    protected $id;

    function __construct($id) {
            $this->id = $id;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ContactForm::select('*')->where('form_id', $this->id)->get();
    }

  

    public function map($ContactForm): array
    {
        $data[] = '';

        foreach(json_decode($ContactForm->meta_value, true) as $key => $value){
            foreach($value as $key => $val){
                    $fill = ucfirst(str_replace('_', ' ', $key)).' :- '.$val; 
                    array_push($data, $fill);
            }
        }
        return $data;
    }
}
