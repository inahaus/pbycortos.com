/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config )
{
    // defino el idioma
    config.language = 'es';
    //defino el ancho estandar
    config.width = 850
    // configuracion del kcfinder (upload de imagenes)
    config.filebrowserBrowseUrl = baseJs+'kcfinder/browse.php?type=files';
    config.filebrowserImageBrowseUrl = baseJs+'kcfinder/browse.php?type=images';
    config.filebrowserFlashBrowseUrl = baseJs+'kcfinder/browse.php?type=flash';
    config.filebrowserUploadUrl = baseJs+'kcfinder/upload.php?type=files';
    config.filebrowserImageUploadUrl = baseJs+'kcfinder/upload.php?type=images';
    config.filebrowserFlashUploadUrl = baseJs+'kcfinder/upload.php?type=flash';

    //configuro las barra de herramientas
    config.toolbar = 'Full';

    config.toolbar_Full =
        [
	{name: 'document', items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ]},
	{name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ]},
	{name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ]},
	{name: 'forms', items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton','HiddenField' ]},
	'/',
	{name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ]},
	{name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ]},
        '/',
        {name: 'links', items : [ 'Link','Unlink','Anchor' ]},
        {name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ]},
                '/',
        {name: 'styles', items : [ 'Styles','Format','Font','FontSize' ]},
        {name: 'colors', items : [ 'TextColor','BGColor' ]},
        {name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ]}
    ];

    config.toolbar_Basic =
        [
        ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','-','About']
        ];

    config.toolbar = 'Comun';

    config.toolbar_Comun =
        [
	{name: 'document', items : [ 'Source']},
	{name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ]},
	{name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ]},
	'/',
	{name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ]},
	{name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ]},
        '/',
        {name: 'links', items : [ 'Link','Unlink','Anchor' ]},
        {name: 'insert', items : [ 'Image','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ]},
        {name: 'styles', items : [ 'Styles','Format','Font','FontSize' ]},
        {name: 'colors', items : [ 'TextColor','BGColor' ]},
        {name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ]}
        ]
};


