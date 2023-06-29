<?php

class Pagination
{
    private $data;
    private $itemsPerPage;
    private $chunks;
    private $numLinksDisplayed;

    public function __construct($data, $itemsPerPage, $numLinksDisplayed = 5)
    {
        $this->data = $data;
        $this->itemsPerPage = $itemsPerPage;
        $this->numLinksDisplayed = $numLinksDisplayed;
        $this->chunks = $this->calculateChunks();
    }

    private function calculateChunks()
    {
        return array_chunk($this->data, $this->itemsPerPage);
    }

    public function getCurrentPage()
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

        if ($currentPage < 1 || $currentPage > count($this->chunks)) {
            $currentPage = 1;
        }
        return $currentPage;
    }

    public function GetCurrentKey(){
        return (($_GET['nb']) ? $_GET['nb']:0);
    }

    public function GetCurrentElement(){
        return $this->chunks[$this->getCurrentPage() - 1][$this->GetCurrentKey()];
    }

    public function GetCurrentChunk(){
       return $this->chunks[$this->getCurrentPage() - 1];
    }

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
}

?>
