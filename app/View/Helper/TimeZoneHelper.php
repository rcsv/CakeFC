<?php
/**
 * An implementation of Timezone helper design patterns.
 * 
 * references:
 * 1. List of Supported Timezones :: php manual
 *    http://www.php.net/manual/en/timezones.php
 * 2. Time and date.com
 *    http://www.timeanddate.com/time/map/
 * 3. Applying multi-locale support in php
 *    http://labs.cybridge.jp/2012/01/kon.html
 * 4. Updated: Timezone helper, The Bakery
 *    http://bakery.cakephp.org/articles/MarkAlanEvans/2009/12/17/updated-timezone-helper
 * 5. User timezone Design patterns and timezones with a helper DST Support
 *    http://bakery.cakephp.org/articles/view/4cf6821a-d128-4c67-946c-4401d13e7814/lang:deu
 * 6. Cakephp Timezones
 *    http://jdbartlett.com/2009/08/27/cakephp-time-zones/
 */
class TimeZoneHelper extends AppHelper {

	public $helpers = array('Form');

	/// implemented methods
	public function select($fieldname, $options=array()){
		$options = array_merge(array(
			'options' => $this->timezones,
			'type' => 'select',
			'label' => 'Please choose a timezone',
			'error' => 'Please choose a timezone'
		),$options);
		return $this->output($this->Form->input($fieldname,$options));
	}

	public function display($index) {
		return $this->output($this->timezones[$index]);
	}

	/**
	 * timezones array
	 */
	///@formatter:off
	var $timezones = array(
		// adjust negative
		// --- GMT -12:00
		'Pacific/Kwajalein'		=> '-12 Marshall Islands Time (MHT), Eniwetok, Kwajalein, Majuro',
		// write config if -12+DST area exists.

		// --- GMT -11:00
		'Pacific/Midway'		=> '-11 Samoa Standard Time (SST), Samoa, Midway',
		// -11+DST

		// --- GMT -10:00
		'Pacific/Honolulu'		=> '-10 Hawaii-Aleutian Standard Time (HAST), Honolulu',
		'Pacific/Adak'			=> '-10+DST Hawaii-Aleutian Daylight Time (HADT), Adak, Alaska',

		// --- GMT -09:00
		// AKST change AKDT during the summer in any case.
		'America/Anchorage'		=> '-09+DST Alaska Daylight Time (AKDT), Anchorage',

		// --- GMT -08:00
		'Pacific/Pitcairn'		=> '-08 Pitcairn Standard Time (PST), Pitcairn Islands',
		'America/Los_Angeles'	=> '-08+DST Pacific Daylight Time (PDT), ',

		// --- GMT -07:00
		'America/Phoenix'		=> '-07 Mountain Standard Time (MST), Arizona, Phoenix',
		'America/Denver'		=> '-07+DST Mountain Daylight Time (MDT), Denver',

		// --- GMT -06:00
		'Canada/Saskatchewan'	=> '-06 Central Standard Time (Canada), Saskatchewan',
		'America/Tegucigalpa'	=> '-06+DST Central Daylight Time (US & Canada), Mexico City',

		// --- GMT -05:00
		'America/Lima'			=> '-05 Peru Time (PET) Quito, Lima',
		'America/New_York'		=> '-05+DST Eastern Daylight Time (EDT), New York',

		// --- GMT -04:30
		'America/Caracas'		=> '-04:30 Venezuelan Standard Time (VET), Caracas',
		// cannot find -04:30+DST

		// --- GMT -04:00
		// Quebec - East of 63 West only. http://www.timeanddate.com/library/abbreviations/timezones/na/ast.html 
		'Canada/Atlantic'		=> '-04 Atlantic Standard Time (AST), Quebec', 
		'America/Halifax'		=> '-04+DST Atlantic Daylight Time (ADT), Halifax',

		// --- GMT -03:30
		// Newfoundland Standard time must change NDT during the summer.
		'America/St_Johns'		=> '-03:30+DST Newfoundland Daylight Time (NDT), Newfoundland',
		// cannot find -03:30+DST

		// --- GMT -03:00
		'America/Argentina/Buenos_Aires' => '-03 Argentina Time (ART), Brazil, Buenos Aires, Georgetown',
		'America/Montevideo' 	=> '-03+DST Uruguay Summer Time (UYT) Montevideo',

		// --- GMT -02:30 St. Johns Summertime.
		
		// --- GMT -02:00
		'America/Noronha'		=> '-02 Fernando de Noronha Time (FNT), Noronha, Mid-Atlantic',
		// cannot find -02+DST

		// --- GMT -01:00
		'Atlantic/Azores'		=> 'Azores, Cape Verde Islands',

		// --- GMT +-0
		'Europe/Dublin'			=> 'Western Europe Time, London',

		// adjust positive
		// --- GMT +01:00
		'Europe/Belgrade'		=> 'Central Europe Time(CET), Brussels',

		// --- GMT +02:00
		'Europe/Minsk'			=> 'Eastern Europe Time(EET), South Africa',

		// --- GMT +03:00
		'Asia/Kuwait'			=> 'Baghdad, Kuwait, Riyadh, Moscow',

		// --- GMT +03:30
		'Asia/Tehran'			=> 'Tehran',

		// --- GMT +04:00
		'Asia/Muscat'			=> '+04 Abu Dhabi, Muscat, Baku, Tbilisi',

		// --- GMT +04:30
		'Asia/Kabul' 			=> '+04:30 Kabul',

		// --- GMT +05:00
		'Asia/Ashkhabad'		=> '+05 Ashkhabad',

		// --- GMT +05:30
		'Asia/Kolkata'			=> '+05:30 Delhi, Kolkata, Bangaroe',

		// --- GMT +06:00
		'Asia/Yekaterinburg'	=> '+06 Ekaterinburg, Islamabad, Karachi, Tashkent',

		// --- GMT +07:00
		'Asia/Singapore'		=> '+07 Singapore, Bangkok, Novosibirsk',

		// --- GMT +08:00
		'Asia/Hong_Kong'		=> '+08 Australian Western Standard Time (AWST), Norilsk, Hong Kong,',
		// cannot find +08+DST.

		// --- GMT +08:45
		'Australia/Eucla'		=> '+08:45 Australian Central Western Standard Time (CWST), Eucla',

		// --- GMT +09:00
		'Asia/Tokyo'			=> '+09 Japanese Standard Time(JST), Queensland, Yakutsk',
		'Australia/Sydney'		=> '+09+DST Australian Eastern Daylight Time (AEDT), Sydney',

		// --- GMT +09:30
		'Australia/ACT'			=> '+09:30 Australian Central Standard Time (ACST)',
		// ACST doesn't change summertime.

		// --- GMT +10:00
		'Australia/Sydney'		=> '+10 Australian Eastern Standard Time (AEST)',

		// --- GMT +11:00
		'Asia/Sakhalin'			=> '+11 Yuzhno-Sakhalinsk, Solomon Islands, New Caledonia',

		// --- GMT +12:00
		'Pacific/Fiji'			=> '+12 Fiji Time (FJT), Fiji, Magadan Kamchatka', 

		// --- GMT +13:00
		'Pacific/Tongatapu'		=> '+13 Tonga Time (TOT), Tongatapu, Nukualofa, Tonga',

		// --- GMT +14:00
		'Pacific/Kiritimati'	=> '+14 Line Islands Time (LINT), Kiribati'
	);
	///@formatter:on
	
}
