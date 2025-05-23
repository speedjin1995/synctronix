<?php

require_once 'db_connect.php';
require_once 'requires/lookup.php';
session_start();

$searchQuery = "";
$group1 = "";
$group2 = "";
$group3 = "";

if($_SESSION["roles"] != 'ADMIN' && $_SESSION["roles"] != 'SADMIN'){
    $username = implode("', '", $_SESSION["plant"]);
    $searchQuery = "and plant_code IN ('$username')";
}

if(isset($_POST['fromDate']) && $_POST['fromDate'] != null && $_POST['fromDate'] != ''){
    $dateTime = DateTime::createFromFormat('d-m-Y H:i', $_POST['fromDate']);
    $formatted_date = $dateTime->format('Y-m-d H:i');
    $fromDate = $dateTime->format('d/m/Y');
    $searchQuery .= " and Weight.tare_weight1_date >= '".$formatted_date."'";
}

if(isset($_POST['toDate']) && $_POST['toDate'] != null && $_POST['toDate'] != ''){
    $dateTime = DateTime::createFromFormat('d-m-Y H:i', $_POST['toDate']);
    $formatted_date = $dateTime->format('Y-m-d H:i');
    $toDate = $dateTime->format('d/m/Y');
    $searchQuery .= " and Weight.tare_weight1_date <= '".$formatted_date."'";
}

if(isset($_POST['status']) && $_POST['status'] != null && $_POST['status'] != '' && $_POST['status'] != '-'){
    $searchQuery .= " and Weight.transaction_status = '".$_POST['status']."'";	
}

if(isset($_POST['customer']) && $_POST['customer'] != null && $_POST['customer'] != '' && $_POST['customer'] != '-'){
    $searchQuery .= " and Weight.customer_code = '".$_POST['customer']."'";
}

if(isset($_POST['supplier']) && $_POST['supplier'] != null && $_POST['supplier'] != '' && $_POST['supplier'] != '-'){
    $searchQuery .= " and Weight.supplier_code = '".$_POST['supplier']."'";
}

if(isset($_POST['vehicle']) && $_POST['vehicle'] != null && $_POST['vehicle'] != '' && $_POST['vehicle'] != '-'){
    $searchQuery .= " and Weight.lorry_plate_no1 = '".$_POST['vehicle']."'";
}

if(isset($_POST['weighingType']) && $_POST['weighingType'] != null && $_POST['weighingType'] != '' && $_POST['weighingType'] != '-'){
    $searchQuery .= " and Weight.weight_type like '%".$_POST['weighingType']."%'";
}

if(isset($_POST['customerType']) && $_POST['customerType'] != null && $_POST['customerType'] != '' && $_POST['customerType'] != '-'){
    $searchQuery .= " and Weight.customer_type like '%".$_POST['customerType']."%'";
}

if(isset($_POST['product']) && $_POST['product'] != null && $_POST['product'] != '' && $_POST['product'] != '-'){
    $searchQuery .= " and Weight.product_code = '".$_POST['product']."'";
}

if(isset($_POST['rawMat']) && $_POST['rawMat'] != null && $_POST['rawMat'] != '' && $_POST['rawMat'] != '-'){
    $searchQuery .= " and Weight.raw_mat_code = '".$_POST['rawMat']."'";
}

if(isset($_POST['destination']) && $_POST['destination'] != null && $_POST['destination'] != '' && $_POST['destination'] != '-'){
    $searchQuery .= " and Weight.destination = '".$_POST['destination']."'";
}

if(isset($_POST['plant']) && $_POST['plant'] != null && $_POST['plant'] != '' && $_POST['plant'] != '-'){
    $searchQuery .= " and Weight.plant_code = '".$_POST['plant']."'";
}

if(isset($_POST['group1']) && $_POST['group1'] != null && $_POST['group1'] != '' && $_POST['group1'] != '-'){
    $group1 = $_POST['group1'];
}

if(isset($_POST['group2']) && $_POST['group2'] != null && $_POST['group2'] != '' && $_POST['group2'] != '-'){
    $group2 = $_POST['group2'];
}

if(isset($_POST['group3']) && $_POST['group3'] != null && $_POST['group3'] != '' && $_POST['group3'] != '-'){
    $group3 = $_POST['group3'];
}

function rearrangeList(array $records, array $filteredGroupKeys): array {
    $grouped = [];

    foreach ($records as $record) {
        $ref = &$grouped;

        // Add grouping levels based on provided groupKeys
        foreach ($filteredGroupKeys as $key) {
            if (empty($record[$key])) {
                continue; // skip empty group value
            }

            $keyValue = $record[$key];

            if (!isset($ref[$keyValue])) {
                $ref[$keyValue] = [];
            }

            $ref = &$ref[$keyValue];
        }

        // Always group by transaction_date (formatting optional)
        $dateKey = convertDatetimeToDate($record['transaction_date']) ?? 'UNKNOWN_DATE';

        if (!isset($ref[$dateKey])) {
            $ref[$dateKey] = [];
        }

        $ref[$dateKey][] = $record;

        unset($ref); // break reference
    }

    return $grouped;
}

function addToHeaderGroup(&$headerGroup, $groupKey, $value) {
    if (!isset($headerGroup[$groupKey])) {
        $headerGroup[$groupKey] = [];
    }

    if (!in_array($value, $headerGroup[$groupKey])) {
        $headerGroup[$groupKey][] = $value;
    }
}

function callLookup($group, $groupValue, $db){
    $value = '';
    switch ($group) {
        case 'Customer':
            $value = searchCustomerByCode($groupValue, $db);
            break;
        case 'Supplier':
            $value = searchSupplierByCode($groupValue, $db);
            break;
        case 'Product':
            $value = searchProductNameByCode($groupValue, $db);
            break;
        case 'Raw Material':
            $value = searchRawNameByCode($groupValue, $db);
            break;
        case 'Vehicle':
            $value = $groupValue;
            break;
        case 'Destination':
            $value = searchDestinationNameByCode($groupValue, $db);
            break;
        case 'Transporter':
            $value = searchTransporterNameByCode($groupValue, $db);
            break;
        case 'Plant':
            $value = searchPlantNameByCode($groupValue, $db);
            break;
    }
    
    return $value;
}

