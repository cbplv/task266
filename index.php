<?php
class myIterator implements Iterator {
    private $position = 0;
    protected $filePointer = null;
    protected $rowCounter = null;
    protected $currentElement = null;

    public function __construct($file) {
        try {
            $this->filePointer = fopen($file, 'rb');
        }
        catch (\Exception $e) {
            throw new \Exception('The file "' . $file . '" cannot be read.');
        }        
    }

    public function rewind(): void {
        $this->rowCounter = 0;
    }

    public function current(): mixed {

        $this->currentElement = fgets($this->filePointer);
        $this->rowCounter++;
        return $this->currentElement;
    }

    public function key():mixed {
        return $this->rowCounter;
    }

    public function next() {
        if (is_resource($this->filePointer)) {
            return !feof($this->filePointer);
        }

        return false;
    }

    public function valid(): bool {
        if (!$this->next()) {
            if (is_resource($this->filePointer)) {
                fclose($this->filePointer);
            }
            return false;
        }
        return true;
    }
}

function strposa($haystack, $needles=array(), $offset=0) {
    $chr = array();
    foreach($needles as $needle) {
            $res = strpos($haystack, $needle, $offset);
            if ($res !== false) $chr[$needle] = $res;
    }
    if(empty($chr)) return false;
    return min($chr);
}

$csv = new myIterator(__DIR__ . '/src.html');
$arr  = array('title>', 'description', 'keywords');

foreach ($csv as $key => $row) {
     if (!strposa($row, $arr, 1)){
        print_r($row);
    }
}