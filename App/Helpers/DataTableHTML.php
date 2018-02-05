<?php

namespace App\Helpers;

use Silver\Http\Request;

/**
 * datatablehtml Helper
 */
class DataTableHTML {
    
    public function orderBy(Request $request, $model, $allClosure = NULL) {
        if ($column = $request->param('order_by', FALSE)) {
            $sort = $request->param('sort', 'desc');
            
            return function($limit, $offset) use ($model, $column, $sort, $allClosure) {
                return $model::query()
                             ->orderBy($column, $sort)
                             ->limit($limit)
                             ->offset($offset)
                             ->all(NULL, $allClosure);
            };
        };
        
        return NULL;
    }
    
}
