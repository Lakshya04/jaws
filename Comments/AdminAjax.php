<?php
/**
 * Comments AJAX API
 *
 * @category   Ajax
 * @package    Comments
 * @author     Ali Fazelzadeh <afz@php.net>
 * @author     HamidReza Aboutalebi <hamid@aboutalebi.com>
 * @copyright  2012 Jaws Development Group
 * @license    http://www.gnu.org/copyleft/gpl.html
 */
class CommentsAdminAjax extends Jaws_Gadget_Ajax
{
    /**
     * Search for comments and return the data in an array
     *
     * @access  public
     * @param   int     $limit   Data limit
     * @param   string  $filter  Filter
     * @param   string  $search  Search word
     * @param   string  $status  Spam status (approved, waiting, spam)
     * @return  array   Data array
     */
    function SearchComments($limit, $gadget, $filter, $search, $status)
    {
        // TODO: Check Permission For Manage Comments
        $cHTML = $GLOBALS['app']->LoadGadget('Comments', 'AdminHTML');
        return $cHTML->GetDataAsArray($gadget, "javascript: commentEdit(this, '{id}')", $filter, $search, $status, $limit);
    }

    /**
     * Get total posts of a comment search
     *
     * @access  public
     * @param   string  $filter  Filter
     * @param   string  $search  Search word
     * @param   string  $status  Spam status (approved, waiting, spam)
     * @return  int     Total of posts
     */
    function SizeOfCommentsSearch($filter, $search, $status)
    {
        $cModel = $GLOBALS['app']->LoadGadget('Comments', 'AdminModel');
        $filterMode = null;
        switch($filter) {
            case 'postid':
                $filterMode = COMMENT_FILTERBY_REFERENCE;
                break;
            case 'name':
                $filterMode = COMMENT_FILTERBY_NAME;
                break;
            case 'email':
                $filterMode = COMMENT_FILTERBY_EMAIL;
                break;
            case 'url':
                $filterMode = COMMENT_FILTERBY_URL;
                break;
            case 'title':
                $filterMode = COMMENT_FILTERBY_TITLE;
                break;
            case 'ip':
                $filterMode = COMMENT_FILTERBY_IP;
                break;
            case 'comment':
                $filterMode = COMMENT_FILTERBY_MESSAGE;
                break;
            case 'various':
                $filterMode = COMMENT_FILTERBY_VARIOUS;
                break;
            case 'status':
                $filterMode = COMMENT_FILTERBY_STATUS;
                break;
            default:
                $filterMode = null;
                break;
        }
        return $cModel->HowManyFilteredComments($this->name, $filterMode, $search, $status, false);
    }

    /**
     * Get information of a Comment
     *
     * @access  public
     * @param   int     $id     Comment ID
     * @return  array   Comment info array
     */
    function GetComment($gadget, $id)
    {
        $comment = $this->_Model->GetComment($gadget, $id);
        if (Jaws_Error::IsError($comment)) {
            return false; //we need to handle errors on ajax
        }
        return $comment;
    }

    /**
     * Update comment information
     *
     * @access  public
     * @param   int     $id         Comment ID
     * @param   string  $name       Name
     * @param   string  $email      Email address
     * @param   string  $url
     * @param   string  $subject    Subject of message
     * @param   string  $message    Message content
     * @return  array   Response array (notice or error)
     */
    function UpdateComment($gadget, $id, $name, $email, $url, $subject, $message, $status)
    {
        // TODO: Check Permission For Manage Comments
        // TODO: Fill permalink In New Versions, Please!!
        $this->_Model->UpdateComment($gadget, $id, $name, $email, $url, $subject, $message, '', $status);
        return $GLOBALS['app']->Session->PopLastResponse();
    }

    /**
     * Does a massive delete on comments
     *
     * @access  public
     * @param   array   $ids     Comment ids
     * @return  array   Response array (notice or error)
     */
    function DeleteComments($ids)
    {
        // TODO: Check Permission For Manage Comments
        $this->_Model->MassiveCommentDelete($ids);
        return $GLOBALS['app']->Session->PopLastResponse();
    }
}