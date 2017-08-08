# Plugin BootNote

## Description

Bootnote is a plugin for [Dokuwiki](https://www.dokuwiki.org). It display some note inside the wiki with bootstrap style.

## Install

Download this plugin into your ``${dokuwiki_root}/lib/plugins`` folder and restart dokuwiki or use the plugin manager inside Dokuwiki.

## Requirements

This plugin does not need any requirements but you need a template like [Boostrap 3](https://github.com/LotarProject/dokuwiki-template-bootstrap3/) to display icons in Dokuwiki. Otherwise, notes are displayed without icons.

## Syntax

You can display actually 6 different types of notes :

* "nothing" : display a simple note with info sign : `<bootnote>...Note...</bootnote>`
* Web : display a note with an globe sign : `<bootnote web>...Note...</bootnote>`
* Question : display a note with question sign : `<bootnote question>...Note...</bootnote>`
* Learn : display note with an education sign : ``<bootnote learn>...Note...</bootnote>``
* Warning : display a note with a warning sign : ``<bootnote warning>...Note...</bootnote>``
* Critical : display a note with a fire sign ``<bootnote critical>...Note...</bootnote>``

**Note :** If you want more type of note, please let me know by opening an issue in this repos.

## Settings

* **bootnote.note**: You can choose to override the plugin [note](https://www.dokuwiki.org/plugin:note) in settings to continue using its syntax.
* **bootnote.theme**: you can come back to old theme if you want. (See below for further informations)
* **bootnote.position**: defines if you want to display your text beside or below the note title.

## Current Render

Here is a preview of each note :

![new-bootnote.png](https://s2.postimg.org/aguld4eah/new-bootnote.png)

**Important:** The old theme is always available in settings but he's deprecated for Dokuwiki theme and only works properly with a bootstrap theme ! This theme may be remove in future versions

For further information, see also [Bootnote on dokuwiki.org](https://www.dokuwiki.org/plugin:bootnote)
