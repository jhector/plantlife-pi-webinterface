plantlife = {
  initChartist: function(){
    var dataMoisture = {
      labels: ['9:00AM', '12:00AM', '3:00PM', '6:00PM', '9:00PM', '12:00PM', '3:00AM', '6:00AM'],
      series: [
         [944, 846, 788, 752, 695, 586, 554, 492, 490, 385, 287],
      ]
    };

    var optionsMoisture = {
      lineSmooth: false,
      low: 0,
      high: 1000,
      showArea: false,
      height: "245px",
      axisX: {
        showGrid: false,
      },
      showLine: true,
      showPoint: true,
    };

    var responsiveMoisture = [
      ['screen and (max-width: 640px)', {
        axisX: {
          labelInterpolationFnc: function (value) {
            return value[0];
          }
        }
      }]
    ];

    Chartist.Line('#moisturedata', dataMoisture, optionsMoisture, responsiveMoisture);
  },

  initDatepicker: function() {
    $('.datepicker-container input').datepicker({
      todayHighlight: true,
      format: "yyyy-mm-dd"
    });
  }
}