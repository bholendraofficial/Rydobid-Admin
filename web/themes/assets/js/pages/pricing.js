!function(r){var t={};function a(e){if(t[e])return t[e].exports;var n=t[e]={i:e,l:!1,exports:{}};return r[e].call(n.exports,n,n.exports,a),n.l=!0,n.exports}a.m=r,a.c=t,a.d=function(e,n,r){a.o(e,n)||Object.defineProperty(e,n,{enumerable:!0,get:r})},a.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},a.t=function(n,e){if(1&e&&(n=a(n)),8&e)return n;if(4&e&&"object"==typeof n&&n&&n.__esModule)return n;var r=Object.create(null);if(a.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:n}),2&e&&"string"!=typeof n)for(var t in n)a.d(r,t,function(e){return n[e]}.bind(null,t));return r},a.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return a.d(n,"a",n),n},a.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)},a.p="",a(a.s=15)}({"./app/assets/es6/pages/pricing.js":function(module,exports){eval("class PagesPricing {\r\n\r\n    static init() {\r\n\r\n        $('#monthly-btn').on('click', (e) => {\r\n            $('#monthly-view').removeClass('d-none');\r\n            $('#annual-view').addClass('d-none')\r\n            $(e.currentTarget).addClass('active');\r\n            $('#annual-btn').removeClass('active');\r\n        })\r\n\r\n        $('#annual-btn').on('click', (e) => {\r\n            $('#annual-view').removeClass('d-none');\r\n            $('#monthly-view').addClass('d-none');\r\n            $(e.currentTarget).addClass('active');\r\n            $('#list-view-btn').removeClass('active');\r\n        })\r\n    }\r\n}\r\n\r\n$(() => { PagesPricing.init(); });\r\n\r\n\n\n//# sourceURL=webpack:///./app/assets/es6/pages/pricing.js?")},15:function(module,exports,__webpack_require__){eval('module.exports = __webpack_require__(/*! C:\\wamp64\\www\\RYDOBID.COM\\starter\\app\\assets\\es6\\pages\\pricing.js */"./app/assets/es6/pages/pricing.js");\n\n\n//# sourceURL=webpack:///multi_./app/assets/es6/pages/pricing.js?')}});