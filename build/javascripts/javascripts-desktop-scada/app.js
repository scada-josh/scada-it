var myApp = angular.module('myApp', []);


/* JavaScripts Train-001 Partial */
myApp.controller('MyController', ['$scope','$http', function($scope, $http){
//myApp.controller('MyController', function($scope, $http) {

	// สร้าง Property ชื่อว่า name
	$scope.name = "Josh";
	$scope.list = [1, 2, 3, 4, 5];
	

	
    $scope.searchText = "";
    // $scope.filter = "$";

    // $scope.getFilter = function(arg) {
    //     switch (arg) {
    //         case 'new':
    //             return {cardApproved: '', userName: $scope.searchText};
    //         case 'approved':
    //             return {cardApproved: '1', userName: $scope.searchText};
    //         default:
    //             return {userName: $scope.searchText}
    //     }
    // }

    $http.post("../../api/AdminAPI/updateInsertAllRtuManager/").success(function(response) {
    	$scope.dataSetListCard = response;
    	//console.log(response);
    	$.metroLoadingKill();
    });



	$scope.sayHi = function() {
		alert("Josh");
	}

	$scope.Popup = function(user) {
		alert(user.message);

		$scope.name = user.message;
	}

	// $scope.cardInfoFilter = function(arg) {

	// 	$scope.searchText = arg;

	// 	// switch (arg) {
	// 	// 	case 'new': 
	// 	// 		return {cardApproved: ''};
	// 	// 	case 'approved': 
	// 	// 		return {cardApproved: '1'};
	// 	// 	case 'all': 	
	// 	// 		return {$: ''}
	// 	// }

	// }

}]);
