<?php
  /**
   *  Speichert Informationen in Dateien
   *  Version 0.2
   *  - statische Funktionen
   */
  class Storage {
    private $filename = 'db.json';
    private $data = array();
    private $count = 0;
    
    function __construct($file = '') {
      if(!empty($file)) {
        $this->filename = $file;
      }
      $this->readData();
      $this->init();
    }
    
    private function init() {
      $this->count = count($this->data);
      $this->test();
    }
    
    public function test() {
      if(!is_writable($this->filename)) {
        die('<div style="border:2px solid red; padding:5px;">Datei <i>'.$this->filename.'</i> ist nicht beschreibbar.');
      }
    }
    
    public function latest($num = 1) {
      reset($this->data);
      if($num == 1) {
        return (array)end($this->data);
      }
      if($num > $this->count) {
        $min = 0;
      }
      else {
        $min = $this->count - $min;
      }
      $max = $this->count;
      return $this->sub($min, $max);
    }
    
    public function sub($min, $max) {
      $r = array();
      for($i = $min; $i < $max; $i++) {
        $key = key($this->data[$i]);
        $value = $this->get($i);
        $r[$key] = (array)$value[$key];
      }
      return $r;
    }
    
    public function get($i) {
      return (array)$this->data[$i];
    }
    
    public function overwrite($rows) {
      $this->data = array();
      foreach($rows as $key => $row) {
        $this->data[] = array($key => $row);
      }
    }
    
    public function save() {
      $content = '';
      foreach($this->data as $row) {
        $content.= json_encode($row)."\n";
      }
      return file_put_contents($this->filename, $content);
    }
    
    private function readData() {
      $lines = file($this->filename);
      if(count($lines) > 0) {
        foreach($lines as $line) {
          $this->addData($line);
        }
      }
    }
    
    private function addData($content) {
      $obj = json_decode($content);
      array_push($this->data, $obj);
    }
    
    //Abstrakte Funktionen um Informationen nur in einer Datei zu speichern
    static function file($path) {
      if(is_file($path)) {
        return file_get_contents($path);
      }
      return '';
    }
  }

?>