<?php
namespace chx2;
use Symfony\Component\Yaml\Yaml;
/*
  Easy Docs by Chris H.

  DocMaker Class
  Used to do CRUD stuff with markdown documents
*/
class DocMaker {

  public $list;

  public $docname;
  public $old_section;
  public $old_name;
  public $section;
  public $content;

  //Setup content handling, map POST,GET or existing local data to class
  public function __construct($list) {

    $this->list = $list;

    //Escape & map data. Try GET befor switching to POST data
    $data               = ($_GET) ? array_map('htmlspecialchars',$_GET) : $_POST;
    $this->old_section  = (isset($data['old-section'])) ? $data['old-section']: null;
    $this->old_name     = (isset($data['old-name'])) ? $data['old-name']: null;
    $this->section      = (isset($data['section'])) ? $data['section']: null;
    $this->docname      = (isset($data['docname'])) ? $data['docname']: null;
    if (isset($data['content']) || (!$this->getContent())) {
      $this->content    = (isset($data['content'])) ? $data['content']: null;
    }

  }

  //Handling just the section
  public function isSection() {
    return ($this->section && !$this->docname);
  }

  //New section
  public function addSection() {
    if (!is_dir(DOC_URI . $this->section)) {
      try {
        mkdir(DOC_URI . $this->section);
      } catch(Exception $e) {
        $_SESSION['error'] = 'Could not create local folder. Check file permissions';
        return false;
      }
    }
    //Dummy first entry
    if (glob(DOC_URI . $this->section . '/*')) {
      $_SESSION['error'] = 'Section already exists';
    }
    else {
      $this->docname = 'Example';
      try {
        $file = fopen(DOC_URI . $this->section . '/' . $this->docname . '.md', 'w');
        fclose($file);
      } catch (Exception $e) {
        $_SESSION['error'] = 'Could not create local file. Check file permissions';
        return false;
      }
      $this->list['pages'][$this->section][] = $this->docname;
      $_SESSION['success'] = 'You have successfully added a new section!';
    }
    $yaml = Yaml::dump($this->list);
    file_put_contents(CONFIG_URI, $yaml);
    header('Location: dashboard');
  }

  //Check if document exists
  public function getContent() {
    if (file_exists(DOC_URI . $this->section . '/' . $this->docname . '.md')) {
      $this->content = file_get_contents(DOC_URI . $this->section . '/' . $this->docname . '.md');
      return true;
    }
    else {
      return false;
    }
  }

  //Remove single document or entire section
  public function deleteContent() {
    //Entire section
    if ($this->docname === 'no-name') {
      foreach(glob(DOC_URI . $this->section . '/*') as $file) {
        unlink($file);
      }
      rmdir(DOC_URI . $this->section);
      unset($this->list['pages'][$this->section]);
    }
    else {
      if (file_exists(DOC_URI . $this->section . '/' . $this->docname . '.md')) {
        unlink(DOC_URI . $this->section . '/' . $this->docname . '.md');
        unset($this->list['pages'][$this->section][array_search($this->docname, $this->list['pages'][$this->section])]);
      }
    }
    $yaml = Yaml::dump($this->list);
    file_put_contents(CONFIG_URI, $yaml);
  }

  //Update document
  public function putContent() {
    if (file_exists(DOC_URI . $this->section . '/' . $this->docname . '.md') && $this->section !== $this->old_section) {
      $_SESSION['error'] = 'Error, document already exists';
      header('Location: dashboard');
    }
    else {
      unlink(DOC_URI . $this->old_section . '/' . $this->old_name . '.md');
      unset($this->list['pages'][$this->old_section][array_search($this->old_name, $this->list['pages'][$this->old_section])]);
      array_push($this->list['pages'][$this->section], $this->docname);
      file_put_contents(DOC_URI . $this->section . '/' . $this->docname . '.md', $this->content);
      $_SESSION['success'] = $this->docname . ' has been updated!';
    }
    $yaml = Yaml::dump($this->list);
    file_put_contents(CONFIG_URI, $yaml);
    header('Location: dashboard');
  }

  //Handling just document
  public function isContent() {
    return ($this->section && $this->docname);
  }

  //New document
  public function addContent() {
    if (file_exists(DOC_URI . $this->section . '/' . $this->docname . '.md')) {
      $_SESSION['error'] = 'Error, document already exists';
    }
    else {
      try {
        $file = fopen(DOC_URI . $this->section . '/' . $this->docname . '.md', 'w');
        fclose($file);
      } catch (Exception $e) {
        $_SESSION['error'] = 'Could not create local file. Check file permissions';
      }
      $this->list['pages'][$this->section][] = $this->docname;
      $_SESSION['success'] = 'You have successfully added a new document!';
    }
    $yaml = Yaml::dump($this->list);
    file_put_contents(CONFIG_URI, $yaml);
    header('Location: dashboard');
  }

  //Handling everything
  public function isEdit() {
    return ($this->section && $this->docname && $this->content);
  }

  //Finishing editing
  public function editContent() {
    $_SESSION['success'] = 'You have successfully edited a document!';
    $yaml = Yaml::dump($this->list);
    file_put_contents(CONFIG_URI, $yaml);
    header('Location: dashboard');
  }

}
