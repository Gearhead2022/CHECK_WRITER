function formatNumber(num) {
  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

// CONTAINER Gauge (Circle)
$(function() {
  "use strict";
  var idContainer = 1;
  var data = new FormData();                     
    data.append("idContainer", idContainer);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        var container_gauge = Math.round(answer["total_amount"]/answer["tsales"]*100);
        var total_sales = formatNumber(Math.round(answer["total_amount"]));
        document.getElementById("container_sales").innerHTML = total_sales;
        document.getElementById("container_goal").innerHTML = formatNumber(answer["tsales"]);
        var options = {
            chart: {
                height: 250,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    //startAngle: -135,
                    //endAngle: 135,
                    hollow: {
                      margin: 0,
                      size: '70%',
                      background: 'transparent',
                      image: undefined,
                      imageOffsetX: 0,
                      imageOffsetY: 0,
                      position: 'front',
                      dropShadow: {
                        enabled: true,
                        top: 3,
                        left: 0,
                        blur: 4,
                        opacity: 0.24
                      }
                    },
                    track: {
                      background: 'rgba(255, 255, 255, 0.12)',
                      strokeWidth: '0%',
                      margin: 0, // margin is in pixels
                      dropShadow: {
                        enabled: true,
                        top: -3,
                        left: 0,
                        blur: 4,
                        opacity: 0.35
                      }
                    },
                    dataLabels: {
                        name: {
                            fontSize: '14px',
                            color: '#fff',
                            offsetY: -5
                        },
                        value: {
                            offsetY: 0,
                            fontSize: '20px',
                            color: '#fff',
                            formatter: function (val) {
                                return val + "%";
                            }
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    shadeIntensity: 0.15,
          gradientToColors: ['#fff'],
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 65, 91]
                },
            },
            stroke: {
                dashArray: 4
            },
        colors: ["#fff"],
            series: [container_gauge],
            labels: ['Total'],
            
        }

       var chart = new ApexCharts(
            document.querySelector("#data-chart-24"),
            options
        );
        
        chart.render();
      }
  })  
})

$(function() {
  var idContainerPrevious = 1;
  var data = new FormData();                     
    data.append("idContainerPrevious", idContainerPrevious);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        var total_sales_container_previous = formatNumber(Math.round(answer["total_amount"]));
        document.getElementById("previous_container_sales").innerHTML = total_sales_container_previous;
      }
  })  
})

// STRAW Gauge (Circle)
$(function() {
  "use strict";
  var idStraw = 2;
  var data = new FormData();                     
    data.append("idStraw", idStraw);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        var straw_gauge = Math.round(answer["total_amount"]/answer["tsales"]*100);
        var total_sales = formatNumber(Math.round(answer["total_amount"]));
        document.getElementById("straw_sales").innerHTML = total_sales;
        document.getElementById("straw_goal").innerHTML = formatNumber(answer["tsales"]);
        var options = {
            chart: {
                height: 250,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    //startAngle: -135,
                    //endAngle: 135,
                    hollow: {
                      margin: 0,
                      size: '70%',
                      background: 'transparent',
                      image: undefined,
                      imageOffsetX: 0,
                      imageOffsetY: 0,
                      position: 'front',
                      dropShadow: {
                        enabled: true,
                        top: 3,
                        left: 0,
                        blur: 4,
                        opacity: 0.24
                      }
                    },
                    track: {
                      background: 'rgba(255, 255, 255, 0.12)',
                      strokeWidth: '0%',
                      margin: 0, // margin is in pixels
                      dropShadow: {
                        enabled: true,
                        top: -3,
                        left: 0,
                        blur: 4,
                        opacity: 0.35
                      }
                    },
                    dataLabels: {
                        name: {
                            fontSize: '14px',
                            color: '#fff',
                            offsetY: -10
                        },
                        value: {
                            offsetY: 0,
                            fontSize: '20px',
                            color: '#fff',
                            formatter: function (val) {
                                return val + "%";
                            }
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    shadeIntensity: 0.15,
                    gradientToColors: ['#fff'],
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 65, 91]
                },
            },
            stroke: {
                dashArray: 4
            },
            colors: ["#fff"],
            series: [straw_gauge],
            labels: ['Total'],
            
        }

       var chart = new ApexCharts(
            document.querySelector("#data-chart-25"),
            options
        );
        
        chart.render();
      }
  })  
})

$(function() {
  var idStrawPrevious = 2;
  var data = new FormData();                     
    data.append("idStrawPrevious", idStrawPrevious);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        var total_sales_straw_previous = formatNumber(Math.round(answer["total_amount"]));
        // total_sales_straw_previous = total_sales_straw_previous ? total_sales_straw_previous : 0;
        document.getElementById("previous_straw_sales").innerHTML = total_sales_straw_previous;
      }
  })  
})

// JAR Gauge (Circle)
$(function() {
  "use strict";
  var idJar = 3;
  var data = new FormData();                     
    data.append("idJar", idJar);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        var jar_gauge = Math.round(answer["total_amount"]/answer["tsales"]*100);
        var total_sales = formatNumber(Math.round(answer["total_amount"]));
        document.getElementById("jar_sales").innerHTML = total_sales;
        document.getElementById("jar_goal").innerHTML = formatNumber(answer["tsales"]);
        var options = {
            chart: {
                height: 250,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    //startAngle: -135,
                    //endAngle: 135,
                    hollow: {
                      margin: 0,
                      size: '70%',
                      background: 'transparent',
                      image: undefined,
                      imageOffsetX: 0,
                      imageOffsetY: 0,
                      position: 'front',
                      dropShadow: {
                        enabled: true,
                        top: 3,
                        left: 0,
                        blur: 4,
                        opacity: 0.24
                      }
                    },
                    track: {
                      background: 'rgba(255, 255, 255, 0.12)',
                      strokeWidth: '0%',
                      margin: 0, // margin is in pixels
                      dropShadow: {
                        enabled: true,
                        top: -3,
                        left: 0,
                        blur: 4,
                        opacity: 0.35
                      }
                    },
                    dataLabels: {
                        name: {
                            fontSize: '14px',
                            color: '#fff',
                            offsetY: -10
                        },
                        value: {
                            offsetY: 0,
                            fontSize: '20px',
                            color: '#fff',
                            formatter: function (val) {
                                return val + "%";
                            }
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    shadeIntensity: 0.15,
                    gradientToColors: ['#fff'],
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 65, 91]
                },
            },
            stroke: {
                dashArray: 4
            },
            colors: ["#fff"],
            series: [jar_gauge],
            labels: ['Total'],
            
        }

        var chart = new ApexCharts(
            document.querySelector("#data-chart-26"),
            options
        );
        
        chart.render();
      }
  })  
})

$(function() {
  var idJarPrevious = 3;
  var data = new FormData();                     
    data.append("idJarPrevious", idJarPrevious);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        var total_sales_jar_previous = formatNumber(Math.round(answer["total_amount"]));
        document.getElementById("previous_jar_sales").innerHTML = total_sales_jar_previous;
      }
  })  
})




