/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


nikosApp.factory('mainInfo', function($http) {
  return {
    getDataAsync: function(callback) {
      $http.get('data/gallery.json').success(callback);
    }
  };
});

// Services need to do communication between controllers.
// This mechanism allow to share data (variables).

 nikosApp.service('nService', function ($window,$http) {

    //----------------------------------------------------------------------
    // 'text' data object - can easily add additional elements
    //----------------------------------------------------------------------

    var text = '';
    var carousel=false;
    var sidebar={}; 
    var pIndex='';
    var langUA=false;
    var curPage=0;      // Current page of gallery
    //var startPage=0;    // Start page of gallery
    //var lastPage=0;     //End page of gallery
    var imgs={};
      
    return {
        
        getJSON: function() { 

                 var obj = {};

                 $http.get('data/gallery.json').success(function(data) {
                     // you can do some processing here
                    obj = data;
                      alert(obj.pam[0].imageURL);
             });    

                 return obj;    
        },
        
        setImageObject: function(elem) {
          imgs=elem;  
        },
        
        getImageObject: function() {
          return imgs;  
        },
        
        getViewportSize: function(doc) {
	    doc = doc || document;
	    var elem  = doc.compatMode === 'CSS1Compat' ? doc.documentElement : doc.body;
	    return [elem.clientWidth, elem.clientHeight];
        },

        setGalleryPage: function(num) {
        	 sessionStorage.setItem('galleryPage',JSON.stringify(num));  
        },

        getGalleryPage: function() {
           if (sessionStorage.getItem('galleryPage') !== null) {
                return JSON.parse(sessionStorage.getItem('galleryPage')); //This done cause sessionStorage can store only string value
            };
            
            return 0;
        },

        setBrand: function (v) {
            text = v;
            if (v === '#dsbl') {carousel=true;
            }else{
               carousel=false; 
            };
        },
         getCarousel: function() {
	    return carousel;
	},
         setMenu: function (mm) {
             sidebar = mm;
         },
         getMenu: function () {
            return sidebar;
         },
         setPageIndex: function(i) {
             pIndex=i;
         },
         getPageIndex: function() {
            return pIndex;
         },
        // set status for BRAND part of navbar
         updateBrand: function () {
            return text;
        },
        // obj - object aka [{key:"value"},{key:"value"},...{key:"value"}]
        // k - key, s - search value
	// return index of object
	filterURL: function(obj,k,s) {
	  var ind=-1;
	  angular.forEach(obj,function(obj,filterIndex) {
	    angular.forEach(obj,function(value,key) {
		if (key === k) {
		 if (value === s) { ind=filterIndex; };
		};		
	     });
	  });
          return ind; //This needed cause to return can't do inside forEach construction!
	},

        setLangSwitcher: function(ua) {
            langUA=ua;

            //This done cause sessionStorage can store only string value
            sessionStorage.setItem('langUA',JSON.stringify(ua));
        },
        getLangSwitcher: function() {

            if (sessionStorage.getItem('langUA') !== null) {
                return JSON.parse(sessionStorage.getItem('langUA')); //This done cause sessionStorage can store only string value
            };
      
            return langUA; //Need for first site start - lang vars is not setted yet. It's do after first click on lang buttons.
        }/*,
        setPict: function(val) {
            var img=new Image();
            
            img.src=val;

            return img.width;
        }*/
        
    };
});