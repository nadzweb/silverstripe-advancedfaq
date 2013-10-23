# Advanced Faq module #
The advancedfaq module allows you to add faqs on your SilverStripe website. Each faq object can have multiple faq-tags and one faq-section attached to it. All dataobjects, Faq, FaqTag and FaqSection are versioned by default.

## Installation ##
* Download the module from here https://github.com/nadzweb/silverstripe-advancedfaq/archive/master.zip
* Extract the downloaded archive into your site root and rename the module to 'advancedfaq'.
* Run dev/build?flush=all to regenerate the manifest
* Upon entering the cms and using advancedfaq for the first time you make need to add ?flush=all to the end of the address to force the templates to regenerate

## Usage
* Create a new page of type, FaqPage
* Once page is created, you will see the tabs; 'Faq Section', 'Faq Tags' and 'Faq'.
* Create faq sections and faq tags before creating any faq.
* A Faq object can have one section and multiple tags
* All dataobjects are versioned by default, publish the page to view it from outside, otherwise view it in draft site.
*
* Sample output of advanced faq page
![Alt text](https://raw.github.com/nadzweb/silverstripe-advancedfaq/master/docs/sample-page.png "An advanced faq page")

