<?php
class Admin_Block_Ticket_Index_View extends Core_Block_Template
{
    protected $_arr = [];
    public function __construct()
    {
        $this->setTemplate('admin/ticket/index/view.phtml');
    }

    function getTicket()
    {
        return Mage::getModel('ticket/ticket')
            ->load($this->getId())
            ->getTitle();
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
        $comment = Mage::getModel('ticket/comment')
            ->getCollection()
            ->addFieldToFilter('ticket_id', $this->getId());
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
    public function dataArray($id = null)
    {
        $data = $this->getComments()->addFieldToFilter('parent_id', $id)->getData();
        if (!$data) {
            $this->_arr[$id] = [];
            return;
        }
        foreach ($data as $d) {
            $this->_arr[is_null($id) ? 0 : $id][] = $d->getCommentId();
            $this->dataArray($d->getCommentId());
        }
        return $this->_arr;
    }


    function buildTree($tableArray, $parentId = 0)
    {
        $tree = [];
        if (isset($tableArray[$parentId])) {
            foreach ($tableArray[$parentId] as $id) {
                $node = [
                    'id' => $id,
                    'children' => $this->buildTree($tableArray, $id)
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
    function render($tree, $ticket)
    {
        $rows = [];
        $rowspans = [];
        $html = '';
        $this->getPaths($tree, [], $rows, $rowspans);
        // Mage::log($tree);
        // Mage::log($rowspans);
        if (!empty($rows)) {
            if (!empty($rowspans)) {
                $last = max(array_keys($rowspans)) + 1;
            } else {
                $last = 0;
            }
            $totalRows = count($rows);

            $html = '<table border="1" cellpadding="10">';
            $html .= '<tr>';
            $html .= '<td rowspan="' . $totalRows . '">';
            $html .= $ticket;
            $html .= '</td>';

            // Mage::log($rows);
            foreach ($rows[0] as $key => $val) {
                $span = isset($rowspans[$key][$val]) ? $rowspans[$key][$val] : 1;
                // Mage::log($this->getCommentTitle($val)->getIsActive());
                // die;

                $html .= sprintf("<td class='%s' rowspan='%s' data-complete-id=%s>%s", ($this->getCommentTitle($val)->getIsActive()) ? "" : "bg-success", $span, $val, $this->getCommentTitle($val)->getComment());
                if ($key == $last && $this->getCommentTitle($val)->getIsActive()) {
                    $html .= "<button onclick='complete(this)' class='bg-success'>Complete</button></td>";
                    $html .= "<td data-node-id={$val}><button onclick='openTextbox()'>add comment</button></td>";
                } else {
                    $html .= '</td>';
                }
                $printed[$key][$val] = true;
            }
            $html .= '</tr>';

            for ($i = 1; $i < $totalRows; $i++) {
                $html .= '<tr>';
                foreach ($rows[$i] as $key => $val) {
                    if (!isset($printed[$key][$val])) {
                        $span = isset($rowspans[$key][$val]) ? $rowspans[$key][$val] : 1;
                        // Mage::log($val);
                        $html .= sprintf("<td class='%s' rowspan='%s' data-complete-id='%s'>%s", ($this->getCommentTitle($val)->getIsActive()) ? "" : "bg-success", $span, $val, $this->getCommentTitle($val)->getComment());
                        if ($key == $last && $this->getCommentTitle($val)->getIsActive()) {
                            $html .= "<button onclick='complete(this)' class='bg-success'>Complete</button></td>";
                            $html .= "<td data-node-id={$val}><button onclick='openTextbox()'>add comment</button></td>";
                        } else {
                            $html .= '</td>';
                        }
                        $printed[$key][$val] = true;
                    }
                }
                $html .= '</tr>';
            }
            $html .= '</table>';
        } else {
            $html .= '<table>';
            $html .= '<tr>';
            $html .= "<td>{$ticket}</td>";
            $html .= "<td data-node-id=0><button onclick='openTextbox()'>add comment</button></td>";
            // $html .= "<button onclick='complete(this)' class='bg-success'>Complete</button></td>";

            $html .= '</tr>';
            $html .= '</table>';
        }
        return $html;
    }
}
