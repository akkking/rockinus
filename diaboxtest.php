<html>
<head>
<script src="http://www.ajaxonomy.com/files/jquery-1.4.2.min_.js_.txt" ></script>
<script src="http://www.ajaxonomy.com/files/jquery-ui-1.8.custom.min_.js_.txt" ></script>
<style>
.ui-helper-hidden {
    display: none;
}
.ui-helper-hidden-accessible {
    left: -1e+8px;
    position: absolute;
}
.ui-helper-reset {
    border: 0 none;
    font-size: 100%;
    line-height: 1.3;
    list-style: none outside none;
    margin: 0;
    outline: 0 none;
    padding: 0;
    text-decoration: none;
}
.ui-helper-clearfix:after {
    clear: both;
    content: ".";
    display: block;
    height: 0;
    visibility: hidden;
}
.ui-helper-clearfix {
    display: inline-block;
}
* html .ui-helper-clearfix {
    height: 1%;
}
.ui-helper-clearfix {
    display: block;
}
.ui-helper-zfix {
    height: 100%;
    left: 0;
    opacity: 0;
    position: absolute;
    top: 0;
    width: 100%;
}
.ui-state-disabled {
    cursor: default !important;
}
.ui-icon {
    background-repeat: no-repeat;
    display: block;
    overflow: hidden;
    text-indent: -99999px;
}
.ui-widget-overlay {
    height: 100%;
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
}
.ui-widget {
    font-family: Arial,sans-serif;
    font-size: 1.1em;
}
.ui-widget .ui-widget {
    font-size: 1em;
}
.ui-widget input, .ui-widget select, .ui-widget textarea, .ui-widget button {
    font-family: Arial,sans-serif;
    font-size: 1em;
}
.ui-widget-content {
    background: url("ui-bg_flat_75_ffffff_40x100.png") repeat-x scroll 50% 50% #FFFFFF;
    border: 1px solid #EEEEEE;
    color: #333333;
}
.ui-widget-content a {
    color: #333333;
}
.ui-widget-header {
    background-color: #006600;
    border: 1px solid #A1E3A1;
    color: #FFFFFF;
    font-weight: bold;
}
.ui-widget-header a {
    color: #FFFFFF;
}
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
    background: url("ui-bg_highlight-hard_100_eeeeee_1x100.png") repeat-x scroll 50% 50% #EEEEEE;
    border: 1px solid #D8DCDF;
    color: #004276;
    font-weight: bold;
}
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited {
    color: #004276;
    text-decoration: none;
}
.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus {
    background: url("ui-bg_highlight-hard_100_f6f6f6_1x100.png") repeat-x scroll 50% 50% #F6F6F6;
    border: 1px solid #CDD5DA;
    color: #111111;
    font-weight: bold;
}
.ui-state-hover a, .ui-state-hover a:hover {
    color: #111111;
    text-decoration: none;
}
.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active {
    background: url("ui-bg_flat_65_ffffff_40x100.png") repeat-x scroll 50% 50% #FFFFFF;
    border: 1px solid #EEEEEE;
    color: #CC0000;
    font-weight: bold;
}
.ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited {
    color: #CC0000;
    text-decoration: none;
}
.ui-widget *:active {
    outline: medium none;
}
.ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight {
    background: url("ui-bg_glass_55_fbf8ee_1x400.png") repeat-x scroll 50% 50% #FBF8EE;
    border: 1px solid #FCD3A1;
    color: #444444;
}
.ui-state-highlight a, .ui-widget-content .ui-state-highlight a, .ui-widget-header .ui-state-highlight a {
    color: #444444;
}
.ui-state-error, .ui-widget-content .ui-state-error, .ui-widget-header .ui-state-error {
    background: url("ui-bg_diagonals-thick_75_f3d8d8_40x40.png") repeat scroll 50% 50% #F3D8D8;
    border: 1px solid #CC0000;
    color: #2E2E2E;
}
.ui-state-error a, .ui-widget-content .ui-state-error a, .ui-widget-header .ui-state-error a {
    color: #2E2E2E;
}
.ui-state-error-text, .ui-widget-content .ui-state-error-text, .ui-widget-header .ui-state-error-text {
    color: #2E2E2E;
}
.ui-priority-primary, .ui-widget-content .ui-priority-primary, .ui-widget-header .ui-priority-primary {
    font-weight: bold;
}
.ui-priority-secondary, .ui-widget-content .ui-priority-secondary, .ui-widget-header .ui-priority-secondary {
    font-weight: normal;
    opacity: 0.7;
}
.ui-state-disabled, .ui-widget-content .ui-state-disabled, .ui-widget-header .ui-state-disabled {
    background-image: none;
    opacity: 0.35;
}
.ui-icon {
    background-image: url("http://www.ajaxonomy.com/files/ui-icons_cc0000_256x240.png");
    height: 16px;
    width: 16px;
}
.ui-widget-content .ui-icon {
    background-image: url("http://www.ajaxonomy.com/files/ui-icons_cc0000_256x240.png");
}
.ui-widget-header .ui-icon {
    background-image: url("http://www.ajaxonomy.com/files/ui-icons_ffffff_256x240.png");
}
.ui-state-default .ui-icon {
    background-image: url("http://www.ajaxonomy.com/files/ui-icons_cc0000_256x240.png");
}
.ui-state-hover .ui-icon, .ui-state-focus .ui-icon {
    background-image: url("http://www.ajaxonomy.com/files/ui-icons_cc0000_256x240.png");
}
.ui-state-active .ui-icon {
    background-image: url("http://www.ajaxonomy.com/files/ui-icons_cc0000_256x240.png");
}
.ui-state-highlight .ui-icon {
    background-image: url("http://www.ajaxonomy.com/files/ui-icons_004276_256x240.png");
}
.ui-state-error .ui-icon, .ui-state-error-text .ui-icon {
    background-image: url("http://www.ajaxonomy.com/files/ui-icons_cc0000_256x240.png");
}
.ui-icon-carat-1-n {
    background-position: 0 0;
}
.ui-icon-carat-1-ne {
    background-position: -16px 0;
}
.ui-icon-carat-1-e {
    background-position: -32px 0;
}
.ui-icon-carat-1-se {
    background-position: -48px 0;
}
.ui-icon-carat-1-s {
    background-position: -64px 0;
}
.ui-icon-carat-1-sw {
    background-position: -80px 0;
}
.ui-icon-carat-1-w {
    background-position: -96px 0;
}
.ui-icon-carat-1-nw {
    background-position: -112px 0;
}
.ui-icon-carat-2-n-s {
    background-position: -128px 0;
}
.ui-icon-carat-2-e-w {
    background-position: -144px 0;
}
.ui-icon-triangle-1-n {
    background-position: 0 -16px;
}
.ui-icon-triangle-1-ne {
    background-position: -16px -16px;
}
.ui-icon-triangle-1-e {
    background-position: -32px -16px;
}
.ui-icon-triangle-1-se {
    background-position: -48px -16px;
}
.ui-icon-triangle-1-s {
    background-position: -64px -16px;
}
.ui-icon-triangle-1-sw {
    background-position: -80px -16px;
}
.ui-icon-triangle-1-w {
    background-position: -96px -16px;
}
.ui-icon-triangle-1-nw {
    background-position: -112px -16px;
}
.ui-icon-triangle-2-n-s {
    background-position: -128px -16px;
}
.ui-icon-triangle-2-e-w {
    background-position: -144px -16px;
}
.ui-icon-arrow-1-n {
    background-position: 0 -32px;
}
.ui-icon-arrow-1-ne {
    background-position: -16px -32px;
}
.ui-icon-arrow-1-e {
    background-position: -32px -32px;
}
.ui-icon-arrow-1-se {
    background-position: -48px -32px;
}
.ui-icon-arrow-1-s {
    background-position: -64px -32px;
}
.ui-icon-arrow-1-sw {
    background-position: -80px -32px;
}
.ui-icon-arrow-1-w {
    background-position: -96px -32px;
}
.ui-icon-arrow-1-nw {
    background-position: -112px -32px;
}
.ui-icon-arrow-2-n-s {
    background-position: -128px -32px;
}
.ui-icon-arrow-2-ne-sw {
    background-position: -144px -32px;
}
.ui-icon-arrow-2-e-w {
    background-position: -160px -32px;
}
.ui-icon-arrow-2-se-nw {
    background-position: -176px -32px;
}
.ui-icon-arrowstop-1-n {
    background-position: -192px -32px;
}
.ui-icon-arrowstop-1-e {
    background-position: -208px -32px;
}
.ui-icon-arrowstop-1-s {
    background-position: -224px -32px;
}
.ui-icon-arrowstop-1-w {
    background-position: -240px -32px;
}
.ui-icon-arrowthick-1-n {
    background-position: 0 -48px;
}
.ui-icon-arrowthick-1-ne {
    background-position: -16px -48px;
}
.ui-icon-arrowthick-1-e {
    background-position: -32px -48px;
}
.ui-icon-arrowthick-1-se {
    background-position: -48px -48px;
}
.ui-icon-arrowthick-1-s {
    background-position: -64px -48px;
}
.ui-icon-arrowthick-1-sw {
    background-position: -80px -48px;
}
.ui-icon-arrowthick-1-w {
    background-position: -96px -48px;
}
.ui-icon-arrowthick-1-nw {
    background-position: -112px -48px;
}
.ui-icon-arrowthick-2-n-s {
    background-position: -128px -48px;
}
.ui-icon-arrowthick-2-ne-sw {
    background-position: -144px -48px;
}
.ui-icon-arrowthick-2-e-w {
    background-position: -160px -48px;
}
.ui-icon-arrowthick-2-se-nw {
    background-position: -176px -48px;
}
.ui-icon-arrowthickstop-1-n {
    background-position: -192px -48px;
}
.ui-icon-arrowthickstop-1-e {
    background-position: -208px -48px;
}
.ui-icon-arrowthickstop-1-s {
    background-position: -224px -48px;
}
.ui-icon-arrowthickstop-1-w {
    background-position: -240px -48px;
}
.ui-icon-arrowreturnthick-1-w {
    background-position: 0 -64px;
}
.ui-icon-arrowreturnthick-1-n {
    background-position: -16px -64px;
}
.ui-icon-arrowreturnthick-1-e {
    background-position: -32px -64px;
}
.ui-icon-arrowreturnthick-1-s {
    background-position: -48px -64px;
}
.ui-icon-arrowreturn-1-w {
    background-position: -64px -64px;
}
.ui-icon-arrowreturn-1-n {
    background-position: -80px -64px;
}
.ui-icon-arrowreturn-1-e {
    background-position: -96px -64px;
}
.ui-icon-arrowreturn-1-s {
    background-position: -112px -64px;
}
.ui-icon-arrowrefresh-1-w {
    background-position: -128px -64px;
}
.ui-icon-arrowrefresh-1-n {
    background-position: -144px -64px;
}
.ui-icon-arrowrefresh-1-e {
    background-position: -160px -64px;
}
.ui-icon-arrowrefresh-1-s {
    background-position: -176px -64px;
}
.ui-icon-arrow-4 {
    background-position: 0 -80px;
}
.ui-icon-arrow-4-diag {
    background-position: -16px -80px;
}
.ui-icon-extlink {
    background-position: -32px -80px;
}
.ui-icon-newwin {
    background-position: -48px -80px;
}
.ui-icon-refresh {
    background-position: -64px -80px;
}
.ui-icon-shuffle {
    background-position: -80px -80px;
}
.ui-icon-transfer-e-w {
    background-position: -96px -80px;
}
.ui-icon-transferthick-e-w {
    background-position: -112px -80px;
}
.ui-icon-folder-collapsed {
    background-position: 0 -96px;
}
.ui-icon-folder-open {
    background-position: -16px -96px;
}
.ui-icon-document {
    background-position: -32px -96px;
}
.ui-icon-document-b {
    background-position: -48px -96px;
}
.ui-icon-note {
    background-position: -64px -96px;
}
.ui-icon-mail-closed {
    background-position: -80px -96px;
}
.ui-icon-mail-open {
    background-position: -96px -96px;
}
.ui-icon-suitcase {
    background-position: -112px -96px;
}
.ui-icon-comment {
    background-position: -128px -96px;
}
.ui-icon-person {
    background-position: -144px -96px;
}
.ui-icon-print {
    background-position: -160px -96px;
}
.ui-icon-trash {
    background-position: -176px -96px;
}
.ui-icon-locked {
    background-position: -192px -96px;
}
.ui-icon-unlocked {
    background-position: -208px -96px;
}
.ui-icon-bookmark {
    background-position: -224px -96px;
}
.ui-icon-tag {
    background-position: -240px -96px;
}
.ui-icon-home {
    background-position: 0 -112px;
}
.ui-icon-flag {
    background-position: -16px -112px;
}
.ui-icon-calendar {
    background-position: -32px -112px;
}
.ui-icon-cart {
    background-position: -48px -112px;
}
.ui-icon-pencil {
    background-position: -64px -112px;
}
.ui-icon-clock {
    background-position: -80px -112px;
}
.ui-icon-disk {
    background-position: -96px -112px;
}
.ui-icon-calculator {
    background-position: -112px -112px;
}
.ui-icon-zoomin {
    background-position: -128px -112px;
}
.ui-icon-zoomout {
    background-position: -144px -112px;
}
.ui-icon-search {
    background-position: -160px -112px;
}
.ui-icon-wrench {
    background-position: -176px -112px;
}
.ui-icon-gear {
    background-position: -192px -112px;
}
.ui-icon-heart {
    background-position: -208px -112px;
}
.ui-icon-star {
    background-position: -224px -112px;
}
.ui-icon-link {
    background-position: -240px -112px;
}
.ui-icon-cancel {
    background-position: 0 -128px;
}
.ui-icon-plus {
    background-position: -16px -128px;
}
.ui-icon-plusthick {
    background-position: -32px -128px;
}
.ui-icon-minus {
    background-position: -48px -128px;
}
.ui-icon-minusthick {
    background-position: -64px -128px;
}
.ui-icon-close {
    background-position: -80px -128px;
}
.ui-icon-closethick {
    background-position: -96px -128px;
}
.ui-icon-key {
    background-position: -112px -128px;
}
.ui-icon-lightbulb {
    background-position: -128px -128px;
}
.ui-icon-scissors {
    background-position: -144px -128px;
}
.ui-icon-clipboard {
    background-position: -160px -128px;
}
.ui-icon-copy {
    background-position: -176px -128px;
}
.ui-icon-contact {
    background-position: -192px -128px;
}
.ui-icon-image {
    background-position: -208px -128px;
}
.ui-icon-video {
    background-position: -224px -128px;
}
.ui-icon-script {
    background-position: -240px -128px;
}
.ui-icon-alert {
    background-position: 0 -144px;
}
.ui-icon-info {
    background-position: -16px -144px;
}
.ui-icon-notice {
    background-position: -32px -144px;
}
.ui-icon-help {
    background-position: -48px -144px;
}
.ui-icon-check {
    background-position: -64px -144px;
}
.ui-icon-bullet {
    background-position: -80px -144px;
}
.ui-icon-radio-off {
    background-position: -96px -144px;
}
.ui-icon-radio-on {
    background-position: -112px -144px;
}
.ui-icon-pin-w {
    background-position: -128px -144px;
}
.ui-icon-pin-s {
    background-position: -144px -144px;
}
.ui-icon-play {
    background-position: 0 -160px;
}
.ui-icon-pause {
    background-position: -16px -160px;
}
.ui-icon-seek-next {
    background-position: -32px -160px;
}
.ui-icon-seek-prev {
    background-position: -48px -160px;
}
.ui-icon-seek-end {
    background-position: -64px -160px;
}
.ui-icon-seek-start {
    background-position: -80px -160px;
}
.ui-icon-seek-first {
    background-position: -80px -160px;
}
.ui-icon-stop {
    background-position: -96px -160px;
}
.ui-icon-eject {
    background-position: -112px -160px;
}
.ui-icon-volume-off {
    background-position: -128px -160px;
}
.ui-icon-volume-on {
    background-position: -144px -160px;
}
.ui-icon-power {
    background-position: 0 -176px;
}
.ui-icon-signal-diag {
    background-position: -16px -176px;
}
.ui-icon-signal {
    background-position: -32px -176px;
}
.ui-icon-battery-0 {
    background-position: -48px -176px;
}
.ui-icon-battery-1 {
    background-position: -64px -176px;
}
.ui-icon-battery-2 {
    background-position: -80px -176px;
}
.ui-icon-battery-3 {
    background-position: -96px -176px;
}
.ui-icon-circle-plus {
    background-position: 0 -192px;
}
.ui-icon-circle-minus {
    background-position: -16px -192px;
}
.ui-icon-circle-close {
    background-position: -32px -192px;
}
.ui-icon-circle-triangle-e {
    background-position: -48px -192px;
}
.ui-icon-circle-triangle-s {
    background-position: -64px -192px;
}
.ui-icon-circle-triangle-w {
    background-position: -80px -192px;
}
.ui-icon-circle-triangle-n {
    background-position: -96px -192px;
}
.ui-icon-circle-arrow-e {
    background-position: -112px -192px;
}
.ui-icon-circle-arrow-s {
    background-position: -128px -192px;
}
.ui-icon-circle-arrow-w {
    background-position: -144px -192px;
}
.ui-icon-circle-arrow-n {
    background-position: -160px -192px;
}
.ui-icon-circle-zoomin {
    background-position: -176px -192px;
}
.ui-icon-circle-zoomout {
    background-position: -192px -192px;
}
.ui-icon-circle-check {
    background-position: -208px -192px;
}
.ui-icon-circlesmall-plus {
    background-position: 0 -208px;
}
.ui-icon-circlesmall-minus {
    background-position: -16px -208px;
}
.ui-icon-circlesmall-close {
    background-position: -32px -208px;
}
.ui-icon-squaresmall-plus {
    background-position: -48px -208px;
}
.ui-icon-squaresmall-minus {
    background-position: -64px -208px;
}
.ui-icon-squaresmall-close {
    background-position: -80px -208px;
}
.ui-icon-grip-dotted-vertical {
    background-position: 0 -224px;
}
.ui-icon-grip-dotted-horizontal {
    background-position: -16px -224px;
}
.ui-icon-grip-solid-vertical {
    background-position: -32px -224px;
}
.ui-icon-grip-solid-horizontal {
    background-position: -48px -224px;
}
.ui-icon-gripsmall-diagonal-se {
    background-position: -64px -224px;
}
.ui-icon-grip-diagonal-se {
    background-position: -80px -224px;
}
.ui-corner-tl {
    border-top-left-radius: 6px;
}
.ui-corner-tr {
    border-top-right-radius: 6px;
}
.ui-corner-bl {
    border-bottom-left-radius: 6px;
}
.ui-corner-br {
    border-bottom-right-radius: 6px;
}
.ui-corner-top {
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
}
.ui-corner-bottom {
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 6px;
}
.ui-corner-right {
    border-bottom-right-radius: 6px;
    border-top-right-radius: 6px;
}
.ui-corner-left {
    border-bottom-left-radius: 6px;
    border-top-left-radius: 6px;
}
.ui-corner-all {
    border-radius: 6px 6px 6px 6px;
}
.ui-widget-overlay {
    background: url("http://www.ajaxonomy.com/files/ui-bg_dots-small_65_a6a6a6_2x2.png") repeat scroll 50% 50% #A6A6A6;
    opacity: 0.4;
}
.ui-widget-shadow {
    background: url("http://www.ajaxonomy.com/files/ui-bg_flat_0_333333_40x100.png") repeat-x scroll 50% 50% #333333;
    border-radius: 8px 8px 8px 8px;
    margin: -8px 0 0 -8px;
    opacity: 0.1;
    padding: 8px;
}
.ui-dialog {
    overflow: hidden;
    padding: 0.2em;
    position: absolute;
    width: 300px;
}
.ui-dialog .ui-dialog-titlebar {
    padding: 0.5em 1em 0.3em;
    position: relative;
}
.ui-dialog .ui-dialog-title {
    float: left;
    margin: 0.1em 16px 0.2em 0;
}
.ui-dialog .ui-dialog-titlebar-close {
    height: 18px;
    margin: -10px 0 0;
    padding: 1px;
    position: absolute;
    right: 0.3em;
    top: 50%;
    width: 19px;
}
.ui-dialog .ui-dialog-titlebar-close span {
    display: block;
    margin: 1px;
}
.ui-dialog .ui-dialog-titlebar-close:hover, .ui-dialog .ui-dialog-titlebar-close:focus {
    padding: 0;
}
.ui-dialog .ui-dialog-content {
    background: none repeat scroll 0 0 transparent;
    border: 0 none;
    overflow: auto;
    padding: 0.5em 1em;
}
.ui-dialog .ui-dialog-buttonpane {
    background-image: none;
    border-width: 1px 0 0;
    margin: 0.5em 0 0;
    padding: 0.3em 1em 0.5em 0.4em;
    text-align: left;
}
.ui-dialog .ui-dialog-buttonpane button {
    cursor: pointer;
    float: right;
    line-height: 1.4em;
    margin: 0.5em 0.4em 0.5em 0;
    overflow: visible;
    padding: 0.2em 0.6em 0.3em;
    width: auto;
}
.ui-dialog .ui-resizable-se {
    bottom: 3px;
    height: 14px;
    right: 3px;
    width: 14px;
}
.ui-draggable .ui-dialog-titlebar {
    cursor: move;
}

</style>
<script>
$(function(){
        // jQuery UI Dialog    

        $('#dialog').dialog({
            autoOpen: false,
            width: 400,
            modal: true,
            resizable: false,
            buttons: {
                "Yes": function() {
                    $(this).dialog("close");
		    $(location).attr('href',$(this).dialog('option', 'anchor'));
		    return true;
                },
                "No": function() {
                    $(this).dialog("close");
		    return false;
                }
            }
        });

        $('.closebutton').click(function(){
	    $('#dialog').dialog('option', 'anchor', $(this).attr('href'));
            $('#dialog').dialog('open');
            return false;
        });
});
</script>
</head>
<body>
<a id="closebutton1" href="http://ocell.us" class="closebutton">Close</a><br />
<a id="closebutton2" href="http://wastingtimegames.com" class="closebutton">Close</a><br />
<a id="closebutton3" href="http://theporscheguys.com" class="closebutton">Close</a>
<div id="dialog" title="Cancel">
<p>
<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span> 
Are you sure you want to do that?</p><p>
If you are sure, click Yes.</p><p>If not click No.<p></div>
</body>
</html>