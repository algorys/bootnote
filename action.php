<?php
/*
 * Bootnote Action Plugin: Inserts a button into the toolbar
 *
 * @author Algorys
*/

if (!defined('DOKU_INC')) die();

class action_plugin_bootnote extends DokuWiki_Action_Plugin {

    function register(Doku_Event_Handler $controller) {
        $controller->register_hook('TOOLBAR_DEFINE', 'AFTER', $this, 'insert_button', array ());
    }

    /*
    * Inserts a toolbar button
    */
    function insert_button(Doku_Event $event, $param) {
        $syntax = array (
            'normal' => array(
                'icon' => '../../plugins/bootnote/images/normal.png',
                'open'   => '<bootnote>',
                'close'  => '</bootnote>',
                'sample' => 'MY_NOTE' 
            ),
            'question' => array(
                'icon' => '../../plugins/bootnote/images/question.png',
                'open'   => '<bootnote question>',
                'close'  => '</bootnote>',
                'sample' => 'MY_NOTE'
            ),
            'learn' => array(
                'icon' => '../../plugins/bootnote/images/learn.png',
                'open'   => '<bootnote learn>',
                'close'  => '</bootnote>',
                'sample' => 'MY_NOTE'
            ),
            'web' => array(
                'icon' => '../../plugins/bootnote/images/web.png',
                'open'   => '<bootnote web>',
                'close'  => '</bootnote>',
                'sample' => 'MY_NOTE'
            ),
            'warning' => array(
                'icon' => '../../plugins/bootnote/images/warning.png',
                'open'   => '<bootnote warning>',
                'close'  => '</bootnote>',
                'sample' => 'MY_NOTE'
            ),
            'critical' => array(
                'icon' => '../../plugins/bootnote/images/critical.png',
                'open'   => '<bootnote critical>',
                'close'  => '</bootnote>',
                'sample' => 'MY_NOTE'
            )
        );

        $bootnote = array(
            'type' => 'picker',
            'title' => 'Bootnote',
            'icon' => '../../plugins/bootnote/images/note.png',
            'list' => array(),
        );

        foreach ($syntax as $syntax_name => $syntax_data) {
            $bootnote['list'] [] = array(
                'type' => 'format',
                'title' => $syntax_name,
                'icon' => $syntax_data['icon'],
                'open' => $syntax_data['open'],
                'close' => $syntax_data['close'],
                'sample' => $syntax_data['sample'],
            );
        }

        $event->data[] = $bootnote;

    }
}