// WATER CONTAINER Gauge (Circle)
$(function() {
  "use strict";
  var idWater = 4;
  var data = new FormData();                     
    data.append("idWater", idWater);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        var water_gauge = Math.round(answer["total_amount"]/answer["tsales"]*100);
        var total_sales = formatNumber(Math.round(answer["total_amount"]));
        document.getElementById("water_sales").innerHTML = total_sales;
        document.getElementById("water_goal").innerHTML = formatNumber(answer["tsales"]);
        var options = {
            chart: {
                height: 250,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    //startAngle: -135,
                    //endAngle: 135,
                    hollow: {
                      margin: 0,
                      size: '70%',
                      background: 'transparent',
                      image: undefined,
                      imageOffsetX: 0,
                      imageOffsetY: 0,
                      position: 'front',
                      dropShadow: {
                        enabled: true,
                        top: 3,
                        left: 0,
                        blur: 4,
                        opacity: 0.24
                      }
                    },
                    track: {
                      background: 'rgba(255, 255, 255, 0.12)',
                      strokeWidth: '0%',
                      margin: 0, // margin is in pixels
                      dropShadow: {
                        enabled: true,
                        top: -3,
                        left: 0,
                        blur: 4,
                        opacity: 0.35
                      }
                    },
                    dataLabels: {
                        name: {
                            fontSize: '14px',
                            color: '#fff',
                            offsetY: -10
                        },
                        value: {
                            offsetY: 0,
                            fontSize: '20px',
                            color: '#fff',
                            formatter: function (val) {
                                return val + "%";
                            }
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    shadeIntensity: 0.15,
                    gradientToColors: ['#fff'],
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 65, 91]
                },
            },
            stroke: {
                dashArray: 4
            },
            colors: ["#fff"],
            series: [water_gauge],
            labels: ['Total'],
            
        }

        var chart = new ApexCharts(
            document.querySelector("#data-chart-27"),
            options
        );
        
        chart.render(); 
      }
  })  
})

$(function() {
  var idWaterPrevious = 4;
  var data = new FormData();                     
    data.append("idWaterPrevious", idWaterPrevious);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        var total_sales_water_previous = formatNumber(Math.round(answer["total_amount"]));
        document.getElementById("previous_water_sales").innerHTML = total_sales_water_previous;
      }
  })  
})






// PLASTIC Gauge (Circle)
$(function() {
  "use strict";
  var idPlastic = 5;
  var data = new FormData();                     
    data.append("idPlastic", idPlastic);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        var plastic_gauge = Math.round(answer["total_amount"]/answer["tsales"]*100);
        var total_sales = formatNumber(Math.round(answer["total_amount"]));
        document.getElementById("plastic_sales").innerHTML = total_sales;
        document.getElementById("plastic_goal").innerHTML = formatNumber(answer["tsales"]);
        var options = {
            chart: {
                height: 250,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    //startAngle: -135,
                    //endAngle: 135,
                    hollow: {
                      margin: 0,
                      size: '70%',
                      background: 'transparent',
                      image: undefined,
                      imageOffsetX: 0,
                      imageOffsetY: 0,
                      position: 'front',
                      dropShadow: {
                        enabled: true,
                        top: 3,
                        left: 0,
                        blur: 4,
                        opacity: 0.24
                      }
                    },
                    track: {
                      background: 'rgba(255, 255, 255, 0.12)',
                      strokeWidth: '0%',
                      margin: 0, // margin is in pixels
                      dropShadow: {
                        enabled: true,
                        top: -3,
                        left: 0,
                        blur: 4,
                        opacity: 0.35
                      }
                    },
                    dataLabels: {
                        name: {
                            fontSize: '14px',
                            color: '#fff',
                            offsetY: -10
                        },
                        value: {
                            offsetY: 0,
                            fontSize: '20px',
                            color: '#fff',
                            formatter: function (val) {
                                return val + "%";
                            }
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    shadeIntensity: 0.15,
                    gradientToColors: ['#fff'],
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 65, 91]
                },
            },
            stroke: {
                dashArray: 4
            },
            colors: ["#fff"],
            series: [plastic_gauge],
            labels: ['Total'],
            
        }

        var chart = new ApexCharts(
            document.querySelector("#data-chart-28"),
            options
        );
        
        chart.render(); 
      }
  })  
})

$(function() {
  var idPlasticPrevious = 5;
  var data = new FormData();                     
    data.append("idPlasticPrevious", idPlasticPrevious);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        var total_sales_plastic_previous = formatNumber(Math.round(answer["total_amount"]));
        document.getElementById("previous_plastic_sales").innerHTML = total_sales_plastic_previous;
      }
  })  
})





// SANDO BAG Gauge (Circle)
$(function() {
  "use strict";
  var idSandobag = 7;
  var data = new FormData();                     
    data.append("idSandobag", idSandobag);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        var sandobag_gauge = Math.round(answer["total_amount"]/answer["tsales"]*100);
        var total_sales = formatNumber(Math.round(answer["total_amount"]));
        document.getElementById("sandobag_sales").innerHTML = total_sales;
        document.getElementById("sandobag_goal").innerHTML = formatNumber(answer["tsales"]);
        var options = {
            chart: {
                height: 250,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    //startAngle: -135,
                    //endAngle: 135,
                    hollow: {
                      margin: 0,
                      size: '70%',
                      background: 'transparent',
                      image: undefined,
                      imageOffsetX: 0,
                      imageOffsetY: 0,
                      position: 'front',
                      dropShadow: {
                        enabled: true,
                        top: 3,
                        left: 0,
                        blur: 4,
                        opacity: 0.24
                      }
                    },
                    track: {
                      background: 'rgba(255, 255, 255, 0.12)',
                      strokeWidth: '0%',
                      margin: 0, // margin is in pixels
                      dropShadow: {
                        enabled: true,
                        top: -3,
                        left: 0,
                        blur: 4,
                        opacity: 0.35
                      }
                    },
                    dataLabels: {
                        name: {
                            fontSize: '14px',
                            color: '#fff',
                            offsetY: -10
                        },
                        value: {
                            offsetY: 0,
                            fontSize: '20px',
                            color: '#fff',
                            formatter: function (val) {
                                return val + "%";
                            }
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    shadeIntensity: 0.15,
                    gradientToColors: ['#fff'],
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 65, 91]
                },
            },
            stroke: {
                dashArray: 4
            },
            colors: ["#fff"],
            series: [sandobag_gauge],
            labels: ['Total'],
            
        }

        var chart = new ApexCharts(
            document.querySelector("#data-chart-29"),
            options
        );
        
        chart.render(); 
      }
  })  
})

$(function() {
  var idSandobagPrevious = 7;
  var data = new FormData();                     
    data.append("idSandobagPrevious", idSandobagPrevious);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        var total_sales_sandobag_previous = formatNumber(Math.round(answer["total_amount"]));
        document.getElementById("previous_sandobag_sales").innerHTML = total_sales_sandobag_previous;
      }
  })  
})






