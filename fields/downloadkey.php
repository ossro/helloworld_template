<?php

defined('_JEXEC') or die();

jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('text');

// This allows us to include the same file in more of our
// premium extensions that require a download key,
// without the need to create a custom field type name for each
if (\class_exists('JFormFieldUpdaterCloud_DownloadKey')) {
    return;
}

class JFormFieldUpdaterCloud_DownloadKey extends JFormFieldText
{
    // The form field type must be declared in the $type variable
    protected $type = 'updatercloud_downloadkey';

    public function getInput()
    {
        if ($this->value) {
            $extra_query = "'{$this->element['name']}={$this->value}'";

            $db = JFactory::getDbo();

            $query = $db
                ->getQuery(true)
                ->update('#__update_sites')
                ->set('extra_query = ' . $extra_query)
                ->where('name = "' . $this->element['server'] . '"');

            $db->setQuery($query);
            $db->execute();
        }

        // return the form field HTML
        return parent::getInput();
    }
}
