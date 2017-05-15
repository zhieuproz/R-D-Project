<?php

class GMWDModelOptions_gmwd extends GMWDModel {
	////////////////////////////////////////////////////////////////////////////////////////
	// Events                                                                             //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Constants                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Variables                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Constructor & Destructor                                                           //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Public Methods                                                                     //
	////////////////////////////////////////////////////////////////////////////////////////
	public function get_options(){
		global $wpdb;
  
        $query = "SELECT * FROM ". $wpdb->prefix . "gmwd_options ";
		$rows = $wpdb->get_results($query);	

        $options = new stdClass();
        foreach ($rows as $row) {
            $name = $row->name;
            $value = $row->value !== "" ? $row->value : $row->default_value;
            $options->$name = $value;
        }
	
        return $options;

	}
	
	public function get_lists(){
		$lists = array();
		$map_languages_list = array(""=>"Location Base", "ar"=>"Arabic", "bg"=>"Bulgarian", "bn"=>"Bengali", "ca"=>"Catalan", "cs"=>"Czech", "da"=>"Danish", "de"=>"German", "el"=>"Greek", "en"=>"English", "en-AU"=>"English (Australian)", "en-GB"=>"English (Great Britain)", "es"=>"Spanish", "eu"=>"Basque", "fa"=>"Farsi", "fi"=>"Finnish", "fil"=>"Filipino", "fr"=>"French", "gl"=>"Galician", "gu"=>"Gujarati", "hi"=>"Hindi", "hr"=>"Croatian", "hu"=>"Hungarian", "id"=>"Indonesian", "it"=>"Italian", "iw"=>"Hebrew", "ja"=>"Japanese", "kn"=>"Kannada", "ko"=>"Korean", "lt"=>"Lithuanian", "lv"=>"Latvian", "ml"=>"Malayalam", "mr"=>"Marathi", "nl"=>"Dutch", "no"=>"Norwegian", "pl"=>"Polish", "pt"=>"Portuguese", "pt-BR"=>"Portuguese (Brazil)", "pt-PT"=>"Portuguese (Portugal)", "ro"=>"Romanian", "ru"=>"Russian", "sk"=>"Slovak", "sl"=>"Slovenian", "sr"=>"Serbian", "sv"=>"Swedish", "ta"=>"Tamil", "te"=>"Telugu", "th"=>"Thai", "tl"=>"Tagalog", "tr"=>"Turkish", "uk"=>"Ukrainian", "vi"=>"Vietnamese", "zh-CN"=>"Chinese (Simplified)", "zh-TW"=>"Chinese (Traditional)");	
		
		$lists["map_languages"] = $map_languages_list;
		
		return $lists;
	}
	////////////////////////////////////////////////////////////////////////////////////////
	// Getters & Setters                                                                  //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Private Methods                                                                    //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Listeners                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
}