
window.onload = function() {
    var headTag = document.getElementsByTagName("head")[0];
    // base url for ajax, scripts, links, images
    if (window.location.host == 'localhost') {
        // var baseUrl = 'http://localhost/trustyy';
        var baseUrl = 'https://app.trustyy.io';
    } else {
        var baseUrl = 'https://app.trustyy.io';
    }





function bootstrapAdd() { 
    var headTag = document.getElementsByTagName("head")[0];
    // base url for ajax, scripts, links, images
    if (window.location.host == 'localhost') {
        // var baseUrl = 'http://localhost/trustyy';
        var baseUrl = 'https://app.trustyy.io';
    } else {
        var baseUrl = 'https://app.trustyy.io';
    }
    var bootstrapLink = document.createElement('link');
    var bootstrapScript = document.createElement('script');

    bootstrapLink.rel = "stylesheet";
    bootstrapLink.href = baseUrl+"/public/plugins/bootstrap/css/bootstrap.min.css";
    // bootstrapLink.onload = myJQueryCode;
    headTag.appendChild(bootstrapLink);

    bootstrapScript.type = 'text/javascript';
    bootstrapScript.src = baseUrl+"/public/plugins/bootstrap/js/bootstrap.min.js";
    // bootstrapScript.onload = myJQueryCode;
    headTag.appendChild(bootstrapScript);
    // console.log('bootstrap 4.1.3 added');

 }
 function FontAwesomeAdd(param) { 
    var headTag = document.getElementsByTagName("head")[0];
   
    var fontawesomeLink = document.createElement('link');
    fontawesomeLink.rel = "stylesheet";
    fontawesomeLink.href = "https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css";
    headTag.appendChild(fontawesomeLink);
    
  }
     // check if jquery not exist add that
     if(typeof jQuery=='undefined') {
        
        
        var jqTag = document.createElement('script');
        jqTag.type = 'text/javascript';
        jqTag.src = baseUrl+'/public/js/jquery.min.js';
        jqTag.onload = myJQueryCode;
        headTag.appendChild(jqTag);
        // console.log('jquery added');
            // import bootstrap if not exist or version below 4.1.3
            FontAwesomeAdd();
            bootstrapAdd();
            fewlinesScriptAdd();
            setTimeout(function(){ 
                myJQueryCode();

             }, 1000);
    } else {
        // console.log('jquery already exists');
            // import bootstrap if not exist or version below 4.1.3
            FontAwesomeAdd();
            bootstrapAdd();
            fewlinesScriptAdd();
            setTimeout(function(){ 
                myJQueryCode();

             }, 1000);
    }




    // // check fontawesome if not exist or fas class not exist add font AWESOME 5
    // var span = document.createElement('span');
    // span.className = 'fas';
    // span.style.display = 'none';
    // document.body.insertBefore(span, document.body.firstChild);     
    // function css(element, property) {
    //     return window.getComputedStyle(element, null).getPropertyValue(property);
    // }       
    // if ((css(span, 'font-family')) !== 'FontAwesome') {
    //     // add a local fallback
    //     var fontawesomeLink = document.createElement('link');
    //     var fontawesomeScript = document.createElement('script');

    //     fontawesomeLink.rel = "stylesheet";
    //     fontawesomeLink.href = baseUrl+"/public/plugins/fontawesome-5/css/fontawesome.min.css";
    //     fontawesomeLink.onload = myJQueryCode;
    //     headTag.appendChild(fontawesomeLink);

    //     fontawesomeScript.type = 'text/javascript';
    //     fontawesomeScript.src = baseUrl+"/public/plugins/fontawesome-5/js/fontawesome.min.js";
    //     fontawesomeScript.onload = myJQueryCode;
    //     headTag.appendChild(fontawesomeScript);
    //     console.log('FontAwesome added');
        
    // } else {
    //     console.log('FontAwesome already exists');
    // }
    // document.body.removeChild(span);



function fewlinesScriptAdd() {
    var headTag = document.getElementsByTagName("head")[0];
    // base url for ajax, scripts, links, images
    if (window.location.host == 'localhost') {
        // var baseUrl = 'http://localhost/trustyy';
        var baseUrl = 'https://app.trustyy.io';
    } else {
        var baseUrl = 'https://app.trustyy.io';
    }
    var fewlines = document.createElement('script');
    fewlines.type = 'text/javascript';
    fewlines.src = baseUrl+'/public/plugins/multi-text/fewlines.js';
    fewlines.onload = myJQueryCode;
    headTag.appendChild(fewlines);

}


function myJQueryCode() {
    var headTag = document.getElementsByTagName("head")[0];
    // base url for ajax, scripts, links, images
    if (window.location.host == 'localhost') {
        // var baseUrl = 'http://localhost/trustyy';
        var baseUrl = 'https://app.trustyy.io';
    } else {
        var baseUrl = 'https://app.trustyy.io';
    }
    // Do stuff with jQuery
    var avatar = baseUrl+ '/public/images/avatardp.png';

    // Need to ask about svgs path
    var tripadvisorsvg = '<img src="'+baseUrl+ '/public/plugins/fontawesome-5/svgs/brands/tripadvisor.svg'+'" style="width:28px; height:auto;" alt="tripadvisor">';
    var yelpsvg = '<img src="'+baseUrl+ '/public/plugins/fontawesome-5/svgs/brands/yelp.svg'+'" style="width:28px; height:auto;" alt="tripadvisor">';
    var googlesvg = '<img src="'+baseUrl+ '/public/plugins/fontawesome-5/svgs/brands/google.svg'+'" style="width:28px; height:auto;" alt="tripadvisor">';
    
    const widget_script = document.getElementById('widget_script');
    const queryString = widget_script.src.replace(/^[^\?]+\??/,'');
    
    const params = parseQuery( queryString );
    const widget_id = params.id;
    function parseQuery ( query ) {
        const Params = new Object ();
        if ( ! query ) return Params; // return empty object
        const Pairs = query.split(/[;&]/);
        for ( var i = 0; i < Pairs.length; i++ ) {
            var KeyVal = Pairs[i].split('=');
            if ( ! KeyVal || KeyVal.length != 2 ) continue;
            var key = unescape( KeyVal[0] );
            var val = unescape( KeyVal[1] );
            val = val.replace(/\+/g, ' ');
            Params[key] = val;
        }
        return Params;
    }
    
    var static_html = '<div class="card-body text-center">'+

    '<div id="slider_carousel" class="carousel slide pb-5" data-ride="carousel" style="display: none">'+
        '<ol class="carousel-indicators">'+
        '</ol>'+
        '<div class="carousel-inner">'+
        '</div>'+
        '<a class="carousel-control-prev" href="#slider_carousel" role="button" data-slide="prev">'+
            '<span class="carousel-control-prev-icon" aria-hidden="true"></span>'+
            '<span class="sr-only">Previous</span>'+
        '</a>'+
        '<a class="carousel-control-next" href="#slider_carousel" role="button" data-slide="next">'+
            '<span class="carousel-control-next-icon" aria-hidden="true"></span>'+
            '<span class="sr-only">Next</span>'+
        '</a>'+
    '</div>'+
    
    '<div id="multislider_carousel" class="carousel slide pb-5" data-ride="carousel" style="display: none">'+
        '<ol class="carousel-indicators">'+
                
        '</ol>'+
        '<div class="carousel-inner">'+
    
        '</div>'+
        '<a class="carousel-control-prev" href="#multislider_carousel" role="button" data-slide="prev">'+
            '<span class="carousel-control-prev-icon" aria-hidden="true"></span>'+
            '<span class="sr-only">Previous</span>'+
        '</a>'+
        '<a class="carousel-control-next" href="#multislider_carousel" role="button" data-slide="next">'+
            '<span class="carousel-control-next-icon" aria-hidden="true"></span>'+
            '<span class="sr-only">Next</span>'+
        '</a>'+
    '</div>'+
    
    '<div id="list_widget" style="display: none">'+
        '<div class="row">'+
                
        '</div>'+
    '</div>'+
    
    '<div id="grid_widget" style="display: none">'+
        '<div class="row">'+
    
        '</div>'+
    '</div>'+
    
    '<div id="single_quote" style="display: none">'+
        
    '</div>'+
    
    '<div id="badge_quote" style="display: none">'+
    
    '</div>'+
    
    '</div>';
    
    $('#preview_card').html(static_html);

    showReviews(widget_id,tripadvisorsvg,yelpsvg,googlesvg);
 }




    function showReviews(widget_id,tripadvisorsvg,yelpsvg,googlesvg) { 


        
        $.ajax({   
        //    headers: {
        //        "accept": "application/json",
        //        "Access-Control-Allow-Origin":"*"
        //    },     
           type: "GET",
           url: baseUrl + "/api/showWidget",
        //    contentType: "text/html; charset=utf-8;",
        //    async: false,
        //    crossDomain: true,
        //     dataType: 'jsonp',
           data: {
               id: widget_id
           },
           success: function(response) {
            // console.log('callback success');
        },
        error: function(xhr, status, error) {
            // console.log(status + '; ' + error);
            // console.log(xhr);
            
        }
    //        success: function(data, textStatus, request){
    //         alert(request.getResponseHeader('some_header'));
    //         // response.setHeader("Access-Control-Allow-Origin", "*");
    //         // response.setHeader("Access-Control-Allow-Credentials", "true");
    //         // response.setHeader("Access-Control-Allow-Methods", "GET,HEAD,OPTIONS,POST,PUT");
    //         // response.setHeader("Access-Control-Allow-Headers", "Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");
            
    //    },
       }).done(function (data) { 
// console.log("data:::", data);
           var widget = data.widget;
   
           var data = data.reviews;
        //    console.log(data);
        //    console.log(widget);
           // html and data rendering
           switch (widget.type) {
               case "Slider":
   
                   // show the selected widget type only
                   $('#slider_carousel').show();
                   $("#slider_carousel").siblings().hide();
   
                   var html = '';
                   var indicator = '';
   
                   // loop will iterate to number of reviews
                   for (let index = 0; index < data.length; index++) {
   
                       // for running slider
                       var slideTo = index + 1;
                       var isActive = (index == 0) ? 'active' : '';
                       indicator += '<li data-target="#slider_carousel" data-slide-to="' + slideTo +
                           '" class="' +
                           isActive + '"></li>';
   
                       // for display reviewsource
                       var reviewsource = '';
                       if (data[index].type == "Tripadvisor") {
                           reviewsource = tripadvisorsvg;
                            //    '<span><i class="fab fa-tripadvisor fa-2x text-right"></i></span>';
                       } else if (data[index].type == "Yelp") {
                           reviewsource = yelpsvg;
                       } else if (data[index].type == "Google Places") {
                           reviewsource = googlesvg;
                       }
   
                       // for display avatar
                       var avatar = baseUrl+ '/public/images/avatardp.png';
   
                       // for display stars
                       var stars = '';
                       for (let starindex = 0; starindex < data[index].rating; starindex++) {
                           stars += '<span><i class="fa fa-star" style="color:#F7B707;"></i></span>';
                       }
   
                       // carousel item
                       html += '<div class="carousel-item ' + isActive + '">' +
                           '<div class="row">' +
                           '<div class="col-md-9 text-left">' +
                           '<div class="row">' +
                           '<div class="col-md-3">' +
                           '<img src="' + avatar +
                           '" alt="" class="rounded-circle" style="width:40px; height:40px;">' +
                           '</div>' +
                           '<div class="col-md-9">' +
                           '<div class="row">' +
                           '<div class="col-md-6">' +
                           '<h4 class="author_font_color">' +
   
                           data[index].reviewer +
                           '</h4>' +
                           '</div>' +
                           '<div class="col-md-6">' +
                           stars +
                           '</div>' +
                           '</div>' +
                           '<div class="date_color">' +
                           data[index].review_date +
                           '</div>' +
                           '</div>' +
                           '</div>' +
                           '</div>' +
                           '<div class="col-md-3">' +
                           reviewsource +
                           '</div>' +
                           '</div>' +
                           '<div class="row mt-4">' +
                           '<div class="col-md-12 quote_font_color review-column">' + '<p>';
                       html += data[index].message ? data[index].message : 'No review for this user.';
                       html += '</p>' + '</div>' +
                           '</div>' +
                           '</div>';
                   }
   
                   $('#preview_card .carousel-indicators').html(indicator);
                   $('#preview_card .carousel-inner').html(html);
   
                   // seemore
                   $('.review-column p').fewlines({
                       lines: 4,
                       openMark: ' See More',
                       closeMark: ' See Less',
                       newLine: false,
                   });
                   break;
               case "MultiSlider":
                   $('#multislider_carousel').show();
                   $("#multislider_carousel").siblings().hide();
   
                   var html = '';
                   var indicator = '';
   
                   // loop will iterate to number of reviews
                   for (let index = 0; index < data.length; index += 3) {
   
                       // for running slider
                       var slideTo = index + 1;
                       var isActive = (index == 0) ? 'active' : '';
                       indicator += '<li data-target="#slider_carousel" data-slide-to="' + slideTo +
                           '" class="' +
                           isActive + '"></li>';
   
                       // for display reviewsource
                       var reviewsource = '';
                       if (data[index].type == "Tripadvisor") {
                           reviewsource =tripadvisorsvg;
                            //    '<span><i class="fab fa-tripadvisor fa-2x text-right"></i></span>';
                       } else if (data[index].type == "Yelp") {
                           reviewsource = yelpsvg;
                       } else if (data[index].type == "Google Places") {
                           reviewsource = googlesvg;
                       }
   
                       // for display avatar
                       var avatar = baseUrl+ '/public/images/avatardp.png';
   
                       // for display stars
                       var stars = '';
                       for (let starindex = 0; starindex < data[index].rating; starindex++) {
                           stars += '<span><i class="fa fa-star" style="color:#F7B707;"></i></span>';
                       }
   
   
                       // for multi slider 
                       var col2 = index + 1;
                       var col3 = index + 2;
   
                       if (data[col2]) {
                           var htmlcol2 = '<div class="col-md-4">' +
                               '<div class="shadow rounded">' +
                               '<div class="row">' +
                               '<div class="col-md-12 text-left">' +
                               '<div class="row d-flex align-items-center">' +
                               '<div class="col-md-6">' +
                               '<img src="' + avatar +
                               '" alt="" class="ml-1 mt-1 rounded-circle" style="width:40px; height:40px;">' +
                               '</div>' +
                               '<div class="col-md-6 text-right pr-4">' +
                               reviewsource +
                               '</div>' +
                               '</div>' +
                               '<div class="row text-center">' +
                               '<div class="col-md-12 py-1">' +
                               '<h4 class="author_font_color">' +
                               data[col2].reviewer +
                               '</h4>' +
                               '</div>' +
                               '<div class="col-md-12 py-1">' +
                               stars +
                               '</div>' +
                               '</div>' +
                               '<div class="date_color text-center py-1">' +
                               data[col2].review_date +
                               '</div>' +
                               '</div>' +
                               '</div>' +
                               '<div class="row mt-4">' +
                               '<div class="col-md-12 quote_font_color review-column">' + '<p>';
                           htmlcol2 += data[col2].message ? data[col2].message :
                           'No review for this user.';
                           htmlcol2 += '</p>' + '</div>' +
                               '</div>' +
                               '</div>' +
                               '</div>';
   
                       } else {
                           var htmlcol2 = '';
                       }
                       if (data[col3]) {
                           var htmlcol3 = '<div class="col-md-4">' +
                               '<div class="shadow rounded">' +
                               '<div class="row">' +
                               '<div class="col-md-12 text-left">' +
                               '<div class="row d-flex align-items-center">' +
                               '<div class="col-md-6">' +
                               '<img src="' + avatar +
                               '" alt="" class="ml-1 mt-1 rounded-circle" style="width:40px; height:40px;">' +
                               '</div>' +
                               '<div class="col-md-6 text-right pr-4">' +
                               reviewsource +
                               '</div>' +
                               '</div>' +
                               '<div class="row text-center">' +
                               '<div class="col-md-12 py-1">' +
                               '<h4 class="author_font_color">' +
                               data[col3].reviewer +
                               '</h4>' +
                               '</div>' +
                               '<div class="col-md-12 py-1">' +
                               stars +
                               '</div>' +
                               '</div>' +
                               '<div class="date_color text-center py-1">' +
                               data[col3].review_date +
                               '</div>' +
                               '</div>' +
                               '</div>' +
                               '<div class="row mt-4">' +
                               '<div class="col-md-12 quote_font_color review-column">' + '<p>';
                           htmlcol3 += data[col3].message ? data[col3].message :
                           'No review for this user.';
                           htmlcol3 += '</p>' + '</div>' +
                               '</div>' +
                               '</div>' +
                               '</div>';
   
                       } else {
                           var htmlcol3 = '';
                       }
   
                       // carousel item
                       html += '<div class="carousel-item ' + isActive + '">' +
                           '<div class="row">' +
                           '<div class="col-md-4">' +
                           '<div class="shadow rounded">' +
                           '<div class="row">' +
                           '<div class="col-md-12 text-left">' +
                           '<div class="row d-flex align-items-center">' +
                           '<div class="col-md-6">' +
                           '<img src="' + avatar +
                           '" alt="" class="ml-1 mt-1 rounded-circle" style="width:40px; height:40px;">' +
                           '</div>' +
                           '<div class="col-md-6 text-right pr-4">' +
                           reviewsource +
                           '</div>' +
                           '</div>' +
                           '<div class="row text-center">' +
                           '<div class="col-md-12 py-1">' +
                           '<h4 class="author_font_color">' +
                           data[index].reviewer +
                           '</h4>' +
                           '</div>' +
                           '<div class="col-md-12 py-1">' +
                           stars +
                           '</div>' +
                           '</div>' +
                           '<div class="date_color text-center py-1">' +
                           data[index].review_date +
                           '</div>' +
                           '</div>' +
                           '</div>' +
                           '<div class="row mt-4">' +
                           '<div class="col-md-12 quote_font_color review-column">' + '<p>';
                       html += data[index].message ? data[index].message : 'No review for this user.';
                       html += '</p>' + '</div>' +
                           '</div>' +
                           '</div>' +
                           '</div>' +
                           htmlcol2 +
                           htmlcol3 +
                           '</div>' +
                           '</div>';
                   } // end for loop
   
                   // appending html
                   $('#preview_card .carousel-indicators').html(indicator);
                   $('#preview_card .carousel-inner').html(html);
   
                   // seemore
                   $('.review-column p').fewlines({
                       lines: 4,
                       openMark: ' See More',
                       closeMark: ' See Less',
                       newLine: false,
                   });
   
   
                   break;
               case "List":
                   $('#list_widget').show();
                   $("#list_widget").siblings().hide();
   
                   // html intialize
                   var html = '';
   
                   // loop will iterate to number of reviews
                   for (let index = 0; index < data.length; index++) {
                       // for display reviewsource
                       var reviewsource = '';
                       if (data[index].type == "Tripadvisor") {
                           reviewsource =tripadvisorsvg;
                            //    '<span><i class="fab fa-tripadvisor fa-2x text-right"></i></span>';
                       } else if (data[index].type == "Yelp") {
                           reviewsource = yelpsvg;
                       } else if (data[index].type == "Google Places") {
                           reviewsource = googlesvg;
                       }
   
                       // for display avatar
                       var avatar = baseUrl+ '/public/images/avatardp.png';
   
                       // for display stars
                       var stars = '';
                       for (let starindex = 0; starindex < data[index].rating; starindex++) {
                           stars += '<span><i class="fa fa-star" style="color:#F7B707;"></i></span>';
                       }
   
                       // html
                       html += '<div class="col-md-12 shadow rounded p-3 mb-3">' +
                                   '<div class="row">' +
                                       '<div class="col-md-1">' +
                                           '<img src="'+avatar+'" alt="" class="rounded-circle" style="width:40px; height:40px;">' +
                                       '</div>' +
                                       '<div class="col-md-8">' +
                                           '<h4 class="author_font_color three-multi-review">' +
                                               data[index].reviewer +
                                           '</h4>' +
                                           '<div class="three-multi-review">' +
                                               stars +
                                           '</div>' +
                                           '<div class="three-multi-review date_color">' +
                                               '<p class="m-b-0">' +
                                                   data[index].review_date +
                                               '</p>' +
                                           '</div>' +
                                       '</div>' +
                                       '<div class="col-md-3">' +
                                           reviewsource +
                                       '</div>' +
                                       '<div class="col-md-12 m-t-5">' +
                                       '<div class="col-md-12 three-multi-review quote_font_color review-column">' +
                                           '<p>';
                                               html += data[index].message ? data[index].message : 'No review for this user.';
                                           html += '</p>' +
                                       '</div>' +
                                   '</div>' +
                               '</div>' +
                           '</div>';
   
                   } // end for loop
   
                   // appending html
                   $('#preview_card #list_widget .row').html(html);
   
                   // see more
                   $('.review-column p').fewlines({
                       lines: 4,
                       openMark: ' See More',
                       closeMark: ' See Less',
                       newLine: false,
                   });
   
                   break;
               case "Grid":
                   $('#grid_widget').show();
                   $("#grid_widget").siblings().hide();
   
                   // html intialize
                   var html = '';
   
                   // loop will iterate to number of reviews
                   for (let index = 0; index < data.length; index++) {
                       // for display reviewsource
                       var reviewsource = '';
                       if (data[index].type == "Tripadvisor") {
                           reviewsource =tripadvisorsvg;
                            //    '<span><i class="fab fa-tripadvisor text-right"></i></span>';
                       } else if (data[index].type == "Yelp") {
                           reviewsource = yelpsvg;
                       } else if (data[index].type == "Google Places") {
                           reviewsource = googlesvg;
                       }
   
                       // for display avatar
                       var avatar = baseUrl+ '/public/images/avatardp.png';
   
                       // for display stars
                       var stars = '';
                       for (let starindex = 0; starindex < data[index].rating; starindex++) {
                           stars += '<span><i class="fa fa-star" style="color:#F7B707;"></i></span>';
                       }
   
                       // html
                       html += '<div class="col-md-4 m-t-30">' +
                                   '<div class="p-3 shadow rounded mb-3">' +
                                       '<div class="row">' +
                                           '<div class="col-md-2 px-1">' +
                                               '<img src="'+avatar+'" alt="" class="rounded-circle" style="width:30px; height:30px;">' +
                                           '</div>' +
                                           '<div class="col-md-8 px-1 text-center">' +
                                               '<h4 class="author_font_color three-multi-review text-center">' +
                                                   data[index].reviewer +
                                               '</h4>' +
                                               '<div class="three-multi-review">' +
                                                   stars +
                                               '</div>' +
                                               '<div class="three-multi-review date_color">' +
                                                   '<p class="m-b-0">' +
                                                       data[index].review_date +
                                                   '</p>' +
                                               '</div>' +
                                           '</div>' +
                                           '<div class="col-md-2 px-1">' +
                                               reviewsource +
                                           '</div>' +
                                           '<div class="col-md-12 m-t-5">' +
                                               '<div class="col-md-12 three-multi-review quote_font_color review-column">' +
                                                   '<p>';
                                                       html += data[index].message ? data[index].message : 'No review for this user.';
                                                   html += '</p>' +
                                               '</div>' +
                                           '</div>' +
                                       '</div>' +
                                   '</div>' +
                               '</div>';
   
                   } // end for loop
   
                   // appending html
                   $('#preview_card #grid_widget .row').html(html);
   
                   // see more
                   $('.review-column p').fewlines({
                       lines: 4,
                       openMark: ' See More',
                       closeMark: ' See Less',
                       newLine: false,
                   });
                   break;
               case "SingleQuote":
                   $('#single_quote').show();
                   $("#single_quote").siblings().hide();
   
                   // html intialize
                   var html = '';
   
                   // loop will iterate to number of reviews
                   for (let index = 0; index < data.length; index++) {
                       // for display reviewsource
                       var reviewsource = '';
                       if (data[index].type == "Tripadvisor") {
                           reviewsource =tripadvisorsvg;
                            //    '<span><i class="fab fa-tripadvisor fa-2x text-right"></i></span>';
                       } else if (data[index].type == "Yelp") {
                           reviewsource = yelpsvg;
                       } else if (data[index].type == "Google Places") {
                           reviewsource = googlesvg;
                       }
   
                       // for display avatar
                       var avatar = baseUrl+ '/public/images/avatardp.png';
   
                       // for display stars
                       var stars = '';
                       for (let starindex = 0; starindex < data[index].rating; starindex++) {
                           stars += '<span><i class="fa fa-star" style="color:#F7B707;"></i></span>';
                       }
   
                       // html
                       html += '<div class="container rounded shadow mb-3 p-3">' +
                                   '<div class="row">'+
                                       '<div class="col-md-3 text-md-right">' +
                                           '<img src="'+ avatar +'"alt="" class="rounded-circle" style="width:40px; height:40px;">'+
                                       '</div>'+
                                       '<div class="col-md-6 text-md-center">'+
                                           '<h4 class="author_font_color three-multi-review">'+
                                               data[index].reviewer +
                                           '</h4>'+
                                           '<div class="three-multi-review">'+
                                               stars +
                                           '</div>'+
                                           '<div class="three-multi-review date_color">'+
                                               '<p>'+
                                                   data[index].review_date +
                                               '</p>'+ 
                                           '</div>'+
                                       '</div>'+
                                       '<div class="col-md-3 text-md-left">'+
                                           reviewsource +
                                       '</div>'+
                                       '<div class="col-md-12">'+
                                           '<div class="three-multi-review quote_font_color review-column">'+
                                               '<p> "';
                                                   html += data[index].message ? data[index].message : 'No review for this user.';
                                               html += '"</p>' +
                                           '</div>'+
                                       '</div>'+
                                   '</div>'+
                               '</div>';
   
                   } // end for loop
   
                   // appending html
                   $('#preview_card #single_quote').html(html);
   
                   // see more
                   $('.review-column p').fewlines({
                       lines: 4,
                       openMark: ' See More',
                       closeMark: ' See Less',
                       newLine: false,
                   });
   
                   break;
               case "Badge":
                   $('#badge_quote').show();
                   $("#badge_quote").siblings().hide();
   
                   // html intialize
                   var html = '';
                   var sumTripadvisor = 0;
                   var sumYelp = 0;
                   var sumGoogle = 0;
                   var totalTripadvisor = 0;
                   var totalYelp = 0;
                   var totalGoogle = 0;
                   
                   var ratings = [];
                   // loop will iterate to number of reviews
                   for (let index = 0; index < data.length; index++) {
                       
                       if (data[index].type == "Tripadvisor") {
                           totalTripadvisor++;
                           sumTripadvisor += parseInt( data[index].rating, 10 );
                       } else if (data[index].type == "Yelp") {
                           totalYelp++;
                           sumYelp += parseInt( data[index].rating, 10 );
                       } else if (data[index].type == "Google Places") {
                           totalGoogle++;
                           sumGoogle += parseInt( data[index].rating, 10 );
                       }
                       
                       
                   }
                   if (totalTripadvisor) {
                       var averageTripadvisor = sumTripadvisor/totalTripadvisor;
                           averageTripadvisor = averageTripadvisor.toFixed(1);
                   } else {
                       var averageTripadvisor = 'No Reviews found';
                   }
                   if (totalYelp) {
                       var averageYelp = sumYelp/totalYelp;
                           averageYelp = averageYelp.toFixed(1);
                   } else {
                       var averageYelp = 'No Reviews found';
                   }
                   if (totalGoogle) {
                       var averageGoogle = sumGoogle/totalGoogle;
                           averageGoogle = averageGoogle.toFixed(1);
                   } else {
                       var averageGoogle = 'No Reviews found';
                   }
                  
   
                   var averageTripadvisorCeil = Math.ceil(averageTripadvisor);
                   var averageYelpCeil = Math.ceil(averageYelp);
                   var averageGoogleCeil = Math.ceil(averageGoogle);
                   // for display stars
                       var starsTripadvisor = '';
                       for (let starindex = 0; starindex < averageTripadvisorCeil; starindex++) {
                           starsTripadvisor += '<span><i class="fa fa-star" style="color:#F7B707;"></i></span>';
                       }
                       var starsYelp = '';
                       for (let starindex = 0; starindex < averageYelpCeil; starindex++) {
                           starsYelp += '<span><i class="fa fa-star" style="color:#F7B707;"></i></span>';
                       }
                       var starsGoogle = '';
                       for (let starindex = 0; starindex < averageGoogleCeil; starindex++) {
                           starsGoogle += '<span><i class="fa fa-star" style="color:#F7B707;"></i></span>';
                       }
                   // var starsimage = "{{asset('public/images/5stars.jpg')}}";
                    tripadvisorsvg = '<img src="'+baseUrl+ '/public/plugins/fontawesome-5/svgs/brands/tripadvisor.svg'+'" style="width:24px; height:auto;" alt="tripadvisor">';
                    yelpsvg = '<img src="'+baseUrl+ '/public/plugins/fontawesome-5/svgs/brands/yelp.svg'+'" style="width:24px; height:auto;" alt="tripadvisor">';
                    googlesvg = '<img src="'+baseUrl+ '/public/plugins/fontawesome-5/svgs/brands/google.svg'+'" style="width:24px; height:auto;" alt="tripadvisor">';
                
                   html += 
                   '<div class="container-fluid">' +
                       '<div class="row">' +
                           '<div class="col-md-4">' +
                               '<div class="card shadow rounded">' +
                                   '<div class="card-body p-3">' +
                                       '<div>'+tripadvisorsvg+'<span style="font-size:20px;">Trip Advisor</span>'+'</div>'+
                                       '<h4>'+ averageTripadvisor +' '+ starsTripadvisor +'</h4>' +
                                       '<p>'+'Based on '+ totalTripadvisor +' reviews'+'</p>' +
                                   '</div>' +
                               '</div>' +
                           '</div>' +
                           '<div class="col-md-4">' +
                               '<div class="card shadow rounded">' +
                                   '<div class="card-body p-3">' +
                                       '<div>'+yelpsvg+'<span style="font-size:20px;">Yelp</span>'+'</div>'+
                                       '<h4>'+ averageYelp +' '+ starsYelp +'</h4>' +
                                       '<p>'+'Based on '+ totalYelp +' reviews'+'</p>' +
                                   '</div>' +
                               '</div>' +
                           '</div>' +
                           '<div class="col-md-4">' +
                               '<div class="card shadow rounded">' +
                                   '<div class="card-body p-3">' +
                                       '<div>'+googlesvg+'<span style="font-size:20px;">Google</span>'+'</div>'+
                                       '<h4>'+ averageGoogle +' '+ starsGoogle +'</h4>' +
                                       '<p>'+'Based on '+ totalGoogle +' reviews'+'</p>' +
                                   '</div>' +
                               '</div>' +
                           '</div>' +
                       '</div>' +
                   '</div>';
                   
                   // appending html
                   $('#preview_card #badge_quote').html(html);
   
   
                   break;
   
               default:
                   break;
           }
           // background color
           switch (widget.type) {
               case "Slider":
                   $('#preview_card').css("background-color", widget.background_color);
                   break;
               case "MultiSlider":
                   $('#preview_card #multislider_carousel > .carousel-inner > .carousel-item > .row > .col-md-4 > .shadow').css("background-color", widget.background_color);
                   break;
               case "List":
                   $('#preview_card #list_widget .row .col-md-12').css("background-color", widget.background_color);
                   break;
               case "Grid":
                   $('#preview_card #grid_widget .row .col-md-4 div').css("background-color", widget.background_color);
                   break;
               case "SingleQuote":
                   $('#preview_card #single_quote .container').css("background-color", widget.background_color);  
                   break;
               case "Badge":
                   $('#preview_card #badge_quote .col-md-4 .card').css("background-color", widget.background_color);
                   break;
                   
               default:
                   break;
           }
           $('#preview_card').css("font-family", widget.font_style);
           $('#preview_card .fa-star').css("color", widget.stars_color);
           $('#preview_card .author_font_color').css("color", widget.author_color);
           $('#preview_card .quote_font_color').css("color", widget.quote_color);
           $('#preview_card .date_color').css("color", widget.date_color);
   
        }).fail(function (error) { 
            // console.log(error);
            
         }).always(function (param) { 
            //  console.log('always');
            //  console.log(param);
             
             
          });
   
   }
};




// jquery
// font awesome
// bootstrap







  
      
// if (typeof jQuery!='undefined' && $.fn.tooltip.Constructor.VERSION == "4.1.3" && (css(span, 'font-family')) == 'FontAwesome') {
    // allReady();
    

// }



