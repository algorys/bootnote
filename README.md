# Plugin BootNote

## Description

Bootnote is a plugin for [Dokuwiki](https://www.dokuwiki.org). It display some note inside the wiki with bootstrap style.

## Install
Download this plugin into your ``${dokuwiki_root}/lib/plugins`` folder and restart dokuwiki.

## Requirements

This plugin needs Bootstrap librairy to work. You need a template like [Boostrap 3](https://github.com/LotarProject/dokuwiki-template-bootstrap3/) to display it properly in Dokuwiki.

## Syntax

You can display actually 6 different types of notes :
* Web : display a note with an globe sign : ``<bootnote lvl="web">...Note...</bootnote>``
* Question : display a note with question sign : ``<bootnote lvl="question">...Note...</bootnote>``
* Learn : display note with an education sign : ``<bootnote lvl="learn">...Note...</bootnote>``
* Warning : display a note with a warning sign : ``<bootnote lvl="warning">...Note...</bootnote>``
* Critical : display a note with a fire sign ``<bootnote lvl="critical">...Note...</bootnote>``
* "nothing" : disply a simple note with info sign : ``<bootnote>...Note...</bootnote>``

**Note :** If you want more type of note, please let me know by opening an issue in this repos.

## Current Render
Here is a preview of each note :
![](http://s17.postimg.org/bxbd7qs9r/bootnote.png)

For further information, see also [Bootnote on dokuwiki.org](https://www.dokuwiki.org/plugin:bootnote)
