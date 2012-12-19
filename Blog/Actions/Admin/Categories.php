<?php
/**
 * Blog Admin HTML file
 *
 * @category   GadgetAdmin
 * @package    Blog
 * @author     Jonathan Hernandez <ion@suavizado.com>
 * @author     Pablo Fischer <pablo@pablo.com.mx>
 * @author     Ali Fazelzadeh <afz@php.net>
 * @copyright  2004-2012 Jaws Development Group
 * @license    http://www.gnu.org/copyleft/gpl.html
 */
class Blog_Actions_Admin_Categories extends BlogAdminHTML
{
    /**
     * Displays blog categories manager
     *
     * @access  public
     * @param   string  $second_action      
     * @return  string  XHTML template content
     */
    function ManageCategories($second_action = '')
    {
        $this->CheckPermission('ManageCategories');
        $this->AjaxMe('script.js');

        $tpl = new Jaws_Template('gadgets/Blog/templates/');
        $tpl->Load('ManageCategories.html');
        $tpl->SetBlock('categories');

        // Menubar
        $tpl->SetVariable('menubar', $this->MenuBar('ManageCategories'));
        $tpl->SetVariable('categories', _t('BLOG_CATEGORIES'));

        $model = $GLOBALS['app']->LoadGadget('Blog', 'AdminModel');
        $categories = $model->GetCategories();
        $combo =& Piwi::CreateWidget('Combo', 'category_id');
        $combo->SetID('category_id');
        $combo->SetStyle('width: 100%; margin-bottom: 10px;');
        $combo->SetSize(18);
        $combo->AddEvent(ON_CHANGE, 'editCategory(this.value)');
        foreach($categories as $cat) {
            $combo->AddOption($cat['name'], $cat['id']);
        }
        $tpl->SetVariable('combo', $combo->Get());

        // Category form
        $catName =& Piwi::CreateWidget('Entry', 'name', '');
        $catName->setStyle('width: 300px;');
        $tpl->SetVariable('lbl_name', _t('BLOG_CATEGORY'));
        $tpl->SetVariable('name', $catName->Get());

        $catFastURL =& Piwi::CreateWidget('Entry', 'fast_url', '');
        $catFastURL->setStyle('width: 300px;');
        $tpl->SetVariable('lbl_fast_url', _t('BLOG_FASTURL'));
        $tpl->SetVariable('fast_url', $catFastURL->Get());

        $metaKeywords =& Piwi::CreateWidget('Entry', 'meta_keywords', '');
        $metaKeywords->setStyle('width: 300px;');
        $tpl->SetVariable('lbl_meta_keywords', _t('GLOBAL_META_KEYWORDS'));
        $tpl->SetVariable('meta_keywords', $metaKeywords->Get());

        $metaDesc =& Piwi::CreateWidget('Entry', 'meta_desc', '');
        $metaDesc->setStyle('width: 300px;');
        $tpl->SetVariable('lbl_meta_desc', _t('GLOBAL_META_DESCRIPTION'));
        $tpl->SetVariable('meta_desc', $metaDesc->Get());

        $catDescription =& Piwi::CreateWidget('TextArea', 'description', '');
        $catDescription->setStyle('width: 300px;');
        $tpl->SetVariable('lbl_description', _t('GLOBAL_DESCRIPTION'));
        $tpl->SetVariable('description', $catDescription->Get());

        $btnDelete =& Piwi::CreateWidget('Button', 'btn_delete', _t('GLOBAL_DELETE'), STOCK_DELETE);
        $btnDelete->AddEvent(ON_CLICK, 'javascript:deleteCategory();');
        $tpl->SetVariable('btn_delete', $btnDelete->Get());

        $btnCancel =& Piwi::CreateWidget('Button', 'btn_cancel', _t('GLOBAL_CANCEL'), STOCK_CANCEL);
        $btnCancel->AddEvent(ON_CLICK, 'javascript: stopAction();');
        $tpl->SetVariable('btn_cancel', $btnCancel->Get());

        $btnSave =& Piwi::CreateWidget('Button', 'btn_save',_t('GLOBAL_SAVE'), STOCK_SAVE);
        $btnSave->AddEvent(ON_CLICK, 'javascript: saveCategory(this.form);');
        $tpl->SetVariable('btn_save', $btnSave->Get());

        $tpl->SetVariable('delete_message',_t('BLOG_DELETE_CONFIRM_CATEGORY'));
        $tpl->ParseBlock('categories');
        return $tpl->Get();
    }

    /**
     * Adds the given category to blog
     *
     * @access  public
     */
    function AddCategory()
    {
        $request =& Jaws_Request::getInstance();

        $this->CheckPermission('ManageCategories');
        $model = $GLOBALS['app']->LoadGadget('Blog', 'AdminModel');
        $model->NewCategory($request->get('catname', 'post'));

        Jaws_Header::Location(BASE_SCRIPT . '?gadget=Blog&action=ManageCategories');
    }

    /**
     * Updates a blog category name
     *
     * @access  public
     */
    function UpdateCategory()
    {
        $request =& Jaws_Request::getInstance();
        $post    = $request->get(array('catid', 'catname'), 'post');

        $this->CheckPermission('ManageCategories');
        $model = $GLOBALS['app']->LoadGadget('Blog', 'AdminModel');
        $model->UpdateCategory($post['catid'], $post['catname']);

        Jaws_Header::Location(BASE_SCRIPT . '?gadget=Blog&action=EditCategory&id=' . $post['catid']);
    }

    /**
     * Deletes the given blog category
     *
     * @access  public
     */
    function DeleteCategory()
    {
        $request =& Jaws_Request::getInstance();

        $this->CheckPermission('ManageCategories');
        $model = $GLOBALS['app']->LoadGadget('Blog', 'AdminModel');
        $model->DeleteCategory($request->get('catid', 'post'));

        Jaws_Header::Location(BASE_SCRIPT . '?gadget=Blog&action=ManageCategories');
    }

}