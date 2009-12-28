<?php
  require_once('../../_res/simpletest/autorun.php');
  require_once('../geile-scheisse.php');
  
  /**
   * Neuer Testcode
   *
   * Diese Klasse beinhaltet alle Tests zu diesem Projekt.
   */
  class TestOfSomething extends UnitTestCase {
    function testConstructor() {
       $test = new Test('p');
       $this->assertEqual($test->__toString(), 'p');
    }
  }

?>