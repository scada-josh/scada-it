<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SCADA Administrator</title>
    
    <link href="../../../stylesheets/stylesheets-desktop-scada.css" rel="stylesheet" type="text/css" />
    <!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"> -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="../../../helper/metro-notifications/static/css/MetroNotificationStyle.min.css" rel="stylesheet" type="text/css" />

</head>

<body id="page-top" ng-app="myApp">

        <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">SCADA Administrator</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">หน้าหลัก</a>
                    </li>
                   <!--  <li>
                        <a href="#">เพิ่มข้อมูล</a>
                    </li> -->
                </ul>
                <!-- <button type="button" class="btn btn-default navbar-btn navbar-right" id="btnApproved">Approved</button> -->
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container" ng-controller="MyController">

        <div class="row">

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4" >

                <!-- Form Search Partial -->
                                <div class="well">
                    <h4>ค้นหาข้อมูล</h4>
                    <div class="input-group">
                        <input type="text" class="form-control" ng-model = "searchText">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    <!-- /.input-group -->

                    <hr/>

                  <!--   <div class="row">
                      <div class="col-lg-4">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input type="radio" aria-label="..." name="optionsRadios"  ng-click="getFilter('new')">
                            New
                          </span>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input type="radio" aria-label="..." name="optionsRadios" ng-click="getFilter('approved')">
                            Approved
                          </span>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input type="radio" aria-label="..." name="optionsRadios" ng-click="getFilter('')" checked>
                            All
                          </span>
                        </div>
                      </div>
                    </div> -->

                    
                </div>

                <!-- List Card Partial -->
                <p class="lead">Search Result</p>
<h6>ผลการค้นหาเจอทั้งหมด {{results.length}} รายการ</h6>

<div class="list-group" id="listCards">
	<!-- <a href="#" class="list-group-item active" ng-repeat="cardInfo in dataSetListCard">
		<h4 class="list-group-item-heading">{{cardInfo.userID}}</h4><span class="badge">Approved</span>
		<p class="list-group-item-text">นางสาวกานต์สินี ปิติวีรารัตน์</p>
		<p class="list-group-item-text">สายงานผู้ว่าการฯ</p>
        </a> -->

        <a href="#" class="list-group-item" ng-repeat="cardInfo in dataSetListCard.rows | filter : searchText as results">
                <h4 class="list-group-item-heading text-primary" >{{cardInfo.meterCode}}</h4>
                <!-- <span class="badge">{{cardInfo.cardApproved ? 'Approved' : 'New'}}</span> -->
                <!-- <p class="list-group-item-text"><small><abbr title="ลำดับที่">No.</abbr> {{cardInfo.userOrder}}</small></p> -->

                <!-- <p class="list-group-item-text">{{cardInfo.userLoggerCode}}</p>
                <p class="list-group-item-text">{{cardInfo.userIpAddress}}</p>
                <p class="list-group-item-text">{{cardInfo.scadaLoggerCode}}</p>
                <p class="list-group-item-text">{{cardInfo.scadaIpAddress}}</p>
                <p class="list-group-item-text">{{cardInfo.wlmaLoggerCode}}</p>
                <p class="list-group-item-text">{{cardInfo.wlmaIpAddress}}</p> -->
                <ul class="list-group">
                        <li class="list-group-item list-group-item-success">
                                <span class="badge">{{cardInfo.userRtuStatus ? 'Active' : 'Active'}}</span>
                                <!-- <p class="list-group-item-text">ฝทส.</p> -->
                                <small class="list-group-item-text">{{cardInfo.userLoggerCode}} - {{cardInfo.userIpAddress}}</small>
                        </li>
                        <li class="list-group-item list-group-item-info">
                                <span class="badge">{{(cardInfo.userRtuStatus == 1) ? 'Onscan' : cardInfo.userRtuStatus}}</span>
                                <!-- <p class="list-group-item-text">SCADA</p> -->
                                <small class="list-group-item-text">{{cardInfo.scadaLoggerCode}} - {{cardInfo.scadaIpAddress}}</small>
                        </li>
                        <li class="list-group-item list-group-item-warning">
                                <span class="badge">{{cardInfo.userRtuStatus ? 'Active' : 'Active'}}</span>
                                <!-- <p class="list-group-item-text">WLMA</p> -->
                                <small class="list-group-item-text">{{cardInfo.wlmaLoggerCode}} - {{cardInfo.wlmaIpAddress}}</small>
                        </li>
                </ul>
        </a>
</div>

<hr/>
<p class="text-center">Copyright &copy; SCADA-IT MWA 2015</p>

            </div>


            <!-- Blog Post Content Column -->
            <div class="col-lg-8">

                <!-- List Card Partial -->
                
                <!-- Blog Post -->

                <!-- Title -->
                <h1>SCADA-RTU Manager</h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="#">กองพัฒนาระบบงานผลิตและวิศวกรรม (กพว. ฝพท.)</a>
                </p>

                <hr>

                <!-- Preview Image -->
                <!-- <img class="img-responsive lazy"  src="../../../images/cardManager/source_images/card-original.png" id="imgCardShow" alt="" width="1063" height="650"> -->

                <hr>




            </div>


        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->



    <script src="../../../javascripts/javascripts-desktop-scada.js" type="text/javascript"></script>
    <script src="../../../helper/metro-notifications/static/js/MetroNotification.min.js" type="text/javascript"></script>

</body>

</html>
