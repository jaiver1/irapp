<?php 

namespace App\Classes\Store;

use App\Models\Clasificacion\Categoria;

class Filter
{
    public $min;
    public $max;
    public $limit;
    public $query;
    public $order;
    public $category;
    
    public function __construct()
    {
       $this->min = null;
       $this->max = null;
       $this->limit = null;
       $this->query = '';
       $this->order = 'lastest';
       $this->category = new Categoria;
    }

}