// PET BOTTLE Gauge (Circle)
$(function() {
  "use strict";
  var idPetbottle = 8;
  var data = new FormData();                     
    data.append("idPetbottle", idPetbottle);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        var petbottle_gauge = Math.round(answer["total_amount"]/answer["tsales"]*100);
        var total_sales = formatNumber(Math.round(answer["total_amount"]));
        document.getElementById("petbottle_sales").innerHTML = total_sales;
        document.getElementById("petbottle_goal").innerHTML = formatNumber(answer["tsales"]);
        var options = {
            chart: {
                height: 250,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    //startAngle: -135,
                    //endAngle: 135,
                    hollow: {
                      margin: 0,
                      size: '70%',
                      background: 'transparent',
                      image: undefined,
                      imageOffsetX: 0,
                      imageOffsetY: 0,
                      position: 'front',
                      dropShadow: {
                        enabled: true,
                        top: 3,
                        left: 0,
                        blur: 4,
                        opacity: 0.24
                      }
                    },
                    track: {
                      background: 'rgba(255, 255, 255, 0.12)',
                      strokeWidth: '0%',
                      margin: 0, // margin is in pixels
                      dropShadow: {
                        enabled: true,
                        top: -3,
                        left: 0,
                        blur: 4,
                        opacity: 0.35
                      }
                    },
                    dataLabels: {
                        name: {
                            fontSize: '14px',
                            color: '#fff',
                            offsetY: -10
                        },
                        value: {
                            offsetY: 0,
                            fontSize: '20px',
                            color: '#fff',
                            formatter: function (val) {
                                return val + "%";
                            }
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    shadeIntensity: 0.15,
                    gradientToColors: ['#fff'],
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 65, 91]
                },
            },
            stroke: {
                dashArray: 4
            },
            colors: ["#fff"],
            series: [petbottle_gauge],
            labels: ['Total'],
            
        }

        var chart = new ApexCharts(
            document.querySelector("#data-chart-30"),
            options
        );
        
        chart.render(); 
      }
  })  
})

$(function() {
  var idPetbottlePrevious = 8;
  var data = new FormData();                     
    data.append("idPetbottlePrevious", idPetbottlePrevious);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        var total_sales_petbottle_previous = formatNumber(Math.round(answer["total_amount"]));
        document.getElementById("previous_petbottle_sales").innerHTML = total_sales_petbottle_previous;
      }
  })  
})








// GALLON Gauge (Circle)
$(function() {
  "use strict";
  var idGallon = 11;
  var data = new FormData();                     
    data.append("idGallon", idGallon);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        var gallon_gauge = Math.round(answer["total_amount"]/answer["tsales"]*100);
        var total_sales = formatNumber(Math.round(answer["total_amount"]));
        document.getElementById("gallon_sales").innerHTML = total_sales;
        document.getElementById("gallon_goal").innerHTML = formatNumber(answer["tsales"]);
        var options = {
            chart: {
                height: 250,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    //startAngle: -135,
                    //endAngle: 135,
                    hollow: {
                      margin: 0,
                      size: '70%',
                      background: 'transparent',
                      image: undefined,
                      imageOffsetX: 0,
                      imageOffsetY: 0,
                      position: 'front',
                      dropShadow: {
                        enabled: true,
                        top: 3,
                        left: 0,
                        blur: 4,
                        opacity: 0.24
                      }
                    },
                    track: {
                      background: 'rgba(255, 255, 255, 0.12)',
                      strokeWidth: '0%',
                      margin: 0, // margin is in pixels
                      dropShadow: {
                        enabled: true,
                        top: -3,
                        left: 0,
                        blur: 4,
                        opacity: 0.35
                      }
                    },
                    dataLabels: {
                        name: {
                            fontSize: '14px',
                            color: '#fff',
                            offsetY: -10
                        },
                        value: {
                            offsetY: 0,
                            fontSize: '20px',
                            color: '#fff',
                            formatter: function (val) {
                                return val + "%";
                            }
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    shadeIntensity: 0.15,
                    gradientToColors: ['#fff'],
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 65, 91]
                },
            },
            stroke: {
                dashArray: 4
            },
            colors: ["#fff"],
            series: [gallon_gauge],
            labels: ['Total'],
            
        }

        var chart = new ApexCharts(
            document.querySelector("#data-chart-31"),
            options
        );
        
        chart.render(); 
      }
  })  
})

$(function() {
  var idGallonPrevious = 11;
  var data = new FormData();                     
    data.append("idGallonPrevious", idGallonPrevious);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        var total_sales_gallon_previous = formatNumber(Math.round(answer["total_amount"]));
        document.getElementById("previous_gallon_sales").innerHTML = total_sales_gallon_previous;
      }
  })  
})








// CURRENT MONTH - Overall Sales
$(function() {
  var currentMonthOverallSales = 1;
  var data = new FormData();                     
    data.append("currentMonthOverallSales", currentMonthOverallSales);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        for(var i = 0; i < answer.length; i++) {
            var obj = answer[i];

            if (i == 0){
              var target_sales = Number.parseFloat(obj.total_sales).toFixed(0); 
            }else{
              var achieved_sales = Number.parseFloat(obj.total_sales).toFixed(0);   
              // var achieved_sales = obj.total_sales; 
            }
        }    
        document.getElementById("target_sales").innerHTML = formatNumber(target_sales);
        document.getElementById("achieved_sales").innerHTML = formatNumber(achieved_sales);
        
        var month_gauge = Math.round(Number(achieved_sales)/Number(target_sales)*100);   

        var options = {
          chart: {
            height: 295,
            type: 'radialBar',
            toolbar: {
              show: false
            }
          },
          plotOptions: {
            radialBar: {
              startAngle: -135,
              endAngle: 225,
               hollow: {
                margin: 0,
                size: '70%',
                background: 'rgba(255, 255, 255, 0.0)',
                image: undefined,
                imageOffsetX: 0,
                imageOffsetY: 0,
                position: 'front',
                dropShadow: {
                  enabled: true,
                  top: 3,
                  left: 0,
                  blur: 4,
                  opacity: 0.24
                }
              },
              track: {
                background: 'rgba(255, 255, 255, 0.12)',
                strokeWidth: '67%',
                margin: 0, // margin is in pixels
                dropShadow: {
                  enabled: true,
                  top: -3,
                  left: 0,
                  blur: 4,
                  opacity: 0.35
                }
              },

              dataLabels: {
                showOn: 'always',
                name: {
                  offsetY: -10,
                  show: true,
                  color: '#fff',
                  fontSize: '17px'
                },
                value: {
                  formatter: function(val) {
                    return parseInt(val);
                  },
                  color: '#fff',
                  fontSize: '36px',
                  show: true,
                }
              }
            }
          },
          fill: {
            type: 'gradient',
            gradient: {
              shade: 'light',
              type: 'horizontal',
              shadeIntensity: 0.5,
              gradientToColors: ['#fff'],
              inverseColors: false,
              opacityFrom: 1,
              opacityTo: 1,
              stops: [0, 100]
            }
          },
          colors: ["#fff"],
          series: [month_gauge],
          stroke: {
            lineCap: 'round'
          },
          labels: ['Percent'],

        }

        var chart = new ApexCharts(
          document.querySelector("#data-chart9"),
          options
        );

        chart.render();
      }   /*outer success*/
  })  
})


$(function() {
  var previousMonthOverallSales = 1;
  var data = new FormData();                     
    data.append("previousMonthOverallSales", previousMonthOverallSales);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        var previous_month_sales = formatNumber(Math.round(answer["total_sales"]));
        document.getElementById("previous_sales").innerHTML = previous_month_sales;
      }
  })  
})









