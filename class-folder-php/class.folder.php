<?php
  
  /**
   *  @title Class Folder
   *  @version 1.0
   *  @description Ließt Ordner aus und gibt die Inhalte zurück
   *
   */
  
  
  class Folder implements Iterator {
    var $folder = '';
    var $path = '';
    var $files = '';
    var $current = 0;
    var $glob_flag = NULL;
    
    /**
     *  Initialisiert die Klasse
     *
     *
     *  @param String Pfad zum zu durchenden Ordner
     *  @param String (optional) Muster der zu suchenden Dateien. Wenn gesetzt wird sofort die Suche ausgelöst.
     */
    function __construct($path, $pattern = '') {
      $this->path = Folder::normalize($path);
      if(!empty($pattern)) {
        $this->search($pattern);
      }
    }
    
    /**
     *  Nach Aufruf gibt die Klasse nur noch Ordner zurück
     */
    function onlyDir() {
      $this->glob_flag = GLOB_ONLYDIR;
    }
    
    /**
     *  Führt im Ordner aus.
     *  @param String Muster der zu suchendenen Dateien. Default: *.*
     *  @return Array Alle gefundenen Einträge
     */
    function search($pattern = '*.*') {
      $this->files = glob($this->path.$pattern, $this->glob_flag);
      return $this->getFiles();
    }
    
    /**
     *  Gibt eine Datei aus den gefundenen zurück
     *  @param Int Index der Datei
     *  @return String Name und Pfad der Datei
     */
    function get($i) {
      return $this->files[$i];
    }
    
    /**
     *  Gibt alle gefundenen Dateien zurück
     *  @return Array
     */
    function getFiles() {
      return $this->files;
    }
    
    /**
     *  Gibt den Namen der Datei oder des Ordners zurück, der aktuelle Datei
     *  @return String
     */
    function name() {
      $parts = explode('/', $this->files[$this->current]);
      return trim(array_pop($parts));
    }
    
    /**
     *  Anzahl der gefundenen Einträge
     *  @return Int
     */
    function count() {
      return count($this->files);
    }
    
    /**
     *  Stellt sicher das ein / am Ende des übergebenen Pfads steht.
     *  @param String Pfad
     *  @return String Pfad aufjedenfall mit einem Slash am Ende
     */
    static function normalize($path) {
      $l = substr($path, -1);
      return $l == '/' ? $path : $path.'/';
    }
    
    /**
     *  Liefert das aktuell genutzte Element zurück
     *  @return String
     */
    function current() {
      return $this->files[$this->current];
    }
    
    /**
     *  Gibt den Index des aktuell genutzten Elements zurück
     *  @return Int
     */
    function key() {
      return key($this->files);
    }
    
    /**
     *  Rückt den internen Zeiger um eins nach vorne
     */
    function next() {
      next($this->files);
      $this->current++;
    }
    
    /**
     *  Setzt den internen Zeiger zurück
     */
    function rewind() {
      reset($this->files);
      $this->current = 0;
    }
    
    /**
     *  Prüft ob der interne Zeiger noch auf ein Element zeigt
     *  @return Boolean
     */
    function valid() {
      return $this->current < $this->count($this->files);
    }
  }

?>