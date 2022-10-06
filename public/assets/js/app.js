var app = angular.module('Leadcliq',[], function($interpolateProvider) {
    //change template tags for angular so we can use with blade
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});