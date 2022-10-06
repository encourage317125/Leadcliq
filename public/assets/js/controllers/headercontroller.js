// HeaderController used in  header.blade.php
app.controller('HeaderController', function($scope, $http){
    // This function is called when user clicks the envelope, default : true
    
    $scope.isEnvelope=true;
    
    $scope.hideEnvelope = function() {
          var response = $http.get("/messages/archive_messages");

        response.success(function(data, status, headers, config) {            
            $scope.isEnvelope=false;
            
        });
    
        response.error(function(data, status, headers, config) {
            alert("Error occured!");
        });
    }
});