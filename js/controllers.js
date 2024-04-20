/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


nikosApp.controller('mainController', ['$scope', 'nService', '$filter', '$location', '$http', '$window', function ($scope, nService, $filter, $location, $http, $window) {

    var today = new Date();

    $scope.year = today.getFullYear();

    $scope.curIndex = '';
    $scope.curPage = '';

    // Styles for LANG buttons
    $scope.langStateUA = false;
    $scope.langStateRU = true;


    $scope.tmp = {};
    $scope.URRL = '';
    $scope.test = {};
    $scope.menu = {};
    $scope.submenu = {};
    $scope.status = '';
    $scope.picture = {};
    $scope.langPage = '';
    $scope.visibleH = 0;  //Height of visible part of browser's window
    $scope.mTOP = 0;      //Margin from top for ROW class ?

    $scope.setLANG = function () {

        $scope.langStateUA = !$scope.langStateUA; //Enough only one LANG switcher

        nService.setLangSwitcher($scope.langStateUA); //Store var via service

        if ($scope.langStateUA) {
            $scope.langButtonUA = "btn-default disabled";
            $scope.langButtonRU = "btn-link ";
        } else {
            $scope.langButtonUA = "btn-link ";
            $scope.langButtonRU = "btn-default disabled";
        }
        ;

        //Store vaules in inner storage. When do update page by F5 it is very useful
        sessionStorage['buttonUA'] = $scope.langButtonUA;
        sessionStorage['buttonRU'] = $scope.langButtonRU;
    };

    // Initial setting Language buttons and variables
    if (sessionStorage.getItem('buttonUA') !== null) {
        $scope.langButtonUA = sessionStorage.getItem('buttonUA');
        $scope.langButtonRU = sessionStorage.getItem('buttonRU');
    } else {
        $scope.setLANG();
    }
    ;

    // Styles for sidebar menu items
    $scope.subLi = ['', 'disabled'];            //Switcher for menu item. 0 - active, 1 - disabled
    $scope.subHref = ['nav', 'nav lead caption']; //Class
    $scope.subStyle = ['', 'padding-left:7px;'];  //Style

    $scope.Dropmenu = [{
        text: ['ПП Іванов', 'ЧП Иванов'],
        url: '#/',
        item: 'menu',
        class: ''
    },
        {
            text: ['Пам\'ятники', 'Памятники'],
            url: '#/memorials',
            item: 'sub',
            class: ''
        },
        {
            text: ['Нанесення зображень', 'Нанесение изображений'],
            url: '#/graver',
            item: 'sub',
            class: ''
        },
        {
            text: ['Додаткові послуги', 'Дополнительные услуги'],
            url: '#/services',
            item: 'sub',
            class: ''
        },
        {
            text: '',
            url: '',
            item: 'sub',
            class: 'divider'
        },
        {
            text: ['Вимоги до фотографій', 'Требования к фотографиям'],
            url: '#/photoreq',
            item: 'sub',
            class: ''
        },
        {
            text: '',
            url: '',
            item: 'sub',
            class: 'divider'
        },
        {
            text: ['Галерея', 'Галерея'],
            url: '#/gallery',
            item: 'menu',
            class: ''
        },
        {
            text: ['Контакти', 'Контакты'],
            url: '#/contacts',
            item: 'menu',
            class: ''
        },
        // This element must be on the latest position in array
        {
            text: ['Послуги', 'Услуги'],
            item: 'none'
        }
    ];

    // Main menu section

    // Set link to brand name for non-main pages & and some other functions
    $scope.brandhref = function () {

        $scope.setURL();
        $scope.curIndex = nService.getPageIndex(); //Need for set link to page disabled for self
        $scope.checkSubItem($scope.curIndex);

        return nService.updateBrand();  //Set link
    };

    // Dropdown menu section

    // Need for set proper class. If we're on the page that equal to $scope.URRL - link to that page disabled
    $scope.checkClass = function (url) {
        if ($scope.URRL === url) return true;
        return false;
    };


    //Set class vars if page is changed
    $scope.setClass = function (url) {
        $scope.status = url;
        $scope.URRL = url;
    };

    // Set
    $scope.setURL = function () {

        $scope.URRL = $scope.getURL();

    };

    $scope.getURL = function () {

        var index = '';
        var url = '#' + $location.url();
        if (url === '#') {
            url = '#/';
        }
        ;

        index = nService.filterURL($scope.Dropmenu, 'url', url);
        if (index === -1) {

            return url;

        } else {
            return $scope.Dropmenu[index].url;
        }
        ;
    };

    $scope.Init = function () {

        $scope.setURL();

        $http.get('data/lang.json').success(function (data) {

            $scope.langData = data;

        });
        //

    };


    //Determine show or hide 'carousel' on start page
    $scope.Switch = function () {
        return nService.getCarousel();

    };

    $scope.sideMenu = function () {
        return nService.getMenu();
    };

    $scope.setSubMenu = function (i) {
        $scope.curIndex = i;
        nService.setPageIndex(i);
    };

    //Set active subitem in sidebar menu is highlihted in own way
    $scope.checkSubItem = function (i) {
        if (i === '') return 0;
        if ($scope.sideMenu()[i].index === $scope.curIndex) {
            return 1;
        } else {
            return 0;
        }
        ;
    };


    // lIndex - variable setting current language {0 - UA, 1 - RU}
    // page - variable to determine current page the language is set for
    $scope.getLangPage = function (link) {
        var url = 'data/lang';
        if (link === '/') {
            link = '';
        } else {
            url = url + '_';
        }
        ;
        return url + link.slice(1) + '.json';

    };

    // Set language file for specified controller for each page displaying by ng-view
    $scope.setLangFile = function () {

        var url = $scope.getLangPage($scope.getURL().slice(1));

        if ($location.url() === '/') {
            url = 'data/lang_main.json';
        }
        ;//Main page has different URL syntax than other

        $http.get(url).success(function (data) {

            $scope.langCtrlData = data;
        });

    };


    $scope.checkLang = function () {
        //Set selection index for array in lang file. 0 - UA, 1 - RU
        if (!nService.getLangSwitcher()) return 1;
        return 0;
    };

    $scope.slideText = function (val) {

        var tmps = JSON.parse(sessionStorage.getItem('carouselData'))[val];
        return tmps[$scope.checkLang()];

    };

    nService.setBrand('#dsbl');


    $scope.menu = $filter('filter')($scope.Dropmenu, {item: 'menu'});
    $scope.submenu = $filter('filter')($scope.Dropmenu, {item: 'sub'});


    /*     var attrib=document.getElementById("myCarousel").attributes;

         for (i=0; i<attrib.length; i++){
             alert("Carousel attr: "+attrib[i].name +" value:"+attrib[i].value);
         };*/
    $scope.tta = function () {
//                var h=328;
        var hh = nService.getViewportSize()[1];

//            alert("Carousel Height: "+document.getElementById("myCarousel").offsetHeight);
        return (hh - 628) / 2;
        //alert("Vert size= "+nService.getViewportSize()[1]);

    };
}]);

