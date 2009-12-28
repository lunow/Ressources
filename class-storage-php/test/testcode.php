<?php
  require_once('../../_res/simpletest/autorun.php');
  require_once('../class.storage.php');
  
  // Neuer Testcode
  class TestOfSomething extends UnitTestCase {
    function testSomething() {
      $this->assertEqual('a', 'a');
    }
  }

?>