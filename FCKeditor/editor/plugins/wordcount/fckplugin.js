/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2005 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 * "Support Open Source software. What about a donation today?"
 * 
 * File Name: fckplugin.js
 * 	This is the sample plugin definition file.
 * 
 * File Authors:
 * 		Frederico Caldeira Knabben (fredck@fckeditor.net)
 */

// Register the related commands.
FCKCommands.RegisterCommand( 'My_Count'		, new FCKDialogCommand( FCKLang['DlgCharDesc']	, FCKLang['DlgCharDesc']		, FCKConfig.PluginsPath + 'wordcount/find.html'	, 340, 170 ) ) ;

// Create the "Find" toolbar button.
// var oFindItem		= new FCKToolbarButton( 'My_Find', FCKLang['DlgMyFindTitle'] ) ;
// oFindItem.IconPath	= FCKConfig.PluginsPath + 'findreplace/find.gif' ;

// FCKToolbarItems.RegisterItem( 'My_Find', oFindItem ) ;			// 'My_Find' is the name used in the Toolbar config.

/* Import plugin specific language pack */
tinyMCE.importPluginLanguagePack('charcount', 'en');

function TinyMCE_charcount_getInfo() {
	return {
		longname : 'Count Words/Characters',
		author : 'Ryan Demmer',
		authorurl : 'http://www.cellardoor.za.net/mosce/',
		infourl : '',
		version : '1.0'
	};
};

function TinyMCE_charcount_getControlHTML(control_name) {
	switch (control_name) {
		case "charcount":
			var cmd = 'tinyMCE.execInstanceCommand(\'{$editor_id}\',\'mceCount\', true);return false;';
			return '<a href="javascript:' + cmd + '" onclick="' + cmd + '" target="_self" onmousedown="return false;"><img id="{$editor_id}charcount" src="{$pluginurl}/images/charcount.gif" title="{$lang_charcount_desc}" width="20" height="20" class="mceButtonNormal" onmouseover="tinyMCE.switchClass(this,\'mceButtonOver\');" onmouseout="tinyMCE.restoreClass(this);" onmousedown="tinyMCE.restoreClass(this);" /></a>';
	}
	return '';
}

function TinyMCE_charcount_execCommand(editor_id, element, command, user_interface, value) {
	switch (command) {
		case "mceCount":
                var content = tinyMCE.getContent();
                var words = TinyMCE_countWords( content );
                var chars = TinyMCE_countChars( content, false );
                var chars_spaces = TinyMCE_countChars( content, true );
                
                var count_text = tinyMCE.getLang('lang_charcount_desc', '', true)+'\n';
                    count_text += tinyMCE.getLang('lang_charcount_words', '', true)+': '+words+'\n';
                    count_text += tinyMCE.getLang('lang_charcount_chars', '', true)+': '+chars+'\n';
                    count_text += tinyMCE.getLang('lang_charcount_chars_spaces', '', true)+': '+chars_spaces;
                alert( count_text );
				
			return true;
	}

	// Pass to next handler in chain
	return false;
}
function clean( content )
{
    content = content.replace(/<(.+?)>/g, '');//remove html
    content = content.replace('&nbsp;', ' ', 'g');//replace &nbsp; with space
    content = content.replace(/&(.*);/g, '1');//convert entities to single character
    return content;
}
function TinyMCE_countWords( content )
{
    content = clean( content );
    var arr = content.split(' ');
    
    var total = 0;
    for(var i=0; i<arr.length; i++)
    {
        if( arr[i].match(/\w/g)){
            total ++;
        }
    }
    return total;
}
function TinyMCE_countChars( content, spaces )
{
    content = clean( content );

    var total = 0;
    if(!spaces)
    {
        content = content.replace( ' ', '', 'g' );
    }
    total = content.length;

    return total;
}