nikosApp.controller('memorialsController', ['nService', '$location', '$window', function (nService, $location, $window) {

    var index = '';
    var url = $location.url();
    var sidebar = [
        {
            name: ['Види пямятників', 'Виды пямятников'],
            link: '#/memorials',
            index: 0
        },
        {
            name: ['Особливості', 'Особенности'],
            link: '#/features',
            index: 1
        },
        {
            name: ['Встановлення', 'Установка'],
            link: '#/setting',
            index: 2
        },
        {
            name: ['Додаткові елементи', 'Дополнительные элементы'],
            link: '#/addings',
            index: 3
        },
        {
            name: ['Оплата', 'Оплата'],
            link: '#/payments',
            index: 4
        }
    ];

    nService.setBrand('#/');


    index = nService.filterURL(sidebar, 'link', '#' + url);

    if (index === -1) {
        index = 0;
    }
    ;
    nService.setPageIndex(sidebar[index].index);
    nService.setMenu(sidebar);
}]);

nikosApp.controller('graverCtrl', ['nService', '$location', '$window', function (nService, $location, $window) {

    var index = '';
    var url = $location.url();

    var sidebar = [
        {
            name: ['Види гравіровок', 'Виды гравировок'],
            link: '#/graver',
            index: 0
        },
        {
            name: ['Вимоги до фотографій', 'Требования к фотографиям'],
            link: '#/photoreq',
            index: 1
        },
        {
            name: ['Послуги', 'Услуги'],
            link: '#/graver_add',
            index: 2
        }
    ];

    nService.setBrand('#/');


    index = nService.filterURL(sidebar, 'link', '#' + url);

    if (index === -1) {
        index = 0;
    }
    ;

    nService.setPageIndex(sidebar[index].index);
    nService.setMenu(sidebar);

}]);


