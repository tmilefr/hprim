<?php

class filemanip{

    protected $_file = '';
    protected $_datas = [];
    protected $_parsed = [];
    protected $_debug = FALSE;
    protected $_working_dir = '';
    protected $ListFiles = [];
    
    /**
     * Method __construct
     *
     * @param $_working_dir $_working_dir [explicite description]
     *
     * @return void
     */
    function __construct($_working_dir = './')
    {
        $this->_working_dir = $_working_dir;
        $this->_SetListFiles();
    }
    
    /**
     * Method ParseFile
     *
     * @param $file $file [explicite description]
     *
     * @return void
     */
    function ParseFile($file){
        if ( $this->_file =  $this->_working_dir.$file) {
            $this->_get_content();
            $this->_parse_content();
        }
    }
    
    /**
     * Method _SetListFiles
     *
     * @return void
     */
    private function _SetListFiles(){
        $this->ListFiles = array_diff(scandir($this->_working_dir) , array('..', '.'));
    }

   /**
     * Method _get_content
     *
     * @return void
     */
    private function _get_content(){
        try {
            $this->_datas = file($this->_file);
        } catch (Exception $e) {
            echo 'Exception reçue : ',  $e->getMessage(), "\n";
        }
    }
    
    /**
     * Method GetSize
     *
     * @param $file $file [explicite description]
     *
     * @return void
     */
    public function GetSize($file){
        $size = filesize($this->_working_dir.$file);
        return $this->human_filesize($size);
    }
    
    /**
     * Method _parse_content
     *
     * @param $sep $sep [explicite description]
     *
     * @return void
     */
    private function _parse_content($sep = '|'){
        try {
            foreach($this->_datas AS $key=>$data){
                $res = explode($sep , $data);
                $this->_parsed[] = $res;
            }
        } catch (Exception $e) {
            echo 'Exception reçue : ',  $e->getMessage(), "\n";
        }
    }
    
    /**
     * Method human_filesize
     *
     * @param $bytes $bytes [explicite description]
     * @param $decimals $decimals [explicite description]
     *
     * @return void
     */
    function human_filesize($bytes = 0, $decimals = 2) {
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
      }

	 /**
     * Method __destruct
     *
     * @return void
     */
    function __destruct()
    {
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
        if ($this->_debug)
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
