<?php

namespace App\Helpers;

use Silver\Database\Query;
use Silver\Http\Request;

/**
 * datatablehtml Helper
 */
class DataTableHTML {
    
    private $orderByColumnName;
    
    private $searchValue;
    
    public function count(Request $request, $model) {
        $query = Query::count()
                      ->from($model::tableName());
        
        if ($this->anyFilter($request)) {
            $query = $this->search($request, $query);
        }
        
        return $query->single();
    }
    
    /**
     * @param Request $request
     *
     * @return bool
     */
    private function anyFilter(Request $request) {
        $this->orderByColumnName = $request->param('order_by', FALSE);
        $this->searchValue       = $request->param('search-data-value', FALSE);
        
        return $this->orderByColumnName || $this->searchValue;
    }
    
    private function search(Request $request, $query) {
        if ($this->searchValue && strlen($this->searchValue) > 1) {
            $dataColumnName = $request->param('search-data-column', FALSE);
            
            return $query->where($dataColumnName, 'LIKE', sprintf('%1$s%2$s%1$s', '%', $this->searchValue));
        }
        
        return $query;
    }
    
    private function orderBy(Request $request, $query) {
        if ($this->orderByColumnName) {
            
            $sort = $request->param('sort', 'desc');
            
            return $query->orderBy($this->orderByColumnName, $sort);
        }
        
        return $query;
    }
    
    public function filter(Request $request, $model, $allClosure = NULL) {
        if ($this->anyFilter($request)) {
            return function($limit, $offset) use ($request, $model, $allClosure) {
                $query = $model::query();
                $query = $this->search($request, $query);
                $query = $this->orderBy($request, $query);
                
                return $query->limit($limit)
                             ->offset($offset)
                             ->all(NULL, $allClosure);
            };
        }
        
        return NULL;
    }
    
}
