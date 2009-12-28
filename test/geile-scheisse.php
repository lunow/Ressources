<?php 
/**
 * Das ist vielleicht ne geile Scheiße!!!
 *
 * <b>Yeahhaa!</b> 
 */
  class Test {
    private $a = '';
    
    /**
     * Setzt die Variable $a auf den übergebenen Wert.
     * @param Mixed
     */
    function __construct($a) {
       $this->a = $a;
    }
    
    /**
     * Gibt die Variable a zurück
     */
    function __toString() {
       return $this->a;
    }
  }
  
?>
