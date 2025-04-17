<?php
class Admin_Block_Ticket_Index_View extends Core_Block_Template
{
    protected $_arr = [];
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
        $limit = $this->getRequest()->getQuery('limit');
        $comment = Mage::getModel('ticket/comment')
            ->getCollection()
            ->addFieldToFilter('ticket_id', $this->getId());
        if ($limit != '') {
            $max = Mage::getModel('ticket/comment')
                ->getCollection()
                ->addFieldToFilter('ticket_id', $this->getId())
                ->select(['MAX(level)' => "maximum"])
                ->getFirstItem()
                ->getMaximum();
            $comment->addFieldToFilter('level', ['>' => $max - $limit]);
        }
        $fleg = $this->getRequest()->getQuery('showcompleted');
        if (!($fleg == 'true')) {
            $comment->addFieldToFilter('is_active', 1);
        }
        return $comment;
    }
    public function getCommentTitle($id)
    {
        return $this->getComments()
            ->addFieldToFilter('comment_id', $id)
            ->getFirstItem();
    }
    public function dataArray($id)
    {
        $data = $this->getComments()->addFieldToFilter('parent_id', $id)->getData();
        if (!$data) {
            $this->_arr[$id] = [];
            return;
        }
        foreach ($data as $d) {
            $this->_arr[$id][] = $d->getCommentId();
            $this->dataArray($d->getCommentId());
        }
    }

    function buildTree($parentId = 0)
    {
        $tree = [];
        if (isset($this->_arr[$parentId])) {
            foreach ($this->_arr[$parentId] as $id) {
                $node = [
                    'id' => $id,
                    'children' => $this->buildTree($id)
                ];
                $tree[] = $node;
            }
        }
        return $tree;
    }
    function getPaths($tree, $path = [], &$rows = [], &$rowspans = [])
    {
        foreach ($tree as $t) {
            $currpath = array_merge($path, [$t['id']]);
            // Mage::log($currpath);
            if (empty($t['children'])) {
                $rows[] = $currpath;
            } else {
                $countBefore = count($rows);
                $this->getPaths($t['children'], $currpath, $rows, $rowspans);
                $temp = count($rows) - $countBefore;
                $level = count($path);
                // Mage::log($path);
                // Mage::log($temp);
                $rowspans[$level][$t['id']] = $temp;
            }
        }
    }
    function getMinimulLevel()
    {
        $ids = [];
        $minimum = $this->getComments()
            ->select(['MIN(level)' => "minimum"])
            ->getFirstItem()
            ->getMinimum();
        // Mage::log($minimum);
        $comments = $this->getComments()
            ->addFieldToFilter('level', $minimum)
            ->getData();
        foreach ($comments as $comment) {
            array_push($ids, $comment->getCommentId());
        }
        return $ids;
    }
    public function getMaximumLevel()
    {
        return $this->getComments()
            ->select(['MAX(level)' => "maximum"])
            ->getFirstItem()
            ->getMaximum();
    }
    function render()
    {
        $ids = $this->getMinimulLevel();
        foreach ($ids as $id) {
            $this->_arr[0][] = $id;
            $this->dataArray($id);
        }
        $tree = $this->buildTree();
        // Mage::log($this->_arr);
        $ticket = $this->getData()->getTitle();
        $rows = [];
        $rowspans = [];
        $html = '';
        $this->getPaths($tree, [], $rows, $rowspans);
        // Mage::log($rows);
        // Mage::log($rowspans);
        if (!empty($rowspans)) {
            $last = max(array_keys($rowspans)) + 1;
        } else {
            $last = 0;
        }
        $totalRows = count($rows);
        if ($totalRows == 0) {
            $totalRows = 1;
        }
        $html = '<table border="1">';
        $html .= '<tr>';
        $html .= "<td rowspan='$totalRows'>";
        $html .= $ticket;
        $html .= '</td>';
        if (!empty($rows)) {
            foreach ($rows[0] as $key => $val) {
                $span = isset($rowspans[$key][$val]) ? $rowspans[$key][$val] : 1;
                $html .= sprintf(
                    "<td class='%s' rowspan='%s' data-complete-id=%s>%s",
                    ($this->getCommentTitle($val)->getIsActive()) ? "" : "bg-success",
                    $span,
                    $val,
                    $this->getCommentTitle($val)->getComment()
                );
                if ($key == $last && $this->getCommentTitle($val)->getIsActive()) {
                    $html .= "<button onclick='complete(this)' class='bg-success'>Complete</button></td>";
                    $html .= "<td data-node-id={$val}><button onclick='openTextbox(this)'>add comment</button></td>";
                } else {
                    $html .= '</td>';
                }
                $printed[$key][$val] = true;
            }
        } else {
            $html .= "<td data-node-id=0><button onclick='openTextbox(this)'>add comment</button></td>";
        }
        // Mage::log($printed);
        $html .= '</tr>';
        // echo $totalRows;
        for ($i = 1; $i < $totalRows; $i++) {
            $html .= '<tr>';
            foreach ($rows[$i] as $key => $val) {
                if (!isset($printed[$key][$val])) {
                    $span = isset($rowspans[$key][$val]) ? $rowspans[$key][$val] : 1;
                    // Mage::log($val);
                    $html .= sprintf(
                        "<td class='%s' rowspan='%s' data-complete-id='%s'>%s",
                        ($this->getCommentTitle($val)->getIsActive()) ? "" : "bg-success",
                        $span,
                        $val,
                        $this->getCommentTitle($val)->getComment()
                    );
                    if ($key == $last && $this->getCommentTitle($val)->getIsActive()) {
                        $html .= "<button onclick='complete(this)' class='bg-success'>Complete</button></td>";
                        $html .= "<td data-node-id={$val}><button onclick='openTextbox(this)'>add comment</button></td>";
                    } else {
                        $html .= '</td>';
                    }
                    $printed[$key][$val] = true;
                }
            }
            $html .= '</tr>';
        }
        $html .= '</table>';
        return $html;
    }
}