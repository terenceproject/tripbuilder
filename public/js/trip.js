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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/trip.js":
/*!******************************!*\
  !*** ./resources/js/trip.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $("#departDatepicker").datepicker({
    minDate: 'today',
    maxDate: "+365D"
  });
  $("#returnDatepicker").datepicker({
    minDate: 'today',
    maxDate: "+365D"
  });
  $("#returnDatepickerSection").hide();
  $("input:radio[name=tripRoute]").change(function () {
    if ($(this).val() === 'oneway') {
      $("#returnDatepickerSection").hide();
      $("#returnDatepickerSection").val('');
    } else {
      $("#returnDatepickerSection").show();
    }
  });
  $('#departSelect').change(function () {
    $('#arrivalSelect').val('');
    $.each($('#arrivalSelect option'), function () {
      $(this).removeAttr('disabled');
    });
    var depart = $(this).val();

    if (depart) {
      $.each($('#arrivalSelect option'), function () {
        if ($(this).val() === depart) {
          $(this).attr('disabled', 'disabled');
        }
      });
    }
  }); // this can be converted from database on PHP side
  // here convert it by a js function

  function countryCodeToName(country_code) {
    switch (country_code) {
      case 'CA':
        return 'Canada';

      default:
        'Canada';
    }
  }

  $.ajax({
    url: '/airports',
    success: function success(data) {
      $.each(data.airports, function (k, airport) {
        var country = countryCodeToName(airport.country_code);
        var option = "".concat(airport.city, ", ").concat(airport.region_code, ", ").concat(country, " - ").concat(airport.name);
        $('#departSelect').append('<option value=' + airport.code + '>' + option + '</option>');
        $('#arrivalSelect').append('<option value=' + airport.code + '>' + option + '</option>');
      });
    }
  });
  $('#submit').click(function () {
    $('#errorMessage').html('');
    var tripRoute = $('input[name="tripRoute"]:checked').val();
    var depart = $('#departSelect').val();
    var arrival = $('#arrivalSelect').val();
    var departDate = $('#departDatepicker').val();
    var returnDate = $('#returnDatepicker').val();

    if (!depart) {
      $('#errorMessage').html('<div style="color: red">Please select departure location</div>');
    } else if (!arrival) {
      $('#errorMessage').html('<div style="color: red">Please select arrival location</div>');
    } else if (!departDate) {
      $('#errorMessage').html('<div style="color: red">Please select departure date</div>');
    } else if (tripRoute === 'roundtrip' && !returnDate) {
      $('#errorMessage').html('<div style="color: red">Please select return date</div>');
    } else {
      $('#errorMessage').html('');
      $.ajax({
        url: '/trip',
        method: 'POST',
        data: {
          'isRoundTrip': tripRoute === 'roundtrip' ? 1 : 0,
          'depart': depart,
          'arrival': arrival,
          'departDate': departDate,
          'returnDate': returnDate
        },
        success: function success(data) {
          $('#result').html('');
          $.each(data.tripResult, function (k, trips) {
            $.each(trips, function (i, t) {
              $('#result').append('<div>' + t.info + ' Total price: $' + t.price + '</div><hr>');
            });
          });
        }
      });
    }
  });
});

/***/ }),

/***/ 1:
/*!************************************!*\
  !*** multi ./resources/js/trip.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/terence/Heroku/tripbuilder/resources/js/trip.js */"./resources/js/trip.js");


/***/ })

/******/ });