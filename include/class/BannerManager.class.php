<?php

    /**
     * Class BannerManager
     */
    class BannerManager
    {
        /**
         * todo:查看輪播資料
         *
         * @param $rows
         * @param $keyword
         * @param $status
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryBanner($rows, $keyword, $status, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('keyword' => $Conn->UtilCheckNotNull($keyword) ? $Conn->getRegexpString($keyword, '|') : NULL,
                            'status'  => $Conn->UtilCheckNotNullIsNumeric($status) ? $status : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `banner`';
            $sql .= ' WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNull($keyword) ? ' AND (`B_Title` REGEXP :keyword OR `B_List1` REGEXP :keyword OR `B_List2` REGEXP :keyword OR `B_List3` REGEXP :keyword OR `B_List4` REGEXP :keyword)' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($status) ? ' AND `B_Status` = :status' : '';
            $sql .= ' ORDER BY `B_Order` DESC, `B_CreateTime` DESC';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }


        /**
         * todo:查看單一輪播資料
         *
         * @param $rows
         * @param $id
         *
         * @return mixed
         */
        function queryBannerByID($rows, $id)
        {
            $Conn = new ConnManager();
            $arrPar = array('id' => $Conn->UtilCheckNotNullIsNumeric($id) ? $id : '');
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `banner`';
            $sql .= ' WHERE `B_ID` = :id';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:新增輪播
         *
         * @param $title
         * @param $logo
         * @param $img
         * @param $type
         * @param $list1
         * @param $list2
         * @param $list3
         * @param $list4
         * @param $url
         * @param $action
         * @param $order
         * @param $status
         *
         * @return array|int|Number
         */
        function insertBanner($title, $logo, $img, $type, $list1, $list2, $list3, $list4, $url, $action, $order, $status)
        {
            $Conn = new ConnManager();
            $arrPar = array('title'  => $Conn->UtilCheckNotNull($title) ? $title : '',
                            'logo'   => $Conn->UtilCheckNotNull($logo) ? $logo : '',
                            'img'    => $Conn->UtilCheckNotNull($img) ? $img : '',
                            'type'  => $Conn->UtilCheckNotNullIsNumeric($type) ? $type : 0,
                            'list1'  => $Conn->UtilCheckNotNull($list1) ? $list1 : '',
                            'list2'  => $Conn->UtilCheckNotNull($list2) ? $list2 : '',
                            'list3'  => $Conn->UtilCheckNotNull($list3) ? $list3 : '',
                            'list4'  => $Conn->UtilCheckNotNull($list4) ? $list4 : '',
                            'url'    => $Conn->UtilCheckNotNull($url) ? $url : '',
                            'action' => $Conn->UtilCheckNotNullIsNumeric($action) ? $action : 0,
                            'order'  => $Conn->UtilCheckNotNullIsNumeric($order) ? $order : 0,
                            'status' => $Conn->UtilCheckNotNullIsNumeric($status) ? $status : 0);
            //SQL
            $sql = ' INSERT INTO `banner`(`B_Title`, `B_Logo`, `B_Img`, `B_Type`, `B_List1`, `B_List2`, `B_List3`, `B_List4`, `B_Url`, `B_Action`, `B_Order`, `B_Status`, `B_UpdateTime`, `B_CreateTime`)';
            $sql .= ' VALUES(:title, :logo, :img, :type, :list1, :list2, :list3, :list4, :url, :action, :order, :status, NOW(), NOW())';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:修改輪播資料
         *
         * @param $title
         * @param $logo
         * @param $img
         * @param $type
         * @param $list1
         * @param $list2
         * @param $list3
         * @param $list4
         * @param $url
         * @param $action
         * @param $order
         * @param $status
         *
         * @return array|int
         */
        function updateBannerByID($id, $title, $logo, $img, $type, $list1, $list2, $list3, $list4, $url, $action, $order, $status)
        {
            $Conn = new ConnManager();
            $arrPar = array('id'     => $Conn->UtilCheckNotNullIsNumeric($id) ? $id : '',
                            'title'  => $Conn->UtilCheckNotNull($title) ? $title : '',
                            'logo'   => $Conn->UtilCheckNotNull($logo) ? $logo : '',
                            'img'    => $Conn->UtilCheckNotNull($img) ? $img : '',
                            'type'  => $Conn->UtilCheckNotNullIsNumeric($type) ? $type : 0,
                            'list1'  => $Conn->UtilCheckNotNull($list1) ? $list1 : '',
                            'list2'  => $Conn->UtilCheckNotNull($list2) ? $list2 : '',
                            'list3'  => $Conn->UtilCheckNotNull($list3) ? $list3 : '',
                            'list4'  => $Conn->UtilCheckNotNull($list4) ? $list4 : '',
                            'url'    => $Conn->UtilCheckNotNull($url) ? $url : '',
                            'action' => $Conn->UtilCheckNotNullIsNumeric($action) ? $action : 0,
                            'order'  => $Conn->UtilCheckNotNullIsNumeric($order) ? $order : 0,
                            'status' => $Conn->UtilCheckNotNullIsNumeric($status) ? $status : 0);
            //SQL
            $sql = ' UPDATE `banner`';
            $sql .= ' SET `B_Title` = :title, `B_Logo` = :logo, `B_Img` = :img, `B_Type` = :type, `B_List1` = :list1, `B_List2` = :list2, `B_List3` = :list3, `B_List4` = :list4, `B_Url` = :url, `B_Action` = :action, `B_Order` = :order, `B_Status` = :status, `B_UpdateTime` = NOW()';
            $sql .= ' WHERE `B_ID` = :id';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:修改輪播狀態
         *
         * @param $id
         * @param $status
         *
         * @return array|int
         */
        function updateBannerStatusByID($id, $status)
        {
            $Conn = new ConnManager();
            $arrPar = array('status' => $Conn->UtilCheckNotNullIsNumeric($status) ? $status : 0,
                            'id'     => $Conn->UtilCheckNotNullIsNumeric($id) ? $id : '');
            //SQL
            $sql = ' UPDATE `banner`';
            $sql .= ' SET `B_Status` = :status, `B_UpdateTime` = NOW()';
            $sql .= ' WHERE `B_ID` = :id';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }


        /**
         * todo:修改輪播排序
         *
         * @param $id
         * @param $order
         *
         * @return array|int
         */
        function updateBannerOrderByID($id, $order)
        {
            $Conn = new ConnManager();
            $arrPar = array('order' => $Conn->UtilCheckNotNullIsNumeric($order) ? $order : 0,
                            'id'    => $Conn->UtilCheckNotNullIsNumeric($id) ? $id : '');
            //SQL
            $sql = ' UPDATE `banner`';
            $sql .= ' SET `B_Order` = :order, `B_UpdateTime` = NOW()';
            $sql .= ' WHERE `B_ID` = :id';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:刪除輪播資料
         *
         * @param int $id 編號
         *
         * @return int|boolean
         */
        function deleteBannerByID($id)
        {
            $Conn = new ConnManager();
            $arrPar = array('id' => $Conn->UtilCheckNotNullIsNumeric($id) ? $id : '');
            //SQL
            $sql = ' DELETE FROM `banner`';
            $sql .= ' WHERE `B_ID` = :id';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

    }

?>
