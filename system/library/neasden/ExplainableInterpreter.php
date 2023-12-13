<?php

namespace Neasden;

use Neasden\Interpreter;

class ExplainableInterpreter extends Interpreter {

  private function printRed ($string) {
    $result = '';
    if (is_array ($string)) {
      // $string = implode ("\n", $string);
      $result .= '<span style="color: #90d">Array of lines:</span><br />';
      $result .= print_r ($string, true);
      return $result;
    };
    $tail = $string;
    while (($char = mb_substr ($tail, 0, 1)) !== '') {
      $tail = substr ($tail, strlen ($char));
      if (ord ($char) >= 33) {
        $result .= htmlspecialchars ($char);
      } elseif (ord ($char) == 32) {
        $result .= '<span style="color: #09d">_</span>&ZeroWidthSpace;';
      } elseif (ord ($char) == 10) {
        $result .= '<span style="color: #09d">\n</span><br />';
      } else {
        $result .= '<span style="color: #09d">#'. str_pad (ord ($char), 2) .'</span>&ZeroWidthSpace;';
      }
    }
    return $result;
  }


  public function explainCompare ($library, Renderer $renderer) {
    echo $renderer -> getLinksHTML ($library);
    echo '<h2 class="neasden-debug">Before and After</h2>';
    echo '<table class="neasden-debug">';
    echo '<tr>';
    echo '<td width="50%">';
    echo '<pre class="neasden-debug">';
    echo htmlspecialchars ($this->input);
    echo '</pre class="neasden-debug">';
    echo '</td>';
    echo '<td width="50%">';
    echo $renderer -> getHTML ();
    echo '</td>';
    echo '</tr>';
    echo '</table>';
  }


  public function explainStream () {
    echo '<h2 class="neasden-debug">Stream</h2>';
    if (!is_array ($this->stream_log)) {
      echo '<p>No stream log found, enable debugging</p>';
      return;
    }
    echo '<table class="neasden-debug">';
    echo '<tr>';
    echo '<td width="50%">';
    echo '<pre class="neasden-debug">';
    $prevstate = self::INITIAL_STREAM_STATE;
    echo '<span style="color: #d33">['. $prevstate .']</span>';
    foreach ($this->stream_log as $line) {
      if ($line[0] === 'char') {
        echo $this -> printRed ($line[1]);
        $state = $line[2];
        if ($state !== $prevstate) echo '<span style="color: #d33">['. $state .']</span>';
        $prevstate = $state;
      }
      if ($line[0] === 'frag') {
        echo '<span style="color: #d33; background: #ff9; ">['. $line[2] .'. capture:]</span><br />';
        echo '</td>';
        echo '<td>';
        // echo '<div style="background: #ff9; outline: 1px #c66 solid; padding: 10px">';
        echo highlight_string ('<?php '. var_export ($line[1], true) . '?>', true);
        // echo '</div>';
        echo '</pre class="neasden-debug">';
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td width="50%">';
        echo '<pre class="neasden-debug">';
      }
      if ($line[0] === 'text') {
        echo $line[1] . '<br />';
      }
    }
    echo '</pre class="neasden-debug">';
    echo '</td>';
    echo '</tr>';
    echo '</table>';

  }


  public function explainFragments () {
    echo '<h2 class="neasden-debug">Fragments</h2>';
    echo '<table class="neasden-debug">';
    echo '<thead>';
    echo '<th>#</th>';
    echo '<th>Strength</th>';
    echo '<th>Original</th>';
    echo '<th>Result</th>';
    echo '</thead>';
    $i = 0;
    foreach ($this->fragments as $fragment) {
      echo '<tr>';
      echo '<td>'. $i ++ .'</td>';
      echo '<td>'. $fragment['strength'] .'</td>'; 
      // echo '<td><pre class="neasden-debug">'. @htmlspecialchars ($fragment['content.original']) .'</pre class="neasden-debug"></td>'; 
      // echo '<td><pre class="neasden-debug">'. @htmlspecialchars ($fragment['content']) .'</pre class="neasden-debug"></td>'; 
      echo '<td><pre class="neasden-debug">'. $this -> printRed ($fragment['content.original']) .'</pre class="neasden-debug"></td>'; 
      echo '<td><pre class="neasden-debug">'. $this -> printRed ($fragment['content']) .'</pre class="neasden-debug"></td>'; 
      // echo '<td><pre class="neasden-debug">'. @highlight_string ('<?php '. var_export ($fragment['groups'], true) . '? >', true) .'</pre class="neasden-debug"></td>';
      echo '</tr>';
    }
    echo '</table>';
  }


  public function explainFlow () {
    echo '<h2 class="neasden-debug">Bands</h2>';
    // print_r($this->bands);
    echo '<table class="neasden-debug">';
    echo '<thead>';
    echo '<th>#</th>';
    echo '<th>Frag</th>';
    echo '<th>Kind</th>';
    echo '<th>Class</th>';
    echo '<th>Isolated</th>';
    // echo '<th>Original</th>';
    echo '<th>Result</th>';
    echo '</thead>';
    $i = 0;
    foreach ($this -> getModel () -> getFlow () as $element) {
    
      $band = Model::expandFlowElement ($element);

      $isolated = '';
      $content = $band['content'];

      // if (is_string ($content) and $content[0] === self::RX_SPECIAL_CHAR) {
      //   $isolated = '✓';
      //   $index = (int) substr ($content, 1, -1);
      //   $content = str_replace ($this -> specialSequence ($index), $this->isolations[$index], $content);
      // }

      echo '<tr>';
      echo '<td>'. $i ++ .'</td>';
      echo '<td>'. $band['.f'] .'</td>';
      echo '<td>'. $band['kind'] .'</td>';
      echo '<td>'. @$band['class'] .'</td>';
      echo '<td>'. $isolated .'</td>';

      // echo '<td><pre class="neasden-debug">'. @htmlspecialchars ($content) .'</pre class="neasden-debug"></td>'; 
      echo '<td><pre class="neasden-debug">'. $this -> printRed ($content) .'</pre class="neasden-debug"></td>'; 
      // echo '<td><pre class="neasden-debug">'. @highlight_string ('<?php '. var_export ($content, true) . '? >', true) .'</pre class="neasden-debug"></td>';

      echo '</tr>';
    }
    echo '</table>';
  }


  public function explainResources () {
    
    echo '<h2 class="neasden-debug">Resources</h2>';
    if (count ($this -> getModel () -> getResources ())) {
      echo '<ul class="neasden-debug">';
      foreach ($this -> getModel () -> getResources () as $resource) {
        echo '<li>'. $resource .'</li>';
      }
      echo '</ul>';
    } else {
      echo '<p>None</p>';
    }

  }


  public function explainLinks () {
    
    echo '<h2 class="neasden-debug">Links</h2>';
    if (count ($this -> getModel () -> getLinks ())) {
      echo '<ul class="neasden-debug">';
      foreach ($this -> getModel () -> getLinks () as $link) {
        echo '<li>'. $link .'</li>';
      }
      echo '</ul>';
    } else {
      echo '<p>None</p>';
    }

  }


  public function explain ($library, $renderer) {

    $this -> explainCompare ($library, $renderer);
    $this -> explainStream ();
    $this -> explainFragments ();
    $this -> explainFlow ();
    $this -> explainResources ();
    $this -> explainLinks ();

  }


}
  
?>