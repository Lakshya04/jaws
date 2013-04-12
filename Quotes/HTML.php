<?php
/**
 * Quotes Gadget
 *
 * @category   Gadget
 * @package    Quotes
 * @author     Ali Fazelzadeh <afz@php.net>
 * @copyright  2007-2013 Jaws Development Group
 * @license    http://www.gnu.org/copyleft/gpl.html
 */
class Quotes_HTML extends Jaws_Gadget_HTML
{
    /**
     * Calls default action(display)
     *
     * @access       public
     * @return       template content
     */
    function DefaultAction()
    {
        $layoutGadget = $GLOBALS['app']->LoadGadget('Quotes', 'LayoutHTML');
        return $layoutGadget->RecentQuotes();
    }

    /**
     * Print the recent quotes
     *
     * @access  public
     * @return  XHTML template content
     */
    function RecentQuotes()
    {
        $layoutGadget = $GLOBALS['app']->LoadGadget('Quotes', 'LayoutHTML');
        return $layoutGadget->RecentQuotes();
    }

    /**
     * Displays quotes by group
     *
     * @access  public
     * @return  XHTML template content
     */
    function ViewGroupQuotes()
    {
        $request =& Jaws_Request::getInstance();
        $gid = $request->get('id', 'get');
        $layoutGadget = $GLOBALS['app']->LoadGadget('Quotes', 'LayoutHTML');
        return $layoutGadget->Display($gid);
    }

    /**
     * Displays quotes by group in standalone mode
     *
     * @access  public
     * @return  XHTML template content
     */
    function QuotesByGroup()
    {
        header(Jaws_XSS::filter($_SERVER['SERVER_PROTOCOL'])." 200 OK");
        return $this->ViewGroupQuotes();
    }

    /**
     * view quote(title and quotation)
     *
     * @access  public
     * @return  string
     */
    function ViewQuote()
    {
        $request =& Jaws_Request::getInstance();
        $qid = $request->get('id', 'get');
        $model = $GLOBALS['app']->LoadGadget('Quotes', 'Model');
        $quote = $model->GetQuote($qid);
        if (Jaws_Error::IsError($quote) || !isset($quote['id']) || !$quote['published']) {
            return '';
        }
        $group = $model->GetGroup($quote['gid']);
        if (Jaws_Error::IsError($group) || !isset($group['id']) || !$group['published']) {
            return '';
        }

        $this->SetTitle($quote['title']);
        $tpl = new Jaws_Template('gadgets/Quotes/templates/');
        $tpl->Load('Quote.html');
        $tpl->SetBlock('quote');

        $tpl->SetVariable('title', $group['title']);
        $tpl->SetVariable('quote_title', $quote['title']);
        $tpl->SetVariable('quotation', $this->gadget->ParseText($quote['quotation']));

        $tpl->ParseBlock('quote');
        return $tpl->Get();
    }

}