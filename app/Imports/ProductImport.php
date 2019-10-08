<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Product([
            'name'          => $row[0],
            'code'          => $row[1],
            'alias'         => $row[2],
            'price'         => (int)$row[3],
            'price_sale'    => (int)$row[4],
            'sup_id'        => (int)$row[5],
            'bra_id'        => (int)$row[6],
            'att_gr_id'     => (int)$row[7],
            'warranty'      => (int)$row[8],
        ]);
    }
}
