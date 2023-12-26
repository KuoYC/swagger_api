<?php

    /**
     * Class ContractManager
     */
    class ContractManager
    {
        /**
         * todo:queryNews 查看公告
         *
         * @param $rows
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryNews($rows, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array();
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `news`';
            $sql .= $Conn->getLimit($anum, $num);
            $sql .= ' ORDER BY `nwsTop` DESC, `nwsRelease` DESC';
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryNewsByID 查看單一公告
         *
         * @param $rows
         * @param $nwsId
         *
         * @return mixed
         */
        function queryNewsByID($rows, $nwsId)
        {
            $Conn = new ConnManager();
            $arrPar = array('nwsId' => $Conn->UtilCheckNotNullIsNumeric($nwsId) ? $nwsId : '');
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `news`
                     WHERE `nwsId` = :nwsId';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:insertNews 新增公告
         *
         * @param $nwsTitle
         * @param $nwsRelease
         * @param $nwsContent
         * @param $nwsTop
         * @param $nwsType
         *
         * @return array|int|Number
         */
        function insertNews($nwsTitle, $nwsRelease, $nwsContent, $nwsTop, $nwsType)
        {
            $Conn = new ConnManager();
            $arrPar = array('nwsTitle'   => $Conn->UtilCheckNotNull($nwsTitle) ? $nwsTitle : '',
                            'nwsRelease' => $Conn->UtilCheckNotNullIsDate($nwsRelease) ? $nwsRelease : date('Y-m-d'),
                            'nwsContent' => $Conn->UtilCheckNotNull($nwsContent) ? $nwsContent : '',
                            'nwsTop'     => $Conn->UtilCheckNotNullIsNumeric($nwsTop) ? $nwsTop : 0,
                            'nwsType'    => $Conn->UtilCheckNotNullIsNumeric($nwsType) ? $nwsType : 0);
            //SQL
            $sql = ' INSERT INTO `news`(`nwsTitle`, `nwsRelease`, `nwsContent`, `nwsTop`, `nwsType`)
                     VALUES(:nwsTitle, :nwsRelease, :nwsContent, :nwsTop, :nwsType)';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:updateNewsByID 修改公告
         *
         * @param $nwsTitle
         * @param $nwsRelease
         * @param $nwsContent
         * @param $nwsTop
         * @param $nwsType
         * @param $nwsId
         *
         * @return array|int
         */
        function updateNewsByID($nwsId, $nwsTitle, $nwsRelease, $nwsContent, $nwsTop, $nwsType)
        {
            $Conn = new ConnManager();
            $arrPar = array('nwsId'      => $Conn->UtilCheckNotNullIsNumeric($nwsId) ? $nwsId : '',
                            'nwsTitle'   => $Conn->UtilCheckNotNull($nwsTitle) ? $nwsTitle : '',
                            'nwsRelease' => $Conn->UtilCheckNotNullIsDate($nwsRelease) ? $nwsRelease : NULL,
                            'nwsContent' => $Conn->UtilCheckNotNull($nwsContent) ? $nwsContent : '',
                            'nwsTop'     => $Conn->UtilCheckNotNullIsNumeric($nwsTop) ? $nwsTop : 0,
                            'nwsType'    => $Conn->UtilCheckNotNullIsNumeric($nwsType) ? $nwsType : 0);
            //SQL
            $sql = ' UPDATE `news`
                     SET `nwsTitle` = :nwsTitle, `nwsContent` = :nwsContent, `nwsTop` = :nwsTop, `nwsType` = :nwsType'.
                ($Conn->UtilCheckNotNullIsDate($nwsRelease) ? ', `nwsRelease` = :nwsRelease' : '').'
                     WHERE `nwsId` = :nwsId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteNewsByID 刪除公告
         *
         * @param int $nwsId 編號
         *
         * @return int|boolean
         */
        function deleteNewsByID($nwsId)
        {
            $Conn = new ConnManager();
            $arrPar = array('nwsId' => $Conn->UtilCheckNotNullIsNumeric($nwsId) ? $nwsId : '');
            //SQL
            $sql = ' DELETE FROM `news`
                     WHERE `nwsId` = :nwsId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:queryTemplate 查看樣板
         *
         * @param $rows
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryTemplate($rows, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array();
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `template`';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryTemplateByID 查看單一樣板
         *
         * @param $rows
         * @param $temId
         *
         * @return mixed
         */
        function queryTemplateByID($rows, $temId)
        {
            $Conn = new ConnManager();
            $arrPar = array('temId' => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : '');
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `template`
                     WHERE `temId` = :temId';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:insertTemplate 新增樣板
         *
         * @param $temTitle
         * @param $temExes
         * @param $temStyle
         *
         * @return array|int|Number
         */
        function insertTemplate($temTitle, $temExes, $temStyle)
        {
            $Conn = new ConnManager();
            $arrPar = array('temTitle' => $Conn->UtilCheckNotNull($temTitle) ? $temTitle : '',
                            'temExes'  => $Conn->UtilCheckNotNull($temExes) ? $temExes : '',
                            'temStyle' => $Conn->UtilCheckNotNull($temStyle) ? $temStyle : '');
            //SQL
            $sql = ' INSERT INTO `template`(`temTitle`, `temExes`, `temStyle`)
                     VALUES(:temTitle, :temExes, :temStyle)';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:updateTemplateByID 修改樣板
         *
         * @param $temTitle
         * @param $temExes
         * @param $temStyle
         * @param $temId
         *
         * @return array|int
         */
        function updateTemplateByID($temId, $temTitle, $temExes, $temStyle)
        {
            $Conn = new ConnManager();
            $arrPar = array('temId'    => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : '',
                            'temTitle' => $Conn->UtilCheckNotNull($temTitle) ? $temTitle : '',
                            'temExes'  => $Conn->UtilCheckNotNull($temExes) ? $temExes : '',
                            'temStyle' => $Conn->UtilCheckNotNull($temStyle) ? $temStyle : '');
            //SQL
            $sql = ' UPDATE `template`
                     SET `temTitle` = :temTitle, `temExes` = :temExes, `temStyle` = :temStyle
                     WHERE `temId` = :temId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteTemplateByID 刪除樣板
         *
         * @param int $temId 編號
         *
         * @return int|boolean
         */
        function deleteTemplateByID($temId)
        {
            $Conn = new ConnManager();
            $arrPar = array('temId' => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : '');
            //SQL
            $sql = ' DELETE FROM `template`
                     WHERE `temId` = :temId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:queryWork 查看作業種類
         *
         * @param $rows
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryWork($rows, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array();
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `work`';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryWorkByID 查看單一作業種類
         *
         * @param $rows
         * @param $worId
         *
         * @return mixed
         */
        function queryWorkByID($rows, $worId)
        {
            $Conn = new ConnManager();
            $arrPar = array('worId' => $Conn->UtilCheckNotNullIsNumeric($worId) ? $worId : '');
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `work`
                     WHERE `worId` = :worId';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:insertWork 新增作業種類
         *
         * @param $worTitle
         *
         * @return array|int|Number
         */
        function insertWork($worTitle)
        {
            $Conn = new ConnManager();
            $arrPar = array('worTitle' => $Conn->UtilCheckNotNull($worTitle) ? $worTitle : '');
            //SQL
            $sql = ' INSERT INTO `work`(`worTitle`)
                     VALUES(:worTitle)';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:updateWorkByID 修改作業種類
         *
         * @param $worTitle
         * @param $worId
         *
         * @return array|int
         */
        function updateWorkByID($worId, $worTitle)
        {
            $Conn = new ConnManager();
            $arrPar = array('worId'    => $Conn->UtilCheckNotNullIsNumeric($worId) ? $worId : '',
                            'worTitle' => $Conn->UtilCheckNotNull($worTitle) ? $worTitle : '');
            //SQL
            $sql = ' UPDATE `work`
                     SET `worTitle` = :worTitle
                     WHERE `worId` = :worId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteWorkByID 刪除作業種類
         *
         * @param int $worId 編號
         *
         * @return int|boolean
         */
        function deleteWorkByID($worId)
        {
            $Conn = new ConnManager();
            $arrPar = array('worId' => $Conn->UtilCheckNotNullIsNumeric($worId) ? $worId : '');
            //SQL
            $sql = ' DELETE FROM `work`
                     WHERE `worId` = :worId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:queryFrame 查看框架種類
         *
         * @param $rows
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryFrame($rows, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array();
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `frame`';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryFrameByID 查看單一框架種類
         *
         * @param $rows
         * @param $frmId
         *
         * @return mixed
         */
        function queryFrameByID($rows, $frmId)
        {
            $Conn = new ConnManager();
            $arrPar = array('frmId' => $Conn->UtilCheckNotNullIsNumeric($frmId) ? $frmId : '');
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `frame`
                     WHERE `frmId` = :frmId';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:insertFrame 新增框架種類
         *
         * @param $frmTitle
         *
         * @return array|int|Number
         */
        function insertFrame($frmTitle)
        {
            $Conn = new ConnManager();
            $arrPar = array('frmTitle' => $Conn->UtilCheckNotNull($frmTitle) ? $frmTitle : '');
            //SQL
            $sql = ' INSERT INTO `frame`(`frmTitle`)
                     VALUES(:frmTitle)';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:updateFrameByID 修改框架種類
         *
         * @param $frmTitle
         * @param $frmId
         *
         * @return array|int
         */
        function updateFrameByID($frmId, $frmTitle)
        {
            $Conn = new ConnManager();
            $arrPar = array('frmId'    => $Conn->UtilCheckNotNullIsNumeric($frmId) ? $frmId : '',
                            'frmTitle' => $Conn->UtilCheckNotNull($frmTitle) ? $frmTitle : '');
            //SQL
            $sql = ' UPDATE `frame`
                     SET `frmTitle` = :frmTitle
                     WHERE `frmId` = :frmId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteFrameByID 刪除框架種類
         *
         * @param int $frmId 編號
         *
         * @return int|boolean
         */
        function deleteFrameByID($frmId)
        {
            $Conn = new ConnManager();
            $arrPar = array('frmId' => $Conn->UtilCheckNotNullIsNumeric($frmId) ? $frmId : '');
            //SQL
            $sql = ' DELETE FROM `frame`
                     WHERE `frmId` = :frmId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:queryCompany 查看公司
         *
         * @param $rows
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryCompany($rows, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array();
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `company`';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryCompanyByID 查看單一公司
         *
         * @param $rows
         * @param $comId
         *
         * @return mixed
         */
        function queryCompanyByID($rows, $comId)
        {
            $Conn = new ConnManager();
            $arrPar = array('comId' => $Conn->UtilCheckNotNullIsNumeric($comId) ? $comId : '');
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `company`
                     WHERE `comId` = :comId';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryCompanyByCode 查看單一公司
         *
         * @param $rows
         * @param $comCode
         *
         * @return mixed
         */
        function queryCompanyByCode($rows, $comCode)
        {
            $Conn = new ConnManager();
            $arrPar = array('comCode' => $Conn->UtilCheckNotNull($comCode) ? $comCode : '');
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `company`
                     WHERE `comCode` = :comCode';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:insertCompany 新增公司
         *
         * @param $comTitle
         * @param $comCode
         *
         * @return array|int|Number
         */
        function insertCompany($comTitle, $comCode)
        {
            $Conn = new ConnManager();
            $arrPar = array('comTitle' => $Conn->UtilCheckNotNull($comTitle) ? $comTitle : '',
                            'comCode'  => $Conn->UtilCheckNotNull($comCode) ? $comCode : '');
            //SQL
            $sql = ' INSERT INTO `company`(`comTitle`, `comCode`)
                     VALUES(:comTitle, :comCode)';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:updateCompanyByID 修改公司
         *
         * @param $comTitle
         * @param $comCode
         * @param $comId
         *
         * @return array|int
         */
        function updateCompanyByID($comId, $comTitle, $comCode)
        {
            $Conn = new ConnManager();
            $arrPar = array('comId'    => $Conn->UtilCheckNotNullIsNumeric($comId) ? $comId : '',
                            'comTitle' => $Conn->UtilCheckNotNull($comTitle) ? $comTitle : '',
                            'comCode'  => $Conn->UtilCheckNotNull($comCode) ? $comCode : '');
            //SQL
            $sql = ' UPDATE `company`
                     SET `comTitle` = :comTitle, `comCode` = :comCode
                     WHERE `comId` = :comId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteCompanyByID 刪除公司
         *
         * @param int $comId 編號
         *
         * @return int|boolean
         */
        function deleteCompanyByID($comId)
        {
            $Conn = new ConnManager();
            $arrPar = array('comId' => $Conn->UtilCheckNotNullIsNumeric($comId) ? $comId : '');
            //SQL
            $sql = ' DELETE FROM `company`
                     WHERE `comId` = :comId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:queryDistribution 查看分攤方式
         *
         * @param $rows
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryDistribution($rows, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array();
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `distribution`';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryDistributionByID 查看單一分攤方式
         *
         * @param $rows
         * @param $disId
         *
         * @return mixed
         */
        function queryDistributionByID($rows, $disId)
        {
            $Conn = new ConnManager();
            $arrPar = array('disId' => $Conn->UtilCheckNotNullIsNumeric($disId) ? $disId : '');
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `distribution`
                     WHERE `disId` = :disId';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:insertDistribution 新增分攤方式
         *
         * @param $disTitle
         *
         * @return array|int|Number
         */
        function insertDistribution($disTitle)
        {
            $Conn = new ConnManager();
            $arrPar = array('disTitle' => $Conn->UtilCheckNotNull($disTitle) ? $disTitle : '');
            //SQL
            $sql = ' INSERT INTO `distribution`(`disTitle`)
                     VALUES(:disTitle)';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:updateDistributionByID 修改分攤方式
         *
         * @param $disTitle
         * @param $disId
         *
         * @return array|int
         */
        function updateDistributionByID($disId, $disTitle)
        {
            $Conn = new ConnManager();
            $arrPar = array('disId'    => $Conn->UtilCheckNotNullIsNumeric($disId) ? $disId : '',
                            'disTitle' => $Conn->UtilCheckNotNull($disTitle) ? $disTitle : '');
            //SQL
            $sql = ' UPDATE `distribution`
                     SET `disTitle` = :disTitle
                     WHERE `disId` = :disId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteDistributionByID 刪除分攤方式
         *
         * @param int $disId 編號
         *
         * @return int|boolean
         */
        function deleteDistributionByID($disId)
        {
            $Conn = new ConnManager();
            $arrPar = array('disId' => $Conn->UtilCheckNotNullIsNumeric($disId) ? $disId : '');
            //SQL
            $sql = ' DELETE FROM `distribution`
                     WHERE `disId` = :disId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:queryManner 查看分攤比例方式
         *
         * @param $rows
         * @param $type
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryManner($rows, $type, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('type' => $Conn->UtilCheckNotNullIsNumeric($type) ? $type : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `manner`';
            $sql .= ' WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($type) ? ' AND `manType` = :type' : '';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryMannerByID 查看單一分攤比例方式
         *
         * @param $rows
         * @param $manId
         *
         * @return mixed
         */
        function queryMannerByID($rows, $manId)
        {
            $Conn = new ConnManager();
            $arrPar = array('manId' => $Conn->UtilCheckNotNullIsNumeric($manId) ? $manId : '');
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `manner`
                     WHERE `manId` = :manId';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:insertManner 新增分攤比例方式
         *
         * @param $manTitle
         * @param $manType
         *
         * @return array|int|Number
         */
        function insertManner($manTitle, $manType)
        {
            $Conn = new ConnManager();
            $arrPar = array('manTitle' => $Conn->UtilCheckNotNull($manTitle) ? $manType : '',
                            'manType'  => $Conn->UtilCheckNotNullIsNumeric($manType) ? $manType : 0);
            //SQL
            $sql = ' INSERT INTO `manner`(`manTitle`, `manType`)
                     VALUES(:manTitle, :manType)';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:updateMannerByID 修改分攤比例方式
         *
         * @param $manId
         * @param $manTitle
         * @param $manType
         * @param $manRatio
         *
         * @return array|int
         */
        function updateMannerByID($manId, $manTitle, $manType, $manRatio)
        {
            $Conn = new ConnManager();
            $arrPar = array('manId'    => $Conn->UtilCheckNotNullIsNumeric($manId) ? $manId : 0,
                            'manTitle' => $Conn->UtilCheckNotNull($manTitle) ? $manTitle : '',
                            'manType'  => $Conn->UtilCheckNotNullIsNumeric($manType) ? $manType : 0,
                            'manRatio' => $Conn->UtilCheckNotNull($manRatio) ? $manRatio : NULL);
            //SQL
            $sql = ' UPDATE `manner`
                     SET `manTitle` = :manTitle, `manType` = :manType';
            $sql .= $Conn->UtilCheckNotNull($manRatio) ? ' , `manRatio` = :manRatio' : '';
            $sql .= ' WHERE `manId` = :manId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteMannerByID 刪除分攤比例方式
         *
         * @param int $manId 編號
         *
         * @return int|boolean
         */
        function deleteMannerByID($manId)
        {
            $Conn = new ConnManager();
            $arrPar = array('manId' => $Conn->UtilCheckNotNullIsNumeric($manId) ? $manId : '');
            //SQL
            $sql = ' DELETE FROM `manner`
                     WHERE `manId` = :manId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:queryCategory 查看類型
         *
         * @param $rows
         * @param $catType
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryCategory($rows, $catType, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('catType' => $Conn->UtilCheckNotNull($catType) ? $catType : '');
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `category`';
            $sql .= ' WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNull($catType) ? ' AND catType = :catType' : '';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryCategoryByID 查看單一類型
         *
         * @param $rows
         * @param $catId
         *
         * @return mixed
         */
        function queryCategoryByID($rows, $catId)
        {
            $Conn = new ConnManager();
            $arrPar = array('catId' => $Conn->UtilCheckNotNullIsNumeric($catId) ? $catId : '');
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `category`
                     WHERE `catId` = :catId';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:insertCategory 新增類型
         *
         * @param $catTitle
         * @param $catType
         * @param $catWord
         * @param $catRequired
         *
         * @return array|int|Number
         */
        function insertCategory($catTitle, $catType, $catWord, $catRequired)
        {
            $Conn = new ConnManager();
            $arrPar = array('catTitle'    => $Conn->UtilCheckNotNull($catTitle) ? $catTitle : '',
                            'catType'     => $Conn->UtilCheckNotNull($catType) ? $catType : '',
                            'catWord'     => $Conn->UtilCheckNotNull($catWord) ? $catWord : '',
                            'catRequired' => $Conn->UtilCheckNotNullIsNumeric($catRequired) ? $catRequired : 0);
            //SQL
            $sql = ' INSERT INTO `category`(`catTitle`, `catType`, `catWord`, `catRequired`)
                     VALUES(:catTitle, :catType, :catWord, :catRequired)';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:updateCategoryByID 修改類型
         *
         * @param $catTitle
         * @param $catType
         * @param $catWord
         * @param $catRequired
         * @param $catId
         *
         * @return array|int
         */
        function updateCategoryByID($catId, $catTitle, $catType, $catWord, $catRequired)
        {
            $Conn = new ConnManager();
            $arrPar = array('catId'       => $Conn->UtilCheckNotNullIsNumeric($catId) ? $catId : '',
                            'catTitle'    => $Conn->UtilCheckNotNull($catTitle) ? $catTitle : '',
                            'catType'     => $Conn->UtilCheckNotNull($catType) ? $catType : '',
                            'catWord'     => $Conn->UtilCheckNotNull($catWord) ? $catWord : '',
                            'catRequired' => $Conn->UtilCheckNotNullIsNumeric($catRequired) ? $catRequired : 0);
            //SQL
            $sql = ' UPDATE `category`
                     SET `catTitle` = :catTitle, `catType` = :catType, `catWord` = :catWord, `catRequired` = :catRequired
                     WHERE `catId` = :catId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteCategoryByID 刪除類型
         *
         * @param int $catId 編號
         *
         * @return int|boolean
         */
        function deleteCategoryByID($catId)
        {
            $Conn = new ConnManager();
            $arrPar = array('catId' => $Conn->UtilCheckNotNullIsNumeric($catId) ? $catId : '');
            //SQL
            $sql = ' DELETE FROM `category`
                     WHERE `catId` = :catId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:querySource 查看選項
         *
         * @param $rows
         * @param $catId
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function querySource($rows, $catId, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('catId' => $Conn->UtilCheckNotNullIsNumeric($catId) ? $catId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `source` S
                     LEFT JOIN `category` C ON C.`catId` = S.`catId`
                     WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($catId) ? ' AND S.`catId` = :catId' : '';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:querySourceByID 查看單一選項
         *
         * @param $rows
         * @param $souId
         *
         * @return mixed
         */
        function querySourceByID($rows, $souId)
        {
            $Conn = new ConnManager();
            $arrPar = array('souId' => $Conn->UtilCheckNotNullIsNumeric($souId) ? $souId : '');
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `source` S
                     LEFT JOIN `category` C ON C.`catId` = S.`catId`
                     WHERE S.`souId` = :souId';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:insertSource 新增選項
         *
         * @param $catId
         * @param $souTitle
         *
         * @return array|int|Number
         */
        function insertSource($catId, $souTitle)
        {
            $Conn = new ConnManager();
            $arrPar = array('catId'    => $Conn->UtilCheckNotNullIsNumeric($catId) ? $catId : 0,
                            'souTitle' => $Conn->UtilCheckNotNull($souTitle) ? $souTitle : '');
            //SQL
            $sql = ' INSERT INTO `source`(`catId`, `souTitle`)
                     VALUES(:catId, :souTitle)';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:updateSourceByID 修改選項
         *
         * @param $catId
         * @param $souTitle
         * @param $souId
         *
         * @return array|int
         */
        function updateSourceByID($souId, $catId, $souTitle)
        {
            $Conn = new ConnManager();
            $arrPar = array('souId'    => $Conn->UtilCheckNotNullIsNumeric($souId) ? $souId : 0,
                            'catId'    => $Conn->UtilCheckNotNullIsNumeric($catId) ? $catId : 0,
                            'souTitle' => $Conn->UtilCheckNotNull($souTitle) ? $souTitle : '');
            //SQL
            $sql = ' UPDATE `source`
                     SET `catId` = :catId, `souTitle` = :souTitle
                     WHERE `souId` = :souId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteSourceByID 刪除選項
         *
         * @param int $souId 編號
         *
         * @return int|boolean
         */
        function deleteSourceByID($souId)
        {
            $Conn = new ConnManager();
            $arrPar = array('souId' => $Conn->UtilCheckNotNullIsNumeric($souId) ? $souId : '');
            //SQL
            $sql = ' DELETE FROM `source`
                     WHERE `souId` = :souId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteSourceByCategory 刪除類型相關選項
         *
         * @param int $catId 編號
         *
         * @return int|boolean
         */
        function deleteSourceByCategory($catId)
        {
            $Conn = new ConnManager();
            $arrPar = array('catId' => $Conn->UtilCheckNotNullIsNumeric($catId) ? $catId : '');
            //SQL
            $sql = ' DELETE FROM `source`
                     WHERE `catId` = :catId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:queryContact 查看窗口
         *
         * @param $rows
         * @param $comId
         * @param $comCode
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryContact($rows, $comId, $comCode, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('comId'   => $Conn->UtilCheckNotNullIsNumeric($comId) ? $comId : NULL,
                            'comCode' => $Conn->UtilCheckNotNull($comCode) ? $comCode : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contact` C
                     LEFT JOIN `company` CP ON CP.`comCode` = C.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($comId) ? ' AND C.`comId` = :comId' : '';
            $sql .= $Conn->UtilCheckNotNull($comCode) ? ' AND C.`comCode` = :comCode' : '';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryContactByID 查看單一窗口
         *
         * @param $rows
         * @param $cotId
         *
         * @return mixed
         */
        function queryContactByID($rows, $cotId)
        {
            $Conn = new ConnManager();
            $arrPar = array('cotId' => $Conn->UtilCheckNotNullIsNumeric($cotId) ? $cotId : '');
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contact` C
                     LEFT JOIN `company` CP ON CP.`comCode` = C.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     WHERE `cotId` = :cotId';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:insertContact 新增窗口
         *
         * @param $comCode
         * @param $perKey
         *
         * @return array|int|Number
         */
        function insertContact($comCode, $perKey)
        {
            $Conn = new ConnManager();
            $arrPar = array('comCode' => $Conn->UtilCheckNotNull($comCode) ? $comCode : 0,
                            'perKey'  => $Conn->UtilCheckNotNull($perKey) ? $perKey : '');
            //SQL
            $sql = ' INSERT INTO `contact`(`comCode`, `perKey`)
                     VALUES(:comCode, :perKey)';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:updateContactByID 修改窗口
         *
         * @param $comCode
         * @param $perKey
         * @param $cotId
         *
         * @return array|int
         */
        function updateContactByID($cotId, $comCode, $perKey)
        {
            $Conn = new ConnManager();
            $arrPar = array('cotId'   => $Conn->UtilCheckNotNullIsNumeric($cotId) ? $cotId : '',
                            'comCode' => $Conn->UtilCheckNotNull($comCode) ? $comCode : 0,
                            'perKey'  => $Conn->UtilCheckNotNull($perKey) ? $perKey : '');
            //SQL
            $sql = ' UPDATE `contact`
                     SET `comCode` = :comCode, `perKey` = :perKey
                     WHERE `cotId` = :cotId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }


        /**
         * todo:deleteContactByID 刪除窗口
         *
         * @param int $cotId 編號
         *
         * @return int|boolean
         */
        function deleteContactByID($cotId)
        {
            $Conn = new ConnManager();
            $arrPar = array('cotId' => $Conn->UtilCheckNotNullIsNumeric($cotId) ? $cotId : 0);
            //SQL
            $sql = ' DELETE FROM `contact`
                     WHERE `cotId` = :cotId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:queryPersonnel 查看人員
         *
         * @param $rows
         * @param $keyword
         * @param $perBu1Code
         * @param $perBu2Code
         * @param $perBu3Code
         * @param $perKey
         * @param $perEmail
         * @param $perAccount
         * @param $perNo
         * @param $perPosition
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryPersonnel($rows, $keyword, $perBu1Code, $perBu2Code, $perBu3Code, $perKey, $perEmail, $perAccount, $perNo, $perPosition, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('keyword'     => $Conn->UtilCheckNotNull($keyword) ? $Conn->getRegexpString($keyword, '|') : NULL,
                            'perBu1Code'  => $Conn->UtilCheckNotNull($perBu1Code) ? $perBu1Code : NULL,
                            'perBu2Code'  => $Conn->UtilCheckNotNull($perBu2Code) ? $perBu2Code : NULL,
                            'perBu3Code'  => $Conn->UtilCheckNotNull($perBu3Code) ? $perBu3Code : NULL,
                            'perKey'      => $Conn->UtilCheckNotNull($perKey) ? $perKey : NULL,
                            'perEmail'    => $Conn->UtilCheckNotNull($perEmail) ? $perEmail : NULL,
                            'perAccount'  => $Conn->UtilCheckNotNull($perAccount) ? $perAccount : NULL,
                            'perNo'       => $Conn->UtilCheckNotNull($perNo) ? $perNo : NULL,
                            'perPosition' => $Conn->UtilCheckNotNull($perPosition) ? $perPosition : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `personnel` P
                     LEFT JOIN `company` C ON C.`comCode` = P.`perBu1Code`
                     WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNull($keyword) ? ' AND (`perAccount` REGEXP :keyword OR `perNo` REGEXP :keyword OR `perName` REGEXP :keyword OR `perPosition` REGEXP :keyword OR `perPositionName` REGEXP :keyword OR `perEmail` REGEXP :keyword)' : '';
            $sql .= $Conn->UtilCheckNotNull($perBu1Code) ? ' AND P.`perBu1Code` = :perBu1Code' : '';
            $sql .= $Conn->UtilCheckNotNull($perBu2Code) ? ' AND P.`perBu2Code` = :perBu2Code' : '';
            $sql .= $Conn->UtilCheckNotNull($perBu3Code) ? ' AND P.`perBu3Code` = :perBu3Code' : '';
            $sql .= $Conn->UtilCheckNotNull($perKey) ? ' AND P.`perKey` = :perKey' : '';
            $sql .= $Conn->UtilCheckNotNull($perEmail) ? ' AND P.`perEmail` = :perEmail' : '';
            $sql .= $Conn->UtilCheckNotNull($perAccount) ? ' AND P.`perAccount` = :perAccount' : '';
            $sql .= $Conn->UtilCheckNotNull($perNo) ? ' AND P.`perNo` = :perNo' : '';
            $sql .= $Conn->UtilCheckNotNull($perPosition) ? ' AND P.`perPosition` = :perPosition' : '';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryPersonnel 查看人員
         *
         * @return mixed
         */
        function queryPersonnelGroupForBu1()
        {
            $Conn = new ConnManager();
            $arrPar = array();
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS `perBu1Code`, `perBu1` FROM `personnel`
                     GROUP BY `perBu1Code`, `perBu1`';
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryPersonnel 查看人員
         *
         * @param $perBu1Code
         *
         * @return mixed
         */
        function queryPersonnelGroupForBu2($perBu1Code)
        {
            $Conn = new ConnManager();
            $arrPar = array(
                'perBu1Code' => $Conn->UtilCheckNotNull($perBu1Code) ? $perBu1Code : NULL
            );
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS `perBu2Code`, `perBu2` FROM `personnel`
                     WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNull($perBu1Code) ? ' AND `perBu1Code` = :perBu1Code' : '';
            $sql .= ' GROUP BY `perBu2Code`, `perBu2`';
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryPersonnel 查看人員
         *
         * @param $perBu1Code
         * @param $perBu2Code
         *
         * @return mixed
         */
        function queryPersonnelGroupForBu3($perBu1Code, $perBu2Code)
        {
            $Conn = new ConnManager();
            $arrPar = array(
                'perBu1Code' => $Conn->UtilCheckNotNull($perBu1Code) ? $perBu1Code : NULL,
                'perBu2Code' => $Conn->UtilCheckNotNull($perBu2Code) ? $perBu2Code : NULL
            );
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS `perBu3Code`, `perBu3` FROM `personnel`
                     WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNull($perBu1Code) ? ' AND `perBu1Code` = :perBu1Code' : '';
            $sql .= $Conn->UtilCheckNotNull($perBu2Code) ? ' AND `perBu2Code` = :perBu2Code' : '';
            $sql .= ' GROUP BY `perBu3Code`, `perBu3`';
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryPersonnelByID 查看單一人員
         *
         * @param $rows
         * @param $perId
         *
         * @return mixed
         */
        function queryPersonnelByID($rows, $perId)
        {
            $Conn = new ConnManager();
            $arrPar = array('perId' => $Conn->UtilCheckNotNullIsNumeric($perId) ? $perId : '');
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `personnel` Ｐ
                     LEFT JOIN `company` C ON C.`comCode` = P.`perBu1Code`
                     WHERE `perId` = :perId';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryPersonnelByKey 查看單一人員
         *
         * @param $rows
         * @param $perKey
         *
         * @return mixed
         */
        function queryPersonnelByKey($rows, $perKey)
        {
            $Conn = new ConnManager();
            $arrPar = array('perKey' => $Conn->UtilCheckNotNull($perKey) ? $perKey : '');
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `personnel` Ｐ
                     LEFT JOIN `company` C ON C.`comCode` = P.`perBu1Code`
                     WHERE `perKey` = :perKey';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:insertPersonnel 新增人員
         *
         * @param $perKey
         * @param $perAccount
         * @param $perNo
         * @param $perName
         * @param $perPar
         * @param $perNick
         * @param $perPosition
         * @param $perPositionName
         * @param $perEmail
         * @param $perPhone1
         * @param $perPhone2
         * @param $perPhone3
         * @param $perBu1Code
         * @param $perBu1
         * @param $perBu2Code
         * @param $perBu2
         * @param $perBu3Code
         * @param $perBu3
         * @param $perMobile
         *
         * @return array|int|Number
         */
        function insertPersonnel($perKey, $perAccount, $perNo, $perName, $perPar, $perNick, $perPosition, $perPositionName, $perEmail, $perPhone1, $perPhone2, $perPhone3, $perBu1Code, $perBu1, $perBu2Code, $perBu2, $perBu3Code, $perBu3, $perMobile)
        {
            $Conn = new ConnManager();
            $arrPar = array('perKey'          => $Conn->UtilCheckNotNull($perKey) ? $perKey : '',
                            'perAccount'      => $Conn->UtilCheckNotNull($perAccount) ? $perAccount : 0,
                            'perNo'           => $Conn->UtilCheckNotNull($perNo) ? $perNo : '',
                            'perName'         => $Conn->UtilCheckNotNull($perName) ? $perName : '',
                            'perPar'          => $Conn->UtilCheckNotNull($perPar) ? $perPar : '',
                            'perNick'         => $Conn->UtilCheckNotNull($perNick) ? $perNick : '',
                            'perPosition'     => $Conn->UtilCheckNotNull($perPosition) ? $perPosition : '',
                            'perPositionName' => $Conn->UtilCheckNotNull($perPositionName) ? $perPositionName : '',
                            'perEmail'        => $Conn->UtilCheckNotNull($perEmail) ? $perEmail : '',
                            'perPhone1'       => $Conn->UtilCheckNotNull($perPhone1) ? $perPhone1 : '',
                            'perPhone2'       => $Conn->UtilCheckNotNull($perPhone2) ? $perPhone2 : '',
                            'perPhone3'       => $Conn->UtilCheckNotNull($perPhone3) ? $perPhone3 : '',
                            'perBu1Code'      => $Conn->UtilCheckNotNull($perBu1Code) ? $perBu1Code : '',
                            'perBu1'          => $Conn->UtilCheckNotNull($perBu1) ? $perBu1 : '',
                            'perBu2Code'      => $Conn->UtilCheckNotNull($perBu2Code) ? $perBu2Code : '',
                            'perBu2'          => $Conn->UtilCheckNotNull($perBu2) ? $perBu2 : '',
                            'perBu3Code'      => $Conn->UtilCheckNotNull($perBu3Code) ? $perBu3Code : '',
                            'perBu3'          => $Conn->UtilCheckNotNull($perBu3) ? $perBu3 : '',
                            'perMobile'       => $Conn->UtilCheckNotNull($perMobile) ? $perMobile : '');
            //SQL
            $sql = ' INSERT INTO `personnel`(`perKey`, `perAccount`, `perNo`, `perName`, `perPar`, `perNick`, `perPosition`, `perPositionName`, `perEmail`, `perPhone1`, `perPhone2`, `perPhone3`, `perBu1Code`, `perBu1`, `perBu2Code`, `perBu2`, `perBu3Code`, `perBu3`, `perMobile`)
                     SELECT :perKey, :perAccount, :perNo, :perName, :perPar, :perNick, :perPosition, :perPositionName, :perEmail, :perPhone1, :perPhone2, :perPhone3, :perBu1Code, :perBu1, :perBu2Code, :perBu2, :perBu3Code, :perBu3, :perMobile FROM DUAL
                     WHERE NOT EXISTS(SELECT `perKey` FROM `personnel` WHERE `perKey` = :perKey)';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }


        /**
         * todo:cleanPersonnel 清除人員
         *
         *
         * @return int|boolean
         */
        function cleanPersonnel()
        {
            $Conn = new ConnManager();
            $arrPar = array();
            //SQL
            $sql = ' TRUNCATE TABLE `personnel`';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:queryContract 查看文件
         *
         * @param $rows
         * @param $keyword
         * @param $temId
         * @param $comId
         * @param $comCode
         * @param $perKey
         * @param $conSerial
         * @param $conStatus
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryContract($rows, $keyword, $temId, $comId, $comCode, $perKey, $conSerial, $conStatus, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('keyword'   => $Conn->UtilCheckNotNull($keyword) ? $Conn->getRegexpString($keyword, '|') : NULL,
                            'conSerial' => $Conn->UtilCheckNotNull($conSerial) ? $conSerial : NULL,
                            'comId'     => $Conn->UtilCheckNotNullIsNumeric($comId) ? $comId : NULL,
                            'comCode'   => $Conn->UtilCheckNotNull($comCode) ? $comCode : NULL,
                            'perKey'    => $Conn->UtilCheckNotNull($perKey) ? $perKey : NULL,
                            'conStatus' => $Conn->UtilCheckNotNullIsNumeric($conStatus) ? $conStatus : NULL,
                            'temId'     => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contract` C
                     LEFT JOIN `template` T ON T.`temId` = C.`temId`
                     LEFT JOIN `company` CM ON CM.`comCode` = C.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     LEFT JOIN `frame` F ON F.`frmId` = C.`frmId`
                     WHERE 1 = 1';
            $sql .= $Conn->UtilCheckNotNull($keyword) ? ' AND (C.`conTitle` REGEXP :keyword OR CONCAT(C.`conSerial`, C.`conVer`) REGEXP :keyword)' : '';
            $sql .= $Conn->UtilCheckNotNull($conSerial) ? ' AND C.`conSerial` = :conSerial' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($comId) ? ' AND CM.`comId` = :comId' : '';
            $sql .= $Conn->UtilCheckNotNull($comCode) ? ' AND C.`comCode` = :comCode' : '';
            $sql .= $Conn->UtilCheckNotNull($perKey) ? ' AND C.`perKey` = :perKey' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conStatus) ? ' AND C.`conStatus` = :conStatus' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($temId) ? ' AND C.`temId` = :temId' : '';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryContractForIntegrate 查看文件-年度費用分攤明細使用
         *
         * @param $rows
         * @param $keyword
         * @param $temId
         * @param $comId
         * @param $comCode
         * @param $perKey
         * @param $conSerial
         * @param $conStatus
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryContractForIntegrate($rows, $keyword, $temId, $comId, $comCode, $perKey, $conSerial, $conStatus, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('keyword'   => $Conn->UtilCheckNotNull($keyword) ? $Conn->getRegexpString($keyword, '|') : NULL,
                            'conSerial' => $Conn->UtilCheckNotNull($conSerial) ? $conSerial : NULL,
                            'comId'     => $Conn->UtilCheckNotNullIsNumeric($comId) ? $comId : NULL,
                            'comCode'   => $Conn->UtilCheckNotNull($comCode) ? $comCode : NULL,
                            'perKey'    => $Conn->UtilCheckNotNull($perKey) ? $perKey : NULL,
                            'conStatus' => $Conn->UtilCheckNotNullIsNumeric($conStatus) ? $conStatus : NULL,
                            'temId'     => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contract` C
                     LEFT JOIN `template` T ON T.`temId` = C.`temId`
                     LEFT JOIN `company` CM ON CM.`comCode` = C.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     LEFT JOIN `frame` F ON F.`frmId` = C.`frmId`
                     WHERE 1 = 1';
            $sql .= $Conn->UtilCheckNotNull($keyword) ? ' AND (C.`conTitle` REGEXP :keyword OR CONCAT(C.`conSerial`, C.`conVer`) REGEXP :keyword)' : '';
            $sql .= $Conn->UtilCheckNotNull($conSerial) ? ' AND C.`conSerial` = :conSerial' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($comId) ? ' AND CM.`comId` = :comId' : '';
            $sql .= $Conn->UtilCheckNotNull($comCode) ? ' AND C.`comCode` = :comCode' : '';
            $sql .= $Conn->UtilCheckNotNull($perKey) ? ' AND C.`perKey` = :perKey' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conStatus) ? ' AND C.`conStatus` = :conStatus' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($temId) ? ' AND C.`temId` = :temId' : '';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryContractForAction 查看文件-相關
         *
         * @param $keyword
         * @param $temId
         * @param $comId
         * @param $comCode
         * @param $conSerial
         * @param $conStatus
         * @param $perKey
         * @param $perBu1Code
         * @param $memOwner 1:擁有者
         * @param $memDraft 1:草稿
         * @param $memView  1:待檢視
         * @param $memSign  1:待簽
         * @param $memOver  1:已簽
         * @param $conStatusNot
         * @param $conMark  1:棄用
         * @param $conInh   1:被繼承
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryContractForAction($keyword, $temId, $comId, $comCode, $conSerial, $conStatus, $perKey, $perBu1Code, $memOwner, $memDraft, $memView, $memSign, $memOver, $conStatusNot, $conMark, $conInh, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('keyword'      => $Conn->UtilCheckNotNull($keyword) ? $Conn->getRegexpString($keyword, '|') : NULL,
                            'conSerial'    => $Conn->UtilCheckNotNull($conSerial) ? $conSerial : NULL,
                            'comId'        => $Conn->UtilCheckNotNullIsNumeric($comId) ? $comId : NULL,
                            'comCode'      => $Conn->UtilCheckNotNull($comCode) ? $comCode : NULL,
                            'conStatus'    => $Conn->UtilCheckNotNullIsNumeric($conStatus) ? $conStatus : NULL,
                            'perKey'       => $Conn->UtilCheckNotNull($perKey) ? $perKey : '',
                            'perBu1Code'   => $Conn->UtilCheckNotNull($perBu1Code) ? $perBu1Code : '',
                            'temId'        => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : NULL,
                            'memOwner'     => $Conn->UtilCheckNotNullIsNumeric($memOwner) ? $memOwner : NULL,
                            'memDraft'     => $Conn->UtilCheckNotNullIsNumeric($memDraft) ? $memDraft : NULL,
                            'memView'      => $Conn->UtilCheckNotNullIsNumeric($memView) ? $memView : NULL,
                            'memSign'      => $Conn->UtilCheckNotNullIsNumeric($memSign) ? $memSign : NULL,
                            'memOver'      => $Conn->UtilCheckNotNullIsNumeric($memOver) ? $memOver : NULL,
                            'conStatusNot' => $Conn->UtilCheckNotNullIsNumeric($conStatusNot) ? $conStatusNot : NULL,
                            'conMark'      => $Conn->UtilCheckNotNullIsNumeric($conMark) ? $conMark : NULL,
                            'conInh'       => $Conn->UtilCheckNotNullIsNumeric($conInh) ? $conInh : NULL
            );
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS T.`temId`, T.`temTitle`, C.`conId`, C.`conTitle`, C.`conStatus`, C.`conSerial`, C.`conVer`, C.`conCreateTime`, C.`comCode`, C.`perKey`, C.`conType`, F.`frmTitle`, P.`perBu1`, P.`perBu2`, P.`perBu3`, CM.`comTitle`, M.`memOwner`, M.`memDraft`, M.`memView`, M.`memSign`, M.`memOver` FROM `contract` C
                     LEFT JOIN `template` T ON T.`temId` = C.`temId`
                     LEFT JOIN `company` CM ON CM.`comCode` = C.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     LEFT JOIN `frame` F ON F.`frmId` = C.`frmId`
                     LEFT JOIN (
                                SELECT M.`conId`, COUNT(*) AS `CT`, 
                                    CASE WHEN SUM(`memOwner`) > 0 THEN 1 ELSE 0 END AS `memOwner`,
                                    CASE WHEN SUM(`memDraft`) > 0 THEN 1 ELSE 0 END AS `memDraft`,
                                    CASE WHEN SUM(`memView`) > 0 THEN 1 ELSE 0 END AS `memView`,
                                    CASE WHEN SUM(`memSign`) > 0 THEN 1 ELSE 0 END AS `memSign`,
                                    CASE WHEN SUM(`memOver`) > 0 THEN 1 ELSE 0 END AS `memOver` FROM (
                                        SELECT M.`conId`, 
                                            CASE WHEN (M.`memType` = 0 AND M.`memLV0Key` = :perKey) THEN 1 ELSE 0 END AS `memOwner`,
                                            CASE WHEN (M.`memType` = 0 AND M.`memLV0Status` = -1) THEN 1 ELSE 0 END AS `memDraft`,
                                            CASE WHEN (M.`memType` = 0 AND M.`memLVCStatus` = 0 AND CT.`perKey` = :perKey) OR 
                                                      (M.`memNowKey` = :perKey AND M.`memNowStatus` = 0) THEN 1 ELSE 0 END AS `memView`,
                                            CASE WHEN (M.`memType` = 0 AND M.`memLVCStatus` = 1 AND CT.`perKey` = :perKey) OR 
                                                      (M.`memNowKey` = :perKey AND M.`memNowStatus` = 1) THEN 1 ELSE 0 END AS `memSign`,
                                            CASE WHEN (M.`memType` = 0 AND M.`memLVCStatus` = 3 AND CT.`perKey` = :perKey) OR 
                                                      (M.`memLV0Key` = :perKey AND M.`memLV0Status` = 3) OR
                                                      (M.`memLV1Key` = :perKey AND M.`memLV1Status` = 3) OR
                                                      (M.`memLV2Key` = :perKey AND M.`memLV2Status` = 3) THEN 1 ELSE 0 END AS `memOver`
                                        FROM `member` M
                                        LEFT JOIN `company` CP ON CP.`comCode` = M.`memBu1Code`
                                        LEFT JOIN `contact` CT ON CP.`comCode` = CT.`comCode` AND CT.`perKey` = :perKey
                                        WHERE 1=1 
                                            AND (
                                                ((M.`memType` = 0 AND M.`memLV0Key` = :perKey) OR (M.`memType` != 0 AND M.`memLV0Key` = :perKey AND M.`memLV0Status` NOT IN (-1, 2))) OR
                                                (M.`memLV0Key` = :perKey AND M.`memLV0Status` != -1) OR
                                                (M.`memType` = 0 AND M.`memLVCStatus` != -1 AND M.`memLV0Status` = 3 AND CT.`perKey` =:perKey) OR
                                                (M.`memLV1Key` = :perKey AND M.`memLV1Status` NOT IN (-1, 2) AND ((M.`memType` = 0 AND M.`memLVCStatus` = 3) OR (M.`memType` != 0 AND M.`memLV0Status` = 3))) OR
                                                (M.`memLV2Key` = :perKey AND M.`memLV2Status` NOT IN (-1, 2) AND M.`memLV1Status` = 3)
                                            )
                                        ) M
                                GROUP BY M.`conId`, M.`memOwner`, M.`memDraft`, M.`memView`, M.`memSign`, M.`memOver`
                                ) M ON M.`conId` = C.`conId`
                     WHERE 1 = 1';
            $sql .= $Conn->UtilCheckNotNull($keyword) ? ' AND (C.`conTitle` REGEXP :keyword OR CONCAT(C.`conSerial`, C.`conVer`) REGEXP :keyword)' : '';
            $sql .= $Conn->UtilCheckNotNull($conSerial) ? ' AND C.`conSerial` = :conSerial' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($comId) ? ' AND CM.`comId` = :comId' : '';
            $sql .= $Conn->UtilCheckNotNull($comCode) ? ' AND C.`comCode` = :comCode' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conStatus) ? ' AND C.`conStatus` = :conStatus' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($temId) ? ' AND C.`temId` = :temId' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conStatusNot) ? ' AND C.`conStatus` != :conStatusNot' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conMark) ? ' AND C.`conMark` = :conMark' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conInh) ? ' AND C.`conInh` = :conInh' : '';
            $sql .= ' AND ((M.`CT` > 0 AND C.`conStatus` IN (0, 1, 3)) OR (CM.`comCode` = :perBu1Code AND C.`perKey` = :perKey AND C.`conStatus` IN (0, 2, 4)))';
            if ($Conn->UtilCheckNotNullIsNumeric($memOwner) || $Conn->UtilCheckNotNullIsNumeric($memDraft) || $Conn->UtilCheckNotNullIsNumeric($memView) || $Conn->UtilCheckNotNullIsNumeric($memSign) || $Conn->UtilCheckNotNullIsNumeric($memOver)) {
                $sql .= ' AND (1=2';
                $sql .= $Conn->UtilCheckNotNullIsNumeric($memOwner) ? ' OR M.`memOwner` = :memOwner' : '';
                $sql .= $Conn->UtilCheckNotNullIsNumeric($memDraft) ? ' OR M.`memDraft` = :memDraft' : '';
                $sql .= $Conn->UtilCheckNotNullIsNumeric($memView) ? ' OR M.`memView` = :memView' : '';
                $sql .= $Conn->UtilCheckNotNullIsNumeric($memSign) ? ' OR M.`memSign` = :memSign' : '';
                $sql .= $Conn->UtilCheckNotNullIsNumeric($memOver) ? ' OR M.`memOver` = :memOver' : '';
                $sql .= ' )';
            }
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:querySearch 查看文件費用資料
         *
         * @param $contract_search
         * @param $apportion_search
         * @param $keyword
         * @param $temId
         * @param $comId
         * @param $comCode
         * @param $frmId
         * @param $conSerial
         * @param $status
         * @param $perKey
         * @param $perBu1Code
         * @param $perBu2Code
         * @param $perBu3Code
         * @param $memOwner 1:擁有者
         * @param $memDraft 1:草稿
         * @param $memView  1:待檢視
         * @param $memSign  1:待簽
         * @param $memOver  1:已簽
         * @param $statusNot
         * @param $mark     1:棄用
         * @param $inh      1:被繼承
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function querySearch($contract_search, $apportion_search, $keyword, $temId, $comId, $comCode, $frmId, $conSerial, $status, $perKey, $perBu1Code, $perBu2Code, $perBu3Code, $memOwner, $memDraft, $memView, $memSign, $memOver, $statusNot, $mark, $inh, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('keyword'    => $Conn->UtilCheckNotNull($keyword) ? $Conn->getRegexpString($keyword, '|') : NULL,
                            'conSerial'  => $Conn->UtilCheckNotNull($conSerial) ? $conSerial : NULL,
                            'comId'      => $Conn->UtilCheckNotNullIsNumeric($comId) ? $comId : NULL,
                            'comCode'    => $Conn->UtilCheckNotNull($comCode) ? $comCode : NULL,
                            'frmId'      => $Conn->UtilCheckNotNullIsNumeric($frmId) ? $frmId : NULL,
                            'status'     => $Conn->UtilCheckNotNullIsNumeric($status) ? $status : NULL,
                            'perKey'     => $Conn->UtilCheckNotNull($perKey) ? $perKey : '',
                            'perBu1Code' => $Conn->UtilCheckNotNull($perBu1Code) ? $perBu1Code : '',
                            'perBu2Code' => $Conn->UtilCheckNotNull($perBu2Code) ? $perBu2Code : '',
                            'perBu3Code' => $Conn->UtilCheckNotNull($perBu3Code) ? $perBu3Code : '',
                            'temId'      => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : NULL,
                            'memOwner'   => $Conn->UtilCheckNotNullIsNumeric($memOwner) ? $memOwner : NULL,
                            'memDraft'   => $Conn->UtilCheckNotNullIsNumeric($memDraft) ? $memDraft : NULL,
                            'memView'    => $Conn->UtilCheckNotNullIsNumeric($memView) ? $memView : NULL,
                            'memSign'    => $Conn->UtilCheckNotNullIsNumeric($memSign) ? $memSign : NULL,
                            'memOver'    => $Conn->UtilCheckNotNullIsNumeric($memOver) ? $memOver : NULL,
                            'statusNot'  => $Conn->UtilCheckNotNullIsNumeric($statusNot) ? $statusNot : NULL,
                            'mark'       => $Conn->UtilCheckNotNullIsNumeric($mark) ? $mark : NULL,
                            'inh'        => $Conn->UtilCheckNotNullIsNumeric($inh) ? $inh : NULL
            );
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS T.`temId`, T.`temTitle`, T.`temExes`, C.*, F.`frmTitle`, P.`perBu1`, P.`perBu2`, P.`perBu3`, CM.`comTitle`, M.`memOwner`, M.`memDraft`, M.`memView`, M.`memSign`, M.`memOver` 
                     FROM (
                        SELECT * FROM (
                            SELECT 0 AS `Type`, C.`conId`, C.`conApp`, CASE WHEN C.`conApp` < 0 THEN 0 ELSE C.`conApp` END AS `appId`, C.`conTitle`, C.`conType`, A.`appType`, C.`temId`, C.`perKey`, C.`comCode`, C.`frmId`, C.`conSerial`, `C`.`conVer`, A.`appYear`, A.`appVer`, C.`conMark`, A.`appMark`, C.`conMark` AS `Mark`, C.`conInh`, A.`appInh`, C.`conInh` AS `Inh`, C.`conStatus`, A.`appStatus`, C.`conStatus` AS `Status`, C.`conDate`, A.`appDate`, C.`conDate` AS `Date`, C.`conCreateTime`, A.`appCreateTime` FROM `contract` C
                            LEFT JOIN `apportion` A ON C.`conApp` = `A`.`appId`
                        ) C
                        UNION
                        SELECT * FROM (
                            SELECT 1 AS `Type`, A.`conId`, 0, A.`appId`, C.`conTitle`, C.`conType`, A.`appType`, C.`temId`, A.`perKey`, A.`comCode`, C.`frmId`, C.`conSerial`, `C`.`conVer`, A.`appYear`, A.`appVer`, C.`conMark`, A.`appMark`, A.`appMark` AS `Mark`, C.`conInh`, A.`appInh`, A.`appInh` AS `Inh`, C.`conStatus`, A.`appStatus`, A.`appStatus` AS `Status`, C.`conDate`, A.`appDate`, A.`appDate` AS `Date`, C.`conCreateTime`, A.`appCreateTime` FROM `apportion` A
                            LEFT JOIN `contract` C ON C.`conId` = A.`conId`
                        ) A
                     ) C
                     LEFT JOIN `template` T ON T.`temId` = C.`temId`
                     LEFT JOIN `company` CM ON CM.`comCode` = C.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     LEFT JOIN `frame` F ON F.`frmId` = C.`frmId`
                     LEFT JOIN (
                                SELECT M.`conId`, M.`appId`, COUNT(*) AS `CT`, 
                                    CASE WHEN SUM(`memOwner`) > 0 THEN 1 ELSE 0 END AS `memOwner`,
                                    CASE WHEN SUM(`memDraft`) > 0 THEN 1 ELSE 0 END AS `memDraft`,
                                    CASE WHEN SUM(`memView`) > 0 THEN 1 ELSE 0 END AS `memView`,
                                    CASE WHEN SUM(`memSign`) > 0 THEN 1 ELSE 0 END AS `memSign`,
                                    CASE WHEN SUM(`memOver`) > 0 THEN 1 ELSE 0 END AS `memOver` FROM (
                                        SELECT M.`conId`, M.`appId`, 
                                            CASE WHEN (M.`memType` = 0 AND M.`memLV0Key` = :perKey) THEN 1 ELSE 0 END AS `memOwner`,
                                            CASE WHEN (M.`memType` = 0 AND M.`memLV0Status` = -1) THEN 1 ELSE 0 END AS `memDraft`,
                                            CASE WHEN (M.`memType` = 0 AND M.`memLVCStatus` = 0 AND CT.`perKey` = :perKey) OR 
                                                      (M.`memType` = 0 AND M.`memBu1Code` = :perBu1Code AND M.`memBu2Code` = :perBu2Code AND M.`memBu3Code` = :perBu3Code) OR
                                                      (M.`memNowKey` = :perKey AND M.`memNowStatus` = 0) THEN 1 ELSE 0 END AS `memView`,
                                            CASE WHEN (M.`memType` = 0 AND M.`memLVCStatus` = 1 AND CT.`perKey` = :perKey) OR 
                                                      (M.`memNowKey` = :perKey AND M.`memNowStatus` = 1) THEN 1 ELSE 0 END AS `memSign`,
                                            CASE WHEN (M.`memType` = 0 AND M.`memLVCStatus` = 3 AND CT.`perKey` = :perKey) OR 
                                                      (M.`memLV0Key` = :perKey AND M.`memLV0Status` = 3) OR
                                                      (M.`memLV1Key` = :perKey AND M.`memLV1Status` = 3) OR
                                                      (M.`memLV2Key` = :perKey AND M.`memLV2Status` = 3) THEN 1 ELSE 0 END AS `memOver`
                                        FROM `member` M
                                        LEFT JOIN `company` CP ON CP.`comCode` = M.`memBu1Code`
                                        LEFT JOIN `contact` CT ON CP.`comCode` = CT.`comCode` AND CT.`perKey` = :perKey
                                        WHERE 1=1 
                                            AND (
                                                ((M.`memType` = 0 AND M.`memLV0Key` = :perKey) OR (M.`memType` != 0 AND M.`memLV0Key` = :perKey AND M.`memLV0Status` NOT IN (-1, 2))) OR
                                                (M.`memLV0Key` = :perKey AND M.`memLV0Status` != -1) OR
                                                (M.`memType` = 0 AND M.`memBu1Code` = :perBu1Code AND M.`memBu2Code` = :perBu2Code AND M.`memBu3Code` = :perBu3Code) OR
                                                (M.`memType` = 0 AND M.`memLVCStatus` != -1 AND M.`memLV0Status` = 3 AND CT.`perKey` =:perKey) OR
                                                (M.`memLV1Key` = :perKey AND M.`memLV1Status` NOT IN (-1, 2) AND ((M.`memType` = 0 AND M.`memLVCStatus` = 3) OR (M.`memType` != 0 AND M.`memLV0Status` = 3))) OR
                                                (M.`memLV2Key` = :perKey AND M.`memLV2Status` NOT IN (-1, 2) AND M.`memLV1Status` = 3)
                                            )
                                        ) M
                                GROUP BY M.`conId`, M.`appId`, M.`memOwner`, M.`memDraft`, M.`memView`, M.`memSign`, M.`memOver`
                                ) M ON M.`conId` = C.`conId` AND M.`appId` = C.`appId`
                     WHERE 1 = 1';
            $sql .= $Conn->UtilCheckNotNull($keyword) ? ' AND (C.`conTitle` REGEXP :keyword OR CONCAT(C.`conSerial`, C.`conVer`) REGEXP :keyword)' : '';
            $sql .= $Conn->UtilCheckNotNull($conSerial) ? ' AND C.`conSerial` = :conSerial' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($comId) ? ' AND CM.`comId` = :comId' : '';
            $sql .= $Conn->UtilCheckNotNull($comCode) ? ' AND C.`comCode` = :comCode' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($frmId) ? ' AND F.`frmId` = :frmId' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($status) ? ' AND C.`Status` = :status' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($temId) ? ' AND C.`temId` = :temId' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($statusNot) ? ' AND C.`Status` != :statusNot' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($mark) ? ' AND C.`Mark` = :mark' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($inh) ? ' AND C.`Inh` = :inh' : '';
            $sql .= ' AND ((M.`CT` > 0 AND C.`Status` IN (0, 1, 3)) OR (M.`CT` IS NULL AND C.`perKey` = :perKey AND C.`Status` >= 0))';
            if ($Conn->UtilCheckNotNullIsNumeric($memOwner) || $Conn->UtilCheckNotNullIsNumeric($memDraft) || $Conn->UtilCheckNotNullIsNumeric($memView) || $Conn->UtilCheckNotNullIsNumeric($memSign) || $Conn->UtilCheckNotNullIsNumeric($memOver)) {
                $sql .= ' AND (1=2';
                $sql .= $Conn->UtilCheckNotNullIsNumeric($memOwner) ? ' OR M.`memOwner` = :memOwner  OR C.`perKey` = :perKey' : '';
                $sql .= $Conn->UtilCheckNotNullIsNumeric($memDraft) ? ' OR M.`memDraft` = :memDraft OR C.`perKey` = :perKey' : '';
                $sql .= $Conn->UtilCheckNotNullIsNumeric($memView) ? ' OR M.`memView` = :memView' : '';
                $sql .= $Conn->UtilCheckNotNullIsNumeric($memSign) ? ' OR M.`memSign` = :memSign' : '';
                $sql .= $Conn->UtilCheckNotNullIsNumeric($memOver) ? ' OR M.`memOver` = :memOver' : '';
                $sql .= ' )';
            }
            $sql .= ' AND C.`Status` != -1';
            if (1== $contract_search || 1 == $apportion_search) {
                $sql .= ' AND (1=2';
                $sql .= 1 == $contract_search ? ' OR C.`Type` = 0' : '';
                $sql .= 1 == $apportion_search ? ' OR C.`Type` = 1' : '';
                $sql .= ' )';
            }
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryContractByID 查看單一文件
         *
         * @param $rows
         * @param $conId
         *
         * @return mixed
         */
        function queryContractByID($rows, $conId)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId' => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : 0);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contract` C
                     LEFT JOIN `template` T ON T.`temId` = C.`temId`
                     LEFT JOIN `company` CM ON CM.`comCode` = C.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     LEFT JOIN `frame` F ON F.`frmId` = C.`frmId`
                     WHERE C.`conId` = :conId';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryContractByID 查看單一文件
         *
         * @param $rows
         * @param $conInh
         *
         * @return mixed
         */
        function queryContractByInh($rows, $conInh)
        {
            $Conn = new ConnManager();
            $arrPar = array('conInh' => $Conn->UtilCheckNotNullIsNumeric($conInh) ? $conInh : -1);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contract`
                     WHERE `conInh` = :conInh';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:insertContract 新增文件
         *
         * @param $temId
         * @param $perKey
         * @param $comCode
         * @param $frmId
         * @param $conSerial
         * @param $conVer
         * @param $conMark
         * @param $conTitle
         * @param $conType
         * @param $conDate
         * @param $conWork
         * @param $conCompany
         * @param $conValue
         * @param $conApp
         * @param $conStatus
         *
         * @return array|int|Number
         */
        function insertContract($temId, $perKey, $comCode, $frmId, $conSerial, $conVer, $conMark, $conTitle, $conType, $conDate, $conWork, $conCompany, $conValue, $conApp, $conStatus)
        {
            $Conn = new ConnManager();
            $arrPar = array('temId'      => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : 0,
                            'perKey'     => $Conn->UtilCheckNotNull($perKey) ? $perKey : '',
                            'comCode'    => $Conn->UtilCheckNotNull($comCode) ? $comCode : 0,
                            'frmId'      => $Conn->UtilCheckNotNull($frmId) ? $frmId : 0,
                            'conSerial'  => $Conn->UtilCheckNotNull($conSerial) ? $conSerial : '',
                            'conVer'     => $Conn->UtilCheckNotNull($conVer) ? $conVer : 'A',
                            'conMark'    => $Conn->UtilCheckNotNullIsNumeric($conMark) ? $conMark : 0,
                            'conTitle'   => $Conn->UtilCheckNotNull($conTitle) ? $conTitle : '',
                            'conType'    => $Conn->UtilCheckNotNullIsNumeric($conType) ? $conType : 0,
                            'conDate'    => $Conn->UtilCheckNotNullIsDate($conDate) ? $conDate : NULL,
                            'conWork'    => $Conn->UtilCheckNotNull($conWork) ? $conWork : '',
                            'conCompany' => $Conn->UtilCheckNotNull($conCompany) ? $conCompany : '',
                            'conValue'   => $Conn->UtilCheckNotNull($conValue) ? $conValue : '',
                            'conApp'     => $Conn->UtilCheckNotNullIsNumeric($conApp) ? $conApp : -1,
                            'conStatus'  => $Conn->UtilCheckNotNullIsNumeric($conStatus) ? $conStatus : -1);
            //SQL
            $sql = ' INSERT INTO `contract`(`temId`, `perKey`, `comCode`, `frmId`, `conSerial`, `conVer`, `conMark`, `conTitle`, `conType`, `conDate`, `conWork`, `conCompany`, `conValue`, `conApp`, `conStatus`, `conUpdateTime`, `conCreateTime`)
                     VALUES(:temId, :perKey, :comCode, :frmId, :conSerial, :conVer, :conMark, :conTitle, :conType, '.($Conn->UtilCheckNotNullIsDate($conDate) ? ':conDate' : 'NULL').', :conWork, :conCompany, :conValue, :conApp, :conStatus, NOW(), NOW())';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:copyContract 複製文件
         *
         * @param $conId
         * @param $conType
         * @param $conSerial
         * @param $conVer
         * @param $conMark
         * @param $conStatus
         *
         * @return array|int|Number
         */
        function copyContract($conId, $conType, $conSerial, $conVer, $conMark, $conStatus)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'     => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : 0,
                            'conType'   => $Conn->UtilCheckNotNullIsNumeric($conType) ? $conType : 0,
                            'conSerial' => $Conn->UtilCheckNotNull($conSerial) ? $conSerial : NULL,
                            'conVer'    => $Conn->UtilCheckNotNull($conVer) ? $conVer : 'A',
                            'conMark'   => $Conn->UtilCheckNotNullIsNumeric($conMark) ? $conMark : 0,
                            'conStatus' => $Conn->UtilCheckNotNullIsNumeric($conStatus) ? $conStatus : -1);
            //SQL
            $sql = ' INSERT INTO `contract`(`temId`, `perKey`, `comCode`, `frmId`, `conSerial`, `conVer`, `conMark`, `conTitle`, `conType`, `conDate`, `conWork`, `conCompany`, `conValue`, `conStatus`, `conInh`, `conUpdateTime`, `conCreateTime`)
                     SELECT `temId`, `perKey`, `comCode`, `frmId`, '.($Conn->UtilCheckNotNull($conSerial) ? ':conSerial' : '`conSerial`').', :conVer, :conMark, `conTitle`, :conType, `conDate`, `conWork`, `conCompany`, `conValue`, :conStatus, 0, NOW(), NOW() FROM `contract` WHERE `conId` = :conId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:updateContractByID 修改文件
         *
         * @param $conTitle
         * @param $frmId
         * @param $conDate
         * @param $conWork
         * @param $conCompany
         * @param $conValue
         * @param $conApp
         * @param $conLock
         * @param $conId
         * @param $conStatus
         *
         * @return array|int
         */
        function updateContractByID($conId, $conTitle, $frmId, $conDate, $conWork, $conCompany, $conValue, $conApp, $conLock, $conStatus)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'      => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : '',
                            'conTitle'   => $Conn->UtilCheckNotNull($conTitle) ? $conTitle : '',
                            'frmId'      => $Conn->UtilCheckNotNullIsNumeric($frmId) ? $frmId : 0,
                            'conDate'    => $Conn->UtilCheckNotNullIsDate($conDate) ? $conDate : NULL,
                            'conWork'    => $Conn->UtilCheckNotNull($conWork) ? $conWork : '',
                            'conCompany' => $Conn->UtilCheckNotNull($conCompany) ? $conCompany : '',
                            'conValue'   => $Conn->UtilCheckNotNull($conValue) ? $conValue : '',
                            'conApp'     => $Conn->UtilCheckNotNullIsNumeric($conApp) ? $conApp : NULL,
                            'conLock'    => $Conn->UtilCheckNotNullIsNumeric($conLock) ? $conLock : NULL,
                            'conStatus'  => $Conn->UtilCheckNotNullIsNumeric($conStatus) ? $conStatus : NULL);
            //SQL
            $sql = ' UPDATE `contract`
                     SET `conTitle` = :conTitle, `frmId` = :frmId, `conDate` = '.($Conn->UtilCheckNotNullIsDate($conDate) ? ':conDate' : 'NULL').', `conWork` = :conWork, `conCompany` = :conCompany, `conValue` = :conValue, `conUpdateTime` = NOW()';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conStatus) ? ', `conStatus` = :conStatus' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conApp) ? ' , `conApp` = :conApp' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conLock) ? ' , `conLock` = :conLock' : '';
            $sql .= '  WHERE `conId` = :conId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:updateContractUpdateTimeByID 修改文件修改時間
         *
         * @param $conId
         *
         * @return array|int
         */
        function updateContractUpdateTimeByID($conId)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId' => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : '');
            //SQL
            $sql = ' UPDATE `contract`
                     SET `conUpdateTime` = NOW()';
            $sql .= ' WHERE `conId` = :conId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:updateContractStatusByID 修改文件狀態
         *
         * @param $conStatus
         * @param $conDate
         * @param $conId
         *
         * @return array|int
         */
        function updateContractStatusByID($conId, $conStatus, $conDate)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'     => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : '',
                            'conDate'   => $Conn->UtilCheckNotNullIsDate($conDate) ? $conDate : NULL,
                            'conStatus' => $Conn->UtilCheckNotNullIsNumeric($conStatus) ? $conStatus : 0);
            //SQL
            $sql = ' UPDATE `contract`
                     SET `conStatus` = :conStatus, `conUpdateTime` = NOW()';
            $sql .= $Conn->UtilCheckNotNullIsDate($conDate) ? ' , `conDate` = :conDate' : '';
            $sql .= ' WHERE `conId` = :conId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:updateContractMarkByID 修改文件作廢
         *
         * @param $conId
         * @param $conMark
         *
         * @return array|int
         */
        function updateContractMarkByID($conId, $conMark)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'   => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : 0,
                            'conMark' => $Conn->UtilCheckNotNullIsNumeric($conMark) ? $conMark : 0);
            //SQL
            $sql = ' UPDATE `contract`
                     SET `conMark` = :conMark, `conUpdateTime` = NOW()';
            $sql .= ' WHERE `conId` = :conId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:updateContractInheritByID 修改文件繼承
         *
         * @param $conId
         * @param $conInh
         *
         * @return array|int
         */
        function updateContractInheritByID($conId, $conInh)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'  => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : 0,
                            'conInh' => $Conn->UtilCheckNotNullIsNumeric($conInh) ? $conInh : 0);
            //SQL
            $sql = ' UPDATE `contract`
                     SET `conInh` = :conInh, `conUpdateTime` = NOW()';
            $sql .= ' WHERE `conId` = :conId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:updateContractInheritByID 修改文件繼承
         *
         * @param $conId
         * @param $conLock
         *
         * @return array|int
         */
        function updateContractLockByID($conId, $conLock)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'   => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : 0,
                            'conLock' => $Conn->UtilCheckNotNullIsNumeric($conLock) ? $conLock : 0);
            //SQL
            $sql = ' UPDATE `contract`
                     SET `conLock` = :conLock, `conUpdateTime` = NOW()';
            $sql .= ' WHERE `conId` = :conId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:updateContractAppByID 修改文件綁定的費用
         *
         * @param $conId
         * @param $conApp
         *
         * @return array|int
         */
        function updateContractAppByID($conId, $conApp)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'  => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : 0,
                            'conApp' => $Conn->UtilCheckNotNullIsNumeric($conApp) ? $conApp : 0);
            //SQL
            $sql = ' UPDATE `contract`
                     SET `conApp` = :conApp, `conUpdateTime` = NOW()';
            $sql .= ' WHERE `conId` = :conId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:cleanContractInheritByID 清除文件繼承
         *
         * @param $conInh
         *
         * @return array|int
         */
        function cleanContractInheritByID($conInh)
        {
            $Conn = new ConnManager();
            $arrPar = array('conInh' => $Conn->UtilCheckNotNullIsDate($conInh) ? $conInh : 0);
            //SQL
            $sql = ' UPDATE `contract`
                     SET `conInh` = 0, `conUpdateTime` = NOW()';
            $sql .= ' WHERE `conInh` = :conInh AND `conMark` = 0';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:updateContractDateByID 修改文件生效日期
         *
         * @param $conDate
         * @param $conId
         *
         * @return array|int
         */
        function updateContractDateByID($conId, $conDate)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'   => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : '',
                            'conDate' => $Conn->UtilCheckNotNullIsDate($conDate) ? $conDate : '');
            //SQL
            $sql = ' UPDATE `contract`
                     SET `conDate` = :conDate, `conUpdateTime` = NOW()
                     WHERE `conId` = :conId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }


        /**
         * todo:deleteContractByID 刪除文件
         *
         * @param int $conId 編號
         *
         * @return int|boolean
         */
        function deleteContractByID($conId)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId' => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : 0);
            //SQL
            $sql = ' DELETE FROM `contract`
                     WHERE `conId` = :conId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:querySignLog 查看文件Log
         *
         * @param $rows
         * @param $conId
         * @param $appId
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function querySignLog($rows, $conId, $appId, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId' => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `signLog` SL';
            $sql .= ' LEFT JOIN `contract` C ON C.`conId` = SL.`conId`';
            $sql .= ' LEFT JOIN `apportion` A ON A.`appId` = SL.`appId`';
            $sql .= ' LEFT JOIN `member` M ON M.`memId` = SL.`memId`';
            $sql .= ' LEFT JOIN `personnel` P ON P.`perKey` = SL.`perKey`';
            $sql .= ' WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conId) ? ' AND SL.`conId` = :conId' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($appId) ? ' AND SL.`appId` = :appId' : '';
            $sql .= $Conn->getLimit($anum, $num);
            $sql .= ' ORDER BY `sglCreateTime` ASC';
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:insertSignLog 新增文件Log
         *
         * @param $conId
         * @param $appId
         * @param $memId
         * @param $perKey
         * @param $colMemberStatus
         * @param $colMsg
         * @param $colStatus
         *
         * @return array|int|Number
         */
        function insertSignLog($conId, $appId, $memId, $perKey, $colMemberStatus, $colMsg, $colStatus)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'           => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : 0,
                            'appId'           => $Conn->UtilCheckNotNullIsNumeric($appId) ? $appId : 0,
                            'memId'           => $Conn->UtilCheckNotNullIsNumeric($memId) ? $memId : 0,
                            'perKey'          => $Conn->UtilCheckNotNull($perKey) ? $perKey : '',
                            'colMemberStatus' => $Conn->UtilCheckNotNullIsNumeric($colMemberStatus) ? $colMemberStatus : -1,
                            'colMsg'          => $Conn->UtilCheckNotNull($colMsg) ? $colMsg : '',
                            'colStatus'       => $Conn->UtilCheckNotNullIsNumeric($colStatus) ? $colStatus : -1);
            //SQL
            $sql = ' INSERT INTO `signLog`(`conId`, `appId`, `memId`, `perKey`, `sglMemberStatus`, `sglMsg`, `sglStatus`, `sglCreateTime`)
                     VALUES(:conId, :appId, :memId, :perKey, :colMemberStatus, :colMsg, :colStatus, NOW())';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:deleteContractLogByContract 刪除文件相關文件Log
         *
         * @param int $conId 編號
         *
         * @return int|boolean
         */
        function deleteContractLogByContract($conId)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId' => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : '');
            //SQL
            $sql = ' DELETE FROM `signLog`
                     WHERE `conId` = :conId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }


        /**
         * todo:queryContractByMember 查看文件簽核-參與者
         *
         * @param $rows
         * @param $temId
         * @param $conId
         * @param $conType
         * @param $conSerial
         * @param $comCode
         * @param $conStatus
         * @param $memType
         * @param $memLV0Key
         * @param $memLV0Status
         * @param $memLVCKey
         * @param $memLVCStatus
         * @param $memLV1Key
         * @param $memLV1Status
         * @param $memLV2Key
         * @param $memLV2Status
         * @param $memNowKey
         * @param $memNowStatus
         * @param $memStatus
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryContractByMember($rows, $temId, $conId, $conType, $conSerial, $comCode, $conStatus, $memType, $memLV0Key, $memLV0Status, $memLVCKey, $memLVCStatus, $memLV1Key, $memLV1Status, $memLV2Key, $memLV2Status, $memNowKey, $memNowStatus, $memStatus, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('temId'        => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : NULL,
                            'conId'        => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : NULL,
                            'conType'      => $Conn->UtilCheckNotNullIsNumeric($conType) ? $conType : NULL,
                            'conSerial'    => $Conn->UtilCheckNotNull($conSerial) ? $conSerial : NULL,
                            'comCode'      => $Conn->UtilCheckNotNull($comCode) ? $comCode : NULL,
                            'conStatus'    => $Conn->UtilCheckNotNullIsNumeric($conStatus) ? $conStatus : NULL,
                            'memType'      => $Conn->UtilCheckNotNullIsNumeric($memType) ? $memType : NULL,
                            'memLV0Key'    => $Conn->UtilCheckNotNull($memLV0Key) ? $memLV0Key : NULL,
                            'memLV0Status' => $Conn->UtilCheckNotNullIsNumeric($memLV0Status) ? $memLV0Status : NULL,
                            'memLVCKey'    => $Conn->UtilCheckNotNull($memLVCKey) ? $memLVCKey : NULL,
                            'memLVCStatus' => $Conn->UtilCheckNotNullIsNumeric($memLVCStatus) ? $memLVCStatus : NULL,
                            'memLV1Key'    => $Conn->UtilCheckNotNull($memLV1Key) ? $memLV1Key : NULL,
                            'memLV1Status' => $Conn->UtilCheckNotNullIsNumeric($memLV1Status) ? $memLV1Status : NULL,
                            'memLV2Key'    => $Conn->UtilCheckNotNull($memLV2Key) ? $memLV2Key : NULL,
                            'memLV2Status' => $Conn->UtilCheckNotNullIsNumeric($memLV2Status) ? $memLV2Status : NULL,
                            'memNowKey'    => $Conn->UtilCheckNotNull($memNowKey) ? $memNowKey : NULL,
                            'memNowStatus' => $Conn->UtilCheckNotNullIsNumeric($memNowStatus) ? $memNowStatus : NULL,
                            'memStatus'    => $Conn->UtilCheckNotNullIsNumeric($memStatus) ? $memStatus : NULL);
            //SQL
            $member_sql = ' AND ( 1=2';
            if ($Conn->UtilCheckNotNull($memLV0Key) || $Conn->UtilCheckNotNullIsNumeric($memLV0Status)) {
                $member_sql .= ' OR ( WHERE 1=1';
                $member_sql .= $Conn->UtilCheckNotNull($memLV0Key) ? ' AND M.`memLV0Key` = :memLV0Key' : '';
                $member_sql .= $Conn->UtilCheckNotNullIsNumeric($memLV0Status) ? ' AND M.`memLV0Status` = :memLV0Status' : '';
                $member_sql .= ' )';
            }
            if ($Conn->UtilCheckNotNull($memLVCKey) || $Conn->UtilCheckNotNullIsNumeric($memLVCStatus)) {
                $member_sql .= ' OR ( WHERE 1=1';
                $member_sql .= $Conn->UtilCheckNotNull($memLVCKey) ? ' AND M.`memLVCKey` = :memLVCKey' : '';
                $member_sql .= $Conn->UtilCheckNotNullIsNumeric($memLVCStatus) ? ' AND M.`memLVCStatus` = :memLVCStatus' : '';
                $member_sql .= ' )';
            }
            if ($Conn->UtilCheckNotNull($memLV1Key) || $Conn->UtilCheckNotNullIsNumeric($memLV1Status)) {
                $member_sql .= ' OR ( WHERE 1=1';
                $member_sql .= $Conn->UtilCheckNotNull($memLV1Key) ? ' AND M.`memLV1Key` = :memLV1Key' : '';
                $member_sql .= $Conn->UtilCheckNotNullIsNumeric($memLV1Status) ? ' AND M.`memLV1Status` = :memLV1Status' : '';
                $member_sql .= ' )';
            }
            if ($Conn->UtilCheckNotNull($memLV2Key) || $Conn->UtilCheckNotNullIsNumeric($memLV2Status)) {
                $member_sql .= ' OR ( WHERE 1=1';
                $member_sql .= $Conn->UtilCheckNotNull($memLV2Key) ? ' AND M.`memLV2Key` = :memLV2Key' : '';
                $member_sql .= $Conn->UtilCheckNotNullIsNumeric($memLV2Status) ? ' AND M.`memLV2Status` = :memLV2Status' : '';
                $member_sql .= ' )';
            }
            $member_sql .= ' )';
            $member_sql .= $Conn->UtilCheckNotNull($memNowKey) ? ' AND M.`memNowKey` = :memNowKey' : '';
            $member_sql .= $Conn->UtilCheckNotNullIsNumeric($memNowStatus) ? ' AND M.`memNowStatus` = :memNowStatus' : '';
            $member_sql .= $Conn->UtilCheckNotNullIsNumeric($memStatus) ? ' AND M.`memStatus` = :memStatus' : '';

            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contract` C
                     LEFT JOIN (
                                   SELECT COUNT(*) AS `CT`, `conId` FROM `contract` C
                                   LEFT JOIN `member` M ON M.`conId` = C.`conId`
                                   WHERE 1=1 '.$member_sql.'
                                   GROUP BY C.`conId`
                               ) DT ON DT.`conId` = C.`conId`
                     WHERE DT.`CT` > 0';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($temId) ? ' AND C.`temId` = :temId' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conId) ? ' AND C.`conId` = :conId' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conType) ? ' AND C.`conType` = :conType' : '';
            $sql .= $Conn->UtilCheckNotNull($conSerial) ? ' AND C.`conSerial` = :conSerial' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($comCode) ? ' AND C.`comCode` = :comCode' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conStatus) ? ' AND C.`conStatus` = :conStatus' : '';
            $sql .= ' ORDER BY C.`conId` DESC`';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryContractForMember 查看文件簽核-參與者明細
         *
         * @param $rows
         * @param $temId
         * @param $conId
         * @param $conType
         * @param $conSerial
         * @param $comCode
         * @param $conStatus
         * @param $memType
         * @param $memLV0Key
         * @param $memLV0Status
         * @param $memLVCKey
         * @param $memLVCStatus
         * @param $memLV1Key
         * @param $memLV1Status
         * @param $memLV2Key
         * @param $memLV2Status
         * @param $memNowKey
         * @param $memNowStatus
         * @param $memStatus
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryContractForMember($rows, $temId, $conId, $conType, $conSerial, $comCode, $conStatus, $memType, $memLV0Key, $memLV0Status, $memLVCKey, $memLVCStatus, $memLV1Key, $memLV1Status, $memLV2Key, $memLV2Status, $memNowKey, $memNowStatus, $memStatus, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('temId'        => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : NULL,
                            'conId'        => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : NULL,
                            'conType'      => $Conn->UtilCheckNotNullIsNumeric($conType) ? $conType : NULL,
                            'conSerial'    => $Conn->UtilCheckNotNull($conSerial) ? $conSerial : NULL,
                            'comCode'      => $Conn->UtilCheckNotNull($comCode) ? $comCode : NULL,
                            'conStatus'    => $Conn->UtilCheckNotNullIsNumeric($conStatus) ? $conStatus : NULL,
                            'memType'      => $Conn->UtilCheckNotNullIsNumeric($memType) ? $memType : NULL,
                            'memLV0Key'    => $Conn->UtilCheckNotNull($memLV0Key) ? $memLV0Key : NULL,
                            'memLV0Status' => $Conn->UtilCheckNotNullIsNumeric($memLV0Status) ? $memLV0Status : NULL,
                            'memLVCKey'    => $Conn->UtilCheckNotNull($memLVCKey) ? $memLVCKey : NULL,
                            'memLVCStatus' => $Conn->UtilCheckNotNullIsNumeric($memLVCStatus) ? $memLVCStatus : NULL,
                            'memLV1Key'    => $Conn->UtilCheckNotNull($memLV1Key) ? $memLV1Key : NULL,
                            'memLV1Status' => $Conn->UtilCheckNotNullIsNumeric($memLV1Status) ? $memLV1Status : NULL,
                            'memLV2Key'    => $Conn->UtilCheckNotNull($memLV2Key) ? $memLV2Key : NULL,
                            'memLV2Status' => $Conn->UtilCheckNotNullIsNumeric($memLV2Status) ? $memLV2Status : NULL,
                            'memNowKey'    => $Conn->UtilCheckNotNull($memNowKey) ? $memNowKey : NULL,
                            'memNowStatus' => $Conn->UtilCheckNotNullIsNumeric($memNowStatus) ? $memNowStatus : NULL,
                            'memStatus'    => $Conn->UtilCheckNotNullIsNumeric($memStatus) ? $memStatus : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contract` C
                     LEFT JOIN `member` M ON M.`conId` = C.`conId`
                     LEFT JOIN `company` CM ON CM.`comCode` = M.`memBu1Code` 
                     WHERE 1=1 ';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($temId) ? ' AND C.`temId` = :temId' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conId) ? ' AND C.`conId` = :conId' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conType) ? ' AND C.`conType` = :conType' : '';
            $sql .= $Conn->UtilCheckNotNull($conSerial) ? ' AND C.`conSerial` = :conSerial' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($comCode) ? ' AND C.`comCode` = :comCode' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conStatus) ? ' AND C.`conStatus` = :conStatus' : '';
            $sql .= $Conn->UtilCheckNotNull($memNowKey) ? ' AND M.`memNowKey` = :memNowKey' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($memNowStatus) ? ' AND M.`memNowStatus` = :memNowStatus' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($memStatus) ? ' AND M.`memStatus` = :memStatus' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($memType) ? ' AND M.`memType` = :memType' : '';
            $sql .= ' OR ( 1=2';
            if ($Conn->UtilCheckNotNull($memLV0Key) || $Conn->UtilCheckNotNullIsNumeric($memLV0Status)) {
                $sql .= ' OR ( WHERE 1=1';
                $sql .= $Conn->UtilCheckNotNull($memLV0Key) ? ' AND M.`memLV0Key` = :memLV0Key' : '';
                $sql .= $Conn->UtilCheckNotNullIsNumeric($memLV0Status) ? ' AND M.`memLV0Status` = :memLV0Status' : '';
                $sql .= ' )';
            }
            if ($Conn->UtilCheckNotNull($memLVCKey) || $Conn->UtilCheckNotNullIsNumeric($memLVCStatus)) {
                $sql .= ' OR ( WHERE 1=1';
                $sql .= $Conn->UtilCheckNotNull($memLVCKey) ? ' AND M.`memLVC` = :memLVCKey' : '';
                $sql .= $Conn->UtilCheckNotNullIsNumeric($memLVCStatus) ? ' AND M.`memLVCStatus` = :memLVCStatus' : '';
                $sql .= ' )';
            }
            if ($Conn->UtilCheckNotNull($memLV1Key) || $Conn->UtilCheckNotNullIsNumeric($memLV1Status)) {
                $sql .= ' OR ( WHERE 1=1';
                $sql .= $Conn->UtilCheckNotNull($memLV1Key) ? ' AND M.`memLV1Key` = :memLV1Key' : '';
                $sql .= $Conn->UtilCheckNotNullIsNumeric($memLV1Status) ? ' AND M.`memLV1Status` = :memLV1Status' : '';
                $sql .= ' )';
            }
            if ($Conn->UtilCheckNotNull($memLV2Key) || $Conn->UtilCheckNotNullIsNumeric($memLV2Status)) {
                $sql .= ' OR ( WHERE 1=1';
                $sql .= $Conn->UtilCheckNotNull($memLV2Key) ? ' AND M.`memLV2Key` = :memLV2Key' : '';
                $sql .= $Conn->UtilCheckNotNullIsNumeric($memLV2Status) ? ' AND M.`memLV2Status` = :memLV2Status' : '';
                $sql .= ' )';
            }
            $sql .= ' )';
            $sql .= ' ORDER BY C.`conId` DESC';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryMember 查看簽核人員資料
         *
         * @param $rows
         * @param $conId
         * @param $appId
         * @param $memType
         * @param $memStatus
         * @param $memStatusNot
         *
         * @return mixed
         */
        function queryMember($rows, $conId, $appId, $memType, $memStatus, $memStatusNot)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'        => $Conn->UtilCheckNotNullIsNumeric($conId) && $conId > 0 ? $conId : NULL,
                            'appId'        => $Conn->UtilCheckNotNullIsNumeric($appId) && $appId > 0 ? $appId : NULL,
                            'memType'      => $Conn->UtilCheckNotNullIsNumeric($memType) ? $memType : NULL,
                            'memStatus'    => $Conn->UtilCheckNotNullIsNumeric($memStatus) ? $memStatus : NULL,
                            'memStatusNot' => $Conn->UtilCheckNotNullIsNumeric($memStatusNot) ? $memStatusNot : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `member` M
                     LEFT JOIN `company` C ON M.`memBu1Code` = C.`comCode`
                     WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conId) && $conId > 0 ? ' AND M.`conId` = :conId' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($appId) && $appId > 0 ? ' AND M.`appId` = :appId' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($memType) ? ' AND M.`memType` = :memType' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($memStatus) ? ' AND M.`memStatus` = :memStatus' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($memStatusNot) ? ' AND M.`memStatus` != :memStatusNot' : '';
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:insertMember 新增簽核流程
         *
         * @param $conId
         * @param $appId
         * @param $memType
         * @param $memBu1Code
         * @param $memBu2Code
         * @param $memBu2
         * @param $memBu3Code
         * @param $memBu3
         * @param $memLV0Key
         * @param $memLV0Name
         * @param $memLV0PositionName
         * @param $memLVCKey
         * @param $memLVCName
         * @param $memLVCPositionName
         * @param $memLV1Key
         * @param $memLV1Name
         * @param $memLV1PositionName
         * @param $memLV2Key
         * @param $memLV2Name
         * @param $memLV2PositionName
         * @param $memPhone
         * @param $memNowKey
         *
         * @return array|int|Number
         */
        function insertMember($conId, $appId, $memType, $memBu1Code, $memBu2Code, $memBu2, $memBu3Code, $memBu3, $memLV0Key, $memLV0Name, $memLV0PositionName, $memLVCKey, $memLVCName, $memLVCPositionName, $memLV1Key, $memLV1Name, $memLV1PositionName, $memLV2Key, $memLV2Name, $memLV2PositionName, $memPhone, $memNowKey)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'              => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : 0,
                            'appId'              => $Conn->UtilCheckNotNullIsNumeric($appId) ? $appId : 0,
                            'memType'            => $Conn->UtilCheckNotNullIsNumeric($memType) ? $memType : 0,
                            'memBu1Code'         => $Conn->UtilCheckNotNull($memBu1Code) ? $memBu1Code : 0,
                            'memBu2Code'         => $Conn->UtilCheckNotNull($memBu2Code) ? $memBu2Code : 0,
                            'memBu2'             => $Conn->UtilCheckNotNull($memBu2) ? $memBu2 : 0,
                            'memBu3Code'         => $Conn->UtilCheckNotNull($memBu3Code) ? $memBu3Code : 0,
                            'memBu3'             => $Conn->UtilCheckNotNull($memBu3) ? $memBu3 : 0,
                            'memLV0Key'          => $Conn->UtilCheckNotNull($memLV0Key) ? $memLV0Key : '',
                            'memLV0Name'         => $Conn->UtilCheckNotNull($memLV0Name) ? $memLV0Name : '',
                            'memLV0PositionName' => $Conn->UtilCheckNotNull($memLV0PositionName) ? $memLV0PositionName : '',
                            'memLVCKey'          => $Conn->UtilCheckNotNull($memLVCKey) ? $memLVCKey : '',
                            'memLVCName'         => $Conn->UtilCheckNotNull($memLVCName) ? $memLVCName : '',
                            'memLVCPositionName' => $Conn->UtilCheckNotNull($memLVCPositionName) ? $memLVCPositionName : '',
                            'memLV1Key'          => $Conn->UtilCheckNotNull($memLV1Key) ? $memLV1Key : '',
                            'memLV1Name'         => $Conn->UtilCheckNotNull($memLV1Name) ? $memLV1Name : '',
                            'memLV1PositionName' => $Conn->UtilCheckNotNull($memLV1PositionName) ? $memLV1PositionName : '',
                            'memLV2Key'          => $Conn->UtilCheckNotNull($memLV2Key) ? $memLV2Key : '',
                            'memLV2Name'         => $Conn->UtilCheckNotNull($memLV2Name) ? $memLV2Name : '',
                            'memLV2PositionName' => $Conn->UtilCheckNotNull($memLV2PositionName) ? $memLV2PositionName : '',
                            'memPhone'           => $Conn->UtilCheckNotNull($memPhone) ? $memPhone : '',
                            'memNowKey'          => $Conn->UtilCheckNotNull($memNowKey) ? $memNowKey : '');
            //SQL
            $sql = ' INSERT INTO `member`(`conId`, `appId`, `memType`, `memBu1Code`, `memBu2Code`, `memBu2`, `memBu3Code`, `memBu3`, `memLV0Key`, `memLV0Name`, `memLV0PositionName`, `memLVCKey`, `memLVCName`, `memLVCPositionName`, `memLV1Key`, `memLV1Name`, `memLV1PositionName`, `memLV2Key`, `memLV2Name`, `memLV2PositionName`, `memPhone`, `memNowKey`)
                     VALUES(:conId, :appId, :memType, :memBu1Code, :memBu2Code, :memBu2, :memBu3Code, :memBu3, :memLV0Key, :memLV0Name, :memLV0PositionName, :memLVCKey, :memLVCName, :memLVCPositionName, :memLV1Key, :memLV1Name, :memLV1PositionName, :memLV2Key, :memLV2Name, :memLV2PositionName, :memPhone, :memNowKey)';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:copyMember 複製簽核流程
         *
         * @param $conId
         * @param $conIdNew
         * @param $appId
         * @param $appIdNew
         *
         * @return array|int|Number
         */
        function copyMember($conId, $conIdNew, $appId, $appIdNew)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'    => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : NULL,
                            'conIdNew' => $Conn->UtilCheckNotNullIsNumeric($conIdNew) ? $conIdNew : NULL,
                            'appId'    => $Conn->UtilCheckNotNullIsNumeric($appId) ? $appId : NULL,
                            'appIdNew' => $Conn->UtilCheckNotNullIsNumeric($appIdNew) ? $appIdNew : NULL);
            //SQL
            $sql = ' INSERT INTO `member`(`conId`, `appId`, `memType`, `memBu1Code`, `memBu2Code`, `memBu2`, `memBu3Code`, `memBu3`, `memLV0Key`, `memLV0Name`, `memLV0PositionName`, `memLV0Status`, `memLV0Msg`, `memLV0Time`, `memLVCKey`, `memLVCName`, `memLVCPositionName`, `memLVCStatus`, `memLVCTime`, `memLV1Key`, `memLV1Name`, `memLV1PositionName`, `memLV1Status`, `memLV1Msg`, `memLV1Time`, `memLV2Key`, `memLV2Name`, `memLV2PositionName`, `memLV2Status`, `memLV2Msg`, `memLV2Time`, `memPhone`, `memNowKey`, `memNowStatus`, `memStatus`)
                     SELECT '.($Conn->UtilCheckNotNullIsNumeric($conIdNew) ? ':conIdNew' : '`conId`').', '.($Conn->UtilCheckNotNullIsNumeric($appIdNew) ? ':appIdNew' : '`appId`').', `memType`, `memBu1Code`, `memBu2Code`, `memBu2`, `memBu3Code`, `memBu3`, `memLV0Key`, `memLV0Name`, `memLV0PositionName`, -1, NULL, NULL, \'\', \'\', \'\', -1, NULL, `memLV1Key`, `memLV1Name`, `memLV1PositionName`, -1, NULL, NULL, `memLV2Key`, `memLV2Name`, `memLV2PositionName`, -1, NULL, NULL, `memPhone`, \'\', -1, -1 
                     FROM `member` WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conId) ? ' AND `conId` = :conId' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($appId) ? ' AND `appId` = :appId' : '';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:updateMemberByID 修改簽核流程
         *
         * @param $memId
         * @param $memType
         * @param $memBu1Code
         * @param $memBu2Code
         * @param $memBu2
         * @param $memBu3Code
         * @param $memBu3
         * @param $memLV0Key
         * @param $memLV0Name
         * @param $memLV0PositionName
         * @param $memLVCKey
         * @param $memLVCName
         * @param $memLVCPositionName
         * @param $memLV1Key
         * @param $memLV1Name
         * @param $memLV1PositionName
         * @param $memLV2Key
         * @param $memLV2Name
         * @param $memLV2PositionName
         * @param $memPhone
         * @param $memNowKey
         *
         * @return array|int
         */
        function updateMemberByID($memId, $memType, $memBu1Code, $memBu2Code, $memBu2, $memBu3Code, $memBu3, $memLV0Key, $memLV0Name, $memLV0PositionName, $memLVCKey, $memLVCName, $memLVCPositionName, $memLV1Key, $memLV1Name, $memLV1PositionName, $memLV2Key, $memLV2Name, $memLV2PositionName, $memPhone, $memNowKey)
        {
            $Conn = new ConnManager();
            $arrPar = array('memId'              => $Conn->UtilCheckNotNullIsNumeric($memId) ? $memId : 0,
                            'memType'            => $Conn->UtilCheckNotNullIsNumeric($memType) ? $memType : 0,
                            'memBu1Code'         => $Conn->UtilCheckNotNull($memBu1Code) ? $memBu1Code : 0,
                            'memBu2Code'         => $Conn->UtilCheckNotNull($memBu2Code) ? $memBu2Code : 0,
                            'memBu2'             => $Conn->UtilCheckNotNull($memBu2) ? $memBu2 : 0,
                            'memBu3Code'         => $Conn->UtilCheckNotNull($memBu3Code) ? $memBu3Code : 0,
                            'memBu3'             => $Conn->UtilCheckNotNull($memBu3) ? $memBu3 : 0,
                            'memLV0Key'          => $Conn->UtilCheckNotNull($memLV0Key) ? $memLV0Key : '',
                            'memLV0Name'         => $Conn->UtilCheckNotNull($memLV0Name) ? $memLV0Name : '',
                            'memLV0PositionName' => $Conn->UtilCheckNotNull($memLV0PositionName) ? $memLV0PositionName : '',
                            'memLVCKey'          => $Conn->UtilCheckNotNull($memLVCKey) ? $memLVCKey : '',
                            'memLVCName'         => $Conn->UtilCheckNotNull($memLVCName) ? $memLVCName : '',
                            'memLVCPositionName' => $Conn->UtilCheckNotNull($memLVCPositionName) ? $memLVCPositionName : '',
                            'memLV1Key'          => $Conn->UtilCheckNotNull($memLV1Key) ? $memLV1Key : '',
                            'memLV1Name'         => $Conn->UtilCheckNotNull($memLV1Name) ? $memLV1Name : '',
                            'memLV1PositionName' => $Conn->UtilCheckNotNull($memLV1PositionName) ? $memLV1PositionName : '',
                            'memLV2Key'          => $Conn->UtilCheckNotNull($memLV2Key) ? $memLV2Key : '',
                            'memLV2Name'         => $Conn->UtilCheckNotNull($memLV2Name) ? $memLV2Name : '',
                            'memLV2PositionName' => $Conn->UtilCheckNotNull($memLV2PositionName) ? $memLV2PositionName : '',
                            'memPhone'           => $Conn->UtilCheckNotNull($memPhone) ? $memPhone : '',
                            'memNowKey'          => $Conn->UtilCheckNotNull($memNowKey) ? $memNowKey : '');
            //SQL
            $sql = ' UPDATE `member`
                     SET `memType` = :memType, `memBu1Code` = :memBu1Code, `memBu2Code` = :memBu2Code, `memBu2` = :memBu2, `memBu3Code` = :memBu3Code, `memBu3` = :memBu3, 
                         `memLV0Key` = :memLV0Key, `memLV0Name` = :memLV0Name, `memLV0PositionName` = :memLV0PositionName, 
                         `memLVCKey` = :memLVCKey, `memLVCName` = :memLVCName, `memLVCPositionName` = :memLVCPositionName, 
                         `memLV1Key` = :memLV1Key, `memLV1Name` = :memLV1Name, `memLV1PositionName` = :memLV1PositionName, 
                         `memLV2Key` = :memLV2Key, `memLV2Name` = :memLV2Name, `memLV2PositionName` = :memLV2PositionName, 
                         `memPhone` = :memPhone, `memNowKey` = :memNowKey
                     WHERE `memId` = :memId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:updateMemberByContractDefault 重置文件相關簽核資料
         *
         * @param $conId
         *
         * @return array|int
         */
        function updateMemberByContractDefault($conId)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId' => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : 0);
            //SQL
            $sql = ' UPDATE `member`
                     SET `memLV0Status` = -1, `memLV0Msg` = NULL, `memLV0Time` = NULL, 
                         `memLVCStatus` = -1, `memLVCKey` = \'\', `memLVCName` = \'\', `memLVCPositionName` = \'\', `memLVCTime` = NULL, 
                         `memLV1Status` = -1, `memLV1Msg` = NULL, `memLV1Time` = NULL, 
                         `memLV2Status` = -1, `memLV2Msg` = NULL, `memLV2Time` = NULL, 
                         `memNowKey` = \'\', `memNowStatus` = -1, `memStatus` = -1
                     WHERE `conId` = :conId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:updateMemberByApportionDefault 重置文件相關簽核資料
         *
         * @param $appId
         *
         * @return array|int
         */
        function updateMemberByApportionDefault($appId)
        {
            $Conn = new ConnManager();
            $arrPar = array('appId' => $Conn->UtilCheckNotNullIsNumeric($appId) ? $appId : 0);
            //SQL
            $sql = ' UPDATE `member`
                     SET `memLV0Status` = -1, `memLV0Msg` = NULL, `memLV0Time` = NULL, 
                         `memLVCStatus` = -1, `memLVCKey` = \'\', `memLVCName` = \'\', `memLVCPositionName` = \'\', `memLVCTime` = NULL, 
                         `memLV1Status` = -1, `memLV1Msg` = NULL, `memLV1Time` = NULL, 
                         `memLV2Status` = -1, `memLV2Msg` = NULL, `memLV2Time` = NULL, 
                         `memNowKey` = \'\', `memNowStatus` = -1, `memStatus` = -1
                     WHERE `appId` = :appId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:updateMemberByContractApportionDefault 修改簽核人員資料(當文件費用一起簽時)
         *
         * @param $conId
         * @param $appId
         *
         * @return array|int
         */
        function updateMemberByContractApportionDefault($conId, $appId)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId' => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : 0,
                            'appId' => $Conn->UtilCheckNotNullIsNumeric($appId) ? $appId : 0);
            //SQL
            $sql = ' UPDATE `member`
                     SET `memLV0Status` = -1, `memLV0Msg` = NULL, `memLV0Time` = NULL, 
                         `memLVCStatus` = -1, `memLVCKey` = \'\', `memLVCName` = \'\', `memLVCPositionName` = \'\', `memLVCTime` = NULL, 
                         `memLV1Status` = -1, `memLV1Msg` = NULL, `memLV1Time` = NULL, 
                         `memLV2Status` = -1, `memLV2Msg` = NULL, `memLV2Time` = NULL, 
                         `memNowKey` = \'\', `memNowStatus` = -1, `memStatus` = -1
                     WHERE `conId` = :conId AND `appId` = :appId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:updateMemberApportionByContract 修改簽核人員資料(當文件費用一起簽時)
         *
         * @param $conId
         * @param $appId
         *
         * @return array|int
         */
        function updateMemberAppIdByConId($conId, $appId)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId' => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : 0,
                            'appId' => $Conn->UtilCheckNotNullIsNumeric($appId) ? $appId : 0);
            //SQL
            $sql = ' UPDATE `member`
                     SET `appId` = :appId
                     WHERE `conId` = :conId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteMember 刪除文件相關簽核流程
         *
         * @param $memId
         *
         * @return array|int|Number
         */
        function deleteMember($memId)
        {
            $Conn = new ConnManager();
            $arrPar = array('memId' => $Conn->UtilCheckNotNullIsNumeric($memId) ? $memId : 0);
            //SQL
            $sql = ' DELETE FROM `member`
                     WHERE `memId` = :memId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteMemberByContract 刪除文件相關簽核流程
         *
         * @param $conId
         * @param $memId_list
         *
         * @return array|int|Number
         */
        function deleteMemberByContract($conId, $memId_list)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId' => $Conn->UtilCheckNotNullIsNumeric($conId) && $conId > 0 ? $conId : 0);
            //SQL
            if ($Conn->UtilCheckNotNullIsNumeric($conId) && $conId > 0) {
                $sql = ' DELETE FROM `member`
                     WHERE `conId` = :conId';
                $sql_memId = '';
                if (is_array($memId_list)) {
                    foreach ($memId_list as $memId) {
                        $sql_memId .= ('' != $sql_memId ? ',' : '').$memId;
                    }
                    if ('' != $sql_memId) {
                        $sql_memId = ' AND `memId` NOT IN ('.$sql_memId.')';
                    }
                }
                $sql .= $sql_memId;
                $aryExecute = $Conn->pramExecute($sql, $arrPar);
                return $aryExecute;
            }
            else {
                return FALSE;
            }
        }

        /**
         * todo:deleteMemberByApportion 刪除費用相關簽核流程
         *
         * @param $appId
         * @param $memId_list
         *
         * @return array|int|Number
         */
        function deleteMemberByApportion($appId, $memId_list)
        {
            $Conn = new ConnManager();
            $arrPar = array('appId' => $Conn->UtilCheckNotNullIsNumeric($appId) && $appId > 0 ? $appId : 0);
            //SQL
            if ($Conn->UtilCheckNotNullIsNumeric($appId) && $appId > 0) {
                $sql = ' DELETE FROM `member`
                     WHERE `appId` = :appId';
                $sql_memId = '';
                if (is_array($memId_list)) {
                    foreach ($memId_list as $memId) {
                        $sql_memId .= ('' != $sql_memId ? ',' : '').$memId;
                    }
                    if ('' != $sql_memId) {
                        $sql_memId = ' AND `memId` NOT IN ('.$sql_memId.')';
                    }
                }
                $sql .= $sql_memId;
                $aryExecute = $Conn->pramExecute($sql, $arrPar);
                return $aryExecute;
            }
            else {
                return FALSE;
            }
        }

        /**
         * todo:updateMemberStatus 修改簽核流程狀態
         *
         * @param $memId
         * @param $memLV0Status
         * @param $memLV0Time
         * @param $memLV0Msg
         * @param $memLVCKey
         * @param $memLVCName
         * @param $memLVCPositionName
         * @param $memLVCStatus
         * @param $memLVCTime
         * @param $memLV1Status
         * @param $memLV1Time
         * @param $memLV1Msg
         * @param $memLV2Status
         * @param $memLV2Time
         * @param $memLV2Msg
         * @param $memNowKey
         * @param $memNowStatus
         * @param $memStatus
         *
         * @return array|int|Number
         */
        function updateMemberStatus($memId, $memLV0Status, $memLV0Time, $memLV0Msg, $memLVCKey, $memLVCName, $memLVCPositionName, $memLVCStatus, $memLVCTime, $memLV1Status, $memLV1Time, $memLV1Msg, $memLV2Status, $memLV2Time, $memLV2Msg, $memNowKey, $memNowStatus, $memStatus)
        {
            $Conn = new ConnManager();
            $arrPar = array('memLV0Status'       => $Conn->UtilCheckNotNullIsNumeric($memLV0Status) ? $memLV0Status : NULL,
                            'memLV0Time'         => $Conn->UtilCheckNotNullIsDateTime($memLV0Time) ? $memLV0Time : NULL,
                            'memLV0Msg'          => $Conn->UtilCheckNotNull($memLV0Msg) ? $memLV0Msg : NULL,
                            'memLVCKey'          => $Conn->UtilCheckNotNull($memLVCKey) ? $memLVCKey : NULL,
                            'memLVCName'         => $Conn->UtilCheckNotNull($memLVCName) ? $memLVCName : NULL,
                            'memLVCPositionName' => $Conn->UtilCheckNotNull($memLVCPositionName) ? $memLVCPositionName : NULL,
                            'memLVCStatus'       => $Conn->UtilCheckNotNullIsNumeric($memLVCStatus) ? $memLVCStatus : NULL,
                            'memLVCTime'         => $Conn->UtilCheckNotNullIsDateTime($memLVCTime) ? $memLVCTime : NULL,
                            'memLV1Status'       => $Conn->UtilCheckNotNullIsNumeric($memLV1Status) ? $memLV1Status : NULL,
                            'memLV1Time'         => $Conn->UtilCheckNotNullIsDateTime($memLV1Time) ? $memLV1Time : NULL,
                            'memLV1Msg'          => $Conn->UtilCheckNotNull($memLV1Msg) ? $memLV1Msg : NULL,
                            'memLV2Status'       => $Conn->UtilCheckNotNullIsNumeric($memLV2Status) ? $memLV2Status : NULL,
                            'memLV2Time'         => $Conn->UtilCheckNotNullIsDateTime($memLV2Time) ? $memLV2Time : NULL,
                            'memLV2Msg'          => $Conn->UtilCheckNotNull($memLV2Msg) ? $memLV2Msg : NULL,
                            'memNowKey'          => $Conn->UtilCheckNotNull($memNowKey) ? $memNowKey : NULL,
                            'memNowStatus'       => $Conn->UtilCheckNotNullIsNumeric($memNowStatus) ? $memNowStatus : NULL,
                            'memStatus'          => $Conn->UtilCheckNotNullIsNumeric($memStatus) ? $memStatus : NULL,
                            'memId'              => $Conn->UtilCheckNotNullIsNumeric($memId) ? $memId : 0);
            //SQL
            $up_sql = '';
            $up_sql .= $Conn->UtilCheckNotNullIsNumeric($memLV0Status) ? ('' != $up_sql ? ', ' : '').' `memLV0Status` = :memLV0Status' : '';
            $up_sql .= $Conn->UtilCheckNotNullIsDateTime($memLV0Time) ? ('' != $up_sql ? ', ' : '').' `memLV0Time` = :memLV0Time' : '';
            $up_sql .= $Conn->UtilCheckNotNull($memLV0Msg) ? ('' != $up_sql ? ', ' : '').' `memLV0Msg` = :memLV0Msg' : '';
            $up_sql .= $Conn->UtilCheckNotNull($memLVCKey) ? ('' != $up_sql ? ', ' : '').' `memLVCKey` = :memLVCKey' : '';
            $up_sql .= $Conn->UtilCheckNotNull($memLVCName) ? ('' != $up_sql ? ', ' : '').' `memLVCName` = :memLVCName' : '';
            $up_sql .= $Conn->UtilCheckNotNull($memLVCPositionName) ? ('' != $up_sql ? ', ' : '').' `memLVCPositionName` = :memLVCPositionName' : '';
            $up_sql .= $Conn->UtilCheckNotNullIsNumeric($memLVCStatus) ? ('' != $up_sql ? ', ' : '').' `memLVCStatus` = :memLVCStatus' : '';
            $up_sql .= $Conn->UtilCheckNotNullIsDateTime($memLVCTime) ? ('' != $up_sql ? ', ' : '').' `memLVCTime` = :memLVCTime' : '';
            $up_sql .= $Conn->UtilCheckNotNullIsNumeric($memLV1Status) ? ('' != $up_sql ? ', ' : '').' `memLV1Status` = :memLV1Status' : '';
            $up_sql .= $Conn->UtilCheckNotNullIsDateTime($memLV1Time) ? ('' != $up_sql ? ', ' : '').' `memLV1Time` = :memLV1Time' : '';
            $up_sql .= $Conn->UtilCheckNotNull($memLV1Msg) ? ('' != $up_sql ? ', ' : '').' `memLV1Msg` = :memLV1Msg' : '';
            $up_sql .= $Conn->UtilCheckNotNullIsNumeric($memLV2Status) ? ('' != $up_sql ? ', ' : '').' `memLV2Status` = :memLV2Status' : '';
            $up_sql .= $Conn->UtilCheckNotNullIsDateTime($memLV2Time) ? ('' != $up_sql ? ', ' : '').' `memLV2Time` = :memLV2Time' : '';
            $up_sql .= $Conn->UtilCheckNotNull($memLV2Msg) ? ('' != $up_sql ? ', ' : '').' `memLV2Msg` = :memLV2Msg' : '';
            $up_sql .= $Conn->UtilCheckNotNull($memNowKey) ? ('' != $up_sql ? ', ' : '').' `memNowKey` = :memNowKey' : '';
            $up_sql .= $Conn->UtilCheckNotNullIsNumeric($memNowStatus) ? ('' != $up_sql ? ', ' : '').' `memNowStatus` = :memNowStatus' : '';
            $up_sql .= $Conn->UtilCheckNotNullIsNumeric($memStatus) ? ('' != $up_sql ? ', ' : '').' `memStatus` = :memStatus' : '';
            $sql = ' UPDATE `member`
                     SET '.$up_sql.'
                     WHERE `memId` = :memId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:updateMemberStatusAll 修改文件相關簽核流程狀態
         *
         * @param $conId
         * @param $appId
         * @param $memNowKey
         * @param $memNowStatus
         *
         * @return array|int|Number
         */
        function updateMemberStatusAll($conId, $appId, $memNowKey, $memNowStatus)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'        => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : NULL,
                            'appId'        => $Conn->UtilCheckNotNullIsNumeric($appId) ? $appId : NULL,
                            'memNowKey'    => $Conn->UtilCheckNotNull($memNowKey) ? $memNowKey : NULL,
                            'memNowStatus' => $Conn->UtilCheckNotNullIsNumeric($memNowStatus) ? $memNowStatus : NULL);
            //SQL
            $up_sql = '';
            $up_sql .= $Conn->UtilCheckNotNull($memNowKey) ? ('' != $up_sql ? ', ' : '').' `memNowKey` = :memNowKey' : '';
            $up_sql .= $Conn->UtilCheckNotNullIsNumeric($memNowStatus) ? ('' != $up_sql ? ', ' : '').' `memNowStatus` = :memNowStatus' : '';
            $sql = ' UPDATE `member`
                     SET '.$up_sql.'
                     WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conId) ? ' AND `conId` = :conId' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conId) ? ' AND `appId` = :appId' : '';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }


        /**
         * todo:queryItem 查看作業內容
         *
         * @param $rows
         * @param $conId
         *
         * @return mixed
         */
        function queryItem($rows, $conId)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId' => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `item` I
                     LEFT JOIN `contract` C ON C.`conId` = I.`conId`
                     LEFT JOIN `work` W ON W.`worId` = I.`worId`
                     LEFT JOIN `distribution` D ON D.`disId` = I.`disId`
                     LEFT JOIN `manner` M ON M.`manId` = I.`manId`
                     LEFT JOIN `source` S ON S.`souId` = I.`iteTime`
                     WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conId) ? ' AND I.`conId` = :conId' : '';
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryItemByID 查看單一作業內容
         *
         * @param $rows
         * @param $iteId
         *
         * @return mixed
         */
        function queryItemByID($rows, $iteId)
        {
            $Conn = new ConnManager();
            $arrPar = array('iteId' => $Conn->UtilCheckNotNullIsNumeric($iteId) ? $iteId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `item` I
                     LEFT JOIN `contract` C ON C.`conId` = I.`conId`
                     LEFT JOIN `work` W ON W.`worId` = I.`worId`
                     LEFT JOIN `distribution` D ON D.`disId` = I.`disId`
                     LEFT JOIN `manner` M ON M.`manId` = I.`manId`
                     WHERE I.`iteId` = :iteId';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:deleteItemByID 刪除作業內容
         *
         * @param $iteId
         *
         * @return mixed
         */
        function deleteItemByID($iteId)
        {
            $Conn = new ConnManager();
            $arrPar = array('iteId' => $Conn->UtilCheckNotNullIsNumeric($iteId) ? $iteId : 0);
            //SQL
            $sql = ' DELETE FROM `item`
                     WHERE `iteId` = :iteId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteItemByContract 刪除作業內容
         *
         * @param $conId
         * @param $iteId_list
         *
         * @return mixed
         */
        function deleteItemByContract($conId, $iteId_list)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId' => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : 0);
            //SQL
            $sql = ' DELETE FROM `item`
                     WHERE `conId` = :conId';
            $sql_iteId = '';
            if (is_array($iteId_list)) {
                foreach ($iteId_list as $iteId) {
                    $sql_iteId .= ('' != $sql_iteId ? ',' : '').$iteId;
                }
                if ('' != $sql_iteId) {
                    $sql_iteId = ' AND `iteId` NOT IN ('.$sql_iteId.')';
                }
            }
            $sql .= $sql_iteId;
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:insertItem 新增作業內容
         *
         * @param $conId
         * @param $iteTitle
         * @param $worId
         * @param $iteTime
         * @param $iteSubsidiaries
         * @param $iteControl
         * @param $disId
         * @param $manId
         * @param $iteProportion
         * @param $iteTypeNote
         * @param $iteDescription
         * @param $iteFileMeeting
         * @param $iteFilePlan
         * @param $iteFile
         * @param $iteWord
         * @param $iteNote
         *
         * @return array|int|Number
         */
        function insertItem($conId, $iteTitle, $worId, $iteTime, $iteSubsidiaries, $iteControl, $disId, $manId, $iteProportion, $iteTypeNote, $iteDescription, $iteFileMeeting, $iteFilePlan, $iteFile, $iteWord, $iteNote)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'           => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : 0,
                            'iteTitle'        => $Conn->UtilCheckNotNull($iteTitle) ? $iteTitle : '',
                            'worId'           => $Conn->UtilCheckNotNullIsNumeric($worId) ? $worId : 0,
                            'iteTime'         => $Conn->UtilCheckNotNull($iteTime) ? $iteTime : '',
                            'iteSubsidiaries' => $Conn->UtilCheckNotNull($iteSubsidiaries) ? $iteSubsidiaries : '',
                            'iteControl'      => $Conn->UtilCheckNotNull($iteControl) ? $iteControl : '',
                            'disId'           => $Conn->UtilCheckNotNullIsNumeric($disId) ? $disId : 0,
                            'manId'           => $Conn->UtilCheckNotNullIsNumeric($manId) ? $manId : 0,
                            'iteProportion'   => $Conn->UtilCheckNotNull($iteProportion) ? $iteProportion : '',
                            'iteTypeNote'     => $Conn->UtilCheckNotNull($iteTypeNote) ? $iteTypeNote : '',
                            'iteDescription'  => $Conn->UtilCheckNotNull($iteDescription) ? $iteDescription : '',
                            'iteFileMeeting'  => $Conn->UtilCheckNotNull($iteFileMeeting) ? $iteFileMeeting : '',
                            'iteFilePlan'     => $Conn->UtilCheckNotNull($iteFilePlan) ? $iteFilePlan : '',
                            'iteFile'         => $Conn->UtilCheckNotNull($iteFile) ? $iteFile : '',
                            'iteWord'         => $Conn->UtilCheckNotNull($iteWord) ? $iteWord : '',
                            'iteNote'         => $Conn->UtilCheckNotNull($iteNote) ? $iteNote : '');
            //SQL
            $sql = ' INSERT INTO `item`(`conId`, `iteTitle`, `worId`, `iteTime`, `iteSubsidiaries`, `iteControl`, `disId`, `manId`, `iteProportion`, `iteTypeNote`, `iteDescription`, `iteFileMeeting`, `iteFilePlan`, `iteFile`, `iteWord`, `iteNote`)
                     VALUES(:conId, :iteTitle, :worId, :iteTime, :iteSubsidiaries, :iteControl, :disId, :manId, :iteProportion, :iteTypeNote, :iteDescription, :iteFileMeeting, :iteFilePlan, :iteFile, :iteWord, :iteNote)';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:copyItem 複製作業內容
         *
         * @param $conId
         * @param $conIdNew
         *
         * @return array|int|Number
         */
        function copyItem($conId, $conIdNew)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'    => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : 0,
                            'conIdNew' => $Conn->UtilCheckNotNullIsNumeric($conIdNew) ? $conIdNew : 0);
            //SQL
            $sql = ' INSERT INTO `item`(`conId`, `iteTitle`, `worId`, `iteTime`, `iteSubsidiaries`, `iteControl`, `disId`, `manId`, `iteProportion`, `iteTypeNote`, `iteDescription`, `iteFileMeeting`, `iteFilePlan`, `iteFile`, `iteWord`, `iteNote`)
                     SELECT :conIdNew, `iteTitle`, `worId`, `iteTime`, `iteSubsidiaries`, `iteControl`, `disId`, `manId`, `iteProportion`, `iteTypeNote`, `iteDescription`, `iteFileMeeting`, `iteFilePlan`, `iteFile`, `iteWord`, `iteNote` FROM `item` WHERE `conId` = :conId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:updateItem 修改作業內容
         *
         * @param $iteId
         * @param $conId
         * @param $iteTitle
         * @param $worId
         * @param $iteTime
         * @param $iteSubsidiaries
         * @param $iteControl
         * @param $disId
         * @param $manId
         * @param $iteProportion
         * @param $iteTypeNote
         * @param $iteDescription
         * @param $iteFileMeeting
         * @param $iteFilePlan
         * @param $iteFile
         * @param $iteWord
         * @param $iteNote
         *
         * @return array|int
         */
        function updateItem($iteId, $conId, $iteTitle, $worId, $iteTime, $iteSubsidiaries, $iteControl, $disId, $manId, $iteProportion, $iteTypeNote, $iteDescription, $iteFileMeeting, $iteFilePlan, $iteFile, $iteWord, $iteNote)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'           => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : 0,
                            'iteTitle'        => $Conn->UtilCheckNotNull($iteTitle) ? $iteTitle : '',
                            'worId'           => $Conn->UtilCheckNotNullIsNumeric($worId) ? $worId : 0,
                            'iteTime'         => $Conn->UtilCheckNotNull($iteTime) ? $iteTime : '',
                            'iteSubsidiaries' => $Conn->UtilCheckNotNull($iteSubsidiaries) ? $iteSubsidiaries : '',
                            'iteControl'      => $Conn->UtilCheckNotNull($iteControl) ? $iteControl : '',
                            'disId'           => $Conn->UtilCheckNotNullIsNumeric($disId) ? $disId : 0,
                            'manId'           => $Conn->UtilCheckNotNullIsNumeric($manId) ? $manId : 0,
                            'iteProportion'   => $Conn->UtilCheckNotNull($iteProportion) ? $iteProportion : '',
                            'iteTypeNote'     => $Conn->UtilCheckNotNull($iteTypeNote) ? $iteTypeNote : '',
                            'iteDescription'  => $Conn->UtilCheckNotNull($iteDescription) ? $iteDescription : '',
                            'iteFileMeeting'  => $Conn->UtilCheckNotNull($iteFileMeeting) ? $iteFileMeeting : '',
                            'iteFilePlan'     => $Conn->UtilCheckNotNull($iteFilePlan) ? $iteFilePlan : '',
                            'iteFile'         => $Conn->UtilCheckNotNull($iteFile) ? $iteFile : '',
                            'iteWord'         => $Conn->UtilCheckNotNull($iteWord) ? $iteWord : '',
                            'iteNote'         => $Conn->UtilCheckNotNull($iteNote) ? $iteNote : '',
                            'iteId'           => $Conn->UtilCheckNotNullIsNumeric($iteId) ? $iteId : 0);
            //SQL
            $sql = ' UPDATE `item`
                     SET `conId` = :conId, `iteTitle` = :iteTitle, `worId` = :worId, `iteTime` = :iteTime, `iteSubsidiaries` = :iteSubsidiaries, `iteControl` = :iteControl, 
                         `disId` = :disId, `manId` = :manId, `iteProportion` = :iteProportion, `iteTypeNote` = :iteTypeNote, `iteDescription` = :iteDescription, 
                         `iteFileMeeting` = :iteFileMeeting, `iteFilePlan` = :iteFilePlan, `iteFile` = :iteFile, `iteWord` = :iteWord, `iteNote` = :iteNote
                     WHERE `iteId` = :iteId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:queryApportion 查看費用
         *
         * @param $rows
         * @param $conId
         * @param $conSerial
         * @param $conMark
         * @param $conStatus
         * @param $conStatusNot
         * @param $perKey
         * @param $appYear
         * @param $appStatus
         * @param $appStatusNot
         * @param $appMark
         * @param $appInh
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryApportion($rows, $conId, $conSerial, $conMark, $conStatus, $conStatusNot, $perKey, $appYear, $appStatus, $appStatusNot, $appMark, $appInh, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('appYear'      => $Conn->UtilCheckNotNullIsNumeric($appYear) ? $appYear : NULL,
                            'conId'        => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : NULL,
                            'conSerial'    => $Conn->UtilCheckNotNull($conSerial) ? $conSerial : NULL,
                            'conMark'      => $Conn->UtilCheckNotNullIsNumeric($conMark) ? $conMark : NULL,
                            'conStatus'    => $Conn->UtilCheckNotNullIsNumeric($conStatus) ? $conStatus : NULL,
                            'conStatusNot' => $Conn->UtilCheckNotNullIsNumeric($conStatusNot) ? $conStatusNot : NULL,
                            'perKey'       => $Conn->UtilCheckNotNull($perKey) ? $perKey : NULL,
                            'appStatus'    => $Conn->UtilCheckNotNullIsNumeric($appStatus) ? $appStatus : NULL,
                            'appStatusNot' => $Conn->UtilCheckNotNullIsNumeric($appStatusNot) ? $appStatusNot : NULL,
                            'appMark'      => $Conn->UtilCheckNotNullIsNumeric($appMark) ? $appMark : NULL,
                            'appInh'       => $Conn->UtilCheckNotNullIsNumeric($appInh) ? $appInh : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `apportion` A
                     LEFT JOIN `contract` C ON C.`conId` = A.`conId`
                     LEFT JOIN `company` CM ON CM.`comCode` = C.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     WHERE 1 = 1';
            $sql .= $Conn->UtilCheckNotNull($appYear) ? ' AND A.`appYear` = :appYear' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conId) ? ' AND A.`conId` = :conId' : '';
            $sql .= $Conn->UtilCheckNotNull($perKey) ? ' AND C.`perKey` = :perKey' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($appStatus) ? ' AND A.`appStatus` = :appStatus' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($appStatusNot) ? ' AND A.`appStatus` != :appStatusNot' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($appMark) ? ' AND A.`appMark` = :appMark' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($appInh) ? ' AND A.`appInh` = :appInh' : '';
            $sql .= $Conn->UtilCheckNotNull($conSerial) ? ' AND C.`conSerial` = :conSerial' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conMark) ? ' AND C.`conMark` = :conMark' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conStatus) ? ' AND C.`conStatus` = :conStatus`' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conStatusNot) ? ' AND C.`conStatus` != :conStatusNot' : '';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryApportionByID 查看單一費用
         *
         * @param $rows
         * @param $appId
         *
         * @return mixed
         */
        function queryApportionByID($rows, $appId)
        {
            $Conn = new ConnManager();
            $arrPar = array('appId' => $Conn->UtilCheckNotNullIsNumeric($appId) ? $appId : '');
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `apportion` A
                     LEFT JOIN `contract` C ON C.`conId` = A.`conId`
                     LEFT JOIN `frame` F ON F.`frmId` = C.`frmId`
                     LEFT JOIN `template` T ON T.`temId` = C.`temId`
                     LEFT JOIN `company` CM ON CM.`comCode` = A.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = A.`perKey`
                     WHERE A.`appId` = :appId';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryApportionByInh 查看單一費用
         *
         * @param $rows
         * @param $appInh
         *
         * @return mixed
         */
        function queryApportionByInh($rows, $appInh)
        {
            $Conn = new ConnManager();
            $arrPar = array('appInh' => $Conn->UtilCheckNotNullIsNumeric($appInh) ? $appInh : -1);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `apportion`
                     WHERE `appInh` = :appInh';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }


        /**
         * todo:queryApportionLastByContract 查看計畫書相關最後單一費用
         *
         * @param $rows
         * @param $conId
         * @param $appStatus
         *
         * @return mixed
         */
        function queryApportionLastByContract($rows, $conId, $appStatus)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'     => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : '',
                            'appStatus' => $Conn->UtilCheckNotNullIsNumeric($appStatus) ? $appStatus : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `apportion` A
                     LEFT JOIN `contract` C ON C.`conId` = A.`conId`
                     LEFT JOIN `company` CM ON CM.`comCode` = A.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = A.`perKey`
                     WHERE A.`conId` = :conId';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($appStatus) ? ' AND A.`appStatus` = :appStatus' : '';
            $sql .= ' AND A.`appMark` = 0';
            $sql .= ' ORDER BY A.`appCreateTime` DESC';
            $sql .= ' LIMIT 0, 1';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:insertApportion 新增費用
         *
         * @param $conId
         * @param $perKey
         * @param $comCode
         * @param $appYear
         * @param $appVer
         * @param $appMark
         * @param $appType
         * @param $appStatus
         *
         * @return array|int|Number
         */
        function insertApportion($conId, $perKey, $comCode, $appYear, $appVer, $appMark, $appType, $appStatus)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'     => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : 0,
                            'perKey'    => $Conn->UtilCheckNotNull($perKey) ? $perKey : '',
                            'comCode'   => $Conn->UtilCheckNotNull($comCode) ? $comCode : '',
                            'appYear'   => $Conn->UtilCheckNotNull($appYear) ? $appYear : '',
                            'appVer'    => $Conn->UtilCheckNotNull($appVer) ? $appVer : 'A',
                            'appMark'   => $Conn->UtilCheckNotNullIsNumeric($appMark) ? $appMark : 0,
                            'appType'   => $Conn->UtilCheckNotNullIsNumeric($appType) ? $appType : 0,
                            'appStatus' => $Conn->UtilCheckNotNullIsNumeric($appStatus) ? $appStatus : -1);
            //SQL
            $sql = ' INSERT INTO `apportion`(`conId`, `perKey`, `comCode`, `appYear`, `appVer`, `appMark`, `appType`, `appStatus`, `appUpdateTime`, `appCreateTime`)
                     VALUES(:conId, :perKey, :comCode, :appYear, :appVer, :appMark, :appType, :appStatus, NOW(), NOW())';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:copyApportion 複製費用
         *
         * @param $appId
         * @param $conId
         * @param $appYear
         * @param $appVer
         * @param $appMark
         * @param $appStatus
         *
         * @return array|int|Number
         */
        function copyApportion($appId, $conId, $appYear, $appVer, $appMark, $appStatus)
        {
            $Conn = new ConnManager();
            $arrPar = array('appId'     => $Conn->UtilCheckNotNullIsNumeric($appId) ? $appId : 0,
                            'conId'     => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : NULL,
                            'appYear'   => $Conn->UtilCheckNotNull($appYear) ? $appYear : '',
                            'appVer'    => $Conn->UtilCheckNotNull($appVer) ? $appVer : 'A',
                            'appMark'   => $Conn->UtilCheckNotNullIsNumeric($appMark) ? $appMark : 0,
                            'appStatus' => $Conn->UtilCheckNotNullIsNumeric($appStatus) ? $appStatus : 0);
            //SQL
            $sql = ' INSERT INTO `apportion`(`conId`, `appYear`, `appVer`, `appMark`, `perKey`, `comCode`, `appStatus`, `appInh`, `appUpdateTime`, `appCreateTime`)
                     SELECT '.($Conn->UtilCheckNotNullIsNumeric($conId) ? ':conId' : `conId`).', '.($Conn->UtilCheckNotNull($appYear) ? ' :appYear' : ' `appYear`').', :appVer, :appMark, `perKey`, `comCode`, :appStatus, 0, NOW(), NOW() FROM `apportion` WHERE `appId` = :appId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:updateApportionByID 修改費用
         *
         * @param $appId
         * @param $appDate
         * @param $appStatus
         *
         * @return array|int
         */
        function updateApportionByID($appId, $appDate, $appStatus)
        {
            $Conn = new ConnManager();
            $arrPar = array('appId'     => $Conn->UtilCheckNotNullIsNumeric($appId) ? $appId : '',
                            'appDate'   => $Conn->UtilCheckNotNullIsDate($appDate) ? $appDate : NULL,
                            'appStatus' => $Conn->UtilCheckNotNullIsNumeric($appStatus) ? $appStatus : NULL);
            //SQL
            $sql = ' UPDATE `apportion`
                     SET `appDate` = '.($Conn->UtilCheckNotNullIsDate($appDate) ? ':appDate' : 'NULL').', `appUpdateTime` = NOW()';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($appStatus) ? ', `appStatus` = :appStatus' : '';
            $sql .= '  WHERE `appId` = :appId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:updateApportionUpdateTimeByID 修改費用修改時間
         *
         * @param $appId
         *
         * @return array|int
         */
        function updateApportionUpdateTimeByID($appId)
        {
            $Conn = new ConnManager();
            $arrPar = array('appId' => $Conn->UtilCheckNotNullIsNumeric($appId) ? $appId : '');
            //SQL
            $sql = ' UPDATE `apportion`
                     SET `appUpdateTime` = NOW()';
            $sql .= ' WHERE `appId` = :appId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:updateApportionStatusByID 修改費用狀態
         *
         * @param $appStatus
         * @param $appDate
         * @param $appId
         *
         * @return array|int
         */
        function updateApportionStatusByID($appId, $appStatus, $appDate)
        {
            $Conn = new ConnManager();
            $arrPar = array('appId'     => $Conn->UtilCheckNotNullIsNumeric($appId) ? $appId : '',
                            'appDate'   => $Conn->UtilCheckNotNullIsDate($appDate) ? $appDate : NULL,
                            'appStatus' => $Conn->UtilCheckNotNullIsNumeric($appStatus) ? $appStatus : 0);
            //SQL
            $sql = ' UPDATE `apportion`
                     SET `appStatus` = :appStatus, `appUpdateTime` = NOW()';
            $sql .= $Conn->UtilCheckNotNullIsDate($appDate) ? ' , `appDate` = :appDate' : '';
            $sql .= ' WHERE `appId` = :appId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:updateApportionMarkByID 修改費用作廢
         *
         * @param $appId
         * @param $appMark
         *
         * @return array|int
         */
        function updateApportionMarkByID($appId, $appMark)
        {
            $Conn = new ConnManager();
            $arrPar = array('appId'   => $Conn->UtilCheckNotNullIsNumeric($appId) ? $appId : 0,
                            'appMark' => $Conn->UtilCheckNotNullIsDate($appMark) ? $appMark : 0);
            //SQL
            $sql = ' UPDATE `apportion`
                     SET `appMark` = :appMark, `appUpdateTime` = NOW()';
            $sql .= ' WHERE `appId` = :appId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:updateApportionInheritByID 修改費用繼承
         *
         * @param $appId
         * @param $appInh
         *
         * @return array|int
         */
        function updateApportionInheritByID($appId, $appInh)
        {
            $Conn = new ConnManager();
            $arrPar = array('appId'  => $Conn->UtilCheckNotNullIsNumeric($appId) ? $appId : 0,
                            'appInh' => $Conn->UtilCheckNotNullIsDate($appInh) ? $appInh : 0);
            //SQL
            $sql = ' UPDATE `apportion`
                     SET `appInh` = :appInh, `appUpdateTime` = NOW()';
            $sql .= ' WHERE `appId` = :appId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:cleanApportionInheritByID 清除費用繼承
         *
         * @param $appInh
         *
         * @return array|int
         */
        function cleanApportionInheritByID($appInh)
        {
            $Conn = new ConnManager();
            $arrPar = array('appInh' => $Conn->UtilCheckNotNullIsDate($appInh) ? $appInh : 0);
            //SQL
            $sql = ' UPDATE `apportion`
                     SET `appInh` = 0, `appUpdateTime` = NOW()';
            $sql .= ' WHERE `appInh` = :appInh AND `appMark` = 0';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteApportionByID 刪除費用
         *
         * @param int $appId 編號
         *
         * @return int|boolean
         */
        function deleteApportionByID($appId)
        {
            $Conn = new ConnManager();
            $arrPar = array('appId' => $Conn->UtilCheckNotNullIsNumeric($appId) ? $appId : 0);
            //SQL
            $sql = ' DELETE FROM `apportion`
                     WHERE `appId` = :appId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:queryExes 查看分攤明細
         *
         * @param $rows
         * @param $appId
         *
         * @return mixed
         */
        function queryExes($rows, $appId)
        {
            $Conn = new ConnManager();
            $arrPar = array('appId' => $Conn->UtilCheckNotNullIsNumeric($appId) ? $appId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `exes` E
                     LEFT JOIN `item` I ON I.`iteId` = E.`iteId`
                     LEFT JOIN `apportion` A ON A.`appId` = E.`appId`
                     LEFT JOIN `contract` C ON C.`conId` = A.`conId`
                     LEFT JOIN `work` W ON W.`worId` = I.`worId`
                     LEFT JOIN `distribution` D ON D.`disId` = I.`disId`
                     LEFT JOIN `manner` M ON M.`manId` = I.`manId`
                     LEFT JOIN `source` S ON S.`souId` = I.`iteTime`
                     WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($appId) ? ' AND E.`appId` = :appId' : '';
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryExesByID 查看單一分攤明細
         *
         * @param $rows
         * @param $exeId
         *
         * @return mixed
         */
        function queryExesByID($rows, $exeId)
        {
            $Conn = new ConnManager();
            $arrPar = array('exeId' => $Conn->UtilCheckNotNullIsNumeric($exeId) ? $exeId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `exes` E
                     LEFT JOIN `item` I ON I.`iteId` = E.`iteId`
                     LEFT JOIN `apportion` A ON A.`appId` = E.`appId`
                     LEFT JOIN `contract` C ON C.`conId` = A.`conId`
                     LEFT JOIN `work` W ON W.`worId` = I.`worId`
                     LEFT JOIN `distribution` D ON D.`disId` = I.`disId`
                     LEFT JOIN `manner` M ON M.`manId` = I.`manId`
                     LEFT JOIN `source` S ON S.`souId` = I.`iteTime`
                     WHERE E.`exeId` = :exeId';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:deleteExesByID 刪除分攤明細
         *
         * @param $exeId
         *
         * @return mixed
         */
        function deleteExesByID($exeId)
        {
            $Conn = new ConnManager();
            $arrPar = array('exeId' => $Conn->UtilCheckNotNullIsNumeric($exeId) ? $exeId : 0);
            //SQL
            $sql = ' DELETE FROM `exes`
                     WHERE `exeId` = :exeId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteExesByApportion 刪除分攤明細
         *
         * @param $appId
         * @param $exeId_list
         *
         * @return mixed
         */
        function deleteExesByApportion($appId, $exeId_list)
        {
            $Conn = new ConnManager();
            $arrPar = array('appId' => $Conn->UtilCheckNotNullIsNumeric($appId) ? $appId : 0);
            //SQL
            $sql = ' DELETE FROM `exes`
                     WHERE `appId` = :appId';
            $sql_exeId = '';
            if (is_array($exeId_list)) {
                foreach ($exeId_list as $exeId) {
                    $sql_exeId .= ('' != $sql_exeId ? ',' : '').$exeId;
                }
                if ('' != $exeId_list) {
                    $sql_exeId = ' AND `exeId` NOT IN ('.$sql_exeId.')';
                }
            }
            $sql .= $sql_exeId;
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteExesByApportionId 刪除費用相關分攤明細
         *
         * @param $apportionId
         *
         * @return mixed
         */
        function deleteExesByApportionId($apportionId)
        {
            $Conn = new ConnManager();
            $arrPar = array('apportionId' => $Conn->UtilCheckNotNullIsNumeric($apportionId) ? $apportionId : 0);
            //SQL
            $sql = ' DELETE FROM `exes`
                     WHERE `appId` = :apportionId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:insertExes 新增分攤明細
         *
         * @param $appId
         * @param $iteId
         * @param $exeTitle
         * @param $exeCost
         * @param $exeCreateMonth
         * @param $exePM
         * @param $exeSP
         * @param $exeMonth
         * @param $exeStartYear
         * @param $exeNote
         * @param $exeStatus
         *
         * @return array|int|Number
         */
        function insertExes($appId, $iteId, $exeTitle, $exePM, $exeSP, $exeCost, $exeCreateMonth, $exeMonth, $exeStartYear, $exeNote, $exeStatus)
        {
            $Conn = new ConnManager();
            $arrPar = array('appId'          => $Conn->UtilCheckNotNullIsNumeric($appId) ? $appId : 0,
                            'iteId'          => $Conn->UtilCheckNotNullIsNumeric($iteId) ? $iteId : 0,
                            'exeTitle'       => $Conn->UtilCheckNotNull($exeTitle) ? $exeTitle : '',
                            'exePM'          => $Conn->UtilCheckNotNullIsNumeric($exePM) ? $exePM : 0,
                            'exeSP'          => $Conn->UtilCheckNotNullIsNumeric($exeSP) ? $exeSP : 0,
                            'exeCost'        => $Conn->UtilCheckNotNullIsNumeric($exeCost) ? $exeCost : 0,
                            'exeCreateMonth' => $Conn->UtilCheckNotNull($exeCreateMonth) ? $exeCreateMonth : '',
                            'exeMonth'       => $Conn->UtilCheckNotNullIsNumeric($exeMonth) ? $exeMonth : 0,
                            'exeStartYear'   => $Conn->UtilCheckNotNull($exeStartYear) ? $exeStartYear : '',
                            'exeNote'        => $Conn->UtilCheckNotNull($exeNote) ? $exeNote : '',
                            'exeStatus'      => $Conn->UtilCheckNotNullIsNumeric($exeStatus) ? $exeStatus : 0);
            //SQL
            $sql = ' INSERT INTO `exes`(`appId`, `iteId`, `exeTitle`, `exePM`, `exeSP`, `exeCost`, `exeCreateMonth`, `exeMonth`, `exeStartYear`, `exeNote`, `exeStatus`)
                     VALUES(:appId, :iteId, :exeTitle, :exePM, :exeSP, :exeCost, :exeCreateMonth, :exeMonth, :exeStartYear, :exeNote, :exeStatus)';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:copyExes 複製分攤明細
         *
         * @param $appId
         * @param $appIdNew
         *
         * @return array|int|Number
         */
        function copyExes($appId, $appIdNew)
        {
            $Conn = new ConnManager();
            $arrPar = array('appId'    => $Conn->UtilCheckNotNullIsNumeric($appId) ? $appId : 0,
                            'appIdNew' => $Conn->UtilCheckNotNullIsNumeric($appIdNew) ? $appIdNew : 0);
            //SQL
            $sql = ' INSERT INTO `exes`(`appId`, `iteId`, `exeTitle`, `exePM`, `exeSP`, `exeCost`, `exeCreateMonth`, `exeMonth`, `exeStartYear`, `exeNote`, `exeStatus`)
                     SELECT :appIdNew, `iteId`, `exeTitle`, `exePM`, `exeSP`, `exeCost`, `exeCreateMonth`, `exeMonth`, `exeStartYear`, `exeNote`, `exeStatus` FROM `exes` WHERE `appId` = :appId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:copyExesByID 複製分攤明細
         *
         * @param $exeId
         * @param $appIdNew
         *
         * @return array|int|Number
         */
        function copyExesByID($exeId, $appIdNew)
        {
            $Conn = new ConnManager();
            $arrPar = array('exeId'    => $Conn->UtilCheckNotNullIsNumeric($exeId) ? $exeId : 0,
                            'appIdNew' => $Conn->UtilCheckNotNullIsNumeric($appIdNew) ? $appIdNew : 0);
            //SQL
            $sql = ' INSERT INTO `exes`(`appId`, `iteId`, `exeTitle`, `exePM`, `exeSP`, `exeCost`, `exeCreateMonth`, `exeMonth`, `exeStartYear`, `exeNote`, `exeStatus`)
                     SELECT :appIdNew, `iteId`, `exeTitle`, `exePM`, `exeSP`, `exeCost`, `exeCreateMonth`, `exeMonth`, `exeStartYear`, `exeNote`, `exeStatus` FROM `exes` WHERE `exeId` = :exeId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:updateExes 修改分攤明細
         *
         * @param $exeId
         * @param $iteId
         * @param $exeTitle
         * @param $exePM
         * @param $exeSP
         * @param $exeCost
         * @param $exeCreateMonth
         * @param $exeMonth
         * @param $exeStartYear
         * @param $exeNote
         *
         * @return array|int
         */
        function updateExes($exeId, $iteId, $exeTitle, $exePM, $exeSP, $exeCost, $exeCreateMonth, $exeMonth, $exeStartYear, $exeNote)
        {
            $Conn = new ConnManager();
            $arrPar = array('iteId'          => $Conn->UtilCheckNotNullIsNumeric($iteId) ? $iteId : 0,
                            'exeTitle'       => $Conn->UtilCheckNotNull($exeTitle) ? $exeTitle : '',
                            'exePM'          => $Conn->UtilCheckNotNullIsNumeric($exePM) ? $exePM : 0,
                            'exeSP'          => $Conn->UtilCheckNotNullIsNumeric($exeSP) ? $exeSP : 0,
                            'exeCost'        => $Conn->UtilCheckNotNullIsNumeric($exeCost) ? $exeCost : 0,
                            'exeCreateMonth' => $Conn->UtilCheckNotNull($exeCreateMonth) ? $exeCreateMonth : '',
                            'exeMonth'       => $Conn->UtilCheckNotNullIsNumeric($exeMonth) ? $exeMonth : 0,
                            'exeStartYear'   => $Conn->UtilCheckNotNull($exeStartYear) ? $exeStartYear : '',
                            'exeNote'        => $Conn->UtilCheckNotNull($exeNote) ? $exeNote : '',
                            'exeId'          => $Conn->UtilCheckNotNullIsNumeric($exeId) ? $exeId : 0);
            //SQL
            $sql = ' UPDATE `exes`
                     SET `iteId` = :iteId, `exeTitle` = :exeTitle, `exePM` = :exePM, `exeSP` = :exeSP, `exeCost` = :exeCost, `exeCreateMonth` = :exeCreateMonth, `exeMonth` = :exeMonth, `exeStartYear` = :exeStartYear, `exeNote` = :exeNote
                     WHERE `exeId` = :exeId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:queryAnnual 查看各年度分攤費用
         *
         * @param $rows
         * @param $exeId
         *
         * @return mixed
         */
        function queryAnnual($rows, $exeId)
        {
            $Conn = new ConnManager();
            $arrPar = array('exeId' => $Conn->UtilCheckNotNullIsNumeric($exeId) ? $exeId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `annual` A
                     LEFT JOIN `exes` E ON E.`exeId` = A.`exeId`
                     WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($exeId) ? ' AND A.`exeId` = :exeId' : '';
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryAnnualByID 查看單一各年度分攤費用
         *
         * @param $rows
         * @param $annId
         *
         * @return mixed
         */
        function queryAnnualByID($rows, $annId)
        {
            $Conn = new ConnManager();
            $arrPar = array('annId' => $Conn->UtilCheckNotNullIsNumeric($annId) ? $annId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `annual` A
                     LEFT JOIN `exes` E ON E.`exeId` = A.`exeId`
                     WHERE A.`annId` = :annId';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:insertAnnual 新增各年度分攤費用
         *
         * @param $exeId
         * @param $annYear
         * @param $annStartMonth
         * @param $annEndMonth
         * @param $annMonth
         * @param $annCost
         * @param $annStatus
         *
         * @return array|int|Number
         */
        function insertAnnual($exeId, $annYear, $annStartMonth, $annEndMonth, $annMonth, $annCost, $annStatus)
        {
            $Conn = new ConnManager();
            $arrPar = array('exeId'         => $Conn->UtilCheckNotNullIsNumeric($exeId) ? $exeId : 0,
                            'annYear'       => $Conn->UtilCheckNotNull($annYear) ? $annYear : '',
                            'annStartMonth' => $Conn->UtilCheckNotNull($annStartMonth) ? $annStartMonth : '',
                            'annEndMonth'   => $Conn->UtilCheckNotNull($annEndMonth) ? $annEndMonth : '',
                            'annMonth'      => $Conn->UtilCheckNotNullIsNumeric($annMonth) ? $annMonth : 0,
                            'annCost'       => $Conn->UtilCheckNotNullIsNumeric($annCost) ? $annCost : 0,
                            'annStatus'     => $Conn->UtilCheckNotNullIsNumeric($annStatus) ? $annStatus : 0);
            //SQL
            $sql = ' INSERT INTO `annual`(`exeId`, `annYear`, `annStartMonth`, `annEndMonth`, `annMonth`, `annCost`, `annStatus`)
                     VALUES(:exeId, :annYear, :annStartMonth, :annEndMonth, :annMonth, :annCost, :annStatus)';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:copyAnnualByID 複製各年度分攤費用
         *
         * @param $annId
         * @param $exeIdNew
         *
         * @return array|int|Number
         */
        function copyAnnualByID($annId, $exeIdNew)
        {
            $Conn = new ConnManager();
            $arrPar = array('annId'    => $Conn->UtilCheckNotNullIsNumeric($annId) ? $annId : 0,
                            'exeIdNew' => $Conn->UtilCheckNotNullIsNumeric($exeIdNew) ? $exeIdNew : 0);
            //SQL
            $sql = ' INSERT INTO `annual`(`exeId`, `annYear`, `annStartMonth`, `annEndMonth`, `annMonth`, `annCost`, `annStatus`)
                     SELECT :exeIdNew, `annYear`, `annStartMonth`, `annEndMonth`, `annMonth`, `annCost`, `annStatus` FROM `annual` WHERE `annId` = :annId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }


        /**
         * todo:updateAnnual 修改各年度分攤費用
         *
         * @param $annId
         * @param $annYear
         * @param $annStartMonth
         * @param $annEndMonth
         * @param $annMonth
         * @param $annCost
         * @param $annStatus
         *
         * @return array|int
         */
        function updateAnnual($annId, $annYear, $annStartMonth, $annEndMonth, $annMonth, $annCost, $annStatus)
        {
            $Conn = new ConnManager();
            $arrPar = array('annId'         => $Conn->UtilCheckNotNullIsNumeric($annId) ? $annId : 0,
                            'annYear'       => $Conn->UtilCheckNotNull($annYear) ? $annYear : '',
                            'annStartMonth' => $Conn->UtilCheckNotNull($annStartMonth) ? $annStartMonth : '',
                            'annEndMonth'   => $Conn->UtilCheckNotNull($annEndMonth) ? $annEndMonth : '',
                            'annMonth'      => $Conn->UtilCheckNotNullIsNumeric($annMonth) ? $annMonth : 0,
                            'annCost'       => $Conn->UtilCheckNotNullIsNumeric($annCost) ? $annCost : 0,
                            'annStatus'     => $Conn->UtilCheckNotNullIsNumeric($annStatus) ? $annStatus : NULL);
            //SQL
            $sql = ' UPDATE `annual`
                     SET `annYear` = :annYear, `annStartMonth` = :annStartMonth, `annEndMonth` = :annEndMonth, `annMonth` = :annMonth, `annCost` = :annCost';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($annStatus) ? ', `annStatus` = :annStatus' : '';
            $sql .= ' WHERE `annId` = :annId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteAnnualByID 刪除各年度分攤費用
         *
         * @param $annId
         *
         * @return mixed
         */
        function deleteAnnualByID($annId)
        {
            $Conn = new ConnManager();
            $arrPar = array('annId' => $Conn->UtilCheckNotNullIsNumeric($annId) ? $annId : 0);
            //SQL
            $sql = ' DELETE FROM `annual`
                     WHERE `annId` = :annId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteAnnualByApportion 刪除各年度分攤費用
         *
         * @param $exeId
         * @param $annId_list
         *
         * @return mixed
         */
        function deleteAnnualByApportion($exeId, $annId_list)
        {
            $Conn = new ConnManager();
            $arrPar = array('exeId' => $Conn->UtilCheckNotNullIsNumeric($exeId) ? $exeId : 0);
            //SQL
            $sql = ' DELETE FROM `annual`
                     WHERE `exeId` = :exeId';
            $sql_annId = '';
            if (is_array($annId_list)) {
                foreach ($annId_list as $annId) {
                    $sql_annId .= ('' != $annId ? ',' : '').$annId;
                }
                if ('' != $annId_list) {
                    $sql_annId = ' AND `exeId` NOT IN ('.$sql_annId.')';
                }
            }
            $sql .= $sql_annId;
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteAnnualByApportionId 刪除費用相關各年度分攤費用
         *
         * @param $apportionId
         *
         * @return mixed
         */
        function deleteAnnualByApportionId($apportionId)
        {
            $Conn = new ConnManager();
            $arrPar = array('apportionId' => $Conn->UtilCheckNotNullIsNumeric($apportionId) ? $apportionId : 0);
            //SQL
            $sql = ' DELETE A FROM `annual` A
                     LEFT JOIN `exes` E ON E.`exeId` = A.`exeId`
                     WHERE E.`appId` = :apportionId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }


        /**
         * todo:querySubsidiary 查看各公司分攤費用
         *
         * @param $rows
         * @param $annId
         *
         * @return mixed
         */
        function querySubsidiary($rows, $annId)
        {
            $Conn = new ConnManager();
            $arrPar = array('annId' => $Conn->UtilCheckNotNullIsNumeric($annId) ? $annId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `subsidiary` S
                     LEFT JOIN `annual` A ON A.`annId` = S.`annId`
                     LEFT JOIN `exes` E ON E.`exeId` = A.`exeId`
                     WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($annId) ? ' AND S.`annId` = :annId' : '';
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:querySubsidiaryByID 查看單一各公司分攤費用
         *
         * @param $rows
         * @param $subId
         *
         * @return mixed
         */
        function querySubsidiaryByID($rows, $subId)
        {
            $Conn = new ConnManager();
            $arrPar = array('subId' => $Conn->UtilCheckNotNullIsNumeric($subId) ? $subId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `subsidiary` S
                     LEFT JOIN `annual` A ON S.`annId` = S.`annId`
                     LEFT JOIN `exes` E ON E.`exeId` = A.`exeId`
                     WHERE S.`subId` = :subId';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:deleteSubsidiaryByID 刪除各公司分攤費用
         *
         * @param $subId
         *
         * @return mixed
         */
        function deleteSubsidiaryByID($subId)
        {
            $Conn = new ConnManager();
            $arrPar = array('subId' => $Conn->UtilCheckNotNullIsNumeric($subId) ? $subId : 0);
            //SQL
            $sql = ' DELETE FROM `subsidiary`
                     WHERE `subId` = :subId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteSubsidiaryByApportion 刪除各公司分攤費用
         *
         * @param $annId
         * @param $subId_list
         *
         * @return mixed
         */
        function deleteSubsidiaryByApportion($annId, $subId_list)
        {
            $Conn = new ConnManager();
            $arrPar = array('annId' => $Conn->UtilCheckNotNullIsNumeric($annId) ? $annId : 0);
            //SQL
            $sql = ' DELETE FROM `subsidiary`
                     WHERE `annId` = :annId';
            $sql_subId = '';
            if (is_array($subId_list)) {
                foreach ($subId_list as $subId) {
                    $sql_subId .= ('' != $sql_subId ? ',' : '').$subId;
                }
                if ('' != $subId_list) {
                    $sql_subId = ' AND `annId` NOT IN ('.$sql_subId.')';
                }
            }
            $sql .= $sql_subId;
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteSubsidiaryByApportion 刪除費用相關各公司分攤費用
         *
         * @param $apportionId
         *
         * @return mixed
         */
        function deleteSubsidiaryByApportionId($apportionId)
        {
            $Conn = new ConnManager();
            $arrPar = array('apportionId' => $Conn->UtilCheckNotNullIsNumeric($apportionId) ? $apportionId : 0);
            //SQL
            $sql = ' DELETE S FROM `subsidiary` S
                     LEFT JOIN `annual` A ON A.`annId` = S.`annId`
                     LEFT JOIN `exes` E ON E.`exeId` = A.`exeId`
                     WHERE E.`appId` = :apportionId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:insertSubsidiary 新增各公司分攤費用
         *
         * @param $annId
         * @param $comCode
         * @param $subAmount
         * @param $subPercent
         * @param $subCost
         *
         * @return array|int|Number
         */
        function insertSubsidiary($annId, $comCode, $subAmount, $subPercent, $subCost)
        {
            $Conn = new ConnManager();
            $arrPar = array('annId'      => $Conn->UtilCheckNotNullIsNumeric($annId) ? $annId : 0,
                            'comCode'    => $Conn->UtilCheckNotNull($comCode) ? $comCode : '',
                            'subAmount'  => $Conn->UtilCheckNotNullIsNumeric($subAmount) ? $subAmount : 0,
                            'subPercent' => $Conn->UtilCheckNotNullIsNumeric($subPercent) ? $subPercent : 0,
                            'subCost'    => $Conn->UtilCheckNotNullIsNumeric($subCost) ? $subCost : 0);
            //SQL
            $sql = ' INSERT INTO `subsidiary`(`annId`, `comCode`, `subAmount`, `subPercent`, `subCost`)
                     VALUES(:annId, :comCode, :subAmount, :subPercent, :subCost)';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:copySubsidiaryByID 複製各公司分攤費用
         *
         * @param $subId
         * @param $annIdNew
         *
         * @return array|int|Number
         */
        function copySubsidiaryByID($subId, $annIdNew)
        {
            $Conn = new ConnManager();
            $arrPar = array('subId'    => $Conn->UtilCheckNotNullIsNumeric($subId) ? $subId : 0,
                            'annIdNew' => $Conn->UtilCheckNotNullIsNumeric($annIdNew) ? $annIdNew : 0);
            //SQL
            $sql = ' INSERT INTO `subsidiary`(`annId`, `comCode`, `subAmount`, `subPercent`, `subCost`)
                     SELECT :annIdNew, `comCode`, `subAmount`, `subPercent`, `subCost` FROM `subsidiary` WHERE `subId` = :subId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:updateSubsidiary 修改各公司分攤費用
         *
         * @param $subId
         * @param $comCode
         * @param $subAmount
         * @param $subPercent
         * @param $subCost
         *
         * @return array|int
         */
        function updateSubsidiary($subId, $comCode, $subAmount, $subPercent, $subCost)
        {
            $Conn = new ConnManager();
            $arrPar = array('comCode'    => $Conn->UtilCheckNotNull($comCode) ? $comCode : '',
                            'subAmount'  => $Conn->UtilCheckNotNullIsNumeric($subAmount) ? $subAmount : 0,
                            'subPercent' => $Conn->UtilCheckNotNullIsNumeric($subPercent) ? $subPercent : 0,
                            'subCost'    => $Conn->UtilCheckNotNullIsNumeric($subCost) ? $subCost : 0,
                            'subId'      => $Conn->UtilCheckNotNullIsNumeric($subId) ? $subId : 0);
            //SQL
            $sql = ' UPDATE `subsidiary`
                     SET `comCode` = :comCode, `subAmount` = :subAmount, `subPercent` = :subPercent, `subCost` = :subCost
                     WHERE `subId` = :subId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }


        /**
         * todo:queryInfoByID 查看單一設定資訊
         *
         * @param $rows
         * @param $infId
         *
         * @return mixed
         */
        function queryInfoByID($rows, $infId)
        {
            $Conn = new ConnManager();
            $arrPar = array('infId' => $Conn->UtilCheckNotNullIsNumeric($infId) ? $infId : '');
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `info`
                     WHERE `infId` = :infId';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:updateInfoByID 修改設定資訊
         *
         * @param $infId
         * @param $infYear
         * @param $infPM
         * @param $infSP
         *
         * @return array|int
         */
        function updateInfoByID($infId, $infYear, $infPM, $infSP)
        {
            $Conn = new ConnManager();
            $arrPar = array('infId'   => $Conn->UtilCheckNotNullIsNumeric($infId) ? $infId : 0,
                            'infYear' => $Conn->UtilCheckNotNullIsNumeric($infYear) ? $infYear : NULL,
                            'infPM'   => $Conn->UtilCheckNotNullIsNumeric($infPM) ? $infPM : NULL,
                            'infSP'   => $Conn->UtilCheckNotNullIsNumeric($infSP) ? $infSP : NULL);
            //SQL
            $sql = ' UPDATE `info`
                     SET `infUpdateTime` = NOW()';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($infYear) ? ' , `infYear` = :infYear' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($infPM) ? ' , `infPM` = :infPM' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($infSP) ? ' , `infSP` = :infSP' : '';
            $sql .= ' WHERE `infId` = :infId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }


        /**
         * todo:querySearchForAction 查看文件費用資料
         *
         * @param $keyword
         * @param $temId
         * @param $comId
         * @param $comCode
         * @param $conSerial
         * @param $status
         * @param $perKey
         * @param $perBu1Code
         * @param $memOwner 1:擁有者
         * @param $memDraft 1:草稿
         * @param $memView  1:待檢視
         * @param $memSign  1:待簽
         * @param $memOver  1:已簽
         * @param $statusNot
         * @param $mark     1:棄用
         * @param $inh      1:被繼承
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function querySearchForAction($keyword, $temId, $comId, $comCode, $conSerial, $status, $perKey, $perBu1Code, $memOwner, $memDraft, $memView, $memSign, $memOver, $statusNot, $mark, $inh, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('keyword'    => $Conn->UtilCheckNotNull($keyword) ? $Conn->getRegexpString($keyword, '|') : NULL,
                            'conSerial'  => $Conn->UtilCheckNotNull($conSerial) ? $conSerial : NULL,
                            'comId'      => $Conn->UtilCheckNotNullIsNumeric($comId) ? $comId : NULL,
                            'comCode'    => $Conn->UtilCheckNotNull($comCode) ? $comCode : NULL,
                            'status'     => $Conn->UtilCheckNotNullIsNumeric($status) ? $status : NULL,
                            'perKey'     => $Conn->UtilCheckNotNull($perKey) ? $perKey : '',
                            'perBu1Code' => $Conn->UtilCheckNotNull($perBu1Code) ? $perBu1Code : '',
                            'temId'      => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : NULL,
                            'memOwner'   => $Conn->UtilCheckNotNullIsNumeric($memOwner) ? $memOwner : NULL,
                            'memDraft'   => $Conn->UtilCheckNotNullIsNumeric($memDraft) ? $memDraft : NULL,
                            'memView'    => $Conn->UtilCheckNotNullIsNumeric($memView) ? $memView : NULL,
                            'memSign'    => $Conn->UtilCheckNotNullIsNumeric($memSign) ? $memSign : NULL,
                            'memOver'    => $Conn->UtilCheckNotNullIsNumeric($memOver) ? $memOver : NULL,
                            'statusNot'  => $Conn->UtilCheckNotNullIsNumeric($statusNot) ? $statusNot : NULL,
                            'mark'       => $Conn->UtilCheckNotNullIsNumeric($mark) ? $mark : NULL,
                            'inh'        => $Conn->UtilCheckNotNullIsNumeric($inh) ? $inh : NULL
            );
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS T.`temId`, T.`temTitle`, T.`temExes`, C.*, F.`frmTitle`, P.`perBu1`, P.`perBu2`, P.`perBu3`, CM.`comTitle`, M.`memOwner`, M.`memDraft`, M.`memView`, M.`memSign`, M.`memOver` 
                     FROM (
                        SELECT * FROM (
                            SELECT 0 AS `Type`, C.`conId`, C.`conApp`, CASE WHEN C.`conApp` < 0 THEN 0 ELSE C.`conApp` END AS `appId`, C.`conTitle`, C.`conType`, A.`appType`, C.`temId`, C.`perKey`, C.`comCode`, C.`frmId`, C.`conSerial`, `C`.`conVer`, A.`appYear`, A.`appVer`, C.`conMark`, A.`appMark`, C.`conMark` AS `Mark`, C.`conInh`, A.`appInh`, C.`conInh` AS `Inh`, C.`conStatus`, A.`appStatus`, C.`conStatus` AS `Status`, C.`conDate`, A.`appDate`, C.`conDate` AS `Date`, C.`conCreateTime`, A.`appCreateTime` FROM `contract` C
                            LEFT JOIN `apportion` A ON C.`conApp` = `A`.`appId`
                        ) C
                        UNION
                        SELECT * FROM (
                            SELECT 1 AS `Type`, 0 AS `conId`, 0 AS `conApp`, A.`appId`, C.`conTitle`, C.`conType`, A.`appType`, C.`temId`, A.`perKey`, A.`comCode`, C.`frmId`, C.`conSerial`, `C`.`conVer`, A.`appYear`, A.`appVer`, C.`conMark`, A.`appMark`, A.`appMark` AS `Mark`, C.`conInh`, A.`appInh`, A.`appInh` AS `Inh`, C.`conStatus`, A.`appStatus`, A.`appStatus` AS `Status`, C.`conDate`, A.`appDate`, A.`appDate` AS `Date`, C.`conCreateTime`, A.`appCreateTime` FROM `apportion` A
                            LEFT JOIN `contract` C ON C.`conId` = A.`conId`
                            WHERE C.`conApp` = -1
                        ) A
                     ) C
                     LEFT JOIN `template` T ON T.`temId` = C.`temId`
                     LEFT JOIN `company` CM ON CM.`comCode` = C.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     LEFT JOIN `frame` F ON F.`frmId` = C.`frmId`
                     LEFT JOIN (
                                SELECT M.`conId`, M.`appId`, COUNT(*) AS `CT`, 
                                    CASE WHEN SUM(`memOwner`) > 0 THEN 1 ELSE 0 END AS `memOwner`,
                                    CASE WHEN SUM(`memDraft`) > 0 THEN 1 ELSE 0 END AS `memDraft`,
                                    CASE WHEN SUM(`memView`) > 0 THEN 1 ELSE 0 END AS `memView`,
                                    CASE WHEN SUM(`memSign`) > 0 THEN 1 ELSE 0 END AS `memSign`,
                                    CASE WHEN SUM(`memOver`) > 0 THEN 1 ELSE 0 END AS `memOver` FROM (
                                        SELECT M.`conId`, M.`appId`, 
                                            CASE WHEN (M.`memType` = 0 AND M.`memLV0Key` = :perKey) THEN 1 ELSE 0 END AS `memOwner`,
                                            CASE WHEN (M.`memType` = 0 AND M.`memLV0Status` = -1) THEN 1 ELSE 0 END AS `memDraft`,
                                            CASE WHEN (M.`memType` = 0 AND M.`memLVCStatus` = 0 AND CT.`perKey` = :perKey) OR 
                                                      (M.`memNowKey` = :perKey AND M.`memNowStatus` = 0) THEN 1 ELSE 0 END AS `memView`,
                                            CASE WHEN (M.`memType` = 0 AND M.`memLVCStatus` = 1 AND CT.`perKey` = :perKey) OR 
                                                      (M.`memNowKey` = :perKey AND M.`memNowStatus` = 1) THEN 1 ELSE 0 END AS `memSign`,
                                            CASE WHEN (M.`memType` = 0 AND M.`memLVCStatus` = 3 AND CT.`perKey` = :perKey) OR 
                                                      (M.`memLV0Key` = :perKey AND M.`memLV0Status` = 3) OR
                                                      (M.`memLV1Key` = :perKey AND M.`memLV1Status` = 3) OR
                                                      (M.`memLV2Key` = :perKey AND M.`memLV2Status` = 3) THEN 1 ELSE 0 END AS `memOver`
                                        FROM `member` M
                                        LEFT JOIN `company` CP ON CP.`comCode` = M.`memBu1Code`
                                        LEFT JOIN `contact` CT ON CP.`comCode` = CT.`comCode` AND CT.`perKey` = :perKey
                                        WHERE 1=1 
                                            AND (
                                                ((M.`memType` = 0 AND M.`memLV0Key` = :perKey) OR (M.`memType` != 0 AND M.`memLV0Key` = :perKey AND M.`memLV0Status` NOT IN (-1, 2))) OR
                                                (M.`memLV0Key` = :perKey AND M.`memLV0Status` != -1) OR
                                                (M.`memType` = 0 AND M.`memLVCStatus` != -1 AND M.`memLV0Status` = 3 AND CT.`perKey` =:perKey) OR
                                                (M.`memLV1Key` = :perKey AND M.`memLV1Status` NOT IN (-1, 2) AND ((M.`memType` = 0 AND M.`memLVCStatus` = 3) OR (M.`memType` != 0 AND M.`memLV0Status` = 3))) OR
                                                (M.`memLV2Key` = :perKey AND M.`memLV2Status` NOT IN (-1, 2) AND M.`memLV1Status` = 3)
                                            )
                                        ) M
                                GROUP BY M.`conId`, M.`appId`, M.`memOwner`, M.`memDraft`, M.`memView`, M.`memSign`, M.`memOver`
                                ) M ON M.`conId` = C.`conId` AND M.`appId` = C.`appId`
                     WHERE 1 = 1';
            $sql .= $Conn->UtilCheckNotNull($keyword) ? ' AND (C.`conTitle` REGEXP :keyword OR CONCAT(C.`conSerial`, C.`conVer`) REGEXP :keyword)' : '';
            $sql .= $Conn->UtilCheckNotNull($conSerial) ? ' AND C.`conSerial` = :conSerial' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($comId) ? ' AND CM.`comId` = :comId' : '';
            $sql .= $Conn->UtilCheckNotNull($comCode) ? ' AND C.`comCode` = :comCode' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($status) ? ' AND C.`Status` = :status' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($temId) ? ' AND C.`temId` = :temId' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($statusNot) ? ' AND C.`Status` != :statusNot' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($mark) ? ' AND C.`Mark` = :mark' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($inh) ? ' AND C.`Inh` = :inh' : '';
            $sql .= ' AND ((M.`CT` > 0 AND C.`Status` IN (0, 1, 3, 4)) OR (M.`CT` IS NULL AND C.`perKey` = :perKey AND C.`Status` >= 0))';
            if ($Conn->UtilCheckNotNullIsNumeric($memOwner) || $Conn->UtilCheckNotNullIsNumeric($memDraft) || $Conn->UtilCheckNotNullIsNumeric($memView) || $Conn->UtilCheckNotNullIsNumeric($memSign) || $Conn->UtilCheckNotNullIsNumeric($memOver)) {
                $sql .= ' AND (1=2';
                $sql .= $Conn->UtilCheckNotNullIsNumeric($memOwner) ? ' OR M.`memOwner` = :memOwner  OR C.`perKey` = :perKey' : '';
                $sql .= $Conn->UtilCheckNotNullIsNumeric($memDraft) ? ' OR M.`memDraft` = :memDraft OR C.`perKey` = :perKey' : '';
                $sql .= $Conn->UtilCheckNotNullIsNumeric($memView) ? ' OR M.`memView` = :memView' : '';
                $sql .= $Conn->UtilCheckNotNullIsNumeric($memSign) ? ' OR M.`memSign` = :memSign' : '';
                $sql .= $Conn->UtilCheckNotNullIsNumeric($memOver) ? ' OR M.`memOver` = :memOver' : '';
                $sql .= ' )';
            }
            $sql .= ' AND C.`Status` != -1';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryInventory 查看清冊
         *
         * @param $rows
         *
         * @return mixed
         */
        function queryInventory($rows)
        {
            $Conn = new ConnManager();
            $arrPar = array();
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contract` C
                     LEFT JOIN `template` T ON T.`temId` = C.`temId`
                     LEFT JOIN `frame` F ON F.`frmId` = C.`frmId`
                     LEFT JOIN `company` COM ON COM.`comCode` = C.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     LEFT JOIN (
                         SELECT APP.`appId`, MAX(E.`exeCreateMonth`) AS `conFirst`, MIN(ANN.`annEndMonth`) AS `conLast` FROM `apportion` APP
                         LEFT JOIN `exes` E ON E.`appId` = APP.`appId`
                         LEFT JOIN `annual` ANN ON ANN.`exeId` = E.`exeId`
                         GROUP BY APP.`appId`
                     ) APP ON APP.`appId` = C.`appId` 
                     WHERE C.`conStatus` = 3';
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryInventory 查看費用統整
         *
         * @param $rows
         * @param $comCode
         * @param $frmId
         * @param $status
         * @param $year
         *
         * @return mixed
         */
        function queryIntegrateApportion($rows, $comCode, $frmId, $status, $year)
        {
            $Conn = new ConnManager();
            $arrPar = array('comCode' => $Conn->UtilCheckNotNull($comCode) ? $comCode : NULL,
                            'frmId'   => $Conn->UtilCheckNotNullIsNumeric($frmId) ? $frmId : NULL,
                            'status'  => $Conn->UtilCheckNotNullIsNumeric($status) ? $status : NULL,
                            'year'    => $Conn->UtilCheckNotNullIsNumeric($year) ? $year : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `apportion` A
                     LEFT JOIN `contract` C ON C.`appId` = A.`appId`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     LEFT JOIN `template` T ON T.`temId` = C.`temId`
                     WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNull($comCode) ? ' AND C.`comCode` = :comCode' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($frmId) ? ' AND C.`frmId` = :frmId' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($status) ? ' AND C.`conStatus` = :status AND A.`appStatus` = :status' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($year) ? ' AND A.`appYear` = :year' : '';
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryIntegrateExes 查看分攤明細
         *
         * @param $rows
         * @param $comCode
         * @param $frmId
         * @param $status
         * @param $year
         *
         * @return mixed
         */
        function queryIntegrateExes($rows, $comCode, $frmId, $status, $year)
        {
            $Conn = new ConnManager();
            $arrPar = array('comCode' => $Conn->UtilCheckNotNull($comCode) ? $comCode : NULL,
                            'frmId'   => $Conn->UtilCheckNotNullIsNumeric($frmId) ? $frmId : NULL,
                            'status'  => $Conn->UtilCheckNotNullIsNumeric($status) ? $status : NULL,
                            'year'    => $Conn->UtilCheckNotNullIsNumeric($year) ? $year : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `exes` E
                     LEFT JOIN `item` I ON I.`iteId` = E.`iteId`
                     LEFT JOIN `distribution` D ON D.`disId` = I.`disId`
                     LEFT JOIN `manner` M ON M.`manId` = I.`manId`
                     LEFT JOIN `apportion` A ON A.`appId` = E.`appId`
                     LEFT JOIN `contract` C ON C.`appId` = A.`appId`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     LEFT JOIN `template` T ON T.`temId` = C.`temId`
                     WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNull($comCode) ? ' AND C.`comCode` = :comCode' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($frmId) ? ' AND C.`frmId` = :frmId' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($status) ? ' AND C.`conStatus` = :status AND A.`appStatus` = :status' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($year) ? ' AND A.`appYear` = :year' : '';
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryIntegrateAnnualYear 查看各年度分攤費用
         *
         * @param $exeId
         *
         * @return mixed
         */
        function queryIntegrateAnnualYear($exeId)
        {
            $Conn = new ConnManager();
            $arrPar = array('exeId' => $Conn->UtilCheckNotNullIsNumeric($exeId) ? $exeId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS `annYear` FROM `annual`
                     WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($exeId) ? ' AND `exeId` = :exeId' : '';
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryIntegrateAnnualSum 查看各年度分攤費用
         *
         * @param $exeId
         *
         * @return mixed
         */
        function queryIntegrateAnnualSum($exeId)
        {
            $Conn = new ConnManager();
            $arrPar = array('exeId' => $Conn->UtilCheckNotNullIsNumeric($exeId) ? $exeId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS SUM(`annCost`) AS `annSum`, `annYear`, `exeId` FROM `annual`
                     WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($exeId) ? ' AND `exeId` = :exeId' : '';
            $sql .= ' GROUP BY `exeId`, `annYear`';
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryIntegrateSubsidiary 查看各公司分攤費用
         *
         * @param $exeId
         * @param $year
         *
         * @return mixed
         */
        function queryIntegrateSubsidiarySum($exeId, $year)
        {
            $Conn = new ConnManager();
            $arrPar = array('exeId' => $Conn->UtilCheckNotNullIsNumeric($exeId) ? $exeId : NULL,
                            'year'  => $Conn->UtilCheckNotNullIsNumeric($year) ? $year : NULL);
            //SQL
            $sql = ' SELECT SUM(S.`subCost`) AS `subSum`, S.`comCode` FROM `subsidiary` S
                     LEFT JOIN `annual` A ON A.`annId` = S.`annId`
                     WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($exeId) ? ' AND A.`exeId` = :exeId' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($year) ? ' AND A.`annYear` = :year' : '';
            $sql .= ' GROUP BY A.`exeId`, A.`annYear`, S.`comCode`';
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }


//        /**
//         * todo:查看項目預計分攤
//         *
//         * @param $rows
//         * @param $ct_id
//         * @param $cti_id
//         *
//         * @return mixed
//         */
//        function queryItemSubsidiary($rows, $ct_id, $cti_id)
//        {
//            $Conn = new ConnManager();
//            $arrPar = array('ct_id'  => $Conn->UtilCheckNotNullIsNumeric($ct_id) ? $ct_id : NULL,
//                            'cti_id' => $Conn->UtilCheckNotNullIsNumeric($cti_id) ? $cti_id : NULL);
//            //SQL
//            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contract_item_subsidiary` CTS';
//            $sql .= ' LEFT JOIN `search_source` SS ON CTS.`SS_ID` = SS.`SS_ID`';
//            $sql .= ' LEFT JOIN `contract_item` CI ON CTS.`CTI_ID` = CI.`CTI_ID`';
//            $sql .= ' WHERE 1=1';
//            $sql .= $Conn->UtilCheckNotNullIsNumeric($ct_id) ? ' AND CI.`CT_ID` = :ct_id' : '';
//            $sql .= $Conn->UtilCheckNotNullIsNumeric($cti_id) ? ' AND CI.`CTI_ID` = :cti_id' : '';
//            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
//            $aryData['count'] = $Conn->pramGetRowCount();
//            return $aryData;
//        }
//
//        /**
//         * todo:刪除文件相關項目預計分攤
//         *
//         * @param $ct_id
//         *
//         * @return mixed
//         */
//        function deleteItemSubsidiary($ct_id)
//        {
//            $Conn = new ConnManager();
//            $arrPar = array('ct_id' => $Conn->UtilCheckNotNullIsNumeric($ct_id) ? $ct_id : '');
//            //SQL
//            $sql = ' DELETE CTIS.* FROM `contract_item_subsidiary` CTIS';
//            $sql .= ' LEFT JOIN `contract_item` CTI ON CTI.`CTI_ID` = CTIS.`CTI_ID`';
//            $sql .= ' WHERE CTI.`CT_ID` = :ct_id';
//            $aryExecute = $Conn->pramExecute($sql, $arrPar);
//            return $aryExecute;
//        }
//
//        /**
//         * todo:查看計畫實際金額
//         *
//         * @param $ct_status
//         *
//         * @return mixed
//         */
//        function queryItemReport($ct_status)
//        {
//            $Conn = new ConnManager();
//            $arrPar = array('ct_status' => $Conn->UtilCheckNotNullIsNumeric($ct_status) ? $ct_status : NULL);
//            //SQL
//            $sql = ' SELECT CT.*, MIN(CIES.`CIES_Year`) AS `Min_Year`, MAX(CIES.`CIES_Year`) AS `Max_Year`, SUM(CIE.`CIE_Cost`) AS `SUM_Cost` FROM `contract` CT';
//            $sql .= ' LEFT JOIN `contract_item` CI ON CI.`CT_ID` = CT.`CT_ID`';
//            $sql .= ' LEFT JOIN `contract_item_exes` CIE ON CI.`CTI_ID` = CIE.`CTI_ID`';
//            $sql .= ' LEFT JOIN `contract_item_exes_subsidiary` CIES ON CIES.`CIE_ID` = CIE.`CIE_ID`';
//            $sql .= ' WHERE 1=1';
//            $sql .= $Conn->UtilCheckNotNullIsNumeric($ct_status) ? ' AND CT.`CT_Status` = :ct_status' : '';
//            $sql .= ' GROUP BY CT.CT_ID';
//            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
//            $aryData['count'] = $Conn->pramGetRowCount();
//            return $aryData;
//        }
//
//        /**
//         * todo:查看分攤使用年份
//         *
//         *
//         * @return mixed
//         */
//        function queryExesYear()
//        {
//            $Conn = new ConnManager();
//            $arrPar = array();
//            //SQL
//            $sql = ' SELECT `CIES_YEAR` FROM `contract_item_exes_subsidiary` GROUP BY `CIES_Year` ORDER BY `CIES_Year`';
//            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
//            $aryData['count'] = $Conn->pramGetRowCount();
//            return $aryData;
//        }
//
//        /**
//         * todo:查看項目實際金額
//         *
//         * @param $ct_status
//         *
//         * @return mixed
//         */
//        function queryItemExesByItem($ct_status)
//        {
//            $Conn = new ConnManager();
//            $arrPar = array('ct_status' => $Conn->UtilCheckNotNullIsNumeric($ct_status) ? $ct_status : NULL);
//            //SQL
//            $sql = ' SELECT CT.`CTP_ID`, CT.`SS_ID`, CT.`CT_ID`, CI.`CTI_ID`, CT.`CT_Title`, CI.`CTI_Work`, CI.`CTI_Title`, CI.`CTI_Appo`, SUM(CIE.`CIE_Cost`) AS `Sum_Cost`  FROM `contract` CT';
//            $sql .= ' LEFT JOIN `contract_item` CI ON CI.`CT_ID` = CT.`CT_ID`';
//            $sql .= ' LEFT JOIN `contract_item_exes` CIE ON CIE.`CTI_ID` = CI.`CTI_ID`';
//            $sql .= ' WHERE 1=1';
//            $sql .= $Conn->UtilCheckNotNullIsNumeric($ct_status) ? ' AND CT.`CT_Status` = :ct_status' : '';
//            $sql .= ' GROUP BY CI.`CTI_ID`';
//            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
//            $aryData['count'] = $Conn->pramGetRowCount();
//            return $aryData;
//        }
//
//        /**
//         * todo:查看項目實際金額
//         *
//         * @param $rows
//         * @param $ct_id
//         *
//         * @return mixed
//         */
//        function queryItemExes($rows, $ct_id)
//        {
//            $Conn = new ConnManager();
//            $arrPar = array('ct_id' => $Conn->UtilCheckNotNullIsNumeric($ct_id) ? $ct_id : NULL);
//            //SQL
//            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contract_item_exes` CIE';
//            $sql .= ' LEFT JOIN `contract_item` CTI ON CTI.`CTI_ID` = CIE.`CTI_ID`';
//            $sql .= ' WHERE 1=1';
//            $sql .= $Conn->UtilCheckNotNullIsNumeric($ct_id) ? ' AND CTI.`CTI_ID` = :ct_id' : '';
//            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
//            $aryData['count'] = $Conn->pramGetRowCount();
//            return $aryData;
//        }
//
//        /**
//         * todo:刪除文件相關項目實際金額
//         *
//         * @param $ct_id
//         *
//         * @return mixed
//         */
//        function deleteItemExes($ct_id)
//        {
//            $Conn = new ConnManager();
//            $arrPar = array('ct_id' => $Conn->UtilCheckNotNullIsNumeric($ct_id) ? $ct_id : '');
//            //SQL
//            $sql = ' DELETE CIR.* FROM `contract_item_exes` CIE';
//            $sql .= ' LEFT JOIN `contract_item` CTI ON CTI.`CTI_ID` = CIE.`CTI_ID`';
//            $sql .= ' WHERE CTI.`CT_ID` = :ct_id';
//            $aryExecute = $Conn->pramExecute($sql, $arrPar);
//            return $aryExecute;
//        }
//
//        /**
//         * todo:查看項目實際金額-一公司與年份區分
//         *
//         * @param $ct_status
//         *
//         * @return mixed
//         */
//        function queryExes($ct_status)
//        {
//            $Conn = new ConnManager();
//            $arrPar = array('ct_status' => $Conn->UtilCheckNotNullIsNumeric($ct_status) ? $ct_status : NULL);
//            //SQL
//            $sql = ' SELECT CT.`CT_ID`, CI.`CTI_ID`, CIES.`SS_ID`, CIES.`CIES_Year`, SUM(CIES.`CIES_Cost`) AS `Exes_Cost`  FROM `contract_item` CI';
//            $sql .= ' LEFT JOIN `contract_item_exes` CIE ON CIE.`CTI_ID` = CI.`CTI_ID`';
//            $sql .= ' LEFT JOIN `contract_item_exes_subsidiary` CIES ON CIES.`CIE_ID` = CIE.`CIE_ID`';
//            $sql .= ' LEFT JOIN `contract` CT ON CT.`CT_ID` = CI.`CT_ID`';
//            $sql .= ' WHERE 1=1';
//            $sql .= $Conn->UtilCheckNotNullIsNumeric($ct_status) ? ' AND CT.`CT_Status` = :ct_status' : '';
//            $sql .= ' GROUP BY CIES.`CIES_Year`, CIES.`SS_ID`, CIE.`CTI_ID`';
//            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
//            $aryData['count'] = $Conn->pramGetRowCount();
//            return $aryData;
//        }
//
//
//        /**
//         * todo:新增
//         *
//         * @param $cti_id
//         * @param $ss_id
//         * @param $ratio
//         * @param $cost
//         *
//         * @return array|int|Number
//         */
//        function insertItemSubsidiary($cti_id, $ss_id, $ratio, $cost)
//        {
//            $Conn = new ConnManager();
//            $arrPar = array('cti_id' => $Conn->UtilCheckNotNullIsNumeric($cti_id) ? $cti_id : 0,
//                            'ss_id'  => $Conn->UtilCheckNotNullIsNumeric($ss_id) ? $ss_id : 0,
//                            'ratio'  => $Conn->UtilCheckNotNullIsNumeric($ratio) ? $ratio : 0,
//                            'cost'   => $Conn->UtilCheckNotNullIsNumeric($cost) ? $cost : 0);
//            //SQL
//            $sql = ' INSERT INTO `contract_item_subsidiary`(`CTI_ID`, `SS_ID`, `CTIS_Ratio`, `CTIS_Cost`)';
//            $sql .= ' VALUES(:cti_id, :ss_id, :ratio, :cost)';
//            $aryExecute = $Conn->pramExecute($sql, $arrPar);
//            if ($aryExecute) {
//                return $Conn->getLastId();
//            }
//            else {
//                return $aryExecute;
//            }
//        }
//
//        /**
//         * todo:新增
//         *
//         * @param $cti_id
//         * @param $title
//         * @param $cost
//         *
//         * @return array|int|Number
//         */
//        function insertItemExes($cti_id, $title, $cost)
//        {
//            $Conn = new ConnManager();
//            $arrPar = array('cti_id' => $Conn->UtilCheckNotNullIsNumeric($cti_id) ? $cti_id : 0,
//                            'title'  => $Conn->UtilCheckNotNullIsNumeric($title) ? $title : '',
//                            'cost'   => $Conn->UtilCheckNotNullIsNumeric($cost) ? $cost : 0);
//            //SQL
//            $sql = ' INSERT INTO `contract_item_exes`(`CTI_ID`, `CIE_Title`, `CIE_Cost`)';
//            $sql .= ' VALUES(:cti_id, :title, :cost)';
//            $aryExecute = $Conn->pramExecute($sql, $arrPar);
//            if ($aryExecute) {
//                return $Conn->getLastId();
//            }
//            else {
//                return $aryExecute;
//            }
//        }
//
//        /**
//         * todo:查看項目費用分攤
//         *
//         * @param $rows
//         * @param $ct_id
//         * @param $cti_id
//         * @param $cie_id
//         *
//         * @return mixed
//         */
//        function queryItemExesSubsidiary($rows, $ct_id, $cti_id, $cie_id)
//        {
//            $Conn = new ConnManager();
//            $arrPar = array('ct_id'  => $Conn->UtilCheckNotNullIsNumeric($ct_id) ? $ct_id : NULL,
//                            'cti_id' => $Conn->UtilCheckNotNullIsNumeric($cti_id) ? $cti_id : NULL,
//                            'cie_id' => $Conn->UtilCheckNotNullIsNumeric($cie_id) ? $cie_id : NULL);
//            //SQL
//            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contract_item_exes_subsidiary` CIES';
//            $sql .= ' LEFT JOIN `contract_item_exes` CIE ON CIE.`CIE_ID` = CIES.`CIE_ID`';
//            $sql .= ' LEFT JOIN `contract_item` CI ON CIE.`CTI_ID` = CI.`CTI_ID`';
//            $sql .= ' WHERE 1=1';
//            $sql .= $Conn->UtilCheckNotNullIsNumeric($ct_id) ? ' AND CI.`CT_ID` = :ct_id' : '';
//            $sql .= $Conn->UtilCheckNotNullIsNumeric($cti_id) ? ' AND CI.`CTI_ID` = :cti_id' : '';
//            $sql .= $Conn->UtilCheckNotNullIsNumeric($cie_id) ? ' AND CIE.`CIE_ID` = :cie_id' : '';
//            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
//            $aryData['count'] = $Conn->pramGetRowCount();
//            return $aryData;
//        }
//
//        /**
//         * todo:新增
//         *
//         * @param $cie_id
//         * @param $ss_id
//         * @param $ratio
//         * @param $cost
//         * @param $year
//         *
//         * @return array|int|Number
//         */
//        function insertItemExesSubsidiary($cie_id, $ss_id, $ratio, $cost, $year)
//        {
//            $Conn = new ConnManager();
//            $arrPar = array('cie_id' => $Conn->UtilCheckNotNullIsNumeric($cie_id) ? $cie_id : 0,
//                            'ss_id'  => $Conn->UtilCheckNotNullIsNumeric($ss_id) ? $ss_id : 0,
//                            'ratio'  => $Conn->UtilCheckNotNullIsNumeric($ratio) ? $ratio : 0,
//                            'cost'   => $Conn->UtilCheckNotNullIsNumeric($cost) ? $cost : 0,
//                            'year'   => $Conn->UtilCheckNotNullIsNumeric($year) ? $year : 0);
//            //SQL
//            $sql = ' INSERT INTO `contract_item_exes_subsidiary`(`CIE_ID`, `SS_ID`, `CIES_Ratio`, `CIES_Cost`, `CIES_Year`)';
//            $sql .= ' VALUES(:cie_id, :ss_id, :ratio, :cost, :year)';
//            $aryExecute = $Conn->pramExecute($sql, $arrPar);
//            if ($aryExecute) {
//                return $Conn->getLastId();
//            }
//            else {
//                return $aryExecute;
//            }
//        }
//
//        /**
//         * todo:刪除文件相關
//         *
//         * @param $ct_id
//         *
//         * @return array|int|Number
//         */
//        function deleteItemExesSubsidiary($ct_id)
//        {
//            $Conn = new ConnManager();
//            $arrPar = array('ct_id' => $Conn->UtilCheckNotNullIsNumeric($ct_id) ? $ct_id : '');
//            //SQL
//            $sql = ' DELETE CIES.* FROM `contract_item_exes_subsidiary` CIES';
//            $sql .= ' LEFT JOIN `contract_item_exes` CIE ON CIE.`CIE_ID` = CIES.`CIE_ID`';
//            $sql .= ' LEFT JOIN `contract_item` CTI ON CTI.`CTI_ID` = CIE.`CTI_ID`';
//            $sql .= ' WHERE CTI.`CT_ID` = :ct_id';
//            $aryExecute = $Conn->pramExecute($sql, $arrPar);
//            return $aryExecute;
//        }


    }

?>
