<?php

	require_once '../../packages/autoload.php';

    $dsn = "mysql:dbname=scada_it_database;host=localhost;charset=UTF8";
    $username = "root";
    $password = "";
    $pdo = new PDO($dsn, $username, $password);
    $db = new NotORM($pdo);

    /* Slim framework */
    $app = new \Slim\Slim();



    /* PHP Excel : Create new PHPExcel object : http://phpexcel.codeplex.com */
    $objPHPExcel = new \PHPExcel();



    /* PHP Function */
        function url(){

	    if(isset($_SERVER['HTTPS'])){
	        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
	    }
	    else{
	        $protocol = 'http';
	    }
    	//return $protocol . "://" . parse_url($_SERVER['REQUEST_URI'], PHP_URL_HOST);
    	return $protocol . "://" . $_SERVER['SERVER_NAME'];
	}

    /* TEST */
  		/**
	 *
	 * @apiName HelloWorld
	 * @apiGroup TEST SERVICE
	 * @apiVersion 0.1.0
	 *
	 * @api {get} /hello/:name Test GET Service (v 0.1.0)
	 * @apiDescription คำอธิบาย : Hello World, Test Service
	 *
	 * localhost : http://localhost/iFire-Reporter-API/src/hello/:name
	 *
	 * remote host : http://128.199.166.211/iFire-Reporter-API/src/hello/:name
	 *
	 * @apiExample Example usage:
	 * "Using Advanced REST Client" : (localhost)   chrome-extension://hgmloofddffdnphfgcellkdfbfbjeloo/RestClient.html#RequestPlace:projectEndpoint/31
	 * "Using Advanced REST Client" : (remote host) chrome-extension://hgmloofddffdnphfgcellkdfbfbjeloo/RestClient.html#RequestPlace:projectEndpoint/30
	 *
	 * @apiParam {String} name     New name of the user
	 *
	 * @apiSampleRequest /hello/:name
	 *
	 * @apiSuccess {String} msg แสดงข้อความทักทายผู้ใช้งาน
	 *
	 * @apiSuccessExample Example data on success:
	 * {
	 *   "msg": "Hello, anusorn"
	 * }
	 *
	 * @apiError UserNotFound The <code>id</code> of the User was not found.
	 * @apiErrorExample {json} Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "UserNotFound"
	 *     }
	 *
	 */
	$app->get('/hello/:name', function ($name) {
		

	    $return_m = array("msg" => "Hello, $name, Current PHP version: ". phpversion());
	    echo json_encode($return_m);

	});
    	/**
	 *
	 * @apiName HelloWorld_POST
	 * @apiGroup TEST SERVICE
	 * @apiVersion 0.1.0
	 *
	 * @api {post} /hello/ Test POST Service (v 0.1.0)
	 * @apiDescription คำอธิบาย : Hello World, Test Post Service
	 *
	 *
	 *
	 * @apiSampleRequest /hello/
	 *
	 * @apiSuccess {String} msg แสดงข้อความทักทายผู้ใช้งาน
	 *
	 * @apiSuccessExample Example data on success:
	 * {
     *   "msg": "Hello, Current PHP version: 5.6.8"
	 * }
	 *
	 * @apiError UserNotFound The <code>id</code> of the User was not found.
	 * @apiErrorExample {json} Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "UserNotFound"
	 *     }
	 *
	 */
	$app->post('/hello/', function () {
		

	    $return_m = array("msg" => "Hello, Current PHP version: ". phpversion());
	    echo json_encode($return_m);

	});


    /* Fast/Tools Configuration manager */
    $app->post('/FastToolsAPI/MODBUS_Manager/',function() use ($app, $pdo, $db, $objPHPExcel) { 
        MODBUS_Manager($app, $pdo, $db, $objPHPExcel); 
    });
    $app->post('/FastToolsAPI/OPCDAC_Manager/',function() use ($app, $pdo, $db, $objPHPExcel) { 
        OPCDAC_Manager($app, $pdo, $db, $objPHPExcel); 
    });
    $app->post('/FastToolsAPI/IEC60870_Manager/',function() use ($app, $pdo, $db, $objPHPExcel) { 
        IEC60870_Manager($app, $pdo, $db, $objPHPExcel); 
    });





    /* Admin manager */
    $app->post('/AdminAPI/updateScadaInfoIpFromHostManager/',function() use ($app, $pdo, $db) { 
        updateScadaInfoIpFromHostManager($app, $pdo, $db); 
    });
    $app->post('/AdminAPI/updateCommentHostFileManager/',function() use ($app, $pdo, $db) { 
        updateCommentHostFileManager($app, $pdo, $db); 
    });
    $app->post('/AdminAPI/updateInsertAllRtuManager/',function() use ($app, $pdo, $db) { 
        updateInsertAllRtuManager($app, $pdo, $db); 
    });
    $app->post('/AdminAPI/updateOnOffScanScadaInfoManager/',function() use ($app, $pdo, $db) { 
        updateOnOffScanScadaInfoManager($app, $pdo, $db); 
    });
    $app->post('/AdminAPI/compareWithExistingRtuManager/',function() use ($app, $pdo, $db) { 
        compareWithExistingRtuManager($app, $pdo, $db); 
    });
    $app->post('/AdminAPI/addUserInfoManager/',function() use ($app, $pdo, $db) { 
        addUserInfoManager($app, $pdo, $db); 
    });
    $app->post('/AdminAPI/addScadaInfoManager/',function() use ($app, $pdo, $db) { 
        addScadaInfoManager($app, $pdo, $db); 
    });
    $app->post('/AdminAPI/addWlmaInfoManager/',function() use ($app, $pdo, $db) { 
        addWlmaInfoManager($app, $pdo, $db); 
    });
    $app->post('/AdminAPI/createHostFileManager/',function() use ($app, $pdo, $db) { 
        createHostFileManager($app, $pdo, $db); 
    });


	$app->run();

    /* Fast/Tools Configuration manager Partial */
    
	/**
	 *
	 * @apiName MODBUS_Manager
	 * @apiGroup Fast_Tools
	 * @apiVersion 0.1.0
	 *
	 * @api {post} /FastToolsAPI/MODBUS_Manager/ MODBUS_Manager
	 * @apiDescription คำอธิบาย : ในส่วนนี้ใช้สำหรับสร้าง FAST/TOOLS Quickload สำหรับโปรโตคอล MODBUS
	 *
	 *
	 *
	 * @apiParam {String} rtu_install = "SERVICE" คำอธิบายกลุ่มของอุปกรณ์ เช่น SERVICE, PRODUCTION, OTHER
	 * @apiParam {String} fasttools_destination = "MOXA" คำอธิบายชนิดของอุปกรณ์ เช่น MOXA, B&R X20, ABB AC500, YOKOGAWA FCJ, WAGO, SIXNET
     * @apiParam {Object[]} listDM  รายการ DM
     * @apiParam {String} listDM.name = "DM-01-01-01-01" ชื่อ DM
     *
     * @apiParamExample {json} Request-Example (ตัวอย่าง Payload, Content-Type: application/json):
     *  {
     *      "rtu_install": "SERVICE",
     *      "fasttools_destination": "MOXA",
     *      "listDM": [
     *          {
     *              "name": "DM-01-01-01-01"
     *          },
     *          {
     *              "name": "DM-01-01-01-02"
     *          },
     *          {
     *              "name": "DM-01-01-01-03"
     *          }
     *      ]
     *  }
     *
	 * @apiSampleRequest /FastToolsAPI/MODBUS_Manager/
	 *
	 * @apiSuccess (คำอธิบายผลลัพธ์ (กรณีส่งค่ากลับสำเร็จ Success 200)) {String} msg แสดงข้อความทักทายผู้ใช้งาน
	 *
	 * @apiSuccessExample Example data on success:
     *  {
     *      "result": "success",
     *      "rows": [
     *          {
     *              "filename": "Quickload_for_MODBUS(PGIM_WTDC)_2015-08-15_1439607474.xls",
     *              "path": "http://localhost/scada-it/build/files/Quickload_for_MODBUS(PGIM_WTDC)_2015-08-15_1439607474.xls"
     *          }
     *      ]
     *  }
	 *
	 * @apiError (คำอธิบายผลลัพธ์ (กรณีเกิด Error 4xx)) UserNotFound The <code>id</code> of the User was not found.
	 * @apiErrorExample {json} Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "UserNotFound"
	 *     }
	 *
	 */
    function MODBUS_Manager($app, $pdo, $db, $objPHPExcel) {

        /* ************************* */
        /* เริ่มกระบวนการรับค่าพารามิเตอร์จากส่วนของ Payload ซึ่งอยู่ในรูปแบบ JSON */
        /* ************************* */
        $headers = $app->request->headers;
        $ContetnType = $app->request->headers->get('Content-Type');

        /**
        * apidoc @apiSampleRequest, iOS RESTKit use content-type is "application/json"
        * Web Form, Advance REST Client App use content-type is "application/x-www-form-urlencoded"
        */
        if ($ContetnType == "application/json") {

	        $request = $app->request();
	        $result = json_decode($request->getBody());

	        /* receive request */
	        $paramRtuInstall = $result->rtu_install;
	        $paramFastToolsDestination = $result->fasttools_destination;
	        $paramListDM = $result->listDM;

 
		} else if ($ContetnType == "application/x-www-form-urlencoded"){

		    //$userID = $app->request()->params('userID_param');
		    //$userID = $app->request()->post('userID_param');
		}


		/* ************************* */
        /* เริ่มกระบวนการเชื่อมต่อกับฐานข้อมูล MySQL */
        /* ************************* */

        $reports = array();
		
		
		/*  MODBUS_LINE_DF Partial */
	    



		/* Create Header */
		//$reports = $db->modbus_point_df[1];
		$results_header_modbus_line_df = $db->modbus_line_df()->where("templates = ?", "header_template")->fetch();

		$sth_modbus_line_df = $pdo->prepare("SELECT * FROM modbus_line_df WHERE templates = 'header_template'");
		$sth_modbus_line_df->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols_modbus_line_df = $sth_modbus_line_df->columnCount();
		$startRow_modbus_line_df = 2;
		$startColumn_modbus_line_df = 4;

		for ($i = $startColumn_modbus_line_df; $i < $numCols_modbus_line_df; $i++) {
			$meta = $sth_modbus_line_df->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn_modbus_line_df;
			$tmpValue = $results_header_modbus_line_df[$meta['name']];
			$value = trim(preg_replace('/\t+/', '', $tmpValue));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}




		/* Create Details */
		$numDM = count($paramListDM);  // จำนวน DM
		$z=1;
		for ($j=$startRow_modbus_line_df; $j < $numDM+$startRow_modbus_line_df; $j++) { 

			$results_data_modbus_line_dfs = $db->modbus_line_df()->where("templates = ? and rtu_install = ? and fasttools_destination = ?", "data_template", $paramRtuInstall, $paramFastToolsDestination);

			$k = 0;  // จำนวนแภวของ Template
			foreach ($results_data_modbus_line_dfs as $results_data_modbus_line_df) {
					$z = $z +1;
					for ($i = $startColumn_modbus_line_df; $i < $numCols_modbus_line_df; $i ++) {
						$meta = $sth_modbus_line_df->getColumnMeta($i);
						$row = $z;		// แถวที่ $row ของ Excel
						$col = $i-$startColumn_modbus_line_df;	// คอลัมภ์ที่ $col ของ Excel

						if ($meta['name'] == "NAME") {
							//B01MDC_01
							$tmpDM_Name = $paramListDM[$j-$startRow_modbus_line_df]->name;
							$tmpBranchCode = substr($tmpDM_Name, 3, 2);
							$tmpZoneCode = substr($tmpDM_Name, 6, 2);
							$value = "B".$tmpBranchCode."MDC_".$tmpZoneCode;
						} else if($meta['name'] == "DESCRIPTION"){
							//Modbus Communication for B01 Zone 01
							$tmpDM_Name = $paramListDM[$j-$startRow_modbus_line_df]->name;
							$tmpBranchCode = substr($tmpDM_Name, 3, 2);
							$tmpZoneCode = substr($tmpDM_Name, 6, 2);
							$value = "Modbus Communication for B".$tmpBranchCode." Zone ".$tmpZoneCode;
						} else if($meta['name'] == "EQUIPMENT_MAN"){
							//EQPM_B01_01
							$tmpDM_Name = $paramListDM[$j-$startRow_modbus_line_df]->name;
							$tmpBranchCode = substr($tmpDM_Name, 3, 2);
							$tmpZoneCode = substr($tmpDM_Name, 6, 2);
							$value = "EQPM_B".$tmpBranchCode."_".$tmpZoneCode;
						} else {
							$tmpValue = $results_data_modbus_line_df[$meta['name']];
							$value = trim(preg_replace('/\t+/', '', $tmpValue));
						}
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
					}
				$k = $k +1;
			}

		}

		/* Set Title */
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('MODBUS_LINE_DF');

		


	    /*  MODBUS_STATION_DF Partial */
	    		$sheetCount = $objPHPExcel->getSheetCount();

		/* Create Worksheet พร้อมกำหนดชื่อ */
		$objPHPExcel_MODBUS_STATION_DF_Worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'MODBUS_STATION_DF');
		$objPHPExcel->addSheet($objPHPExcel_MODBUS_STATION_DF_Worksheet, $sheetCount);
		$objPHPExcel_MODBUS_STATION_DF_Worksheet->setTitle('MODBUS_STATION_DF');

		/* กำหนดให้เป็น ActiveWorkSheet */
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex($sheetCount);


		/* ************************* */
        /* เริ่มกระบวนการสร้าง Quickload for MODBUS (MODBUS_STATION_DF) */
        /* ************************* */

		/* Create Header */
		//$reports = $db->modbus_station_df[1];
		$results_header = $db->modbus_station_df()->where("templates = ?", "header_template")->fetch();

        $sth = $pdo->prepare("SELECT * FROM modbus_station_df WHERE templates = 'header_template'");
        $sth->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols = $sth->columnCount();
		$startRow = 2;
		$startColumn = 4;

		for ($i = $startColumn; $i < $numCols; $i ++) {
			$meta = $sth->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn;
			$value = $results_header[$meta['name']];
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}


		/* Create Details */
		$numDM = count($paramListDM);  // จำนวน DM
		$results_data = $db->modbus_station_df()->where("templates = ? and rtu_install = ?", "data_template", $paramRtuInstall)->fetch();
		for ($j=$startRow; $j < $numDM+$startRow; $j++) { 

			for ($i = $startColumn; $i < $numCols; $i ++) {
				$meta = $sth->getColumnMeta($i);
				$row = $j;		// แถวที่ $row ของ Excel
				$col = $i-$startColumn;	// คอลัมภ์ที่ $col ของ Excel

				if ($meta['name'] == "NAME") {
					$value = $paramListDM[$j-$startRow]->name;
				} else if($meta['name'] == "DESCRIPTION") {
					$value = $paramFastToolsDestination;
				} else if($meta['name'] == "LINE") {
					$tmpDM_Name = $paramListDM[$j-$startRow]->name;  //DM-01-02-03-04, B01MDC_02
					$tmpBranchCode = substr($tmpDM_Name, 3, 2);
					$tmpZoneCode = substr($tmpDM_Name, 6, 2);
					$value = "B".$tmpBranchCode."MDC_".$tmpZoneCode;
				} else if($meta['name'] == "LINE_1_DEVICE") {
					$value = $paramListDM[$j-$startRow]->name;
				} else if($meta['name'] == "STATUS_ITEM") {
					$tmpDM_Name = $paramListDM[$j-$startRow]->name;	//DM-01-02-03-04, SERVICE.B01.DM-01-02-03-04.COMM_STS
					$tmpBranchCode = substr($tmpDM_Name, 3, 2);
					$value = "SERVICE.B".$tmpBranchCode.".".$tmpDM_Name.".COMM_STS";
				} else {
					$value = $results_data[$meta['name']];
				}


				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
			}

		}




		/* Set Title */
		// Rename worksheet
		//$objPHPExcel->getActiveSheet()->setTitle('MODBUS_STATION_DF');




	    /*  MODBUS_POINT_DF Partial */
	    		$sheetCount = $objPHPExcel->getSheetCount();

		/* Create Worksheet พร้อมกำหนดชื่อ */
		$objPHPExcel_MODBUS_POINT_DF_Worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'MODBUS_POINT_DF');
		$objPHPExcel->addSheet($objPHPExcel_MODBUS_POINT_DF_Worksheet, $sheetCount);
		$objPHPExcel_MODBUS_POINT_DF_Worksheet->setTitle('MODBUS_POINT_DF');

		/* กำหนดให้เป็น ActiveWorkSheet */
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex($sheetCount);


		/* Create Header */
		//$reports = $db->modbus_point_df[1];
		$results_header_modbus_point_df = $db->modbus_point_df()->where("templates = ?", "header_template")->fetch();

		$sth_modbus_point_df = $pdo->prepare("SELECT * FROM modbus_point_df WHERE templates = 'header_template'");
		$sth_modbus_point_df->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols_modbus_point_df = $sth_modbus_point_df->columnCount();
		$startRow_modbus_point_df = 2;
		$startColumn_modbus_point_df = 4;

		for ($i = $startColumn_modbus_point_df; $i < $numCols_modbus_point_df; $i++) {
			$meta = $sth_modbus_point_df->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn_modbus_point_df;
			$value = $results_header_modbus_point_df[$meta['name']];
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}




		/* Create Details */
		$numDM = count($paramListDM);  // จำนวน DM
		$z=1;
		for ($j=$startRow_modbus_point_df; $j < $numDM+$startRow_modbus_point_df; $j++) { 

			$results_data_modbus_point_dfs = $db->modbus_point_df()->where("templates = ? and rtu_install = ? and fasttools_destination = ?", "data_template", $paramRtuInstall, $paramFastToolsDestination);

			$k = 0;  // จำนวนแภวของ Template
			foreach ($results_data_modbus_point_dfs as $results_data_modbus_point_df) {
					$z = $z +1;
					for ($i = $startColumn_modbus_point_df; $i < $numCols_modbus_point_df; $i ++) {
						$meta = $sth_modbus_point_df->getColumnMeta($i);
						$row = $z;		// แถวที่ $row ของ Excel
						$col = $i-$startColumn_modbus_point_df;	// คอลัมภ์ที่ $col ของ Excel


						if ($meta['name'] == "STATION") {
							$value = $paramListDM[$j-$startRow_modbus_point_df]->name;
						} else if($meta['name'] == "NAME"){
							$tmpDM_Name = $paramListDM[$j-$startRow_modbus_point_df]->name;
							$value = $tmpDM_Name.":".$results_data_modbus_point_df["POINT"];
						} else {
							$value = $results_data_modbus_point_df[$meta['name']];
						}
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
					}
				$k = $k +1;
			}

		}



	    /*  STATION_DF Partial */
	    		$sheetCount = $objPHPExcel->getSheetCount();

		/* Create Worksheet พร้อมกำหนดชื่อ */
		$objPHPExcel_SECTION_DF_Worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'SECTION_DF');
		$objPHPExcel->addSheet($objPHPExcel_SECTION_DF_Worksheet, $sheetCount);
		$objPHPExcel_SECTION_DF_Worksheet->setTitle('SECTION_DF');

		/* กำหนดให้เป็น ActiveWorkSheet */
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex($sheetCount);


		/* Create Header */
		//$reports = $db->modbus_point_df[1];
		$results_header_section_df = $db->section_df()->where("templates = ?", "header_template")->fetch();

		$sth_section_df = $pdo->prepare("SELECT * FROM section_df WHERE templates = 'header_template'");
		$sth_section_df->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols_section_df = $sth_section_df->columnCount();
		$startRow_section_df = 2;
		$startColumn_section_df = 4;

		for ($i = $startColumn_section_df; $i < $numCols_section_df; $i++) {
			$meta = $sth_section_df->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn_section_df;
			$tmpValue = $results_header_section_df[$meta['name']];
			$value = trim(preg_replace('/\t+/', '', $tmpValue));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}




		/* Create Details */

		$numDM = count($paramListDM);  // จำนวน DM
		$z=1;
		for ($j=$startRow_section_df; $j < $numDM+$startRow_section_df; $j++) { 

			$results_data_section_dfs = $db->section_df()->where("templates = ? and rtu_install = ? and fasttools_destination = ?", "data_template", $paramRtuInstall, $paramFastToolsDestination);

			$k = 0;  // จำนวนแภวของ Template
			foreach ($results_data_section_dfs as $results_data_section_df) {

					$z = $z +1;
					for ($i = $startColumn_section_df; $i < $numCols_section_df; $i ++) {
						$meta = $sth_section_df->getColumnMeta($i);
						$row = $z;		// แถวที่ $row ของ Excel
						$col = $i-$startColumn_section_df;	// คอลัมภ์ที่ $col ของ Excel


						if ($meta['name'] == "SECTION_NAME") {
							$value = $paramListDM[$j-$startRow_section_df]->name;
						} else if($meta['name'] == "NAME"){

							if($paramRtuInstall == "PRODUCTION") {
								// PRODUCTION.WTDC.U208
								$tmpDM_Name = $paramListDM[$j-$startRow_section_df]->name;
								$value = "PRODUCTION.WTDC.".$tmpDM_Name;
							} else {
								// SERVICE.B54.DM-54-04-05-01
								$tmpDM_Name = $paramListDM[$j-$startRow_section_df]->name;
								$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);
								$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name;
							}

						} else if($meta['name'] == "DESCRIPTION"){
							
							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_section_df[$meta['name']];
							} else {
								$tmpDM_Name = $paramListDM[$j-$startRow_section_df]->name;
								$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);
								$value = $tmpBranch_Name;
							}

						} else {
							$tmpValue = $results_data_section_df[$meta['name']];
							$value = trim(preg_replace('/\t+/', '', $tmpValue));
						}
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
					}
				$k = $k +1;

			}

		}





	    /*  ITEM_DF Partial */
	    		$sheetCount = $objPHPExcel->getSheetCount();

		/* Create Worksheet พร้อมกำหนดชื่อ */
		$objPHPExcel_ITEM_DF_Worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'ITEM_DF');
		$objPHPExcel->addSheet($objPHPExcel_ITEM_DF_Worksheet, $sheetCount);
		$objPHPExcel_ITEM_DF_Worksheet->setTitle('ITEM_DF');

		/* กำหนดให้เป็น ActiveWorkSheet */
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex($sheetCount);


		/* Create Header */
		//$reports = $db->modbus_point_df[1];
		$results_header_item_df = $db->item_df()->where("templates = ?", "header_template")->fetch();

		$sth_item_df = $pdo->prepare("SELECT * FROM item_df WHERE templates = 'header_template'");
		$sth_item_df->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols_item_df = $sth_item_df->columnCount();
		$startRow_item_df = 2;
		$startColumn_item_df = 4;

		for ($i = $startColumn_item_df; $i < $numCols_item_df; $i++) {
			$meta = $sth_item_df->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn_item_df;
			$tmpValue = $results_header_item_df[$meta['name']];
			$value = trim(preg_replace('/\t+/', '', $tmpValue));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}




		/* Create Details */

		$numDM = count($paramListDM);  // จำนวน DM
		$z=1;
		for ($j=$startRow_item_df; $j < $numDM+$startRow_item_df; $j++) { 

			$results_data_item_dfs = $db->item_df()->where("templates = ? and rtu_install = ? and fasttools_destination = ?", "data_template", $paramRtuInstall, $paramFastToolsDestination);

			$k = 0;  // จำนวนแภวของ Template
			foreach ($results_data_item_dfs as $results_data_item_df) {

					$z = $z +1;
					for ($i = $startColumn_item_df; $i < $numCols_item_df; $i ++) {
						$meta = $sth_item_df->getColumnMeta($i);
						$row = $z;		// แถวที่ $row ของ Excel
						$col = $i-$startColumn_item_df;	// คอลัมภ์ที่ $col ของ Excel


						if ($meta['name'] == "INSTALL") {
							$value = $paramRtuInstall;
						} else if ($meta['name'] == "UNIT") {

							if($paramRtuInstall == "PRODUCTION") {
								$value = "WTDC";
							} else {
								$tmpDM_Name = $paramListDM[$j-$startRow_item_df]->name;
								$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);
								$value = $tmpBranch_Name;
							}

						} else if ($meta['name'] == "NAME") {
							// PRODUCTION.WTDC.U208.FT
							// SERVICE.B01.DM-01-06-03-02.PT_INT_HI_SP
							if($paramRtuInstall == "PRODUCTION") {
								$tmpDM_Name = $paramListDM[$j-$startRow_item_df]->name;
								$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);
								$value = $paramRtuInstall.".WTDC".".".$tmpDM_Name.".".$results_data_item_df['TAG'];
							} else {
								$tmpDM_Name = $paramListDM[$j-$startRow_item_df]->name;
								$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);
								$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".".$results_data_item_df['TAG'];
							}


						} else if ($meta['name'] == "STATION") {
							
								/*  MODBUS_LINE_DF Partial */
							    							$tmpDM_Name = $paramListDM[$j-$startRow_item_df]->name;
							$tmpBranch_Name = substr($tmpDM_Name, 3, 2);

							if (( $paramFastToolsDestination == "B&R X20")||($paramFastToolsDestination == "YOKOGAWA FCJ")||($paramFastToolsDestination == "SIXNET")||($paramFastToolsDestination == "ABB CTU800")) {
								// Define STATION for B&R X20, Template from "DM-01-04-04-01"
								// Define STATION for YOKOGAWA FCJ, Template from "DM-01-06-02-03"
								// Define STATION for SIXNET, Template from "DM-04-03-01-01"
								if ($results_data_item_df['TAG'] == "COMM_STS"){
									$value = "";
								} else {
									$value = $tmpDM_Name;
								}

							} else if (($paramFastToolsDestination == "MOXA") || ($paramFastToolsDestination == "WAGO")) {
								// Define STATION for MOXA, Template from "DM-01-06-03-02"
								// Define STATION for WAGO, Template from "DM-02-08-02-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT") 
										|| ($results_data_item_df['TAG'] == "TOTAL")){
										$value = $tmpDM_Name;
								} else {
									$value = "";
								}
							} else if ($paramFastToolsDestination == "ABB AC500") {
								// Define STATION for ABB AC500, Template from "DM-01-06-01-01"
								if (($results_data_item_df['TAG'] == "COMM_STS") || ($results_data_item_df['TAG'] == "PT_EXT_HI_ALM") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_HI_SP") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_LO_ALM") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_LO_SP")){
										$value = "";
								} else {
									$value = $tmpDM_Name;
								}
							} else if ($paramFastToolsDestination == "PGIM_BRANCH") {
								// Define STATION for PGIM_BRANCH, Template from "DM-02-15-01-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "ON") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT")
										|| ($results_data_item_df['TAG'] == "TOTAL")){
									$value = "B".$tmpBranch_Name."_PGIM";
								} else {
									$value = "";
								}
							} else if ($paramFastToolsDestination == "DCXII") {
								// Define STATION for DCXII, Template from "DM-02-02-08-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT")
										|| ($results_data_item_df['TAG'] == "TOTAL")){
										$value = "DCXII";
								} else {
									$value = "N/A";
								}
							} else if ($paramFastToolsDestination == "PGIM_WTDC") {
								// Define STATION for PGIM_WTDC, Template from "U208"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "PT")){
										$value = "WTDC_PGIM";
								} else {
									$value = "N/A";
								}
							}





						} else if ($meta['name'] == "POINT") {
							
								/*  MODBUS_LINE_DF Partial */
							    							if (( $paramFastToolsDestination == "B&R X20")||($paramFastToolsDestination == "YOKOGAWA FCJ")||($paramFastToolsDestination == "SIXNET")||($paramFastToolsDestination == "ABB CTU800")) {
								// Define STATION for B&R X20, Template from "DM-01-04-04-01"
								// Define STATION for YOKOGAWA FCJ, Template from "DM-01-06-02-03"
								// Define STATION for SIXNET, Template from "DM-04-03-01-01"
								if ($results_data_item_df['TAG'] == "COMM_STS"){
									$value = "";
								} else {
									$value = $results_data_item_df['TAG'];
								}
							} else if (($paramFastToolsDestination == "MOXA") || ($paramFastToolsDestination == "WAGO")) {
								// Define STATION for MOXA, Template from "DM-01-06-03-02"
								// Define STATION for WAGO, Template from "DM-02-08-02-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT") 
										|| ($results_data_item_df['TAG'] == "TOTAL")){
										$value = $results_data_item_df['TAG'];
								} else {
									$value = "";
								}
							} else if ($paramFastToolsDestination == "ABB AC500") {
								// Define STATION for ABB AC500, Template from "DM-01-06-01-01"
								if (($results_data_item_df['TAG'] == "COMM_STS") || ($results_data_item_df['TAG'] == "PT_EXT_HI_ALM") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_HI_SP") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_LO_ALM") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_LO_SP")){
										$value = "";
								} else {
									$value = $results_data_item_df['TAG'];
								}
							} else if ($paramFastToolsDestination == "PGIM_BRANCH") {
								// Define STATION for PGIM_BRANCH, Template from "DM-02-15-01-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "ON") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT")
										|| ($results_data_item_df['TAG'] == "TOTAL")){
									$value = $tmpDM_Name.".".$results_data_item_df['TAG'];
								} else {
									$value = "";
								}
							} else if ($paramFastToolsDestination == "DCXII") {
								// Define STATION for DCXII, Template from "DM-02-02-08-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT")
										|| ($results_data_item_df['TAG'] == "TOTAL")){
										$value = $tmpDM_Name.".".$results_data_item_df['TAG'];
								} else {
									$value = "N/A";
								}
							} else if ($paramFastToolsDestination == "PGIM_WTDC") {
								// Define STATION for PGIM_WTDC, Template from "U208"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "PT")){
										$value = $tmpDM_Name.".".$results_data_item_df['TAG'];
								} else {
									$value = "N/A";
								}
							}

						} else if ($meta['name'] == "POINT_NAME") {
							
								/*  MODBUS_LINE_DF Partial */
							    							$tmpDM_Name = $paramListDM[$j-$startRow_item_df]->name;

							if (( $paramFastToolsDestination == "B&R X20")||($paramFastToolsDestination == "YOKOGAWA FCJ")||($paramFastToolsDestination == "SIXNET")||($paramFastToolsDestination == "ABB CTU800")) {
								// Define STATION for B&R X20, Template from "DM-01-04-04-01"
								// Define STATION for YOKOGAWA FCJ, Template from "DM-01-06-02-03"
								// Define STATION for SIXNET, Template from "DM-04-03-01-01"
								if ($results_data_item_df['TAG'] == "COMM_STS"){
									$value = ":";
								} else {
									$value = $tmpDM_Name.":".$results_data_item_df['TAG'];
								}
							} else if (($paramFastToolsDestination == "MOXA") || ($paramFastToolsDestination == "WAGO")) {
								// Define STATION for MOXA, Template from "DM-01-06-03-02"
								// Define STATION for WAGO, Template from "DM-02-08-02-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
																		   || ($results_data_item_df['TAG'] == "PT_EXT") 
																		   || ($results_data_item_df['TAG'] == "PT_INT") 
																		   || ($results_data_item_df['TAG'] == "TOTAL")){
									$value = $tmpDM_Name.":".$results_data_item_df['TAG'];
								} else {
									$value = $results_data_item_df[$meta['name']];
								}
							} else if ($paramFastToolsDestination == "ABB AC500") {
								// Define STATION for ABB AC500, Template from "DM-01-06-01-01"
								if (($results_data_item_df['TAG'] == "COMM_STS") || ($results_data_item_df['TAG'] == "PT_EXT_HI_ALM") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_HI_SP") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_LO_ALM") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_LO_SP")){
										$value = ":";
								} else {
									$value = $tmpDM_Name.":".$results_data_item_df['TAG'];
								}
							} else if ($paramFastToolsDestination == "PGIM_BRANCH") {
								// Define STATION for PGIM_BRANCH, Template from "DM-02-15-01-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "ON") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT")
										|| ($results_data_item_df['TAG'] == "TOTAL")){
									$value = "B".$tmpBranch_Name."_PGIM".":".$tmpDM_Name.".".$results_data_item_df['TAG'];
								} else {
									$value = ":";
								}
							} else if ($paramFastToolsDestination == "DCXII") {
								// Define STATION for DCXII, Template from "DM-02-02-08-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT")
										|| ($results_data_item_df['TAG'] == "TOTAL")){
										$value = "DCXII:".$tmpDM_Name.".".$results_data_item_df['TAG'];
								} else {
									$value = "N/A";
								}
							} else if ($paramFastToolsDestination == "PGIM_WTDC") {
								// Define STATION for PGIM_WTDC, Template from "U208"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "PT")){
										$value = "WTDC_PGIM:".$tmpDM_Name.".".$results_data_item_df['TAG'];
								} else {
									$value = "N/A";
								}
							}

						} else if ($meta['name'] == "AOI_1") {
							
							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_item_df[$meta['name']];
							} else {
								$tmpDM_Name = $paramListDM[$j-$startRow_item_df]->name;
								$tmpDatabaseAOI_Name = "DB".substr($tmpDM_Name, 3, 2);

								if ($results_data_item_df['TAG'] == "LOG_FREQ"){
									$value = $tmpDatabaseAOI_Name;
								} else {
									$value = $results_data_item_df[$meta['name']];
								}
							}

						} else {
							$tmpValue = $results_data_item_df[$meta['name']];
							$value = trim(preg_replace('/\t+/', '', $tmpValue));
						}
						
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
					}
				$k = $k +1;

			}

		}

	    /*  OBJECT_DF Partial */
	    		$sheetCount = $objPHPExcel->getSheetCount();

		/* Create Worksheet พร้อมกำหนดชื่อ */
		$objPHPExcel_OBJECT_DF_Worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'OBJECT_DF');
		$objPHPExcel->addSheet($objPHPExcel_OBJECT_DF_Worksheet, $sheetCount);
		$objPHPExcel_OBJECT_DF_Worksheet->setTitle('OBJECT_DF');

		/* กำหนดให้เป็น ActiveWorkSheet */
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex($sheetCount);


		/* Create Header */
		//$reports = $db->modbus_point_df[1];
		$results_header_object_df = $db->object_df()->where("templates = ?", "header_template")->fetch();

		$sth_object_df = $pdo->prepare("SELECT * FROM object_df WHERE templates = 'header_template'");
		$sth_object_df->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols_object_df = $sth_object_df->columnCount();
		$startRow_object_df = 2;
		$startColumn_object_df = 4;

		for ($i = $startColumn_object_df; $i < $numCols_object_df; $i++) {
			$meta = $sth_object_df->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn_object_df;
			$tmpValue = $results_header_object_df[$meta['name']];
			$value = trim(preg_replace('/\t+/', '', $tmpValue));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}




		/* Create Details */

		$numDM = count($paramListDM);  // จำนวน DM
		$z=1;
		for ($j=$startRow_object_df; $j < $numDM+$startRow_object_df; $j++) { 

			$results_data_object_dfs = $db->object_df()->where("templates = ? and rtu_install = ? and fasttools_destination = ?", "data_template", $paramRtuInstall, $paramFastToolsDestination);

			$k = 0;  // จำนวนแภวของ Template
			foreach ($results_data_object_dfs as $results_data_object_df) {

					$z = $z +1;
					for ($i = $startColumn_object_df; $i < $numCols_object_df; $i ++) {
						$meta = $sth_object_df->getColumnMeta($i);
						$row = $z;		// แถวที่ $row ของ Excel
						$col = $i-$startColumn_object_df;	// คอลัมภ์ที่ $col ของ Excel


						if ($meta['name'] == "UNIT") {

							if($paramRtuInstall == "PRODUCTION") {
								$value = "WTDC";
							} else {
								$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
								$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);
								$value = $tmpBranch_Name;
							}

						} else if ($meta['name'] == "TAG") {

							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$value = $tmpDM_Name;

						} else if ($meta['name'] == "DESCRIPTION") {
							
							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {
								$value = $paramFastToolsDestination;
							}

						} else if ($meta['name'] == "NAME") {
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								// PRODUCTION.WTDC.U208.U208
								$value = $paramRtuInstall.".WTDC.".$tmpDM_Name.".".$tmpDM_Name;
							} else {
								//SERVICE.B01.DM-01-06-03-02.DM-01-06-03-02
								$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".".$tmpDM_Name;
							}

						} else if ($meta['name'] == "ATTR_VALUE_1") {

							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								// PRODUCTION.WTDC.U208.FT
								$value = $paramRtuInstall.".WTDC.".$tmpDM_Name.".FT";
							} else {
								// SERVICE.B01.DM-01-06-03-02.FT
								$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".FT";
							}


						} else if ($meta['name'] == "ATTR_VALUE_2") {

							//SERVICE.B01.DM-01-06-03-02.FT_HI_ALM
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								// PRODUCTION.WTDC.U208.PT
								$value = $paramRtuInstall.".WTDC.".$tmpDM_Name.".PT";
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_FT_HI_ALM";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".FT_HI_ALM";
								}
								
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_3") {

							//SERVICE.B01.DM-01-06-03-02.FT_LO_ALM
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_FT_LO_ALM";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".FT_LO_ALM";
								}
							}

						} else if ($meta['name'] == "ATTR_VALUE_4") {

							//SERVICE.B01.DM-01-06-03-02.FT_HI_SP
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_FT_HI_SP";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".FT_HI_SP";
								}
							}

						} else if ($meta['name'] == "ATTR_VALUE_5") {

							//SERVICE.B01.DM-01-06-03-02.FT_LO_SP
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_FT_LO_SP";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".FT_LO_SP";
								}
							}

						} else if ($meta['name'] == "ATTR_VALUE_6") {

							//SERVICE.B01.DM-01-06-03-02.PT_INT
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								// if($paramFastToolsDestination == "DCXII") {
								// 	$value = "OTHER.DUMMY.DUMMY_FT_LO_SP";
								// } else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_INT";
								// }
							}

						} else if ($meta['name'] == "ATTR_VALUE_7") {

							//SERVICE.B01.DM-01-06-03-02.PT_INT_HI_ALM
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_INT_HI_ALM";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_INT_HI_ALM";
								}
							}

						} else if ($meta['name'] == "ATTR_VALUE_8") {

							//SERVICE.B01.DM-01-06-03-02.PT_INT_LO_ALM
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_INT_LO_ALM";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_INT_LO_ALM";
								}
							}

						} else if ($meta['name'] == "ATTR_VALUE_9") {

							//SERVICE.B01.DM-01-06-03-02.PT_INT_HI_SP
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_INT_HI_SP";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_INT_HI_SP";
								}
							}

						} else if ($meta['name'] == "ATTR_VALUE_10") {

							//SERVICE.B01.DM-01-06-03-02.PT_INT_LO_SP
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_INT_LO_SP";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_INT_LO_SP";
								}
							}

						} else if ($meta['name'] == "ATTR_VALUE_11") {

							//SERVICE.B01.DM-01-06-03-02.PT_EXT
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if($paramFastToolsDestination == "ABB CTU800") {
									$value = "OTHER.DUMMY.DUMMY_PT_EXT";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_EXT";
								}
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_12") {

							//SERVICE.B01.DM-01-06-03-02.PT_EXT_HI_ALM
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_EXT_HI_ALM";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_EXT_HI_ALM";
								}
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_13") {

							//SERVICE.B01.DM-01-06-03-02.PT_EXT_LO_ALM
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_EXT_LO_ALM";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_EXT_LO_ALM";
								}
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_14") {

							//SERVICE.B01.DM-01-06-03-02.PT_EXT_HI_SP
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_EXT_HI_SP";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_EXT_HI_SP";
								}
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_15") {

							//SERVICE.B01.DM-01-06-03-02.PT_EXT_LO_SP
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_EXT_LO_SP";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_EXT_LO_SP";
								}
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_16") {

							//SERVICE.B01.DM-01-06-03-02.TOTAL
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								// if($paramFastToolsDestination == "DCXII") {
								// 	$value = "OTHER.DUMMY.DUMMY_PT_EXT_LO_SP";
								// } else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".TOTAL";
								// }
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_17") {

							//SERVICE.B01.DM-01-06-03-02.LOG_FREQ
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								// if($paramFastToolsDestination == "DCXII") {
								// 	$value = "OTHER.DUMMY.DUMMY_PT_EXT_LO_SP";
								// } else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".LOG_FREQ";
								// }
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_18") {

							//SERVICE.B01.DM-01-06-03-02.COMM_STS
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if($paramFastToolsDestination == "PGIM_BRANCH") {
									$value = "OTHER.DUMMY.DUMMY_COMM_STS";
								} else if($paramFastToolsDestination == "DCXII") {
									$value = "OTHER.DUMMY.DUMMY_COMM_STS";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".COMM_STS";
								}
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_19") {

							//SERVICE.B01.DM-01-06-03-02.COMM_STS
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if($paramFastToolsDestination == "PGIM_BRANCH") {
									// SERVICE.B02.DM-02-15-01-01.ON
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".ON";
								} else {
									$value = "OTHER.DUMMY.DUMMY_ON";
								}
							}
							

						} else {
							$tmpValue = $results_data_object_df[$meta['name']];
							$value = trim(preg_replace('/\t+/', '', $tmpValue));
						}
						
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
					}
				$k = $k +1;

			}

		}





	    /*  ITEM_HIS_DF Partial */
	    		$sheetCount = $objPHPExcel->getSheetCount();

		/* Create Worksheet พร้อมกำหนดชื่อ */
		$objPHPExcel_ITEM_HIS_DF_Worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'ITEM_HIS_DF');
		$objPHPExcel->addSheet($objPHPExcel_ITEM_HIS_DF_Worksheet, $sheetCount);
		$objPHPExcel_ITEM_HIS_DF_Worksheet->setTitle('ITEM_HIS_DF');

		/* กำหนดให้เป็น ActiveWorkSheet */
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex($sheetCount);


		/* Create Header */
		//$reports = $db->modbus_point_df[1];
		$results_header_item_his_df = $db->item_his_df()->where("templates = ?", "header_template")->fetch();

		$sth_item_his_df = $pdo->prepare("SELECT * FROM item_his_df WHERE templates = 'header_template'");
		$sth_item_his_df->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols_item_his_df = $sth_item_his_df->columnCount();
		$startRow_item_his_df = 2;
		$startColumn_item_his_df = 4;

		for ($i = $startColumn_item_his_df; $i < $numCols_item_his_df; $i++) {
			$meta = $sth_item_his_df->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn_item_his_df;
			$tmpValue = $results_header_item_his_df[$meta['name']];
			$value = trim(preg_replace('/\t+/', '', $tmpValue));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}




		/* Create Details */

		$numDM = count($paramListDM);  // จำนวน DM
		$z=1;
		for ($j=$startRow_item_his_df; $j < $numDM+$startRow_item_his_df; $j++) { 

			$results_data_item_his_dfs = $db->item_his_df()->where("templates = ? and rtu_install = ? and fasttools_destination = ?", "data_template", $paramRtuInstall, $paramFastToolsDestination);

			$k = 0;  // จำนวนแภวของ Template
			foreach ($results_data_item_his_dfs as $results_data_item_his_df) {

					$z = $z +1;
					for ($i = $startColumn_item_his_df; $i < $numCols_item_his_df; $i ++) {
						$meta = $sth_item_his_df->getColumnMeta($i);
						$row = $z;		// แถวที่ $row ของ Excel
						$col = $i-$startColumn_item_his_df;	// คอลัมภ์ที่ $col ของ Excel

// TEN_SECONDS:SERVICE.B01.DM-01-06-03-02.FT
// TEN_SECONDS:SERVICE.B01.DM-01-06-03-02.PT_INT
// TEN_SECONDS:SERVICE.B01.DM-01-06-03-02.PT_EXT

						if ($meta['name'] == "NAME") {

							$tmpDM_Name = $paramListDM[$j-$startRow_item_his_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							$tmpValue = $results_data_item_his_df[$meta['name']];

							if($paramRtuInstall == "PRODUCTION") {
								// TEN_SECONDS:PRODUCTION.WTDC.U208.FT
								if ((substr($tmpValue, -2) == "FT")) {
									$value = $results_data_item_his_df['GROUP_NAME'].":".$paramRtuInstall.".WTDC.".$tmpDM_Name.".FT";
								} else if ((substr($tmpValue, -2) == "PT")) {
									$value = $results_data_item_his_df['GROUP_NAME'].":".$paramRtuInstall.".WTDC.".$tmpDM_Name.".PT";
								} else {
									$value = "N/A";
								}

							} else if($paramRtuInstall == "ABB CTU800"){

								if ((substr($tmpValue, -2) == "FT")) {
									// TEN_SECONDS:SERVICE.B03.DM-03-01-03-01.FT
									$value = $results_data_item_his_df['GROUP_NAME'].":".$paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".FT";
								} else if ((substr($tmpValue, -6) == "PT_INT")) {
									// TEN_SECONDS:SERVICE.B03.DM-03-01-03-01.PT_INT
									$value = $results_data_item_his_df['GROUP_NAME'].":".$paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_INT";
								}

							} else {
								// TEN_SECONDS:SERVICE.B02.DM-02-02-08-01.PT_EXT
								if ((substr($tmpValue, -2) == "FT")) {
									$value = $results_data_item_his_df['GROUP_NAME'].":".$paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".FT";
								} else if ((substr($tmpValue, -6) == "PT_INT")) {
									$value = $results_data_item_his_df['GROUP_NAME'].":".$paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_INT";
								} else if ((substr($tmpValue, -6) == "PT_EXT")) {
									$value = $results_data_item_his_df['GROUP_NAME'].":".$paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_EXT";
								}

							}

							

						} else {
							$tmpValue = $results_data_item_his_df[$meta['name']];
							$value = trim(preg_replace('/\t+/', '', $tmpValue));
						}
						
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
					}
				$k = $k +1;

			}

		}






		/* ************************* */
        /* เริ่มกระบวนการสร้าง Excel file */
        /* ************************* */

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");


		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="01simple.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$date = new DateTime();
		$fileName = 'Quickload_for_MODBUS('.$paramFastToolsDestination.')'.'_'.date("Y-m-d").'_'.$date->getTimestamp().'.xls';
		$filePath = '../../files/'.$fileName;
		$objWriter->save($filePath);



	    /* ************************* */
	    /* เริ่มกระบวนการส่งค่ากลับ */
	    /* ************************* */
	    $reports[] = array(
	    		"filename" => $fileName,
	    		"path" => url()."/scada-it/build/files/".$fileName
	    	);


	    $resultText = "success";

	    $reportResult = array("result" =>  $resultText, "rows" => $reports);
	    //$reportResult = array("result" =>  $resultText);

	    $app->response()->header("Content-Type", "application/json");
	    echo json_encode($reportResult);


    }
    
	/**
	 *
	 * @apiName OPCDAC_Manager
	 * @apiGroup Fast_Tools
	 * @apiVersion 0.1.0
	 *
	 * @api {post} /FastToolsAPI/OPCDAC_Manager/ OPCDAC_Manager
	 * @apiDescription คำอธิบาย : ในส่วนนี้ใช้สำหรับสร้าง FAST/TOOLS Quickload สำหรับโปรโตคอล OPCDAC
	 *
	 *
	 *
	 * @apiParam {String} rtu_install = "SERVICE" คำอธิบายกลุ่มของอุปกรณ์ เช่น SERVICE, PRODUCTION, OTHER
	 * @apiParam {String} fasttools_destination = "DCXII" คำอธิบายชนิดของอุปกรณ์ เช่น <br/> <b style='color:red'>PGIM_BRANCH</b> หมายถึงการเชื่อมต่อระหว่าง Fast/Tools กับ PGIM ที่สาขาผ่านทาง DCOM, <br/> <b style='color:red'>DCXII</b> หมายถึงการเชื่อมต่อระหว่าง Fast/Tools กับ DCXII ผ่านทางโปรแกรม KEPWareEx , <br/> <b style='color:red'>PGIM_WTDC</b> หมายถึงการเชื่อมต่อระหว่าง Fast/Tools กับ PGIM ที่ ฝคจ. ผ่านทางโปรแกรม Matrikon Tunneller
     * @apiParam {Object[]} listDM  รายการ DM
     * @apiParam {String} listDM.name = "DM-01-01-01-01" ชื่อ DM
     *
     * @apiParamExample {json} Request-Example (ตัวอย่าง Payload, Content-Type: application/json):
     *  {
     *      "rtu_install": "SERVICE",
     *      "fasttools_destination": "PGIM_BRANCH",
     *      "listDM": [
     *          {
     *              "name": "DM-04-03-01-01"
     *          },
     *          {
     *              "name": "DM-17-03-04-02"
     *          },
     *          {
     *              "name": "DM-17-07-02-01"
     *          },
     *          {
     *              "name": "DM-13-07-07-01"
     *          }
     *      ]
     *  }
     *
	 * @apiSampleRequest /FastToolsAPI/OPCDAC_Manager/
	 *
	 * @apiSuccess (คำอธิบายผลลัพธ์ (กรณีส่งค่ากลับสำเร็จ Success 200)) {String} msg แสดงข้อความทักทายผู้ใช้งาน
	 *
	 * @apiSuccessExample Example data on success:
     *  {
     *      "result": "success",
     *      "rows": [
     *          {
     *              "filename": "Quickload_for_OPCDAC(PGIM_WTDC)_2015-08-15_1439607474.xls",
     *              "path": "http://localhost/scada-it/build/files/Quickload_for_OPCDAC(PGIM_WTDC)_2015-08-15_1439607474.xls"
     *          }
     *      ]
     *  }
	 *
	 * @apiError (คำอธิบายผลลัพธ์ (กรณีเกิด Error 4xx)) UserNotFound The <code>id</code> of the User was not found.
	 * @apiErrorExample {json} Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "UserNotFound"
	 *     }
	 *
	 */
    function OPCDAC_Manager($app, $pdo, $db, $objPHPExcel) {

        /* ************************* */
        /* เริ่มกระบวนการรับค่าพารามิเตอร์จากส่วนของ Payload ซึ่งอยู่ในรูปแบบ JSON */
        /* ************************* */
        $headers = $app->request->headers;
        $ContetnType = $app->request->headers->get('Content-Type');

        /**
        * apidoc @apiSampleRequest, iOS RESTKit use content-type is "application/json"
        * Web Form, Advance REST Client App use content-type is "application/x-www-form-urlencoded"
        */
        if ($ContetnType == "application/json") {

	        $request = $app->request();
	        $result = json_decode($request->getBody());

	        /* receive request */
	        $paramRtuInstall = $result->rtu_install;
	        $paramFastToolsDestination = $result->fasttools_destination;
	        $paramListDM = $result->listDM;

 
		} else if ($ContetnType == "application/x-www-form-urlencoded"){

		    //$userID = $app->request()->params('userID_param');
		    //$userID = $app->request()->post('userID_param');
		}


		/* ************************* */
        /* เริ่มกระบวนการเชื่อมต่อกับฐานข้อมูล MySQL */
        /* ************************* */

        $reports = array();

		/*  OPCDAC_LINE_DF Partial */
	    		/* Create Header */
		//$reports = $db->modbus_point_df[1];
		$results_header_opcdac_line_df = $db->opcdac_line_df()->where("templates = ?", "header_template")->fetch();

		$sth_opcdac_line_df = $pdo->prepare("SELECT * FROM opcdac_line_df WHERE templates = 'header_template'");
		$sth_opcdac_line_df->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols_opcdac_line_df = $sth_opcdac_line_df->columnCount();
		$startRow_opcdac_line_df = 2;
		$startColumn_opcdac_line_df = 4;

		for ($i = $startColumn_opcdac_line_df; $i < $numCols_opcdac_line_df; $i++) {
			$meta = $sth_opcdac_line_df->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn_opcdac_line_df;
			$value = $results_header_opcdac_line_df[$meta['name']];
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}




		/* Create Details */
		$numDM = count($paramListDM);  // จำนวน DM
		$z=1;
		for ($j=$startRow_opcdac_line_df; $j < $numDM+$startRow_opcdac_line_df; $j++) { 

			$results_data_opcdac_line_dfs = $db->opcdac_line_df()->where("templates = ? and rtu_install = ? and fasttools_destination = ?", "data_template", $paramRtuInstall, $paramFastToolsDestination);

			$k = 0;  // จำนวนแภวของ Template
			foreach ($results_data_opcdac_line_dfs as $results_data_opcdac_line_df) {
					$z = $z +1;
					for ($i = $startColumn_opcdac_line_df; $i < $numCols_opcdac_line_df; $i ++) {
						$meta = $sth_opcdac_line_df->getColumnMeta($i);
						$row = $z;		// แถวที่ $row ของ Excel
						$col = $i-$startColumn_opcdac_line_df;	// คอลัมภ์ที่ $col ของ Excel


						if ($meta['name'] == "NAME") {

							if($paramFastToolsDestination == "PGIM_BRANCH") {
								$tmpDM_Name = $paramListDM[$j-$startRow_opcdac_line_df]->name;
								$tmpBranchCode = substr($tmpDM_Name, 3, 2);
								$value = "B".$tmpBranchCode."OPC";
							} else if($paramFastToolsDestination == "DCXII") {
								$value = "DCX";
							} else if($paramFastToolsDestination == "PGIM_WTDC") {
								$value = "WTDC_OPC";
							} else {
								$value = "N/A";
							}
							
						} else if($meta['name'] == "DESCRIPTION") {

							if($paramFastToolsDestination == "PGIM_BRANCH") {
								$tmpDM_Name = $paramListDM[$j-$startRow_opcdac_line_df]->name;
								$tmpBranchCode = substr($tmpDM_Name, 3, 2);
								$value = "B".$tmpBranchCode." PGIM Interface";
							} else if($paramFastToolsDestination == "DCXII") {
								$value = "DCX Localhost Interface";
							} else if($paramFastToolsDestination == "PGIM_WTDC") {
								$value = "WTDC PGIM Interface";
							} else {
								$value = "N/A";
							}

						} else if($meta['name'] == "EQUIPMENT_MAN") {

							if($paramFastToolsDestination == "PGIM_BRANCH") {
								$tmpDM_Name = $paramListDM[$j-$startRow_opcdac_line_df]->name;
								$tmpBranchCode = substr($tmpDM_Name, 3, 2);
								$value = "OPXDAC_B".$tmpBranchCode;
							} else if($paramFastToolsDestination == "DCXII") {
								$value = "OPXDAC_DCX";
							} else if($paramFastToolsDestination == "PGIM_WTDC") {
								$value = "OPXDAC_WTDC";
							} else {
								$value = "N/A";
							}

						} else {
							$value = $results_data_opcdac_line_df[$meta['name']];
						}
						
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
					}
				$k = $k +1;
			}

		}

		/* Set Title */
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('OPCDAC_LINE_DF');


	    /*  OPCDAC_GROUP_DF Partial */
	    		$sheetCount = $objPHPExcel->getSheetCount();

		/* Create Worksheet พร้อมกำหนดชื่อ */
		$objPHPExcel_OPCDAC_GROUP_DF_Worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'OPCDAC_GROUP_DF');
		$objPHPExcel->addSheet($objPHPExcel_OPCDAC_GROUP_DF_Worksheet, $sheetCount);
		$objPHPExcel_OPCDAC_GROUP_DF_Worksheet->setTitle('OPCDAC_GROUP_DF');

		/* กำหนดให้เป็น ActiveWorkSheet */
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex($sheetCount);


		/* ************************* */
        /* เริ่มกระบวนการสร้าง Quickload for MODBUS (MODBUS_STATION_DF) */
        /* ************************* */

		/* Create Header */
		//$reports = $db->modbus_station_df[1];
		//$results_header = $db->opcdac_station_df()->where("templates = ?", "header_template")->fetch();
		$results_header_opcdac_group_df = $db->opcdac_group_df()->where("templates = ?", "header_template")->fetch();

        $sth_opcdac_group_df = $pdo->prepare("SELECT * FROM opcdac_group_df WHERE templates = 'header_template'");
        $sth_opcdac_group_df->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols_opcdac_group_df = $sth_opcdac_group_df->columnCount();
		$startRow_opcdac_group_df = 2;
		$startColumn_opcdac_group_df = 4;

		for ($i = $startColumn_opcdac_group_df; $i < $numCols_opcdac_group_df; $i ++) {
			$meta = $sth_opcdac_group_df->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn_opcdac_group_df;
			$tmpValue = $results_header_opcdac_group_df[$meta['name']];
			$value = trim(preg_replace('/\t+/', '', $tmpValue));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}





		/* Create Details */
		$numDM = count($paramListDM);  // จำนวน DM
		$z=1;
		for ($j=$startRow_opcdac_group_df; $j < $numDM+$startRow_opcdac_group_df; $j++) { 

			$results_data_opcdac_group_dfs = $db->opcdac_group_df()->where("templates = ? and rtu_install = ? and fasttools_destination = ?", "data_template", $paramRtuInstall, $paramFastToolsDestination);

			$k = 0;  // จำนวนแภวของ Template
			foreach ($results_data_opcdac_group_dfs as $results_data_opcdac_group_df) {
					$z = $z +1;
					for ($i = $startColumn_opcdac_group_df; $i < $numCols_opcdac_group_df; $i ++) {
						$meta = $sth_opcdac_group_df->getColumnMeta($i);
						$row = $z;		// แถวที่ $row ของ Excel
						$col = $i-$startColumn_opcdac_group_df;	// คอลัมภ์ที่ $col ของ Excel


						 if ($meta['name'] == "STATION_NAME") {

							if($paramFastToolsDestination == "PGIM_BRANCH") {
								$tmpDM_Name = $paramListDM[$j-$startRow_opcdac_line_df]->name;
								$tmpBranchCode = substr($tmpDM_Name, 3, 2);
								$value = "B".$tmpBranchCode."_PGIM";
							} else if($paramFastToolsDestination == "DCXII") {
								$value = "DCXII";
							} else if($paramFastToolsDestination == "PGIM_WTDC") {
								$value = "WTDC_PGIM";
							} else {
								$value = "N/A";
							}

						 } else if ($meta['name'] == "DESCRIPTION") {

								$tmpDM_Name = $paramListDM[$j-$startRow_opcdac_line_df]->name;
								$value = $tmpDM_Name;

						 } else if ($meta['name'] == "NAME") {

							if($paramFastToolsDestination == "PGIM_BRANCH") {
								//B02_PGIM:DM-02-15-01-01
								$tmpDM_Name = $paramListDM[$j-$startRow_opcdac_line_df]->name;
								$tmpBranchCode = substr($tmpDM_Name, 3, 2);

								$value = "B".$tmpBranchCode."_PGIM:".$tmpDM_Name;

							} else if($paramFastToolsDestination == "DCXII") {
								$value = "DCXII:".$tmpDM_Name;
							} else if($paramFastToolsDestination == "PGIM_WTDC") {
								$value = "WTDC_PGIM:".$tmpDM_Name;
							} else {
								$value = "N/A";
							}
							
						 } else {
							$value = $results_data_opcdac_group_df[$meta['name']];
						 }

						 //$value = $results_data_opcdac_group_df[$meta['name']];
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
					}
				$k = $k +1;
			}

		}







		/*  OPCDAC_STATION_DF Partial */
	    		$sheetCount = $objPHPExcel->getSheetCount();

		/* Create Worksheet พร้อมกำหนดชื่อ */
		$objPHPExcel_OPCDAC_STATION_DF_Worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'OPCDAC_STATION_DF');
		$objPHPExcel->addSheet($objPHPExcel_OPCDAC_STATION_DF_Worksheet, $sheetCount);
		$objPHPExcel_OPCDAC_STATION_DF_Worksheet->setTitle('OPCDAC_STATION_DF');

		/* กำหนดให้เป็น ActiveWorkSheet */
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex($sheetCount);


		/* ************************* */
        /* เริ่มกระบวนการสร้าง Quickload for MODBUS (MODBUS_STATION_DF) */
        /* ************************* */

		/* Create Header */
		//$reports = $db->modbus_station_df[1];
		//$results_header = $db->opcdac_station_df()->where("templates = ?", "header_template")->fetch();
		$results_header_opcdac_station_df = $db->opcdac_station_df()->where("templates = ?", "header_template")->fetch();

        $sth_opcdac_station_df = $pdo->prepare("SELECT * FROM opcdac_station_df WHERE templates = 'header_template'");
        $sth_opcdac_station_df->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols_opcdac_station_df = $sth_opcdac_station_df->columnCount();
		$startRow_opcdac_station_df = 2;
		$startColumn_opcdac_station_df = 4;

		for ($i = $startColumn_opcdac_station_df; $i < $numCols_opcdac_station_df; $i ++) {
			$meta = $sth_opcdac_station_df->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn_opcdac_station_df;
			$value = $results_header_opcdac_station_df[$meta['name']];
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}




		/* Create Details */
		$numDM = count($paramListDM);  // จำนวน DM
		$z=1;
		for ($j=$startRow_opcdac_station_df; $j < $numDM+$startRow_opcdac_station_df; $j++) { 

			//$results_data_opcdac_station_dfs = $db->opcdac_station_df()->where("templates = ? and rtu_install = ? and rtu_modbus_brand = ?", "data_template", $paramRtuInstall, $paramRtuModbusBrand);
			$results_data_opcdac_station_dfs = $db->opcdac_station_df()->where("templates = ? and rtu_install = ? and fasttools_destination = ?", "data_template", $paramRtuInstall, $paramFastToolsDestination);

			$k = 0;  // จำนวนแภวของ Template
			foreach ($results_data_opcdac_station_dfs as $results_data_opcdac_station_df) {
					$z = $z +1;
					for ($i = $startColumn_opcdac_station_df; $i < $numCols_opcdac_station_df; $i ++) {
						$meta = $sth_opcdac_station_df->getColumnMeta($i);
						$row = $z;		// แถวที่ $row ของ Excel
						$col = $i-$startColumn_opcdac_station_df;	// คอลัมภ์ที่ $col ของ Excel


						 if ($meta['name'] == "NAME") {

							if($paramFastToolsDestination == "PGIM_BRANCH") {
								$tmpDM_Name = $paramListDM[$j-$startRow_opcdac_line_df]->name;
								$tmpBranchCode = substr($tmpDM_Name, 3, 2);
								$value = "B".$tmpBranchCode."_PGIM";
							} else if($paramFastToolsDestination == "DCXII") {
								$value = "DCXII";
							} else if($paramFastToolsDestination == "PGIM_WTDC") {
								$value = "WTDC_PGIM";
							} else {
								$value = "N/A";
							}

						 } else if ($meta['name'] == "LINE") {

							if($paramFastToolsDestination == "PGIM_BRANCH") {
								$tmpDM_Name = $paramListDM[$j-$startRow_opcdac_line_df]->name;
								$tmpBranchCode = substr($tmpDM_Name, 3, 2);
								$value = "B".$tmpBranchCode."OPC";
							} else if($paramFastToolsDestination == "DCXII") {
								$value = "DCX";
							} else if($paramFastToolsDestination == "PGIM_WTDC") {
								$value = "WTDC_OPC";
							} else {
								$value = "N/A";
							}

						 } else if ($meta['name'] == "OPC_SERVER_NODE") {

							if($paramFastToolsDestination == "PGIM_BRANCH") {
								$tmpDM_Name = $paramListDM[$j-$startRow_opcdac_line_df]->name;
								$tmpBranchCode = substr($tmpDM_Name, 3, 2);

								if (substr($tmpBranchCode,0,1)=="0") {
									$value = "WL-WLMS-1".$tmpBranchCode;
								} else {
									$value = "WL-WLMS-".$tmpBranchCode;
								}
							} else if($paramFastToolsDestination == "DCXII") {
								$value = "localhost";
							} else if($paramFastToolsDestination == "PGIM_WTDC") {
								$value = "localhost";
							} else {
								$value = "N/A";
							}
							
						 } else {
							$value = $results_data_opcdac_station_df[$meta['name']];
						 }
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
					}
				$k = $k +1;
			}

		}







	    /*  OPCDAC_POINT_DF Partial */
	    		$sheetCount = $objPHPExcel->getSheetCount();

		/* Create Worksheet พร้อมกำหนดชื่อ */
		$objPHPExcel_OPCDAC_POINT_DF_Worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'OPCDAC_POINT_DF');
		$objPHPExcel->addSheet($objPHPExcel_OPCDAC_POINT_DF_Worksheet, $sheetCount);
		$objPHPExcel_OPCDAC_POINT_DF_Worksheet->setTitle('OPCDAC_POINT_DF');

		/* กำหนดให้เป็น ActiveWorkSheet */
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex($sheetCount);


		/* ************************* */
        /* เริ่มกระบวนการสร้าง Quickload for MODBUS (MODBUS_STATION_DF) */
        /* ************************* */

		/* Create Header */
		//$reports = $db->modbus_station_df[1];
		//$results_header = $db->opcdac_station_df()->where("templates = ?", "header_template")->fetch();
		$results_header_opcdac_point_df = $db->opcdac_point_df()->where("templates = ?", "header_template")->fetch();

        $sth_opcdac_point_df = $pdo->prepare("SELECT * FROM opcdac_point_df WHERE templates = 'header_template'");
        $sth_opcdac_point_df->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols_opcdac_point_df = $sth_opcdac_point_df->columnCount();
		$startRow_opcdac_point_df = 2;
		$startColumn_opcdac_point_df = 4;

		for ($i = $startColumn_opcdac_point_df; $i < $numCols_opcdac_point_df; $i ++) {
			$meta = $sth_opcdac_point_df->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn_opcdac_point_df;
			$tmpValue = $results_header_opcdac_point_df[$meta['name']];
			$value = trim(preg_replace('/\t+/', '', $tmpValue));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}





		/* Create Details */
		$numDM = count($paramListDM);  // จำนวน DM
		$z=1;
		for ($j=$startRow_opcdac_point_df; $j < $numDM+$startRow_opcdac_point_df; $j++) { 

			$results_data_opcdac_point_dfs = $db->opcdac_point_df()->where("templates = ? and rtu_install = ? and fasttools_destination = ?", "data_template", $paramRtuInstall, $paramFastToolsDestination);

			$k = 0;  // จำนวนแภวของ Template
			foreach ($results_data_opcdac_point_dfs as $results_data_opcdac_point_df) {
					$z = $z +1;
					for ($i = $startColumn_opcdac_point_df; $i < $numCols_opcdac_point_df; $i ++) {
						$meta = $sth_opcdac_point_df->getColumnMeta($i);
						$row = $z;		// แถวที่ $row ของ Excel
						$col = $i-$startColumn_opcdac_point_df;	// คอลัมภ์ที่ $col ของ Excel


						 if ($meta['name'] == "STATION") {

							if($paramFastToolsDestination == "PGIM_BRANCH") {
								$tmpDM_Name = $paramListDM[$j-$startRow_opcdac_line_df]->name;
								$tmpBranchCode = substr($tmpDM_Name, 3, 2);
								$value = "B".$tmpBranchCode."_PGIM";
							} else if($paramFastToolsDestination == "DCXII") {
								$value = "DCXII";
							} else if($paramFastToolsDestination == "PGIM_WTDC") {
								$value = "WTDC_PGIM";
							} else {
								$value = "N/A";
							}

						 } else if ($meta['name'] == "DESCRIPTION") {

								$tmpDM_Name = $paramListDM[$j-$startRow_opcdac_line_df]->name;
								$value = "";

						 } else if ($meta['name'] == "OPC_GROUP") {

								$value = $tmpDM_Name;
							
						 } else if ($meta['name'] == "POINT") {

						 	$tmpOriginal = $results_data_opcdac_point_df[$meta['name']];
							$tmpDM_Name = $paramListDM[$j-$startRow_opcdac_line_df]->name;
							$tmpBranchCode = substr($tmpDM_Name, 3, 2);

							if($paramFastToolsDestination == "PGIM_BRANCH") {
								$value = str_replace("DM-02-15-01-01", $tmpDM_Name, $tmpOriginal);
							} else if($paramFastToolsDestination == "DCXII") {
								$value = str_replace("DM-02-02-08-01", $tmpDM_Name, $tmpOriginal);
							} else if($paramFastToolsDestination == "PGIM_WTDC") {
								$value = str_replace("U208", $tmpDM_Name, $tmpOriginal);
							} else {
								$value = "N/A";
							}

						 } else if ($meta['name'] == "NAME") {

						 	$tmpOriginal = $results_data_opcdac_point_df[$meta['name']];
							$tmpDM_Name = $paramListDM[$j-$startRow_opcdac_line_df]->name;
							$tmpBranchCode = substr($tmpDM_Name, 3, 2);

							if($paramFastToolsDestination == "PGIM_BRANCH") {
								$value = "B".$tmpBranchCode."_PGIM:".str_replace("B02_PGIM:DM-02-15-01-01", $tmpDM_Name, $tmpOriginal);
							} else if($paramFastToolsDestination == "DCXII") {
								$value = str_replace("DM-02-02-08-01", $tmpDM_Name, $tmpOriginal);
							} else if($paramFastToolsDestination == "PGIM_WTDC") {
								$value = str_replace("U208", $tmpDM_Name, $tmpOriginal);
							} else {
								$value = "N/A";
							}

						 } else if ($meta['name'] == "OPC_TAG") {

						 	$tmpOriginal = $results_data_opcdac_point_df[$meta['name']];
							$tmpDM_Name = $paramListDM[$j-$startRow_opcdac_line_df]->name;
							$tmpBranchCode = substr($tmpDM_Name, 3, 2);
							$tmpZoneCode = substr($tmpDM_Name, 6, 2);

							if($paramFastToolsDestination == "PGIM_BRANCH") {
								//WL-WLMS-102\DCXII\DM-02-15-01-01-F1
								if (substr($tmpBranchCode,0,1)=="0") {
									$tmp1 = "WL-WLMS-1".$tmpBranchCode;
									$tmp2 = str_replace("DM-02-02-08-01", $tmpDM_Name, $tmpOriginal);
									$value = str_replace("WL-WLMS-102", $tmp1, $tmp2);
								} else {
									$tmp1 = "WL-WLMS-".$tmpBranchCode;
									$tmp2 = str_replace("DM-02-02-08-01", $tmpDM_Name, $tmpOriginal);
									$value = str_replace("WL-WLMS-102", $tmp1, $tmp2);
								}
							} else if($paramFastToolsDestination == "DCXII") {
								//B02_02.DM-02-02-08-01.Flow
								$tmpReplaceBrancZone = str_replace("B02_02", "B".$tmpBranchCode."_".$tmpZoneCode, $tmpOriginal);
								$tmpReplaceDM = str_replace("DM-02-02-08-01", $tmpDM_Name, $tmpReplaceBrancZone);
								$value = $tmpReplaceDM;
							} else if($paramFastToolsDestination == "PGIM_WTDC") {
								//DC-SCADA-PGSCAN\OPCScanner_1\Applications.Application_1.Program2.FU208
								$value = str_replace("U208", $tmpDM_Name, $tmpOriginal);
							} else {
								$value = "N/A";
							}

						 } else {
							$value = $results_data_opcdac_point_df[$meta['name']];
						 }

						 //$value = $results_data_opcdac_point_df[$meta['name']];
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
					}
				$k = $k +1;
			}

		}







	    /*  SECTION_DF Partial */
	    		$sheetCount = $objPHPExcel->getSheetCount();

		/* Create Worksheet พร้อมกำหนดชื่อ */
		$objPHPExcel_SECTION_DF_Worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'SECTION_DF');
		$objPHPExcel->addSheet($objPHPExcel_SECTION_DF_Worksheet, $sheetCount);
		$objPHPExcel_SECTION_DF_Worksheet->setTitle('SECTION_DF');

		/* กำหนดให้เป็น ActiveWorkSheet */
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex($sheetCount);


		/* Create Header */
		//$reports = $db->modbus_point_df[1];
		$results_header_section_df = $db->section_df()->where("templates = ?", "header_template")->fetch();

		$sth_section_df = $pdo->prepare("SELECT * FROM section_df WHERE templates = 'header_template'");
		$sth_section_df->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols_section_df = $sth_section_df->columnCount();
		$startRow_section_df = 2;
		$startColumn_section_df = 4;

		for ($i = $startColumn_section_df; $i < $numCols_section_df; $i++) {
			$meta = $sth_section_df->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn_section_df;
			$tmpValue = $results_header_section_df[$meta['name']];
			$value = trim(preg_replace('/\t+/', '', $tmpValue));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}




		/* Create Details */

		$numDM = count($paramListDM);  // จำนวน DM
		$z=1;
		for ($j=$startRow_section_df; $j < $numDM+$startRow_section_df; $j++) { 

			$results_data_section_dfs = $db->section_df()->where("templates = ? and rtu_install = ? and fasttools_destination = ?", "data_template", $paramRtuInstall, $paramFastToolsDestination);

			$k = 0;  // จำนวนแภวของ Template
			foreach ($results_data_section_dfs as $results_data_section_df) {

					$z = $z +1;
					for ($i = $startColumn_section_df; $i < $numCols_section_df; $i ++) {
						$meta = $sth_section_df->getColumnMeta($i);
						$row = $z;		// แถวที่ $row ของ Excel
						$col = $i-$startColumn_section_df;	// คอลัมภ์ที่ $col ของ Excel


						if ($meta['name'] == "SECTION_NAME") {
							$value = $paramListDM[$j-$startRow_section_df]->name;
						} else if($meta['name'] == "NAME"){

							if($paramRtuInstall == "PRODUCTION") {
								// PRODUCTION.WTDC.U208
								$tmpDM_Name = $paramListDM[$j-$startRow_section_df]->name;
								$value = "PRODUCTION.WTDC.".$tmpDM_Name;
							} else {
								// SERVICE.B54.DM-54-04-05-01
								$tmpDM_Name = $paramListDM[$j-$startRow_section_df]->name;
								$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);
								$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name;
							}

						} else if($meta['name'] == "DESCRIPTION"){
							
							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_section_df[$meta['name']];
							} else {
								$tmpDM_Name = $paramListDM[$j-$startRow_section_df]->name;
								$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);
								$value = $tmpBranch_Name;
							}

						} else {
							$tmpValue = $results_data_section_df[$meta['name']];
							$value = trim(preg_replace('/\t+/', '', $tmpValue));
						}
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
					}
				$k = $k +1;

			}

		}





	    /*  ITEM_DF Partial */
	    		$sheetCount = $objPHPExcel->getSheetCount();

		/* Create Worksheet พร้อมกำหนดชื่อ */
		$objPHPExcel_ITEM_DF_Worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'ITEM_DF');
		$objPHPExcel->addSheet($objPHPExcel_ITEM_DF_Worksheet, $sheetCount);
		$objPHPExcel_ITEM_DF_Worksheet->setTitle('ITEM_DF');

		/* กำหนดให้เป็น ActiveWorkSheet */
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex($sheetCount);


		/* Create Header */
		//$reports = $db->modbus_point_df[1];
		$results_header_item_df = $db->item_df()->where("templates = ?", "header_template")->fetch();

		$sth_item_df = $pdo->prepare("SELECT * FROM item_df WHERE templates = 'header_template'");
		$sth_item_df->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols_item_df = $sth_item_df->columnCount();
		$startRow_item_df = 2;
		$startColumn_item_df = 4;

		for ($i = $startColumn_item_df; $i < $numCols_item_df; $i++) {
			$meta = $sth_item_df->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn_item_df;
			$tmpValue = $results_header_item_df[$meta['name']];
			$value = trim(preg_replace('/\t+/', '', $tmpValue));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}




		/* Create Details */

		$numDM = count($paramListDM);  // จำนวน DM
		$z=1;
		for ($j=$startRow_item_df; $j < $numDM+$startRow_item_df; $j++) { 

			$results_data_item_dfs = $db->item_df()->where("templates = ? and rtu_install = ? and fasttools_destination = ?", "data_template", $paramRtuInstall, $paramFastToolsDestination);

			$k = 0;  // จำนวนแภวของ Template
			foreach ($results_data_item_dfs as $results_data_item_df) {

					$z = $z +1;
					for ($i = $startColumn_item_df; $i < $numCols_item_df; $i ++) {
						$meta = $sth_item_df->getColumnMeta($i);
						$row = $z;		// แถวที่ $row ของ Excel
						$col = $i-$startColumn_item_df;	// คอลัมภ์ที่ $col ของ Excel


						if ($meta['name'] == "INSTALL") {
							$value = $paramRtuInstall;
						} else if ($meta['name'] == "UNIT") {

							if($paramRtuInstall == "PRODUCTION") {
								$value = "WTDC";
							} else {
								$tmpDM_Name = $paramListDM[$j-$startRow_item_df]->name;
								$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);
								$value = $tmpBranch_Name;
							}

						} else if ($meta['name'] == "NAME") {
							// PRODUCTION.WTDC.U208.FT
							// SERVICE.B01.DM-01-06-03-02.PT_INT_HI_SP
							if($paramRtuInstall == "PRODUCTION") {
								$tmpDM_Name = $paramListDM[$j-$startRow_item_df]->name;
								$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);
								$value = $paramRtuInstall.".WTDC".".".$tmpDM_Name.".".$results_data_item_df['TAG'];
							} else {
								$tmpDM_Name = $paramListDM[$j-$startRow_item_df]->name;
								$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);
								$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".".$results_data_item_df['TAG'];
							}


						} else if ($meta['name'] == "STATION") {
							
								/*  MODBUS_LINE_DF Partial */
							    							$tmpDM_Name = $paramListDM[$j-$startRow_item_df]->name;
							$tmpBranch_Name = substr($tmpDM_Name, 3, 2);

							if (( $paramFastToolsDestination == "B&R X20")||($paramFastToolsDestination == "YOKOGAWA FCJ")||($paramFastToolsDestination == "SIXNET")||($paramFastToolsDestination == "ABB CTU800")) {
								// Define STATION for B&R X20, Template from "DM-01-04-04-01"
								// Define STATION for YOKOGAWA FCJ, Template from "DM-01-06-02-03"
								// Define STATION for SIXNET, Template from "DM-04-03-01-01"
								if ($results_data_item_df['TAG'] == "COMM_STS"){
									$value = "";
								} else {
									$value = $tmpDM_Name;
								}

							} else if (($paramFastToolsDestination == "MOXA") || ($paramFastToolsDestination == "WAGO")) {
								// Define STATION for MOXA, Template from "DM-01-06-03-02"
								// Define STATION for WAGO, Template from "DM-02-08-02-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT") 
										|| ($results_data_item_df['TAG'] == "TOTAL")){
										$value = $tmpDM_Name;
								} else {
									$value = "";
								}
							} else if ($paramFastToolsDestination == "ABB AC500") {
								// Define STATION for ABB AC500, Template from "DM-01-06-01-01"
								if (($results_data_item_df['TAG'] == "COMM_STS") || ($results_data_item_df['TAG'] == "PT_EXT_HI_ALM") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_HI_SP") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_LO_ALM") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_LO_SP")){
										$value = "";
								} else {
									$value = $tmpDM_Name;
								}
							} else if ($paramFastToolsDestination == "PGIM_BRANCH") {
								// Define STATION for PGIM_BRANCH, Template from "DM-02-15-01-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "ON") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT")
										|| ($results_data_item_df['TAG'] == "TOTAL")){
									$value = "B".$tmpBranch_Name."_PGIM";
								} else {
									$value = "";
								}
							} else if ($paramFastToolsDestination == "DCXII") {
								// Define STATION for DCXII, Template from "DM-02-02-08-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT")
										|| ($results_data_item_df['TAG'] == "TOTAL")){
										$value = "DCXII";
								} else {
									$value = "N/A";
								}
							} else if ($paramFastToolsDestination == "PGIM_WTDC") {
								// Define STATION for PGIM_WTDC, Template from "U208"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "PT")){
										$value = "WTDC_PGIM";
								} else {
									$value = "N/A";
								}
							}





						} else if ($meta['name'] == "POINT") {
							
								/*  MODBUS_LINE_DF Partial */
							    							if (( $paramFastToolsDestination == "B&R X20")||($paramFastToolsDestination == "YOKOGAWA FCJ")||($paramFastToolsDestination == "SIXNET")||($paramFastToolsDestination == "ABB CTU800")) {
								// Define STATION for B&R X20, Template from "DM-01-04-04-01"
								// Define STATION for YOKOGAWA FCJ, Template from "DM-01-06-02-03"
								// Define STATION for SIXNET, Template from "DM-04-03-01-01"
								if ($results_data_item_df['TAG'] == "COMM_STS"){
									$value = "";
								} else {
									$value = $results_data_item_df['TAG'];
								}
							} else if (($paramFastToolsDestination == "MOXA") || ($paramFastToolsDestination == "WAGO")) {
								// Define STATION for MOXA, Template from "DM-01-06-03-02"
								// Define STATION for WAGO, Template from "DM-02-08-02-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT") 
										|| ($results_data_item_df['TAG'] == "TOTAL")){
										$value = $results_data_item_df['TAG'];
								} else {
									$value = "";
								}
							} else if ($paramFastToolsDestination == "ABB AC500") {
								// Define STATION for ABB AC500, Template from "DM-01-06-01-01"
								if (($results_data_item_df['TAG'] == "COMM_STS") || ($results_data_item_df['TAG'] == "PT_EXT_HI_ALM") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_HI_SP") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_LO_ALM") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_LO_SP")){
										$value = "";
								} else {
									$value = $results_data_item_df['TAG'];
								}
							} else if ($paramFastToolsDestination == "PGIM_BRANCH") {
								// Define STATION for PGIM_BRANCH, Template from "DM-02-15-01-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "ON") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT")
										|| ($results_data_item_df['TAG'] == "TOTAL")){
									$value = $tmpDM_Name.".".$results_data_item_df['TAG'];
								} else {
									$value = "";
								}
							} else if ($paramFastToolsDestination == "DCXII") {
								// Define STATION for DCXII, Template from "DM-02-02-08-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT")
										|| ($results_data_item_df['TAG'] == "TOTAL")){
										$value = $tmpDM_Name.".".$results_data_item_df['TAG'];
								} else {
									$value = "N/A";
								}
							} else if ($paramFastToolsDestination == "PGIM_WTDC") {
								// Define STATION for PGIM_WTDC, Template from "U208"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "PT")){
										$value = $tmpDM_Name.".".$results_data_item_df['TAG'];
								} else {
									$value = "N/A";
								}
							}

						} else if ($meta['name'] == "POINT_NAME") {
							
								/*  MODBUS_LINE_DF Partial */
							    							$tmpDM_Name = $paramListDM[$j-$startRow_item_df]->name;

							if (( $paramFastToolsDestination == "B&R X20")||($paramFastToolsDestination == "YOKOGAWA FCJ")||($paramFastToolsDestination == "SIXNET")||($paramFastToolsDestination == "ABB CTU800")) {
								// Define STATION for B&R X20, Template from "DM-01-04-04-01"
								// Define STATION for YOKOGAWA FCJ, Template from "DM-01-06-02-03"
								// Define STATION for SIXNET, Template from "DM-04-03-01-01"
								if ($results_data_item_df['TAG'] == "COMM_STS"){
									$value = ":";
								} else {
									$value = $tmpDM_Name.":".$results_data_item_df['TAG'];
								}
							} else if (($paramFastToolsDestination == "MOXA") || ($paramFastToolsDestination == "WAGO")) {
								// Define STATION for MOXA, Template from "DM-01-06-03-02"
								// Define STATION for WAGO, Template from "DM-02-08-02-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
																		   || ($results_data_item_df['TAG'] == "PT_EXT") 
																		   || ($results_data_item_df['TAG'] == "PT_INT") 
																		   || ($results_data_item_df['TAG'] == "TOTAL")){
									$value = $tmpDM_Name.":".$results_data_item_df['TAG'];
								} else {
									$value = $results_data_item_df[$meta['name']];
								}
							} else if ($paramFastToolsDestination == "ABB AC500") {
								// Define STATION for ABB AC500, Template from "DM-01-06-01-01"
								if (($results_data_item_df['TAG'] == "COMM_STS") || ($results_data_item_df['TAG'] == "PT_EXT_HI_ALM") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_HI_SP") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_LO_ALM") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_LO_SP")){
										$value = ":";
								} else {
									$value = $tmpDM_Name.":".$results_data_item_df['TAG'];
								}
							} else if ($paramFastToolsDestination == "PGIM_BRANCH") {
								// Define STATION for PGIM_BRANCH, Template from "DM-02-15-01-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "ON") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT")
										|| ($results_data_item_df['TAG'] == "TOTAL")){
									$value = "B".$tmpBranch_Name."_PGIM".":".$tmpDM_Name.".".$results_data_item_df['TAG'];
								} else {
									$value = ":";
								}
							} else if ($paramFastToolsDestination == "DCXII") {
								// Define STATION for DCXII, Template from "DM-02-02-08-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT")
										|| ($results_data_item_df['TAG'] == "TOTAL")){
										$value = "DCXII:".$tmpDM_Name.".".$results_data_item_df['TAG'];
								} else {
									$value = "N/A";
								}
							} else if ($paramFastToolsDestination == "PGIM_WTDC") {
								// Define STATION for PGIM_WTDC, Template from "U208"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "PT")){
										$value = "WTDC_PGIM:".$tmpDM_Name.".".$results_data_item_df['TAG'];
								} else {
									$value = "N/A";
								}
							}

						} else if ($meta['name'] == "AOI_1") {
							
							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_item_df[$meta['name']];
							} else {
								$tmpDM_Name = $paramListDM[$j-$startRow_item_df]->name;
								$tmpDatabaseAOI_Name = "DB".substr($tmpDM_Name, 3, 2);

								if ($results_data_item_df['TAG'] == "LOG_FREQ"){
									$value = $tmpDatabaseAOI_Name;
								} else {
									$value = $results_data_item_df[$meta['name']];
								}
							}

						} else {
							$tmpValue = $results_data_item_df[$meta['name']];
							$value = trim(preg_replace('/\t+/', '', $tmpValue));
						}
						
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
					}
				$k = $k +1;

			}

		}

	    /*  OBJECT_DF Partial */
	    		$sheetCount = $objPHPExcel->getSheetCount();

		/* Create Worksheet พร้อมกำหนดชื่อ */
		$objPHPExcel_OBJECT_DF_Worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'OBJECT_DF');
		$objPHPExcel->addSheet($objPHPExcel_OBJECT_DF_Worksheet, $sheetCount);
		$objPHPExcel_OBJECT_DF_Worksheet->setTitle('OBJECT_DF');

		/* กำหนดให้เป็น ActiveWorkSheet */
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex($sheetCount);


		/* Create Header */
		//$reports = $db->modbus_point_df[1];
		$results_header_object_df = $db->object_df()->where("templates = ?", "header_template")->fetch();

		$sth_object_df = $pdo->prepare("SELECT * FROM object_df WHERE templates = 'header_template'");
		$sth_object_df->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols_object_df = $sth_object_df->columnCount();
		$startRow_object_df = 2;
		$startColumn_object_df = 4;

		for ($i = $startColumn_object_df; $i < $numCols_object_df; $i++) {
			$meta = $sth_object_df->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn_object_df;
			$tmpValue = $results_header_object_df[$meta['name']];
			$value = trim(preg_replace('/\t+/', '', $tmpValue));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}




		/* Create Details */

		$numDM = count($paramListDM);  // จำนวน DM
		$z=1;
		for ($j=$startRow_object_df; $j < $numDM+$startRow_object_df; $j++) { 

			$results_data_object_dfs = $db->object_df()->where("templates = ? and rtu_install = ? and fasttools_destination = ?", "data_template", $paramRtuInstall, $paramFastToolsDestination);

			$k = 0;  // จำนวนแภวของ Template
			foreach ($results_data_object_dfs as $results_data_object_df) {

					$z = $z +1;
					for ($i = $startColumn_object_df; $i < $numCols_object_df; $i ++) {
						$meta = $sth_object_df->getColumnMeta($i);
						$row = $z;		// แถวที่ $row ของ Excel
						$col = $i-$startColumn_object_df;	// คอลัมภ์ที่ $col ของ Excel


						if ($meta['name'] == "UNIT") {

							if($paramRtuInstall == "PRODUCTION") {
								$value = "WTDC";
							} else {
								$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
								$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);
								$value = $tmpBranch_Name;
							}

						} else if ($meta['name'] == "TAG") {

							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$value = $tmpDM_Name;

						} else if ($meta['name'] == "DESCRIPTION") {
							
							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {
								$value = $paramFastToolsDestination;
							}

						} else if ($meta['name'] == "NAME") {
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								// PRODUCTION.WTDC.U208.U208
								$value = $paramRtuInstall.".WTDC.".$tmpDM_Name.".".$tmpDM_Name;
							} else {
								//SERVICE.B01.DM-01-06-03-02.DM-01-06-03-02
								$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".".$tmpDM_Name;
							}

						} else if ($meta['name'] == "ATTR_VALUE_1") {

							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								// PRODUCTION.WTDC.U208.FT
								$value = $paramRtuInstall.".WTDC.".$tmpDM_Name.".FT";
							} else {
								// SERVICE.B01.DM-01-06-03-02.FT
								$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".FT";
							}


						} else if ($meta['name'] == "ATTR_VALUE_2") {

							//SERVICE.B01.DM-01-06-03-02.FT_HI_ALM
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								// PRODUCTION.WTDC.U208.PT
								$value = $paramRtuInstall.".WTDC.".$tmpDM_Name.".PT";
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_FT_HI_ALM";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".FT_HI_ALM";
								}
								
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_3") {

							//SERVICE.B01.DM-01-06-03-02.FT_LO_ALM
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_FT_LO_ALM";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".FT_LO_ALM";
								}
							}

						} else if ($meta['name'] == "ATTR_VALUE_4") {

							//SERVICE.B01.DM-01-06-03-02.FT_HI_SP
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_FT_HI_SP";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".FT_HI_SP";
								}
							}

						} else if ($meta['name'] == "ATTR_VALUE_5") {

							//SERVICE.B01.DM-01-06-03-02.FT_LO_SP
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_FT_LO_SP";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".FT_LO_SP";
								}
							}

						} else if ($meta['name'] == "ATTR_VALUE_6") {

							//SERVICE.B01.DM-01-06-03-02.PT_INT
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								// if($paramFastToolsDestination == "DCXII") {
								// 	$value = "OTHER.DUMMY.DUMMY_FT_LO_SP";
								// } else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_INT";
								// }
							}

						} else if ($meta['name'] == "ATTR_VALUE_7") {

							//SERVICE.B01.DM-01-06-03-02.PT_INT_HI_ALM
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_INT_HI_ALM";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_INT_HI_ALM";
								}
							}

						} else if ($meta['name'] == "ATTR_VALUE_8") {

							//SERVICE.B01.DM-01-06-03-02.PT_INT_LO_ALM
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_INT_LO_ALM";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_INT_LO_ALM";
								}
							}

						} else if ($meta['name'] == "ATTR_VALUE_9") {

							//SERVICE.B01.DM-01-06-03-02.PT_INT_HI_SP
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_INT_HI_SP";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_INT_HI_SP";
								}
							}

						} else if ($meta['name'] == "ATTR_VALUE_10") {

							//SERVICE.B01.DM-01-06-03-02.PT_INT_LO_SP
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_INT_LO_SP";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_INT_LO_SP";
								}
							}

						} else if ($meta['name'] == "ATTR_VALUE_11") {

							//SERVICE.B01.DM-01-06-03-02.PT_EXT
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if($paramFastToolsDestination == "ABB CTU800") {
									$value = "OTHER.DUMMY.DUMMY_PT_EXT";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_EXT";
								}
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_12") {

							//SERVICE.B01.DM-01-06-03-02.PT_EXT_HI_ALM
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_EXT_HI_ALM";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_EXT_HI_ALM";
								}
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_13") {

							//SERVICE.B01.DM-01-06-03-02.PT_EXT_LO_ALM
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_EXT_LO_ALM";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_EXT_LO_ALM";
								}
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_14") {

							//SERVICE.B01.DM-01-06-03-02.PT_EXT_HI_SP
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_EXT_HI_SP";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_EXT_HI_SP";
								}
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_15") {

							//SERVICE.B01.DM-01-06-03-02.PT_EXT_LO_SP
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_EXT_LO_SP";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_EXT_LO_SP";
								}
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_16") {

							//SERVICE.B01.DM-01-06-03-02.TOTAL
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								// if($paramFastToolsDestination == "DCXII") {
								// 	$value = "OTHER.DUMMY.DUMMY_PT_EXT_LO_SP";
								// } else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".TOTAL";
								// }
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_17") {

							//SERVICE.B01.DM-01-06-03-02.LOG_FREQ
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								// if($paramFastToolsDestination == "DCXII") {
								// 	$value = "OTHER.DUMMY.DUMMY_PT_EXT_LO_SP";
								// } else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".LOG_FREQ";
								// }
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_18") {

							//SERVICE.B01.DM-01-06-03-02.COMM_STS
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if($paramFastToolsDestination == "PGIM_BRANCH") {
									$value = "OTHER.DUMMY.DUMMY_COMM_STS";
								} else if($paramFastToolsDestination == "DCXII") {
									$value = "OTHER.DUMMY.DUMMY_COMM_STS";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".COMM_STS";
								}
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_19") {

							//SERVICE.B01.DM-01-06-03-02.COMM_STS
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if($paramFastToolsDestination == "PGIM_BRANCH") {
									// SERVICE.B02.DM-02-15-01-01.ON
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".ON";
								} else {
									$value = "OTHER.DUMMY.DUMMY_ON";
								}
							}
							

						} else {
							$tmpValue = $results_data_object_df[$meta['name']];
							$value = trim(preg_replace('/\t+/', '', $tmpValue));
						}
						
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
					}
				$k = $k +1;

			}

		}





	    /*  ITEM_HIS_DF Partial */
	    		$sheetCount = $objPHPExcel->getSheetCount();

		/* Create Worksheet พร้อมกำหนดชื่อ */
		$objPHPExcel_ITEM_HIS_DF_Worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'ITEM_HIS_DF');
		$objPHPExcel->addSheet($objPHPExcel_ITEM_HIS_DF_Worksheet, $sheetCount);
		$objPHPExcel_ITEM_HIS_DF_Worksheet->setTitle('ITEM_HIS_DF');

		/* กำหนดให้เป็น ActiveWorkSheet */
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex($sheetCount);


		/* Create Header */
		//$reports = $db->modbus_point_df[1];
		$results_header_item_his_df = $db->item_his_df()->where("templates = ?", "header_template")->fetch();

		$sth_item_his_df = $pdo->prepare("SELECT * FROM item_his_df WHERE templates = 'header_template'");
		$sth_item_his_df->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols_item_his_df = $sth_item_his_df->columnCount();
		$startRow_item_his_df = 2;
		$startColumn_item_his_df = 4;

		for ($i = $startColumn_item_his_df; $i < $numCols_item_his_df; $i++) {
			$meta = $sth_item_his_df->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn_item_his_df;
			$tmpValue = $results_header_item_his_df[$meta['name']];
			$value = trim(preg_replace('/\t+/', '', $tmpValue));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}




		/* Create Details */

		$numDM = count($paramListDM);  // จำนวน DM
		$z=1;
		for ($j=$startRow_item_his_df; $j < $numDM+$startRow_item_his_df; $j++) { 

			$results_data_item_his_dfs = $db->item_his_df()->where("templates = ? and rtu_install = ? and fasttools_destination = ?", "data_template", $paramRtuInstall, $paramFastToolsDestination);

			$k = 0;  // จำนวนแภวของ Template
			foreach ($results_data_item_his_dfs as $results_data_item_his_df) {

					$z = $z +1;
					for ($i = $startColumn_item_his_df; $i < $numCols_item_his_df; $i ++) {
						$meta = $sth_item_his_df->getColumnMeta($i);
						$row = $z;		// แถวที่ $row ของ Excel
						$col = $i-$startColumn_item_his_df;	// คอลัมภ์ที่ $col ของ Excel

// TEN_SECONDS:SERVICE.B01.DM-01-06-03-02.FT
// TEN_SECONDS:SERVICE.B01.DM-01-06-03-02.PT_INT
// TEN_SECONDS:SERVICE.B01.DM-01-06-03-02.PT_EXT

						if ($meta['name'] == "NAME") {

							$tmpDM_Name = $paramListDM[$j-$startRow_item_his_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							$tmpValue = $results_data_item_his_df[$meta['name']];

							if($paramRtuInstall == "PRODUCTION") {
								// TEN_SECONDS:PRODUCTION.WTDC.U208.FT
								if ((substr($tmpValue, -2) == "FT")) {
									$value = $results_data_item_his_df['GROUP_NAME'].":".$paramRtuInstall.".WTDC.".$tmpDM_Name.".FT";
								} else if ((substr($tmpValue, -2) == "PT")) {
									$value = $results_data_item_his_df['GROUP_NAME'].":".$paramRtuInstall.".WTDC.".$tmpDM_Name.".PT";
								} else {
									$value = "N/A";
								}

							} else if($paramRtuInstall == "ABB CTU800"){

								if ((substr($tmpValue, -2) == "FT")) {
									// TEN_SECONDS:SERVICE.B03.DM-03-01-03-01.FT
									$value = $results_data_item_his_df['GROUP_NAME'].":".$paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".FT";
								} else if ((substr($tmpValue, -6) == "PT_INT")) {
									// TEN_SECONDS:SERVICE.B03.DM-03-01-03-01.PT_INT
									$value = $results_data_item_his_df['GROUP_NAME'].":".$paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_INT";
								}

							} else {
								// TEN_SECONDS:SERVICE.B02.DM-02-02-08-01.PT_EXT
								if ((substr($tmpValue, -2) == "FT")) {
									$value = $results_data_item_his_df['GROUP_NAME'].":".$paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".FT";
								} else if ((substr($tmpValue, -6) == "PT_INT")) {
									$value = $results_data_item_his_df['GROUP_NAME'].":".$paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_INT";
								} else if ((substr($tmpValue, -6) == "PT_EXT")) {
									$value = $results_data_item_his_df['GROUP_NAME'].":".$paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_EXT";
								}

							}

							

						} else {
							$tmpValue = $results_data_item_his_df[$meta['name']];
							$value = trim(preg_replace('/\t+/', '', $tmpValue));
						}
						
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
					}
				$k = $k +1;

			}

		}

		/* ************************* */
        /* เริ่มกระบวนการสร้าง Excel file */
        /* ************************* */

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");


		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="01simple.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$date = new DateTime();
		$fileName = 'Quickload_for_OPCDAC('.$paramFastToolsDestination.')'.'_'.date("Y-m-d").'_'.$date->getTimestamp().'.xls';
		$filePath = '../../files/'.$fileName;
		$objWriter->save($filePath);



	    /* ************************* */
	    /* เริ่มกระบวนการส่งค่ากลับ */
	    /* ************************* */
	    $reports[] = array(
	    		"filename" => $fileName,
	    		"path" => url()."/scada-it/build/files/".$fileName
	    	);


	    $resultText = "success";

	    $reportResult = array("result" =>  $resultText, "rows" => $reports);
	    //$reportResult = array("result" =>  $resultText);

	    $app->response()->header("Content-Type", "application/json");
	    echo json_encode($reportResult);


	    // $return_m = array("msg" => "Hello, Current PHP version: ". phpversion());
	    // echo json_encode($return_m);


    }
    
	/**
	 *
	 * @apiName IEC60870_Manager
	 * @apiGroup Fast_Tools
	 * @apiVersion 0.1.0
	 *
	 * @api {post} /FastToolsAPI/IEC60870_Manager/ IEC60870_Manager
	 * @apiDescription คำอธิบาย : ในส่วนนี้ใช้สำหรับสร้าง FAST/TOOLS Quickload สำหรับโปรโตคอล IEC60870-5-104
	 *
	 *
	 *
	 * @apiParam {String} rtu_install = "SERVICE" คำอธิบายกลุ่มของอุปกรณ์ เช่น SERVICE, PRODUCTION, OTHER
	 * @apiParam {String} fasttools_destination = "ABB CTU800" คำอธิบายชนิดของอุปกรณ์ เช่น ABB CTU800
     * @apiParam {Object[]} listDM  รายการ DM
     * @apiParam {String} listDM.name = "DM-01-01-01-01" ชื่อ DM
     *
     * @apiParamExample {json} Request-Example (ตัวอย่าง Payload, Content-Type: application/json):
     *  {
     *      "rtu_install": "SERVICE",
     *      "fasttools_destination": "ABB CTU800",
     *      "listDM": [
     *          {
     *              "name": "DM-01-01-01-01"
     *          },
     *          {
     *              "name": "DM-01-01-01-02"
     *          },
     *          {
     *              "name": "DM-01-01-01-03"
     *          }
     *      ]
     *  }
     *
	 * @apiSampleRequest /FastToolsAPI/IEC60870_Manager/
	 *
	 * @apiSuccess (คำอธิบายผลลัพธ์ (กรณีส่งค่ากลับสำเร็จ Success 200)) {String} msg แสดงข้อความทักทายผู้ใช้งาน
	 *
	 * @apiSuccessExample Example data on success:
     *  {
     *      "result": "success",
     *      "rows": [
     *          {
     *              "filename": "Quickload_for_IEC60870(PGIM_WTDC)_2015-08-15_1439607474.xls",
     *              "path": "http://localhost/scada-it/build/files/Quickload_for_IEC60870(PGIM_WTDC)_2015-08-15_1439607474.xls"
     *          }
     *      ]
     *  }
	 *
	 * @apiError (คำอธิบายผลลัพธ์ (กรณีเกิด Error 4xx)) UserNotFound The <code>id</code> of the User was not found.
	 * @apiErrorExample {json} Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "UserNotFound"
	 *     }
	 *
	 */
    function IEC60870_Manager($app, $pdo, $db, $objPHPExcel) {

        /* ************************* */
        /* เริ่มกระบวนการรับค่าพารามิเตอร์จากส่วนของ Payload ซึ่งอยู่ในรูปแบบ JSON */
        /* ************************* */
        $headers = $app->request->headers;
        $ContetnType = $app->request->headers->get('Content-Type');

        /**
        * apidoc @apiSampleRequest, iOS RESTKit use content-type is "application/json"
        * Web Form, Advance REST Client App use content-type is "application/x-www-form-urlencoded"
        */
        if ($ContetnType == "application/json") {

	        $request = $app->request();
	        $result = json_decode($request->getBody());

	        /* receive request */
	        $paramRtuInstall = $result->rtu_install;
	        $paramFastToolsDestination = $result->fasttools_destination;
	        $paramListDM = $result->listDM;

 
		} else if ($ContetnType == "application/x-www-form-urlencoded"){

		    //$userID = $app->request()->params('userID_param');
		    //$userID = $app->request()->post('userID_param');
		}


		/* ************************* */
        /* เริ่มกระบวนการเชื่อมต่อกับฐานข้อมูล MySQL */
        /* ************************* */

        $reports = array();
		
		
		/*  IEC60870_LINE_DF Partial */
	    
		/* Create Header */
		//$reports = $db->iec60870_point_df[1];
		$results_header_iec60870_line_df = $db->iec60870_line_df()->where("templates = ?", "header_template")->fetch();

		$sth_iec60870_line_df = $pdo->prepare("SELECT * FROM iec60870_line_df WHERE templates = 'header_template'");
		$sth_iec60870_line_df->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols_iec60870_line_df = $sth_iec60870_line_df->columnCount();
		$startRow_iec60870_line_df = 2;
		$startColumn_iec60870_line_df = 4;

		for ($i = $startColumn_iec60870_line_df; $i < $numCols_iec60870_line_df; $i++) {
			$meta = $sth_iec60870_line_df->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn_iec60870_line_df;
			$tmpValue = $results_header_iec60870_line_df[$meta['name']];
			$value = trim(preg_replace('/\t+/', '', $tmpValue));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}



		/* Create Details */
		$numDM = count($paramListDM);  // จำนวน DM
		$z=1;
		for ($j=$startRow_iec60870_line_df; $j < $numDM+$startRow_iec60870_line_df; $j++) { 

			$results_data_iec60870_line_dfs = $db->iec60870_line_df()->where("templates = ? and rtu_install = ? and fasttools_destination = ?", "data_template", $paramRtuInstall, $paramFastToolsDestination);

			$k = 0;  // จำนวนแภวของ Template
			foreach ($results_data_iec60870_line_dfs as $results_data_iec60870_line_df) {
					$z = $z +1;
					for ($i = $startColumn_iec60870_line_df; $i < $numCols_iec60870_line_df; $i ++) {
						$meta = $sth_iec60870_line_df->getColumnMeta($i);
						$row = $z;		// แถวที่ $row ของ Excel
						$col = $i-$startColumn_iec60870_line_df;	// คอลัมภ์ที่ $col ของ Excel

						if ($meta['name'] == "NAME") {
							//B03IEC_01
							$tmpDM_Name = $paramListDM[$j-$startRow_iec60870_line_df]->name;
							$tmpBranchCode = substr($tmpDM_Name, 3, 2);
							$tmpZoneCode = substr($tmpDM_Name, 6, 2);
							$value = "B".$tmpBranchCode."IEC_".$tmpZoneCode;
						} else if($meta['name'] == "EQUIPMENT_MAN"){
							//EQP104_0301
							$tmpDM_Name = $paramListDM[$j-$startRow_iec60870_line_df]->name;
							$tmpBranchCode = substr($tmpDM_Name, 3, 2);
							$tmpZoneCode = substr($tmpDM_Name, 6, 2);
						 	$value = "EQP104_".$tmpBranchCode.$tmpZoneCode;
						} else {
							$tmpValue = $results_data_iec60870_line_df[$meta['name']];
							$value = trim(preg_replace('/\t+/', '', $tmpValue));
						}

						
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
					}
				$k = $k +1;
			}

		}

		/* Set Title */
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('IEC60870_LINE_DF');

		

	    /*  IEC60870_STATION_DF Partial */
	    		$sheetCount = $objPHPExcel->getSheetCount();

		/* Create Worksheet พร้อมกำหนดชื่อ */
		$objPHPExcel_IEC60870_STATION_DF_Worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'IEC60870_STATION_DF');
		$objPHPExcel->addSheet($objPHPExcel_IEC60870_STATION_DF_Worksheet, $sheetCount);
		$objPHPExcel_IEC60870_STATION_DF_Worksheet->setTitle('IEC60870_STATION_DF');

		/* กำหนดให้เป็น ActiveWorkSheet */
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex($sheetCount);


		/* ************************* */
        /* เริ่มกระบวนการสร้าง Quickload for MODBUS (MODBUS_STATION_DF) */
        /* ************************* */

		/* Create Header */
		//$reports = $db->modbus_station_df[1];
		//$results_header = $db->opcdac_station_df()->where("templates = ?", "header_template")->fetch();
		$results_header_iec60870_station_df = $db->iec60870_station_df()->where("templates = ?", "header_template")->fetch();

        $sth_iec60870_station_df = $pdo->prepare("SELECT * FROM iec60870_station_df WHERE templates = 'header_template'");
        $sth_iec60870_station_df->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols_iec60870_station_df = $sth_iec60870_station_df->columnCount();
		$startRow_iec60870_station_df = 2;
		$startColumn_iec60870_station_df = 4;

		for ($i = $startColumn_iec60870_station_df; $i < $numCols_iec60870_station_df; $i ++) {
			$meta = $sth_iec60870_station_df->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn_iec60870_station_df;
			$value = $results_header_iec60870_station_df[$meta['name']];
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}




		/* Create Details */
		$numDM = count($paramListDM);  // จำนวน DM
		$z=1;
		for ($j=$startRow_iec60870_station_df; $j < $numDM+$startRow_iec60870_station_df; $j++) { 

			//$results_data_opcdac_station_dfs = $db->opcdac_station_df()->where("templates = ? and rtu_install = ? and rtu_modbus_brand = ?", "data_template", $paramRtuInstall, $paramRtuModbusBrand);
			$results_data_iec60870_station_dfs = $db->iec60870_station_df()->where("templates = ? and rtu_install = ? and fasttools_destination = ?", "data_template", $paramRtuInstall, $paramFastToolsDestination);

			$k = 0;  // จำนวนแภวของ Template
			foreach ($results_data_iec60870_station_dfs as $results_data_iec60870_station_df) {
					$z = $z +1;
					for ($i = $startColumn_iec60870_station_df; $i < $numCols_iec60870_station_df; $i ++) {
						$meta = $sth_iec60870_station_df->getColumnMeta($i);
						$row = $z;		// แถวที่ $row ของ Excel
						$col = $i-$startColumn_iec60870_station_df;	// คอลัมภ์ที่ $col ของ Excel


						 if ($meta['name'] == "NAME") {
						 	// DM-03-01-01-01
						 	$tmpDM_Name = $paramListDM[$j-$startRow_iec60870_station_df]->name;
							$value = $tmpDM_Name;

						 } else if($meta['name'] == "DESCRIPTION") {
						 	// DM-03-01-01-01
						 	$tmpDM_Name = $paramListDM[$j-$startRow_iec60870_station_df]->name;
							$value = $tmpDM_Name;

						 } else if ($meta['name'] == "LINE") {
						 	// B03IEC
					 		$tmpDM_Name = $paramListDM[$j-$startRow_iec60870_station_df]->name;
							$tmpBranchCode = substr($tmpDM_Name, 3, 2);
							$tmpZoneCode = substr($tmpDM_Name, 6, 2);
							$value = "B".$tmpBranchCode."IEC_".$tmpZoneCode;

						 } else if($meta['name'] == "LINE_1_DEVICE") {
						 	// DM-03-01-01-01
						 	$tmpDM_Name = $paramListDM[$j-$startRow_iec60870_station_df]->name;
							$value = $tmpDM_Name;
							
						 } else {
						 	$tmpValue = $results_data_iec60870_station_df[$meta['name']];
							$value = trim(preg_replace('/\t+/', '', $tmpValue));
						 }
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
					}
				$k = $k +1;
			}

		}






	    /*  IEC60870_POINT_DF Partial */
	    		$sheetCount = $objPHPExcel->getSheetCount();

		/* Create Worksheet พร้อมกำหนดชื่อ */
		$objPHPExcel_IEC60870_POINT_DF_Worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'IEC60870_POINT_DF');
		$objPHPExcel->addSheet($objPHPExcel_IEC60870_POINT_DF_Worksheet, $sheetCount);
		$objPHPExcel_IEC60870_POINT_DF_Worksheet->setTitle('IEC60870_POINT_DF');

		/* กำหนดให้เป็น ActiveWorkSheet */
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex($sheetCount);


		/* ************************* */
        /* เริ่มกระบวนการสร้าง Quickload for IEC60870 (IEC60870_POINT_DF) */
        /* ************************* */

		/* Create Header */
		//$reports = $db->iec60870_station_df[1];
		//$results_header = $db->iec60870_station_df()->where("templates = ?", "header_template")->fetch();
		$results_header_iec60870_point_df = $db->iec60870_point_df()->where("templates = ?", "header_template")->fetch();

        $sth_iec60870_point_df = $pdo->prepare("SELECT * FROM iec60870_point_df WHERE templates = 'header_template'");
        $sth_iec60870_point_df->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols_iec60870_point_df = $sth_iec60870_point_df->columnCount();
		$startRow_iec60870_point_df = 2;
		$startColumn_iec60870_point_df = 4;

		for ($i = $startColumn_iec60870_point_df; $i < $numCols_iec60870_point_df; $i ++) {
			$meta = $sth_iec60870_point_df->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn_iec60870_point_df;
			$tmpValue = $results_header_iec60870_point_df[$meta['name']];
			$value = trim(preg_replace('/\t+/', '', $tmpValue));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}





		/* Create Details */
		$numDM = count($paramListDM);  // จำนวน DM
		$z=1;
		for ($j=$startRow_iec60870_point_df; $j < $numDM+$startRow_iec60870_point_df; $j++) { 

			$results_data_iec60870_point_dfs = $db->iec60870_point_df()->where("templates = ? and rtu_install = ? and fasttools_destination = ?", "data_template", $paramRtuInstall, $paramFastToolsDestination);

			$k = 0;  // จำนวนแภวของ Template
			foreach ($results_data_iec60870_point_dfs as $results_data_iec60870_point_df) {
					$z = $z +1;
					for ($i = $startColumn_iec60870_point_df; $i < $numCols_iec60870_point_df; $i ++) {
						$meta = $sth_iec60870_point_df->getColumnMeta($i);
						$row = $z;		// แถวที่ $row ของ Excel
						$col = $i-$startColumn_iec60870_point_df;	// คอลัมภ์ที่ $col ของ Excel


						 if ($meta['name'] == "STATION") {

							$tmpDM_Name = $paramListDM[$j-$startRow_iec60870_point_df]->name;
							$tmpBranchCode = substr($tmpDM_Name, 3, 2);
							$value = $tmpDM_Name;

						 } else if ($meta['name'] == "NAME") {

							$tmpDM_Name = $paramListDM[$j-$startRow_iec60870_point_df]->name;
							$value = $tmpDM_Name.":".$results_data_iec60870_point_df['POINT'];

						 } else {
							$tmpValue = $results_data_iec60870_point_df[$meta['name']];
							$value = trim(preg_replace('/\t+/', '', $tmpValue));
						 }

						 //$value = $results_data_iec60870_point_df[$meta['name']];
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
					}
				$k = $k +1;
			}

		}







	    /*  STATION_DF Partial */
	    		$sheetCount = $objPHPExcel->getSheetCount();

		/* Create Worksheet พร้อมกำหนดชื่อ */
		$objPHPExcel_SECTION_DF_Worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'SECTION_DF');
		$objPHPExcel->addSheet($objPHPExcel_SECTION_DF_Worksheet, $sheetCount);
		$objPHPExcel_SECTION_DF_Worksheet->setTitle('SECTION_DF');

		/* กำหนดให้เป็น ActiveWorkSheet */
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex($sheetCount);


		/* Create Header */
		//$reports = $db->modbus_point_df[1];
		$results_header_section_df = $db->section_df()->where("templates = ?", "header_template")->fetch();

		$sth_section_df = $pdo->prepare("SELECT * FROM section_df WHERE templates = 'header_template'");
		$sth_section_df->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols_section_df = $sth_section_df->columnCount();
		$startRow_section_df = 2;
		$startColumn_section_df = 4;

		for ($i = $startColumn_section_df; $i < $numCols_section_df; $i++) {
			$meta = $sth_section_df->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn_section_df;
			$tmpValue = $results_header_section_df[$meta['name']];
			$value = trim(preg_replace('/\t+/', '', $tmpValue));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}




		/* Create Details */

		$numDM = count($paramListDM);  // จำนวน DM
		$z=1;
		for ($j=$startRow_section_df; $j < $numDM+$startRow_section_df; $j++) { 

			$results_data_section_dfs = $db->section_df()->where("templates = ? and rtu_install = ? and fasttools_destination = ?", "data_template", $paramRtuInstall, $paramFastToolsDestination);

			$k = 0;  // จำนวนแภวของ Template
			foreach ($results_data_section_dfs as $results_data_section_df) {

					$z = $z +1;
					for ($i = $startColumn_section_df; $i < $numCols_section_df; $i ++) {
						$meta = $sth_section_df->getColumnMeta($i);
						$row = $z;		// แถวที่ $row ของ Excel
						$col = $i-$startColumn_section_df;	// คอลัมภ์ที่ $col ของ Excel


						if ($meta['name'] == "SECTION_NAME") {
							$value = $paramListDM[$j-$startRow_section_df]->name;
						} else if($meta['name'] == "NAME"){

							if($paramRtuInstall == "PRODUCTION") {
								// PRODUCTION.WTDC.U208
								$tmpDM_Name = $paramListDM[$j-$startRow_section_df]->name;
								$value = "PRODUCTION.WTDC.".$tmpDM_Name;
							} else {
								// SERVICE.B54.DM-54-04-05-01
								$tmpDM_Name = $paramListDM[$j-$startRow_section_df]->name;
								$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);
								$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name;
							}

						} else if($meta['name'] == "DESCRIPTION"){
							
							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_section_df[$meta['name']];
							} else {
								$tmpDM_Name = $paramListDM[$j-$startRow_section_df]->name;
								$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);
								$value = $tmpBranch_Name;
							}

						} else {
							$tmpValue = $results_data_section_df[$meta['name']];
							$value = trim(preg_replace('/\t+/', '', $tmpValue));
						}
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
					}
				$k = $k +1;

			}

		}




	    /*  ITEM_DF Partial */
	    		$sheetCount = $objPHPExcel->getSheetCount();

		/* Create Worksheet พร้อมกำหนดชื่อ */
		$objPHPExcel_ITEM_DF_Worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'ITEM_DF');
		$objPHPExcel->addSheet($objPHPExcel_ITEM_DF_Worksheet, $sheetCount);
		$objPHPExcel_ITEM_DF_Worksheet->setTitle('ITEM_DF');

		/* กำหนดให้เป็น ActiveWorkSheet */
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex($sheetCount);


		/* Create Header */
		//$reports = $db->modbus_point_df[1];
		$results_header_item_df = $db->item_df()->where("templates = ?", "header_template")->fetch();

		$sth_item_df = $pdo->prepare("SELECT * FROM item_df WHERE templates = 'header_template'");
		$sth_item_df->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols_item_df = $sth_item_df->columnCount();
		$startRow_item_df = 2;
		$startColumn_item_df = 4;

		for ($i = $startColumn_item_df; $i < $numCols_item_df; $i++) {
			$meta = $sth_item_df->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn_item_df;
			$tmpValue = $results_header_item_df[$meta['name']];
			$value = trim(preg_replace('/\t+/', '', $tmpValue));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}




		/* Create Details */

		$numDM = count($paramListDM);  // จำนวน DM
		$z=1;
		for ($j=$startRow_item_df; $j < $numDM+$startRow_item_df; $j++) { 

			$results_data_item_dfs = $db->item_df()->where("templates = ? and rtu_install = ? and fasttools_destination = ?", "data_template", $paramRtuInstall, $paramFastToolsDestination);

			$k = 0;  // จำนวนแภวของ Template
			foreach ($results_data_item_dfs as $results_data_item_df) {

					$z = $z +1;
					for ($i = $startColumn_item_df; $i < $numCols_item_df; $i ++) {
						$meta = $sth_item_df->getColumnMeta($i);
						$row = $z;		// แถวที่ $row ของ Excel
						$col = $i-$startColumn_item_df;	// คอลัมภ์ที่ $col ของ Excel


						if ($meta['name'] == "INSTALL") {
							$value = $paramRtuInstall;
						} else if ($meta['name'] == "UNIT") {

							if($paramRtuInstall == "PRODUCTION") {
								$value = "WTDC";
							} else {
								$tmpDM_Name = $paramListDM[$j-$startRow_item_df]->name;
								$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);
								$value = $tmpBranch_Name;
							}

						} else if ($meta['name'] == "NAME") {
							// PRODUCTION.WTDC.U208.FT
							// SERVICE.B01.DM-01-06-03-02.PT_INT_HI_SP
							if($paramRtuInstall == "PRODUCTION") {
								$tmpDM_Name = $paramListDM[$j-$startRow_item_df]->name;
								$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);
								$value = $paramRtuInstall.".WTDC".".".$tmpDM_Name.".".$results_data_item_df['TAG'];
							} else {
								$tmpDM_Name = $paramListDM[$j-$startRow_item_df]->name;
								$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);
								$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".".$results_data_item_df['TAG'];
							}


						} else if ($meta['name'] == "STATION") {
							
								/*  MODBUS_LINE_DF Partial */
							    							$tmpDM_Name = $paramListDM[$j-$startRow_item_df]->name;
							$tmpBranch_Name = substr($tmpDM_Name, 3, 2);

							if (( $paramFastToolsDestination == "B&R X20")||($paramFastToolsDestination == "YOKOGAWA FCJ")||($paramFastToolsDestination == "SIXNET")||($paramFastToolsDestination == "ABB CTU800")) {
								// Define STATION for B&R X20, Template from "DM-01-04-04-01"
								// Define STATION for YOKOGAWA FCJ, Template from "DM-01-06-02-03"
								// Define STATION for SIXNET, Template from "DM-04-03-01-01"
								if ($results_data_item_df['TAG'] == "COMM_STS"){
									$value = "";
								} else {
									$value = $tmpDM_Name;
								}

							} else if (($paramFastToolsDestination == "MOXA") || ($paramFastToolsDestination == "WAGO")) {
								// Define STATION for MOXA, Template from "DM-01-06-03-02"
								// Define STATION for WAGO, Template from "DM-02-08-02-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT") 
										|| ($results_data_item_df['TAG'] == "TOTAL")){
										$value = $tmpDM_Name;
								} else {
									$value = "";
								}
							} else if ($paramFastToolsDestination == "ABB AC500") {
								// Define STATION for ABB AC500, Template from "DM-01-06-01-01"
								if (($results_data_item_df['TAG'] == "COMM_STS") || ($results_data_item_df['TAG'] == "PT_EXT_HI_ALM") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_HI_SP") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_LO_ALM") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_LO_SP")){
										$value = "";
								} else {
									$value = $tmpDM_Name;
								}
							} else if ($paramFastToolsDestination == "PGIM_BRANCH") {
								// Define STATION for PGIM_BRANCH, Template from "DM-02-15-01-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "ON") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT")
										|| ($results_data_item_df['TAG'] == "TOTAL")){
									$value = "B".$tmpBranch_Name."_PGIM";
								} else {
									$value = "";
								}
							} else if ($paramFastToolsDestination == "DCXII") {
								// Define STATION for DCXII, Template from "DM-02-02-08-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT")
										|| ($results_data_item_df['TAG'] == "TOTAL")){
										$value = "DCXII";
								} else {
									$value = "N/A";
								}
							} else if ($paramFastToolsDestination == "PGIM_WTDC") {
								// Define STATION for PGIM_WTDC, Template from "U208"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "PT")){
										$value = "WTDC_PGIM";
								} else {
									$value = "N/A";
								}
							}





						} else if ($meta['name'] == "POINT") {
							
								/*  MODBUS_LINE_DF Partial */
							    							if (( $paramFastToolsDestination == "B&R X20")||($paramFastToolsDestination == "YOKOGAWA FCJ")||($paramFastToolsDestination == "SIXNET")||($paramFastToolsDestination == "ABB CTU800")) {
								// Define STATION for B&R X20, Template from "DM-01-04-04-01"
								// Define STATION for YOKOGAWA FCJ, Template from "DM-01-06-02-03"
								// Define STATION for SIXNET, Template from "DM-04-03-01-01"
								if ($results_data_item_df['TAG'] == "COMM_STS"){
									$value = "";
								} else {
									$value = $results_data_item_df['TAG'];
								}
							} else if (($paramFastToolsDestination == "MOXA") || ($paramFastToolsDestination == "WAGO")) {
								// Define STATION for MOXA, Template from "DM-01-06-03-02"
								// Define STATION for WAGO, Template from "DM-02-08-02-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT") 
										|| ($results_data_item_df['TAG'] == "TOTAL")){
										$value = $results_data_item_df['TAG'];
								} else {
									$value = "";
								}
							} else if ($paramFastToolsDestination == "ABB AC500") {
								// Define STATION for ABB AC500, Template from "DM-01-06-01-01"
								if (($results_data_item_df['TAG'] == "COMM_STS") || ($results_data_item_df['TAG'] == "PT_EXT_HI_ALM") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_HI_SP") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_LO_ALM") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_LO_SP")){
										$value = "";
								} else {
									$value = $results_data_item_df['TAG'];
								}
							} else if ($paramFastToolsDestination == "PGIM_BRANCH") {
								// Define STATION for PGIM_BRANCH, Template from "DM-02-15-01-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "ON") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT")
										|| ($results_data_item_df['TAG'] == "TOTAL")){
									$value = $tmpDM_Name.".".$results_data_item_df['TAG'];
								} else {
									$value = "";
								}
							} else if ($paramFastToolsDestination == "DCXII") {
								// Define STATION for DCXII, Template from "DM-02-02-08-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT")
										|| ($results_data_item_df['TAG'] == "TOTAL")){
										$value = $tmpDM_Name.".".$results_data_item_df['TAG'];
								} else {
									$value = "N/A";
								}
							} else if ($paramFastToolsDestination == "PGIM_WTDC") {
								// Define STATION for PGIM_WTDC, Template from "U208"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "PT")){
										$value = $tmpDM_Name.".".$results_data_item_df['TAG'];
								} else {
									$value = "N/A";
								}
							}

						} else if ($meta['name'] == "POINT_NAME") {
							
								/*  MODBUS_LINE_DF Partial */
							    							$tmpDM_Name = $paramListDM[$j-$startRow_item_df]->name;

							if (( $paramFastToolsDestination == "B&R X20")||($paramFastToolsDestination == "YOKOGAWA FCJ")||($paramFastToolsDestination == "SIXNET")||($paramFastToolsDestination == "ABB CTU800")) {
								// Define STATION for B&R X20, Template from "DM-01-04-04-01"
								// Define STATION for YOKOGAWA FCJ, Template from "DM-01-06-02-03"
								// Define STATION for SIXNET, Template from "DM-04-03-01-01"
								if ($results_data_item_df['TAG'] == "COMM_STS"){
									$value = ":";
								} else {
									$value = $tmpDM_Name.":".$results_data_item_df['TAG'];
								}
							} else if (($paramFastToolsDestination == "MOXA") || ($paramFastToolsDestination == "WAGO")) {
								// Define STATION for MOXA, Template from "DM-01-06-03-02"
								// Define STATION for WAGO, Template from "DM-02-08-02-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
																		   || ($results_data_item_df['TAG'] == "PT_EXT") 
																		   || ($results_data_item_df['TAG'] == "PT_INT") 
																		   || ($results_data_item_df['TAG'] == "TOTAL")){
									$value = $tmpDM_Name.":".$results_data_item_df['TAG'];
								} else {
									$value = $results_data_item_df[$meta['name']];
								}
							} else if ($paramFastToolsDestination == "ABB AC500") {
								// Define STATION for ABB AC500, Template from "DM-01-06-01-01"
								if (($results_data_item_df['TAG'] == "COMM_STS") || ($results_data_item_df['TAG'] == "PT_EXT_HI_ALM") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_HI_SP") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_LO_ALM") 
										|| ($results_data_item_df['TAG'] == "PT_EXT_LO_SP")){
										$value = ":";
								} else {
									$value = $tmpDM_Name.":".$results_data_item_df['TAG'];
								}
							} else if ($paramFastToolsDestination == "PGIM_BRANCH") {
								// Define STATION for PGIM_BRANCH, Template from "DM-02-15-01-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "ON") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT")
										|| ($results_data_item_df['TAG'] == "TOTAL")){
									$value = "B".$tmpBranch_Name."_PGIM".":".$tmpDM_Name.".".$results_data_item_df['TAG'];
								} else {
									$value = ":";
								}
							} else if ($paramFastToolsDestination == "DCXII") {
								// Define STATION for DCXII, Template from "DM-02-02-08-01"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "LOG_FREQ") 
										|| ($results_data_item_df['TAG'] == "PT_EXT") 
										|| ($results_data_item_df['TAG'] == "PT_INT")
										|| ($results_data_item_df['TAG'] == "TOTAL")){
										$value = "DCXII:".$tmpDM_Name.".".$results_data_item_df['TAG'];
								} else {
									$value = "N/A";
								}
							} else if ($paramFastToolsDestination == "PGIM_WTDC") {
								// Define STATION for PGIM_WTDC, Template from "U208"
								if (($results_data_item_df['TAG'] == "FT") || ($results_data_item_df['TAG'] == "PT")){
										$value = "WTDC_PGIM:".$tmpDM_Name.".".$results_data_item_df['TAG'];
								} else {
									$value = "N/A";
								}
							}

						} else if ($meta['name'] == "AOI_1") {
							
							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_item_df[$meta['name']];
							} else {
								$tmpDM_Name = $paramListDM[$j-$startRow_item_df]->name;
								$tmpDatabaseAOI_Name = "DB".substr($tmpDM_Name, 3, 2);

								if ($results_data_item_df['TAG'] == "LOG_FREQ"){
									$value = $tmpDatabaseAOI_Name;
								} else {
									$value = $results_data_item_df[$meta['name']];
								}
							}

						} else {
							$tmpValue = $results_data_item_df[$meta['name']];
							$value = trim(preg_replace('/\t+/', '', $tmpValue));
						}
						
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
					}
				$k = $k +1;

			}

		}
	    /*  OBJECT_DF Partial */
	    		$sheetCount = $objPHPExcel->getSheetCount();

		/* Create Worksheet พร้อมกำหนดชื่อ */
		$objPHPExcel_OBJECT_DF_Worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'OBJECT_DF');
		$objPHPExcel->addSheet($objPHPExcel_OBJECT_DF_Worksheet, $sheetCount);
		$objPHPExcel_OBJECT_DF_Worksheet->setTitle('OBJECT_DF');

		/* กำหนดให้เป็น ActiveWorkSheet */
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex($sheetCount);


		/* Create Header */
		//$reports = $db->modbus_point_df[1];
		$results_header_object_df = $db->object_df()->where("templates = ?", "header_template")->fetch();

		$sth_object_df = $pdo->prepare("SELECT * FROM object_df WHERE templates = 'header_template'");
		$sth_object_df->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols_object_df = $sth_object_df->columnCount();
		$startRow_object_df = 2;
		$startColumn_object_df = 4;

		for ($i = $startColumn_object_df; $i < $numCols_object_df; $i++) {
			$meta = $sth_object_df->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn_object_df;
			$tmpValue = $results_header_object_df[$meta['name']];
			$value = trim(preg_replace('/\t+/', '', $tmpValue));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}




		/* Create Details */

		$numDM = count($paramListDM);  // จำนวน DM
		$z=1;
		for ($j=$startRow_object_df; $j < $numDM+$startRow_object_df; $j++) { 

			$results_data_object_dfs = $db->object_df()->where("templates = ? and rtu_install = ? and fasttools_destination = ?", "data_template", $paramRtuInstall, $paramFastToolsDestination);

			$k = 0;  // จำนวนแภวของ Template
			foreach ($results_data_object_dfs as $results_data_object_df) {

					$z = $z +1;
					for ($i = $startColumn_object_df; $i < $numCols_object_df; $i ++) {
						$meta = $sth_object_df->getColumnMeta($i);
						$row = $z;		// แถวที่ $row ของ Excel
						$col = $i-$startColumn_object_df;	// คอลัมภ์ที่ $col ของ Excel


						if ($meta['name'] == "UNIT") {

							if($paramRtuInstall == "PRODUCTION") {
								$value = "WTDC";
							} else {
								$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
								$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);
								$value = $tmpBranch_Name;
							}

						} else if ($meta['name'] == "TAG") {

							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$value = $tmpDM_Name;

						} else if ($meta['name'] == "DESCRIPTION") {
							
							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {
								$value = $paramFastToolsDestination;
							}

						} else if ($meta['name'] == "NAME") {
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								// PRODUCTION.WTDC.U208.U208
								$value = $paramRtuInstall.".WTDC.".$tmpDM_Name.".".$tmpDM_Name;
							} else {
								//SERVICE.B01.DM-01-06-03-02.DM-01-06-03-02
								$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".".$tmpDM_Name;
							}

						} else if ($meta['name'] == "ATTR_VALUE_1") {

							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								// PRODUCTION.WTDC.U208.FT
								$value = $paramRtuInstall.".WTDC.".$tmpDM_Name.".FT";
							} else {
								// SERVICE.B01.DM-01-06-03-02.FT
								$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".FT";
							}


						} else if ($meta['name'] == "ATTR_VALUE_2") {

							//SERVICE.B01.DM-01-06-03-02.FT_HI_ALM
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								// PRODUCTION.WTDC.U208.PT
								$value = $paramRtuInstall.".WTDC.".$tmpDM_Name.".PT";
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_FT_HI_ALM";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".FT_HI_ALM";
								}
								
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_3") {

							//SERVICE.B01.DM-01-06-03-02.FT_LO_ALM
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_FT_LO_ALM";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".FT_LO_ALM";
								}
							}

						} else if ($meta['name'] == "ATTR_VALUE_4") {

							//SERVICE.B01.DM-01-06-03-02.FT_HI_SP
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_FT_HI_SP";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".FT_HI_SP";
								}
							}

						} else if ($meta['name'] == "ATTR_VALUE_5") {

							//SERVICE.B01.DM-01-06-03-02.FT_LO_SP
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_FT_LO_SP";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".FT_LO_SP";
								}
							}

						} else if ($meta['name'] == "ATTR_VALUE_6") {

							//SERVICE.B01.DM-01-06-03-02.PT_INT
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								// if($paramFastToolsDestination == "DCXII") {
								// 	$value = "OTHER.DUMMY.DUMMY_FT_LO_SP";
								// } else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_INT";
								// }
							}

						} else if ($meta['name'] == "ATTR_VALUE_7") {

							//SERVICE.B01.DM-01-06-03-02.PT_INT_HI_ALM
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_INT_HI_ALM";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_INT_HI_ALM";
								}
							}

						} else if ($meta['name'] == "ATTR_VALUE_8") {

							//SERVICE.B01.DM-01-06-03-02.PT_INT_LO_ALM
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_INT_LO_ALM";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_INT_LO_ALM";
								}
							}

						} else if ($meta['name'] == "ATTR_VALUE_9") {

							//SERVICE.B01.DM-01-06-03-02.PT_INT_HI_SP
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_INT_HI_SP";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_INT_HI_SP";
								}
							}

						} else if ($meta['name'] == "ATTR_VALUE_10") {

							//SERVICE.B01.DM-01-06-03-02.PT_INT_LO_SP
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_INT_LO_SP";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_INT_LO_SP";
								}
							}

						} else if ($meta['name'] == "ATTR_VALUE_11") {

							//SERVICE.B01.DM-01-06-03-02.PT_EXT
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if($paramFastToolsDestination == "ABB CTU800") {
									$value = "OTHER.DUMMY.DUMMY_PT_EXT";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_EXT";
								}
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_12") {

							//SERVICE.B01.DM-01-06-03-02.PT_EXT_HI_ALM
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_EXT_HI_ALM";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_EXT_HI_ALM";
								}
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_13") {

							//SERVICE.B01.DM-01-06-03-02.PT_EXT_LO_ALM
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_EXT_LO_ALM";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_EXT_LO_ALM";
								}
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_14") {

							//SERVICE.B01.DM-01-06-03-02.PT_EXT_HI_SP
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_EXT_HI_SP";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_EXT_HI_SP";
								}
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_15") {

							//SERVICE.B01.DM-01-06-03-02.PT_EXT_LO_SP
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if(($paramFastToolsDestination == "DCXII")||($paramFastToolsDestination == "ABB CTU800")) {
									$value = "OTHER.DUMMY.DUMMY_PT_EXT_LO_SP";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_EXT_LO_SP";
								}
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_16") {

							//SERVICE.B01.DM-01-06-03-02.TOTAL
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								// if($paramFastToolsDestination == "DCXII") {
								// 	$value = "OTHER.DUMMY.DUMMY_PT_EXT_LO_SP";
								// } else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".TOTAL";
								// }
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_17") {

							//SERVICE.B01.DM-01-06-03-02.LOG_FREQ
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								// if($paramFastToolsDestination == "DCXII") {
								// 	$value = "OTHER.DUMMY.DUMMY_PT_EXT_LO_SP";
								// } else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".LOG_FREQ";
								// }
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_18") {

							//SERVICE.B01.DM-01-06-03-02.COMM_STS
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if($paramFastToolsDestination == "PGIM_BRANCH") {
									$value = "OTHER.DUMMY.DUMMY_COMM_STS";
								} else if($paramFastToolsDestination == "DCXII") {
									$value = "OTHER.DUMMY.DUMMY_COMM_STS";
								} else {
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".COMM_STS";
								}
							}
							

						} else if ($meta['name'] == "ATTR_VALUE_19") {

							//SERVICE.B01.DM-01-06-03-02.COMM_STS
							$tmpDM_Name = $paramListDM[$j-$startRow_object_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							if($paramRtuInstall == "PRODUCTION") {
								$value = "";
								//$value = $results_data_object_df[$meta['name']];
							} else {

								if($paramFastToolsDestination == "PGIM_BRANCH") {
									// SERVICE.B02.DM-02-15-01-01.ON
									$value = $paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".ON";
								} else {
									$value = "OTHER.DUMMY.DUMMY_ON";
								}
							}
							

						} else {
							$tmpValue = $results_data_object_df[$meta['name']];
							$value = trim(preg_replace('/\t+/', '', $tmpValue));
						}
						
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
					}
				$k = $k +1;

			}

		}




	    /*  ITEM_HIS_DF Partial */
	    		$sheetCount = $objPHPExcel->getSheetCount();

		/* Create Worksheet พร้อมกำหนดชื่อ */
		$objPHPExcel_ITEM_HIS_DF_Worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'ITEM_HIS_DF');
		$objPHPExcel->addSheet($objPHPExcel_ITEM_HIS_DF_Worksheet, $sheetCount);
		$objPHPExcel_ITEM_HIS_DF_Worksheet->setTitle('ITEM_HIS_DF');

		/* กำหนดให้เป็น ActiveWorkSheet */
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex($sheetCount);


		/* Create Header */
		//$reports = $db->modbus_point_df[1];
		$results_header_item_his_df = $db->item_his_df()->where("templates = ?", "header_template")->fetch();

		$sth_item_his_df = $pdo->prepare("SELECT * FROM item_his_df WHERE templates = 'header_template'");
		$sth_item_his_df->execute();
		/* Count the number of columns in the (non-existent) result set */
		$numCols_item_his_df = $sth_item_his_df->columnCount();
		$startRow_item_his_df = 2;
		$startColumn_item_his_df = 4;

		for ($i = $startColumn_item_his_df; $i < $numCols_item_his_df; $i++) {
			$meta = $sth_item_his_df->getColumnMeta($i);

			$row = 1;		// แถวที่ 1 ของ Excel
			$col = $i-$startColumn_item_his_df;
			$tmpValue = $results_header_item_his_df[$meta['name']];
			$value = trim(preg_replace('/\t+/', '', $tmpValue));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
		}




		/* Create Details */

		$numDM = count($paramListDM);  // จำนวน DM
		$z=1;
		for ($j=$startRow_item_his_df; $j < $numDM+$startRow_item_his_df; $j++) { 

			$results_data_item_his_dfs = $db->item_his_df()->where("templates = ? and rtu_install = ? and fasttools_destination = ?", "data_template", $paramRtuInstall, $paramFastToolsDestination);

			$k = 0;  // จำนวนแภวของ Template
			foreach ($results_data_item_his_dfs as $results_data_item_his_df) {

					$z = $z +1;
					for ($i = $startColumn_item_his_df; $i < $numCols_item_his_df; $i ++) {
						$meta = $sth_item_his_df->getColumnMeta($i);
						$row = $z;		// แถวที่ $row ของ Excel
						$col = $i-$startColumn_item_his_df;	// คอลัมภ์ที่ $col ของ Excel

// TEN_SECONDS:SERVICE.B01.DM-01-06-03-02.FT
// TEN_SECONDS:SERVICE.B01.DM-01-06-03-02.PT_INT
// TEN_SECONDS:SERVICE.B01.DM-01-06-03-02.PT_EXT

						if ($meta['name'] == "NAME") {

							$tmpDM_Name = $paramListDM[$j-$startRow_item_his_df]->name;
							$tmpBranch_Name = "B".substr($tmpDM_Name, 3, 2);

							$tmpValue = $results_data_item_his_df[$meta['name']];

							if($paramRtuInstall == "PRODUCTION") {
								// TEN_SECONDS:PRODUCTION.WTDC.U208.FT
								if ((substr($tmpValue, -2) == "FT")) {
									$value = $results_data_item_his_df['GROUP_NAME'].":".$paramRtuInstall.".WTDC.".$tmpDM_Name.".FT";
								} else if ((substr($tmpValue, -2) == "PT")) {
									$value = $results_data_item_his_df['GROUP_NAME'].":".$paramRtuInstall.".WTDC.".$tmpDM_Name.".PT";
								} else {
									$value = "N/A";
								}

							} else if($paramRtuInstall == "ABB CTU800"){

								if ((substr($tmpValue, -2) == "FT")) {
									// TEN_SECONDS:SERVICE.B03.DM-03-01-03-01.FT
									$value = $results_data_item_his_df['GROUP_NAME'].":".$paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".FT";
								} else if ((substr($tmpValue, -6) == "PT_INT")) {
									// TEN_SECONDS:SERVICE.B03.DM-03-01-03-01.PT_INT
									$value = $results_data_item_his_df['GROUP_NAME'].":".$paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_INT";
								}

							} else {
								// TEN_SECONDS:SERVICE.B02.DM-02-02-08-01.PT_EXT
								if ((substr($tmpValue, -2) == "FT")) {
									$value = $results_data_item_his_df['GROUP_NAME'].":".$paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".FT";
								} else if ((substr($tmpValue, -6) == "PT_INT")) {
									$value = $results_data_item_his_df['GROUP_NAME'].":".$paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_INT";
								} else if ((substr($tmpValue, -6) == "PT_EXT")) {
									$value = $results_data_item_his_df['GROUP_NAME'].":".$paramRtuInstall.".".$tmpBranch_Name.".".$tmpDM_Name.".PT_EXT";
								}

							}

							

						} else {
							$tmpValue = $results_data_item_his_df[$meta['name']];
							$value = trim(preg_replace('/\t+/', '', $tmpValue));
						}
						
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
					}
				$k = $k +1;

			}

		}






		/* ************************* */
        /* เริ่มกระบวนการสร้าง Excel file */
        /* ************************* */

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");


		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="01simple.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$date = new DateTime();
		$fileName = 'Quickload_for_IEC60870('.$paramFastToolsDestination.')'.'_'.date("Y-m-d").'_'.$date->getTimestamp().'.xls';
		$filePath = '../../files/'.$fileName;
		$objWriter->save($filePath);



	    /* ************************* */
	    /* เริ่มกระบวนการส่งค่ากลับ */
	    /* ************************* */
	    $reports[] = array(
	    		"filename" => $fileName,
	    		"path" => url()."/scada-it/build/files/".$fileName
	    	);


	    $resultText = "success";

	    $reportResult = array("result" =>  $resultText, "rows" => $reports);
	    //$reportResult = array("result" =>  $resultText);

	    $app->response()->header("Content-Type", "application/json");
	    echo json_encode($reportResult);


    }
    

    /* Admin manager Partial */
    	/**
	 *
	 * @apiName UpdateScadaInfoIpFromHostManager
	 * @apiGroup Admin
	 * @apiVersion 0.1.0
	 *
	 * @api {post} /AdminAPI/updateScadaInfoIpFromHostManager/ Update SCADA Info from Host
	 * @apiDescription คำอธิบาย : ในส่วนนี้ใช้สำหรับอัพเดตข้อมูล IP Address ใน SCADA โดยอ้างอิงจากฐานข้อมูลที่เก็บ Host file (ตาราง "tb_scada_host_info")
	 *
	 *
	 *
	 * @apiSampleRequest /AdminAPI/updateScadaInfoIpFromHostManager/
	 *
	 * @apiSuccess {String} msg แสดงข้อความทักทายผู้ใช้งาน
	 *
	 * @apiSuccessExample Example data on success:
	 * {
	 *   "msg": "Hello, anusorn"
	 * }
	 *
	 * @apiError UserNotFound The <code>id</code> of the User was not found.
	 * @apiErrorExample {json} Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "UserNotFound"
	 *     }
	 *
	 */
	 function updateScadaInfoIpFromHostManager($app, $pdo, $db) {
		
	 	/* ************************* */
	 	/* เริ่มกระบวนการเชื่อมต่อกับฐานข้อมูล MySQL */
	 	/* ************************* */
	 	$reports = array();

		$scada_rtu_info_results = $db->tb_main02_scada_rtu_info();

		foreach ($scada_rtu_info_results as $scada_rtu_info_result) {
			// ค้นหา ip address จากฐานข้อมูลที่เก็บ Host file (ตาราง "tb_scada_host_info")
			$host_info_result = $db->tb_scada_host_info()->where("host_name = ? and status = 1", $scada_rtu_info_result["meter_code"])->fetch();


			$result_scadaInfo = $db->tb_main02_scada_rtu_info()->where("meter_code = ?", $scada_rtu_info_result["meter_code"])->fetch();
			if ($result_scadaInfo !== false) {

				$data = array(
					"ip_address" => $host_info_result["ip"],
					"comm" => (substr($host_info_result["ip"],0,3)=="192"?"PSTN":"GPRS")
				);

				$result_updateScadaInfo = $result_scadaInfo->update($data);
			    $msgIpAddress = $host_info_result["ip"];
			    
			} else {

				$data = array(
					"ip_address" => "",
					"comm" => ""
				);
				$result_updateScadaInfo = $result_scadaInfo->update($data);
			    $msgIpAddress = "";
			}

			// if ($result_updateScadaInfo) {
			// 	$resultMsg = "อัพเดตข้อมูล รหัส $postWalkInId สำเร็จ";
			// } else {
			// 	$resultMsg = "ไม่สามารถอัพเดตข้อมูลได้";
			// }


			$reports[] = array(
				"meterCode" => $scada_rtu_info_result["meter_code"],
				"loggerCode" => $scada_rtu_info_result["logger_code"],
				"ipAddress" => $msgIpAddress
				);

		}

		$rowCount = count($scada_rtu_info_results);

	    /* ************************* */
	    /* เริ่มกระบวนการส่งค่ากลับ */
	    /* ************************* */
	    $resultText = "success";

	    $reportResult = array("result" =>  $resultText, "count"=>$rowCount, "rows" => $reports);

	    $app->response()->header("Content-Type", "application/json");
	    echo json_encode($reportResult);

	    // $return_m = array("msg" => "Hello, Current PHP version: ". phpversion());
	    // echo json_encode($return_m);

	}
    	/**
	 *
	 * @apiName UpdateCommentHostFileManager
	 * @apiGroup Admin
	 * @apiVersion 0.1.0
	 *
	 * @api {post} /AdminAPI/updateCommentHostFileManager/ Update Comment in Host file
	 * @apiDescription คำอธิบาย : ในส่วนนี้ใช้สำหรับอัพเดต Comment ในฐานข้อมูลที่เก็บ Host file (ตาราง "tb_scada_host_info")
	 *
	 *
	 *
	 * @apiSampleRequest /AdminAPI/updateCommentHostFileManager/
	 *
	 * @apiSuccess {String} msg แสดงข้อความทักทายผู้ใช้งาน
	 *
	 * @apiSuccessExample Example data on success:
	 * {
	 *   "msg": "Hello, anusorn"
	 * }
	 *
	 * @apiError UserNotFound The <code>id</code> of the User was not found.
	 * @apiErrorExample {json} Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "UserNotFound"
	 *     }
	 *
	 */
	 function updateCommentHostFileManager($app, $pdo, $db) {
		
	 	/* ************************* */
	 	/* เริ่มกระบวนการเชื่อมต่อกับฐานข้อมูล MySQL */
	 	/* ************************* */
	 	$reports = array();

		$scada_host_info_results = $db->tb_scada_host_info();

		foreach ($scada_host_info_results as $scada_host_info_result) {
			
			$tmpHostName = $scada_host_info_result["host_name"];

			// ค้นหา Logger Code จากฐานข้อมูล (ตาราง "tb_main02_scada_rtu_info")
			$scada_rtu_info_result = $db->tb_main02_scada_rtu_info()->where("meter_code = ? ", $tmpHostName)->fetch();

			// ค้นหารายละเอียด Logger Code จากฐานข้อมูล (ตาราง "tb_rtu_general_info")
			$rtu_general_info_result = $db->tb_rtu_general_info()->where("LOGGER_CODE = ? ", $scada_rtu_info_result["logger_code"])->fetch();


			//#B01 B&R  X20 PSTN

			if (substr($scada_host_info_result["host_name"],0,2) == "DM") {
				$tmpBranchName = "B".substr($scada_host_info_result["host_name"],3,2);
				$tmpComment = "#".$tmpBranchName."	".$rtu_general_info_result["BRAND"]."	".$scada_rtu_info_result["logger_code"]."	".$scada_rtu_info_result["comm"];
			} else {
				$tmpBranchName = "";
				$tmpComment = "";
			}

			$data = array(
				"comments" => $tmpComment
			);

			// อัพเดต Comment ในฐานข้อมูลที่เก็บ Host file (ตาราง "tb_scada_host_info")
			$scada_host_info_result_update = $db->tb_scada_host_info()->where("host_name = ? ", $tmpHostName)->fetch();

			if ($scada_host_info_result_update !== false) {

				$result_updateScadaRTUInfo = $scada_host_info_result_update->update($data);
			    
			} else {

				$result_updateScadaRTUInfo = $scada_host_info_result_update->update($data);
			}





			

			$reports[] = array(
				"hostName" => $scada_host_info_result["host_name"],
				"ipAddress" => $scada_host_info_result["ip"],
				"comment" => $tmpComment
				);

		}

		$rowCount = count($scada_host_info_results);

	    /* ************************* */
	    /* เริ่มกระบวนการส่งค่ากลับ */
	    /* ************************* */
	    $resultText = "success";

	    $reportResult = array("result" =>  $resultText, "count"=>$rowCount, "rows" => $reports);

	    $app->response()->header("Content-Type", "application/json");
	    echo json_encode($reportResult);

	    // $return_m = array("msg" => "Hello, Current PHP version: ". phpversion());
	    // echo json_encode($return_m);

	}
    	/**
	 *
	 * @apiName UpdateInsertAllRtuManager
	 * @apiGroup Admin
	 * @apiVersion 0.1.0
	 *
	 * @api {post} /AdminAPI/updateInsertAllRtuManager/ Update/Insert All RTU 
	 * @apiDescription คำอธิบาย : ในส่วนนี้ใช้สำหรับรวบรวมข้อมูล RTU ทั้งหมด จากทั้งผู้ใช้งาน, scada และ wlma
	 *
	 *
	 *
	 * @apiSampleRequest /AdminAPI/updateInsertAllRtuManager/
	 *
	 * @apiSuccess {String} msg แสดงข้อความทักทายผู้ใช้งาน
	 *
	 * @apiSuccessExample Example data on success:
	 * {
	 *   "msg": "Hello, anusorn"
	 * }
	 *
	 * @apiError UserNotFound The <code>id</code> of the User was not found.
	 * @apiErrorExample {json} Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "UserNotFound"
	 *     }
	 *
	 */
	 function updateInsertAllRtuManager($app, $pdo, $db) {

	 	/* ************************* */
	 	/* เริ่มกระบวนการเชื่อมต่อกับฐานข้อมูล MySQL */
	 	/* ************************* */
	 	

	 	// Clear ข้อมูลเดิม (Empty the table - TRUNCATE)
	 	$truncate_result = $pdo->query("TRUNCATE TABLE `tb_main04_all_rtu_info`")->fetch();


	 	// Update ข้อมูลจากผู้ใช้งาน (ฝทส.)
		$main01_user_rtu_info_results = $db->tb_main01_user_rtu_info();
		foreach ($main01_user_rtu_info_results as $main01_user_rtu_info_result) {

			$tmpMeterCode = $main01_user_rtu_info_result["meter_code"];
			$tmpUserLoggerCode = $main01_user_rtu_info_result["logger_code"];
			$tmpUserIpAddress  = $main01_user_rtu_info_result["ip_address"];
			$tmpUserRtuStatus  = $main01_user_rtu_info_result["rtu_status"];

			$query_result = $db->tb_main04_all_rtu_info()->insert_update(
						    array("meter_code" => $tmpMeterCode), // unique key
						    array("user_logger_code" => $tmpUserLoggerCode, 
						    	  "user_ip_address"  => $tmpUserIpAddress, 
						    	  "user_rtu_status"  => $tmpUserRtuStatus), // insert values if the row doesn't exist
						    array("user_logger_code" => $tmpUserLoggerCode, 
						    	  "user_ip_address"  => $tmpUserIpAddress, 
						    	  "user_rtu_status"  => $tmpUserRtuStatus) // update values otherwise
						    );

		}

		// Update ข้อมูลจาก scada
		$main02_scada_rtu_info_results = $db->tb_main02_scada_rtu_info();
		foreach ($main02_scada_rtu_info_results as $main02_scada_rtu_info_result) {

			$tmpMeterCode = $main02_scada_rtu_info_result["meter_code"];
			$tmpUserLoggerCode = $main02_scada_rtu_info_result["logger_code"];
			$tmpUserIpAddress  = $main02_scada_rtu_info_result["ip_address"];
			$tmpUserRtuStatus  = $main02_scada_rtu_info_result["rtu_status"];

			$query_result = $db->tb_main04_all_rtu_info()->insert_update(
						    array("meter_code" => $tmpMeterCode), // unique key
						    array("scada_logger_code" => $tmpUserLoggerCode, 
						    	  "scada_ip_address"  => $tmpUserIpAddress, 
						    	  "scada_rtu_status"  => $tmpUserRtuStatus), // insert values if the row doesn't exist
						    array("scada_logger_code" => $tmpUserLoggerCode, 
						    	  "scada_ip_address"  => $tmpUserIpAddress, 
						    	  "scada_rtu_status"  => $tmpUserRtuStatus) // update values otherwise
						    );
		}

		// Update ข้อมูลจาก wlma
		$main03_wlma_rtu_info_results = $db->tb_main03_wlma_rtu_info();
		foreach ($main03_wlma_rtu_info_results as $main03_wlma_rtu_info_result) {

			$tmpMeterCode = $main03_wlma_rtu_info_result["meter_code"];
			$tmpUserLoggerCode = $main03_wlma_rtu_info_result["logger_code"];
			$tmpUserIpAddress  = $main03_wlma_rtu_info_result["ip_address"];
			$tmpUserRtuStatus  = $main03_wlma_rtu_info_result["rtu_status"];

			$query_result = $db->tb_main04_all_rtu_info()->insert_update(
						    array("meter_code" => $tmpMeterCode), // unique key
						    array("wlma_logger_code" => $tmpUserLoggerCode, 
						    	  "wlma_ip_address"  => $tmpUserIpAddress, 
						    	  "wlma_rtu_status"  => $tmpUserRtuStatus), // insert values if the row doesn't exist
						    array("wlma_logger_code" => $tmpUserLoggerCode, 
						    	  "wlma_ip_address"  => $tmpUserIpAddress, 
						    	  "wlma_rtu_status"  => $tmpUserRtuStatus) // update values otherwise
						    );

		}

		// แสดงรายการข้อมูลทั้งหมดจากฐานข้อมูลรวม tb_main04_all_rtu_info
		$reports = array();
		$main04_all_rtu_info_results = $db->tb_main04_all_rtu_info();
		foreach ($main04_all_rtu_info_results as $main04_all_rtu_info_result) {

			$reports[] = array(
				"meterCode" => $main04_all_rtu_info_result["meter_code"],
				"userLoggerCode" => $main04_all_rtu_info_result["user_logger_code"],
				"userIpAddress" => $main04_all_rtu_info_result["user_ip_address"],
				"userRtuStatus" => $main04_all_rtu_info_result["user_rtu_status"],
				"scadaLoggerCode" => $main04_all_rtu_info_result["scada_logger_code"],
				"scadaIpAddress" => $main04_all_rtu_info_result["scada_ip_address"],
				"scadaRtuStatus" => $main04_all_rtu_info_result["scada_rtu_status"],
				"wlmaLoggerCode" => $main04_all_rtu_info_result["wlma_logger_code"],
				"wlmaIpAddress" => $main04_all_rtu_info_result["wlma_ip_address"],
				"wlmaRtuStatus" => $main04_all_rtu_info_result["wlma_rtu_status"]
				);

		}

		$rowCount = count($main04_all_rtu_info_results);

	    /* ************************* */
	    /* เริ่มกระบวนการส่งค่ากลับ */
	    /* ************************* */
	    $resultText = "success";

	    $reportResult = array("result" =>  $resultText, "count"=>$rowCount, "rows" => $reports);

	    $app->response()->header("Content-Type", "application/json");
	    echo json_encode($reportResult);

	    // $return_m = array("msg" => "Hello, Current PHP version: ". phpversion());
	    // echo json_encode($return_m);

	}
    	/**
	 *
	 * @apiName UpdateOnOffScanScadaInfoManager
	 * @apiGroup Admin
	 * @apiVersion 0.1.0
	 *
	 * @api {post} /AdminAPI/updateOnOffScanScadaInfoManager/ Update ON_SCAN 
	 * @apiDescription คำอธิบาย : ในส่วนนี้ใช้สำหรับอัพเดต ค่า ON_SCAN ใน STATION_DF
	 *
	 *
	 *
	 * @apiSampleRequest /AdminAPI/updateOnOffScanScadaInfoManager/
	 *
	 * @apiSuccess {String} msg แสดงข้อความทักทายผู้ใช้งาน
	 *
	 * @apiSuccessExample Example data on success:
	 * {
	 *   "msg": "Hello, anusorn"
	 * }
	 *
	 * @apiError UserNotFound The <code>id</code> of the User was not found.
	 * @apiErrorExample {json} Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "UserNotFound"
	 *     }
	 *
	 */
	 function updateOnOffScanScadaInfoManager($app, $pdo, $db) {
		
	 	/* ************************* */
	 	/* เริ่มกระบวนการเชื่อมต่อกับฐานข้อมูล MySQL */
	 	/* ************************* */


	 	// Update ข้อมูล ON_SCAN จาก Fast/Tools
		$scada_station_df_results = $db->tb_scada_station_df();
		foreach ($scada_station_df_results as $scada_station_df_result) {

			$i = 0;

			// ค้นหาจากฐานข้อมูล (ตาราง "tb_main02_scada_rtu_info")
			$main02_scada_rtu_info_result = $db->tb_main02_scada_rtu_info()->where("meter_code = ? ", $scada_station_df_result["meter_code"])->fetch();

				if ($main02_scada_rtu_info_result !== false) {
						 $str = $scada_station_df_result["on_scan"];
						 $str = preg_replace('/(\v|\s)+/', ' ', $str);
						 $str = trim($str);

						 //$str = trim($text, " \t.");

						$data = array(
							"rtu_status" => $str
						);

						$result_updateScadaInfo = $main02_scada_rtu_info_result->update($data);

				} else {

				}

			}

	    $return_m = array("msg" => "Hello, Current PHP version: ". phpversion());
	    echo json_encode($return_m);

	}
    
	/**
	 *
	 * @apiName CompareWithExistingRtuManager
	 * @apiGroup Admin
	 * @apiVersion 0.1.0
	 *
	 * @api {post} /AdminAPI/compareWithExistingRtuManager/ CompareWithExistingRtuManager
	 * @apiDescription คำอธิบาย : ในส่วนนี้ใช้สำหรับตรวจสอบและเปรียบเทียบรายละเอียด RTU (เช่น IP Address, ชือ DM) ที่มีอยู่แล้วกับรายการ RTU ที่กำลังจะดำเนินการเพิ่มเข้าไป
	 *
	 *
	 *
	 * @apiParam {Object[]} listRTU รายการ RTU ที่ต้องการเพิ่มเข้าไปใหม่ในระบบ SCADA FastTools
	 * @apiParam {String} listRTU.branch_code รหัสสาขา
     * @apiParam {String} listRTU.zone_code รหัสโซน
     * @apiParam {String} listRTU.dma_code รหัส DMA
     * @apiParam {String} listRTU.meter_code รหัส DM หรือ meter_code นั่นเอง
     * @apiParam {String} listRTU.ip IP Address
     * @apiParam {String} listRTU.logger_code รหัสตัวแทนอุปกรณ์ภาคสนาม
     * @apiParam {String} listRTU.rtu_status สถานะ RTU (1 : OnScan, 0 : OffScan, blank : อาจจะเป็นกรณีการเชื่อมต่อผ่านทาง OPCDA ซึ่ง OnScan เป็นกลุ่มไม่ได้แยกแต่ละ DM)
     *
     * @apiParamExample {json} Request-Example (ตัวอย่าง Payload, Content-Type: application/json):
     *  {
     *      "listRTU": [
     *          {
     *              "branch_code": "",
     *              "zone_code": "",
     *              "dma_code": "",
     *              "meter_code": "DM-13-01-02-01",
     *              "ip": "10.50.133.145",
     *              "logger_code": "SIXNET",
     *              "rtu_status": "1"
     *          },
     *          {
     *              "branch_code": "",
     *              "zone_code": "",
     *              "dma_code": "",
     *              "meter_code": "DM-13-01-03-04",
     *              "ip": "10.202.71.63",
     *              "logger_code": "SIXNET",
     *              "rtu_status": "1"
     *          },
     *          {
     *              "branch_code": "",
     *              "zone_code": "",
     *              "dma_code": "",
     *              "meter_code": "DM-54-08-12-01",
     *              "ip": "10.50.131.92",
     *              "logger_code": "X20",
     *              "rtu_status": "1"
     *          }
     *      ]
     *  }
     *
	 * @apiSampleRequest /AdminAPI/compareWithExistingRtuManager/
	 *
	 * @apiSuccess (คำอธิบายผลลัพธ์ (กรณีส่งค่ากลับสำเร็จ Success 200)) {String} msg แสดงข้อความทักทายผู้ใช้งาน
	 *
	 * @apiSuccessExample Example data on success:
     *  {
     *      "result": "success",
     *      "rows": [
     *          {
     *              "filename": "Quickload_for_MODBUS(PGIM_WTDC)_2015-08-15_1439607474.xls",
     *              "path": "http://localhost/scada-it/build/files/Quickload_for_MODBUS(PGIM_WTDC)_2015-08-15_1439607474.xls"
     *          }
     *      ]
     *  }
	 *
	 * @apiError (คำอธิบายผลลัพธ์ (กรณีเกิด Error 4xx)) UserNotFound The <code>id</code> of the User was not found.
	 * @apiErrorExample {json} Error-Response:
	 *     HTTP/1.1 404 Not Found
	 *     {
	 *       "error": "UserNotFound"
	 *     }
	 *
	 */
    function compareWithExistingRtuManager($app, $pdo, $db) {


        /* ************************* */
        /* เริ่มกระบวนการรับค่าพารามิเตอร์จากส่วนของ Payload ซึ่งอยู่ในรูปแบบ JSON */
        /* ************************* */
        $headers = $app->request->headers;
        $ContetnType = $app->request->headers->get('Content-Type');

        /**
        * apidoc @apiSampleRequest, iOS RESTKit use content-type is "application/json"
        * Web Form, Advance REST Client App use content-type is "application/x-www-form-urlencoded"
        */
        if ($ContetnType == "application/json") {

             $request = $app->request();
             $result = json_decode($request->getBody());

             /* receive request */
             $paramListRTU = $result->listRTU;

 
          } else if ($ContetnType == "application/x-www-form-urlencoded"){

              //$userID = $app->request()->params('userID_param');
              //$userID = $app->request()->post('userID_param');
          }

          /* ************************* */
          /* เริ่มกระบวนการเชื่อมต่อกับฐานข้อมูล MySQL */
          /* ************************* */
          $reports = array();
          $reports_ip_compare = array();
          $reports_meterCode_compare = array();
          $ip_compared_duplicate = 0;
          $meterCode_compared_duplicate = 0;

          $numDM = count($paramListRTU);  // จำนวน DM

          for ($i=0; $i < $numDM; $i++) { 

               $tmpMeterCode = $paramListRTU[$i]->meter_code;
               $tmpIP = $paramListRTU[$i]->ip;
               $tmpLoggerCode = $paramListRTU[$i]->logger_code;

               // ค้นหา ip  จากฐานข้อมูล (ตาราง "tb_scada_host_info")
               $result_ip_compare = $db->tb_scada_host_info()->where("ip = ? and status = 1", $tmpIP)->fetch();

               if ($result_ip_compare) {
                    $reports_ip_compare[] = array(
                                                  "meter_code" => $tmpMeterCode,
                                                  "ip" => $tmpIP,
                                                  "loggerCode" => $tmpLoggerCode,
                                                  "compare_result" => array("meterCode" => $result_ip_compare["host_name"], 
                                                                            "ip" => $result_ip_compare["ip"],
                                                                            "comment" => $result_ip_compare["comments"])
                                             );
                    $ip_compared_duplicate++;
               }


               // ค้นหา meter_code  จากฐานข้อมูล (ตาราง "tb_scada_host_info")
               $result_meterCode_compare = $db->tb_scada_host_info()->where("host_name = ? and status = 1", $tmpMeterCode)->fetch();

               if ($result_meterCode_compare) {
                    $reports_meterCode_compare[] = array(
                                                  "meter_code" => $tmpMeterCode,
                                                  "ip" => $tmpIP,
                                                  "loggerCode" => $tmpLoggerCode,
                                                  "compare_result" => array("meterCode" => $result_meterCode_compare["host_name"], 
                                                                            "ip" => $result_meterCode_compare["ip"],
                                                                            "comment" => $result_meterCode_compare["comments"])
                                             );
                    $meterCode_compared_duplicate++;
               }

          }
          


         /* ************************* */
         /* เริ่มกระบวนการส่งค่ากลับ */
         /* ************************* */
         $resultText = "success";

         $compare_results = array("ip_compared_details" =>  $reports_ip_compare, "meterCode_compared_details" => $reports_meterCode_compare);

         $reports[] = array(
               "ip_compared_details" => $reports_ip_compare,
               "meterCode_compared_details" => $reports_meterCode_compare
          );

         $reportResult = array("result" =>  $resultText,
                                   "ip_compared_duplicate" => $ip_compared_duplicate, 
                                   "meterCode_compared_duplicate" => $meterCode_compared_duplicate, 
                                   "rows" => $reports);

         $app->response()->header("Content-Type", "application/json");
         echo json_encode($reportResult);

         // $return_m = array("msg" => "Hello, Current PHP version: ". phpversion());
         // echo json_encode($return_m);



    }
    
	/**
	 *
	 * @apiName AddUserInfoManager
	 * @apiGroup Admin
	 * @apiVersion 0.1.0
	 *
	 * @api {post} /AdminAPI/addUserInfoManager/ AddUserInfoManager
	 * @apiDescription คำอธิบาย : ในส่วนนี้ใช้สำหรับข้อมูลใหม่เข้าไปในระบบทั้งใน tb_scada_host_info, tb_main01_user_rtu_info
	 *
	 *
	 */
    function addUserInfoManager($app, $pdo, $db) {


        /* ************************* */
        /* เริ่มกระบวนการรับค่าพารามิเตอร์จากส่วนของ Payload ซึ่งอยู่ในรูปแบบ JSON */
        /* ************************* */
        $headers = $app->request->headers;
        $ContetnType = $app->request->headers->get('Content-Type');

        /**
        * apidoc @apiSampleRequest, iOS RESTKit use content-type is "application/json"
        * Web Form, Advance REST Client App use content-type is "application/x-www-form-urlencoded"
        */
        if ($ContetnType == "application/json") {

             $request = $app->request();
             $result = json_decode($request->getBody());

             /* receive request */
             $paramListRTU = $result->listRTU;

 
          } else if ($ContetnType == "application/x-www-form-urlencoded"){

              //$userID = $app->request()->params('userID_param');
              //$userID = $app->request()->post('userID_param');
          }



          /* ************************* */
          /* เริ่มกระบวนการเชื่อมต่อกับฐานข้อมูล MySQL */
          /* ************************* */

          $reports = array();
          $numDM = count($paramListRTU);  // จำนวน DM
          

          for ($i=0; $i < $numDM; $i++) { 

               $tmpBranchCode = $paramListRTU[$i]->branch_code;
               $tmpZoneCode = $paramListRTU[$i]->zone_code;
               $tmpDmaCode = $paramListRTU[$i]->dma_code;
               $tmpDmCode = $paramListRTU[$i]->dm_code;
               $tmpIP = $paramListRTU[$i]->ip;
               $tmpLoggerCode = $paramListRTU[$i]->logger_code;
               $tmpComm = $paramListRTU[$i]->comm;
               $tmpRtuStatus = $paramListRTU[$i]->rtu_status;
               

               /*  Update Existing Records (tb_scada_host_info) Partial */
                               // ค้นหาจากฐานข้อมูล (ตาราง "tb_scada_host_info")
                //$tb_scada_host_info_result = $db->tb_scada_host_info()->where("host_name = ? ", $tmpDmCode)->fetch();
                $tb_scada_host_info_result = $db->tb_scada_host_info()->where("host_name = ? ", $tmpDmCode);

                $result_updateScadaInfo = 0;

                if ($tb_scada_host_info_result !== false) {

                    $str = 0;

                    $data = array(
                      "status" => $str
                    );
                    // Update Existing Records
                    $result_updateScadaInfo = $tb_scada_host_info_result->update($data);

                } else {

                }
               /*  Insert/Update Records (tb_scada_host_info) Partial */
                               // ค้นหา Logger Code จากฐานข้อมูล (ตาราง "tb_main02_scada_rtu_info")
                $scada_rtu_info_result = $db->tb_main02_scada_rtu_info()->where("meter_code = ? ", $tmpDmCode)->fetch();
                // ค้นหารายละเอียด Logger Code จากฐานข้อมูล (ตาราง "tb_rtu_general_info")
                $rtu_general_info_result = $db->tb_rtu_general_info()->where("LOGGER_CODE_SCADA = ? ", $tmpLoggerCode)->fetch();
                //#B01 B&R  X20 PSTN
                if (substr($tmpDmCode,0,2) == "DM") {
                  $tmpBranchName = "B".substr($tmpDmCode,3,2);
                  $tmpComments = "#".$tmpBranchName."  ".$rtu_general_info_result["BRAND"]." ".$scada_rtu_info_result["logger_code"]." ".$scada_rtu_info_result["comm"];
                  $tmpSections = "# For RTU";
                } else {
                  $tmpBranchName = "";
                  $tmpComments = "";
                  $tmpSections = "";
                }

                // Insert or Update New Records
                $insertUpdate_result = $db->tb_scada_host_info()->insert_update(
                            array("ip_host_name" => $tmpIP."_".$tmpDmCode), // unique key
                            array("sections" => $tmpSections, 
                                  "ip"  => $tmpIP, 
                                  "host_name"  => $tmpDmCode,
                                  "comments"  => $tmpComments, // #B01 B&R  X20 GPRS
                                  "status"  => $tmpRtuStatus), // insert values if the row doesn't exist
                            array("comments"  => $tmpComments, // #B01 B&R  X20 GPRS
                                  "status"  => $tmpRtuStatus)// update values otherwise
                );
               /*  Check IP Address Duplicate (tb_scada_host_info) Partial */
                               // Check IP Address Duplicate???
                $resons = array();             // เหตุผลต่างๆ เช่น IP ซ้ำหรือไม่? , DM เคยมีอยู่แล้วหรือเปล่า?
                $ip_duplicates = array();
                // $ip_repeat_results = $db->tb_scada_host_info()->where("ip = ? and status = 1 and ip_host_name != '10.50.130.247_DM-01-01-04-01'", $tmpIP);
                $ip_duplicate_results = $db->tb_scada_host_info()->where("ip = ? and status = 1 and ip_host_name != ?", $tmpIP, $tmpIP."_".$tmpDmCode);
                // $ip_repeat_results = $db->tb_scada_host_info()->where("ip = ? and status = 1", $tmpIP);
                foreach ($ip_duplicate_results as $ip_duplicate_result) {
                  $ip_duplicates[] = array(
                    "message" => "IP ซ้ำกับ ".$ip_duplicate_result["host_name"]." (id : ".$ip_duplicate_result["id"].")"
                  );
                }
               /*  Check DM Duplicate (tb_scada_host_info) Partial */
                               // Check DM Duplicate???
                $dm_duplicates = array();
                $dm_duplicate_results = $db->tb_scada_host_info()->where("host_name = ? and status = 1 and ip_host_name != ?", $tmpDmCode, $tmpIP."_".$tmpDmCode);
                foreach ($dm_duplicate_results as $dm_duplicate_result) {
                  $dm_duplicates[] = array(
                    "message" => "DM ซ้ำกับ ".$dm_duplicate_result["host_name"]." (id : ".$dm_duplicate_result["id"].")"
                  );
                }
               
               /*  Insert/Update Records (tb_main01_user_rtu_info) Partial */
               
    // Insert or Update User Records
    $insertUpdateUser_result = $db->tb_main01_user_rtu_info()->insert_update(
                array("meter_code" => $tmpDmCode), // unique key
                array("logger_code"  => $tmpLoggerCode,
                      "ip_address" => $tmpIP,
                      "comm" => $tmpComm,
                      "rtu_status" => $tmpRtuStatus), // insert values if the row doesn't exist
                array("logger_code"  => $tmpLoggerCode,
                      "ip_address" => $tmpIP,
                      "comm" => $tmpComm,
                      "rtu_status" => $tmpRtuStatus)// update values otherwise
    );


                $resons[] = array(
                    "ip_duplicate" => $ip_duplicates,
                    "dm_duplicate" => $dm_duplicates
                );


               $reports[] = array(
                  "dm_code" => $tmpDmCode,
                  "ip" => $tmpIP,
                  "check_with_existing_result" => $resons
                );



          }


         /* ************************* */
         /* เริ่มกระบวนการส่งค่ากลับ */
         /* ************************* */
         $resultText = "success";

         $reportResult = array("result" =>  $resultText,
                                   "rows" => $reports);

         $app->response()->header("Content-Type", "application/json");
         echo json_encode($reportResult);

         // $return_m = array("msg" => "Hello, Current PHP version: ". phpversion());
         // echo json_encode($return_m);



    }
    
	/**
	 *
	 * @apiName AddScadaInfoManager
	 * @apiGroup Admin
	 * @apiVersion 0.1.0
	 *
	 * @api {post} /AdminAPI/addScadaInfoManager/ AddScadaInfoManager
	 * @apiDescription คำอธิบาย : ในส่วนนี้ใช้สำหรับข้อมูลใหม่เข้าไปในระบบทั้งใน tb_scada_station_df
	 *
	 *
	 */
    function addScadaInfoManager($app, $pdo, $db) {


        /* ************************* */
        /* เริ่มกระบวนการรับค่าพารามิเตอร์จากส่วนของ Payload ซึ่งอยู่ในรูปแบบ JSON */
        /* ************************* */
        $headers = $app->request->headers;
        $ContetnType = $app->request->headers->get('Content-Type');

        /**
        * apidoc @apiSampleRequest, iOS RESTKit use content-type is "application/json"
        * Web Form, Advance REST Client App use content-type is "application/x-www-form-urlencoded"
        */
        if ($ContetnType == "application/json") {

             $request = $app->request();
             $result = json_decode($request->getBody());

             /* receive request */
             $paramListRTU = $result->listRTU;

 
          } else if ($ContetnType == "application/x-www-form-urlencoded"){

              //$userID = $app->request()->params('userID_param');
              //$userID = $app->request()->post('userID_param');
          }



          /* ************************* */
          /* เริ่มกระบวนการเชื่อมต่อกับฐานข้อมูล MySQL */
          /* ************************* */

          $reports = array();
          $numDM = count($paramListRTU);  // จำนวน DM
          

          for ($i=0; $i < $numDM; $i++) { 

               $tmpBranchCode = $paramListRTU[$i]->branch_code;
               $tmpZoneCode = $paramListRTU[$i]->zone_code;
               $tmpDmaCode = $paramListRTU[$i]->dma_code;
               $tmpDmCode = $paramListRTU[$i]->dm_code;
               $tmpIP = $paramListRTU[$i]->ip;
               $tmpLoggerCode = $paramListRTU[$i]->logger_code;
               $tmpComm = $paramListRTU[$i]->comm;
               $tmpRtuStatus = $paramListRTU[$i]->rtu_status;
               

               /*  Insert/Update Records (tb_main02_scada_rtu_info) Partial */
               
    // Insert or Update SCADA Records
    $insertUpdateScada_result = $db->tb_main02_scada_rtu_info()->insert_update(
                array("meter_code" => $tmpDmCode), // unique key
                array("logger_code"  => $tmpLoggerCode,
                      "ip_address" => $tmpIP,
                      "comm" => $tmpComm,
                      "rtu_status" => $tmpRtuStatus), // insert values if the row doesn't exist
                array("logger_code"  => $tmpLoggerCode,
                      "ip_address" => $tmpIP,
                      "comm" => $tmpComm,
                      "rtu_status" => $tmpRtuStatus)// update values otherwise
    );



               $reports[] = array(
                  "dm_code" => $tmpDmCode,
                  "ip" => $tmpIP
                );



          }


         /* ************************* */
         /* เริ่มกระบวนการส่งค่ากลับ */
         /* ************************* */
         $resultText = "success";

         $reportResult = array("result" =>  $resultText,
                                   "rows" => $reports);

         $app->response()->header("Content-Type", "application/json");
         echo json_encode($reportResult);

         // $return_m = array("msg" => "Hello, Current PHP version: ". phpversion());
         // echo json_encode($return_m);

    }


    
	/**
	 *
	 * @apiName AddWlmaInfoManager
	 * @apiGroup Admin
	 * @apiVersion 0.1.0
	 *
	 * @api {post} /AdminAPI/addWlmaInfoManager/ AddWlmaInfoManager
	 * @apiDescription คำอธิบาย : ในส่วนนี้ใช้สำหรับข้อมูลใหม่เข้าไปในระบบใน tb_main03_wlma_rtu_info
	 *
	 *
	 */
    function addWlmaInfoManager($app, $pdo, $db) {


        /* ************************* */
        /* เริ่มกระบวนการรับค่าพารามิเตอร์จากส่วนของ Payload ซึ่งอยู่ในรูปแบบ JSON */
        /* ************************* */
        $headers = $app->request->headers;
        $ContetnType = $app->request->headers->get('Content-Type');

        /**
        * apidoc @apiSampleRequest, iOS RESTKit use content-type is "application/json"
        * Web Form, Advance REST Client App use content-type is "application/x-www-form-urlencoded"
        */
        if ($ContetnType == "application/json") {

             $request = $app->request();
             $result = json_decode($request->getBody());

             /* receive request */
             $paramListRTU = $result->listRTU;

 
          } else if ($ContetnType == "application/x-www-form-urlencoded"){

              //$userID = $app->request()->params('userID_param');
              //$userID = $app->request()->post('userID_param');
          }



          /* ************************* */
          /* เริ่มกระบวนการเชื่อมต่อกับฐานข้อมูล MySQL */
          /* ************************* */

          $reports = array();
          $numDM = count($paramListRTU);  // จำนวน DM
          

          for ($i=0; $i < $numDM; $i++) { 

               $tmpBranchCode = $paramListRTU[$i]->branch_code;
               $tmpZoneCode = $paramListRTU[$i]->zone_code;
               $tmpDmaCode = $paramListRTU[$i]->dma_code;
               $tmpDmCode = $paramListRTU[$i]->dm_code;
               $tmpIP = $paramListRTU[$i]->ip;
               $tmpLoggerCode = $paramListRTU[$i]->logger_code;
               $tmpComm = $paramListRTU[$i]->comm;
               $tmpRtuStatus = $paramListRTU[$i]->rtu_status;
               

               /*  Insert/Update Records (tb_main02_scada_rtu_info) Partial */
               
    // Insert or Update SCADA Records
    $insertUpdateWlma_result = $db->tb_main03_wlma_rtu_info()->insert_update(
                array("meter_code" => $tmpDmCode), // unique key
                array("logger_code"  => $tmpLoggerCode,
                      "ip_address" => $tmpIP,
                      "comm" => $tmpComm,
                      "rtu_status" => $tmpRtuStatus), // insert values if the row doesn't exist
                array("logger_code"  => $tmpLoggerCode,
                      "ip_address" => $tmpIP,
                      "comm" => $tmpComm,
                      "rtu_status" => $tmpRtuStatus)// update values otherwise
    );



               $reports[] = array(
                  "dm_code" => $tmpDmCode,
                  "ip" => $tmpIP
                );



          }


         /* ************************* */
         /* เริ่มกระบวนการส่งค่ากลับ */
         /* ************************* */
         $resultText = "success";

         $reportResult = array("result" =>  $resultText,
                                   "rows" => $reports);

         $app->response()->header("Content-Type", "application/json");
         echo json_encode($reportResult);

         // $return_m = array("msg" => "Hello, Current PHP version: ". phpversion());
         // echo json_encode($return_m);

    }


    
	/**
	 *
	 * @apiName CreateHostFileManager
	 * @apiGroup Admin
	 * @apiVersion 0.1.0
	 *
	 * @api {post} /AdminAPI/createHostFileManager/ CreateHostFileManager
	 * @apiDescription คำอธิบาย : ในส่วนนี้ใช้สำหรับสร้าง Host File
	 *
	 *
	 */
    function createHostFileManager($app, $pdo, $db) {


        /* ************************* */
        /* เริ่มกระบวนการรับค่าพารามิเตอร์จากส่วนของ Payload ซึ่งอยู่ในรูปแบบ JSON */
        /* ************************* */
        $headers = $app->request->headers;
        $ContetnType = $app->request->headers->get('Content-Type');

        /**
        * apidoc @apiSampleRequest, iOS RESTKit use content-type is "application/json"
        * Web Form, Advance REST Client App use content-type is "application/x-www-form-urlencoded"
        */
        if ($ContetnType == "application/json") {

             $request = $app->request();
             $result = json_decode($request->getBody());

             /* receive request */
             // $paramListRTU = $result->listRTU;

 
          } else if ($ContetnType == "application/x-www-form-urlencoded"){

              //$userID = $app->request()->params('userID_param');
              //$userID = $app->request()->post('userID_param');
          }


          /* ************************* */
          /* เริ่มกระบวนการเชื่อมต่อกับฐานข้อมูล MySQL */
          /* ************************* */
          $reports = array();

          $date = new DateTime();
          $fileName = 'HostFile'.'_'.date("Y-m-d").'_'.$date->getTimestamp().'.txt';
          $filePath = '../../files/'.$fileName;
          $myHostfile = fopen($filePath, "w") or die("Unable to open file!");
           
          $txtRecord = "# Copyright (c) 1993-2009 Microsoft Corp.\n";
          $txtRecord .= "#\n";
          $txtRecord .= "# This is a sample HOSTS file used by Microsoft TCP/IP for Windows. \n";
          $txtRecord .= "#\n";
          $txtRecord .= "# This file contains the mappings of IP addresses to host names. Each\n";
          $txtRecord .= "# entry should be kept on an individual line. The IP address should\n";
          $txtRecord .= "# be placed in the first column followed by the corresponding host name.  \n";
          $txtRecord .= "# The IP address and the host name should be separated by at least one\n";
          $txtRecord .= "# space. \n";
          $txtRecord .= "#\n";
          $txtRecord .= "# Additionally, comments (such as these) may be inserted on individual \n";
          $txtRecord .= "# lines or following the machine name denoted by a '#' symbol.\n";
          $txtRecord .= "#\n";
          $txtRecord .= "# For example:  \n";
          $txtRecord .= "#\n";
          $txtRecord .= "# 102.54.94.97     rhino.acme.com          # source server \n";
          $txtRecord .= "# 38.25.63.10     x.acme.com              # x client host \n";
          $txtRecord .= "\n";
          $txtRecord .= "# localhost name resolution is handled within DNS itself.  \n";
          $txtRecord .= "# 127.0.0.1       localhost \n";
          $txtRecord .= "# ::1             localhost \n";
          $txtRecord .= "\n";
          $txtRecord .= "\n";
          $txtRecord .= "#--Below Host Name were added ------\n";
          $txtRecord .= "\n";
          fwrite($myHostfile, $txtRecord);


          $txtRecord = "# For SCADA System\n";
          fwrite($myHostfile, $txtRecord);

          $host_info_results = $db->tb_scada_host_info()->where("sections = '# For SCADA System' and status = 1")->order("host_name ASC");
          foreach ($host_info_results as $host_info_result) {

            $txtRecord = $host_info_result['ip']."\t".$host_info_result['host_name']."\t".$host_info_result['comments']."\n";
            fwrite($myHostfile, $txtRecord);
          }


          $txtRecord = "\n";
          $txtRecord .= "# For WLMS PGIM each Branch\n";
          fwrite($myHostfile, $txtRecord);

          $host_info_results = $db->tb_scada_host_info()->where("sections = '# For WLMS PGIM each Branch' and status = 1")->order("host_name ASC");
          foreach ($host_info_results as $host_info_result) {

            $txtRecord = $host_info_result['ip']."\t".$host_info_result['host_name']."\t".$host_info_result['comments']."\n";
            fwrite($myHostfile, $txtRecord);
          }


          $txtRecord = "\n";
          $txtRecord .= "# For RTU\n";
          fwrite($myHostfile, $txtRecord);

          $host_info_results = $db->tb_scada_host_info()->where("sections = '# For RTU' and status = 1")->order("host_name ASC");
          foreach ($host_info_results as $host_info_result) {

            $txtRecord = $host_info_result['ip']."\t".$host_info_result['host_name']."\t".$host_info_result['comments']."\n";
            fwrite($myHostfile, $txtRecord);


               $reports[] = array(
                  "dm" => $host_info_result["host_name"],
                  "ip" => $host_info_result["ip"]
                );
          }

          fclose($myHostfile);

         /* ************************* */
         /* เริ่มกระบวนการส่งค่ากลับ */
         /* ************************* */
         $resultText = "success";

         $reportResult = array("result" =>  $resultText,
                                   "rows" => $reports);

         $app->response()->header("Content-Type", "application/json");
         echo json_encode($reportResult);

         // $return_m = array("msg" => "Hello, Current PHP version: ". phpversion());
         // echo json_encode($return_m);

    }



?>