// CURRENT YEAR - Sales Category
$(function() {
  var currentYearSalesCategory = 1;
  var data = new FormData();                     
    data.append("currentYearSalesCategory", currentYearSalesCategory);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        var current_year_sales_category = [];
        var overall_sales = 0.00;

        var con_percent = 0;
        var jar_percent = 0;
        var pb_percent = 0;
        var pl_percent = 0;
        var sb_percent = 0;
        var straw_percent = 0;
        var water_percent = 0;
        var gal_percent = 0;

        for(var i = 0; i < answer.length; i++) {
            var obj = answer[i];
            var total_category_sales = Number(obj.total_category_sales);
            var category_name =  obj.cdesc;

            current_year_sales_category.push(total_category_sales);  

            overall_sales = overall_sales + Number(obj.total_category_sales);
            var total_category_income = formatNumber(Math.round(total_category_sales));

            if (i == 0){
              document.getElementById("accessories_category_sales").innerHTML = total_category_income;
              var accessories = total_category_sales;
            }else if (i == 1){
              document.getElementById("container_category_sales").innerHTML = total_category_income;
              var con = total_category_sales;
            }else if (i == 2){
              document.getElementById("gallon_category_sales").innerHTML = total_category_income;
              var gal = total_category_sales;              
            }else if (i == 3){
              document.getElementById("jar_category_sales").innerHTML = total_category_income;
              var jar = total_category_sales;
            }else if (i == 4){
              document.getElementById("petbottle_category_sales").innerHTML = total_category_income;
              var pb = total_category_sales;
            }else if (i == 5){
              document.getElementById("sandobag_category_sales").innerHTML = total_category_income;
              var sb = total_category_sales;
            }else if (i == 6){
              document.getElementById("straw_category_sales").innerHTML = total_category_income;
              var straw = total_category_sales;
            }else if (i == 7){
              document.getElementById("water_category_sales").innerHTML = total_category_income;
              var water = total_category_sales;              
            }
        } 

        con_percent = parseInt((con / overall_sales) * 100);
        jar_percent = parseInt((jar / overall_sales) * 100);
        pb_percent = parseInt((pb / overall_sales) * 100);
        gal_percent = parseInt((gal / overall_sales) * 100);
        sb_percent = parseInt((sb / overall_sales) * 100);
        straw_percent = parseInt((straw / overall_sales) * 100);
        water_percent = parseInt((water / overall_sales) * 100);
        accessories_percent = parseInt((accessories / overall_sales) * 100);

        document.getElementById("conper").style.width = con_percent + "%";
        document.getElementById("jarper").style.width = jar_percent + "%";
        document.getElementById("pbper").style.width = pb_percent + "%";
        document.getElementById("galper").style.width = gal_percent + "%";
        document.getElementById("sbper").style.width = sb_percent + "%";
        document.getElementById("strawper").style.width = straw_percent + "%";
        document.getElementById("waterper").style.width = water_percent + "%";
        document.getElementById("accessoriesper").style.width = accessories_percent + "%";
        

        var options = {
          chart: {
              width: 300,
              type: 'pie',
              foreColor: 'rgba(255, 255, 255, 0.85)',
          },
          dataLabels: {
              enabled: true
          },
          series: current_year_sales_category,
          tooltip: {
                enabled: false,
                theme: 'dark',
            },
          colors: ["#ffffff", "rgba(255, 255, 255, 0.55)", 'rgba(255, 255, 255, 0.35)', 'rgba(255, 255, 255, 0.15)', 'rgba(255, 255, 255, 0.65)', 'rgba(255, 255, 255, 0.21)', 'rgba(255, 255, 255, 0.45)', 'rgba(255, 255, 255, 0.65)'],
          legend: {
            show:false,
              formatter: function(val, opts) {
                  return val + " - " + opts.w.globals.series[opts.seriesIndex]
              }
          },
          responsive: [{
              breakpoint: 480,
              options: {
                  chart: {
                      width: 280
                  },
                  legend: {
                      position: 'bottom'
                  }
              }
          }]

      }

      var chart = new ApexCharts(
          document.querySelector("#data-chart8"),
          options
      );

      chart.render();

      }   /*outer success*/
  })  
})







// TOP Customers
$(function() {
  var clientMonthSales = 1;
  var data = new FormData();                     
    data.append("clientMonthSales", clientMonthSales);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        var client_month_sales = [];
        var client_list = [];

        for(var i = 0; i < answer.length; i++) {
            var obj = answer[i];
            var total_client_sales = Number(obj.total_sales);
            var client_name =  obj.cname;

            client_month_sales.push(total_client_sales);
            client_list.push(client_name);
        }        

        var options = {
            chart: {
                height: 737,
                type: 'bar',
        foreColor: 'rgba(255, 255, 255, 0.65)',
                toolbar: {
                  show: false
                },
        dropShadow: {
                    enabled: true,
                    opacity: 0.1,
                    blur: 3,
                    left: -7,
                    top: 22,
                }
            },
            plotOptions: {
                bar: {
                    barHeight: '100%',
                    endingShape: 'rounded',
                    distributed: true,
                    horizontal: true,
                    dataLabels: {
                        position: 'bottom'
                    },
                }
            },
             fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    gradientToColors: [ '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff'],
                    shadeIntensity: 0.60,
                    type: 'vertical',
                    opacityFrom: 0.5,
                    opacityTo: 0.5,
                    stops: [0, 100, 100, 100]
                },
            },
            colors: ['#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff'],
            dataLabels: {
                enabled: true,
                textAnchor: 'start',
                style: {
                    colors: ['#fff']
                },
                formatter: function(val, opt) {
                    return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
                },
                offsetX: 0,
                dropShadow: {
                  enabled: true
                }
            },
            series: [{
                data: client_month_sales
            }],
            stroke: {
                width: 1,
              colors: ['#fff'],
            },
            xaxis: {
                categories: client_list,
            },
            yaxis: {
                labels: {
                    show: false
                }
            },
            tooltip: {
                theme: 'dark',
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function() {
                            return ''
                        }
                    }
                }
            },
      grid:{
        show: true,
        borderColor: 'rgba(255, 255, 255, 0.12)',
          }
        }
       var chart = new ApexCharts(
            document.querySelector("#top-referrers"),
            options
        );
        chart.render();

      }   /*outer success*/
  })  
})




