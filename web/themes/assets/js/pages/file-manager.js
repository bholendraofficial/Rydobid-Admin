!function(r){var a={};function t(e){if(a[e])return a[e].exports;var n=a[e]={i:e,l:!1,exports:{}};return r[e].call(n.exports,n,n.exports,t),n.l=!0,n.exports}t.m=r,t.c=a,t.d=function(e,n,r){t.o(e,n)||Object.defineProperty(e,n,{enumerable:!0,get:r})},t.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},t.t=function(n,e){if(1&e&&(n=t(n)),8&e)return n;if(4&e&&"object"==typeof n&&n&&n.__esModule)return n;var r=Object.create(null);if(t.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:n}),2&e&&"string"!=typeof n)for(var a in n)t.d(r,a,function(e){return n[e]}.bind(null,a));return r},t.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(n,"a",n),n},t.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)},t.p="",t(t.s=10)}({"./app/assets/es6/pages/file-manager.js":function(module,exports){eval("class FileManager {\r\n\r\n    static init() {\r\n\r\n        const hide = 'd-none'\r\n        const fileItems = '.file-manager-content-files .file';\r\n        const fileDetail = '.file-manager-content-details .content-details';\r\n        const fileContentDetails = '.file-manager-content-details'\r\n        const fileDetailNoData = '.file-manager-content-details .content-details-no-data';\r\n\r\n        function showFileDetails () {\r\n            $(fileDetailNoData).addClass(hide)\r\n            $(fileDetail).removeClass(hide)\r\n        }\r\n\r\n        function hideFileDetails () {\r\n            $(fileDetailNoData).removeClass(hide)\r\n            $(fileDetail).addClass(hide)\r\n        }\r\n\r\n        $(fileItems).on('click', (e) => {\r\n            showFileDetails()\r\n            $(fileItems).removeClass('active')\r\n            $(e.currentTarget).addClass('active')\r\n            $(fileContentDetails).addClass('details-open')\r\n        })\r\n\r\n        $('.unselect-bg').on('click', (e) => {\r\n            hideFileDetails()\r\n            $(fileItems).removeClass('active')\r\n        })\r\n\r\n        $('.content-details-close a').on('click', (e) => {\r\n            $(fileContentDetails).removeClass('details-open')\r\n        })\r\n\r\n        $('#open-manager-menu').on('click', (e) => {\r\n            $('.file-manager-nav').addClass('nav-open')\r\n            $(e.currentTarget).addClass(hide)\r\n            $('#close-manager-menu').removeClass(hide)\r\n        })\r\n\r\n        $('#close-manager-menu').on('click', (e) => {\r\n            $('.file-manager-nav').removeClass('nav-open')\r\n            $(e.currentTarget).addClass(hide)\r\n            $('#open-manager-menu').removeClass(hide)\r\n        })\r\n    }\r\n}\r\n\r\n$(() => { FileManager.init(); });\r\n\r\n\n\n//# sourceURL=webpack:///./app/assets/es6/pages/file-manager.js?")},10:function(module,exports,__webpack_require__){eval('module.exports = __webpack_require__(/*! C:\\wamp64\\www\\RYDOBID.COM\\starter\\app\\assets\\es6\\pages\\file-manager.js */"./app/assets/es6/pages/file-manager.js");\n\n\n//# sourceURL=webpack:///multi_./app/assets/es6/pages/file-manager.js?')}});