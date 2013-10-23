<?php
/**
 * Represents a single faq tag object.
 * 
 * @package advancedfaq
 */
class FaqTag extends DataObject {

	private static $db = array(
		'Title' => 'Varchar(100)',
		'SortOrder'=>'Int'
	);
	
	public static $default_sort='SortOrder';
	
	private static $has_one = array(
        'FaqPage' => 'FaqPage'
    );
	
	private static $extensions = array(
		"Versioned('Stage', 'Live')"
	);
	
	private static $summary_fields = array(
		'Title'
	);	
	
	private static $belongs_many_many = array(
		'Faqs' => 'Faq'
	);
	
	/*
	 * Modify the default fields shown to the user
	 */
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Main', new TextField('Title'));
		$fields->removeByName('FaqPageID');
		$fields->removeByName('Faqs');
		$fields->removeByName('SortOrder');
		return $fields;
	}
	
	/** allow all users for crud operations **/
	public function canView($member = null) {
		return true;
	}
	public function canEdit($member = null) {
		return true;
	}
	public function canDelete($member = null) {
		return true;
	}
	public function canCreate($member = null) {
		return true;
	}
}