// CURRENT YEAR - Production Category
$(function() {
  var currentYearProdCategory = 1;
  var data = new FormData();                     
    data.append("currentYearProdCategory", currentYearProdCategory);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        var current_year_prod_category = [];
        var overall_prod = 0.00;

        var con_percent_prod = 0;
        var jar_percent_prod = 0;
        var pb_percent_prod = 0;
        var pl_percent_prod = 0;
        var sb_percent_prod = 0;
        var straw_percent_prod = 0;
        var water_percent_prod = 0;
        var accessories_percent_prod = 0;
        var gal_percent_prod = 0;

        for(var i = 0; i < answer.length; i++) {
            var obj = answer[i];
            var total_category_prod = Number(obj.total_category_prod);
            var category_name =  obj.cdesc;

            current_year_prod_category.push(total_category_prod);  

            overall_prod = overall_prod + Number(obj.total_category_prod);
            var total_category_production = formatNumber(Math.round(total_category_prod));

            if (category_name == 'Accessories'){
              document.getElementById("accessories_category_prod").innerHTML = total_category_production;
              var accessories_p = total_category_prod;
            }else if (category_name == 'Container'){
              document.getElementById("container_category_prod").innerHTML = total_category_production;
              var con_p = total_category_prod;
            }else if (category_name == 'Gallon'){
              document.getElementById("gallon_category_prod").innerHTML = total_category_production;
              var gal_p = total_category_prod;              
            }else if (category_name == 'Jar'){
              document.getElementById("jar_category_prod").innerHTML = total_category_production;
              var jar_p = total_category_prod;
            }else if (category_name == 'Pet Bottle'){
              document.getElementById("petbottle_category_prod").innerHTML = total_category_production;
              var pb_p = total_category_prod;
            }else if (category_name == 'Sando Bag'){
              document.getElementById("sandobag_category_prod").innerHTML = total_category_production;
              var sb_p = total_category_prod;
            }else if (category_name == 'Straw'){
              document.getElementById("straw_category_prod").innerHTML = total_category_production;
              var straw_p = total_category_prod;
            }else if (category_name == 'Water Container'){
              document.getElementById("water_category_prod").innerHTML = total_category_production;
              var water_p = total_category_prod;              
            }            

            // if (i == 0){
            //   document.getElementById("accessories_category_prod").innerHTML = total_category_production;
            //   var accessories_p = total_category_prod;
            // }else if (i == 1){
            //   document.getElementById("container_category_prod").innerHTML = total_category_production;
            //   var con_p = total_category_prod;
            // }else if (i == 2){
            //   document.getElementById("jar_category_prod").innerHTML = total_category_production;
            //   var jar_p = total_category_prod;
            // }else if (i == 3){
            //   document.getElementById("petbottle_category_prod").innerHTML = total_category_production;
            //   var pb_p = total_category_prod;
            // }else if (i == 4){
            //   document.getElementById("sandobag_category_prod").innerHTML = total_category_production;
            //   var sb_p = total_category_prod;
            // }else if (i == 5){
            //   document.getElementById("straw_category_prod").innerHTML = total_category_production;
            //   var straw_p = total_category_prod;
            // }else if (i == 6){
            //   document.getElementById("water_category_prod").innerHTML = total_category_production;
            //   var water_p = total_category_prod;              
            // }
        } 

        con_percent_prod = parseInt((con_p / overall_prod) * 100);
        gal_percent_prod = parseInt((gal_p / overall_prod) * 100);
        jar_percent_prod = parseInt((jar_p / overall_prod) * 100);
        pb_percent_prod = parseInt((pb_p / overall_prod) * 100);
        sb_percent_prod = parseInt((sb_p / overall_prod) * 100);
        straw_percent_prod = parseInt((straw_p / overall_prod) * 100);
        water_percent_prod = parseInt((water_p / overall_prod) * 100);
        accessories_percent_prod = parseInt((accessories_p / overall_prod) * 100);

        document.getElementById("conperprod").style.width = con_percent_prod + "%";
        document.getElementById("galperprod").style.width = gal_percent_prod + "%";
        document.getElementById("jarperprod").style.width = jar_percent_prod + "%";
        document.getElementById("pbperprod").style.width = pb_percent_prod + "%";
        document.getElementById("sbperprod").style.width = sb_percent_prod + "%";
        document.getElementById("strawperprod").style.width = straw_percent_prod + "%";
        document.getElementById("waterperprod").style.width = water_percent_prod + "%";
        document.getElementById("accessoriesperprod").style.width = accessories_percent_prod + "%";
        
        var options = {
          chart: {
              width: 300,
              type: 'pie',
              foreColor: 'rgba(255, 255, 255, 0.85)',
          },
          dataLabels: {
              enabled: true
          },
          series: current_year_prod_category,
          tooltip: {
                enabled: false,
                theme: 'dark',
            },
          colors: ["#ffffff", "rgba(255, 255, 255, 0.55)", 'rgba(255, 255, 255, 0.35)', 'rgba(255, 255, 255, 0.15)', 'rgba(255, 255, 255, 0.65)', 'rgba(255, 255, 255, 0.21)', 'rgba(255, 255, 255, 0.45)', 'rgba(255, 255, 255, 0.65)'],
          legend: {
            show:false,
              formatter: function(val, opts) {
                  return val + " - " + opts.w.globals.series[opts.seriesIndex]
              }
          },
          responsive: [{
              breakpoint: 480,
              options: {
                  chart: {
                      width: 280
                  },
                  legend: {
                      position: 'bottom'
                  }
              }
          }]

      }

      var chart = new ApexCharts(
          document.querySelector("#data-chart100"),
          options
      );

      chart.render();

      }   /*outer success*/
  })  
})





// CURRENT YEAR Comparative Sales
$(function() {
  var currentYearMonthlySales = 1;
  var data = new FormData();                     
    data.append("currentYearMonthlySales", currentYearMonthlySales);  
     $.ajax({
      url:"ajax/dashboard.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
        var sales_count = answer.length / 2;

        var monthly_sales = [];
        var monthly_purchase = [];

        var yearly_sales = 0.00;
        var yearly_purchase = 0.00;

        for(var i = 0; i < answer.length; i++) {
            var obj = answer[i];
            var sales_info = obj.sales_info;

            if (sales_info == 'Sales'){
              var total_sales = obj.total_amount;
              monthly_sales.push(total_sales);
              yearly_sales = yearly_sales + Number(total_sales); 
            }else{
              var total_purchase = obj.total_amount;
              monthly_purchase.push(total_purchase);
              yearly_purchase = yearly_purchase + Number(total_purchase);              
            }
        }       

        var total_sales_income = formatNumber(Math.round(yearly_sales));
        document.getElementById("year_sales").innerHTML = total_sales_income;

        var total_purchase_cost = formatNumber(Math.round(yearly_purchase));
        document.getElementById("year_purchase").innerHTML = total_purchase_cost;
      
          var ctx = document.getElementById('dash2-chart1').getContext('2d');
          var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
              datasets: [{
                label: 'Purchases',
                data: monthly_purchase,    /*[23,556,48, etc..]*/
                backgroundColor: 'rgba(255, 255, 255, 0.12)',
                borderColor: "transparent",
                borderWidth: 3
              }, {
                label: 'Sales',
                type: 'line',
                data: monthly_sales,
                backgroundColor: "rgba(255, 255, 255, 0.12)",
                borderColor: "#fff",
                pointBackgroundColor:'transparent',
                            pointHoverBackgroundColor:'#fff',
                pointBorderWidth :3,
                pointRadius :4,
                pointHoverRadius :4,
                borderWidth: 3
                
              }]
            },
          options: {
            maintainAspectRatio: false,
            legend: {
              display: false,
              labels: {
              fontColor: '#ddd',  
              boxWidth:40
              }
            },
            tooltips: {
              displayColors:false
            },  
            scales: {
              xAxes: [{
              barPercentage: .4,
              ticks: {
                beginAtZero:true,
                fontColor: '#ddd'
              },
              gridLines: {
                display: true ,
                color: "rgba(221, 221, 221, 0.08)"
              },
              }],
               yAxes: [{
              ticks: {
                beginAtZero:true,
                fontColor: '#ddd'
              },
              gridLines: {
                display: true ,
                color: "rgba(221, 221, 221, 0.08)"
              },
              }]
             }

           }
          });


      }   /*outer success*/
  })  
})

// =====================================================================
//    S E C O N D   R O W  - Recruitment Cost, Application by Source
// =====================================================================

