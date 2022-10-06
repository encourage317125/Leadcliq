app.controller('TerritoriesCtrlNew', function($scope, $http, Territory)
{
    $scope.allTerritories = []
    $scope.searchTerritory = "";
    $scope.possibleMatchTerritories = []
    $scope.newTerritory = {};
    $scope.searchingForTerritory = false;
    $scope.addingTerritory = false;
    $scope.deletingTerritory = false;


    // loading variable to show the spinning loading icon
    $scope.loading = true;


    /**
     * Retrieve all existing territories ===
     *
     * This data can alternatively be bootstrapped on page load
     */
    ($scope.getUserTerritory = function() {
        Territory.get()
            .success(function(data) {
                $scope.allTerritories = data;
                $scope.loading = false;
            });
    })(); //init on load

    /**
     * Submits the territory to our server and reloads them
     */
    $scope.submitUserTerritory = function() {
        $scope.loading = true;

        // save the user territory. pass in territory data from the form
        // use the function we created in our service
        Territory.save($scope.newTerritory)
            .success(function(data) {
                $scope.getUserTerritory();
                $scope.addingTerritory = false;
                $scope.searchingForTerritory = false;
                $scope.clearPossibleMatches();

            })
            .error(function(data) {
                console.log(data); //todo: replace this with better error handler!!
                alert('Unable to add territory!');
                $scope.addingTerritory = false;
                $scope.searchingForTerritory = false;
                $scope.clearPossibleMatches();

            });
    };

    /**
     * Deletes the territory off our server and reloads them
     * @param territory
     */
    $scope.deleteUserTerritory = function(territory) {
        $scope.loading = true;

        // use the function we created in our service
        Territory.destroy(territory.id)
            .success(function(data) {
                $scope.getUserTerritory();
            });
    };

    /**
     * Readies a territory for submission to api
     * Add to newTerritory variable to setup for sumiission
     * Retrieves geodata for the territory
     * Calls function to submit territory to our api
     * @param territory
     */
    $scope.addTerritory = function(territory){

        $scope.addingTerritory = true;

        $scope.newTerritory = territory;

        $scope.submitUserTerritory();
    }

    $scope.clearPossibleMatches = function() {
        $scope.possibleMatchTerritories = [];
    }

    /**
     * checks a territory and sees if it's the one being added
     * (used for showing loading indiciation)
     * @param territory
     * @returns {boolean}
     */
    $scope.thisTerritoryBeingAdded = function(territory) {
        return $scope.addingTerritory && $scope.newTerritory && $scope.newTerritory.name===territory.name
    }

    /**
     * Searches for a "territory" aka an area with an associated polygon based on the user supplied string
     * Anticipates return of multiple matching territories or just one
     */
    $scope.searchForTerritory = function() {
        $scope.possibleMatchTerritories = [];
        $scope.searchingForTerritory = true;
        $.get('/city/find/'+$scope.searchTerritory,function(result){

            //if only one result found add the territory
            if (result.length===1){
                $scope.addTerritory(result[0]);
            }

            //if multiple results found create list of possible match territories and display to user
            else{
                $scope.$apply(function(){//all callbacks that use scope need to be wrapped in this!!
                    var item;
                    for (var $i = 0 ; item = result[$i] ; $i++)
                        $scope.possibleMatchTerritories.push(item);
                    $scope.searchingForTerritory = false;
                });
            }
        });
    }

});