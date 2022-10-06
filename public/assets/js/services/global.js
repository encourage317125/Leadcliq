
//todo: we should figure out a way to make this into a universal LeadCliqAPI!
app.factory('Territory', function($http) {

    return {
        // get all the user territories (for the logged in user)
        get : function() {
            return $http.get('/api/user-territories');
        },

        // save a user territory
        save : function(territoryData) {
            return $http({
                method: 'POST',
                url: '/api/user-territories',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param(territoryData)
            });
        },

        // destroy a user territory
        destroy : function(id) {
            return $http.delete('/api/user-territories/' + id);
        }
    }
});