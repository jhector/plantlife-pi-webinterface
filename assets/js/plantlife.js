function getData(type, start, end) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: "index.php",
      type: "get", // use GET request
      data: {
        site: 'data',
        type: type,
        start: start,
        end: end
      }, success: function (response) {
        response['dates'].forEach(function(part, index, arr) {
          arr[index] = /....-..-.. (..:..):../g.exec(part)[1];
        });

        resolve(response);
      }
    });
  });
}

function updateChart(response) {
  chartist = document.querySelector("#"+response['type']+"chart").__chartist__;
  chartist.update({labels: response['dates'], series: [response['values']]});
}

plantlife = {
  initChartist: function(){
    var dataMoisture = {
      labels: [],
      series: [[],]
    };

    var optionsMoisture = {
      lineSmooth: false,
      low: 0,
      high: 1000,
      showArea: true,
      axisX: {
        showGrid: false,
	labelInterpolationFnc: function(value, index) {
	  return index % 6 === 0 ? value : null;
	}
      },
      showLine: true,
      showPoint: false,
    };

    Chartist.Line('#moisturechart', dataMoisture, optionsMoisture);

    var dataLight = dataMoisture;
    var optionsLight = optionsMoisture;
    optionsLight.showArea = false;

    Chartist.Line('#lightchart', dataLight, optionsLight);

    var dataTemperature = dataMoisture;
    var optionsTemperature = optionsMoisture;
    optionsTemperature.showArea = false;
    optionsTemperature.low = -30;
    optionsTemperature.high = 60;

    Chartist.Line('#temperaturechart', dataTemperature, optionsTemperature);

    var dataHumidity = dataMoisture;
    var optionsHumidity = optionsMoisture;
    optionsHumidity.showArea = true;
    optionsHumidity.low = 0;
    optionsHumidity.high = 100;

    Chartist.Line('#humiditychart', dataHumidity, optionsHumidity);

    now = new Date();
    month = now.getMonth() + 1; // January is 0
    dateString = now.getFullYear() + "-" + month + "-" + now.getDate();

    getData('moisture', dateString, dateString).then(updateChart);
  },

  initDatepicker: function() {
    $('.datepicker-container input').datepicker({
      todayHighlight: true,
      format: "yyyy-mm-dd",
      autoclose: true,
    });

    $('.datepicker-container input').datepicker("setDate", new Date());

    $('.datepicker-container input').datepicker().on("input change", function (e) {
      type = /(.*)-start/g.exec(e.target.id)[1];
      value = e.target.value;

      getData(type, value, value).then(updateChart);
    });
  }
}
