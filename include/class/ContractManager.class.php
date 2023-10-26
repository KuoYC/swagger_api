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
         * @param $temStyle
         *
         * @return array|int|Number
         */
        function insertTemplate($temTitle, $temStyle)
        {
            $Conn = new ConnManager();
            $arrPar = array('temTitle' => $Conn->UtilCheckNotNull($temTitle) ? $temTitle : '',
                            'temStyle' => $Conn->UtilCheckNotNull($temStyle) ? $temStyle : '');
            //SQL
            $sql = ' INSERT INTO `template`(`temTitle`, `temStyle`)
                     VALUES(:temTitle, :temStyle)';
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
         * @param $temStyle
         * @param $temId
         *
         * @return array|int
         */
        function updateTemplateByID($temId, $temTitle, $temStyle)
        {
            $Conn = new ConnManager();
            $arrPar = array('temId'    => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : '',
                            'temTitle' => $Conn->UtilCheckNotNull($temTitle) ? $temTitle : '',
                            'temStyle' => $Conn->UtilCheckNotNull($temStyle) ? $temStyle : '');
            //SQL
            $sql = ' UPDATE `template`
                     SET `temTitle` = :temTitle, `temStyle` = :temStyle
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
         *
         * @return array|int
         */
        function updateMannerByID($manId, $manTitle, $manType)
        {
            $Conn = new ConnManager();
            $arrPar = array('manId'    => $Conn->UtilCheckNotNullIsNumeric($manId) ? $manId : 0,
                            'manTitle' => $Conn->UtilCheckNotNull($manTitle) ? $manType : '',
                            'manType'  => $Conn->UtilCheckNotNullIsNumeric($manType) ? $manType : 0);
            //SQL
            $sql = ' UPDATE `manner`
                     SET `manTitle` = :manTitle, `manType` = :manType
                     WHERE `manId` = :manId';
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
         * todo:queryRatio 查看公司分攤比例
         *
         * @param $rows
         * @param $disId
         * @param $comId
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryRatio($rows, $disId, $comId, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('disId' => $Conn->UtilCheckNotNullIsNumeric($disId) ? $disId : NULL,
                            'comId' => $Conn->UtilCheckNotNullIsNumeric($comId) ? $comId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `ratio` R
                     LEFT JOIN `distribution` D ON D.`disId` = R.`disId`
                     LEFT JOIN `company` C ON C.`comId` = R.`comId`
                     WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($disId) ? ' AND R.`disId` = :disId' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($comId) ? ' AND R.`comId` = :comId' : '';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryRatioByID 查看單一公司分攤比例
         *
         * @param $rows
         * @param $ratId
         *
         * @return mixed
         */
        function queryRatioByID($rows, $ratId)
        {
            $Conn = new ConnManager();
            $arrPar = array('ratId' => $Conn->UtilCheckNotNullIsNumeric($ratId) ? $ratId : '');
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `ratio` R
                     LEFT JOIN `distribution` D ON D.`disId` = R.`disId`
                     LEFT JOIN `company` C ON C.`comId` = R.`comId`
                     WHERE R.`ratId` = :ratId';
            $aryData['data'] = $Conn->pramGetOne($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:insertRatio 新增公司分攤比例
         *
         * @param $disId
         * @param $comId
         * @param $ratRatio
         *
         * @return array|int|Number
         */
        function insertRatio($disId, $comId, $ratRatio)
        {
            $Conn = new ConnManager();
            $arrPar = array('disId'    => $Conn->UtilCheckNotNullIsNumeric($disId) ? $disId : 0,
                            'comId'    => $Conn->UtilCheckNotNullIsNumeric($comId) ? $comId : 0,
                            'ratRatio' => $Conn->UtilCheckNotNullIsNumeric($ratRatio) ? $ratRatio : 0);
            //SQL
            $sql = ' INSERT INTO `ratio`(`disId`, `comId`, `ratRatio`)
                     SELECT :disId, :comId, :ratRatio FROM DUAL 
                     WHERE NOT EXISTS (SELECT `disId`, `comId` FROM `ratio` WHERE `disId` = :disId AND `comId` = :comId)';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            if ($aryExecute) {
                return $Conn->getLastId();
            }
            else {
                return $aryExecute;
            }
        }

        /**
         * todo:updateRatioByID 修改公司分攤比例
         *
         * @param $ratRatio
         * @param $ratId
         *
         * @return array|int
         */
        function updateRatioByID($ratId, $ratRatio)
        {
            $Conn = new ConnManager();
            $arrPar = array('ratId'    => $Conn->UtilCheckNotNullIsNumeric($ratId) ? $ratId : 0,
                            'ratRatio' => $Conn->UtilCheckNotNullIsNumeric($ratRatio) ? $ratRatio : 0);
            //SQL
            $sql = ' UPDATE `ratio`
                     SET `ratRatio` = :ratRatio
                     WHERE `ratId` = :ratId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteRatioByID 刪除公司分攤比例
         *
         * @param int $ratId 編號
         *
         * @return int|boolean
         */
        function deleteRatioByID($ratId)
        {
            $Conn = new ConnManager();
            $arrPar = array('ratId' => $Conn->UtilCheckNotNullIsNumeric($ratId) ? $ratId : '');
            //SQL
            $sql = ' DELETE FROM `ratio`
                     WHERE `ratId` = :ratId';
            $aryExecute = $Conn->pramExecute($sql, $arrPar);
            return $aryExecute;
        }

        /**
         * todo:deleteRatioByDistribution 刪除分攤方式相關公司分攤比例
         *
         * @param int $disId 編號
         *
         * @return int|boolean
         */
        function deleteRatioByDistribution($disId)
        {
            $Conn = new ConnManager();
            $arrPar = array('disId' => $Conn->UtilCheckNotNullIsNumeric($disId) ? $disId : '');
            //SQL
            $sql = ' DELETE FROM `ratio`
                     WHERE `disId` = :disId';
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
            $arrPar = array('comCode' => $Conn->UtilCheckNotNullIsNumeric($comCode) ? $comCode : 0,
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
                            'comCode' => $Conn->UtilCheckNotNullIsNumeric($comCode) ? $comCode : 0,
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
         * @param $temId
         * @param $comId
         * @param $comCode
         * @param $conSerial
         * @param $conStatus
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryContract($rows, $temId, $comId, $comCode, $conSerial, $conStatus, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('conSerial' => $Conn->UtilCheckNotNull($conSerial) ? $conSerial : NULL,
                            'comId'     => $Conn->UtilCheckNotNullIsNumeric($comId) ? $comId : NULL,
                            'comCode'   => $Conn->UtilCheckNotNull($comCode) ? $comCode : NULL,
                            'conStatus' => $Conn->UtilCheckNotNullIsNumeric($conStatus) ? $conStatus : NULL,
                            'temId'     => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contract` C
                     LEFT JOIN `template` T ON T.`temId` = C.`temId`
                     LEFT JOIN `company` CM ON CM.`comCode` = C.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     WHERE 1 = 1';
            $sql .= $Conn->UtilCheckNotNull($conSerial) ? ' AND C.`conSerial` = :conSerial' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($comId) ? ' AND CM.`comId` = :comId' : '';
            $sql .= $Conn->UtilCheckNotNull($comCode) ? ' AND C.`comCode` = :comCode' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conStatus) ? ' AND C.`conStatus` = :conStatus' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($temId) ? ' AND C.`temId` = :temId' : '';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryContractForAction0 查看文件-相關(發起, 待簽, 已簽)
         *
         * @param $rows
         * @param $temId
         * @param $comId
         * @param $comCode
         * @param $conSerial
         * @param $conStatus
         * @param $perKey
         * @param $perBu1Code
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryContractForAction0($rows, $temId, $comId, $comCode, $conSerial, $conStatus, $perKey, $perBu1Code, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('conSerial'  => $Conn->UtilCheckNotNull($conSerial) ? $conSerial : NULL,
                            'comId'      => $Conn->UtilCheckNotNullIsNumeric($comId) ? $comId : NULL,
                            'comCode'    => $Conn->UtilCheckNotNull($comCode) ? $comCode : NULL,
                            'conStatus'  => $Conn->UtilCheckNotNullIsNumeric($conStatus) ? $conStatus : NULL,
                            'perKey'     => $Conn->UtilCheckNotNull($perKey) ? $perKey : '',
                            'perBu1Code' => $Conn->UtilCheckNotNull($perBu1Code) ? $perBu1Code : '',
                            'temId'      => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contract` C
                     LEFT JOIN `template` T ON T.`temId` = C.`temId`
                     LEFT JOIN `company` CM ON CM.`comCode` = C.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     LEFT JOIN (
                                SELECT `conId`, COUNT(*) AS `CT` FROM `member` M
                                LEFT JOIN `company` CP ON CP.`comCode` = M.`memBu1Code`
                                LEFT JOIN `contact` CT ON CP.`comCode` = CT.`comCode` AND CT.`perKey` = :perKey
                                WHERE M.`memBu1Code` = :perBu1Code 
                                AND (
                                        (M.`memLV0Key` = :perKey AND M.`memLV0Status` != -1) OR
                                        (M.`memLVCStatus` != -1 AND M.`memType` = 0) OR
                                        (M.`memLV1Key` = :perKey AND M.`memLV1Status` != -1) OR
                                        (M.`memLV2Key` = :perKey AND M.`memLV2Status` != -1)
                                    )
                                GROUP BY M.`conId`
                                ) M ON M.`conId` = C.`conId`
                     WHERE 1 = 1';
            $sql .= $Conn->UtilCheckNotNull($conSerial) ? ' AND C.`conSerial` = :conSerial' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($comId) ? ' AND CM.`comId` = :comId' : '';
            $sql .= $Conn->UtilCheckNotNull($comCode) ? ' AND C.`comCode` = :comCode' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conStatus) ? ' AND C.`conStatus` = :conStatus' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($temId) ? ' AND C.`temId` = :temId' : '';
            $sql .= ' AND ((M.`CT` > 0 AND C.`conStatus` IN (0, 1)) OR (CM.`comCode` = :perBu1Code AND C.`perKey` = :perKey AND C.`conStatus` IN (0, 2)))';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryContractForAction1 查看文件-待檢視
         *
         * @param $rows
         * @param $temId
         * @param $comId
         * @param $comCode
         * @param $conSerial
         * @param $perKey
         * @param $perBu1Code
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryContractForAction1($rows, $temId, $comId, $comCode, $conSerial, $perKey, $perBu1Code, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('conSerial'  => $Conn->UtilCheckNotNull($conSerial) ? $conSerial : NULL,
                            'comId'      => $Conn->UtilCheckNotNullIsNumeric($comId) ? $comId : NULL,
                            'comCode'    => $Conn->UtilCheckNotNull($comCode) ? $comCode : NULL,
                            'perKey'     => $Conn->UtilCheckNotNull($perKey) ? $perKey : '',
                            'perBu1Code' => $Conn->UtilCheckNotNull($perBu1Code) ? $perBu1Code : '',
                            'temId'      => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contract` C
                     LEFT JOIN `template` T ON T.`temId` = C.`temId`
                     LEFT JOIN `company` CM ON CM.`comCode` = C.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     LEFT JOIN (
                                SELECT M.`conId`, COUNT(*) AS `CT` FROM `member` M 
                                LEFT JOIN `company` CP ON CP.`comCode` = M.`memBu1Code`
                                LEFT JOIN `contact` CT ON CP.`comCode` = CT.`comCode` AND CT.`perKey` = :perKey
                                WHERE M.`memBu1Code` = :perBu1Code 
                                AND (
                                        (`memNowKey` = :perKey AND `memNowStatus` = 0) OR
                                        (M.`memLVCStatus` != -1 AND M.`memType` = 0 AND CT.`perKey` = :perKey)
                                    )
                                GROUP BY M.`conId`
                                ) M ON M.`conId` = C.`conId`
                     WHERE 1 = 1';
            $sql .= $Conn->UtilCheckNotNull($conSerial) ? ' AND C.`conSerial` = :conSerial' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($comId) ? ' AND CM.`comId` = :comId' : '';
            $sql .= $Conn->UtilCheckNotNull($comCode) ? ' AND C.`comCode` = :comCode' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($temId) ? ' AND C.`temId` = :temId' : '';
            $sql .= ' AND M.`CT` > 0';
            $sql .= ' AND C.`conStatus` = 1';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryContractForAction2 查看文件-待簽
         *
         * @param $rows
         * @param $temId
         * @param $comId
         * @param $comCode
         * @param $conSerial
         * @param $perKey
         * @param $perBu1Code
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryContractForAction2($rows, $temId, $comId, $comCode, $conSerial, $perKey, $perBu1Code, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('conSerial'  => $Conn->UtilCheckNotNull($conSerial) ? $conSerial : NULL,
                            'comId'      => $Conn->UtilCheckNotNullIsNumeric($comId) ? $comId : NULL,
                            'comCode'    => $Conn->UtilCheckNotNull($comCode) ? $comCode : NULL,
                            'perKey'     => $Conn->UtilCheckNotNull($perKey) ? $perKey : '',
                            'perBu1Code' => $Conn->UtilCheckNotNull($perBu1Code) ? $perBu1Code : '',
                            'temId'      => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contract` C
                     LEFT JOIN `template` T ON T.`temId` = C.`temId`
                     LEFT JOIN `company` CM ON CM.`comCode` = C.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     LEFT JOIN (
                                SELECT M.`conId`, COUNT(*) AS `CT` FROM `member` M 
                                LEFT JOIN `company` CP ON CP.`comCode` = M.`memBu1Code`
                                LEFT JOIN `contact` CT ON CP.`comCode` = CT.`comCode` AND CT.`perKey` = :perKey
                                WHERE M.`memBu1Code` = :perBu1Code 
                                AND (
                                        (`memNowKey` = :perKey AND `memNowStatus` = 0) OR
                                        (M.`memLVCStatus` != -1 AND M.`memLVCStatus` != 3 AND M.`memType` = 0 AND CT.`perKey` = :perKey)
                                    )
                                GROUP BY M.`conId`
                                ) M ON M.`conId` = C.`conId`
                     WHERE 1 = 1';
            $sql .= $Conn->UtilCheckNotNull($conSerial) ? ' AND C.`conSerial` = :conSerial' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($comId) ? ' AND CM.`comId` = :comId' : '';
            $sql .= $Conn->UtilCheckNotNull($comCode) ? ' AND C.`comCode` = :comCode' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($temId) ? ' AND C.`temId` = :temId' : '';
            $sql .= ' AND M.`CT` > 0';
            $sql .= ' AND C.`conStatus` = 1';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryContractForAction3 查看文件-等待
         *
         * @param $rows
         * @param $temId
         * @param $comId
         * @param $comCode
         * @param $conSerial
         * @param $perKey
         * @param $perBu1Code
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryContractForAction3($rows, $temId, $comId, $comCode, $conSerial, $perKey, $perBu1Code, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('conSerial'  => $Conn->UtilCheckNotNull($conSerial) ? $conSerial : NULL,
                            'comId'      => $Conn->UtilCheckNotNullIsNumeric($comId) ? $comId : NULL,
                            'comCode'    => $Conn->UtilCheckNotNull($comCode) ? $comCode : NULL,
                            'perKey'     => $Conn->UtilCheckNotNull($perKey) ? $perKey : '',
                            'perBu1Code' => $Conn->UtilCheckNotNull($perBu1Code) ? $perBu1Code : '',
                            'temId'      => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contract` C
                     LEFT JOIN `template` T ON T.`temId` = C.`temId`
                     LEFT JOIN `company` CM ON CM.`comCode` = C.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     LEFT JOIN (
                                SELECT M.`conId`, COUNT(*) AS `CT` FROM `member` M 
                                LEFT JOIN `company` CP ON CP.`comCode` = M.`memBu1Code`
                                LEFT JOIN `contact` CT ON CP.`comCode` = CT.`comCode` AND CT.`perKey` = :perKey
                                WHERE M.`memBu1Code` = :perBu1Code 
                                AND (
                                        (`memNowKey` = :perKey AND (`memNowStatus` IN (0, 1))) OR
                                        (M.`memLVCStatus` != -1 AND M.`memLVCStatus` != 3 AND M.`memType` = 0 AND CT.`perKey` = :perKey)
                                    )
                                GROUP BY M.`conId`
                                ) M ON M.`conId` = C.`conId`
                     WHERE 1 = 1';
            $sql .= $Conn->UtilCheckNotNull($conSerial) ? ' AND C.`conSerial` = :conSerial' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($comId) ? ' AND CM.`comId` = :comId' : '';
            $sql .= $Conn->UtilCheckNotNull($comCode) ? ' AND C.`comCode` = :comCode' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($temId) ? ' AND C.`temId` = :temId' : '';
            $sql .= ' AND M.`CT` > 0';
            $sql .= ' AND C.`conStatus` = 1';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryContractForAction4 查看文件-已簽
         *
         * @param $rows
         * @param $temId
         * @param $comId
         * @param $comCode
         * @param $conSerial
         * @param $perKey
         * @param $perBu1Code
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryContractForAction4($rows, $temId, $comId, $comCode, $conSerial, $perKey, $perBu1Code, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('conSerial'  => $Conn->UtilCheckNotNull($conSerial) ? $conSerial : NULL,
                            'comId'      => $Conn->UtilCheckNotNullIsNumeric($comId) ? $comId : NULL,
                            'comCode'    => $Conn->UtilCheckNotNull($comCode) ? $comCode : NULL,
                            'perKey'     => $Conn->UtilCheckNotNull($perKey) ? $perKey : '',
                            'perBu1Code' => $Conn->UtilCheckNotNull($perBu1Code) ? $perBu1Code : '',
                            'temId'      => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contract` C
                     LEFT JOIN `template` T ON T.`temId` = C.`temId`
                     LEFT JOIN `company` CM ON CM.`comCode` = C.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     LEFT JOIN (
                                SELECT `conId`, COUNT(*) AS `CT` FROM `member` 
                                WHERE `memBu1Code` = :perBu1Code 
                                AND (
                                        (`memLV0Key` = :perKey AND `memLV0Status` = 3) OR
                                        (`memLVCKey` = :perKey AND `memLVCStatus` = 3) OR
                                        (`memLV1Key` = :perKey AND `memLV1Status` = 3) OR
                                        (`memLV2Key` = :perKey AND `memLV2Status` = 3)
                                    )
                                GROUP BY `conId`
                                ) M ON M.`conId` = C.`conId`
                     WHERE 1 = 1';
            $sql .= $Conn->UtilCheckNotNull($conSerial) ? ' AND C.`conSerial` = :conSerial' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($comId) ? ' AND CM.`comId` = :comId' : '';
            $sql .= $Conn->UtilCheckNotNull($comCode) ? ' AND C.`comCode` = :comCode' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($temId) ? ' AND C.`temId` = :temId' : '';
            $sql .= ' AND M.`CT` > 0';
            $sql .= ' AND C.`conStatus` = 1';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryContractForAction5 查看文件-全部相關
         *
         * @param $rows
         * @param $temId
         * @param $comId
         * @param $comCode
         * @param $conSerial
         * @param $conStatus
         * @param $perKey
         * @param $perBu1Code
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryContractForAction5($rows, $temId, $comId, $comCode, $conSerial, $conStatus, $perKey, $perBu1Code, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('conSerial'  => $Conn->UtilCheckNotNull($conSerial) ? $conSerial : NULL,
                            'comId'      => $Conn->UtilCheckNotNullIsNumeric($comId) ? $comId : NULL,
                            'comCode'    => $Conn->UtilCheckNotNull($comCode) ? $comCode : NULL,
                            'conStatus'  => $Conn->UtilCheckNotNullIsNumeric($conStatus) ? $conStatus : NULL,
                            'perKey'     => $Conn->UtilCheckNotNull($perKey) ? $perKey : '',
                            'perBu1Code' => $Conn->UtilCheckNotNull($perBu1Code) ? $perBu1Code : '',
                            'temId'      => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contract` C
                     LEFT JOIN `template` T ON T.`temId` = C.`temId`
                     LEFT JOIN `company` CM ON CM.`comCode` = C.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     LEFT JOIN (
                                SELECT `conId`, COUNT(*) AS `CT` FROM `member` 
                                WHERE `memBu1Code` = :perBu1Code 
                                AND (
                                        `memLV0Key` = :perKey OR
                                        `memLVCKey` = :perKey OR
                                        `memLV1Key` = :perKey OR
                                        `memLV2Key` = :perKey 
                                    )
                                GROUP BY `conId`
                                ) M ON M.`conId` = C.`conId`
                     WHERE 1 = 1';
            $sql .= $Conn->UtilCheckNotNull($conSerial) ? ' AND C.`conSerial` = :conSerial' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($comId) ? ' AND CM.`comId` = :comId' : '';
            $sql .= $Conn->UtilCheckNotNull($comCode) ? ' AND C.`comCode` = :comCode' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conStatus) ? ' AND C.`conStatus` = :conStatus' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($temId) ? ' AND C.`temId` = :temId' : '';
            $sql .= ' AND (M.`CT` > 0 OR (CM.`comCode` = :perBu1Code AND C.`perKey` = :perKey))';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryContractForAction6 查看文件-完成
         *
         * @param $rows
         * @param $temId
         * @param $comId
         * @param $comCode
         * @param $conSerial
         * @param $perKey
         * @param $perBu1Code
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryContractForAction6($rows, $temId, $comId, $comCode, $conSerial, $perKey, $perBu1Code, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('conSerial'  => $Conn->UtilCheckNotNull($conSerial) ? $conSerial : NULL,
                            'comId'      => $Conn->UtilCheckNotNullIsNumeric($comId) ? $comId : NULL,
                            'comCode'    => $Conn->UtilCheckNotNull($comCode) ? $comCode : NULL,
                            'perKey'     => $Conn->UtilCheckNotNull($perKey) ? $perKey : '',
                            'perBu1Code' => $Conn->UtilCheckNotNull($perBu1Code) ? $perBu1Code : '',
                            'temId'      => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contract` C
                     LEFT JOIN `template` T ON T.`temId` = C.`temId`
                     LEFT JOIN `company` CM ON CM.`comCode` = C.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     LEFT JOIN (
                                SELECT `conId`, COUNT(*) AS `CT` FROM `member` 
                                WHERE `memBu1Code` = :perBu1Code 
                                AND (
                                        `memLV0Key` = :perKey OR
                                        `memLVCKey` = :perKey OR
                                        `memLV1Key` = :perKey OR
                                        `memLV2Key` = :perKey
                                    )
                                GROUP BY `conId`
                                ) M ON M.`conId` = C.`conId`
                     WHERE 1 = 1';
            $sql .= $Conn->UtilCheckNotNull($conSerial) ? ' AND C.`conSerial` = :conSerial' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($comId) ? ' AND CM.`comId` = :comId' : '';
            $sql .= $Conn->UtilCheckNotNull($comCode) ? ' AND C.`comCode` = :comCode' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($temId) ? ' AND C.`temId` = :temId' : '';
            $sql .= ' AND M.`CT` > 0';
            $sql .= ' AND C.`conStatus` IN (3, 5)';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryContractForAction7 查看文件-拒絕
         *
         * @param $rows
         * @param $temId
         * @param $comId
         * @param $comCode
         * @param $conSerial
         * @param $perKey
         * @param $perBu1Code
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryContractForAction7($rows, $temId, $comId, $comCode, $conSerial, $perKey, $perBu1Code, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('conSerial'  => $Conn->UtilCheckNotNull($conSerial) ? $conSerial : NULL,
                            'comId'      => $Conn->UtilCheckNotNullIsNumeric($comId) ? $comId : NULL,
                            'comCode'    => $Conn->UtilCheckNotNull($comCode) ? $comCode : NULL,
                            'perKey'     => $Conn->UtilCheckNotNull($perKey) ? $perKey : '',
                            'perBu1Code' => $Conn->UtilCheckNotNull($perBu1Code) ? $perBu1Code : '',
                            'temId'      => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contract` C
                     LEFT JOIN `template` T ON T.`temId` = C.`temId`
                     LEFT JOIN `company` CM ON CM.`comCode` = C.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     LEFT JOIN (
                                SELECT `conId`, COUNT(*) AS `CT` FROM `member` 
                                WHERE `memBu1Code` = :perBu1Code 
                                AND (
                                        `memLV0Key` = :perKey OR
                                        `memLVCKey` = :perKey OR
                                        `memLV1Key` = :perKey OR
                                        `memLV2Key` = :perKey
                                    )
                                GROUP BY `conId`
                                ) M ON M.`conId` = C.`conId`
                     WHERE 1 = 1';
            $sql .= $Conn->UtilCheckNotNull($conSerial) ? ' AND C.`conSerial` = :conSerial' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($comId) ? ' AND CM.`comId` = :comId' : '';
            $sql .= $Conn->UtilCheckNotNull($comCode) ? ' AND C.`comCode` = :comCode' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($temId) ? ' AND C.`temId` = :temId' : '';
            $sql .= ' AND M.`CT` > 0';
            $sql .= ' AND C.`conStatus` = 4';
            $sql .= $Conn->getLimit($anum, $num);
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:queryContractForAction8 查看文件-完成或拒絕
         *
         * @param $rows
         * @param $temId
         * @param $comId
         * @param $comCode
         * @param $conSerial
         * @param $perKey
         * @param $perBu1Code
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryContractForAction8($rows, $temId, $comId, $comCode, $conSerial, $perKey, $perBu1Code, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('conSerial'  => $Conn->UtilCheckNotNull($conSerial) ? $conSerial : NULL,
                            'comId'      => $Conn->UtilCheckNotNullIsNumeric($comId) ? $comId : NULL,
                            'comCode'    => $Conn->UtilCheckNotNull($comCode) ? $comCode : NULL,
                            'perKey'     => $Conn->UtilCheckNotNull($perKey) ? $perKey : '',
                            'perBu1Code' => $Conn->UtilCheckNotNull($perBu1Code) ? $perBu1Code : '',
                            'temId'      => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contract` C
                     LEFT JOIN `template` T ON T.`temId` = C.`temId`
                     LEFT JOIN `company` CM ON CM.`comCode` = C.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     LEFT JOIN (
                                SELECT `conId`, COUNT(*) AS `CT` FROM `member` 
                                WHERE `memBu1Code` = :perBu1Code 
                                AND (
                                        `memLV0Key` = :perKey OR
                                        `memLVCKey` = :perKey OR
                                        `memLV1Key` = :perKey OR
                                        `memLV2Key` = :perKey
                                    )
                                GROUP BY `conId`
                                ) M ON M.`conId` = C.`conId`
                     WHERE 1 = 1';
            $sql .= $Conn->UtilCheckNotNull($conSerial) ? ' AND C.`conSerial` = :conSerial' : '';
            $sql .= $Conn->UtilCheckNotNull($comId) ? ' AND CM.`comId` = :comId' : '';
            $sql .= $Conn->UtilCheckNotNull($comCode) ? ' AND C.`comCode` = :comCode' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($temId) ? ' AND C.`temId` = :temId' : '';
            $sql .= ' AND M.`CT` > 0';
            $sql .= ' AND C.`conStatus` IN (3, 4, 5)';
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
            $arrPar = array('conId' => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : '');
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contract` C
                     LEFT JOIN `template` T ON T.`temId` = C.`temId`
                     LEFT JOIN `company` CM ON CM.`comCode` = C.`comCode`
                     LEFT JOIN `personnel` P ON P.`perKey` = C.`perKey`
                     WHERE C.`conId` = :conId';
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
         * @param $conSerial
         * @param $conTitle
         * @param $conType
         * @param $conDate
         * @param $conWork
         * @param $conCompany
         * @param $conFileMeeting
         * @param $conFilePlan
         * @param $conFile
         * @param $conValue
         * @param $conLog
         * @param $conStatus
         *
         * @return array|int|Number
         */
        function insertContract($temId, $perKey, $comCode, $conSerial, $conTitle, $conType, $conDate, $conWork, $conCompany, $conFileMeeting, $conFilePlan, $conFile, $conValue, $conLog, $conStatus)
        {
            $Conn = new ConnManager();
            $arrPar = array('temId'          => $Conn->UtilCheckNotNullIsNumeric($temId) ? $temId : 0,
                            'perKey'         => $Conn->UtilCheckNotNull($perKey) ? $perKey : '',
                            'comCode'        => $Conn->UtilCheckNotNull($comCode) ? $comCode : 0,
                            'conSerial'      => $Conn->UtilCheckNotNull($conSerial) ? $conSerial : '',
                            'conTitle'       => $Conn->UtilCheckNotNull($conTitle) ? $conTitle : '',
                            'conType'        => $Conn->UtilCheckNotNullIsNumeric($conType) ? $conType : 0,
                            'conDate'        => $Conn->UtilCheckNotNullIsDate($conDate) ? $conDate : NULL,
                            'conWork'        => $Conn->UtilCheckNotNull($conWork) ? $conWork : '',
                            'conCompany'     => $Conn->UtilCheckNotNull($conCompany) ? $conCompany : '',
                            'conFileMeeting' => $Conn->UtilCheckNotNull($conFileMeeting) ? $conFileMeeting : '',
                            'conFilePlan'    => $Conn->UtilCheckNotNull($conFilePlan) ? $conFilePlan : '',
                            'conFile'        => $Conn->UtilCheckNotNull($conFile) ? $conFile : '',
                            'conValue'       => $Conn->UtilCheckNotNull($conValue) ? $conValue : '',
                            'conLog'         => $Conn->UtilCheckNotNull($conLog) ? $conLog : '',
                            'conStatus'      => $Conn->UtilCheckNotNullIsNumeric($conStatus) ? $conStatus : 0);
            //SQL
            $sql = ' INSERT INTO `contract`(`temId`, `perKey`, `comCode`, `conSerial`, `conTitle`, `conType`, `conDate`, `conWork`, `conCompany`, `conFileMeeting`, `conFilePlan`, `conFile`, `conValue`, `conLog`, `conStatus`, `conUpdateTime`, `conCreateTime`)
                     VALUES(:temId, :perKey, :comCode, :conSerial, :conTitle, :conType, '.($Conn->UtilCheckNotNullIsDate($conDate) ? ':conDate' : 'NULL').', :conWork, :conCompany, :conFileMeeting, :conFilePlan, :conFile, :conValue, :conLog, :conStatus, NOW(), NOW())';
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
         * @param $conLogMsg
         * @param $conId
         *
         * @return array|int
         */
        function updateContractLogByID($conId, $conLogMsg)
        {
            if (is_numeric($conId) && !empty($conLogMsg)) {
                $contract_sl = $this->queryContractByID(array('C.`conLog`'), $conId);
                if (0 < $contract_sl['count']) {
                    $conLogArr[] = array('msg'  => $conLogMsg,
                                         'time' => date('Y-m-d H:i:s')
                    );
                    if ('' != $contract_sl['data']['conLog']) {
                        $conLog = json_decode(htmlspecialchars_decode($contract_sl['data']['conLog']), TRUE);
                        $conLogNew = array_merge($conLogArr, $conLog);
                    }
                    else {
                        $conLogNew = $conLogArr;
                    }
                    $Conn = new ConnManager();
                    $arrPar = array('conId'  => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : '',
                                    'conLog' => htmlspecialchars(json_encode($conLogNew, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK)));
                    //SQL
                    $sql = ' UPDATE `contract`
                             SET `conLog` = :conLog
                             WHERE `conId` = :conId';
                    $aryExecute = $Conn->pramExecute($sql, $arrPar);
                    return $aryExecute;
                }
                else {
                    return FALSE;
                }
            }
            else {
                return FALSE;
            }
        }

        /**
         * todo:updateContractByID 修改文件
         *
         * @param $conTitle
         * @param $conType
         * @param $conDate
         * @param $conWork
         * @param $conCompany
         * @param $conFileMeeting
         * @param $conFilePlan
         * @param $conFile
         * @param $conValue
         * @param $conId
         *
         * @return array|int
         */
        function updateContractByID($conId, $conTitle, $conType, $conDate, $conWork, $conCompany, $conFileMeeting, $conFilePlan, $conFile, $conValue)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'          => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : '',
                            'conTitle'       => $Conn->UtilCheckNotNull($conTitle) ? $conTitle : '',
                            'conType'        => $Conn->UtilCheckNotNullIsNumeric($conType) ? $conType : 0,
                            'conDate'        => $Conn->UtilCheckNotNullIsDate($conDate) ? $conDate : NULL,
                            'conWork'        => $Conn->UtilCheckNotNull($conWork) ? $conWork : '',
                            'conCompany'     => $Conn->UtilCheckNotNull($conCompany) ? $conCompany : '',
                            'conFileMeeting' => $Conn->UtilCheckNotNull($conFileMeeting) ? $conFileMeeting : '',
                            'conFilePlan'    => $Conn->UtilCheckNotNull($conFilePlan) ? $conFilePlan : '',
                            'conFile'        => $Conn->UtilCheckNotNull($conFile) ? $conFile : '',
                            'conValue'       => $Conn->UtilCheckNotNull($conValue) ? $conValue : '');
            //SQL
            $sql = ' UPDATE `contract`
                     SET `conTitle` = :conTitle, `conType` = :conType, `conDate` = '.($Conn->UtilCheckNotNullIsDate($conDate) ? ':conDate' : 'NULL').', `conWork` = :conWork, `conCompany` = :conCompany, `conFileMeeting` = :conFileMeeting, `conFilePlan` = :conFilePlan, `conFile` = :conFile, `conValue` = :conValue, `conUpdateTime` = NOW()
                     WHERE `conId` = :conId';
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
         * todo:addContractLogByID 修改文件Log
         *
         * @param $msg
         * @param $conId
         *
         * @return boolean|int
         */
        function addContractLogByID($conId, $msg)
        {
            $Conn = new ConnManager();
            $contract_sl = $this->queryContractByID('', $conId);
            $conLog = NULL;
            $msg_log = array('time' => date('Y-m-d H:i:s'), 'msg' => $msg);
            if (0 < $contract_sl['count'] && '' != $contract_sl['data']['conLog']) {
                $conLog = json_decode($contract_sl['data']['conLog'], TRUE);
                array_unshift($conLog, $msg_log);
            }
            else {
                $conLog[] = $msg_log;
            }
            $arrPar = array('conId'  => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : '',
                            'conLog' => json_encode($conLog, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK));
            //SQL
            if ($Conn->UtilCheckNotNull($conLog)) {
                $sql = ' UPDATE `contract`
                         SET `conLog` = :conLog, `conUpdateTime` = NOW()
                         WHERE `conId` = :conId';
                $aryExecute = $Conn->pramExecute($sql, $arrPar);
            }
            else {
                return FALSE;
            }
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
         * todo:queryContractLog 查看文件Log
         *
         * @param $rows
         * @param $conId
         * @param $anum
         * @param $num
         *
         * @return mixed
         */
        function queryContractLog($rows, $conId, $anum, $num)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId' => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `contractLog` CL';
            $sql .= ' LEFT JOIN `contract` C ON C.`conId` = CL.`conId`';
            $sql .= ' LEFT JOIN `member` M ON M.`memId` = CL.`memId`';
            $sql .= ' LEFT JOIN `personnel` P ON P.`perKey` = CL.`perKey`';
            $sql .= ' WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conId) ? ' AND CL.`conId` = :conId' : '';
            $sql .= $Conn->getLimit($anum, $num);
            $sql .= ' ORDER BY `colCreateTime` DESC';
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:insertContractLog 新增文件Log
         *
         * @param $conId
         * @param $memId
         * @param $perKey
         * @param $colMemberStatus
         * @param $colMsg
         * @param $colStatus
         *
         * @return array|int|Number
         */
        function insertContractLog($conId, $memId, $perKey, $colMemberStatus, $colMsg, $colStatus)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'     => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : '',
                            'memId'     => $Conn->UtilCheckNotNullIsNumeric($memId) ? $memId : '',
                            'perKey'    => $Conn->UtilCheckNotNull($perKey) ? $perKey : '',
                            'colMemberStatus' => $Conn->UtilCheckNotNullIsNumeric($colMemberStatus) ? $colMemberStatus : -1,
                            'colMsg'    => $Conn->UtilCheckNotNull($colMsg) ? $colMsg : '',
                            'colStatus' => $Conn->UtilCheckNotNullIsNumeric($colStatus) ? $colStatus : -1);
            //SQL
            $sql = ' INSERT INTO `contractLog`(`conId`, `memId`, `perKey`, `colMemberStatus`, `colMsg`, `colStatus`, `colCreateTime`)
                     VALUES(:conId, :memId, :perKey, :colMemberStatus, :colMsg, :colStatus, NOW())';
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
            $sql = ' DELETE FROM `contractLog`
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
         * @param $memType
         *
         * @return mixed
         */
        function queryMember($rows, $conId, $memType)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'   => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : 0,
                            'memType' => $Conn->UtilCheckNotNullIsNumeric($memType) ? $memType : NULL);
            //SQL
            $sql = ' SELECT SQL_CALC_FOUND_ROWS '.$Conn->getFiledRow($rows).' FROM `member` M
                     LEFT JOIN `company` C ON M.`memBu1Code` = C.`comCode`
                     WHERE 1=1';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($conId) ? ' AND conId = :conId' : '';
            $sql .= $Conn->UtilCheckNotNullIsNumeric($memType) ? ' AND M.`memType` = :memType' : '';
            $aryData['data'] = $Conn->pramGetAll($sql, $arrPar);
            $aryData['count'] = $Conn->pramGetRowCount();
            return $aryData;
        }

        /**
         * todo:insertMember 新增簽核流程
         *
         * @param $conId
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
        function insertMember($conId, $memType, $memBu1Code, $memBu2Code, $memBu2, $memBu3Code, $memBu3, $memLV0Key, $memLV0Name, $memLV0PositionName, $memLVCKey, $memLVCName, $memLVCPositionName, $memLV1Key, $memLV1Name, $memLV1PositionName, $memLV2Key, $memLV2Name, $memLV2PositionName, $memPhone, $memNowKey)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'              => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : 0,
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
            $sql = ' INSERT INTO `member`(`conId`, `memType`, `memBu1Code`, `memBu2Code`, `memBu2`, `memBu3Code`, `memBu3`, `memLV0Key`, `memLV0Name`, `memLV0PositionName`, `memLVCKey`, `memLVCName`, `memLVCPositionName`, `memLV1Key`, `memLV1Name`, `memLV1PositionName`, `memLV2Key`, `memLV2Name`, `memLV2PositionName`, `memPhone`, `memNowKey`)
                     VALUES(:conId, :memType, :memBu1Code, :memBu2Code, :memBu2, :memBu3Code, :memBu3, :memLV0Key, :memLV0Name, :memLV0PositionName, :memLVCKey, :memLVCName, :memLVCPositionName, :memLV1Key, :memLV1Name, :memLV1PositionName, :memLV2Key, :memLV2Name, :memLV2PositionName, :memPhone, :memNowKey)';
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
                     SET `memLV0Status` = -1, `memLV0Msg` = NULL, `memLV0Time` = NULL, `memLVCStatus` = -1, `memLVCKey` = \'\', `memLVCName` = \'\', `memLVCPositionName` = \'\', `memLVCTime` = NULL, `memLV1Status` = -1, `memLV1Msg` = NULL, `memLV1Time` = NULL, `memLV2Status` = -1, `memLV2Msg` = NULL, `memLV2Time` = NULL, `memNowKey` = NULL, `memNowStatus` = -1, `memStatus` = -1
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
            $arrPar = array('conId' => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : 0);
            //SQL
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
         * @param $memNowKey
         * @param $memNowStatus
         *
         * @return array|int|Number
         */
        function updateMemberStatusAll($conId, $memNowKey, $memNowStatus)
        {
            $Conn = new ConnManager();
            $arrPar = array('conId'        => $Conn->UtilCheckNotNullIsNumeric($conId) ? $conId : 0,
                            'memNowKey'    => $Conn->UtilCheckNotNull($memNowKey) ? $memNowKey : NULL,
                            'memNowStatus' => $Conn->UtilCheckNotNullIsNumeric($memNowStatus) ? $memNowStatus : NULL);
            //SQL
            $up_sql = '';
            $up_sql .= $Conn->UtilCheckNotNull($memNowKey) ? ('' != $up_sql ? ', ' : '').' `memNowKey` = :memNowKey' : '';
            $up_sql .= $Conn->UtilCheckNotNullIsNumeric($memNowStatus) ? ('' != $up_sql ? ', ' : '').' `memNowStatus` = :memNowStatus' : '';
            $sql = ' UPDATE `member`
                     SET '.$up_sql.'
                     WHERE `conId` = :conId';
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
                    $sql_iteId = ' AND `memId` NOT IN ('.$sql_iteId.')';
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
