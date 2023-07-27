<?php

require_once './class/autoloader.php';

/**
 * HprimFactory
 * On assemble les classes métiers pour garder leur indépendance ( injection de dépendance )
 * 
 */
class HprimFactory{

    /* Injection de dépendance */
    protected $_files = NULL; 
    protected $_pagination = NULL;
    protected $_maphprim = NULL;

    /* Variables in use*/
    protected $_debug = FALSE;
    
    /**
     * Method __construct
     *
     * @return void
     */
    function __construct()
    {
        
        /* PARSE FILE */
        $this->_files       = new filemanip('./datas/messages/'); //Objet fichier 
        $this->_pagination  = new Pagination($this->_files->_get('ListFiles'), 10, 4); //Objet pagination
        $this->_map         = new MapProtocol(); //Objet parsing HPRIM

        $this->_files->_set('_debug',       $this->_debug);
        $this->_pagination->_set('_debug',  $this->_debug);
        $this->_map->_set('_debug',    $this->_debug);

        /* Utilisation des classes : processus */
        $this->_files->ParseFile( $this->GetFileInProgess() ); //on parse le fichier en cours, dépend de la pagination : page : xx et numéro de fichier yy
        $this->_map->_set('lgnFileParsed', $this->_files->_get('_parsed'));
        $this->_map->process();
    }
    
    /**
     * Method GetParsed
     *
     * @return array()
     */
    function GetParsed(){
        return $this->_map->_get('processed');
    }
    
    /**
     * Method GetFileInProgess
     *
     * @return void
     */
    function GetFileInProgess(){
        return $this->_pagination->GetCurrentElement();
    }
    
    /**
     * Method showPagination
     *
     * @return void
     */
    function showPagination(){
        return $this->_pagination->showPagination();
    }
    
    /**
     * Method showPageItems
     *
     * @return void
     */
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
     * @param $obj [explicite description]
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