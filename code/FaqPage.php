<?php
/**
  *	A SiteTree page for faqs
  * 
  * @package advancedfaq
  * @author Nadzweb.com
**/
class FaqPage extends Page {
	
	public static $has_many = array(
		'Faqs' => 'Faq',
		'FaqSections' => 'FaqSection',
		'FaqTags' => 'FaqTag',
	);
	
	/*
	 * Modify the default fields shown to the user
	 */
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
        $configTags = GridFieldConfig_RelationEditor::create();
		$configTags->getComponentByType('GridFieldPaginator')->setItemsPerPage(10);
		if (class_exists('GridFieldSortableRows'))
			$configTags->addComponent(new GridFieldSortableRows('SortOrder'));
		$configTags->getComponentByType('GridFieldAddNewButton')->setButtonName('Add a faq section');
        $configTags->getComponentByType('GridFieldDataColumns')->setDisplayFields(array(
            'Title' => 'Title'
        ));
        $faqSectionsField = new GridField(
            'FaqSections', 
            'FaqSections', 
            $this->FaqSections(),
            $configTags
        );		
        $fields->addFieldToTab('Root.FaqSection', $faqSectionsField);
		
		$config = GridFieldConfig_RelationEditor::create();
		$config->getComponentByType('GridFieldPaginator')->setItemsPerPage(10);
		if (class_exists('GridFieldSortableRows'))
			$config->addComponent(new GridFieldSortableRows('SortOrder'));
		$config->getComponentByType('GridFieldAddNewButton')->setButtonName('Add a faq tag');
		$config->getComponentByType('GridFieldDataColumns')->setDisplayFields(array(
			'Title' => 'Title'
		));
		$faqTagField = new GridField(
			'FaqTags', 
			'FaqTags', 
			$this->FaqTags(),
			$config
		);
	
		$fields->addFieldToTab('Root.FaqTags', $faqTagField);
		
		if(FaqSection::get()->count() > 0 && FaqTag::get()->count() > 0){
			$config = GridFieldConfig_RelationEditor::create();
			$config->getComponentByType('GridFieldPaginator')->setItemsPerPage(10);
			if (class_exists('GridFieldSortableRows'))
				$config->addComponent(new GridFieldSortableRows('SortOrder'));
			$config->getComponentByType('GridFieldAddNewButton')->setButtonName('Add a faq');
			$config->getComponentByType('GridFieldDataColumns')->setDisplayFields(array(
				'Question' => 'Question'
			));
			$faqField = new GridField(
				'Faqs', 
				'Faqs', 
				$this->Faqs(),
				$config
			);
		} else {
			$faqField = new LiteralField('faqError','<p class="message info">You don\'t have faq sections or tags, please create tags in Faq Tag tab and sections in Faq Section tab before adding any faq.</p>');
		}
		
		$fields->addFieldToTab('Root.Faqs', $faqField);
		
		
        return $fields;
	}
	
	/*
	 * Delete versioned objects from a defined stage
	 * @param  object $tags
	 * @param  object $obj 
	 * @param  string $stage
	 * @param  int $pageID 
	 * @return boolean
	 */
	protected function deleteVersionedObjects($tags, $obj, $stage, $pageID) {
		$tagsArray = array();
		$tagsTempArray = array();
		
		if($tags){
			foreach($tags as $tag){
				array_push($tagsArray, $tag->ID);
			}
			$versionedTags = Versioned::get_by_stage($obj, $stage)->filter(array('FaqPageID' => $pageID));
			foreach($versionedTags as $versionedTag) array_push($tagsTempArray, $versionedTag->ID);
			$tagsArrayDiff = array_diff($tagsTempArray,$tagsArray);
			if($tagsArrayDiff){
				foreach($tagsArrayDiff as $key=>$val) {
					$thisTag = Versioned::get_by_stage($obj, $stage)->byID($val);
					if ($thisTag) $thisTag->deleteFromStage($stage);
				}
				return true;
			}
		}
		return false;
	}
	
	/*
	 * Publish faq related dataobjects to both stages and delete any unstaged data
	 * @return parent::doPublish();
	 */
	public function doPublish() {
	
		if($this->FaqSections()) {
			foreach($this->FaqSections() as $field) {
				$field->publish('Stage', 'Live');
			}
			$this->deleteVersionedObjects($this->FaqSections(), 'FaqSection', 'Live', $this->ID);
		}
		
		if($this->FaqTags()) {
			foreach($this->FaqTags() as $field) {
				$field->publish('Stage', 'Live');
			}
			$this->deleteVersionedObjects($this->FaqTags(), 'FaqTag', 'Live', $this->ID);
		}
		
		if($this->Faqs()) {
			foreach($this->Faqs() as $field) {
				$field->publish('Stage', 'Live');
			}
			$this->deleteVersionedObjects($this->Faqs(), 'Faq', 'Live', $this->ID);
		}
		parent::doPublish();
	}
}

class FaqPage_Controller extends Page_Controller {
	
	public function init(){
		Requirements::css("advancedfaq/css/advancedfaq.css", "screen,projection");
	}
	
}