$(function() {
  "use strict";
    // chart 1
    var options = {
            chart: {
                height: 325,
                type: 'bar',
                stacked: false,
                foreColor: 'rgba(255, 255, 255, 0.65)',
                toolbar: {
                      show: false
                    },
                dropShadow: {
                    enabled: true,
                    opacity: 0.1,
                    blur: 3,
                    left: -7,
                    top: 22,
                }
            },
            plotOptions: {
                bar: {
            columnWidth: '50%',
              endingShape: 'rounded',
                    dataLabels: {
                        position: 'top', // top, center, bottom
                    },
                }
            },
            dataLabels: {
                enabled: false,
                formatter: function(val) {
                  return parseInt(val);
                },
                offsetY: -20,
                style: {
                    fontSize: '14px',
                    colors: ["#304758"]
                }
            },
            stroke: {
                show: true,
                width: [0, 0, 0],
                dashArray: [0, 0, 0],
                curve: 'smooth'
               //colors: ['transparent']
            },
            grid:{
                show: true,
                borderColor: 'rgba(255, 255, 255, 0.12)',
            },
            series: [{
                name: 'External Costs',
                data: [44, 75, 37, 56, 61, 58, 83, 60, 66]
            }, {
                name: 'Internal Costs',
                data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
            }, {
                name: 'Cost Per Hire',
                data: [20, 41, 26, 46, 30, 50, 12, 53, 41]
            }],
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
            },
            colors: ["#fff", "rgba(255, 255, 255, 0.50)", 'rgba(255, 255, 255, 0.10)'],
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function (val) {
                        return "$ " + val + " "
                    }
                }
            },
      responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
            height: 330,
            stacked: true,
                    },
          legend: {
            show: !0,
            position: "top",
            horizontalAlign: "left",
            offsetX: -20,
            fontSize: "10px",
            markers: {
              radius: 50,
              width: 10,
              height: 10
            }
            },
            plotOptions: {
            bar: {
              columnWidth: '30%'
              }
            }
                }
            }]
        }
        var chart = new ApexCharts(
            document.querySelector("#recruitment-cost"),
            options
        );
        chart.render();


// chart 2 - application by source
    var options = {
            chart: {
                height: 360,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                  //startAngle: -135,
                  //endAngle: 135,
                  hollow: {
                      margin: 12,
                      size: '50%',
                      background: 'rgba(255, 255, 255, 0.12)',
                      image: undefined,
                      imageOffsetX: 0,
                      imageOffsetY: 0,
                      position: 'front',
                      dropShadow: {
                        enabled: true,
                        top: 3,
                        left: 0,
                        blur: 4,
                        opacity: 0.24
                      }
                    },
                    track: {
                      background: 'rgba(255, 255, 255, 0.06)',
                      strokeWidth: '100%',
                      margin: 5, // margin is in pixels
                      dropShadow: {
                        enabled: false,
                        top: -3,
                        left: 0,
                        blur: 4,
                        opacity: 0.35
                      }
                    },
                    dataLabels: {
                        name: {
                            color:'#fff',
                            fontSize: '14px',
                            offsetY: -5
                        },
                        value: {
                            color: '#fff',
                            fontSize: '25px',
                            offsetY: 5
                        },
                        total: {
                            show: true,
                            label: 'Total',
                            color: '#fff',
                            formatter: function (w) {
                                // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                                return 300
                            }
                        }
                    }
                }
            },
            stroke: {
               lineCap: "round",
           },
            colors: ["#fff", "rgba(255, 255, 255, 0.50)", "rgba(255, 255, 255, 0.25)", "rgba(255, 255, 255, 0.12)"],
            series: [90, 80, 70, 60],
            labels: ['Career Page', 'Referral', 'Agency', 'Job Boards']
        }
       var chart = new ApexCharts(
            document.querySelector("#application-by-source"),
            options
        );
        chart.render();

// ==========================================================================
//    T H I R D  R O W  - Screening Calls, Vacancies Status, Top Referrers
// ==========================================================================

