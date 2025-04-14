<?php
class Admin_Block_Ticket_Index_View extends Core_Block_Template
{
    protected $_comments = null;
    public function __construct()
    {
        $this->setTemplate('admin/ticket/index/view.phtml');
    }
    public function getData()
    {
        return Mage::getModel('ticket/ticket')
            ->load($this->getId());
    }
    public function getId()
    {
        return $this->getRequest()->getQuery('id');
    }
    public function getComments()
    {
        // if (!is_array($this->_comments)) {
        // $this->_comments = [];
        return Mage::getModel('ticket/comment')
            ->getCollection()
            ->addFieldToFilter('ticket_id', $this->getId())
            ->orderBy(['node_id'])
            ->getData();
        //     foreach ($comments as $comment) {
        //         array_push($this->_comments, $comment->getData());
        //     }
        // }
        // return $this->_comments;
        // Mage::log($this->_comments);
    }
    public function buildCommentTree()
    {
        $lookup = [];
        foreach ($this->getComments() as $comment) {
            $id = $comment->getCommentId();
            $lookup[$id] = [
                'id' => $id,
                // 'ticket_id' => $comment->getTicketId(),
                'parent_id' => $comment->getParentId(),
                'comment' => $comment->getComment(),
                // 'created_at' => $comment->getCreatedAt(),
                'children' => []
            ];
        }

        $tree = [];
        foreach ($lookup as $id => &$node) {
            $parentId = $node['parent_id'];
            if ($parentId == 0 || $parentId === null || $parentId == "") {
                $tree[] = &$node;
            } else {
                if (isset($lookup[$parentId])) {
                    $lookup[$parentId]['children'][] = &$node;
                }
            }
        }
        return $tree;
    }

    // public function countNodes($node, &$counts)
    // {
    //     $count = 1;
    //     if (!empty($node['children'])) {
    //         foreach ($node['children'] as $child) {
    //             if (empty($node['children'])) {
    //                 return 1;
    //             }
    //             $count += $this->countNodes($child, $counts);
    //         }
    //     }
    //     $counts[$node['id']] = $count - 1;
    //     return $count;
    // }

    // public function buildCounts()
    // {
    //     $data = $this->buildCommentTree();
    //     $counts = [];
    //     foreach ($data as $item) {
    //         $this->countNodes($item, $counts);
    //     }
    //     return $counts;
    // }
}