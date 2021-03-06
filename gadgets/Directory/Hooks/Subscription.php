<?php
/**
 * Directory gadget hook
 *
 * @category    GadgetHook
 * @package     Directory
 */
class Directory_Hooks_Subscription extends Jaws_Gadget_Hook
{
    /**
     * Returns available subscription items
     *
     * @access  public
     * @return array An array of subscription
     */
    function Execute()
    {
        $items = array();

        $items[] = array(
            'action'=>'type',
            'reference' => Directory_Info::FILE_TYPE_TEXT,
            'title' => _t('DIRECTORY_FILE_TYPE_TEXT'),
            'url' => $this->gadget->urlMap('Directory', array('type' => Directory_Info::FILE_TYPE_TEXT), true),
        );

        $items[] = array(
            'action'=>'type',
            'reference' => Directory_Info::FILE_TYPE_IMAGE,
            'title' => _t('DIRECTORY_FILE_TYPE_IMAGE'),
            'url' => $this->gadget->urlMap('Directory', array('type' => Directory_Info::FILE_TYPE_IMAGE), true),
        );

        $items[] = array(
            'action'=>'type',
            'reference' => Directory_Info::FILE_TYPE_AUDIO,
            'title' => _t('DIRECTORY_FILE_TYPE_AUDIO'),
            'url' => $this->gadget->urlMap('Directory', array('type' => Directory_Info::FILE_TYPE_AUDIO), true),
        );

        $items[] = array(
            'action'=>'type',
            'reference' => Directory_Info::FILE_TYPE_VIDEO,
            'title' => _t('DIRECTORY_FILE_TYPE_VIDEO'),
            'url' => $this->gadget->urlMap('Directory', array('type' => Directory_Info::FILE_TYPE_VIDEO), true),
        );

        $items[] = array(
            'action'=>'type',
            'reference' => Directory_Info::FILE_TYPE_ARCHIVE,
            'title' => _t('DIRECTORY_FILE_TYPE_ARCHIVE'),
            'url' => $this->gadget->urlMap('Directory', array('type' => Directory_Info::FILE_TYPE_ARCHIVE), true),
        );

        $items[] = array(
            'action'=>'type',
            'reference' => Directory_Info::FILE_TYPE_UNKNOWN,
            'title' => _t('DIRECTORY_FILE_TYPE_OTHER'),
            'url' => $this->gadget->urlMap('Directory', array('type' => Directory_Info::FILE_TYPE_UNKNOWN), true),
        );

        return $items;
    }

}