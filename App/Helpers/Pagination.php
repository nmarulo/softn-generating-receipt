<?php
/**
 * Pagination.php
 */

namespace App\Helpers;

use App\Models\Settings;
use Silver\Database\Query;
use Silver\Http\Request;
use Silver\Http\View;

/**
 * Class Pagination
 * @author Nicolás Marulanda P.
 */
class Pagination {
    
    /** @var array */
    private $pages;
    
    /** @var Page */
    private $leftArrow;
    
    /** @var Page */
    private $rightArrow;
    
    /** @var int */
    private $currentPageValue;
    
    /** @var int */
    private $totalData;
    
    /** @var int */
    private $numberRowShow;
    
    /** @var int */
    private $maxNumberPagesShow;
    
    /** @var int */
    private $totalNumberPages;
    
    /** @var bool */
    private $rendered;
    
    /** @var int */
    private $beginRow;
    
    /** @var string */
    private $route;
    
    public function viewMake(Request $request, $currentModel, $nameModel, $template, $route, $dataModelClosure = NULL) {
        $currentPage = 1;
        
        if ($request->ajax()) {
            $currentPage = $request->input('page', 1);
        }
        
        if(is_callable($currentModel)){
            $totalData = $currentModel();
        }else{
            $totalData = Query::count()
                              ->from($currentModel::tableName())
                              ->single();
        }
        
        $this->instance($route, $currentPage, $totalData);
        
        if ($dataModelClosure == NULL || !is_callable($dataModelClosure)) {
            $dataModel = $currentModel::query()
                                      ->orderBy('id', 'desc')
                                      ->limit($this->numberRowShow)
                                      ->offset($this->beginRow)
                                      ->all();
        } else {
            $dataModel = $dataModelClosure($this->numberRowShow, $this->beginRow);
        }
        
        return View::make($template)
                   ->with($nameModel, $dataModel)
                   ->withComponent($this, 'pagination');
    }
    
    public function instance($route, $currentPageValue, $totalData, $maxNumberPagesShow = 3) {
        $this->currentPageValue   = $currentPageValue;
        $this->totalData          = $totalData;
        $this->maxNumberPagesShow = $maxNumberPagesShow;
        $this->pages              = [];
        $this->totalNumberPages   = 0;
        $this->rendered           = FALSE;
        $this->beginRow           = 0;
        $this->route              = $route;
        $this->setNumberRowShow(Settings::where('option_key', '=', 'setting_pagination_number_row_show')
                                        ->first()->option_value);
        $this->init();
        
        return $this;
    }
    
    /**
     * @param int $numberRowShow
     */
    private function setNumberRowShow($numberRowShow) {
        if ($numberRowShow <= 0) {
            $numberRowShow = 1;
        }
        
        $this->numberRowShow = $numberRowShow;
    }
    
    private function init() {
        //Se comprueba que sea mayor que 0 para evitar error en la operaciones.
        if ($this->totalData > 0) {
            /*
             * Comprueba que el número de datos a mostrar por pagina
             * no sea mayor al total de filas a mostrar, para obtener
             * el numero correcto de filas a mostrar.
             */
            if ($this->numberRowShow > $this->totalData) {
                $this->numberRowShow = $this->totalData;
            }
            
            $this->totalNumberPages = ceil($this->totalData / $this->numberRowShow);
            
            //Se podrá mostrar la paginación si hay mas de una pagina.
            if ($this->totalNumberPages > 1) {
                $this->rendered = TRUE;
                
                //Se comprueba el valor de la pagina actual no es valida.
                if (empty($this->currentPageValue) || intval($this->currentPageValue) <= 0) {
                    $this->currentPageValue = 1;
                }
                
                //Se comprueba si la pagina actual es mayor al numero total de paginas
                if ($this->currentPageValue > $this->totalNumberPages) {
                    $this->currentPageValue = $this->totalNumberPages;
                }
                
                //Se establece la posición de inicio de la fila.
                $this->beginRow = ($this->numberRowShow * $this->currentPageValue) - $this->numberRowShow;
                
                $this->initPages();
            }
        }
    }
    
    private function initPages() {
        /*
         * Para evitar los casos donde el total de paginas es demasiado grande
         * se establece un maximo de paginas a mostrar ($maxNumberPagesShow)
         */
        
        $startPageNumber = $this->currentPageValue - $this->maxNumberPagesShow;
        $endPageNumber   = $this->currentPageValue + $this->maxNumberPagesShow;
        
        if ($startPageNumber <= 0) {
            /*
             * Cuando la pagina inicial es menor que 0,
             * obtengo su valor positivo y le sumo 1
             * y se le suma el numero de la pagina final,
             * con esto se mostrara siempre el mismo numero de paginas.
             */
            $endPageNumber += (abs($startPageNumber) + 1);
            
            if ($endPageNumber > $this->totalNumberPages) {
                $endPageNumber = $this->totalNumberPages;
            }
            
            $startPageNumber = 1;
        } else {
            if ($endPageNumber > $this->totalNumberPages) {
                /*
                 * Al igual que en la comprobación del numero de la pagina inicial,
                 * para mostrar siempre el mismo numero de paginas,
                 * obtengo el numero de paginas que exceden el total de paginas
                 * y se lo resto al numero de la pagina inicial.
                 */
                $startPageNumber -= ($endPageNumber - $this->totalNumberPages);
                
                if ($startPageNumber <= 0) {
                    $startPageNumber = 1;
                }
                
                $endPageNumber = $this->totalNumberPages;
            }
        }
        
        $this->setPages($startPageNumber, $endPageNumber);
        $this->initArrows();
    }
    
    private function setPages($startPageNumber, $endPageNumber) {
        for ($i = $startPageNumber; $i <= $endPageNumber; ++$i) {
            $styleClass = '';
            $attrData   = [
                'url'  => $this->route,
                'page' => $i,
            ];
            
            if ($this->currentPageValue == $i) {
                $styleClass = 'active';
                unset($attrData['page']);
            }
            
            $this->pages[] = new Page($i, $styleClass, $attrData);
        }
    }
    
    private function initArrows() {
        $styleClass = "disabled";
        $attrData   = ['url' => $this->route];
        $this->setLeftArrow($styleClass, $attrData);
        $this->setRightArrow($styleClass, $attrData);
    }
    
    private function setLeftArrow($styleClass, $attrData) {
        if ($this->currentPageValue > 1) {
            $styleClass       = "";
            $attrData['page'] = $this->currentPageValue - 1;
        }
        
        $this->leftArrow = new Page('&laquo;', $styleClass, $attrData);
    }
    
    private function setRightArrow($styleClass, $attrData) {
        if ($this->currentPageValue < $this->totalNumberPages) {
            $styleClass       = "";
            $attrData['page'] = $this->currentPageValue + 1;
        }
        
        $this->rightArrow = new Page('&raquo;', $styleClass, $attrData);
    }
    
    /**
     * @return mixed
     */
    public function getBeginRow() {
        return $this->beginRow;
    }
    
    /**
     * @return array
     */
    public function getPages() {
        return $this->pages;
    }
    
    /**
     * @return Page
     */
    public function getLeftArrow() {
        return $this->leftArrow;
    }
    
    /**
     * @return Page
     */
    public function getRightArrow() {
        return $this->rightArrow;
    }
    
    /**
     * @return bool
     */
    public function isRendered() {
        return $this->rendered;
    }
    
}
