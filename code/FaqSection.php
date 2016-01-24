<?php
/**
 * Represents a single faq section object.
 * 
 * @package advancedfaq
 */

class FaqSection extends DataObject
{

    private static $db = array(
        'Title' => 'Varchar(100)',
        'SortOrder'=>'Int'
    );
    
    public static $default_sort='SortOrder';
    
    private static $has_one = array(
        'FaqPage' => 'FaqPage'
    );
    
    private static $has_many = array(
        'Faqs' => 'Faq'
    );
    
    private static $extensions = array(
        "Versioned('Stage', 'Live')"
    );
    
    private static $summary_fields = array(
        'Title'
    );
    
    /*
     * Modify the default fields shown to the user
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', new TextField('Title'));
        $fields->removeByName('FaqPageID');
        $fields->removeByName('Faqs');
        $fields->removeByName('SortOrder');
        return $fields;
    }
    
    /** allow all users for crud operations **/
    public function canView($member = null)
    {
        return true;
    }
    public function canEdit($member = null)
    {
        return true;
    }
    public function canDelete($member = null)
    {
        return true;
    }
    public function canCreate($member = null)
    {
        return true;
    }
}
