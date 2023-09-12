<?php
/**
 * Bootnote Syntax Plugin: display note with different level of importance.
 *
 * @author Algorys
 */

if (!defined('DOKU_INC')) die();

class syntax_plugin_bootnote extends DokuWiki_Syntax_Plugin {

    public function getType() {
        return 'container';
    }

    /**
    * @return string Paragraph type
    **/

    public function getPType() {
        return 'normal';
    }

    // Keep syntax inside plugin
    function getAllowedTypes() {
	return array('container', 'baseonly', 'substition','protected','disabled','formatting','paragraphs');
    }

    public function getSort() {
        return 192;
    }

    function connectTo($mode) {
        if($this->getConf('bootnote.note') == 'note') {
            $this->Lexer->addEntryPattern('<note[^>]*>(?=.*</note>)', $mode,'plugin_bootnote');
        } else {
            $this->Lexer->addEntryPattern('<bootnote[^>]*>(?=.*</bootnote>)', $mode,'plugin_bootnote');
        }
    }
    
    function postConnect() {
        if($this->getConf('bootnote.note') == 'note') {
            $this->Lexer->addExitPattern("</note>", 'plugin_bootnote');
        } else {
            $this->Lexer->addExitPattern("</bootnote>", 'plugin_bootnote');
        }
    }

    /**
    * Do the regexp
    **/
    function handle($match, $state, $pos, Doku_Handler $handler) {
        switch($state){
            case DOKU_LEXER_ENTER :
                $data = array(
                        'state'=>$state,
                        'lvl'=> "",
                    );
                // Looking for id
                if($this->getConf('bootnote.note') == 'note') {
                    $note = 'note';
                } else {
                    $note = 'bootnote';
                }
                preg_match("/$note (\\w*)/", $match, $lvl);
                if( count($lvl) != 0 ) {
                    $data['lvl'] = $lvl[1];
                }
                return $data;           
            case DOKU_LEXER_UNMATCHED :
                return array('state'=>$state, 'text'=>$match);
            default:
                return array('state'=>$state, 'bytepos_end' => $pos + strlen($match));
         }
    }

    // Dokuwiki Renderer
    function render($mode, Doku_Renderer $renderer, $data) {
        if($mode != 'xhtml') return false;

        if($this->getArrayValue('error',$data)) {
            $renderer->doc .= $this->getArrayValue('text',$data);
            return true;
        }
        $renderer->info['cache'] = false;
        switch($this->getArrayValue('state',$data)) {
            case DOKU_LEXER_ENTER :
                $this->_define_note($renderer, $data);
                break;
            case DOKU_LEXER_EXIT:
                if ($this->getConf('bootnote.theme') == 'oldtheme') {
                    $renderer->doc .= '</div>';// /.note
                    $renderer->doc .= '<div class="triangle"></div>';
                    $renderer->doc .= '</div>';// /.note-container
                    $renderer->doc .= '</div>';// /Global
                } else {
                    $renderer->doc .= '</p></div>';
                }

            case DOKU_LEXER_UNMATCHED :
                $renderer->doc .= $renderer->_xmlEntities($this->getArrayValue('text',$data));
                break;
        }
        return true;
    }

    function getArrayValue(string $key,array $array,$default=''){
    	if (array_key_exists($key,$array)){
    	    return $array[$key];
    	}
    	return $default;    	  	
     }

    // Define note before render
    function _define_note($renderer, $data) {
        $glyphs = Array(
            'web' => 'globe',
            'question' => 'question-sign',
            'learn' => 'education',
            'tip' => 'education',
            'warning' => 'alert',
            'critical' => 'fire',
            'important' => 'fire',
            '' => 'info-sign'
        );

	    $this->_render_note($renderer, $glyphs[$data['lvl']]);
    }

    // Render Note
    function _render_note($renderer, $glyph) {
        if ($this->getConf('bootnote.theme') == 'oldtheme') {
            $renderer->doc .= '<div style="clear: both;">'; // Global
            $renderer->doc .= '<div class="sign-container">';
            $renderer->doc .= '  <span class="sign">';
            $renderer->doc .= '    <span class="glyphicon glyphicon-'.$glyph.' s-'.$glyph.' glyph" aria-hidden="true"></span>';
            $renderer->doc .= '  </span>'; // /.sign
            $renderer->doc .= '</div>'; // /.sign-container
            $renderer->doc .= '<div class="note-container s-'.$glyph.'">';
            $renderer->doc .= '<div class="note">';
        } else {
            $renderer->doc .= '<div class="w3-panel n-'.$glyph.'"><p>';
            $renderer->doc .= '<span class="glyphicon glyphicon-'.$glyph.' blackglyph" aria-hidden="true"></span>';
            $renderer->doc .= '<span class="n-title">'.$this->getTitle($glyph).':</span>';
            if ($this->getConf('bootnote.position') == 'below') {
                $renderer->doc .= '</p>';
                $renderer->doc .= '<p>';
            } else {
                $renderer->doc .= ' '; // Need a space to separate title from text
            }
        }
    }

    function getTitle($glyph) {
        $titles = Array(
            'info-sign'     => $this->getLang('bootnote.info'),
            'education'     => $this->getLang('bootnote.learn'),
            'question-sign' => $this->getLang('bootnote.question'),
            'alert'         => $this->getLang('bootnote.alert'),
            'fire'          => $this->getLang('bootnote.fire'),
            'globe'         => $this->getLang('bootnote.link')
        );

        return $titles[$glyph];
    }
}



