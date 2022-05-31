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
/******/ 	return __webpack_require__(__webpack_require__.s = 27);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/metronic/js/pages/crud/datatables/basic/basic.js":
/*!********************************************************************!*\
  !*** ./resources/metronic/js/pages/crud/datatables/basic/basic.js ***!
  \********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

    "use strict";


    var KTDatatablesBasicBasic = function () {
        var tableSuratMasuk = function tableSuratMasuk() {
            $('#datatable-surat-masuk thead tr').clone(true).appendTo('#datatable-surat-masuk thead');
            $('#datatable-surat-masuk thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                if(title == "No") {
                  $(this).html('#' );
                } else if(title == "Aksi") {
                  $(this).html(`<button class="btn btn-danger btn-sm"><i class="la la-close"></i></button><button class="btn btn-success btn-sm ml-3"><i class="la la-search"></i> Cari</button>`);
                } else {
                  if(title == "Tgl Surat" || title == "Tgl Terima") {
                    $(this).html(`<input type="date" class="form-control input-datatable" placeholder="Cari '+title+'" />`);
                  } else if(title == "Tipe Penerima") {
                    $(this).html(`<select class="form-control form-control-sm form-filter input-datatable" title="Select" data-col-index="` + i + `"><option value="">Pilih</option><option value="Tembusan">Tembusan</option><option value="Utama">Utama</option></select>`);
                  } else {
                    $(this).html( '<input type="text" class="form-control input-datatable" placeholder="Cari '+title+'" />' );
                  }
                  $('.input-datatable', this ).on('keyup change', function () {
                      if (table.column(i).search() !== this.value ) {
                          table
                              .column(i)
                              .search( this.value )
                              .draw();
                      }
                  });
                }
            });

            var table = $('#datatable-surat-masuk').DataTable({
              orderCellsTop: true,
              fixedHeader: true,
              responsive: true,
              dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
              lengthMenu: [5, 10, 25, 50],
              pageLength: 10,
              info: false,
              language: {
                  'lengthMenu': 'Display _MENU_'
              },
              order: [[1, 'desc']],
              columnDefs: []
            });
        };

        var tableNaskahDinas = function tableNaskahDinas() {
            var table = $('#datatable-naskah-dinas');
        
            table.DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,
            info: false,
            language: {
                'lengthMenu': 'Display _MENU_'
            },
            order: [[1, 'desc']],
            columnDefs: []
            });
        };

    
      return {
        init: function init() {
            tableSuratMasuk();
            tableNaskahDinas();
        }
      };
    }();
    
    jQuery(document).ready(function () {
      KTDatatablesBasicBasic.init();
    });
    
    /***/ }),
    
    /***/ 27:
    /*!**************************************************************************!*\
      !*** multi ./resources/metronic/js/pages/crud/datatables/basic/basic.js ***!
      \**************************************************************************/
    /*! no static exports found */
    /***/ (function(module, exports, __webpack_require__) {
    
    module.exports = __webpack_require__(/*! D:\Umar\Template\themeforest-C5JfwcUM-metronic-responsive-admin-dashboard-template\metronic_v7.0.3\theme\html_laravel\demo1\skeleton\resources\metronic\js\pages\crud\datatables\basic\basic.js */"./resources/metronic/js/pages/crud/datatables/basic/basic.js");
    
    
    /***/ })
    
    /******/ });