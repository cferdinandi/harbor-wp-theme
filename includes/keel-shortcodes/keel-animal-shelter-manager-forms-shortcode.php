<?php

	/**
	 * Add a shortcode for Animal Shelter Manager forms
	 * @link http://sheltermanager.com/
	 * @link http://stackoverflow.com/questions/10921457/php-retrieve-inner-html-as-string-from-url-using-domdocument
	 * @link http://stackoverflow.com/questions/2087103/how-to-get-innerhtml-of-domnode
	 */

	function keel_asm_forms_shortcode( $atts ) {

		// Check that feature is activated
		$dev_options = keel_developer_options();
		if ( !$dev_options['asm_forms_shortcode'] ) return '';

		// Get user options
		$asm = shortcode_atts(array(
			'url'  => '',
			'submit' => 'Submit',
			'submit_class' => 'btn'
		), $atts);

		// Bail if no link
		if ( empty( $asm['url'] ) ) return;

		// Get the form
		$dom = new DOMDocument();
		$dom->loadHTMLFile( $asm['url'] );
		$data = $dom->getElementsByTagName( 'form' );
		$form = $data[0]->ownerDocument->saveHTML($data[0]);

		// Clean up the default markup for Harbor

		$find = array(
			'<table class="asm-onlineform-table">',
			'</table>',
			'<tbody>',
			'</tbody>',
			'<span class="asm-onlineform-required" style="color: #ff0000;">*</span>',
			'<span class="asm-onlineform-notrequired" style="visibility: hidden">*</span>',
			'<tr class="asm-onlineform-tr">',
			'</tr>',
			'<label ',
			'<input class=',
			'<select class=',
			'<td class="asm-onlineform-td" colspan="2">',
			'<td class="asm-onlineform-td">',
			'</td>',
			'<p style="text-align: center"><input type="submit" value="Submit"></p>',
		);

		$replace = array(
			'', // <table>
			'', // </table>
			'', // <tbody>
			'', // </tbody>
			'', // *
			'', // *
			'<div class="row">', // <tr>
			'</div>', // </tr>
			'<div class="grid-third"><label ', // <label>
			'<div class="grid-two-thirds"><input class=', // <input>
			'<div class="grid-two-thirds"><select class=', // <select>
			'<div class="grid-full">', // <td colspan="2">
			'', // <td>
			'</div>', // </td
			'<div class="row"><div class="grid-two-thirds offset-third"><button class="' . $asm['submit_class'] . '">' . $asm['submit'] . '</button></div></div>', // submit
		);

		$form = str_replace( $find, $replace, $form );
		$form = preg_replace( '#<select class="asm-onlineform-yesno" name="(.*?)"(.*?)>(.*?)<\/select>#is', '<radiogroup><label><input type="radio" name="$1" value="Yes" $2> Yes</label><label><input type="radio" name="$1" value="No" $2> No</label></radiogroup>', $form );
		$form = preg_replace( '#<input class="asm-onlineform-text" type="text" name="(.*?)email(.*?)"(.*?)>#is', '<input type="email" name="$1email$2" $3>', $form );

		return $form;

	}
	add_shortcode( 'asm_forms', 'keel_asm_forms_shortcode' );