// chart 3 - screening calls
  var options = {
            chart: {
                width: 180,
        //height: 150,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    //startAngle: -135,
                    //endAngle: 135,
                    hollow: {
                      margin: 0,
                      size: '65%',
                      background: 'rgba(0, 0, 0, 0.0)',
                      image: undefined,
                      imageOffsetX: 0,
                      imageOffsetY: 0,
                      position: 'front',
                      dropShadow: {
                        enabled: true,
                        top: 3,
                        left: 0,
                        blur: 4,
                        opacity: 0.1
                      }
                    },
                    track: {
                      background: 'rgba(255, 255, 255, 0.12)',
                      strokeWidth: '100%',
                      margin: 0, // margin is in pixels
                      dropShadow: {
                        enabled: true,
                        top: -3,
                        left: 0,
                        blur: 4,
                        opacity: 0.1
                      }
                    },
                    dataLabels: {
                        name: {
                            fontSize: '14px',
                            color: '#fff',
                            offsetY: -10,
              show: false
                        },
                        value: {
                            offsetY: 6,
                            fontSize: '20px',
                            color: '#fff',
                            formatter: function (val) {
                                return val + "%";
                            }
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    shadeIntensity: 0.15,
                    gradientToColors: ['#fff'],
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 65, 91]
                },
            },
            stroke: {
                dashArray: 4,
            },
            colors: ["#fff"],
            series: [64],
            labels: ['Screening Calls'],
        }
       var chart = new ApexCharts(
            document.querySelector("#screening-calls"),
            options
        );
        chart.render();

  // chart 4 - assignments
  var options = {
            chart: {
                width: 180,
        //height: 150,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    //startAngle: -135,
                    //endAngle: 135,
                    hollow: {
                      margin: 0,
                      size: '65%',
                      background: 'rgba(0, 0, 0, 0.0)',
                      image: undefined,
                      imageOffsetX: 0,
                      imageOffsetY: 0,
                      position: 'front',
                      dropShadow: {
                        enabled: true,
                        top: 3,
                        left: 0,
                        blur: 4,
                        opacity: 0.1
                      }
                    },
                    track: {
                      background: 'rgba(255, 255, 255, 0.12)',
                      strokeWidth: '100%',
                      margin: 0, // margin is in pixels
                      dropShadow: {
                        enabled: true,
                        top: -3,
                        left: 0,
                        blur: 4,
                        opacity: 0.1
                      }
                    },
                    dataLabels: {
                        name: {
                            fontSize: '14px',
                            color: '#fff',
                            offsetY: -10,
              show: false
                        },
                        value: {
                            offsetY: 6,
                            fontSize: '20px',
                            color: '#fff',
                            formatter: function (val) {
                                return val + "%";
                            }
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    shadeIntensity: 0.15,
                    gradientToColors: ['#fff'],
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 65, 91]
                },
            },
            stroke: {
                dashArray: 4,
            },
            colors: ["#fff"],
            series: [76],
            labels: ['Assignments'],
        }
       var chart = new ApexCharts(
            document.querySelector("#assignments"),
            options
        );
        chart.render();


  // chart 5 - interviews
  var options = {
            chart: {
                width: 180,
        //height: 150,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    //startAngle: -135,
                    //endAngle: 135,
                    hollow: {
                      margin: 0,
                      size: '65%',
                      background: 'rgba(255, 255, 255, 0.0)',
                      image: undefined,
                      imageOffsetX: 0,
                      imageOffsetY: 0,
                      position: 'front',
                      dropShadow: {
                        enabled: true,
                        top: 3,
                        left: 0,
                        blur: 4,
                        opacity: 0.1
                      }
                    },
                    track: {
                      background: 'rgba(255, 255, 255, 0.12)',
                      strokeWidth: '100%',
                      margin: 0, // margin is in pixels
                      dropShadow: {
                        enabled: true,
                        top: -3,
                        left: 0,
                        blur: 4,
                        opacity: 0.1
                      }
                    },
                    dataLabels: {
                        name: {
                            fontSize: '14px',
                            color: '#fff',
                            offsetY: -10,
              show: false
                        },
                        value: {
                            offsetY: 6,
                            fontSize: '20px',
                            color: '#fff',
                            formatter: function (val) {
                                return val + "%";
                            }
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    shadeIntensity: 0.15,
                    gradientToColors: ['#fff'],
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 65, 91]
                },
            },
            stroke: {
                dashArray: 4,
            },
            colors: ["#fff"],
            series: [83],
            labels: ['interviews'],
        }
       var chart = new ApexCharts(
            document.querySelector("#interviews"),
            options
        );
        chart.render();

   // chart 6 - vacancy status
   var options = {
      chart: {
        height: 335,
        type: 'radialBar',
        toolbar: {
          show: false
        }
      },
      plotOptions: {
        radialBar: {
          startAngle: -135,
          endAngle: 225,
           hollow: {
            margin: 20,
            size: '70%',
            background: 'transparent',
            image: undefined,
            imageOffsetX: 0,
            imageOffsetY: 0,
            position: 'front',
            dropShadow: {
              enabled: true,
              top: 3,
              left: 0,
              blur: 4,
              opacity: 0.24
            }
          },
          track: {
            background: 'rgba(255, 255, 255, 0.12)',
            strokeWidth: '67%',
            margin: 0, // margin is in pixels
            dropShadow: {
              enabled: true,
              top: -3,
              left: 0,
              blur: 4,
              opacity: 0.35
            }
          },
          dataLabels: {
            showOn: 'always',
            name: {
              offsetY: -10,
              show: false,
              color: '#fff',
              fontSize: '16px'
            },
            value: {
              formatter: function (val) {
          return val + "%";
         },
              color: '#fff',
              fontSize: '40px',
              show: true,
            }
          }
        }
      },
      fill: {
        type: 'gradient',
        gradient: {
          shade: 'light',
          type: 'horizontal',
          shadeIntensity: 0.5,
          gradientToColors: ['#fff'],
          inverseColors: false,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100]
        }
      },
      colors: ["#fff"],
      series: [75],
      stroke: {
        lineCap: 'round'
      },
      labels: ['Median Ratio'],
    }
    var chart = new ApexCharts(
      document.querySelector("#vacancies-status"),
      options
    );
    chart.render();

    // chart 7 - top referrers
    // var options = {
    //         chart: {
    //             height: 387,
    //             type: 'bar',
    //     foreColor: 'rgba(255, 255, 255, 0.65)',
    //             toolbar: {
    //               show: false
    //             },
    //     dropShadow: {
    //                 enabled: true,
    //                 opacity: 0.1,
    //                 blur: 3,
    //                 left: -7,
    //                 top: 22,
    //             }
    //         },
    //         plotOptions: {
    //             bar: {
    //                 barHeight: '100%',
    //                 endingShape: 'rounded',
    //                 distributed: true,
    //                 horizontal: true,
    //                 dataLabels: {
    //                     position: 'bottom'
    //                 },
    //             }
    //         },
    //          fill: {
    //             type: 'gradient',
    //             gradient: {
    //                 shade: 'light',
    //                 gradientToColors: [ '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff'],
    //                 shadeIntensity: 0.60,
    //                 type: 'vertical',
    //                 opacityFrom: 0.5,
    //                 opacityTo: 0.5,
    //                 stops: [0, 100, 100, 100]
    //             },
    //         },
    //         colors: ['#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff'],
    //         dataLabels: {
    //             enabled: true,
    //             textAnchor: 'start',
    //             style: {
    //                 colors: ['#fff']
    //             },
    //             formatter: function(val, opt) {
    //                 return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
    //             },
    //             offsetX: 0,
    //             dropShadow: {
    //               enabled: true
    //             }
    //         },
    //         series: [{
    //             data: [950, 730, 848, 570, 840, 580, 900, 1100, 1200, 1280]
    //         }],
    //         stroke: {
    //             width: 1,
    //           colors: ['#fff'],
    //         },
    //         xaxis: {
    //             categories: ['Direct', 'Google', 'Medium.com', 'Github', 'Envato', 'Youtube', 'cs.champion.com', 'T.co', 'Facebbok', 'LinkedIn'],
    //         },
    //         yaxis: {
    //             labels: {
    //                 show: false
    //             }
    //         },
    //         tooltip: {
    //             theme: 'dark',
    //             x: {
    //                 show: false
    //             },
    //             y: {
    //                 title: {
    //                     formatter: function() {
    //                         return ''
    //                     }
    //                 }
    //             }
    //         },
    //   grid:{
    //     show: true,
    //     borderColor: 'rgba(255, 255, 255, 0.12)',
    //       }
    //     }
    //    var chart = new ApexCharts(
    //         document.querySelector("#top-referrers"),
    //         options
    //     );
    //     chart.render();