nikosApp.controller('servicesCtrl', ['nService', '$location', function (nService, $location) {

    var index = '';
    var url = $location.url();
    var sidebar = [
        {
            name: ['Загальна інформація', 'Общая информация'],
            link: '#/services',
            index: 0
        }
        /*       {
                   name:['Вироби з бетону','Бетонные изделия'],
                   link:'#/sconcrete',
                   index:1
               },
               {
                   name:['Фотокераміка','Фотокерамика'],
                   link:'#/sphoto',
                   index:2
               },
               {
                   name:['Плоттерна різка','Плоттерная порезка'],
                   link:'#/splotter',
                   index:3
               } */
    ];

    nService.setBrand('#/'); // This set the url for brand part of sidebar. If we on main page it is disable.
    // if not - we set '#' for url

    index = nService.filterURL(sidebar, 'link', '#' + url);

    if (index === -1) {
        index = 0;
    }
    ;
    nService.setPageIndex(sidebar[index].index);
    nService.setMenu(sidebar);
}]);

nikosApp.controller('galleryCtrl', ['nService', '$location', '$scope', '$http', 'mainInfo', function (nService, $location, $scope, $http, mainInfo) {

    mainInfo.getDataAsync(function (results) {
        //  console.log('fruitsController async returned value');
        $scope.allimages = results;
        // nService.setImageObject(results.pam);


        var index = '';
        var imW = 0;      // Width of image (result value to display)
        var imH = 0;      // Height of image (result value to display)
        var pageItems = 20; // Amount of pictures on every page
        var startPage = 0;    // Value of starting page of Gallery
        var endPage = 0;      // Value of ending page
        var pLinks = [];      // Array of links of page numbers

        $scope.images = {};

        var immP = 0;     //Determine if number of items divide by pageItems without rest {0} or with rest {1}


        $scope.imgWidth = 0;
        $scope.imgHeight = 0;

        $scope.picture = {};
        $scope.pgColor = '';

        var url = $location.url();

        var sidebar = [
            {
                name: ['Пам\'ятники', 'Памятники'],
                link: '#/gallery',
                index: 0
            },
            // {
            //     name:['Бетонні вироби','Бетонные изделия'],
            //     link:'#/gconcrete',
            //     index:1
            // },
            {
                name: ['Фотокераміка', 'Фотокерамика'],
                link: '#/gphoto',
                index: 2
            }
        ];


        $scope.getViewportSize = function (doc) {
            doc = doc || document;
            var elem = doc.compatMode === 'CSS1Compat' ? doc.documentElement : doc.body;
            return [elem.clientWidth, elem.clientHeight];
        };

        $scope.getKeysCount = function (obj) {

            var counter = 0;
            for (var key in obj) {
                //    alert(key);
                counter++;
            }
            return counter;
        };

        $scope.setOBJ = function (obj) {
            $scope.images = obj;
        };

        $scope.setActiveColor = function (num) {
            //			alert("Gpage = "+num);
            if (num == nService.getGalleryPage()) {
                return "color:gray;pointer-events: none;cursor:default;";
            }
            ;

            return "";

        };

        $scope.fillIMG = function (num) {

            nService.setGalleryPage(num);

            $scope.setActiveColor(num);

            if (url === '/gconcrete') {
                $scope.images = $scope.allimages.con.slice(((num - 1) * pageItems), (num * pageItems));
                return;
            }
            ;

            if (url === '/gphoto') {
                $scope.images = $scope.allimages.fok.slice(((num - 1) * pageItems), (num * pageItems));
                return;
            }
            ;

            $scope.images = $scope.allimages.pam.slice(((num - 1) * pageItems), (num * pageItems));
        };


        // Return id of modal window
        $scope.getModalID = function () {
            if (url === '/gallery') {
                return '#gallery'
            }
            ;
            if (url === '/gconcrete') {
                return '#gconcrete'
            }
            ;
            if (url === '/gphoto') {
                return '#gphoto'
            }
            ;
        };

        //Clear data on modal window on close event
        $scope.clearPicture = function () {
            $($scope.getModalID()).on('hidden.bs.modal', function () {
                $scope.picture.imageURL = '';
            });
        };

        $scope.ttt = function () {

            return $scope.picture.imageURL;
        };

        $scope.setPicture = function (item) {

            //Clear data on modal window on close event
            // This need beacause if not - modal window show (on 1-2 sec.) previous picture
            $($scope.getModalID()).on('show.bs.modal', function () {
                $scope.picture.imageURL = '';
                //alert("A:= "+$scope.ttt());
            });

            $scope.picture = item;

            $scope.imgWidth = 0;
            $scope.imgHeight = 0;

            //$scope.picture.imageURL='';

            imW = $scope.getViewportSize()[0];
            imH = $scope.getViewportSize()[1];


            //alert(item.imageURL + "\n"+
            //      item.width + "\n" +
            //      item.height);

            if (item.width > (imW + 41)) {
                $scope.imgWidth = imW;
                $scope.imgHeight = ($scope.imgWidth * item.height) / item.width;
            } else {
                $scope.imgWidth = item.width;
            }
            ;

            // If height of visible area of window is smaller than pictures' height
            // 172 - is amount of pixiles that needed for caption and description
            if (item.height > (imH - 172)) {
                $scope.imgHeight = imH - 172;
                $scope.imgWidth = (item.width * $scope.imgHeight) / item.height;

            } else {
                $scope.imgHeight = item.height;
            }
            ;

            if ($scope.imgWidth < 350) {
                $scope.imgWidth = 350;
            }
            ;

            $scope.imgHeight = "height: " + $scope.imgHeight + "px;";
            //="width:"+imW+"px;";
            $scope.imgWidth = "width:" + ($scope.imgWidth + 41) + "px;";

            //  alert("Size: "+ $scope.imgWidth + " x " + $scope.imgHeight);
        };

        nService.setBrand('#/');

        index = nService.filterURL(sidebar, 'link', '#' + url);

        if (index === -1) {
            index = 0;
        }
        ; // if index=0 first link in side menu is highlihgted.
          // in some cases this don't need to do
          // -1 retruned if page has not link in sidebar menu (e.g. main subpage)
        nService.setPageIndex(sidebar[index].index);
        nService.setMenu(sidebar);


        if (nService.getGalleryPage() === 0) {
            nService.setGalleryPage(1);
        }
        ;

        startPage = nService.getGalleryPage();
        //  alert("Gallery Page="+$scope.allimages.length%pageItems);
        //     alert("Total objects="+$scope.getKeysCount($scope.allimages));

        $scope.setPlinks = function () {
            var arr = [];
            var len = $scope.allimages.pam.length;
            if ($scope.allimages.pam.length % pageItems > 0) {
                immP = 1;
            }
            ;

            if (url === '/gconcrete') {
                len = $scope.allimages.con.length;
                if ($scope.allimages.con.length % pageItems > 0) {
                    immP = 1;
                }
                ;
            }
            ;

            if (url === '/gphoto') {
                len = $scope.allimages.fok.length;
                if ($scope.allimages.fok.length % pageItems > 0) {
                    immP = 1;
                }
                ;
            }
            ;

            for (i = 1; i <= (len / pageItems + immP); i++) {
                arr.push(i);
                //alert("i="+i);
            }
            ;
            return arr;
        };


        //
        // alert("STP: "+startPage);
        // alert("pLinks="+pLinks.length);
        $scope.fillIMG(startPage);

        //    $scope.al=function(a) {
        //         alert("A "+a);
        //    };

    });
}]); // END of galleryCtrl

