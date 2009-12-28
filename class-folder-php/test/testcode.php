<?php
  require_once('../../_res/simpletest/autorun.php');
  require_once('../class.folder.php');
  
  // Neuer Testcode
  class TestOfFolder extends UnitTestCase {
    function testNormalize() {
      $this->assertEqual('test/', Folder::normalize('test'));
      $this->assertEqual('test/', Folder::normalize('test/'));
    }
    function testFoldername() {
      $folder = new Folder('/');
      $folder->files[0] = 'test/pfad/name';
      $this->assertEqual($folder->name(), 'name');
    }
    
    function testFilename() {
      $folder = new Folder('/');
      $folder->files[0] = 'test/pfad/name.txt';
      $this->assertEqual($folder->name(), 'name.txt');
    }
  }

?>