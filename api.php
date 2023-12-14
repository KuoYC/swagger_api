<?php
    include 'include/config/Web_Config.php';
    include INCLUDE_PATH.'class/ContractManager.class.php';
    // 允许跨域请求的源
    header("Access-Control-Allow-Origin: *");
    // 允许的请求方法
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    // 允许的请求头
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    // 允许发送身份验证凭据（如 Cookie）
    header('Access-Control-Allow-Credentials: true');

    header('Content-Type: application/json');
    $ContractMgr = new ContractManager();
    $return_data['code'] = 0;
    $return_data['message'] = '請求成功';
    switch ($_GET['type']) {
        /**
         * todo: personnel 取得員工資訊
         * GET personnel
         * input:string
         * {
         *      keyword:            string(null)
         *      perBu1Code:         string(null)
         *      perBu2Code:         string(null)
         *      perBu3Code:         string(null)
         *      perKey:             string(null)
         *      perEmail:           string(null)
         *      perAccount:         string(null)
         *      perNo:              string(null)
         *      perPosition:        string(null)
         * }
         * return:
         * {
         *      "perMobile":        "0922333444",
         *      "perPositionName":  "高級專員",
         *      "perPhone1":        "02",
         *      "perPhone3":        "5077",
         *      "perKey":           "00588240::51::01::TC10000::TC10050",
         *      "perBu2":           "國內通路A1-通路營運部",
         *      "perAccount":       "J25905937C",
         *      "perBu1Code":       "01",
         *      "perName":          "傅○瑋",
         *      "perBu2Code":       "TC10000",
         *      "perBu3Code":       "TC10050",
         *      "perEmail":         "00588240@cathlife.com.tw",
         *      "perPar":           "0",
         *      "perId":            "1",
         *      "perBu1":           "國泰世華",
         *      "perNo":            "00588240",
         *      "perPhone2":        "0227551399",
         *      "perNick":          "",
         *      "perBu3":           "通路營運部",
         *      "perPosition":      "51"
         * }
         */
        case 'personnel':
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    $personnel_list = $ContractMgr->queryPersonnel(NULL, $_GET['keyword'], $_GET['perBu1Code'], $_GET['perBu2Code'], $_GET['perBu3Code'], $_GET['perKey'], $_GET['perEmail'], $_GET['perAccount'], $_GET['perNo'], $_GET['perPosition'], NULL, NULL);
                    $return_data['data'] = $personnel_list['data'];
                    break;
            }
            break;


        /**
         * todo: personnel_group 從personnel取得部門與科部名稱
         * GET personnel_group
         * input:string
         * {
         *      col:                int
         *      perBu1Code:         string(col in (2, 3))
         *      perBu2Code: `       string(col in (3))
         * }
         */
        case 'personnel_group':
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    switch ($_GET['col']) {
                        case '1':
                            $personnel_group_list = $ContractMgr->queryPersonnelGroupForBu1();
                            break;
                        case '2':
                            $personnel_group_list = $ContractMgr->queryPersonnelGroupForBu2($_GET['perBu1Code']);
                            break;
                        case '3':
                            $personnel_group_list = $ContractMgr->queryPersonnelGroupForBu3($_GET['perBu1Code'], $_GET['perBu2Code']);
                            break;
                    }
                    $return_data['data'] = $personnel_group_list['data'];
                    break;
            }
            break;
        /**
         * todo: news 公告操作
         */
        case 'news':// todo: news 公告操作
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: news GET[nwsId|null] 取得[單一|全部]公告
                    if (isset($_GET['nwsId'])) {
                        $news_sl = $ContractMgr->queryNewsByID(NULL, $_GET['nwsId']);
                        if (0 < $news_sl['count']) {
                            $news_sl['data']['nwsContent'] = htmlspecialchars_decode(nl2br($news_sl['data']['nwsContent']));
                            $return_data['data'] = $news_sl['data'];
                        }
                    }
                    else {
                        $news_list = $ContractMgr->queryNews(NULL, NULL, NULL);
                        for ($i = 0; $i < $news_list['count']; $i++) {
                            $news_list['data'][$i]['nwsContent'] = htmlspecialchars_decode(nl2br($news_list['data'][$i]['nwsContent']));
                        }

                        $return_data['data'] = $news_list['data'];
                    }
                    break;
                case 'POST':// todo: work POST[nwsTitle, nwsRelease, nwsContent, nwsTop, nwsType]新增公告 return:nwsId
                    $data = json_decode(file_get_contents('php://input'), TRUE);
                    $news_ad = $ContractMgr->insertNews($data['nwsTitle'], $data['nwsRelease'], $data['nwsContent'], $data['nwsTop'], $data['nwsType']);
                    if ($news_ad) {
                        $return_data['nwsId'] = $news_ad;//回傳成功
                        $return_data['data'] = 'success';
                    }
                    break;
                case 'PUT':// todo: work PUT[worId, worTitle]修改公告
                    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料
                    if (isset($data['worId'])) {
                        $news_up = $ContractMgr->updateNewsByID($data['nwsId'], $data['nwsTitle'], $data['nwsRelease'], $data['nwsContent'], $data['nwsTop'], $data['nwsType']);
                        if ($news_up) {
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
                case 'DELETE':// todo: nwsId PUT[nwsId]刪除公告
                    if (isset($_GET['worId'])) {
                        $news_dl = $ContractMgr->deleteNewsByID($_GET['nwsId']);
                        if ($news_dl) {
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
            }
            break;
        case 'work':// todo: work 作業種類操作
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: work GET[worId|null] 取得[單一|全部]作業種類
                    if (isset($_GET['worId'])) {
                        $work_sl = $ContractMgr->queryWorkByID(NULL, $_GET['worId']);
                        if (0 < $work_sl['count']) {
                            $return_data['data'] = $work_sl['data'];
                        }
                    }
                    else {
                        $work_list = $ContractMgr->queryWork(NULL, NULL, NULL);
                        $return_data['data'] = $work_list['data'];
                    }
                    break;
                case 'POST':// todo: work POST[worTitle]新增作業種類 return:worId
                    $data = json_decode(file_get_contents('php://input'), TRUE);
                    $work_ad = $ContractMgr->insertWork($data['worTitle']);
                    if ($work_ad) {
                        $return_data['worId'] = $work_ad;//回傳成功
                        $return_data['data'] = 'success';
                    }
                    break;
                case 'PUT':// todo: work PUT[worId, worTitle]修改作業種類
                    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料
                    if (isset($data['worId'])) {
                        $work_up = $ContractMgr->updateWorkByID($data['worId'], $data['worTitle']);
                        if ($work_up) {
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
                case 'DELETE':// todo: work PUT[worId]刪除作業種類
                    if (isset($_GET['worId'])) {
                        $work_dl = $ContractMgr->deleteWorkByID($_GET['worId']);
                        if ($work_dl) {
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
            }
            break;
        case 'frame':// todo: frame 框架種類操作
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: frame GET[frmId|null] 取得[單一|全部]框架種類
                    if (isset($_GET['frmId'])) {
                        $frame_sl = $ContractMgr->queryFrameByID(NULL, $_GET['frmId']);
                        if (0 < $frame_sl['count']) {
                            $return_data['data'] = $frame_sl['data'];
                        }
                    }
                    else {
                        $frame_list = $ContractMgr->queryFrame(NULL, NULL, NULL);
                        $return_data['data'] = $frame_list['data'];
                    }
                    break;
                case 'POST':// todo: frame POST[frmTitle]新增框架種類 return:frmId
                    $data = json_decode(file_get_contents('php://input'), TRUE);
                    $frame_ad = $ContractMgr->insertFrame($data['frmTitle']);
                    if ($frame_ad) {
                        $return_data['frmId'] = $frame_ad;//回傳成功
                        $return_data['data'] = 'success';
                    }
                    break;
                case 'PUT':// todo: frame PUT[frmId, frmTitle]修改框架種類
                    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料
                    if (isset($data['frmId'])) {
                        $frame_up = $ContractMgr->updateFrameByID($data['frmId'], $data['frmTitle']);
                        if ($frame_up) {
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
                case 'DELETE':// todo: frame PUT[frmId]刪除框架種類
                    if (isset($_GET['frmId'])) {
                        $frame_dl = $ContractMgr->deleteFrameByID($_GET['frmId']);
                        if ($frame_dl) {
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
            }
            break;
        case 'company':// todo: company 公司資料操作
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: company GET[comId|null] 取得[單一|全部]公司資料
                    if (isset($_GET['comId'])) {
                        $company_sl = $ContractMgr->queryCompanyByID(NULL, $_GET['comId']);
                        if (0 < $company_sl['count']) {
                            $return_data['data'] = $company_sl['data'];
                        }
                    }
                    else {
                        $company_list = $ContractMgr->queryCompany(NULL, NULL, NULL);
                        $return_data['data'] = $company_list['data'];
                    }
                    break;
                case 'POST':// todo: company POST[comTitle, comCode]新增公司 return:comId
                    $data = json_decode(file_get_contents('php://input'), TRUE);
                    $company_ad = $ContractMgr->insertCompany($data['comTitle'], $data['comCode']);
                    if ($company_ad) {
                        $return_data['comId'] = $company_ad;//回傳成功
                        $return_data['data'] = 'success';
                    }
                    break;
                case 'PUT':// todo: company PUT[comId, comTitle, comCode]修改公司
                    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料
                    if (isset($data['comId'])) {
                        $company_up = $ContractMgr->updateCompanyByID($data['comId'], $data['comTitle'], $data['comCode']);
                        if ($company_up) {
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
                case 'DELETE':// todo: company PUT[comId]刪除公司 **
                    if (isset($_GET['comId'])) {
                        $company_dl = $ContractMgr->deleteCompanyByID($_GET['comId']);
                        if ($company_dl) {
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
            }
            break;
        case 'category':// todo: category 下拉分類
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: category GET[catId|null] 取得[單一|全部]下拉分類資料 ps.catType=[list:分類|word:選項]
                    if (isset($_GET['catId'])) {
                        $category_sl = $ContractMgr->queryCategoryByID(NULL, $_GET['catId']);
                        if (0 < $category_sl['count']) {
                            $return_data['data'] = $category_sl['data'];
                        }
                    }
                    else {
                        $category_list = $ContractMgr->queryCategory(NULL, $_GET['catType'], NULL, NULL);
                        $return_data['data'] = $category_list['data'];
                    }
                    break;
                case 'POST':// todo: category POST[catTitle, catType, catWord]新增下拉分類 return:catId
                    $data = json_decode(file_get_contents('php://input'), TRUE);
                    $category_ad = $ContractMgr->insertCategory($data['catTitle'], $data['catType'], $data['catWord'], '0');
                    if ($category_ad) {
                        $return_data['catId'] = $category_ad;//回傳成功
                        $return_data['data'] = 'success';
                    }
                    break;
                case 'PUT':// todo: category PUT[catId, catTitle, catType, catWord]修改下拉分類
                    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料
                    if (isset($data['catId'])) {
                        $category_up = $ContractMgr->updateCategoryByID($data['catId'], $data['catTitle'], $data['catType'], $data['catWord'], '0');
                        if ($category_up) {
                            if (!in_array($data['catType'], array('list'))) {
                                $source_dl = $ContractMgr->deleteSourceByCategory($_GET['catId']);
                            }
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
                case 'DELETE':// todo: category PUT[catId]刪除下拉分類 **
                    if (isset($_GET['catId'])) {
                        $category_dl = $ContractMgr->deleteCategoryByID($_GET['catId']);
                        if ($category_dl) {
                            $source_dl = $ContractMgr->deleteSourceByCategory($_GET['catId']);
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
            }
            break;
        case 'source':// todo: source 下拉資料
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: source GET[souId|{null|catId}] 取得[單一|{全部|分類相關}]下拉資料
                    if (isset($_GET['souId'])) {
                        $source_sl = $ContractMgr->querySourceByID(NULL, $_GET['souId']);
                        if (0 < $source_sl['count']) {
                            $return_data['data'] = $source_sl['data'];
                        }
                    }
                    else {
                        if (isset($_GET['catId'])) {
                            $source_list = $ContractMgr->querySource(NULL, $_GET['catId'], NULL, NULL);
                            $return_data['data'] = $source_list['data'];
                        }
                        else {
                            $source_list = $ContractMgr->querySource(NULL, NULL, NULL, NULL);
                            $return_data['data'] = $source_list['data'];
                        }
                    }
                    break;
                case 'POST':// todo: source POST[catId, souTitle]新增下拉資料 return:souId
                    $data = json_decode(file_get_contents('php://input'), TRUE);
                    $source_ad = $ContractMgr->insertSource($data['catId'], $data['souTitle']);
                    if ($source_ad) {
                        $return_data['souId'] = $source_ad;//回傳成功
                        $return_data['data'] = 'success';
                    }
                    break;
                case 'PUT':// todo: source PUT[souId, catId, souTitle]修改下拉資料
                    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料
                    if (isset($data['souId'])) {
                        $source_up = $ContractMgr->updateSourceByID($data['souId'], $data['catId'], $data['souTitle']);
                        if ($source_up) {
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
                case 'DELETE':// todo: source PUT[souId]刪除下拉資料 **
                    if (isset($_GET['souId'])) {
                        $source_dl = $ContractMgr->deleteSourceByID($_GET['souId']);
                        if ($source_dl) {
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
            }
            break;
        case 'template':// todo: template 樣板操作
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: template GET[temId|null] 取得[單一|全部]樣板
                    if (isset($_GET['temId'])) {
                        $template_sl = $ContractMgr->queryTemplateByID(NULL, $_GET['temId']);
                        if (0 < $template_sl['count']) {
                            $template_sl['data']['temStyle'] = htmlspecialchars_decode($template_sl['data']['temStyle']);
                        }
                        $return_data['data'] = $template_sl['data'];
                    }
                    else {
                        $template_list = $ContractMgr->queryTemplate(NULL, NULL, NULL);
                        for ($i = 0; $i < $template_list['count']; $i++) {
                            $template_list['data'][$i]['temStyle'] = htmlspecialchars_decode($template_list['data'][$i]['temStyle']);
                        }
                        $return_data['data'] = $template_list['data'];
                    }
                    break;
                case 'POST':// todo: template POST[temTitle, temStyle]新增樣板 return:temId
                    $data = json_decode(file_get_contents('php://input'), TRUE);
                    $template_ad = $ContractMgr->insertTemplate($data['temTitle'], $data['temExes'], $data['temStyle']);
                    if ($template_ad) {
                        $return_data['temId'] = $template_ad;//回傳成功
                        $return_data['data'] = 'success';
                    }
                    break;
                case 'PUT':// todo: template PUT[temId, temTitle, temStyle]修改樣板
                    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料
                    if (isset($data['temId'])) {
                        $template_up = $ContractMgr->updateTemplateByID($data['temId'], $data['temTitle'], $data['temExes'], $data['temStyle']);
                        if ($template_up) {
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
                case 'DELETE':// todo: template DELETE[temId]刪除樣板 **
                    if (isset($_GET['temId'])) {
                        $contract_template_dl = $ContractMgr->deleteTemplateByID($_GET['temId']);
                        if ($contract_template_dl) {
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
                default:
                    $return_data = FALSE;
                    break;
            }
            break;
        case 'distribution': // todo: distribution 分攤方式
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: distribution GET[worId|null] 取得[單一|全部]分攤方式
                    if (isset($_GET['disId'])) {
                        $distribution_sl = $ContractMgr->queryDistributionByID(NULL, $_GET['disId']);
                        if (0 < $distribution_sl['count']) {
                            $return_data['data'] = $distribution_sl['data'];
                        }
                    }
                    else {
                        $distribution_list = $ContractMgr->queryDistribution(NULL, NULL, NULL);
                        $return_data['data'] = $distribution_list['data'];
                    }
                    break;
            }
            break;
        case 'manner': // todo: manner 分攤比例方式
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: manner GET[manId|null] 取得[單一|全部]分攤方式
                    if (isset($_GET['manId'])) {
                        $manner_sl = $ContractMgr->queryMannerByID(NULL, $_GET['manId']);
                        if (0 < $manner_sl['count']) {
                            $manner_sl['data']['manRatio'] = htmlspecialchars_decode($manner_sl['data']['manRatio']);
                            $return_data['data'] = $manner_sl['data'];
                        }
                    }
                    else {
                        $manner_list = $ContractMgr->queryManner(NULL, NULL, NULL, NULL);
                        for ($i = 0; $i < $manner_list['count']; $i++) {
                            $manner_list['data'][$i]['manRatio'] = htmlspecialchars_decode($manner_list['data'][$i]['manRatio']);
                        }
                        $return_data['data'] = $manner_list['data'];
                    }
                    break;
                case 'PUT':// todo: manner PUT[worId, worTitle]修改公告
                    $data = json_decode(file_get_contents('php://input'), TRUE);
                    if (isset($data['mannerData'])) {
                        foreach ($data['mannerData'] as $man) {
                            if (isset($man['manId'], $man['manRatio']) && 'null' != $man['manRatio']) {
                                $manner_up = $ContractMgr->updateMannerByID($man['manId'], $man['manTitle'], $man['manType'], $man['manRatio']);
                            }
                        }
                        $return_data['data'] = 'success';
                    }
                    break;
            }
            break;
        case 'contact':// todo: contact 窗口資訊
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: contact GET[cotId|{comId|comCode|null}] 取得[單一|{公司編號|公司代號|全部}]窗口資訊
                    if (isset($_GET['cotId'])) {
                        $contact_sl = $ContractMgr->queryContactByID(NULL, $_GET['cotId']);
                        if (0 < $contact_sl['count']) {
                            $return_data['data'] = $contact_sl['data'];
                        }
                    }
                    else {
                        $contact_list = $ContractMgr->queryContact(NULL, $_GET['comId'], $_GET['comCode'], NULL, NULL);
                        $return_data['data'] = $contact_list['data'];
                    }
                    break;
                case 'POST':// todo: contact POST[comCode, perKey]新增窗口 return:cotId
                    $data = json_decode(file_get_contents('php://input'), TRUE);
                    $contact_ad = $ContractMgr->insertContact($data['comCode'], $data['perKey']);
                    if ($contact_ad) {
                        $return_data['cotId'] = $contact_ad;//回傳成功
                        $return_data['data'] = 'success';
                    }
                    break;
                case 'PUT':// todo: contact PUT[cotId, comCode, perKey]修改窗口
                    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料
                    if (isset($data['cotId'])) {
                        $contact_up = $ContractMgr->updateContactByID($data['cotId'], $data['comCode'], $data['perKey']);
                        if ($contact_up) {
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
                case 'DELETE':// todo: contact PUT[cotId]刪除窗口 **
                    if (isset($_GET['cotId'])) {
                        $contact_dl = $ContractMgr->deleteContactByID($_GET['cotId']);
                        if ($contact_dl) {
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
            }
            break;
        case 'search'://todo: contract 文件操作
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: contract GET[conId|{temId|comId|null}] 取得[單一|全部]文件
                    if (isset($_GET['action']) && '1' == $_GET['action']) {
                        $contract_list = $ContractMgr->queryContractForAction($_GET['keyword'], $_GET['temId'], $_GET['comId'], $_GET['comCode'], $_GET['conSerial'], $_GET['conStatus'], $_GET['perKey'], $_GET['perBu1Code'], $_GET['memOwner'], $_GET['memDraft'], $_GET['memView'], $_GET['memSign'], $_GET['memOver'], $_GET['conStatusNot'], $_GET['conMark'], $_GET['conInh'], NULL, NULL);
                    }
                    else {
                        $contract_list = $ContractMgr->queryContract(NULL, $_GET['keyword'], $_GET['temId'], $_GET['comId'], $_GET['comCode'], $_GET['perKey'], $_GET['conSerial'], $_GET['conStatus'], NULL, NULL);
                    }
                    if ($contract_list['count'] > 0) {
                        for ($i = 0; $i < $contract_list['count']; $i++) {
                            $contract_list['data'][$i]['conValue'] = htmlspecialchars_decode($contract_list['data'][$i]['conValue']);
                        }
                    }
                    $return_data['data'] = replaceArr($contract_list['data']);
                    break;
                default:
                    $return_data = FALSE;
                    break;
            }
            break;
        case 'contract'://todo: contract 文件操作
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: contract GET[conId|{temId|comId|null}] 取得[單一|全部]文件
                    if (isset($_GET['conId'])) {
                        $contract_sl = $ContractMgr->queryContractByID(array('C.*', 'T.*', 'CM.*', 'P.*', 'F.`frmTitle`'), $_GET['conId']);
                        $return_data['count'] = $contract_sl['count'];
                        if (0 < $contract_sl['count']) {
                            $contract_sl['data']['conValue'] = htmlspecialchars_decode($contract_sl['data']['conValue']);
                            $item_list = $ContractMgr->queryItem('', $_GET['conId']);
                            for ($i = 0; $i < $item_list['count']; $i++) {
                                $item_list['data'][$i]['iteProportion'] = htmlspecialchars_decode($item_list['data'][$i]['iteProportion']);
                            }
                            $member_list = $ContractMgr->queryMember(NULL, $_GET['conId'], $_GET['appId'], $_GET['memType'], '', '');

                            $contract_sl['data']['itemData'] = $item_list['data'];
                            $contract_sl['data']['memberData'] = $member_list['data'];
//                            $contract_sl['data']['filePath'] = 'https://ju-house.com/upload/';
                            $contract_sl['data']['filePath'] = 'http://www.api.ks/upload/';
                            $return_data['data'] = replaceArr($contract_sl['data']);
                        }
                    }
                    else {
                        if (isset($_GET['action']) && '1' == $_GET['action']) {
                            $contract_list = $ContractMgr->querySearchForAction($_GET['keyword'], $_GET['temId'], $_GET['comId'], $_GET['comCode'], $_GET['conSerial'], $_GET['status'], $_GET['perKey'], $_GET['perBu1Code'], $_GET['memOwner'], $_GET['memDraft'], $_GET['memView'], $_GET['memSign'], $_GET['memOver'], $_GET['statusNot'], $_GET['mark'], $_GET['inh'], NULL, NULL);
//                            $contract_list = $ContractMgr->queryContractForAction($_GET['keyword'], $_GET['temId'], $_GET['comId'], $_GET['comCode'], $_GET['conSerial'], $_GET['conStatus'], $_GET['perKey'], $_GET['perBu1Code'], $_GET['memOwner'], $_GET['memDraft'], $_GET['memView'], $_GET['memSign'], $_GET['memOver'], $_GET['conStatusNot'], $_GET['conMark'], $_GET['conInh'], NULL, NULL);
                        }
                        else {
                            $contract_list = $ContractMgr->queryContract(NULL, $_GET['keyword'], $_GET['temId'], $_GET['comId'], $_GET['comCode'], $_GET['perKey'], $_GET['conSerial'], $_GET['conStatus'], NULL, NULL);
                        }
                        if ($contract_list['count'] > 0) {
                            for ($i = 0; $i < $contract_list['count']; $i++) {
                                $contract_list['data'][$i]['conValue'] = htmlspecialchars_decode($contract_list['data'][$i]['conValue']);
                            }
                        }
                        $return_data['data'] = replaceArr($contract_list['data']);
                    }
                    break;
                case 'PUT'://todo contract PUT 修改文件資料
                    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料
                    $contract_up = $ContractMgr->updateContractByID($data['conId'], $data['conTitle'], $data['frmId'], $data['conDate'], $data['conWork'], $data['conCompany'], $data['conValue'], $data['conApp'], $data['conLock'], $data['conStatus']);
                    if (isset($data['itemData']) && NULL != $data['itemData']) {
                        //刪除不再資料列中的資料
                        $iteId_list = NULL;
                        foreach ($data['itemData'] as $ite) {
                            $iteId_list[] = $ite['iteId'];
                        }
                        $item_list = $ContractMgr->queryItem(array('I.`iteId`'), $data['conId']);
                        $o_iteId_list = NULL;
                        foreach ($item_list['data'] as $ite) {
                            $o_iteId_list[] = $ite['iteId'];
                        }
                        $dl_iteId_list = array_diff($o_iteId_list, $iteId_list);

                        if (0 < count($dl_iteId_list)) {
                            $item_dl = $ContractMgr->deleteItemByContract($data['conId'], $dl_iteId_list);
                        }
                        //============
                        foreach ($data['itemData'] as $ite) {
                            if ($ite['iteId']) {
                                $item_up = $ContractMgr->updateItem($ite['iteId'], $data['conId'], $ite['iteTitle'], $ite['worId'], $ite['iteTime'], $ite['iteSubsidiaries'], $ite['iteControl'],
                                                                    $ite['disId'], $ite['manId'], $ite['iteProportion'], $ite['iteTypeNote'], $ite['iteDescription'],
                                                                    NULL, NULL, NULL, $ite['iteWord'], $ite['iteNote']);
                            }
                            else {
                                $item_ad = $ContractMgr->insertItem($data['conId'],
                                                                    $ite['iteTitle'], $ite['worId'], $ite['iteTime'], $ite['iteSubsidiaries'], $ite['iteControl'],
                                                                    $ite['disId'], $ite['manId'], $ite['iteProportion'], $ite['iteTypeNote'], $ite['iteDescription'],
                                                                    NULL, NULL, NULL, $ite['iteWord'], $ite['iteNote']);
                            }
                        }
                    }
                    if (isset($data['memberData']) && is_array($data['memberData'])) {
                        //刪除不再資料列中的資料
                        $memId_list = NULL;
                        foreach ($data['memberData'] as $mbr) {
                            $memId_list[] = $mbr['memId'];
                        }
                        $member_list = $ContractMgr->queryMember(array('M.`memId`'), $data['conId'], '', NULL, NULL, NULL);
                        if ($member_list['count'] > 0) {
                            $o_memId_list = NULL;
                            foreach ($member_list['data'] as $mbr) {
                                $o_memId_list[] = $mbr['memId'];
                            }
                            $dl_memId_list = array_diff($o_memId_list, $memId_list);

                            if (0 < count($dl_memId_list)) {
                                $member_dl = $ContractMgr->deleteMemberByContract($data['conId'], $dl_memId_list);
                            }
                        }
                        //==============
                        $appId = 0;
                        $contract_sl = $ContractMgr->queryContractByID('', $data['conId']);
                        if ($contract_sl['data']['conApp'] >= 0) {
                            $appId = $contract_sl['data']['conApp'];
                        }
                        foreach ($data['memberData'] as $mbr) {
                            if ($mbr['memId'] && '0' != $mbr['memId']) {
                                $member_up = $ContractMgr->updateMemberByID($mbr['memId'], $mbr['memType'], $mbr['memBu1Code'], $mbr['memBu2Code'], $mbr['memBu2'], $mbr['memBu3Code'], $mbr['memBu3'],
                                                                            $mbr['memLV0Key'], $mbr['memLV0Name'], $mbr['memLV0PositionName'],
                                                                            $mbr['memLVCKey'], $mbr['memLVCName'], $mbr['memLVCPositionName'],
                                                                            $mbr['memLV1Key'], $mbr['memLV1Name'], $mbr['memLV1PositionName'],
                                                                            $mbr['memLV2Key'], $mbr['memLV2Name'], $mbr['memLV2PositionName'],
                                                                            $mbr['memPhone'], NULL);
                            }
                            else {
                                $member_ad = $ContractMgr->insertMember($data['conId'], $appId, $mbr['memType'], $mbr['memBu1Code'], $mbr['memBu2Code'], $mbr['memBu2'], $mbr['memBu3Code'], $mbr['memBu3'],
                                                                        $mbr['memLV0Key'], $mbr['memLV0Name'], $mbr['memLV0PositionName'],
                                                                        $mbr['memLVCKey'], $mbr['memLVCName'], $mbr['memLVCPositionName'],
                                                                        $mbr['memLV1Key'], $mbr['memLV1Name'], $mbr['memLV1PositionName'],
                                                                        $mbr['memLV2Key'], $mbr['memLV2Name'], $mbr['memLV2PositionName'],
                                                                        $mbr['memPhone'], NULL);
                            }
                        }
                    }
                    $return_data['data'] = 'success';
                    break;
                case 'DELETE'://dl
                    if (isset($_GET['conId'])) {
                        $contract_dl = $ContractMgr->deleteContractByID($_GET['conId']);
                        if ($contract_dl) {
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
                default:
                    $return_data = FALSE;
                    break;
            }
            break;
        case 'contractId'://todo: contractId 取得新增的conId
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: contract GET[perKey, temId] 取得[單一|全部]文件
                    $date_key = date('YmdHis', time());
                    $template_sl = $ContractMgr->queryTemplateByID('', $_GET['temId']);
                    if (0 < $template_sl['count']) {
                        $contract_ad = $ContractMgr->insertContract($_GET['temId'], $_GET['perKey'], $_GET['comCode'], '', $date_key, 'A', '0', '', $_GET['conType'], '', '', '', $template_sl['data']['temStyle'], $_GET['conApp'], '-1');
                        $return_data['conId'] = $contract_ad;
                        $return_data['data'] = 'success';
                    }
                    else {
                        $return_data = FALSE;
                    }
                    break;
                default:
                    $return_data = FALSE;
                    break;
            }
            break;
        case 'contractCopy'://todo: contractCopy 複製一份文件 ##new##
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: contract GET[perKey, temId] 取得[單一|全部]文件
                    $contract_sl = $ContractMgr->queryContractByID('', $_GET['conId']);
                    if (0 < $contract_sl['count']) {
                        $contract_copy = $ContractMgr->copyContract($_GET['conId'], $_GET['conType'], $contract_sl['data']['conSerial'], chr(ord(trim($contract_sl['data']['conVer'])) + 1), $_GET['conMark'], -1);
                        if ($contract_copy) {
                            $item_copy = $ContractMgr->copyItem($_GET['conId'], $contract_copy);
                            $member_copy = $ContractMgr->copyMember($_GET['conId'], $contract_copy, '', '');
                            $contract_inh_up = $ContractMgr->updateContractInheritByID($_GET['conId'], $contract_copy);
                        }
                        $contract_inh_up = $ContractMgr->updateContractInheritByID($_GET['conId'], $contract_copy);
                        $return_data['conId'] = $contract_copy;
                        $return_data['data'] = 'success';
                    }
                    else {
                        $return_data = FALSE;
                    }
                    break;
                default:
                    $return_data = FALSE;
                    break;
            }
            break;
        case 'contractStatus': // todo: contractStatus 修改文件狀態
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'PUT':// todo: contract_status PUT[conId, conStatus, {conDate|null}] 修改文件狀態
                    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料

                    if (isset($data['conId'])) {
                        $contract_up = $ContractMgr->updateContractStatusByID($data['conId'], $data['conStatus'], $data['conDate']);
                        if ($contract_up) {
                            if ('2' == $data['conStatus']) {
                                $contract_sl = $ContractMgr->queryContractByID('', $data['conId']);
                                if ($contract_sl['count'] > 0) {
                                    $contract_copy = $ContractMgr->copyContract($data['conId'], $contract_sl['data']['conType'], $contract_sl['data']['conSerial'], $contract_sl['data']['conVer'], 0, 0);
                                    if ($contract_copy) {
                                        $item_copy = $ContractMgr->copyItem($_GET['conId'], $contract_copy);
                                        $member_copy = $ContractMgr->copyMember($_GET['conId'], $contract_copy, '', '');
                                        $contract_sl = $ContractMgr->queryContractByInh('', $_GET['conId']);
                                        if (0 < $contract_sl['count']) {
                                            $contract_inh_up = $ContractMgr->updateContractInheritByID($contract_sl['data']['conId'], $contract_copy);
                                        }
                                    }
                                }
                                $contract_mark_up = $ContractMgr->updateContractMarkByID($data['conId'], '1');
                            }
                            if ('4' == $data['conStatus']) {
                                $contract_inh_clean = $ContractMgr->cleanContractInheritByID($data['conId']);
                            }
                            if (isset($data['sglLog'])) {
                                $log = json_decode($data['sglLog'], TRUE);
                                $ContractMgr->insertSignLog($log['conId'], $log['appId'], $log['memId'], $log['perKey'], $log['sglMemberStatus'], $log['sglMsg'], $log['sglStatus']);
                            }
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
                default:
                    $return_data = FALSE;
                    break;
            }
            break;
        case 'contractInherit': // todo: contractInherit 修改文件繼承編號
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'PUT':// todo: contract_status PUT[conId, conStatus, {conDate|null}] 修改文件狀態
                    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料

                    if (isset($data['conId'], $data['conIdNew'])) {
                        $contract_inh_up = $ContractMgr->updateContractInheritByID($data['conId'], $data['conIdNew']);
                        if ($contract_inh_up) {
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
                default:
                    $return_data = FALSE;
                    break;
            }
            break;
        case 'contractLock': // todo: contractInherit 修改文件繼承編號
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'PUT':// todo: contract_status PUT[conId, conStatus, {conDate|null}] 修改文件狀態
                    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料
                    if (isset($data['conId'], $data['conLock'])) {
                        $contract_sl = $ContractMgr->queryContractByID('', $data['conId']);
                        if (0 < $contract_sl['count']) {
                            if ('0' == $data['conLock']) {
                                if (0 < $contract_sl['data']['conApp']) {
                                    $ContractMgr->deleteSubsidiaryByApportionId($contract_sl['data']['conApp']);
                                    $ContractMgr->deleteAnnualByApportionId($contract_sl['data']['conApp']);
                                    $ContractMgr->deleteExesByApportionId($contract_sl['data']['conApp']);
                                    $ContractMgr->deleteApportionByID($contract_sl['data']['conApp']);
                                    $ContractMgr->updateContractAppByID($data['conId'], 0);
                                }
                            }
                            $contract_lock_up = $ContractMgr->updateContractLockByID($data['conId'], $data['conLock']);
                            if ($contract_lock_up) {
                                $return_data['data'] = 'success';
                            }
                        }
                    }
                    break;
                default:
                    $return_data = FALSE;
                    break;
            }
            break;
        case 'signLog'://todo: signLog取得文件Log資料
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: signLog取得文件Log資料 GET[conId] 取得[單一]文件
                    $contract_log_list = $ContractMgr->querySignLog('', $_GET['conId'], $_GET['appId'], '', '');
                    $return_data['count'] = $contract_log_list['count'];
                    if (0 < $contract_log_list['count']) {
                        $return_data['data'] = replaceArr($contract_log_list['data']);
                    }
                    break;
            }
            break;
        case 'contractDefault':// todo: contractDefault 重置文件狀態
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'PUT':// todo: contract_default PUT[conId] 重置文件狀態 ps.將文件conStatus=0, conDate不予理會, member.conId相關全部資料重置(xxStatus=-1, xxMsg=null, xxTime=null, memNow=null, memNowPosition=null)
                    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料

                    if (isset($data['conId'])) {
                        $contract_up = $ContractMgr->updateContractStatusByID($data['conId'], 0, NULL);
                        if ($contract_up) {
                            $ContractMgr->updateMemberByContractDefault($data['conId']);
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
                default:
                    $return_data = FALSE;
                    break;
            }
            break;
        case 'apportionDefault':// todo: contractDefault 重置文件狀態
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'PUT':// todo: contract_default PUT[conId] 重置文件狀態 ps.將文件conStatus=0, conDate不予理會, member.conId相關全部資料重置(xxStatus=-1, xxMsg=null, xxTime=null, memNow=null, memNowPosition=null)
                    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料

                    if (isset($data['appId'])) {
                        $apportion_up = $ContractMgr->updateApportionStatusByID($data['appId'], 0, NULL);
                        if ($apportion_up) {
                            $ContractMgr->updateMemberByApportionDefault($data['appId']);
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
                default:
                    $return_data = FALSE;
                    break;
            }
            break;
        case 'signDefault':// todo: contractDefault 重置文件狀態
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'PUT':// todo: contract_default PUT[conId] 重置文件狀態 ps.將文件conStatus=0, conDate不予理會, member.conId相關全部資料重置(xxStatus=-1, xxMsg=null, xxTime=null, memNow=null, memNowPosition=null)
                    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料

                    if (isset($data['conId']) && isset($data['appId'])) {
                        $contract_up = $ContractMgr->updateContractStatusByID($data['conId'], 0, NULL);
                        $apportion_up = $ContractMgr->updateApportionStatusByID($data['appId'], 0, NULL);
                        if ($contract_up && $apportion_up) {
                            $ContractMgr->updateMemberByContractApportionDefault($data['conId'], $data['appId']);
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
                default:
                    $return_data = FALSE;
                    break;
            }
            break;
        case 'signMember':// todo: contractMember 取得文件相關的所有簽核名單
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: contract_member GET[conId, {memType|null}]
                    $member_list = $ContractMgr->queryMember(NULL, $_GET['conId'], $_GET['appId'], $_GET['memType'], $_GET['memStatus'], $_GET['memStatusNot']);
                    $return_data['data'] = replaceArr($member_list['data']);
                    break;
            }
            break;
        case 'signStatus': // todo: contractStatus 修改文件與費用狀態
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'PUT':// todo: contract_status PUT[conId, conStatus, {conDate|null}] 修改文件狀態
                    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料
                    if (isset($data['conId']) && isset($data['appId'])) {
                        $contract_up = $ContractMgr->updateContractStatusByID($data['conId'], $data['status'], $data['date']);
                        $apportion_up = $ContractMgr->updateApportionStatusByID($data['appId'], $data['status'], $data['date']);
                        if ($contract_up && $apportion_up) {
                            if ('2' == $data['status']) {
                                $contract_sl = $ContractMgr->queryContractByID('', $data['conId']);
                                if ($contract_sl['count'] > 0) {
                                    $contract_copy = $ContractMgr->copyContract($data['conId'], $contract_sl['data']['conType'], $contract_sl['data']['conSerial'], $contract_sl['data']['conVer'], 0, 0);
                                    if ($contract_copy) {
                                        $item_copy = $ContractMgr->copyItem($_GET['conId'], $contract_copy);
                                        $contract_sl = $ContractMgr->queryContractByInh('', $_GET['conId']);
                                        if (0 < $contract_sl['count']) {
                                            $contract_inh_up = $ContractMgr->updateContractInheritByID($contract_sl['data']['conId'], $contract_copy);
                                        }

                                        $apportion_sl = $ContractMgr->queryApportionByID('', $data['appId']);
                                        if ($apportion_sl['count'] > 0) {
                                            $apportion_copy = $ContractMgr->copyApportion($data['appId'], $contract_copy, $apportion_sl['data']['appYear'], $apportion_sl['data']['appVer'], 0, 0);
                                            if ($apportion_copy) {
                                                $exes_list = $ContractMgr->queryExes('', $_GET['appId']);
                                                for ($i = 0; $i < $exes_list['count']; $i++) {
                                                    $exes_ad = $ContractMgr->copyExesByID($exes_list['data'][$i]['exeId'], $apportion_copy);
                                                    if ($exes_ad) {
                                                        $annual_list = $ContractMgr->queryAnnual('', $exes_list['data'][$i]['exeId']);
                                                        for ($j = 0; $j < $annual_list['count']; $j++) {
                                                            $ann_ad = $ContractMgr->copyAnnualByID($annual_list['data'][$j]['annId'], $exes_ad);
                                                            if ($ann_ad) {
                                                                $subsidiary_list = $ContractMgr->querySubsidiary('', $annual_list['data'][$j]['annId']);
                                                                for ($k = 0; $k < $subsidiary_list['count']; $k++) {
                                                                    $subsidiary_ad = $ContractMgr->copySubsidiaryByID($subsidiary_list['data'][$k]['subId'], $ann_ad);
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                $apportion_sl = $ContractMgr->queryApportionByInh('', $_GET['conId']);
                                                if (0 < $apportion_sl['count']) {
                                                    $apportion_inh_up = $ContractMgr->updateApportionInheritByID($apportion_sl['data']['appId'], $apportion_copy);
                                                }
                                                $member_copy = $ContractMgr->copyMember($data['conId'], $contract_copy, $data['appId'], $apportion_copy);
                                            }
                                        }
                                        $apportion_mark_up = $ContractMgr->updateApportionMarkByID($data['appId'], '1');
                                    }
                                }
                                $contract_mark_up = $ContractMgr->updateContractMarkByID($data['conId'], '1');
                            }
                            if ('4' == $data['status']) {
                                $contract_inh_clean = $ContractMgr->cleanContractInheritByID($data['conId']);
                                $apportion_inh_clean = $ContractMgr->cleanApportionInheritByID($data['conId']);
                            }
                            if (isset($data['sglLog'])) {
                                $log = json_decode($data['sglLog'], TRUE);
                                $ContractMgr->insertSignLog($log['conId'], $log['appId'], $log['memId'], $log['perKey'], $log['sglMemberStatus'], $log['sglMsg'], $log['sglStatus']);
                            }
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
                default:
                    $return_data = FALSE;
                    break;
            }
            break;
        case 'memberStatus'://todo:member_status簽核人員資料修改
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'PUT'://up
                    $data = json_decode(file_get_contents('php://input'), TRUE);
                    $member_up = $ContractMgr->updateMemberStatus($data['memId'], $data['memLV0Status'], $data['memLV0Time'], $data['memLV0Msg'], $data['memLVCKey'], $data['memLVCName'], $data['memLVCPositionName'], $data['memLVCStatus'], $data['memLVCTime'], $data['memLV1Status'], $data['memLV1Time'], $data['memLV1Msg'], $data['memLV2Status'], $data['memLV2Time'], $data['memLV2Msg'], $data['memNowKey'], $data['memNowStatus'], $data['memStatus']);
                    if ($member_up) {
                        if (isset($data['sglLog'])) {
                            $log = json_decode($data['sglLog'], TRUE);
                            $ContractMgr->insertSignLog($log['conId'], $log['appId'], $log['memId'], $log['perKey'], $log['sglMemberStatus'], $log['sglMsg'], $log);
                        }
                        if (isset($data['sglLogNext'])) {
                            $log = json_decode($data['sglLogNext'], TRUE);
                            $ContractMgr->insertSignLog($log['conId'], $log['appId'], $log['memId'], $log['perKey'], $log['sglMemberStatus'], $log['sglMsg'], $log);
                        }
                        $return_data['data'] = 'success';
                    }
                    break;
                default:
                    $return_data = FALSE;
                    break;
            }
            break;
        case 'memberStatusAll'://todo:member_status_all所有簽核人員資料修改
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'PUT'://up
                    $data = json_decode(file_get_contents('php://input'), TRUE);
                    $member_up = $ContractMgr->updateMemberStatusAll($data['conId'], $data['appId'], $data['memNowKey'], $data['memNowStatus']);
                    if ($member_up) {
                        $return_data['data'] = 'success';
                    }
                    break;
                default:
                    $return_data = FALSE;
                    break;
            }
            break;
        case 'contractItem':// todo: contract_item 取得文件相關的所有作業項目
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: contract_item GET[conId]
                    $item_list = $ContractMgr->queryItem(NULL, $_GET['conId']);
                    for ($i = 0; $i < $item_list['count']; $i++) {
                        $item_list['data'][$i]['iteProportion'] = htmlspecialchars_decode($item_list['data'][$i]['iteProportion']);
                    }
                    $return_data['data'] = replaceArr($item_list['data']);
                    break;
            }
            break;


        case 'personnelPurview':
            break;
        case 'admin':// todo: admin 管理員
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: admin GET[AdminId|{null|catId}] 取得[單一|{全部|分類相關}]下拉資料
                    if (isset($_GET['souId'])) {
                        $source_sl = $ContractMgr->querySourceByID(NULL, $_GET['souId']);
                        if (0 < $source_sl['count']) {
                            $return_data['data'] = $source_sl['data'];
                        }
                    }
                    else {
                        if (isset($_GET['catId'])) {
                            $source_list = $ContractMgr->querySource(NULL, $_GET['catId'], NULL, NULL);
                            $return_data['data'] = $source_list['data'];
                        }
                        else {
                            $source_list = $ContractMgr->querySource(NULL, NULL, NULL, NULL);
                            $return_data['data'] = $source_list['data'];
                        }
                    }
                    break;
            }
            break;
        case 'adminLogin':// todo: admin 管理員登入
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: admin GET[admAccount, md5(admPassword)] 管理員登入
                    if (isset($_GET['souId'])) {
                        $source_sl = $ContractMgr->querySourceByID(NULL, $_GET['souId']);
                        if (0 < $source_sl['count']) {
                            $return_data['data'] = $source_sl['data'];
                        }
                    }
                    else {
                        if (isset($_GET['catId'])) {
                            $source_list = $ContractMgr->querySource(NULL, $_GET['catId'], NULL, NULL);
                            $return_data['data'] = $source_list['data'];
                        }
                        else {
                            $source_list = $ContractMgr->querySource(NULL, NULL, NULL, NULL);
                            $return_data['data'] = $source_list['data'];
                        }
                    }
                    break;
            }
            break;

        case 'apportion'://todo: apportion 費用操作
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: apportion GET[conId|{conId|comId|null}] 取得[單一|全部]文件
                    if (isset($_GET['appId'])) {
                        $apportion_sl = $ContractMgr->queryApportionByID(array('A.*', 'CM.*', 'P.*', 'C.`conSerial`', 'C.`conVer`', 'C.`conTitle`', 'C.`conWork`', 'F.`frmTitle`', 'C.`conDate`', 'C.`conCompany`', 'T.`temTitle`', 'T.`temExes`', 'C.`conApp`'), $_GET['appId']);
                        $return_data['count'] = $apportion_sl['count'];
                        if (0 < $apportion_sl['count']) {
                            $exes_list = $ContractMgr->queryExes(array('E.*', 'I.*', 'W.*', 'D.*', 'M.*', 'S.*'), $_GET['appId']);
                            if (0 < $exes_list['count']) {
                                for ($i = 0; $i < $exes_list['count']; $i++) {
                                    $annual_list = $ContractMgr->queryAnnual('', $exes_list['data'][$i]['exeId']);
                                    $exes_list['data'][$i]['annualData'] = $annual_list['data'];
                                    if (0 < $annual_list['count']) {
                                        for ($j = 0; $j < $annual_list['count']; $j++) {
                                            $subsidiary_list = $ContractMgr->querySubsidiary('', $annual_list['data'][$j]['annId']);
                                            $exes_list['data'][$i]['annualData'][$j]['subsidiaryData'] = $subsidiary_list['data'];
                                            $exes_list['data'][$i]['iteProportion'] = htmlspecialchars_decode($exes_list['data'][$i]['iteProportion']);
                                            $exes_list['data'][$i]['manRatio'] = htmlspecialchars_decode($exes_list['data'][$i]['manRatio']);
                                        }
                                    }
                                }
                            }
                            $item_list = $ContractMgr->queryItem('', $apportion_sl['data']['conId']);
                            for ($i = 0; $i < $item_list['count']; $i++) {
                                $item_list['data'][$i]['iteProportion'] = htmlspecialchars_decode($item_list['data'][$i]['iteProportion']);
                                $item_list['data'][$i]['manRatio'] = htmlspecialchars_decode($item_list['data'][$i]['manRatio']);
                            }
                            $apportion_sl['data']['exesData'] = $exes_list['data'];
                            $apportion_sl['data']['itemData'] = $item_list['data'];
                            $member_list = $ContractMgr->queryMember(NULL, $_GET['conId'], $_GET['appId'], $_GET['memType'], '', '');
                            $apportion_sl['data']['memberData'] = $member_list['data'];
                            $return_data['data'] = replaceArr($apportion_sl['data']);
                        }
                    }
                    elseif (isset($_GET['conId'])) {
                        $apportion_sl = $ContractMgr->queryApportionLastByContract(array('A.`appId`'), $_GET['conId'], $_GET['appStatus']);
                        $return_data['count'] = $apportion_sl['count'];
                        if (0 < $apportion_sl['count']) {
                            $return_data['appId'] = $apportion_sl['data']['appId'];
                        }
                    }
                    else {
                        $apportion_list = $ContractMgr->queryApportion(NULL, $_GET['conId'], '', 0, '', '', $_GET['perKey'], $_GET['appYear'], $_GET['appStatus'], -1, $_GET['appMark'], $_GET['appInh'], NULL, NULL);
                        $return_data['data'] = replaceArr($apportion_list['data']);
                    }
                    break;
                case 'PUT'://todo apportion PUT 修改文件資料
                    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料
                    $apportion_up = $ContractMgr->updateApportionByID($data['appId'], $data['appDate'], $data['appStatus']);
                    if (isset($data['exesData']) && NULL != $data['exesData']) {
                        //刪除不再資料列中的資料
                        $exeId_list = NULL;
                        foreach ($data['exesData'] as $exe) {
                            $exeId_list[] = $exe['exeId'];
                        }
                        $exes_list = $ContractMgr->queryExes(array('E.`exeId`'), $data['appId']);
                        $o_exeId_list = NULL;
                        foreach ($exes_list['data'] as $exe) {
                            $o_exeId_list[] = $exe['exeId'];
                        }
                        if ($o_exeId_list) {
                            $dl_exeId_list = array_diff($o_exeId_list, $exeId_list);
                            if ($dl_exeId_list && 0 < count($dl_exeId_list)) {
                                $exes_dl = $ContractMgr->deleteExesByApportion($data['appId'], $dl_exeId_list);
                            }
                        }
                        //============
                        foreach ($data['exesData'] as $exe) {
                            $exeId = 0;
                            if ($exe['exeId']) {
                                $exeId = $exe['exeId'];
                                $exes_up = $ContractMgr->updateExes($exe['exeId'], $exe['iteId'], $exe['exeTitle'], $exe['exePM'], $exe['exeSP'], $exe['exeCost'], $exe['exeCreateMonth'], $exe['exeMonth'], $exe['exeStartYear'],
                                                                    $exe['exeNote']);
                            }
                            else {
                                $exes_ad = $ContractMgr->insertExes($exe['appId'], $exe['iteId'], $exe['exeTitle'], $exe['exePM'], $exe['exeSP'], $exe['exeCost'], $exe['exeCreateMonth'], $exe['exeMonth'], $exe['exeStartYear'],
                                                                    $exe['exeNote'], 0);
                                $exeId = $exes_ad;
                            }
                            if (isset($exe['annualData']) && NULL != $exe['annualData']) {
                                //刪除不再資料列中的資料
                                $annId_list = NULL;
                                foreach ($exe['annualData'] as $ann) {
                                    $annId_list[] = $ann['annId'];
                                }
                                $annual_list = $ContractMgr->queryAnnual(array('A.`annId`'), $exeId);
                                $o_annId_list = NULL;
                                foreach ($annual_list['data'] as $ann) {
                                    $o_annId_list[] = $ann['annId'];
                                }
                                if ($o_annId_list) {
                                    $dl_annId_list = array_diff($o_annId_list, $annId_list);
                                    if ($dl_annId_list && 0 < count($dl_annId_list)) {
                                        $ann_dl = $ContractMgr->deleteAnnualByApportion($exeId, $dl_annId_list);
                                    }
                                }
                                //============
                                $annId = 0;
                                foreach ($exe['annualData'] as $ann) {
                                    if ($ann['annId']) {
                                        $ann_up = $ContractMgr->updateAnnual($ann['annId'], $ann['annYear'], $ann['annStartMonth'], $ann['annEndMonth'], $ann['annMonth'], $ann['annCost'], $ann['annStatus']);
                                        $ann_id = $ann['annId'];
                                    }
                                    else {
                                        $ann_ad = $ContractMgr->insertAnnual($exeId, $ann['annYear'], $ann['annStartMonth'], $ann['annEndMonth'], $ann['annMonth'], $ann['annCost'], 0);
                                        $ann_id = $ann_ad;
                                    }
                                    if (isset($ann['subsidiaryData']) && NULL != $ann['subsidiaryData']) {
                                        //刪除不再資料列中的資料
                                        $subId_list = NULL;
                                        foreach ($ann['subsidiaryData'] as $sub) {
                                            $subId_list[] = $sub['subId'];
                                        }
                                        $subsidiary_list = $ContractMgr->querySubsidiary(array('S.`subId`'), $annId);
                                        $o_subId_list = NULL;
                                        foreach ($subsidiary_list['data'] as $sub) {
                                            $o_subId_list[] = $sub['subId'];
                                        }

                                        if ($o_subId_list) {
                                            $dl_subId_list = array_diff($o_subId_list, $subId_list);
                                            if ($dl_subId_list && 0 < count($dl_subId_list)) {
                                                $sub_dl = $ContractMgr->deleteSubsidiaryByApportion($ann_id, $dl_subId_list);
                                            }
                                        }
                                        //============
                                        foreach ($ann['subsidiaryData'] as $sub) {
                                            if ($sub['subId']) {
                                                $sub_up = $ContractMgr->updateSubsidiary($sub['subId'], $sub['comCode'], $sub['subAmount'], $sub['subPercent'], $sub['subCost']);
                                            }
                                            else {
                                                $sub_ad = $ContractMgr->insertSubsidiary($ann_id, $sub['comCode'], $sub['subAmount'], $sub['subPercent'], $sub['subCost']);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if (isset($data['memberData']) && is_array($data['memberData'])) {
                        //刪除不再資料列中的資料
                        $memId_list = NULL;
                        foreach ($data['memberData'] as $mbr) {
                            $memId_list[] = $mbr['memId'];
                        }
                        $member_list = $ContractMgr->queryMember(array('M.`memId`'), '', $data['appId'], NULL, NULL, NULL);
                        if ($member_list['count'] > 0) {
                            $o_memId_list = NULL;
                            foreach ($member_list['data'] as $mbr) {
                                $o_memId_list[] = $mbr['memId'];
                            }
                            $dl_memId_list = array_diff($o_memId_list, $memId_list);

                            if (0 < count($dl_memId_list)) {
                                $member_dl = $ContractMgr->deleteMemberByApportion($data['conId'], $dl_memId_list);
                            }
                        }
                        //==============
                        foreach ($data['memberData'] as $mbr) {
                            if ($mbr['memId'] && '0' != $mbr['memId']) {
                                $member_up = $ContractMgr->updateMemberByID($mbr['memId'], $mbr['memType'], $mbr['memBu1Code'], $mbr['memBu2Code'], $mbr['memBu2'], $mbr['memBu3Code'], $mbr['memBu3'],
                                                                            $mbr['memLV0Key'], $mbr['memLV0Name'], $mbr['memLV0PositionName'],
                                                                            $mbr['memLVCKey'], $mbr['memLVCName'], $mbr['memLVCPositionName'],
                                                                            $mbr['memLV1Key'], $mbr['memLV1Name'], $mbr['memLV1PositionName'],
                                                                            $mbr['memLV2Key'], $mbr['memLV2Name'], $mbr['memLV2PositionName'],
                                                                            $mbr['memPhone'], NULL);
                            }
                            else {
                                $member_ad = $ContractMgr->insertMember($data['conId'], $data['appId'], $mbr['memType'], $mbr['memBu1Code'], $mbr['memBu2Code'], $mbr['memBu2'], $mbr['memBu3Code'], $mbr['memBu3'],
                                                                        $mbr['memLV0Key'], $mbr['memLV0Name'], $mbr['memLV0PositionName'],
                                                                        $mbr['memLVCKey'], $mbr['memLVCName'], $mbr['memLVCPositionName'],
                                                                        $mbr['memLV1Key'], $mbr['memLV1Name'], $mbr['memLV1PositionName'],
                                                                        $mbr['memLV2Key'], $mbr['memLV2Name'], $mbr['memLV2PositionName'],
                                                                        $mbr['memPhone'], NULL);
                            }
                        }
                    }
                    $return_data['data'] = 'success';
                    break;
                case 'DELETE'://dl
                    if (isset($_GET['appId'])) {
                        $ContractMgr->deleteSubsidiaryByApportionId($_GET['appId']);
                        $ContractMgr->deleteAnnualByApportionId($_GET['appId']);
                        $ContractMgr->deleteExesByApportionId($_GET['appId']);
                        $apportion_dl = $ContractMgr->deleteApportionByID($_GET['appId']);
                        if ($apportion_dl) {
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
                default:
                    $return_data = FALSE;
                    break;
            }
            break;
        case 'apportionId'://todo: apportionId 取得新增的appId
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: apportionId GET[conId] 取得[單一|全部]文件
                    $info_sl = $ContractMgr->queryInfoByID('', 1);
                    $apportion_list = $ContractMgr->queryApportion('', $_GET['conId'], $_GET['conSerial'], 0, '', -1, '', '', '', -1, 0, '', '', '');
                    if (0 < $apportion_list['count']) {
                        if ($apportion_list['data'][0]['appYear'] == $info_sl['data']['infYear']) {
                            $apportion_ad = $ContractMgr->insertApportion($_GET['conId'], $_GET['perKey'], $_GET['comCode'], $info_sl['data']['infYear'], chr(ord(trim($apportion_list['data'][0]['appVer'])) + 1), '0', isset($_GET['appType']) && '2' != $_GET['appType'] ? 1 : $_GET['appType'], '-1');
                        }
                        else {
                            $apportion_ad = $ContractMgr->insertApportion($_GET['conId'], $_GET['perKey'], $_GET['comCode'], $info_sl['data']['infYear'], 'A', '0', $_GET['appType'], '-1');
                        }
                        $exes_list = $ContractMgr->queryExes('', $apportion_list['data'][0]['appId']);
                        for ($i = 0; $i < $exes_list['count']; $i++) {
                            $exes_ad = $ContractMgr->insertExes($apportion_ad, $exes_list['data'][$i]['iteId'], $exes_list['data'][$i]['exeTitle'], $exes_list['data'][$i]['exePM'], $exes_list['data'][$i]['exeSP'], $exes_list['data'][$i]['exeCost'], $exes_list['data'][$i]['exeCreateMonth'], $exes_list['data'][$i]['exeMonth'], $exes_list['data'][$i]['exeStartYear'], $exes_list['data'][$i]['exeNote'], $exes_list['data'][$i]['exeStatus']);
                            $annual_list = $ContractMgr->queryAnnual('', $exes_list['data'][$i]['exeId']);
                            for ($j = 0; $j < $annual_list['count']; $j++) {
                                $annual_ad = $ContractMgr->insertAnnual($exes_ad, $annual_list['data'][$j]['annYear'], $annual_list['data'][$j]['annStartMonth'], $annual_list['data'][$j]['annEndMonth'], $annual_list['data'][$j]['annMonth'], $annual_list['data'][$j]['annCost'], $annual_list['data'][$j]['annStatus']);
                                $subsidiary_list = $ContractMgr->querySubsidiary('', $annual_list['data'][$j]['annId']);
                                for ($k = 0; $k < $subsidiary_list['count']; $k++) {
                                    $subsidiary_ad = $ContractMgr->insertSubsidiary($annual_ad, $subsidiary_list['data'][$k]['comCode'], $subsidiary_list['data'][$k]['subAmount'], $subsidiary_list['data'][$k]['subPercent'], $subsidiary_list['data'][$k]['subCost']);
                                }
                            }
                        }
                    }
                    else {
                        $apportion_ad = $ContractMgr->insertApportion($_GET['conId'], $_GET['perKey'], $_GET['comCode'], $info_sl['data']['infYear'], 'A', '0', $_GET['appType'], '-1');
                    }
                    $contract_sl = $ContractMgr->queryContractByID('', $_GET['conId']);
                    if ($contract_sl['data']['conApp'] >= 0) {
                        if ('0' != $contract_sl['data']['conApp']) {
                            $ContractMgr->deleteSubsidiaryByApportionId($contract_sl['data']['conApp']);
                            $ContractMgr->deleteAnnualByApportionId($contract_sl['data']['conApp']);
                            $ContractMgr->deleteExesByApportionId($contract_sl['data']['conApp']);
                            $apportion_dl = $ContractMgr->deleteApportionByID($contract_sl['data']['conApp']);
                        }
                        $contract_lock_up = $ContractMgr->updateContractLockByID($_GET['conId'], 1);
                        $contract_up = $ContractMgr->updateContractAppByID($_GET['conId'], $apportion_ad);
                        $member_up_appId = $ContractMgr->updateMemberAppIdByConId($_GET['conId'], $apportion_ad);
                        $member_up = $ContractMgr->updateMemberByContractApportionDefault($_GET['conId'], $apportion_ad);
                    }
                    $return_data['appId'] = $apportion_ad;
                    $return_data['data'] = 'success';
                    break;
                default:
                    $return_data = FALSE;
                    break;
            }
            break;
        case 'apportionStatus': // todo: contractStatus 修改文件狀態
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'PUT':// todo: contract_status PUT[conId, conStatus, {conDate|null}] 修改文件狀態
                    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料
                    if (isset($data['appId'])) {
                        $apportion_up = $ContractMgr->updateApportionStatusByID($data['appId'], $data['appStatus'], $data['appDate']);
                        if ($contract_up) {
                            if ('2' == $data['conStatus']) {
                                $apportion_sl = $ContractMgr->queryApportionByID('', $data['appId']);
                                if ($apportion_sl['count'] > 0) {
                                    $apportion_copy = $ContractMgr->copyApportion($data['appId'], $apportion_sl['data']['appYear'], $apportion_sl['data']['appVer'], 0, 0);
                                    if ($apportion_copy) {
                                        $exes_list = $ContractMgr->queryExes('', $_GET['appId']);
                                        for ($i = 0; $i < $exes_list['count']; $i++) {
                                            $exes_ad = $ContractMgr->copyExesByID($exes_list['data'][$i]['exeId'], $apportion_copy);
                                            if ($exes_ad) {
                                                $annual_list = $ContractMgr->queryAnnual('', $exes_list['data'][$i]['exeId']);
                                                for ($j = 0; $j < $annual_list['count']; $j++) {
                                                    $ann_ad = $ContractMgr->copyAnnualByID($annual_list['data'][$j]['annId'], $exes_ad);
                                                    if ($ann_ad) {
                                                        $subsidiary_list = $ContractMgr->querySubsidiary('', $annual_list['data'][$j]['annId']);
                                                        for ($k = 0; $k < $subsidiary_list['count']; $k++) {
                                                            $subsidiary_ad = $ContractMgr->copySubsidiaryByID($subsidiary_list['data'][$k]['subId'], $ann_ad);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        $member_copy = $ContractMgr->copyMember('', '', $data['appId'], $apportion_copy);
                                        $apportion_sl = $ContractMgr->queryApportionByInh('', $_GET['conId']);
                                        if (0 < $apportion_sl['count']) {
                                            $apportion_inh_up = $ContractMgr->updateApportionInheritByID($apportion_sl['data']['appId'], $apportion_copy);
                                        }
                                    }
                                }
                                $apportion_mark_up = $ContractMgr->updateApportionMarkByID($data['appId'], '1');
                            }
                            if ('4' == $data['conStatus']) {
                                $apportion_inh_clean = $ContractMgr->cleanApportionInheritByID($data['appId']);
                            }
                            if (isset($data['sglLog'])) {
                                $log = json_decode($data['sglLog'], TRUE);
                                $ContractMgr->insertSignLog($log['conId'], $log['appId'], $log['memId'], $log['perKey'], $log['sglMemberStatus'], $log['sglMsg'], $log['sglStatus']);
                            }
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
                default:
                    $return_data = FALSE;
                    break;
            }
            break;
        case 'apportionClean':
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'DELETE':// todo: apportionId GET[conId] 取得[單一|全部]文件
                    if (isset($_GET['conId'])) {
                        $contract_sl = $ContractMgr->queryContactByID('', $_GET['conId']);
                        if (0 < $contract_sl['count'] && $contract_sl['data']['appId'] > 0) {
                            $ContractMgr->deleteSubsidiaryByApportionId($contract_sl['data']['appId']);
                            $ContractMgr->deleteAnnualByApportionId($contract_sl['data']['appId']);
                            $ContractMgr->deleteExesByApportionId($contract_sl['data']['appId']);
                        }
                    }
                    if (isset($_GET['appId'])) {
                        $ContractMgr->deleteSubsidiaryByApportionId($_GET['appId']);
                        $ContractMgr->deleteAnnualByApportionId($_GET['appId']);
                        $ContractMgr->deleteExesByApportionId($_GET['appId']);
                    }
                    $return_data['data'] = 'success';
                    break;
                default:
                    $return_data = FALSE;
                    break;
            }
            break;


        case 'item':
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET'://sl
                    $item_list = $ContractMgr->queryItem(NULL, $_GET['conId']);
                    $return_data['data'] = replaceArr($item_list['data']);
                    break;
            }
            break;

        case 'info':// todo: info 系統資訊設定
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: work GET[worId|null] 取得[單一|全部]作業種類
                    $info_sl = $ContractMgr->queryInfoByID(NULL, 1);
                    $return_data['data'] = $info_sl['data'];
                    break;
                case 'PUT':// todo: work PUT[worId, worTitle]修改作業種類
                    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料
                    $info_up = $ContractMgr->updateInfoByID(1, $data['infYear'], $data['infPM'], $data['infSP']);
                    if ($info_up) {
                        $return_data['data'] = 'success';
                    }
                    break;
            }
            break;

    }
    die(json_encode($return_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));


    function replaceString($str)
    {
        $parts = explode('_', $str); // 將字串以 '_' 分割為陣列
        if (count($parts) != 1) {
            $beforeString = strtolower($parts[0]); // 取得 '_' 前的部分
            $afterString = NULL;
            for ($i = 1; $i < count($parts); $i++) {
                $afterString .= $parts[$i];
            }
            $afterString = ucfirst(strtolower($afterString));
            $newString = $beforeString.$afterString;
            if (preg_match('/\d[a-zA-Z]/', $newString)) {
                $newString = preg_replace_callback('/(\d)([a-zA-Z])/', function ($matches) {
                    return $matches[1].ucfirst($matches[2]);
                }, $newString);
            }

            return $newString; // 返回結果
        }
        else {
            return $str;
        }
    }


    function replaceArr($arr)
    {
// 檢查陣列是否為一維
        if (is_array(reset($arr))) {
            // 二維陣列的處理
            foreach ($arr as &$subArr) {
                $subArr = replaceArr($subArr); // 遞迴處理子陣列
            }
        }
        else {
            // 一維陣列的處理
            $keys = array_keys($arr); // 取得陣列的鍵名
            foreach ($keys as $key) {
                $newKey = replaceString($key); // 使用前面定義的 replaceString 函數進行鍵名置換
                if ($newKey !== $key) {
                    $arr[$newKey] = $arr[$key]; // 新鍵名對應到舊值
                    unset($arr[$key]); // 刪除舊鍵名
                }
            }
        }

        return $arr;
    }

?>
