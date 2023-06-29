<?php

require_once('./class/filemanip.class.php');
require_once('./class/MapHprim.class.php');
require_once('./class/Pagination.class.php');

class HprimFactory{

    /* Injection de dépendance */
    protected $_files = NULL; 
    protected $_pagination = NULL;
    protected $_maphprim = NULL;

    /* Variables in use*/
    protected $_debug = FALSE;
    protected $processed = [];
    protected $pageinprogress = 0;
    protected $PagListFiles = [];
    protected $fileparsedinprogress = [];

    function __construct()
    {
        
        /* PARSE FILE */
        $this->_files = new filemanip('./datas/messages/'); //Objet 
        $this->_pagination = new Pagination($this->_files->_get('ListFiles'), 10, 4); //Objet pagination
        $this->_maphprim = new MapHprim();

        /* Utilisation des classes */
        $this->_files->ParseFile( $this->GetFileInProgess() );
        $this->fileparsedinprogress = $this->_files->_get('_parsed');
        foreach($this->fileparsedinprogress AS $key=>$lgn){
            $this->processed[$key] = $this->_maphprim->Process($lgn);
        }
    }

    function GetFileInProgess(){
        return $this->_pagination->GetCurrentElement();
    }

    function showPagination(){
       
        return $this->_pagination->showPagination();
    }

    function showPageItems(){

        foreach($this->_pagination->GetCurrentChunk() AS $key=>$file){
            echo '<div class="list-group list-group-flush border-bottom scrollarea">';
            echo '<a class="list-group-item list-group-item-action lh-tight '.(($this->_pagination->GetCurrentKey() == $key) ? 'active':'').'" aria-current="page" href="index.php?nb='.$key.'&page='.$this->_pagination->getCurrentPage().'">
                    <div class="d-flex w-100 align-items-center justify-content-between">
                        <strong class="mb-1">'.$file.'</strong>
                        <small>'.$this->_files->GetSize($file).'</small>
                    </div></a>';
            echo '</div>';
        }

    }
       
	 /**
     * Method __destruct
     *
     * @return void
     */
    function __destruct()
    {
        if ($this->_debug)
            $this->_debug($this);
    }
    
    /**
     * Method _debug
     *
     * @param $obj $obj [explicite description]
     *
     * @return void
     */
    private function _debug($obj){
        echo '<pre>'.print_r($obj, 'TRUE').'</pre>';
    }


    /**
	 * @brief Generic SETTER
	 * @param $field 
	 * @param $value 
	 * @returns 
	 * 
	 * 
	 */
	public function _set($field,$value){
		$this->$field = $value;
	}

	/**
	 * @brief Generic GETTER
	 * @param $field 
	 * @returns 
	 * 
	 * 
	 */
	public function _get($field){
		return $this->$field;
	}
}