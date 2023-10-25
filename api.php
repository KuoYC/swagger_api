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
        case 'personnel': // todo: personnel 取得員工資訊
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: personnel GET[{keyword|null}|{perBu1Code|null}|{perBu2Code|null}|{perBu3Code|null}|{perKey|null}|{perEmail|null}|{perAccount|null}|{perNo|null}|{perPosition|null}} 取得員工資訊
                    $personnel_list = $ContractMgr->queryPersonnel(NULL, $_GET['keyword'], $_GET['perBu1Code'], $_GET['perBu2Code'], $_GET['perBu3Code'], $_GET['perKey'], $_GET['perEmail'], $_GET['perAccount'], $_GET['perNo'], $_GET['perPosition'], NULL, NULL);
                    $return_data['data'] = $personnel_list['data'];
                    break;
            }
            break;


        case 'personnel_group': // todo: personnel_group 從personnel取得部門與科部名稱
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: personnel_group GET[col, {perBu1Code|null}, {perBu2Code|null}] 從personnel取得部門與科部名稱 ps.col=1取得Bu1, col=2取得Bu2(perBu1Code必要), col=3取得Bu3(perBu1Code, perBu2Code必要)
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
                    $template_ad = $ContractMgr->insertTemplate($data['temTitle'], $data['temStyle']);
                    if ($template_ad) {
                        $return_data['temId'] = $template_ad;//回傳成功
                        $return_data['data'] = 'success';
                    }
                    break;
                case 'PUT':// todo: template PUT[temId, temTitle, temStyle]修改樣板
                    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料
                    if (isset($data['temId'])) {
                        $template_up = $ContractMgr->updateTemplateByID($data['temId'], $data['temTitle'], $data['temStyle']);
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
                            $return_data['data'] = $manner_sl['data'];
                        }
                    }
                    else {
                        $manner_list = $ContractMgr->queryManner(NULL, NULL, NULL, NULL);
                        $return_data['data'] = $manner_list['data'];
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
        case 'contract'://todo: contract 文件操作
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: contract GET[conId|{temId|comId|null}] 取得[單一|全部]文件
                    if (isset($_GET['conId'])) {
                        $contract_sl = $ContractMgr->queryContractByID(NULL, $_GET['conId']);
                        $return_data['count'] = $contract_sl['count'];
                        if (0 < $contract_sl['count']) {
                            $contract_sl['data']['conValue'] = htmlspecialchars_decode($contract_sl['data']['conValue']);
                            $contract_sl['data']['filePath'] = 'https://ju-house.com/upload/';
//                            $contract_sl['data']['filePath'] = 'http://www.api.ks/upload/';
                            $return_data['data'] = replaceArr($contract_sl['data']);
                        }
                    }
                    else {
                        if (isset($_GET['action'])) {
                            $rows = array('C.*', 'CM.*', 'P.*', 'T.*');
                            switch ($_GET['action']) {
                                case '0':// todo: contract GET[{action=0}|{temId|comId|comCode|conSerial|conStatus|null}|{perKey|perNo|perPosition|perBu1Code}] 取得文件-相關(發起, 退回, 待簽, 已簽)
                                    $contract_list = $ContractMgr->queryContractForAction0($rows, $_GET['temId'], $_GET['comId'], $_GET['comCode'], $_GET['conSerial'], $_GET['conStatus'], $_GET['perKey'], $_GET['perBu1Code'], NULL, NULL);
                                    break;
                                case '1':// todo: contract GET[{action=1}|{temId|comId|comCode|conSerial|null}|{perKey|perNo|perPosition|perBu1Code}] 取得文件-待檢視
                                    $contract_list = $ContractMgr->queryContractForAction1($rows, $_GET['temId'], $_GET['comId'], $_GET['comCode'], $_GET['conSerial'], $_GET['perKey'], $_GET['perBu1Code'], NULL, NULL);
                                    break;
                                case '2':// todo: contract GET[{action=2}|{temId|comId|comCode|conSerial|null}|{perKey|perNo|perPosition|perBu1Code}] 取得文件-待簽
                                    $contract_list = $ContractMgr->queryContractForAction2($rows, $_GET['temId'], $_GET['comId'], $_GET['comCode'], $_GET['conSerial'], $_GET['perKey'], $_GET['perBu1Code'], NULL, NULL);
                                    break;
                                case '3':// todo: contract GET[{action=3}|{temId|comId|comCode|conSerial|null}|{perKey|perNo|perPosition|perBu1Code}] 取得文件-等待(待檢視+待簽)
                                    $contract_list = $ContractMgr->queryContractForAction3($rows, $_GET['temId'], $_GET['comId'], $_GET['comCode'], $_GET['conSerial'], $_GET['perKey'], $_GET['perBu1Code'], NULL, NULL);
                                    break;
                                case '4':// todo: contract GET[{action=4}|{temId|comId|comCode|conSerial|null}|{perKey|perNo|perPosition|perBu1Code}] 取得文件-已簽
                                    $contract_list = $ContractMgr->queryContractForAction4($rows, $_GET['temId'], $_GET['comId'], $_GET['comCode'], $_GET['conSerial'], $_GET['perKey'], $_GET['perBu1Code'], NULL, NULL);
                                    break;
                                case '5':// todo: contract GET[{action=5}|{temId|comId|comCode|conSerial|conStatus|null}|{perKey|perNo|perPosition|perBu1Code}] 取得文件-全部相關
                                    $contract_list = $ContractMgr->queryContractForAction5($rows, $_GET['temId'], $_GET['comId'], $_GET['comCode'], $_GET['conSerial'], $_GET['perKey'], $_GET['conStatus'], $_GET['perBu1Code'], NULL, NULL);
                                    break;
                                case '6':// todo: contract GET[{action=6}|{temId|comId|comCode|conSerial|null}|{perKey|perNo|perPosition|perBu1Code}] 取得文件-完成
                                    $contract_list = $ContractMgr->queryContractForAction6($rows, $_GET['temId'], $_GET['comId'], $_GET['comCode'], $_GET['conSerial'], $_GET['perKey'], $_GET['perBu1Code'], NULL, NULL);
                                    break;
                                case '7':// todo: contract GET[{action=7}|{temId|comId|comCode|conSerial|null}|{perKey|perNo|perPosition|perBu1Code}] 取得文件-拒絕
                                    $contract_list = $ContractMgr->queryContractForAction7($rows, $_GET['temId'], $_GET['comId'], $_GET['comCode'], $_GET['conSerial'], $_GET['perKey'], $_GET['perBu1Code'], NULL, NULL);
                                    break;
                                case '8':// todo: contract GET[{action=8}|{temId|comId|comCode|conSerial|null}|{perKey|perNo|perPosition|perBu1Code}] 取得文件-完成或拒絕
                                    $contract_list = $ContractMgr->queryContractForAction8($rows, $_GET['temId'], $_GET['comId'], $_GET['comCode'], $_GET['conSerial'], $_GET['perKey'], $_GET['perBu1Code'], NULL, NULL);
                                    break;
                                default:
                                    $contract_list = $ContractMgr->queryContract(NULL, $_GET['temId'], $_GET['comId'], $_GET['comCode'], $_GET['comCode'], $_GET['conSerial'], $_GET['conStatus'], NULL, NULL);
                                    break;
                            }
                        }
                        else {
                            $contract_list = $ContractMgr->queryContract(NULL, $_GET['temId'], $_GET['comId'], $_GET['comCode'], $_GET['conSerial'], $_GET['conStatus'], NULL, NULL);
                        }
                        if ($contract_list['count'] > 0) {
                            for ($i = 0; $i < $contract_list['count']; $i++) {
                                $contract_list['data'][$i]['conValue'] = htmlspecialchars_decode($contract_list['data'][$i]['conValue']);
                                $contract_list['data'][$i]['conLog'] = htmlspecialchars_decode($contract_list['data'][$i]['conLog']);
                            }
                        }
                        $return_data['data'] = replaceArr($contract_list['data']);
                    }
                    break;
                case 'DELETE'://dl
                    if (isset($_GET['conId'])) {
                        $contract_dl = $ContractMgr->deleteContractByID($_GET['conId']);
                        if ($contract_dl) {
                            $return_data['data'] = 'success';
                        }
                    }
                default:
                    $return_data = FALSE;
                    break;
            }
            break;
        case 'contract_create'://todo: contract_create新增文件資料
            if ('POST' == $_SERVER['REQUEST_METHOD']) {
                $date = date('Ymd', time());
                $contract_list = $ContractMgr->queryContract(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
//                    $data = json_decode(file_get_contents('php://input'), TRUE);
                $conFileMeeting = NULL;
                if (isset($_FILES['conFileMeeting']) && is_array($_FILES['conFileMeeting']['name'])) {
                    $conFileMeetingFiles = $_FILES['conFileMeeting'];
                    // 遍歷每個conFileMeeting文件
                    for ($i = 0; $i < count($conFileMeetingFiles['name']); $i++) {
                        $file_name = $conFileMeetingFiles['name'][$i];
                        $file_tmp = $conFileMeetingFiles['tmp_name'][$i];

                        $original_extension = pathinfo($file_name, PATHINFO_EXTENSION);//取得副檔名
                        $timestamp = date('YmdHis');
                        $random_number = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
                        $new_file_name = $timestamp.$random_number.'.'.$original_extension;

                        $file_destination = 'upload/'.$new_file_name; // 指定上傳目錄和文件名
                        if (move_uploaded_file($file_tmp, $file_destination)) {
                            $conFileMeeting[] = $new_file_name;
                        }
                    }
                }
                if ($conFileMeeting && is_array($conFileMeeting)) {
                    $conFileMeeting = implode('|', $conFileMeeting);
                }
                $conFilePlan = NULL;
                if (isset($_FILES['conFilePlan']) && is_array($_FILES['conFilePlan']['name'])) {
                    $conFilePlanFiles = $_FILES['conFilePlan'];
                    // 遍歷每個conFilePlan文件
                    for ($i = 0; $i < count($conFilePlanFiles['name']); $i++) {
                        $file_name = $conFilePlanFiles['name'][$i];
                        $file_tmp = $conFilePlanFiles['tmp_name'][$i];

                        $original_extension = pathinfo($file_name, PATHINFO_EXTENSION);//取得副檔名
                        $timestamp = date('YmdHis');
                        $random_number = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
                        $new_file_name = $timestamp.$random_number.'.'.$original_extension;

                        $file_destination = 'upload/'.$new_file_name; // 指定上傳目錄和文件名
                        if (move_uploaded_file($file_tmp, $file_destination)) {
                            $conFilePlan[] = $new_file_name;
                        }
                    }
                }
                if ($conFilePlan && is_array($conFilePlan)) {
                    $conFilePlan = implode('|', $conFilePlan);
                }
                $conFile = NULL;
                if (isset($_FILES['conFile']) && is_array($_FILES['conFile']['name'])) {
                    $conFileFiles = $_FILES['conFile'];
                    // 遍歷每個conFile文件
                    for ($i = 0; $i < count($conFileFiles['name']); $i++) {
                        $file_name = $conFileFiles['name'][$i];
                        $file_tmp = $conFileFiles['tmp_name'][$i];

                        $original_extension = pathinfo($file_name, PATHINFO_EXTENSION);//取得副檔名
                        $timestamp = date('YmdHis');
                        $random_number = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
                        $new_file_name = $timestamp.$random_number.'.'.$original_extension;

                        $file_destination = 'upload/'.$new_file_name; // 指定上傳目錄和文件名
                        if (move_uploaded_file($file_tmp, $file_destination)) {
                            $conFile[] = $new_file_name;
                        }
                    }
                }
                if ($conFile && is_array($conFile)) {
                    $conFile = implode('|', $conFile);
                }

                $contract_ad = $ContractMgr->insertContract($_POST['temId'], $_POST['perKey'], $_POST['comCode'], $date.'-'.str_pad($contract_list['count'] + 1, 3, '0', STR_PAD_LEFT),
                                                            $_POST['conTitle'], $_POST['conType'], $_POST['conDate'], $_POST['conWork'], $_POST['conCompany'], $conFileMeeting, $conFilePlan, $conFile, $_POST['conValue'], NULL, 0);
                if ($contract_ad) {
                    if (isset($_POST['itemList']) && NULL != $_POST['itemList']) {
                        $_POST['itemList'] = json_decode(htmlspecialchars_decode($_POST['itemList']), TRUE);
                        //項目
                        foreach ($_POST['itemList'] as $ite) {
                            $item_ad = $ContractMgr->insertItem($contract_ad,
                                                                $ite['iteTitle'], $ite['worId'], $ite['iteTime'], $ite['iteSubsidiaries'], $ite['iteControl'],
                                                                $ite['disId'], $ite['manId'], $ite['iteProportion'], $ite['iteTypeNote'], $ite['iteDescription'],
                                                                NULL, NULL, NULL, $ite['iteWord'], $ite['iteNote']);
                        }
                    }
                    if (isset($_POST['memberList']) && NULL != $_POST['memberList']) {
                        $_POST['memberList'] = json_decode(htmlspecialchars_decode($_POST['memberList']), TRUE);
                        foreach ($_POST['memberList'] as $mbr) {
                            $member_ad = $ContractMgr->insertMember($contract_ad, $mbr['memType'], $mbr['memBu1Code'], $mbr['memBu2Code'], $mbr['memBu2'], $mbr['memBu3Code'], $mbr['memBu3'],
                                                                    $mbr['memLV0Key'], $mbr['memLV0Name'], $mbr['memLV0PositionName'],
                                                                    $mbr['memLVCKey'], $mbr['memLVCName'], $mbr['memLVCPositionName'],
                                                                    $mbr['memLV1Key'], $mbr['memLV1Name'], $mbr['memLV1PositionName'],
                                                                    $mbr['memLV2Key'], $mbr['memLV2Name'], $mbr['memLV2PositionName'],
                                                                    $mbr['memPhone'], NULL);
                        }
                    }
                    $return_data['conId'] = $contract_ad;
                    $return_data['data'] = 'success';
                }
            }
            break;
        case 'contract_update'://todo: contract_update修改文件資料
            if ('POST' == $_SERVER['REQUEST_METHOD']) {
                $contract_sl = $ContractMgr->queryContractByID(NULL, $_POST['conId']);
                if (0 < $contract_sl['count']) {
                    $conFileMeeting = explode('|', $contract_sl['data']['conFileMeeting']);
                    if (isset($_POST['delFileMeeting']) && NULL != $_POST['delFileMeeting']) {
                        $delFileMeeting = explode('|', $_POST['delFileMeeting']);
                        $conFileMeeting = array_diff($conFileMeeting, $delFileMeeting);
                    }
                    if (isset($_FILES['conFileMeeting']) && is_array($_FILES['conFileMeeting']['name'])) {
                        $conFileMeetingFiles = $_FILES['conFileMeeting'];
                        // 遍歷每個conFileMeeting文件
                        for ($i = 0; $i < count($conFileMeetingFiles['name']); $i++) {
                            $file_name = $conFileMeetingFiles['name'][$i];
                            $file_tmp = $conFileMeetingFiles['tmp_name'][$i];

                            $original_extension = pathinfo($file_name, PATHINFO_EXTENSION);//取得副檔名
                            $timestamp = date('YmdHis');
                            $random_number = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
                            $new_file_name = $timestamp.$random_number.'.'.$original_extension;

                            $file_destination = 'upload/'.$new_file_name; // 指定上傳目錄和文件名
                            if (move_uploaded_file($file_tmp, $file_destination)) {
                                $conFileMeeting[] = $new_file_name;
                            }
                        }
                    }
                    if ($conFileMeeting && is_array($conFileMeeting)) {
                        $conFileMeeting = implode('|', $conFileMeeting);
                    }
                    $conFilePlan = explode('|', $contract_sl['data']['conFilePlan']);
                    if (isset($_POST['delFilePlan']) && NULL != $_POST['delFilePlan']) {
                        $delFilePlan = explode('|', $_POST['delFilePlan']);
                        $conFilePlan = array_diff($conFilePlan, $delFilePlan);
                    }
                    if (isset($_FILES['conFilePlan']) && is_array($_FILES['conFilePlan']['name'])) {
                        $conFilePlanFiles = $_FILES['conFilePlan'];
                        // 遍歷每個conFilePlan文件
                        for ($i = 0; $i < count($conFilePlanFiles['name']); $i++) {
                            $file_name = $conFilePlanFiles['name'][$i];
                            $file_tmp = $conFilePlanFiles['tmp_name'][$i];

                            $original_extension = pathinfo($file_name, PATHINFO_EXTENSION);//取得副檔名
                            $timestamp = date('YmdHis');
                            $random_number = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
                            $new_file_name = $timestamp.$random_number.'.'.$original_extension;

                            $file_destination = 'upload/'.$new_file_name; // 指定上傳目錄和文件名
                            if (move_uploaded_file($file_tmp, $file_destination)) {
                                $conFilePlan[] = $new_file_name;
                            }
                        }
                    }
                    if ($conFilePlan && is_array($conFilePlan)) {
                        $conFilePlan = implode('|', $conFilePlan);
                    }
                    $conFile = explode('|', $contract_sl['data']['conFile']);
                    if (isset($_POST['delFile']) && NULL != $_POST['delFile']) {
                        $delFile = explode('|', $_POST['delFile']);
                        $conFile = array_diff($conFile, $delFile);
                    }
                    if (isset($_FILES['conFile']) && is_array($_FILES['conFile']['name'])) {
                        $conFileFiles = $_FILES['conFile'];
                        // 遍歷每個conFile文件
                        for ($i = 0; $i < count($conFileFiles['name']); $i++) {
                            $file_name = $conFileFiles['name'][$i];
                            $file_tmp = $conFileFiles['tmp_name'][$i];

                            $original_extension = pathinfo($file_name, PATHINFO_EXTENSION);//取得副檔名
                            $timestamp = date('YmdHis');
                            $random_number = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
                            $new_file_name = $timestamp.$random_number.'.'.$original_extension;

                            $file_destination = 'upload/'.$new_file_name; // 指定上傳目錄和文件名
                            if (move_uploaded_file($file_tmp, $file_destination)) {
                                $conFile[] = $new_file_name;
                            }
                        }
                    }
                    if ($conFile && is_array($conFile)) {
                        $conFile = implode('|', $conFile);
                    }
                    $contract_up = $ContractMgr->updateContractByID($_POST['conId'], $_POST['conTitle'], $_POST['conType'], $_POST['conDate'], $_POST['conWork'], $_POST['conCompany'], $conFileMeeting, $conFilePlan, $conFile, $_POST['conValue']);
                    if ($contract_up) {
                        if ($delFileMeeting) {
                            foreach ($delFileMeeting as $v) {
                                if (file_exists('upload/'.$v)) {
                                    unlink('upload/'.$v);
                                }
                            }
                        }
                        if ($delFilePlan) {
                            foreach ($delFilePlan as $v) {
                                if (file_exists('upload/'.$v)) {
                                    unlink('upload/'.$v);
                                }
                            }
                        }
                        if ($delFile) {
                            foreach ($delFile as $v) {
                                if (file_exists('upload/'.$v)) {
                                    unlink('upload/'.$v);
                                }
                            }
                        }

                        if (isset($_POST['itemList']) && NULL != $_POST['itemList']) {
                            $_POST['itemList'] = json_decode($_POST['itemList'], TRUE);
                            $iteId_list = NULL;
                            foreach ($_POST['itemList'] as $ite) {
                                $iteId_list[] = $ite['iteId'];
                            }
                            $item_list = $ContractMgr->queryItem(array('I.`iteId`'), $_POST['conId']);
                            $o_iteId_list = NULL;
                            foreach ($item_list['data'] as $ite) {
                                $o_iteId_list[] = $ite['iteId'];
                            }
                            $dl_iteId_list = array_diff($o_iteId_list, $iteId_list);

                            if (0 < count($dl_iteId_list)) {
                                $item_dl = $ContractMgr->deleteItemByContract($_POST['conId'], $dl_iteId_list);
                            }
                            foreach ($_POST['itemList'] as $ite) {
                                if ($ite['iteId']) {
                                    $item_up = $ContractMgr->updateItem($ite['iteId'], $_POST['conId'], $ite['iteTitle'], $ite['worId'], $ite['iteTime'], $ite['iteSubsidiaries'], $ite['iteControl'],
                                                                        $ite['disId'], $ite['manId'], $ite['iteProportion'], $ite['iteTypeNote'], $ite['iteDescription'],
                                                                        NULL, NULL, NULL, $ite['iteWord'], $ite['iteNote']);
                                }
                                else {
                                    $item_ad = $ContractMgr->insertItem($_POST['conId'],
                                                                        $ite['iteTitle'], $ite['worId'], $ite['iteTime'], $ite['iteSubsidiaries'], $ite['iteControl'],
                                                                        $ite['disId'], $ite['manId'], $ite['iteProportion'], $ite['iteTypeNote'], $ite['iteDescription'],
                                                                        NULL, NULL, NULL, $ite['iteWord'], $ite['iteNote']);
                                }
                            }
                        }
                        if (isset($_POST['memberList']) && is_array($_POST['memberList'])) {
                            $_POST['memberList'] = json_decode(htmlspecialchars_decode($_POST['memberList']), TRUE);
                            $memId_list = NULL;
                            foreach ($_POST['memberList'] as $mbr) {
                                $memId_list[] = $mbr['memId'];
                            }
                            $member_list = $ContractMgr->queryMember(array('M.`memId`'), $_POST['conId'], NULL);
                            $o_memId_list = NULL;
                            foreach ($member_list['data'] as $mbr) {
                                $o_memId_list[] = $mbr['memId'];
                            }
                            $dl_memId_list = array_diff($o_memId_list, $memId_list);

                            if (0 < count($dl_memId_list)) {
                                $member_dl = $ContractMgr->deleteMemberByContract($_POST['conId'], $dl_memId_list);
                            }
                            foreach ($_POST['memberList'] as $mbr) {
                                if ($mbr['memId'] && '0' != $mbr['memId']) {
                                    $member_up = $ContractMgr->updateMemberByID($mbr['memId'], $mbr['memType'], $mbr['memBu1Code'], $mbr['memBu2Code'], $mbr['memBu2'], $mbr['memBu3Code'], $mbr['memBu3'],
                                                                                $mbr['memLV0Key'], $mbr['memLV0Name'], $mbr['memLV0PositionName'],
                                                                                $mbr['memLVCKey'], $mbr['memLVCName'], $mbr['memLVCPositionName'],
                                                                                $mbr['memLV1Key'], $mbr['memLV1Name'], $mbr['memLV1PositionName'],
                                                                                $mbr['memLV2Key'], $mbr['memLV2Name'], $mbr['memLV2PositionName'],
                                                                                $mbr['memPhone'], NULL);
                                }
                                else {
                                    $member_ad = $ContractMgr->insertMember($_POST['conId'], $mbr['memType'], $mbr['memBu1Code'], $mbr['memBu2Code'], $mbr['memBu2'], $mbr['memBu3Code'], $mbr['memBu3'],
                                                                            $mbr['memLV0Key'], $mbr['memLV0Name'], $mbr['memLV0PositionName'],
                                                                            $mbr['memLVCKey'], $mbr['memLVCName'], $mbr['memLVCPositionName'],
                                                                            $mbr['memLV1Key'], $mbr['memLV1Name'], $mbr['memLV1PositionName'],
                                                                            $mbr['memLV2Key'], $mbr['memLV2Name'], $mbr['memLV2PositionName'],
                                                                            $mbr['memPhone'], NULL);
                                }
                            }
                        }
                        $return_data['data'] = 'success';
                    }
                }
            }
            break;
        case 'contract_status': // todo: contract_status 修改文件狀態
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'PUT':// todo: contract_status PUT[conId, conStatus, {conDate|null}] 修改文件狀態
                    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料

                    if (isset($data['conId'])) {
                        $contract_up = $ContractMgr->updateContractStatusByID($data['conId'], $data['conStatus'], $data['conDate']);
                        if ($contract_up) {
                            $ContractMgr->updateContractLogByID($data['conId'], $data['conLogMsg']);
                            $return_data['data'] = 'success';
                        }
                    }
                    break;
                default:
                    $return_data = FALSE;
                    break;
            }
            break;
        case 'contract_default':// todo: contract_default 重置文件狀態
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
        case 'contract_member':// todo: contract_member 取得文件相關的所有簽核名單
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':// todo: contract_member GET[conId, {memType|null}]
                    $member_list = $ContractMgr->queryMember(NULL, $_GET['conId'], $_GET['memType']);
                    $return_data['data'] = replaceArr($member_list['data']);
                    break;
            }
            break;
        case 'member_status'://todo:member_status簽核人員資料修改
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'PUT'://up
                    $data = json_decode(file_get_contents('php://input'), TRUE);
                    $member_up = $ContractMgr->updateMemberStatus($data['memId'], $data['memLV0Status'], $data['memLV0Time'], $data['memLV0Msg'], $data['memLVCKey'], $data['memLVCName'], $data['memLVCPositionName'], $data['memLVCStatus'], $data['memLVCTime'], $data['memLV1Status'], $data['memLV1Time'], $data['memLV1Msg'], $data['memLV2Status'], $data['memLV2Time'], $data['memLV2Msg'], $data['memNowKey'], $data['memNowStatus'], $data['memStatus']);
                    $contract_update_time = $ContractMgr->updateContractUpdateTimeByID($data['conId']);
                    if ($member_up) {
                        if (isset($data['conLogMsg'])) {
                            $ContractMgr->updateContractLogByID($data['conId'], $data['conLogMsg']);
                        }
                        if (isset($data['conLogMsgNext'])) {
                            $ContractMgr->updateContractLogByID($data['conId'], $data['conLogMsgNext']);
                        }
                        $return_data['data'] = 'success';
                    }
                    break;
                default:
                    $return_data = FALSE;
                    break;
            }
            break;
        case 'member_status_all'://todo:member_status_all所有簽核人員資料修改
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'PUT'://up
                    $data = json_decode(file_get_contents('php://input'), TRUE);
                    $member_up = $ContractMgr->updateMemberStatusAll($data['conId'], $data['memNowKey'], $data['memNowStatus']);
                    if ($member_up) {
                        $return_data['data'] = 'success';
                    }
                    break;
                default:
                    $return_data = FALSE;
                    break;
            }
            break;
        case 'contract_item':// todo: contract_item 取得文件相關的所有作業項目
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


        case 'personnel_purview':
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
        case 'admin_login':// todo: admin 管理員登入
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


        case 'item':
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET'://sl
                    $item_list = $ContractMgr->queryItem(NULL, $_GET['conId']);
                    $return_data['data'] = replaceArr($item_list['data']);
                    break;
            }
            break;


        case 'search_source':
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET'://sl
                    $contract_template_list = $ContractMgr->querySearchSource(NULL);
                    $return_data['data'] = replaceArr($contract_template_list['data']);
                    break;
            }
            break;
        case 'contract_item_subsidiary':
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET'://sl
                    $item_subsidiary_list = $ContractMgr->queryItemSubsidiary(NULL, $_GET['ctId'], $_GET['ctiId']);
                    $return_data['data'] = replaceArr($item_subsidiary_list['data']);
                    break;
            }
            break;
        case 'contract_item_report':
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET'://sl

                    $item_report_list = $ContractMgr->queryItemReport($_GET['ctStatus']);
                    $return_data['data'] = replaceArr($item_report_list['data']);
                    break;
            }
            break;
        case 'contract_exes_year':
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET'://sl
                    $exes_year = NULL;
                    $exes_year_list = $ContractMgr->queryExesYear();
                    for ($i = 0; $i < $exes_year_list['count']; $i++) {
                        $exes_year[] = $exes_year_list['data'][$i]['CIES_YEAR'];
                    }
                    $return_data['data'] = replaceArr($exes_year);
                    break;
            }
            break;
        case 'contract_item_exes':
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET'://sl
                    $item_exes_list = $ContractMgr->queryItemExesByItem($_GET['ctStatus']);
                    $return_data['data'] = replaceArr($item_exes_list['data']);
                    break;
            }
            break;
        case 'contract_exes':
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET'://sl
                    $exes_list = $ContractMgr->queryExes($_GET['ctStatus']);
                    $return_data['data'] = replaceArr($exes_list['data']);
                    break;
            }
            break;
        case 'item_exes':
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET'://sl
                    $rows = array('CIE.*');
                    $exes_list = $ContractMgr->queryItemExes($rows, $_GET['ctId']);
                    $return_data['data'] = replaceArr($exes_list['data']);
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
