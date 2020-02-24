$( function() {
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $( "#departDatepicker" ).datepicker({minDate: 'today', maxDate: "+365D"});                         
  $( "#returnDatepicker" ).datepicker({minDate: 'today', maxDate: "+365D"});

  $( "#returnDatepickerSection" ).hide();

  $("input:radio[name=tripRoute]").change(function () {
    if ($(this).val() === 'oneway') {
      $( "#returnDatepickerSection" ).hide();
      $( "#returnDatepickerSection" ).val('');
    } else {
      $( "#returnDatepickerSection" ).show();
    }
  });

  $('#departSelect').change(function () {
    $('#arrivalSelect').val('');
    $.each($('#arrivalSelect option'), function () {
      $(this).removeAttr('disabled');
    });
    let depart = $(this).val();
    if (depart) {
      $.each($('#arrivalSelect option'), function () {
        if ($(this).val() === depart) {
          $(this).attr('disabled', 'disabled');
        }
      });
    }
  });

  // this can be converted from database on PHP side
  // here convert it by a js function
  function countryCodeToName(country_code) {
    switch (country_code) {
      case 'CA':
        return 'Canada';
      default: 'Canada'
    }
  }

  $.ajax({
    url: '/airports',
    success: function (data) {
      $.each(data.airports, function (k, airport) {
        let country = countryCodeToName(airport.country_code);
        let option = `${airport.city}, ${airport.region_code}, ${country} - ${airport.name}`;
        $('#departSelect').append('<option value=' + airport.code + '>' + option + '</option>');
        $('#arrivalSelect').append('<option value=' + airport.code + '>' + option + '</option>');
      });
    }
  });

  $('#submit').click(function () {
    $('#errorMessage').html('');
    let tripRoute = $('input[name="tripRoute"]:checked').val();
    let depart = $('#departSelect').val();
    let arrival = $('#arrivalSelect').val();
    let departDate = $('#departDatepicker').val();
    let returnDate = $('#returnDatepicker').val();

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
          'isRoundTrip': tripRoute === 'roundtrip' ? true : false,
          'depart': depart,
          'arrival': arrival,
          'departDate': departDate,
          'returnDate': returnDate
        },
        success: function (data) {
          $('#result').html('');
          $.each(data.tripResult, function (k, trip) {
            $('#result').append('<div>' + trip + '</div>');
          });
        }
      });
    }
  });

});