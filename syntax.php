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
        return 198;
    }

    function connectTo($mode) {
        $this->Lexer->addEntryPattern('<bootnote[^>]*>(?=.*</bootnote>)', $mode,'plugin_bootnote');
    }
    
    function postConnect() {
        $this->Lexer->addExitPattern('</bootnote>', 'plugin_bootnote');
    }

/**
* Do the regexp
**/
    function handle($match, $state, $pos, $handler) {
        switch($state){
            case DOKU_LEXER_ENTER :
                $data = array(
                        'state'=>$state,
                        'lvl'=> "",
                    );
                // Looking for id
                preg_match("/lvl *= *(['\"])(.*?)\\1/", $match, $lvl);
                if( count($lvl) != 0 ) {
                    $data['lvl'] = $lvl[2];
                }
                return $data;           
            case DOKU_LEXER_UNMATCHED :
                return array('state'=>$state, 'text'=>$match);
            default:
                return array('state'=>$state, 'bytepos_end' => $pos + strlen($match));
         }
    }

    function _render_note($renderer, $data, $glyph) {
         $renderer->doc .= '<div>';
         $renderer->doc .= '<div class="sign-container">';
         $renderer->doc .= '<span class="sign">';
         $renderer->doc .= '<span class="glyphicon glyphicon-'.$glyph.' s-'.$glyph.'" aria-hidden="true"></span>';
         $renderer->doc .= '</span>'; // /.sign
         $renderer->doc .= '</div>'; // /.sign-container
         $renderer->doc .= '<div class="note s-'.$glyph.'">';
    }

    /****
    * MAIN FONCTION
    ****/
    function _define_note($renderer, $data) {
	if($data['lvl'] == "web") {
            $glyph = "globe";
            $this->_render_note($renderer, $data, $glyph);
	}elseif($data['lvl'] == "question") {
            $glyph = "question-sign";
            $this->_render_note($renderer, $data, $glyph);
        }elseif($data['lvl'] == "learn") {
            $glyph = "education";
            $this->_render_note($renderer, $data, $glyph);
         }elseif($data['lvl'] == "warning") {
            $glyph = "alert";
            $this->_render_note($renderer, $data, $glyph);
        }elseif($data['lvl'] == "critical") {
            $glyph = "fire";
            $this->_render_note($renderer, $data, $glyph);
	}else{
            $glyph = "info-sign";
            $this->_render_note($renderer, $data, $glyph);
        }
    }

    // Dokuwiki Renderer
    function render($mode, $renderer, $data) {
        if($mode != 'xhtml') return false;

        if($data['error']) {
            $renderer->doc .= $data['text'];
            return true;
        }
        $renderer->info['cache'] = false;
        switch($data['state']) {
            case DOKU_LEXER_ENTER :
                $this->_define_note($renderer, $data);
                //$renderer->doc .= '<div class="note">';
                print_r($glyph);
                break;
            case DOKU_LEXER_EXIT:
                $renderer->doc .= '</div>';//</div>';
            case DOKU_LEXER_UNMATCHED :
                $renderer->doc .= $renderer->_xmlEntities($data['text']);
                break;
        }
        return true;
    }
}