if(isset($_POST["type"])){
    if($_POST["type"] == 'Sales'){
        if ($select_stmt = $db->prepare("select * from Weight WHERE is_complete = 'Y' AND  is_cancel <> 'Y'".$searchQuery.' ORDER BY tare_weight1_date')) {
            // Execute the prepared query.
            if (! $select_stmt->execute()) {
                echo json_encode(
                    array(
                        "status" => "failed",
                        "message" => "Something went wrong"
                    )); 
            }
            else{
                $result = $select_stmt->get_result();
                $weightData = [];
                while ($row = $result->fetch_assoc()) {
                    // Replace all null values with ''
                    $cleanedRow = array_map(function($value) {
                        return $value === null ? '' : $value;
                    }, $row);

                    $weightData[] = $cleanedRow;
                }

                $groupList = [
                    $group1, $group2, $group3                    
                ];

                // Clean groupKeys to remove any empty values
                $filteredGroupKeys = array_filter($groupList, fn($key) => !empty($key));
                $groupBy = "";
                $groupOrder = [];
                if (empty($filteredGroupKeys)){
                    $groupBy = 'Date';
                }else{
                    foreach ($filteredGroupKeys as $group) {
                        switch ($group) {
                            case 'customer_code':
                                $groupBy .= '/Customer';
                                $groupOrder[] = 'Customer';
                                break;
                            case 'product_code':
                                $groupBy .= '/Product';
                                $groupOrder[] = 'Product';
                                break;
                            case 'lorry_plate_no1':
                                $groupBy .= '/Vehicle';
                                $groupOrder[] = 'Vehicle';
                                break;
                            case 'destination_code':
                                $groupBy .= '/Destination';
                                $groupOrder[] = 'Destination';
                                break;
                            case 'transporter_code':
                                $groupBy .= '/Transporter';
                                $groupOrder[] = 'Transporter';
                                break;
                            case 'plant_code':
                                $groupBy .= '/Plant';
                                $groupOrder[] = 'Plant';
                                break;
                        }
                    }
                }
                $groupBy = ltrim($groupBy, '/');

                $processedData = rearrangeList($weightData, $filteredGroupKeys);

                ################################################## Header Processing ##################################################
                $headerGrouping = [];
                $defaultGroups = ['Customer', 'Product', 'Vehicle', 'Destination', 'Transporter', 'Plant']; // Default group keys
                // Initialize $headerGrouping with empty arrays
                foreach ($defaultGroups as $group) {
                    $headerGroup[$group] = [];
                }

                if (count($groupOrder) > 0){
                    foreach ($processedData as $grp1 => $grp1Data) {
                        # Group 1 Header Processing
                        if (in_array($groupOrder[0], $defaultGroups)) {
                            addToHeaderGroup($headerGroup, $groupOrder[0], $grp1);
                        }
    
                        if(count($groupOrder) > 1 && !empty($grp1Data)){
                            foreach ($grp1Data as $grp2 => $grp2Data) {
                                # Group 2 Header Processing
                                if (in_array($groupOrder[1], $defaultGroups)) {
                                    addToHeaderGroup($headerGroup, $groupOrder[1], $grp2);
                                }
    
                                if(count($groupOrder) > 2 && !empty($grp2Data)){
                                    foreach ($grp2Data as $grp3 => $grp3Data) {
                                        # Group 3 Header Processing
                                        if (in_array($groupOrder[2], $defaultGroups)) {
                                            addToHeaderGroup($headerGroup, $groupOrder[2], $grp3);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                
                ################################################## Row Processing ##################################################
                $groupCount = count($filteredGroupKeys)+1; // Add 1 for date group
                $compiledRowData = '';
                if($groupCount == 1){ 
                    $grpNettWeight = 0;
                    $totalNettWeight = 0;
                    $grpTotalCount = 0;

                    foreach ($processedData as $date => $grpData) { 
                        $rowData = '
                            <tr>
                                <td colspan="17" style="border:0; padding-bottom: 0;">
                                    <div class="fw-bold">
                                        <span>
                                            Date <span>:</span> '.$date.'
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        ';

                        foreach ($grpData as $data){ 
                            $grpNettWeight += $data['nett_weight1']/1000; 
                            if ($data['ex_del'] == 'EX'){
                                $exDel = 'E';
                            }else{
                                $exDel = 'D';
                            }

                            $rowData .= '<tr class="details">
                                <td>'.$data['transaction_id'].'</td>
                                <td>'.$data['transporter_code'].'</td>
                                <td>'.$data['lorry_plate_no1'].'</td>
                                <td>'.$data['agent_code'].'</td>
                                <td>'.date("d/m/Y", strtotime($data['transaction_date'])).'</td>
                                <td width="10%">'.$data['purchase_order'].'</td>
                                <td class="text-end">'.date("H:i", strtotime($data['gross_weight1_date'])).'</td>
                                <td class="text-end">'.date("H:i", strtotime($data['tare_weight1_date'])).'</td>
                                <td class="text-end">'.($data['gross_weight1']/1000).'</td>
                                <td class="text-end">'.($data['tare_weight1']/1000).'</td>
                                <td class="text-end">'.($data['nett_weight1']/1000).'</td>
                                <td class="text-end">0.00</td>
                                <td class="text-end">0.00</td>
                                <td class="text-end">0.00</td>
                                <td class="text-end">0.00</td>
                                <td class="text-end">0.00</td>
                                <td>'.$exDel.'</td>
                                <td>'.searchNamebyId($data['created_by'], $db).'</td>
                            </tr>';                
                        }

                        $rowData .= '
                            <tr class="details fw-bold">
                                <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">Date Total : '.$date.'</td>
                                <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.count($grpData).'</td>
                                <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grpNettWeight.'</td>
                                <td></td>
                                <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            </tr>
                            <tr style="height: 18.5px;"></tr>
                        ';
                        
                        // Append this row block to full HTML
                        $compiledRowData .= $rowData;

                        $grpTotalCount += count($grpData);
                        $totalNettWeight += $grpNettWeight;
                    }

                    $compiledRowData .= '
                        <tr class="details fw-bold">
                            <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">Company Total : </td>
                            <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grpTotalCount.'</td>
                            <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$totalNettWeight.'</td>
                            <td></td>
                            <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                        </tr>
                        <tr style="height: 18.5px;"></tr>         
                    ';
                }elseif ($groupCount == 2) { 
                    $grpTotalCount = 0;
                    $dateNettWeight = 0;
                    $totalNettWeight = 0;
                    foreach ($processedData as $grp1 => $grp1Data) { 
                        $rowData = '
                            <tr>
                                <td colspan="17" style="border:0; padding-bottom: 0;">
                                    <div class="fw-bold">
                                        <span>
                                            '.$groupOrder[0].' <span>:</span> '.$grp1.' &nbsp;&nbsp;&nbsp;&nbsp; '.callLookup($groupOrder[0], $grp1, $db).'
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        '; 
                        $grp1Records = 0;
                        $grp1NettWeight = 0;
                        foreach ($grp1Data as $date => $dateData){
                            $rowData .= '
                                <tr>
                                    <td colspan="17" style="border:0; padding-bottom: 0;">
                                        <div class="fw-bold">
                                            <span>
                                                Date <span>:</span> '.$date.'
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            '; 

                            foreach ($dateData as $data){
                                $dateNettWeight += $data['nett_weight1']/1000;
                                if ($data['ex_del'] == 'EX'){
                                    $exDel = 'E';
                                }else{
                                    $exDel = 'D';
                                }

                                $rowData .= '<tr class="details">
                                    <td>'.$data['transaction_id'].'</td>
                                    <td>'.$data['transporter_code'].'</td>
                                    <td>'.$data['lorry_plate_no1'].'</td>
                                    <td>'.$data['agent_code'].'</td>
                                    <td>'.date("d/m/Y", strtotime($data['transaction_date'])).'</td>
                                    <td width="10%">'.$data['purchase_order'].'</td>
                                    <td class="text-end">'.date("H:i", strtotime($data['gross_weight1_date'])).'</td>
                                    <td class="text-end">'.date("H:i", strtotime($data['tare_weight1_date'])).'</td>
                                    <td class="text-end">'.($data['gross_weight1']/1000).'</td>
                                    <td class="text-end">'.($data['tare_weight1']/1000).'</td>
                                    <td class="text-end">'.($data['nett_weight1']/1000).'</td>
                                    <td class="text-end">0.00</td>
                                    <td class="text-end">0.00</td>
                                    <td class="text-end">0.00</td>
                                    <td class="text-end">0.00</td>
                                    <td class="text-end">0.00</td>
                                    <td>'.$exDel.'</td>
                                    <td>'.searchNamebyId($data['created_by'], $db).'</td>
                                </tr>';                
                            }

                            $rowData .= '
                                <tr class="details fw-bold">
                                    <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">Date Total : '.$date.'</td>
                                    <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.count($dateData).'</td>
                                    <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$dateNettWeight.'</td>
                                    <td></td>
                                    <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                    <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                    <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                </tr>
                                <tr style="height: 18.5px;"></tr>      
                            ';

                            $grp1Records += count($dateData);
                            $grp1NettWeight += $dateNettWeight;
                        }

                        $rowData .= '
                            <tr class="details fw-bold">
                                <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$groupOrder[0].' Total : '.callLookup($groupOrder[0], $grp1, $db).'</td>
                                <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp1Records.'</td>
                                <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp1NettWeight.'</td>
                                <td></td>
                                <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            </tr>
                            <tr style="height: 18.5px;"></tr>   
                        ';
                        
                        // Append this row block to full HTML
                        $compiledRowData .= $rowData;

                        $grpTotalCount += $grp1Records;
                        $totalNettWeight += $grp1NettWeight;
                    }

                    $compiledRowData .= '
                        <tr class="details fw-bold">
                            <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">Company Total : </td>
                            <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grpTotalCount.'</td>
                            <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$totalNettWeight.'</td>
                            <td></td>
                            <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                        </tr>
                    ';
                }elseif ($groupCount == 3) {
                    $companyCount = 0;
                    $companyNettWeight = 0;
                    $grp2Count = [];
                    $grp2NettWeight = [];
                    
                    foreach ($processedData as $grp1 => $grp1Data){
                        $rowData = '
                            <tr>
                                <td colspan="17" style="border:0; padding-bottom: 0;">
                                    <div class="fw-bold">
                                        <span>
                                            '.$groupOrder[0].' <span>:</span> '.$grp1.' &nbsp;&nbsp;&nbsp;&nbsp; '.callLookup($groupOrder[0], $grp1, $db).'
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        '; 

                        $grp1Count = 0;
                        $grp1NettWeight = 0;
                        foreach ($grp1Data as $grp2 => $grp2Data){
                            $rowData .= '
                                <tr>
                                    <td colspan="17" style="border:0; padding-top: 0; padding-bottom: 0;">
                                        <div class="fw-bold">
                                            <span>
                                                '.$groupOrder[1].' <span>:</span> '.$grp2.' &nbsp;&nbsp;&nbsp;&nbsp; '.callLookup($groupOrder[1], $grp2, $db).'
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            '; 

                            $grp2Count[$grp2] = 0;
                            $grp2NettWeight[$grp2] = 0;

                            foreach ($grp2Data as $grp3 => $grp3Data){ 
                                $grp2Count[$grp2] += count($grp3Data);

                                $rowData .= '
                                    <tr>
                                        <td colspan="17" style="border:0; padding-top: 0; padding-bottom: 0;">
                                            <div class="fw-bold">
                                                <span>
                                                Date <span>:</span> '.$grp3.'
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                '; 

                                $dateNettWeight = 0;
                                foreach ($grp3Data as $data){ 
                                    $grp1Count++;
                                    $dateNettWeight += $data['nett_weight1']/1000; 
                                    if ($data['ex_del'] == 'EX'){
                                        $exDel = 'E';
                                    }else{
                                        $exDel = 'D';
                                    }
    
                                    $rowData .= '<tr class="details">
                                        <td>'.$data['transaction_id'].'</td>
                                        <td>'.$data['transporter_code'].'</td>
                                        <td>'.$data['lorry_plate_no1'].'</td>
                                        <td>'.$data['agent_code'].'</td>
                                        <td>'.date("d/m/Y", strtotime($data['transaction_date'])).'</td>
                                        <td width="10%">'.$data['purchase_order'].'</td>
                                        <td class="text-end">'.date("H:i", strtotime($data['gross_weight1_date'])).'</td>
                                        <td class="text-end">'.date("H:i", strtotime($data['tare_weight1_date'])).'</td>
                                        <td class="text-end">'.($data['gross_weight1']/1000).'</td>
                                        <td class="text-end">'.($data['tare_weight1']/1000).'</td>
                                        <td class="text-end">'.($data['nett_weight1']/1000).'</td>
                                        <td class="text-end">0.00</td>
                                        <td class="text-end">0.00</td>
                                        <td class="text-end">0.00</td>
                                        <td class="text-end">0.00</td>
                                        <td class="text-end">0.00</td>
                                        <td>'.$exDel.'</td>
                                        <td>'.searchNamebyId($data['created_by'], $db).'</td>
                                    </tr>';                
                                }

                                $rowData .= '
                                    <tr class="details fw-bold">
                                        <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">Date Total : '.$grp3.'</td>
                                        <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.count($grp3Data).'</td>
                                        <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$dateNettWeight.'</td>
                                        <td></td>
                                        <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                        <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                        <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                    </tr>
                                    <tr style="height: 18.5px;"></tr>      
                                ';

                                $grp2NettWeight[$grp2] += $dateNettWeight;
                                $grp1NettWeight += $dateNettWeight;

                            }

                            $rowData .= '
                                <tr class="details fw-bold">
                                    <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$groupOrder[1].' Total : '.callLookup($groupOrder[1], $grp2, $db).'</td>
                                    <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp2Count[$grp2].'</td>
                                    <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp2NettWeight[$grp2].'</td>
                                    <td></td>
                                    <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                    <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                    <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                </tr>
                                <tr style="height: 18.5px;"></tr>
                            ';
                        }

                        $rowData .= '
                            <tr class="details fw-bold">
                                <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$groupOrder[0].' Total : '.callLookup($groupOrder[0], $grp1, $db).'</td>
                                <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp1Count.'</td>
                                <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp1NettWeight.'</td>
                                <td></td>
                                <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            </tr>
                            <tr style="height: 18.5px;"></tr>   
                        ';

                        $companyCount += $grp1Count;
                        $companyNettWeight += $grp1NettWeight;

                        $compiledRowData .= $rowData;
                    }

                    $compiledRowData .= '
                        <tr class="details fw-bold">
                            <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">Company Total : </td>
                            <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$companyCount.'</td>
                            <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$companyNettWeight.'</td>
                            <td></td>
                            <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                        </tr>
                    ';
                }elseif($groupCount == 4){
                    $companyCount = 0;
                    $companyNettWeight = 0;

                    foreach ($processedData as $grp1 => $grp1Data) {
                        $rowData = '
                            <tr>
                                <td colspan="17" style="border:0; padding-bottom: 0;">
                                    <div class="fw-bold">
                                        <span>
                                            '.$groupOrder[0].' <span>:</span> '.$grp1.' &nbsp;&nbsp;&nbsp;&nbsp; '.callLookup($groupOrder[0], $grp1, $db).'
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        '; 
                    
                        $grp1Count = 0;
                        $grp1TotalNettWeight = 0;
                    
                        foreach ($grp1Data as $grp2 => $grp2Data) {
                            $rowData .= '
                                <tr>
                                    <td colspan="17" style="border:0; padding-top: 0; padding-bottom: 0;">
                                        <div class="fw-bold">
                                            <span>
                                                '.$groupOrder[1].' <span>:</span> '.$grp2.' &nbsp;&nbsp;&nbsp;&nbsp; '.callLookup($groupOrder[1], $grp2, $db).'
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            '; 
                    
                            $grp2Count = 0;
                            $grp2TotalNettWeight = 0;
                    
                            foreach ($grp2Data as $grp3 => $grp3Data) { 
                                $rowData .= '
                                    <tr>
                                        <td colspan="17" style="border:0; padding-top: 0; padding-bottom: 0;">
                                            <div class="fw-bold">
                                                <span>
                                                '.$groupOrder[2].' <span>:</span> '.$grp3.' &nbsp;&nbsp;&nbsp;&nbsp; '.callLookup($groupOrder[2], $grp3, $db).'
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                '; 
                    
                                $grp3Count = 0;
                                $grp3TotalNettWeight = 0;
                    
                                foreach ($grp3Data as $grp4 => $grp4Data) {
                                    $rowData .= '
                                        <tr>
                                            <td colspan="17" style="border:0; padding-top: 0; padding-bottom: 0;">
                                                <div class="fw-bold">
                                                    <span>
                                                    Date <span>:</span> '.$grp4.'
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    ';
                    
                                    $dateNettWeight = 0;
                                    $grp4Count = 0;
                    
                                    foreach ($grp4Data as $data) {
                                        $dateNettWeight += $data['nett_weight1'] / 1000;
                                        $grp4Count++;
                                        if ($data['ex_del'] == 'EX') {
                                            $exDel = 'E';
                                        } else {
                                            $exDel = 'D';
                                        }
                    
                                        $rowData .= '<tr class="details">
                                            <td>'.$data['transaction_id'].'</td>
                                            <td>'.$data['transporter_code'].'</td>
                                            <td>'.$data['lorry_plate_no1'].'</td>
                                            <td>'.$data['agent_code'].'</td>
                                            <td>'.date("d/m/Y", strtotime($data['transaction_date'])).'</td>
                                            <td width="10%">'.$data['purchase_order'].'</td>
                                            <td class="text-end">'.date("H:i", strtotime($data['gross_weight1_date'])).'</td>
                                            <td class="text-end">'.date("H:i", strtotime($data['tare_weight1_date'])).'</td>
                                            <td class="text-end">'.($data['gross_weight1'] / 1000).'</td>
                                            <td class="text-end">'.($data['tare_weight1'] / 1000).'</td>
                                            <td class="text-end">'.($data['nett_weight1'] / 1000).'</td>
                                            <td class="text-end">0.00</td>
                                            <td class="text-end">0.00</td>
                                            <td class="text-end">0.00</td>
                                            <td class="text-end">0.00</td>
                                            <td class="text-end">0.00</td>
                                            <td>'.$exDel.'</td>
                                            <td>'.searchNamebyId($data['created_by'], $db).'</td>
                                        </tr>';                
                                    }
                    
                                    $rowData .= '
                                        <tr class="details fw-bold">
                                            <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">Date Total : '.$grp4.'</td>
                                            <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp4Count.'</td>
                                            <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$dateNettWeight.'</td>
                                            <td></td>
                                            <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                            <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                            <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                        </tr>
                                        <tr style="height: 18.5px;"></tr>      
                                    ';
                    
                                    $grp3TotalNettWeight += $dateNettWeight;
                                    $grp3Count += $grp4Count;
                                }
                    
                                $rowData .= '
                                    <tr class="details fw-bold">
                                        <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$groupOrder[2].' Total : '.callLookup($groupOrder[2], $grp3, $db).'</td>
                                        <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp3Count.'</td>
                                        <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp3TotalNettWeight.'</td>
                                        <td></td>
                                        <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                        <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                        <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                    </tr>
                                    <tr style="height: 18.5px;"></tr>
                                ';
                    
                                $grp2TotalNettWeight += $grp3TotalNettWeight;
                                $grp2Count += $grp3Count;
                            }
                    
                            $rowData .= '
                                <tr class="details fw-bold">
                                    <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$groupOrder[1].' Total : '.callLookup($groupOrder[1], $grp2, $db).'</td>
                                    <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp2Count.'</td>
                                    <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp2TotalNettWeight.'</td>
                                    <td></td>
                                    <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                    <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                    <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                </tr>
                                <tr style="height: 18.5px;"></tr>   
                            ';
                    
                            $grp1TotalNettWeight += $grp2TotalNettWeight;
                            $grp1Count += $grp2Count;
                        }
                    
                        $rowData .= '
                            <tr class="details fw-bold">
                                <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$groupOrder[0].' Total : '.callLookup($groupOrder[0], $grp1, $db).'</td>
                                <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp1Count.'</td>
                                <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp1TotalNettWeight.'</td>
                                <td></td>
                                <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            </tr>
                            <tr style="height: 18.5px;"></tr>   
                        ';
                        
                        $companyNettWeight += $grp1TotalNettWeight;
                        $companyCount += $grp1Count;
                        $compiledRowData .= $rowData;
                    }

                    $compiledRowData .= '
                        <tr class="details fw-bold">
                            <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">Company Total : </td>
                            <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$companyCount.'</td>
                            <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$companyNettWeight.'</td>
                            <td></td>
                            <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                        </tr>
                    ';
                }

                $message = '
                    <html>
                        <head>
                            <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" media="all" />
                            <link rel="stylesheet" href="assets/css/custom.min.css" type="text/css" media="all" />

                            <style>
                                @page {
                                    size: A4 landscape;
                                    margin: 5mm;
                                }

                                @media print {
                                    header {
                                        top: 0;
                                        width: 100%;
                                        background: white;
                                        z-index: 1000; /* High z-index to make sure header stays on top */
                                    } 

                                    .details td {
                                        border: 0;
                                        padding-top: 0;
                                        padding-bottom: 0;
                                    }

                                    .section-break {
                                        page-break-before: always;
                                    }
                                }
                            </style>
                        </head>

                        <body>
                            <header>
                                <div class="row">
                                    <div class="d-flex justify-content-center">
                                        <h5 class="fw-bold">EAST ROCK MARKETING SDN. BHD.</h5>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <p>Sales Weighing Summary Report By '.$groupBy.'</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <p>
                                        Start Date : '.$fromDate.' Last Date : '.$toDate.'
                                        <br>
                                        Start/Last Company : ERMSB / ERMSB
                                        <br>
                                        Start Customer / Last Customer : '.reset($headerGroup['Customer']).' / '.end($headerGroup['Customer']).'
                                        <br>
                                        Start Destination / Last Destination : '.reset($headerGroup['Destination']).' / '.end($headerGroup['Destination']).'
                                        <br>
                                        Start/Last Customer Type: /IN 
                                        <br>
                                        Start/Last Site : 
                                        <br>
                                        Start Product / Last Product : '.reset($headerGroup['Product']).' / '.end($headerGroup['Product']).'
                                    </p>
                                </div>
                            </header>
                            <div class="container-full content">
                                <div class="row">
                                    <div>
                                        <table class="table" style="font-size: 12px">
                                            <thead style="border-bottom: 1px solid black;">
                                                <tr class="text-center" style="border-top: 1px solid black;">
                                                    <th rowspan="2" class="text-start">Serial No.</th>
                                                    <th rowspan="2">Transport</th>
                                                    <th rowspan="2">Vehicle No.</th>
                                                    <th rowspan="2">Salesman</th>
                                                    <th rowspan="2">Date</th>
                                                    <th rowspan="2">P/O No</th>
                                                    <th colspan="2" class="pb-0 pt-0" style="border-bottom: none;">Time</th>
                                                    <th colspan="3" class="pt-0 pb-0" style="border-bottom: none;">Weight (MT)</th>
                                                    <th rowspan="2">Price <br>/Ton</th>
                                                    <th rowspan="2">Trans Rate</th>
                                                    <th rowspan="2">Ex_GST <br>(RM)</th>
                                                    <th rowspan="2">GST 0% <br>(RM)</th>
                                                    <th rowspan="2">Amount <br>(RM)</th>
                                                    <th rowspan="2">E/D</th>
                                                    <th rowspan="2"></th>
                                                </tr>
                                                <tr class="text-center">
                                                    <th>In</th>
                                                    <th>Out</th>
                                                    <th>In</th>
                                                    <th>Out</th>
                                                    <th>Net</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            '.$compiledRowData.'
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </body>

                    </html>
                ';
                
                echo json_encode(
                    array(
                        "status" => "success",
                        "message" => $message
                    )
                );
            }
        }
        else{
            echo json_encode(
                array(
                    "status" => "failed",
                    "message" => "Something Goes Wrong"
                ));
        }
    }elseif($_POST["type"] == 'Purchase'){
        if ($select_stmt = $db->prepare("select * from Weight WHERE is_complete = 'Y' AND is_cancel <> 'Y'".$searchQuery.' ORDER BY tare_weight1_date')) {
            // Execute the prepared query.
            if (! $select_stmt->execute()) {
                echo json_encode(
                    array(
                        "status" => "failed",
                        "message" => "Something went wrong"
                    )); 
            }
            else{
                $result = $select_stmt->get_result();
                $weightData = [];
                while ($row = $result->fetch_assoc()) {
                    // Replace all null values with ''
                    $cleanedRow = array_map(function($value) {
                        return $value === null ? '' : $value;
                    }, $row);

                    $weightData[] = $cleanedRow;
                }

                $groupList = [
                    $group1, $group2, $group3                    
                ];

                // Clean groupKeys to remove any empty values
                $filteredGroupKeys = array_filter($groupList, fn($key) => !empty($key));
                $groupBy = "";
                $groupOrder = [];
                if (empty($filteredGroupKeys)){
                    $groupBy = 'Date';
                }else{
                    foreach ($filteredGroupKeys as $group) {
                        switch ($group) {
                            case 'supplier_code':
                                $groupBy .= '/Supplier';
                                $groupOrder[] = 'Supplier';
                                break;
                            case 'raw_mat_code':
                                $groupBy .= '/Raw Material';
                                $groupOrder[] = 'Raw Material';
                                break;
                            case 'lorry_plate_no1':
                                $groupBy .= '/Vehicle';
                                $groupOrder[] = 'Vehicle';
                                break;
                            case 'destination_code':
                                $groupBy .= '/Destination';
                                $groupOrder[] = 'Destination';
                                break;
                            case 'transporter_code':
                                $groupBy .= '/Transporter';
                                $groupOrder[] = 'Transporter';
                                break;
                            case 'plant_code':
                                $groupBy .= '/Plant';
                                $groupOrder[] = 'Plant';
                                break;
                        }
                    }
                }
                $groupBy = ltrim($groupBy, '/');

                $processedData = rearrangeList($weightData, $filteredGroupKeys);

                ################################################## Header Processing ##################################################
                $headerGrouping = [];
                $defaultGroups = ['Supplier', 'Raw Material', 'Vehicle', 'Destination', 'Transporter', 'Plant']; // Default group keys
                // Initialize $headerGrouping with empty arrays
                foreach ($defaultGroups as $group) {
                    $headerGroup[$group] = [];
                }

                if (count($groupOrder) > 0){
                    foreach ($processedData as $grp1 => $grp1Data) {
                        # Group 1 Header Processing
                        if (in_array($groupOrder[0], $defaultGroups)) {
                            addToHeaderGroup($headerGroup, $groupOrder[0], $grp1);
                        }
    
                        if(count($groupOrder) > 1 && !empty($grp1Data)){
                            foreach ($grp1Data as $grp2 => $grp2Data) {
                                # Group 2 Header Processing
                                if (in_array($groupOrder[1], $defaultGroups)) {
                                    addToHeaderGroup($headerGroup, $groupOrder[1], $grp2);
                                }
    
                                if(count($groupOrder) > 2 && !empty($grp2Data)){
                                    foreach ($grp2Data as $grp3 => $grp3Data) {
                                        # Group 3 Header Processing
                                        if (in_array($groupOrder[2], $defaultGroups)) {
                                            addToHeaderGroup($headerGroup, $groupOrder[2], $grp3);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                
                ################################################## Row Processing ##################################################
                $groupCount = count($filteredGroupKeys)+1; // Add 1 for date group
                $compiledRowData = '';
                if($groupCount == 1){ 
                    $grpNettWeight = 0;
                    $totalNettWeight = 0;
                    $grpTotalCount = 0;

                    foreach ($processedData as $date => $grpData) { 
                        $rowData = '
                            <tr>
                                <td colspan="17" style="border:0; padding-bottom: 0;">
                                    <div class="fw-bold">
                                        <span>
                                            Date <span>:</span> '.$date.'
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        ';

                        foreach ($grpData as $data){ 
                            $grpNettWeight += $data['nett_weight1']/1000; 
                            if ($data['ex_del'] == 'EX'){
                                $exDel = 'E';
                            }else{
                                $exDel = 'D';
                            }

                            $rowData .= '<tr class="details">
                                <td>'.$data['transaction_id'].'</td>
                                <td>'.$data['transporter_code'].'</td>
                                <td>'.$data['lorry_plate_no1'].'</td>
                                <td>'.$data['agent_code'].'</td>
                                <td>'.date("d/m/Y", strtotime($data['transaction_date'])).'</td>
                                <td width="10%">'.$data['purchase_order'].'</td>
                                <td class="text-end">'.date("H:i", strtotime($data['gross_weight1_date'])).'</td>
                                <td class="text-end">'.date("H:i", strtotime($data['tare_weight1_date'])).'</td>
                                <td class="text-end">'.($data['gross_weight1']/1000).'</td>
                                <td class="text-end">'.($data['tare_weight1']/1000).'</td>
                                <td class="text-end">'.($data['nett_weight1']/1000).'</td>
                                <td class="text-end">0.00</td>
                                <td class="text-end">0.00</td>
                                <td class="text-end">0.00</td>
                                <td class="text-end">0.00</td>
                                <td class="text-end">0.00</td>
                                <td>'.$exDel.'</td>
                                <td>'.searchNamebyId($data['created_by'], $db).'</td>
                            </tr>';                
                        }

                        $rowData .= '
                            <tr class="details fw-bold">
                                <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">Date Total : '.$date.'</td>
                                <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.count($grpData).'</td>
                                <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grpNettWeight.'</td>
                                <td></td>
                                <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            </tr>
                            <tr style="height: 18.5px;"></tr>
                        ';
                        
                        // Append this row block to full HTML
                        $compiledRowData .= $rowData;

                        $grpTotalCount += count($grpData);
                        $totalNettWeight += $grpNettWeight;
                    }

                    $compiledRowData .= '
                        <tr class="details fw-bold">
                            <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">Company Total : </td>
                            <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grpTotalCount.'</td>
                            <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$totalNettWeight.'</td>
                            <td></td>
                            <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                        </tr>
                        <tr style="height: 18.5px;"></tr>         
                    ';
                }elseif ($groupCount == 2) { 
                    $grpTotalCount = 0;
                    $dateNettWeight = 0;
                    $totalNettWeight = 0;
                    foreach ($processedData as $grp1 => $grp1Data) { 
                        $rowData = '
                            <tr>
                                <td colspan="17" style="border:0; padding-bottom: 0;">
                                    <div class="fw-bold">
                                        <span>
                                            '.$groupOrder[0].' <span>:</span> '.$grp1.' &nbsp;&nbsp;&nbsp;&nbsp; '.callLookup($groupOrder[0], $grp1, $db).'
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        '; 
                        $grp1Records = 0;
                        $grp1NettWeight = 0;
                        foreach ($grp1Data as $date => $dateData){
                            $rowData .= '
                                <tr>
                                    <td colspan="17" style="border:0; padding-bottom: 0;">
                                        <div class="fw-bold">
                                            <span>
                                                Date <span>:</span> '.$date.'
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            '; 

                            foreach ($dateData as $data){
                                $dateNettWeight += $data['nett_weight1']/1000;
                                if ($data['ex_del'] == 'EX'){
                                    $exDel = 'E';
                                }else{
                                    $exDel = 'D';
                                }

                                $rowData .= '<tr class="details">
                                    <td>'.$data['transaction_id'].'</td>
                                    <td>'.$data['transporter_code'].'</td>
                                    <td>'.$data['lorry_plate_no1'].'</td>
                                    <td>'.$data['agent_code'].'</td>
                                    <td>'.date("d/m/Y", strtotime($data['transaction_date'])).'</td>
                                    <td width="10%">'.$data['purchase_order'].'</td>
                                    <td class="text-end">'.date("H:i", strtotime($data['gross_weight1_date'])).'</td>
                                    <td class="text-end">'.date("H:i", strtotime($data['tare_weight1_date'])).'</td>
                                    <td class="text-end">'.($data['gross_weight1']/1000).'</td>
                                    <td class="text-end">'.($data['tare_weight1']/1000).'</td>
                                    <td class="text-end">'.($data['nett_weight1']/1000).'</td>
                                    <td class="text-end">0.00</td>
                                    <td class="text-end">0.00</td>
                                    <td class="text-end">0.00</td>
                                    <td class="text-end">0.00</td>
                                    <td class="text-end">0.00</td>
                                    <td>'.$exDel.'</td>
                                    <td>'.searchNamebyId($data['created_by'], $db).'</td>
                                </tr>';                
                            }

                            $rowData .= '
                                <tr class="details fw-bold">
                                    <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">Date Total : '.$date.'</td>
                                    <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.count($dateData).'</td>
                                    <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$dateNettWeight.'</td>
                                    <td></td>
                                    <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                    <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                    <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                </tr>
                                <tr style="height: 18.5px;"></tr>      
                            ';

                            $grp1Records += count($dateData);
                            $grp1NettWeight += $dateNettWeight;
                        }

                        $rowData .= '
                            <tr class="details fw-bold">
                                <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$groupOrder[0].' Total : '.callLookup($groupOrder[0], $grp1, $db).'</td>
                                <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp1Records.'</td>
                                <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp1NettWeight.'</td>
                                <td></td>
                                <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            </tr>
                            <tr style="height: 18.5px;"></tr>   
                        ';
                        
                        // Append this row block to full HTML
                        $compiledRowData .= $rowData;

                        $grpTotalCount += $grp1Records;
                        $totalNettWeight += $grp1NettWeight;
                    }

                    $compiledRowData .= '
                        <tr class="details fw-bold">
                            <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">Company Total : </td>
                            <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grpTotalCount.'</td>
                            <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$totalNettWeight.'</td>
                            <td></td>
                            <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                        </tr>
                    ';
                }elseif ($groupCount == 3) {
                    $companyCount = 0;
                    $companyNettWeight = 0;
                    $grp2Count = [];
                    $grp2NettWeight = [];
                    
                    foreach ($processedData as $grp1 => $grp1Data){
                        $rowData = '
                            <tr>
                                <td colspan="17" style="border:0; padding-bottom: 0;">
                                    <div class="fw-bold">
                                        <span>
                                            '.$groupOrder[0].' <span>:</span> '.$grp1.' &nbsp;&nbsp;&nbsp;&nbsp; '.callLookup($groupOrder[0], $grp1, $db).'
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        '; 

                        $grp1Count = 0;
                        $grp1NettWeight = 0;
                        foreach ($grp1Data as $grp2 => $grp2Data){
                            $rowData .= '
                                <tr>
                                    <td colspan="17" style="border:0; padding-top: 0; padding-bottom: 0;">
                                        <div class="fw-bold">
                                            <span>
                                                '.$groupOrder[1].' <span>:</span> '.$grp2.' &nbsp;&nbsp;&nbsp;&nbsp; '.callLookup($groupOrder[1], $grp2, $db).'
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            '; 

                            $grp2Count[$grp2] = 0;
                            $grp2NettWeight[$grp2] = 0;

                            foreach ($grp2Data as $grp3 => $grp3Data){ 
                                $grp2Count[$grp2] += count($grp3Data);

                                $rowData .= '
                                    <tr>
                                        <td colspan="17" style="border:0; padding-top: 0; padding-bottom: 0;">
                                            <div class="fw-bold">
                                                <span>
                                                Date <span>:</span> '.$grp3.'
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                '; 

                                $dateNettWeight = 0;
                                foreach ($grp3Data as $data){ 
                                    $grp1Count++;
                                    $dateNettWeight += $data['nett_weight1']/1000; 
                                    if ($data['ex_del'] == 'EX'){
                                        $exDel = 'E';
                                    }else{
                                        $exDel = 'D';
                                    }
    
                                    $rowData .= '<tr class="details">
                                        <td>'.$data['transaction_id'].'</td>
                                        <td>'.$data['transporter_code'].'</td>
                                        <td>'.$data['lorry_plate_no1'].'</td>
                                        <td>'.$data['agent_code'].'</td>
                                        <td>'.date("d/m/Y", strtotime($data['transaction_date'])).'</td>
                                        <td width="10%">'.$data['purchase_order'].'</td>
                                        <td class="text-end">'.date("H:i", strtotime($data['gross_weight1_date'])).'</td>
                                        <td class="text-end">'.date("H:i", strtotime($data['tare_weight1_date'])).'</td>
                                        <td class="text-end">'.($data['gross_weight1']/1000).'</td>
                                        <td class="text-end">'.($data['tare_weight1']/1000).'</td>
                                        <td class="text-end">'.($data['nett_weight1']/1000).'</td>
                                        <td class="text-end">0.00</td>
                                        <td class="text-end">0.00</td>
                                        <td class="text-end">0.00</td>
                                        <td class="text-end">0.00</td>
                                        <td class="text-end">0.00</td>
                                        <td>'.$exDel.'</td>
                                        <td>'.searchNamebyId($data['created_by'], $db).'</td>
                                    </tr>';                
                                }

                                $rowData .= '
                                    <tr class="details fw-bold">
                                        <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">Date Total : '.$grp3.'</td>
                                        <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.count($grp3Data).'</td>
                                        <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$dateNettWeight.'</td>
                                        <td></td>
                                        <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                        <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                        <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                    </tr>
                                    <tr style="height: 18.5px;"></tr>      
                                ';

                                $grp2NettWeight[$grp2] += $dateNettWeight;
                                $grp1NettWeight += $dateNettWeight;

                            }

                            $rowData .= '
                                <tr class="details fw-bold">
                                    <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$groupOrder[1].' Total : '.callLookup($groupOrder[1], $grp2, $db).'</td>
                                    <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp2Count[$grp2].'</td>
                                    <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp2NettWeight[$grp2].'</td>
                                    <td></td>
                                    <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                    <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                    <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                </tr>
                                <tr style="height: 18.5px;"></tr>
                            ';
                        }

                        $rowData .= '
                            <tr class="details fw-bold">
                                <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$groupOrder[0].' Total : '.callLookup($groupOrder[0], $grp1, $db).'</td>
                                <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp1Count.'</td>
                                <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp1NettWeight.'</td>
                                <td></td>
                                <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            </tr>
                            <tr style="height: 18.5px;"></tr>   
                        ';

                        $companyCount += $grp1Count;
                        $companyNettWeight += $grp1NettWeight;

                        $compiledRowData .= $rowData;
                    }

                    $compiledRowData .= '
                        <tr class="details fw-bold">
                            <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">Company Total : </td>
                            <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$companyCount.'</td>
                            <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$companyNettWeight.'</td>
                            <td></td>
                            <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                        </tr>
                    ';
                }elseif($groupCount == 4){
                    $companyCount = 0;
                    $companyNettWeight = 0;

                    foreach ($processedData as $grp1 => $grp1Data) {
                        $rowData = '
                            <tr>
                                <td colspan="17" style="border:0; padding-bottom: 0;">
                                    <div class="fw-bold">
                                        <span>
                                            '.$groupOrder[0].' <span>:</span> '.$grp1.' &nbsp;&nbsp;&nbsp;&nbsp; '.callLookup($groupOrder[0], $grp1, $db).'
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        '; 
                    
                        $grp1Count = 0;
                        $grp1TotalNettWeight = 0;
                    
                        foreach ($grp1Data as $grp2 => $grp2Data) {
                            $rowData .= '
                                <tr>
                                    <td colspan="17" style="border:0; padding-top: 0; padding-bottom: 0;">
                                        <div class="fw-bold">
                                            <span>
                                                '.$groupOrder[1].' <span>:</span> '.$grp2.' &nbsp;&nbsp;&nbsp;&nbsp; '.callLookup($groupOrder[1], $grp2, $db).'
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            '; 
                    
                            $grp2Count = 0;
                            $grp2TotalNettWeight = 0;
                    
                            foreach ($grp2Data as $grp3 => $grp3Data) { 
                                $rowData .= '
                                    <tr>
                                        <td colspan="17" style="border:0; padding-top: 0; padding-bottom: 0;">
                                            <div class="fw-bold">
                                                <span>
                                                '.$groupOrder[2].' <span>:</span> '.$grp3.' &nbsp;&nbsp;&nbsp;&nbsp; '.callLookup($groupOrder[2], $grp3, $db).'
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                '; 
                    
                                $grp3Count = 0;
                                $grp3TotalNettWeight = 0;
                    
                                foreach ($grp3Data as $grp4 => $grp4Data) {
                                    $rowData .= '
                                        <tr>
                                            <td colspan="17" style="border:0; padding-top: 0; padding-bottom: 0;">
                                                <div class="fw-bold">
                                                    <span>
                                                    Date <span>:</span> '.$grp4.'
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    ';
                    
                                    $dateNettWeight = 0;
                                    $grp4Count = 0;
                    
                                    foreach ($grp4Data as $data) {
                                        $dateNettWeight += $data['nett_weight1'] / 1000;
                                        $grp4Count++;
                                        if ($data['ex_del'] == 'EX') {
                                            $exDel = 'E';
                                        } else {
                                            $exDel = 'D';
                                        }
                    
                                        $rowData .= '<tr class="details">
                                            <td>'.$data['transaction_id'].'</td>
                                            <td>'.$data['transporter_code'].'</td>
                                            <td>'.$data['lorry_plate_no1'].'</td>
                                            <td>'.$data['agent_code'].'</td>
                                            <td>'.date("d/m/Y", strtotime($data['transaction_date'])).'</td>
                                            <td width="10%">'.$data['purchase_order'].'</td>
                                            <td class="text-end">'.date("H:i", strtotime($data['gross_weight1_date'])).'</td>
                                            <td class="text-end">'.date("H:i", strtotime($data['tare_weight1_date'])).'</td>
                                            <td class="text-end">'.($data['gross_weight1'] / 1000).'</td>
                                            <td class="text-end">'.($data['tare_weight1'] / 1000).'</td>
                                            <td class="text-end">'.($data['nett_weight1'] / 1000).'</td>
                                            <td class="text-end">0.00</td>
                                            <td class="text-end">0.00</td>
                                            <td class="text-end">0.00</td>
                                            <td class="text-end">0.00</td>
                                            <td class="text-end">0.00</td>
                                            <td>'.$exDel.'</td>
                                            <td>'.searchNamebyId($data['created_by'], $db).'</td>
                                        </tr>';                
                                    }
                    
                                    $rowData .= '
                                        <tr class="details fw-bold">
                                            <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">Date Total : '.$grp4.'</td>
                                            <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp4Count.'</td>
                                            <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$dateNettWeight.'</td>
                                            <td></td>
                                            <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                            <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                            <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                        </tr>
                                        <tr style="height: 18.5px;"></tr>      
                                    ';
                    
                                    $grp3TotalNettWeight += $dateNettWeight;
                                    $grp3Count += $grp4Count;
                                }
                    
                                $rowData .= '
                                    <tr class="details fw-bold">
                                        <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$groupOrder[2].' Total : '.callLookup($groupOrder[2], $grp3, $db).'</td>
                                        <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp3Count.'</td>
                                        <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp3TotalNettWeight.'</td>
                                        <td></td>
                                        <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                        <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                        <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                    </tr>
                                    <tr style="height: 18.5px;"></tr>
                                ';
                    
                                $grp2TotalNettWeight += $grp3TotalNettWeight;
                                $grp2Count += $grp3Count;
                            }
                    
                            $rowData .= '
                                <tr class="details fw-bold">
                                    <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$groupOrder[1].' Total : '.callLookup($groupOrder[1], $grp2, $db).'</td>
                                    <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp2Count.'</td>
                                    <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp2TotalNettWeight.'</td>
                                    <td></td>
                                    <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                    <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                    <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                </tr>
                                <tr style="height: 18.5px;"></tr>   
                            ';
                    
                            $grp1TotalNettWeight += $grp2TotalNettWeight;
                            $grp1Count += $grp2Count;
                        }
                    
                        $rowData .= '
                            <tr class="details fw-bold">
                                <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$groupOrder[0].' Total : '.callLookup($groupOrder[0], $grp1, $db).'</td>
                                <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp1Count.'</td>
                                <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$grp1TotalNettWeight.'</td>
                                <td></td>
                                <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                                <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            </tr>
                            <tr style="height: 18.5px;"></tr>   
                        ';
                        
                        $companyNettWeight += $grp1TotalNettWeight;
                        $companyCount += $grp1Count;
                        $compiledRowData .= $rowData;
                    }

                    $compiledRowData .= '
                        <tr class="details fw-bold">
                            <td colspan="6" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">Company Total : </td>
                            <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$companyCount.'</td>
                            <td colspan="3" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">'.$companyNettWeight.'</td>
                            <td></td>
                            <td colspan="2" class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                            <td class="text-end" style="border-top: 1px dashed black; border-bottom: 1px dashed black;">0.00</td>
                        </tr>
                    ';
                }

                $message = '
                    <html>
                        <head>
                            <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" media="all" />
                            <link rel="stylesheet" href="assets/css/custom.min.css" type="text/css" media="all" />

                            <style>
                                @page {
                                    size: A4 landscape;
                                    margin: 5mm;
                                }

                                @media print {
                                    header {
                                        top: 0;
                                        width: 100%;
                                        background: white;
                                        z-index: 1000; /* High z-index to make sure header stays on top */
                                    } 

                                    .details td {
                                        border: 0;
                                        padding-top: 0;
                                        padding-bottom: 0;
                                    }

                                    .section-break {
                                        page-break-before: always;
                                    }
                                }
                            </style>
                        </head>

                        <body>
                            <header>
                                <div class="row">
                                    <div class="d-flex justify-content-center">
                                        <h5 class="fw-bold">EAST ROCK MARKETING SDN. BHD.</h5>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <p>Purchase Weighing Summary Report By '.$groupBy.'</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <p>
                                        Start Date : '.$fromDate.' Last Date : '.$toDate.'
                                        <br>
                                        Start/Last Company : ERMSB / ERMSB
                                        <br>
                                        Start Supplier / Last Supplier : '.reset($headerGroup['Supplier']).' / '.end($headerGroup['Supplier']).'
                                        <br>
                                        Start Destination / Last Destination : '.reset($headerGroup['Destination']).' / '.end($headerGroup['Destination']).'
                                        <br>
                                        Start/Last Customer Type: /IN 
                                        <br>
                                        Start/Last Site : 
                                        <br>
                                        Start Raw Material / Last Raw Material : '.reset($headerGroup['Raw Material']).' / '.end($headerGroup['Raw Material']).'
                                    </p>
                                </div>
                            </header>
                            <div class="container-full content">
                                <div class="row">
                                    <div>
                                        <table class="table" style="font-size: 12px">
                                            <thead style="border-bottom: 1px solid black;">
                                                <tr class="text-center" style="border-top: 1px solid black;">
                                                    <th rowspan="2" class="text-start">Serial No.</th>
                                                    <th rowspan="2">Transport</th>
                                                    <th rowspan="2">Vehicle No.</th>
                                                    <th rowspan="2">Salesman</th>
                                                    <th rowspan="2">Date</th>
                                                    <th rowspan="2">P/O No</th>
                                                    <th colspan="2" class="pb-0 pt-0" style="border-bottom: none;">Time</th>
                                                    <th colspan="3" class="pt-0 pb-0" style="border-bottom: none;">Weight (MT)</th>
                                                    <th rowspan="2">Price <br>/Ton</th>
                                                    <th rowspan="2">Trans Rate</th>
                                                    <th rowspan="2">Ex_GST <br>(RM)</th>
                                                    <th rowspan="2">GST 0% <br>(RM)</th>
                                                    <th rowspan="2">Amount <br>(RM)</th>
                                                    <th rowspan="2">E/D</th>
                                                    <th rowspan="2"></th>
                                                </tr>
                                                <tr class="text-center">
                                                    <th>In</th>
                                                    <th>Out</th>
                                                    <th>In</th>
                                                    <th>Out</th>
                                                    <th>Net</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            '.$compiledRowData.'
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </body>

                    </html>
                ';
                
                echo json_encode(
                    array(
                        "status" => "success",
                        "message" => $message
                    )
                );
            }
        }
        else{
            echo json_encode(
                array(
                    "status" => "failed",
                    "message" => "Something Goes Wrong"
                ));
        }
    }
}
else{
    echo json_encode(
        array(
            "status"=> "failed", 
            "message"=> "Please fill in all the fields"
        )
    ); 
}

?>