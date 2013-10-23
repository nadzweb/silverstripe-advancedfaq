<?php
/**
 * Represents a single faq object.
 * 
 * @package advancedfaq
 */
class Faq extends DataObject {

	private static $db = array(
		'Question' => 'Text',
		'Answer' => 'HTMLText',
		'SortOrder'=>'Int'
	);
	
	public static $default_sort='SortOrder';
	
	private static $has_one = array(
        'FaqPage' => 'FaqPage',
		'FaqSection' => 'FaqSection',
    );
	
	private static $many_many = array(
		'FaqTags' => 'FaqTag'
	);
		
	private static $extensions = array(
		"Versioned('Stage', 'Live')"
	);
	
	private static $summary_fields = array(
		'Question', 'Answer'
	);
	
	private static $searchable_fields = array(
		'Question', 'Answer'
	);
	
	/*
	 * Modify the default fields shown to the user
	 */
	public function getCMSFields() {
		$fields = parent::getCMSFields();  
		$fields->removeByName('FaqPageID');
		$fields->removeByName('FaqTags');
		$fields->removeByName('SortOrder');
		
		$fields->addFieldToTab('Root.Main', new TextField('Question', 'Question'));		
		$fields->addFieldToTab('Root.Main', new HtmlEditorField('Answer', 'Answer'));
		
		// faq section - has_one relation
		$map = FaqSection::get()
			->sort('Title')
			->map('ID', 'Title');
		$field = new DropdownField('FaqSectionID', 'Faq section', $map);
		$field->setEmptyString('None');
		$fields->addFieldToTab('Root.Main', $field, 'Question');
		
		// faq tags - has_many relation
		$tagMap = FaqTag::get()
			->sort('Title')
			->map('ID', 'Title')
			->toArray();
		$tagsField = new ListboxField('FaqTags', 'Faq tags');
		$tagsField->setMultiple(true)->setSource($tagMap);
		$fields->addFieldToTab( 'Root.Main', $tagsField, 'Question' );
		
		return $fields;
	}
	
	public function getTitle(){
		return $this->Question;
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