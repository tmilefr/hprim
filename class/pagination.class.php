<?php

class Pagination
{
    protected $data   = [];
    protected $itemsPerPage = 20;
    protected $chunks = [];
    protected $numLinksDisplayed = 5;
    protected $_debug;
    
    /**
     * Method __construct
     *
     * @param $data $data [explicite description]
     * @param $itemsPerPage $itemsPerPage [explicite description]
     * @param $numLinksDisplayed $numLinksDisplayed [explicite description]
     *
     * @return void
     */
    public function __construct($data = [], $itemsPerPage = 20, $numLinksDisplayed = 5)
    {
        $this->data = $data;
        $this->itemsPerPage = $itemsPerPage;
        $this->numLinksDisplayed = $numLinksDisplayed;
        $this->chunks = $this->calculateChunks();
    }
    
    /**
     * Method calculateChunks
     *
     * @return array 
     */
    private function calculateChunks()
    {
        return array_chunk($this->data, $this->itemsPerPage);
    }
    
    /**
     * Method getCurrentPage
     *
     * @return integer $currentPage
     */
    public function getCurrentPage()
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

        if ($currentPage < 1 || $currentPage > count($this->chunks)) {
            $currentPage = 1;
        }
        return $currentPage;
    }
    
    /**
     * Method GetCurrentKey
     *
     * @return void
     */
    public function GetCurrentKey(){
        return ((isset($_GET['nb'])) ? $_GET['nb']:0);
    }
    
    /**
     * Method GetCurrentElement
     *
     * @return void
     */
    public function GetCurrentElement(){
        return $this->chunks[$this->getCurrentPage() - 1][$this->GetCurrentKey()];
    }
    
    /**
     * Method GetCurrentChunk
     *
     * @return array()
     */
    public function GetCurrentChunk(){
       return $this->chunks[$this->getCurrentPage() - 1];
    }
    
    /**
     * Method showPageItems
     *
     * @return void
     */
    public function showPageItems()
    {
        $currentPage = $this->getCurrentPage();
        $currentChunk = $this->GetCurrentChunk();
        // Display the items with Bootstrap styling
        echo '<ul class="list-group">';
        foreach ($currentChunk as $key=>$item) {
            echo '<li class="list-group-item"><a href="index.php?nb='.$key.'&page='.$currentPage.'">' . $item . '</a></li>';
        }
        echo '</ul>';
    }
    
    /**
     * Method showPagination
     *
     * @return void
     */
    public function showPagination()
    {
        $currentPage = $this->getCurrentPage();

        echo '<nav aria-label="Pagination">';
        echo '<ul class="pagination">';

        // Display the "Previous" link
        if ($currentPage > 1) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage - 1) . '"><<</a></li>';
        }

        // Display the pagination links
        $start = max(1, $currentPage - floor($this->numLinksDisplayed / 2));
        $end = min($start + $this->numLinksDisplayed - 1, count($this->chunks));

        foreach (range($start, $end) as $i) {
            echo '<li class="page-item '.(($i == $currentPage) ? 'active':'').'"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }

        // Display the "Next" link
        if ($currentPage < count($this->chunks)) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage + 1) . '">>></a></li>';
        }

        echo '</ul>';
        echo '</nav>';
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

?>
