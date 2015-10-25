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

    /****
    * MAIN FONCTION
    ****/
    function _renderer_note($renderer, $data) {
        $renderer->doc .= '<div>';
	if($data['lvl'] == "web") {
            $renderer->doc .= '<div><span class="glyphicon glyphicon-globe" aria-hidden="true">';
	    $renderer->doc .= '<p>Ceci est une note d\'information.</p>';
	}elseif($data['lvl'] == "question") {
            $renderer->doc .= '<div><span class="glyphicon glyphicon-question-sign" aria-hidden="true">';
            $renderer->doc .= '<p>Ceci est une question</p>'; 
        }elseif($data['lvl'] == "learn") {
            $renderer->doc .= '<div><span class="glyphicon glyphicon-education" aria-hidden="true">';
            $renderer->doc .= '<p>Ceci est une note importante</p>';
         }elseif($data['lvl'] == "warning") {
            $renderer->doc .= '<div><span class="glyphicon glyphicon-alert" aria-hidden="true">';
            $renderer->doc .= '<p>Ceci est une note d\'attention</p>';
        }elseif($data['lvl'] == "critical") {
            $renderer->doc .= '<div><span class="glyphicon glyphicon-fire" aria-hidden="true">';
            $renderer->doc .= '<p>Ceci est une note importante</p>';
	}else{
            $renderer->doc .= '<div><span class="glyphicon glyphicon-info-sign" aria-hidden="true">';
            $renderer->doc .= '<p>Ceci est une note normale</p>';
        }
        $renderer->doc .= '</div>';    
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
            case DOKU_LEXER_SPECIAL :
                $this->_renderer_note($renderer, $data);
                break;
            case DOKU_LEXER_ENTER :
                $this->_renderer_note($renderer, $data);
                break;
            case DOKU_LEXER_EXIT:
                $renderer->doc .= '</div>';
            case DOKU_LEXER_UNMATCHED :
                $renderer->doc .= $renderer->_xmlEntities($data['text']);
                break;
        }
        return true;
    }
}



