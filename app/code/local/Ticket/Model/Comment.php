<?php
class Ticket_Model_Comment extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName = 'Ticket_Model_Resource_Comment';
        $this->_collectionClass = 'Ticket_Model_Resource_Comment_Collection';
    }
    // protected function _afterSave()
    // {
    //     $comment_id = $this->getCommentId();
    //     Mage::log($this);
    //     // die;
    //     $this->load($comment_id);
    //     $totalChild = Mage::getModel('ticket/comment')
    //         ->getCollection()
    //         ->addFieldToFilter('parent_id', $this->getParentId())
    //         ->addFieldToFilter('is_active', 1)
    //         ->select(['COUNT(*)' => 'total'])
    //         ->getFirstItem();
    //     // Mage::log($this);
    //     if ($totalChild->getTotal() == 0) {
    //         Mage::getModel('ticket/comment')
    //             ->setCommentId($this->getParentId())
    //             ->setIsActive(0)
    //             ->save();
    //     }
    // }
}