// chart 8
var options1 = {
      chart: {
        type: 'area',
        height: 110,
        sparkline: {
          enabled: true
        }
      },
      dataLabels: {
          enabled: false
      },
      fill: {
        type: 'gradient',
          gradient: {
              shade: 'light',
              //gradientToColors: ['rgba(255, 255, 255, 0.12)'],
              shadeIntensity: 1,
              type: 'vertical',
              opacityFrom: 0.7,
              opacityTo: 0.1,
              stops: [0, 100, 100, 100]
          },
      },
      colors: ["#fff"],
      series: [{
        name: 'Employee NPS',
        data: [25, 66, 41, 59, 25, 44, 12, 36, 9, 21]
      }],
      stroke: {
              width: 2.5, 
              curve: 'smooth',
              dashArray: [0]
         },
      tooltip: {
              theme: 'dark',
              x: {
                  show: false
              },
          }
    }
    new ApexCharts(document.querySelector("#emp-nps"), options1).render();
    // chart 9
    var options1 = {
      chart: {
        type: 'area',
        height: 110,
        sparkline: {
          enabled: true
        }
      },
      dataLabels: {
          enabled: false
      },
      fill: {
        type: 'gradient',
          gradient: {
              shade: 'light',
              //gradientToColors: ['rgba(255, 255, 255, 0.12)'],
              shadeIntensity: 1,
              type: 'vertical',
              opacityFrom: 0.7,
              opacityTo: 0.1,
              stops: [0, 100, 100, 100]
          },
      },
      colors: ["#fff"],
      series: [{
        name: 'Training Expenses',
        data: [12, 14, 2, 47, 32, 44, 14, 55, 41, 69]
      }],
      stroke: {
                width: 2.5, 
                curve: 'smooth',
                dashArray: [0]
         },
      tooltip: {
              theme: 'dark',
              x: {
                  show: false
              },
          }
    }
    new ApexCharts(document.querySelector("#training-expenses"), options1).render();
    
    // chart 10
    var options1 = {
      chart: {
        type: 'area',
        height: 110,
        sparkline: {
          enabled: true
        }
      },
      dataLabels: {
          enabled: false
      },
      fill: {
        type: 'gradient',
          gradient: {
              shade: 'light',
              //gradientToColors: ['rgba(255, 255, 255, 0.12)'],
              shadeIntensity: 1,
              type: 'vertical',
              opacityFrom: 0.7,
              opacityTo: 0.1,
              stops: [0, 100, 100, 100]
          },
      },
      colors: ["#fff"],
      series: [{
        name: 'CSR Activities',
        data: [47, 45, 74, 32, 56, 31, 44, 33, 45, 19]
      }],
      stroke: {
                width: 2.5, 
                curve: 'smooth',
                dashArray: [0]
         },
      tooltip: {
              theme: 'dark',
              x: {
                  show: false
              },
          }
    }
    new ApexCharts(document.querySelector("#csr-activities"), options1).render();
  // chart 11
  var options1 = {
      chart: {
        type: 'area',
        height: 110,
        sparkline: {
          enabled: true
        }
      },
      dataLabels: {
          enabled: false
      },
      fill: {
        type: 'gradient',
          gradient: {
              shade: 'light',
              //gradientToColors: ['rgba(255, 255, 255, 0.12)'],
              shadeIntensity: 1,
              type: 'vertical',
              opacityFrom: 0.7,
              opacityTo: 0.1,
              stops: [0, 100, 100, 100]
          },
      },
      colors: ["#fff"],
      series: [{
        name: 'Starter This Month',
        data: [15, 75, 47, 65, 14, 32, 19, 54, 44, 61]
      }],
      stroke: {
                width: 2.5, 
                curve: 'smooth',
                dashArray: [0]
         },
      tooltip: {
              theme: 'dark',
              x: {
                  show: false
              },
          }
    }
    new ApexCharts(document.querySelector("#starter-this-month"), options1).render();
  // chart 6
    var options = {
            chart: {
                width:200,
                height: 73,
                type: 'bar',
                zoom: {
                      enabled: false
                    },
                foreColor: '#4e4e4e',
                toolbar: {
                      show: false
                    },
            sparkline: {
              enabled: true
          },
          dropShadow: {
                  enabled: true,
                  opacity: 0.1,
                  blur: 3,
                  left: -4,
                  top: 22,
                }
            },
            plotOptions: {
                bar: {
            columnWidth: '30%',
              endingShape: 'rounded',
                }
            },
            stroke: {
                width: 0,   
                curve: 'smooth',
            },
            dataLabels: { 
                enabled: false
            },
            series: [{
                name: 'Bounce Rate',
                data: [47, 45, 74, 14, 56, 74, 14, 11, 7, 39, 82],
            }],
            yaxis: [{
        y: 0,
        offsetX: 0,
        offsetY: 0,
        padding: {
        left: 0,
        right: 0
        }
      }],
        tooltip: {
          theme: 'dark',
          x: {
              show: false
          },
      },
        colors: ["#fff"],
        grid:{
            show: false,
            borderColor: 'rgba(66, 59, 116, 0.15)',
        },
      responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 150,
            height: 70,
                    }
                }
            }]
        }
       var chart = new ApexCharts(
            document.querySelector("#bounce-rate"),
            options
        );
        chart.render();
        
    // chart 13
    var options = {
            chart: {
                height: 310,
                type: 'bar',
        foreColor: 'rgba(255, 255, 255, 0.65)',
           toolbar: {
                     show: false
                }
            },
            plotOptions: {
                bar: {
            columnWidth: '50%',
              endingShape: 'rounded',
                    dataLabels: {
                        position: 'top', // top, center, bottom
                    },
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val) {
                  return parseInt(val);
                },
                offsetY: -20,
                style: {
                    fontSize: '14px',
                    colors: ["rgba(255, 255, 255, 0.65)"]
                }
            },
            stroke: {
              width: 0
              },
            series: [{
                name: 'Applications',
                data: [2.3, 3.1, 4.0, 10.1, 4.0, 3.6, 3.2]
            }],
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
                position: 'bottom',
                labels: {
                    offsetY: 0,
                },
                axisBorder: {
                    show: true
                },
                axisTicks: {
                    show: true
                }
            },
              tooltip: {
                    enabled: true,
                    theme: 'dark',
             },
            grid:{
                show: true,
                borderColor: 'rgba(255, 255, 255, 0.12)',
            }, 
            colors: ["#ffffff"], 
            yaxis: {
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    show: false,
                    formatter: function(val) {
                    return parseInt(val);
                  }
                }
            },
            title: {
                text: 'Monthly Application Submitions, 2018',
                floating: true,
                offsetY: 0,
                align: 'center',
                style: {
                    fontSize: '15px',
                    color: '#fff'
                }
            },
      responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 310
                    },
                    legend: {
                        position: 'bottom'
                    },
          title: {
            text: 'Monthly Application Submitions, 2018',
            floating: true,
            offsetY: 0,
            align: 'center',
            style: {
              fontSize: '13px',
              color: '#fff'
            }
          }
                }
            }]
        }
        var chart = new ApexCharts(
            document.querySelector("#submitted-application"),
            options
        );
        chart.render();
        
  // chart 14
    var options = {
            chart: {
                height: 225,
                type: 'area',
                zoom: {
                      enabled: false
                    },
             foreColor: 'rgba(255, 255, 255, 0.65)',
             toolbar: {
                  show: false
                },
          sparkline:{
              enabled:false,
            }
            },
            plotOptions: {
                bar: {
            columnWidth: '10%',
              endingShape: 'rounded',
                    dataLabels: {
                        position: 'top', // top, center, bottom
                    },
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 2.5, 
                curve: 'smooth'
            },
            series: [{
                name: 'New Users',
                data: [15, 26, 20, 33, 27, 43, 17, 26, 19]
            },{
                name: 'Returning Users',
                data: [33, 21, 42, 19, 32, 25, 36, 29, 49]
            }],
            xaxis: {
                type: 'month',
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep"],                
            },
            yaxis: {
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    show: false,
                    formatter: function(val) {
                    return parseInt(val);
                  }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    gradientToColors: ['rgba(255, 255, 255, 0.1)', '#fff'],
                    shadeIntensity: 1,
                    type: 'vertical',
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 80, 100]
                },
            },
            colors: ['rgba(255, 255, 255, 0.1)', '#fff'],
            legend: {
                show: !0,
                position: "top",
                horizontalAlign: "left",
                offsetX: -20,
                fontSize: "12px",
                markers: {
                  radius: 50,
                  width: 10,
                  height: 10
                }
              },
            grid:{
                show: true,
                borderColor: 'rgba(255, 255, 255, 0.12)',
            },
            tooltip: {
                theme: 'dark',
                x: {
                    format: 'dd/MM/yy HH:mm',
                },
            },
      responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 300
                    },
                    legend: {
                        offsetX: -20,
                        fontSize: "12px", 
                    }
                }
            }]
        }
        var chart = new ApexCharts(
            document.querySelector("#users-status"),
            options
        );
        chart.render();    

    });  