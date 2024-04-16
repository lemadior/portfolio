/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 

    var nikosApp = angular.module('nikosApp', ['ngRoute']);
     
   
     
    nikosApp.config(['$routeProvider','$locationProvider',function($routeProvider,$locationProvider) {
  //          $locationProvider.html5Mode(true).hashPrefix('!');
            $routeProvider
                .when('/', {
                    templateUrl: 'partials/main.html',
                    controller: 'mainController'
                })
                .when('/memorials', {
                    templateUrl: 'partials/memorials.html',
                    controller: 'memorialsController'
                })
                .when('/features', {
                    templateUrl: 'partials/features.html',
                    controller: 'memorialsController'
                })
                .when('/setting', {
                    templateUrl: 'partials/setting.html',
                    controller: 'memorialsController'
                })
                .when('/addings', {
                    templateUrl: 'partials/addings.html',
                    controller: 'memorialsController'
                })
                .when('/payments', {
                    templateUrl: 'partials/payments.html',
                    controller: 'memorialsController'
                })
                .when('/graver', {
                    templateUrl: 'partials/graver.html',
                    controller: 'graverCtrl'
                })
                .when('/photoreq', {
                    templateUrl: 'partials/photoreq.html',
                    controller: 'graverCtrl'
                })
                .when('/graver_add', {
                    templateUrl: 'partials/graver_add.html',
                    controller: 'graverCtrl'
                })
                .when('/services', {
                    templateUrl: 'partials/services.html',
                    controller: 'servicesCtrl'
                })
                .when('/sconcrete', {
                    templateUrl: 'partials/sconcrete.html',
                    controller: 'servicesCtrl'
                })
                .when('/sphoto', {
                    templateUrl: 'partials/sphoto.html',
                    controller: 'servicesCtrl'
                })
                .when('/splotter', {
                    templateUrl: 'partials/splotter.html',
                    controller: 'servicesCtrl'
                })
                .when('/gallery', {
                    templateUrl: 'partials/gallery.html ',
                    controller: 'galleryCtrl'
                })
                .when('/gconcrete', {
                    templateUrl: 'partials/gconcrete.html ',
                    controller: 'galleryCtrl'
                })
                .when('/gphoto', {
                    templateUrl: 'partials/gphoto.html ',
                    controller: 'galleryCtrl'
                })
                .when('/contacts', {
                    templateUrl: 'partials/contacts.html',
                    controller: 'contactsCtrl'
                })
                .when('/dsbl', {
                    templateUrl: 'partials/nonexistentURL.html'
                })
                .when('/modal', {
                     templateUrl: 'partials/gallery.html ',
                     controller: 'galleryCtrl'
                })
                .otherwise({
                    redirectTo: '/'
                });
           
        }]);
    
    
   
    