nikosApp.controller('contactsCtrl', ['nService', '$location', '$scope', '$window', function (nService, $location, $scope, $window) {
    $scope.curmap = {};
    var sidebar = [
        {
            name: ['Контактні дані', 'Контактные данные'],
            link: '#/contacts',
            index: 0
        }
    ];

    $scope.maps = [
        {
            caption: 'Центральный офис',
            imageURL: 'images/map1_RU.jpg',
            description: 'Объехать базар и спуститься по улице вниз, в переулок',
            width: 'width: 750px;'
        },
        {
            caption: 'Производственная база',
            imageURL: 'images/map2_RU.jpg',
            description: 'Нас очень легко найти',
            width: 'width: 750px;'
        },
        {
            caption: 'Центральный офіс',
            imageURL: 'images/map1_UA.jpg',
            description: 'Об\'їхати базар i спуститись донизу в провулок',
            width: 'width: 750px;'
        },
        {
            caption: 'Виробнича база',
            imageURL: 'images/map2_UA.jpg',
            description: 'Нас дуже легко знайти',
            width: 'width: 750px;'
        }
    ];


    $scope.setMap = function (item) {
        var mapp = {};

        if (!nService.getLangSwitcher()) {
            mapp = [$scope.maps[0], $scope.maps[1]];  //RU lang
        } else {
            mapp = [$scope.maps[2], $scope.maps[3]]; // UA lang
        }
        ;
        $scope.curmap = mapp[item];
    };

    nService.setBrand('#/');

    nService.setPageIndex(sidebar[0].index);
    nService.setMenu(sidebar);
}]);

   