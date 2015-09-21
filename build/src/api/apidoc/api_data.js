define({ "api": [
  {
    "name": "AddNewRtuInfoManager",
    "group": "Admin",
    "version": "0.1.0",
    "type": "post",
    "url": "/AdminAPI/addNewRtuInfoManager/",
    "title": "AddNewRtuInfoManager",
    "description": "<p>คำอธิบาย : ในส่วนนี้ใช้สำหรับข้อมูลใหม่เข้าไปในระบบทั้งใน tb_scada_host_info, tb_scada_station_df, tb_main01_user_rtu_info, tb_main02_scada_rtu_info</p> ",
    "filename": "./index.php",
    "groupTitle": "Admin",
    "sampleRequest": [
      {
        "url": "http://localhost/scada-it/build/src/api/AdminAPI/addNewRtuInfoManager/"
      }
    ]
  },
  {
    "name": "CompareWithExistingRtuManager",
    "group": "Admin",
    "version": "0.1.0",
    "type": "post",
    "url": "/AdminAPI/compareWithExistingRtuManager/",
    "title": "CompareWithExistingRtuManager",
    "description": "<p>คำอธิบาย : ในส่วนนี้ใช้สำหรับตรวจสอบและเปรียบเทียบรายละเอียด RTU (เช่น IP Address, ชือ DM) ที่มีอยู่แล้วกับรายการ RTU ที่กำลังจะดำเนินการเพิ่มเข้าไป</p> ",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "listRTU",
            "description": "<p>รายการ RTU ที่ต้องการเพิ่มเข้าไปใหม่ในระบบ SCADA FastTools</p> "
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "listRTU.branch_code",
            "description": "<p>รหัสสาขา</p> "
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "listRTU.zone_code",
            "description": "<p>รหัสโซน</p> "
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "listRTU.dma_code",
            "description": "<p>รหัส DMA</p> "
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "listRTU.meter_code",
            "description": "<p>รหัส DM หรือ meter_code นั่นเอง</p> "
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "listRTU.ip",
            "description": "<p>IP Address</p> "
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "listRTU.logger_code",
            "description": "<p>รหัสตัวแทนอุปกรณ์ภาคสนาม</p> "
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "listRTU.rtu_status",
            "description": "<p>สถานะ RTU (1 : OnScan, 0 : OffScan, blank : อาจจะเป็นกรณีการเชื่อมต่อผ่านทาง OPCDA ซึ่ง OnScan เป็นกลุ่มไม่ได้แยกแต่ละ DM)</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example (ตัวอย่าง Payload, Content-Type: application/json):",
          "content": "{\n    \"listRTU\": [\n        {\n            \"branch_code\": \"\",\n            \"zone_code\": \"\",\n            \"dma_code\": \"\",\n            \"meter_code\": \"DM-13-01-02-01\",\n            \"ip\": \"10.50.133.145\",\n            \"logger_code\": \"SIXNET\",\n            \"rtu_status\": \"1\"\n        },\n        {\n            \"branch_code\": \"\",\n            \"zone_code\": \"\",\n            \"dma_code\": \"\",\n            \"meter_code\": \"DM-13-01-03-04\",\n            \"ip\": \"10.202.71.63\",\n            \"logger_code\": \"SIXNET\",\n            \"rtu_status\": \"1\"\n        },\n        {\n            \"branch_code\": \"\",\n            \"zone_code\": \"\",\n            \"dma_code\": \"\",\n            \"meter_code\": \"DM-54-08-12-01\",\n            \"ip\": \"10.50.131.92\",\n            \"logger_code\": \"X20\",\n            \"rtu_status\": \"1\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "sampleRequest": [
      {
        "url": "http://localhost/scada-it/build/src/api/AdminAPI/compareWithExistingRtuManager/"
      }
    ],
    "success": {
      "fields": {
        "คำอธิบายผลลัพธ์ (กรณีส่งค่ากลับสำเร็จ Success 200)": [
          {
            "group": "คำอธิบายผลลัพธ์ (กรณีส่งค่ากลับสำเร็จ Success 200)",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>แสดงข้อความทักทายผู้ใช้งาน</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Example data on success:",
          "content": "{\n    \"result\": \"success\",\n    \"rows\": [\n        {\n            \"filename\": \"Quickload_for_MODBUS(PGIM_WTDC)_2015-08-15_1439607474.xls\",\n            \"path\": \"http://localhost/scada-it/build/files/Quickload_for_MODBUS(PGIM_WTDC)_2015-08-15_1439607474.xls\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "คำอธิบายผลลัพธ์ (กรณีเกิด Error 4xx)": [
          {
            "group": "คำอธิบายผลลัพธ์ (กรณีเกิด Error 4xx)",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"UserNotFound\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./index.php",
    "groupTitle": "Admin"
  },
  {
    "name": "UpdateCommentHostFileManager",
    "group": "Admin",
    "version": "0.1.0",
    "type": "post",
    "url": "/AdminAPI/updateCommentHostFileManager/",
    "title": "Update Comment in Host file",
    "description": "<p>คำอธิบาย : ในส่วนนี้ใช้สำหรับอัพเดต Comment ในฐานข้อมูลที่เก็บ Host file (ตาราง &quot;tb_scada_host_info&quot;)</p> ",
    "sampleRequest": [
      {
        "url": "http://localhost/scada-it/build/src/api/AdminAPI/updateCommentHostFileManager/"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>แสดงข้อความทักทายผู้ใช้งาน</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Example data on success:",
          "content": "{\n  \"msg\": \"Hello, anusorn\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"UserNotFound\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./index.php",
    "groupTitle": "Admin"
  },
  {
    "name": "UpdateInsertAllRtuManager",
    "group": "Admin",
    "version": "0.1.0",
    "type": "post",
    "url": "/AdminAPI/updateInsertAllRtuManager/",
    "title": "Update/Insert All RTU",
    "description": "<p>คำอธิบาย : ในส่วนนี้ใช้สำหรับรวบรวมข้อมูล RTU ทั้งหมด จากทั้งผู้ใช้งาน, scada และ wlma</p> ",
    "sampleRequest": [
      {
        "url": "http://localhost/scada-it/build/src/api/AdminAPI/updateInsertAllRtuManager/"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>แสดงข้อความทักทายผู้ใช้งาน</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Example data on success:",
          "content": "{\n  \"msg\": \"Hello, anusorn\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"UserNotFound\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./index.php",
    "groupTitle": "Admin"
  },
  {
    "name": "UpdateOnOffScanScadaInfoManager",
    "group": "Admin",
    "version": "0.1.0",
    "type": "post",
    "url": "/AdminAPI/updateOnOffScanScadaInfoManager/",
    "title": "Update ON_SCAN",
    "description": "<p>คำอธิบาย : ในส่วนนี้ใช้สำหรับอัพเดต ค่า ON_SCAN ใน STATION_DF</p> ",
    "sampleRequest": [
      {
        "url": "http://localhost/scada-it/build/src/api/AdminAPI/updateOnOffScanScadaInfoManager/"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>แสดงข้อความทักทายผู้ใช้งาน</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Example data on success:",
          "content": "{\n  \"msg\": \"Hello, anusorn\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"UserNotFound\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./index.php",
    "groupTitle": "Admin"
  },
  {
    "name": "UpdateScadaInfoIpFromHostManager",
    "group": "Admin",
    "version": "0.1.0",
    "type": "post",
    "url": "/AdminAPI/updateScadaInfoIpFromHostManager/",
    "title": "Update SCADA Info from Host",
    "description": "<p>คำอธิบาย : ในส่วนนี้ใช้สำหรับอัพเดตข้อมูล IP Address ใน SCADA โดยอ้างอิงจากฐานข้อมูลที่เก็บ Host file (ตาราง &quot;tb_scada_host_info&quot;)</p> ",
    "sampleRequest": [
      {
        "url": "http://localhost/scada-it/build/src/api/AdminAPI/updateScadaInfoIpFromHostManager/"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>แสดงข้อความทักทายผู้ใช้งาน</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Example data on success:",
          "content": "{\n  \"msg\": \"Hello, anusorn\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"UserNotFound\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./index.php",
    "groupTitle": "Admin"
  },
  {
    "name": "IEC60870_Manager",
    "group": "Fast_Tools",
    "version": "0.1.0",
    "type": "post",
    "url": "/FastToolsAPI/IEC60870_Manager/",
    "title": "IEC60870_Manager",
    "description": "<p>คำอธิบาย : ในส่วนนี้ใช้สำหรับสร้าง FAST/TOOLS Quickload สำหรับโปรโตคอล IEC60870-5-104</p> ",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "rtu_install",
            "defaultValue": "SERVICE",
            "description": "<p>คำอธิบายกลุ่มของอุปกรณ์ เช่น SERVICE, PRODUCTION, OTHER</p> "
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "fasttools_destination",
            "defaultValue": "ABB CTU800",
            "description": "<p>คำอธิบายชนิดของอุปกรณ์ เช่น ABB CTU800</p> "
          },
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "listDM",
            "description": "<p>รายการ DM</p> "
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "listDM.name",
            "defaultValue": "DM-01-01-01-01",
            "description": "<p>ชื่อ DM</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example (ตัวอย่าง Payload, Content-Type: application/json):",
          "content": "{\n    \"rtu_install\": \"SERVICE\",\n    \"fasttools_destination\": \"ABB CTU800\",\n    \"listDM\": [\n        {\n            \"name\": \"DM-01-01-01-01\"\n        },\n        {\n            \"name\": \"DM-01-01-01-02\"\n        },\n        {\n            \"name\": \"DM-01-01-01-03\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "sampleRequest": [
      {
        "url": "http://localhost/scada-it/build/src/api/FastToolsAPI/IEC60870_Manager/"
      }
    ],
    "success": {
      "fields": {
        "คำอธิบายผลลัพธ์ (กรณีส่งค่ากลับสำเร็จ Success 200)": [
          {
            "group": "คำอธิบายผลลัพธ์ (กรณีส่งค่ากลับสำเร็จ Success 200)",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>แสดงข้อความทักทายผู้ใช้งาน</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Example data on success:",
          "content": "{\n    \"result\": \"success\",\n    \"rows\": [\n        {\n            \"filename\": \"Quickload_for_IEC60870(PGIM_WTDC)_2015-08-15_1439607474.xls\",\n            \"path\": \"http://localhost/scada-it/build/files/Quickload_for_IEC60870(PGIM_WTDC)_2015-08-15_1439607474.xls\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "คำอธิบายผลลัพธ์ (กรณีเกิด Error 4xx)": [
          {
            "group": "คำอธิบายผลลัพธ์ (กรณีเกิด Error 4xx)",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"UserNotFound\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./index.php",
    "groupTitle": "Fast_Tools"
  },
  {
    "name": "MODBUS_Manager",
    "group": "Fast_Tools",
    "version": "0.1.0",
    "type": "post",
    "url": "/FastToolsAPI/MODBUS_Manager/",
    "title": "MODBUS_Manager",
    "description": "<p>คำอธิบาย : ในส่วนนี้ใช้สำหรับสร้าง FAST/TOOLS Quickload สำหรับโปรโตคอล MODBUS</p> ",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "rtu_install",
            "defaultValue": "SERVICE",
            "description": "<p>คำอธิบายกลุ่มของอุปกรณ์ เช่น SERVICE, PRODUCTION, OTHER</p> "
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "fasttools_destination",
            "defaultValue": "MOXA",
            "description": "<p>คำอธิบายชนิดของอุปกรณ์ เช่น MOXA, B&amp;R X20, ABB AC500, YOKOGAWA FCJ, WAGO, SIXNET</p> "
          },
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "listDM",
            "description": "<p>รายการ DM</p> "
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "listDM.name",
            "defaultValue": "DM-01-01-01-01",
            "description": "<p>ชื่อ DM</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example (ตัวอย่าง Payload, Content-Type: application/json):",
          "content": "{\n    \"rtu_install\": \"SERVICE\",\n    \"fasttools_destination\": \"MOXA\",\n    \"listDM\": [\n        {\n            \"name\": \"DM-01-01-01-01\"\n        },\n        {\n            \"name\": \"DM-01-01-01-02\"\n        },\n        {\n            \"name\": \"DM-01-01-01-03\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "sampleRequest": [
      {
        "url": "http://localhost/scada-it/build/src/api/FastToolsAPI/MODBUS_Manager/"
      }
    ],
    "success": {
      "fields": {
        "คำอธิบายผลลัพธ์ (กรณีส่งค่ากลับสำเร็จ Success 200)": [
          {
            "group": "คำอธิบายผลลัพธ์ (กรณีส่งค่ากลับสำเร็จ Success 200)",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>แสดงข้อความทักทายผู้ใช้งาน</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Example data on success:",
          "content": "{\n    \"result\": \"success\",\n    \"rows\": [\n        {\n            \"filename\": \"Quickload_for_MODBUS(PGIM_WTDC)_2015-08-15_1439607474.xls\",\n            \"path\": \"http://localhost/scada-it/build/files/Quickload_for_MODBUS(PGIM_WTDC)_2015-08-15_1439607474.xls\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "คำอธิบายผลลัพธ์ (กรณีเกิด Error 4xx)": [
          {
            "group": "คำอธิบายผลลัพธ์ (กรณีเกิด Error 4xx)",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"UserNotFound\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./index.php",
    "groupTitle": "Fast_Tools"
  },
  {
    "name": "OPCDAC_Manager",
    "group": "Fast_Tools",
    "version": "0.1.0",
    "type": "post",
    "url": "/FastToolsAPI/OPCDAC_Manager/",
    "title": "OPCDAC_Manager",
    "description": "<p>คำอธิบาย : ในส่วนนี้ใช้สำหรับสร้าง FAST/TOOLS Quickload สำหรับโปรโตคอล OPCDAC</p> ",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "rtu_install",
            "defaultValue": "SERVICE",
            "description": "<p>คำอธิบายกลุ่มของอุปกรณ์ เช่น SERVICE, PRODUCTION, OTHER</p> "
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "fasttools_destination",
            "defaultValue": "DCXII",
            "description": "<p>คำอธิบายชนิดของอุปกรณ์ เช่น <br/> <b style='color:red'>PGIM_BRANCH</b> หมายถึงการเชื่อมต่อระหว่าง Fast/Tools กับ PGIM ที่สาขาผ่านทาง DCOM, <br/> <b style='color:red'>DCXII</b> หมายถึงการเชื่อมต่อระหว่าง Fast/Tools กับ DCXII ผ่านทางโปรแกรม KEPWareEx , <br/> <b style='color:red'>PGIM_WTDC</b> หมายถึงการเชื่อมต่อระหว่าง Fast/Tools กับ PGIM ที่ ฝคจ. ผ่านทางโปรแกรม Matrikon Tunneller</p> "
          },
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "listDM",
            "description": "<p>รายการ DM</p> "
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "listDM.name",
            "defaultValue": "DM-01-01-01-01",
            "description": "<p>ชื่อ DM</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example (ตัวอย่าง Payload, Content-Type: application/json):",
          "content": "{\n    \"rtu_install\": \"SERVICE\",\n    \"fasttools_destination\": \"PGIM_BRANCH\",\n    \"listDM\": [\n        {\n            \"name\": \"DM-04-03-01-01\"\n        },\n        {\n            \"name\": \"DM-17-03-04-02\"\n        },\n        {\n            \"name\": \"DM-17-07-02-01\"\n        },\n        {\n            \"name\": \"DM-13-07-07-01\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "sampleRequest": [
      {
        "url": "http://localhost/scada-it/build/src/api/FastToolsAPI/OPCDAC_Manager/"
      }
    ],
    "success": {
      "fields": {
        "คำอธิบายผลลัพธ์ (กรณีส่งค่ากลับสำเร็จ Success 200)": [
          {
            "group": "คำอธิบายผลลัพธ์ (กรณีส่งค่ากลับสำเร็จ Success 200)",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>แสดงข้อความทักทายผู้ใช้งาน</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Example data on success:",
          "content": "{\n    \"result\": \"success\",\n    \"rows\": [\n        {\n            \"filename\": \"Quickload_for_OPCDAC(PGIM_WTDC)_2015-08-15_1439607474.xls\",\n            \"path\": \"http://localhost/scada-it/build/files/Quickload_for_OPCDAC(PGIM_WTDC)_2015-08-15_1439607474.xls\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "คำอธิบายผลลัพธ์ (กรณีเกิด Error 4xx)": [
          {
            "group": "คำอธิบายผลลัพธ์ (กรณีเกิด Error 4xx)",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"UserNotFound\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./index.php",
    "groupTitle": "Fast_Tools"
  },
  {
    "name": "HelloWorld",
    "group": "TEST_SERVICE",
    "version": "0.1.0",
    "type": "get",
    "url": "/hello/:name",
    "title": "Test GET Service (v 0.1.0)",
    "description": "<p>คำอธิบาย : Hello World, Test Service</p> <p>localhost : <a href=\"http://localhost/iFire-Reporter-API/src/hello/:name\">http://localhost/iFire-Reporter-API/src/hello/:name</a></p> <p>remote host : <a href=\"http://128.199.166.211/iFire-Reporter-API/src/hello/:name\">http://128.199.166.211/iFire-Reporter-API/src/hello/:name</a></p> ",
    "examples": [
      {
        "title": "Example usage:",
        "content": "\"Using Advanced REST Client\" : (localhost)   chrome-extension://hgmloofddffdnphfgcellkdfbfbjeloo/RestClient.html#RequestPlace:projectEndpoint/31\n\"Using Advanced REST Client\" : (remote host) chrome-extension://hgmloofddffdnphfgcellkdfbfbjeloo/RestClient.html#RequestPlace:projectEndpoint/30",
        "type": "json"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>New name of the user</p> "
          }
        ]
      }
    },
    "sampleRequest": [
      {
        "url": "http://localhost/scada-it/build/src/api/hello/:name"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>แสดงข้อความทักทายผู้ใช้งาน</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Example data on success:",
          "content": "{\n  \"msg\": \"Hello, anusorn\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"UserNotFound\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./index.php",
    "groupTitle": "TEST_SERVICE"
  },
  {
    "name": "HelloWorld_POST",
    "group": "TEST_SERVICE",
    "version": "0.1.0",
    "type": "post",
    "url": "/hello/",
    "title": "Test POST Service (v 0.1.0)",
    "description": "<p>คำอธิบาย : Hello World, Test Post Service</p> ",
    "sampleRequest": [
      {
        "url": "http://localhost/scada-it/build/src/api/hello/"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>แสดงข้อความทักทายผู้ใช้งาน</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Example data on success:",
          "content": "{\n  \"msg\": \"Hello, Current PHP version: 5.6.8\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UserNotFound",
            "description": "<p>The <code>id</code> of the User was not found.</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\": \"UserNotFound\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "./index.php",
    "groupTitle": "TEST_SERVICE"
  },
  {
    "sampleRequest": [
      {
        "url": "http://localhost/scada-it/build/src/api, iOS RESTKit use content-type is \"application/json\"\nWeb Form, Advance REST Client App use content-type is \"application/x-www-form-urlencoded\""
      }
    ],
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "./index.php",
    "group": "_Applications_XAMPP_xamppfiles_htdocs_scada_it_build_src_api_index_php",
    "groupTitle": "_Applications_XAMPP_xamppfiles_htdocs_scada_it_build_src_api_index_php",
    "name": ""
  },
  {
    "sampleRequest": [
      {
        "url": "http://localhost/scada-it/build/src/api, iOS RESTKit use content-type is \"application/json\"\nWeb Form, Advance REST Client App use content-type is \"application/x-www-form-urlencoded\""
      }
    ],
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "./index.php",
    "group": "_Applications_XAMPP_xamppfiles_htdocs_scada_it_build_src_api_index_php",
    "groupTitle": "_Applications_XAMPP_xamppfiles_htdocs_scada_it_build_src_api_index_php",
    "name": ""
  },
  {
    "sampleRequest": [
      {
        "url": "http://localhost/scada-it/build/src/api, iOS RESTKit use content-type is \"application/json\"\nWeb Form, Advance REST Client App use content-type is \"application/x-www-form-urlencoded\""
      }
    ],
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "./index.php",
    "group": "_Applications_XAMPP_xamppfiles_htdocs_scada_it_build_src_api_index_php",
    "groupTitle": "_Applications_XAMPP_xamppfiles_htdocs_scada_it_build_src_api_index_php",
    "name": ""
  },
  {
    "sampleRequest": [
      {
        "url": "http://localhost/scada-it/build/src/api, iOS RESTKit use content-type is \"application/json\"\nWeb Form, Advance REST Client App use content-type is \"application/x-www-form-urlencoded\""
      }
    ],
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "./index.php",
    "group": "_Applications_XAMPP_xamppfiles_htdocs_scada_it_build_src_api_index_php",
    "groupTitle": "_Applications_XAMPP_xamppfiles_htdocs_scada_it_build_src_api_index_php",
    "name": ""
  },
  {
    "sampleRequest": [
      {
        "url": "http://localhost/scada-it/build/src/api, iOS RESTKit use content-type is \"application/json\"\nWeb Form, Advance REST Client App use content-type is \"application/x-www-form-urlencoded\""
      }
    ],
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "./index.php",
    "group": "_Applications_XAMPP_xamppfiles_htdocs_scada_it_build_src_api_index_php",
    "groupTitle": "_Applications_XAMPP_xamppfiles_htdocs_scada_it_build_src_api_index_php",
    "name": ""
  }
] });