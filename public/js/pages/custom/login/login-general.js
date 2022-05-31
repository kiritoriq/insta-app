/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 105);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/metronic/js/pages/custom/login/login-general.js":
/*!*******************************************************************!*\
  !*** ./resources/metronic/js/pages/custom/login/login-general.js ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
 // Class Definition

var KTLogin = function () {
  var _login;
  var base_url = $(location).attr('pathname');
  base_url.indexOf(1);
  base_url.toLowerCase();
  base_url = (window.location.origin === "http://103.9.227.61/" ? "" : base_url.split("/")[0]);
  var site_url = window.location.origin + "/" + base_url;

  var _reloadCaptcha = function _reloadCaptcha() {
      var captcha = $("#captchaCode");
      $.ajax({
        type: "GET",
        url: site_url + 'reload-captcha',
      }).done(function( msg ) {
        console.log(msg);
        captcha.attr('src', msg);
      });
  };

  var _handleSignInForm = function _handleSignInForm() {
    var validation;

    validation = FormValidation.formValidation(KTUtil.getById('kt_login_signin_form'), {
      fields: {
        username: {
          validators: {
            notEmpty: {
              message: 'Username cannot be empty'
            }
          }
        },
        password: {
          validators: {
            notEmpty: {
              message: 'Password cannot be empty'
            }
          }
        },
        captcha: {
          validators: {
            notEmpty: {
              message: 'Captcha cannot be empty'
            }
          }
        },
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap: new FormValidation.plugins.Bootstrap()
      }
    });

    $('#kt_login_signin_form').on('submit', function (e) {
      e.preventDefault();
      validation.validate().then(function (status) {
        $("#btnLogin").prop("disabled", true);
        if (status == 'Valid') {
          let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          let username = $('#username').val();
          let password = $('#password').val();
          let captcha = $('#captcha').val();
          $("#btnLogin").prop("disabled", true);
          $.ajax({
            url: site_url + 'login/action',
            type: 'POST',
            dataType: "JSON",
            timeout: 10000,
            data: {
                _token: CSRF_TOKEN,
                username: username,
                password: password,
                captcha: captcha
            },
            beforeSend: function () {
                
            },
            success: function (data) {
              if(data.status == "failed") {
                toastr.error("Ops, " + data.msg);
                _reloadCaptcha();
                $("#btnLogin").prop("disabled", false);
              } else {
                Swal.fire({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  icon: 'success',
                  title: 'Yay, ' + data.msg,
                  timer: 1500
                }).then(() => {
                  window.location.href = site_url + 'dashboard';
                })
              }
            }, error: function (x, t, m) {

            }
        });

        } else {
          $("#btnLogin").prop("disabled", false);
          swal.fire({
            title: "Register cannot be complete!",
            text: "Please fill out all the forms.",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Tutup",
            customClass: {
              confirmButton: "btn font-weight-bold btn-light-primary"
            }
          }).then(function () {
            KTUtil.scrollTop();
          });
        }
      });
    });

  };


  return {
    // public functions
    init: function init() {
      _login = $('#kt_login');

      _handleSignInForm();
    }
  };
}(); // Class Initialization


jQuery(document).ready(function () {
  KTLogin.init();
});

/***/ }),

/***/ 105:
/*!*************************************************************************!*\
  !*** multi ./resources/metronic/js/pages/custom/login/login-general.js ***!
  \*************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\Umar\Template\themeforest-C5JfwcUM-metronic-responsive-admin-dashboard-template\metronic_v7.0.3\theme\html_laravel\demo1\skeleton\resources\metronic\js\pages\custom\login\login-general.js */"./resources/metronic/js/pages/custom/login/login-general.js");


/***/ })

/******/ });