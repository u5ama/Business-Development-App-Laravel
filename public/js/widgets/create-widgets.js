
 if (window.location.host == 'localhost') {
var baseUrl = 'http://localhost/trustyy';
     
 } else {
var baseUrl = 'https://app.trustyy.io';
     
 }

function copyClipBoard() {
    var copyText = document.getElementById("codetextarea");
    copyText.select();
    copyText.setSelectionRange(0, 99999)
    document.execCommand("copy");
    alert("Copied the text: " + copyText.value);
  }
function numberOfReviews(selected_widget_name) {

    if (selected_widget_name == 'SingleQuote' || selected_widget_name == 'Badge') {
        $('#number_of_reviews').attr( 'disabled', 'disabled' );
        $('#minimum_rating').attr( 'disabled', 'disabled' );
        $('#sort_review_by').attr( 'disabled', 'disabled' );
    } else {
        $('#number_of_reviews').removeAttr( "disabled" );
        $('#minimum_rating').removeAttr( "disabled" );
        $('#sort_review_by').removeAttr( "disabled" );
    }
    
    var number_of_reviews = $("#number_of_reviews").val();
    var minimum_rating = $("#minimum_rating").val();
    var sort_review_by = $('#sort_review_by').val();
    var trustyylogo = baseUrl+ '/public/images/brand/logo-black.png';
    var avatar = baseUrl+ '/public/images/avatardp.png';
    var tripadvisorpng = baseUrl+ '/public/images/apps/tripadvisor.png';
    var yelppng = baseUrl+ '/public/images/apps/yelp.png';
    var googleplacespng = baseUrl+ '/public/images/apps/googleplaces.png';
    var static_html = '<div class="card-body text-center">'+

                            '<div id="slider_carousel" class="carousel slide pb-5" data-ride="carousel"style="display: none">'+
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

                            '<div id="multislider_carousel" class="carousel slide pb-5" data-ride="carousel">'+
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

                            '<div id="list_widget">'+
                                '<div class="row">'+
                                        
                                '</div>'+
                            '</div>'+

                            '<div id="grid_widget">'+
                                '<div class="row">'+

                                '</div>'+
                            '</div>'+

                            '<div id="single_quote">'+
                                
                            '</div>'+

                            '<div id="badge_quote">'+

                            '</div>'+

                        '</div>';

                        console.log(selected_widget_name);
    $('#preview_card').html(static_html);
    $.get( baseUrl + "/numberOfReviews", {
        number_of_reviews: number_of_reviews,
        minimum_rating: minimum_rating,
        sort_review_by: sort_review_by,
        selected_widget_name: selected_widget_name

    }).done(function (data) {
        var selected_widget_name = $('.widget-selected').attr('data-value');
        console.log(selected_widget_name);

        switch (selected_widget_name) {
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
                        reviewsource =
                            '<span><i class="fab fa-tripadvisor text-right" style="border: 1px black solid;border-radius: 50%;padding: 2px;"></i></span>';
                    } else if (data[index].type == "Yelp") {
                        reviewsource = '<span><i class="fab fa-yelp text-right" style="border: 1px black solid;border-radius: 50%;padding: 2px;"></i></span>';
                    } else if (data[index].type == "Google Places") {
                        reviewsource = '<span><i class="fab fa-google text-right" style="border: 1px black solid;border-radius: 50%;padding: 2px;"></i></span>';
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
                                '<div class="container mb-3 p-4"><div class=" rounded shadow p-3">' +    
                                    '<div class="text-center">' +        
                                        '<img src="'+ avatar +'" alt="" class="rounded-circle"style=" width: 60px;height: 60px;position: relative;top: -40px;">' +            
                                        '<span style="position: relative; top: -15px;left: -15px;">' +
                                            reviewsource +
                                        '</span>' +             
                                    '</div>' +        
                                    '<div class="row">' +        
                                        '<div class="col-md-12">' +            
                                            '<div class="three-multi-review quote_font_color review-column text-center">' +                
                                                '<p> "';
                                                    html += data[index].message ? data[index].message : 'No review for this user.';
                                                    html += '"</p>' +
                                            '</div>' +                
                                        '</div>' +            
                                        '<div class="col-md-6 text-center text-md-left">' +            
                                            '<h4 class="author_font_color three-multi-review">'+
                                                data[index].reviewer +
                                            '</h4>'+
                                        '</div>' +            
                                        '<div class="col-md-6 text-center text-md-right">' +            
                                            '<div class="three-multi-review">' +                
                                                stars +                    
                                            '</div>' +                
                                        '</div>' +            
                                    '</div>' +        
                                         
                                '</div></div>' + // shadow div
                            '</div>';
                }
                var trustyylogofooter = '<div style="position: absolute;bottom: 10px;left: 45%;">' +        
                    '<img class="img-fluid" src="'+trustyylogo+'" style="height:28px;">'+
                '</div>';
                $('#preview_card .carousel-indicators').html(indicator);
                $('#preview_card .carousel-inner').html(html);
                $('#preview_card').append(trustyylogofooter);
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


                    console.log(index);
                    // for multi slider 
                    var col2 = index + 1;
                    var col3 = index + 2;
  
                    console.log(col2);
                    console.log(col3);

                    // for running slider
                    var slideTo = index + 1;
                    var isActive = (index == 0) ? 'active' : '';
                    indicator += '<li data-target="#multislider_carousel" data-slide-to="' + slideTo +
                        '" class="' +
                        isActive + '"></li>';

                    // for display reviewsource
                    var reviewsource = '';
                    if (data[index].type == "Tripadvisor") {
                        reviewsource =
                            '<span><i class="fab fa-tripadvisor text-right" style="border: 1px black solid;border-radius: 50%;padding: 2px;"></i></span>';
                    } else if (data[index].type == "Yelp") {
                        reviewsource = '<span><i class="fab fa-yelp text-right" style="border: 1px black solid;border-radius: 50%;padding: 2px;"></i></span>';
                    } else if (data[index].type == "Google Places") {
                        reviewsource = '<span><i class="fab fa-google text-right" style="border: 1px black solid;border-radius: 50%;padding: 2px;"></i></span>';
                    }

                    // for display avatar
                    var avatar = baseUrl+ '/public/images/avatardp.png';

                    // for display stars
                    var stars = '';
                    for (let starindex = 0; starindex < data[index].rating; starindex++) {
                        stars += '<span><i class="fa fa-star" style="color:#F7B707;"></i></span>';
                    }


                  
                    if (data[col2]) {
                        console.log('col2 if');
                      var  htmlcol2 = '<div class="col-md-4 m-t-30">' +
                        '<div class="container rounded shadow mb-3 p-3">' +    
                            '<div class="text-center">' +        
                                '<img src="'+ avatar +'" alt="" class="rounded-circle"style=" width: 60px;height: 60px;position: relative;top: -40px;">' +            
                                '<span style="position: relative; top: -15px;left: -15px;">' +
                                    reviewsource +
                                '</span>' +             
                            '</div>' +        
                            '<div class="row">' +  
                                '<div class="col-md-12 text-center">' +            
                                    '<h4 class="author_font_color three-multi-review">'+
                                        data[col2].reviewer +
                                    '</h4>'+
                                '</div>' +       
                                '<div class="col-md-12">' +            
                                    '<div class="three-multi-review quote_font_color review-column text-center">' +                
                                        '<p> "';
                                        htmlcol2 += data[col2].message ? data[col2].message : 'No review for this user.';
                                        htmlcol2 += '"</p>' +
                                    '</div>' +                
                                '</div>' +            
                                        
                                '<div class="col-md-12 text-center">' +            
                                    '<div class="three-multi-review">' +                
                                        stars +                    
                                    '</div>' +                
                                '</div>' +            
                            '</div>' +        
                                  
                        '</div>' + 
                    '</div>';


                    } else {
                        console.log('col2 else');
                        var htmlcol2 = '';
                    }
                    if (data[col3]) {
                        console.log('col3 if');
                        var htmlcol3 = '<div class="col-md-4 m-t-30">' +
                                        '<div class="container rounded shadow mb-3 p-3">' +    
                                            '<div class="text-center">' +        
                                                '<img src="'+ avatar +'" alt="" class="rounded-circle"style=" width: 60px;height: 60px;position: relative;top: -40px;">' +            
                                                '<span style="position: relative; top: -15px;left: -15px;">' +
                                                    reviewsource +
                                                '</span>' +             
                                            '</div>' +        
                                            '<div class="row">' +  
                                                '<div class="col-md-12 text-center">' +            
                                                    '<h4 class="author_font_color three-multi-review">'+
                                                        data[col3].reviewer +
                                                    '</h4>'+
                                                '</div>' +       
                                                '<div class="col-md-12">' +            
                                                    '<div class="three-multi-review quote_font_color review-column text-center">' +                
                                                        '<p> "';
                                                        htmlcol3 += data[col3].message ? data[col3].message : 'No review for this user.';
                                                        htmlcol3 += '"</p>' +
                                                    '</div>' +                
                                                '</div>' +            
                                                        
                                                '<div class="col-md-12 text-center">' +            
                                                    '<div class="three-multi-review">' +                
                                                        stars +                    
                                                    '</div>' +                
                                                '</div>' +            
                                            '</div>' +        
                                                   
                                        '</div>' + 
                                    '</div>';


                    } else {
                        console.log('col3 else');
                        var htmlcol3 = '';
                    }


                    // 
                    // carousel item
                    html += '<div class="carousel-item ' + isActive + '">' +
                    '<div class="row">' +
                        '<div class="col-md-4 m-t-30">' +
                            '<div class="container rounded shadow mb-3 p-3">' +    
                                '<div class="text-center">' +        
                                    '<img src="'+ avatar +'" alt="" class="rounded-circle"style=" width: 60px;height: 60px;position: relative;top: -40px;">' +            
                                    '<span style="position: relative; top: -15px;left: -15px;">' +
                                        reviewsource +
                                    '</span>' +             
                                '</div>' +        
                                '<div class="row">' +  
                                    '<div class="col-md-12 text-center">' +            
                                        '<h4 class="author_font_color three-multi-review">'+
                                            data[index].reviewer +
                                        '</h4>'+
                                    '</div>' +       
                                    '<div class="col-md-12">' +            
                                        '<div class="three-multi-review quote_font_color review-column text-center">' +                
                                            '<p> "';
                                                html += data[index].message ? data[index].message : 'No review for this user.';
                                                html += '"</p>' +
                                        '</div>' +                
                                    '</div>' +            
                                            
                                    '<div class="col-md-12 text-center">' +            
                                        '<div class="three-multi-review">' +                
                                            stars +                    
                                        '</div>' +                
                                    '</div>' +            
                                '</div>' +        
                                      
                            '</div>' + 
                        '</div>' +
                        htmlcol2 +
                        htmlcol3 +
                    '</div>' +
                    '</div>';
                    // 

                } // end for loop
                var trustyylogofooter = '<div style="position: absolute;bottom: 10px;left: 45%;">' +        
                    '<img class="img-fluid" src="'+trustyylogo+'" style="height:28px;">'+
                '</div>';
                // appending html
                $('#preview_card .carousel-indicators').html(indicator);
                $('#preview_card .carousel-inner').html(html);
                $('#preview_card').append(trustyylogofooter);
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
                        reviewsource =
                            '<span><i class="fab fa-tripadvisor text-right" style="border: 1px black solid;border-radius: 50%;padding: 2px;"></i></span>';
                    } else if (data[index].type == "Yelp") {
                        reviewsource = '<span><i class="fab fa-yelp text-right" style="border: 1px black solid;border-radius: 50%;padding: 2px;"></i></span>';
                    } else if (data[index].type == "Google Places") {
                        reviewsource = '<span><i class="fab fa-google text-right" style="border: 1px black solid;border-radius: 50%;padding: 2px;"></i></span>';
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
                                '<div class="container rounded shadow mb-3 p-3">' +    
                                    '<div class="text-center">' +        
                                        '<img src="'+ avatar +'" alt="" class="rounded-circle"style=" width: 60px;height: 60px;position: relative;top: -40px;">' +            
                                        '<span style="position: relative; top: -15px;left: -15px;">' +
                                            reviewsource +
                                        '</span>' +             
                                    '</div>' +        
                                    '<div class="row">' +  
                                        '<div class="col-md-12 text-center">' +            
                                            '<h4 class="author_font_color three-multi-review">'+
                                                data[index].reviewer +
                                            '</h4>'+
                                        '</div>' +       
                                        '<div class="col-md-12">' +            
                                            '<div class="three-multi-review quote_font_color review-column text-center">' +                
                                                '<p> "';
                                                    html += data[index].message ? data[index].message : 'No review for this user.';
                                                    html += '"</p>' +
                                            '</div>' +                
                                        '</div>' +            
                                                
                                        '<div class="col-md-12 text-center">' +            
                                            '<div class="three-multi-review">' +                
                                                stars +                    
                                            '</div>' +                
                                        '</div>' +            
                                    '</div>' +        
                                        
                                '</div>' + 
                            '</div>'+
                            '<div class="col-md-8"></div>';
                    // old
                    // html += '<div class="col-md-12 m-t-30 shadow rounded p-3">' +
                    //             '<div class="row">' +
                    //                 '<div class="col-md-1">' +
                    //                     '<img src="'+avatar+'" alt="" class="rounded-circle" style="width:40px; height:40px;">' +
                    //                 '</div>' +
                    //                 '<div class="col-md-8">' +
                    //                     '<h4 class="author_font_color three-multi-review">' +
                    //                         data[index].reviewer +
                    //                     '</h4>' +
                    //                     '<div class="three-multi-review">' +
                    //                         stars +
                    //                     '</div>' +
                    //                     '<div class="three-multi-review date_color">' +
                    //                         '<p class="m-b-0">' +
                    //                             data[index].review_date +
                    //                         '</p>' +
                    //                     '</div>' +
                    //                 '</div>' +
                    //                 '<div class="col-md-3">' +
                    //                     reviewsource +
                    //                 '</div>' +
                    //                 '<div class="col-md-12 m-t-5">' +
                    //                 '<div class="col-md-12 three-multi-review quote_font_color review-column">' +
                    //                     '<p>';
                    //                         html += data[index].message ? data[index].message : 'No review for this user.';
                    //                     html += '</p>' +
                    //                 '</div>' +
                    //             '</div>' +
                    //         '</div>' +
                    //         '<div class="text-center">'+
                    //             '<img class="img-fluid" src="'+trustyylogo+'" style="height:28px;">'+
                    //         '</div>'+
                    //     '</div>';

                } // end for loop

                // appending html
                var trustyylogofooter = '<div style="position: absolute;bottom: 10px;left: 45%;">' +        
                        '<img class="img-fluid" src="'+trustyylogo+'" style="height:28px;">'+
                    '</div>';
                $('#preview_card #list_widget .row').html(html + trustyylogofooter);

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
                        reviewsource =
                            '<span><i class="fab fa-tripadvisor text-right" style="border: 1px black solid;border-radius: 50%;padding: 2px;"></i></span>';
                    } else if (data[index].type == "Yelp") {
                        reviewsource = '<span><i class="fab fa-yelp text-right" style="border: 1px black solid;border-radius: 50%;padding: 2px;"></i></span>';
                    } else if (data[index].type == "Google Places") {
                        reviewsource = '<span><i class="fab fa-google text-right" style="border: 1px black solid;border-radius: 50%;padding: 2px;"></i></span>';
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
                                '<div class="container rounded shadow mb-3 p-3">' +    
                                    '<div class="text-center">' +        
                                        '<img src="'+ avatar +'" alt="" class="rounded-circle"style=" width: 60px;height: 60px;position: relative;top: -40px;">' +            
                                        '<span style="position: relative; top: -15px;left: -15px;">' +
                                            reviewsource +
                                        '</span>' +             
                                    '</div>' +        
                                    '<div class="row">' +  
                                        '<div class="col-md-12 text-center">' +            
                                            '<h4 class="author_font_color three-multi-review">'+
                                                data[index].reviewer +
                                            '</h4>'+
                                        '</div>' +       
                                        '<div class="col-md-12">' +            
                                            '<div class="three-multi-review quote_font_color review-column text-center">' +                
                                                '<p> "';
                                                    html += data[index].message ? data[index].message : 'No review for this user.';
                                                    html += '"</p>' +
                                            '</div>' +                
                                        '</div>' +            
                                                
                                        '<div class="col-md-12 text-center">' +            
                                            '<div class="three-multi-review">' +                
                                                stars +                    
                                            '</div>' +                
                                        '</div>' +            
                                    '</div>' +        
                                         
                                '</div>' + 
                            '</div>';
                    // old
                    // html += '<div class="col-md-4 m-t-30">' +
                    //             '<div class="p-3 shadow rounded">' +
                    //                 '<div class="row">' +
                    //                     '<div class="col-md-2 px-1">' +
                    //                         '<img src="'+avatar+'" alt="" class="rounded-circle" style="width:30px; height:30px;">' +
                    //                     '</div>' +
                    //                     '<div class="col-md-8 px-1 text-center">' +
                    //                         '<h4 class="author_font_color three-multi-review text-center">' +
                    //                             data[index].reviewer +
                    //                         '</h4>' +
                    //                         '<div class="three-multi-review">' +
                    //                             stars +
                    //                         '</div>' +
                    //                         '<div class="three-multi-review date_color">' +
                    //                             '<p class="m-b-0">' +
                    //                                 data[index].review_date +
                    //                             '</p>' +
                    //                         '</div>' +
                    //                     '</div>' +
                    //                     '<div class="col-md-2 px-1">' +
                    //                         reviewsource +
                    //                     '</div>' +
                    //                     '<div class="col-md-12 m-t-5">' +
                    //                         '<div class="col-md-12 three-multi-review quote_font_color review-column">' +
                    //                             '<p>';
                    //                                 html += data[index].message ? data[index].message : 'No review for this user.';
                    //                             html += '</p>' +
                    //                         '</div>' +
                    //                     '</div>' +
                    //                 '</div>' +
                    //                 '<div class="text-center">'+
                    //                     '<img class="img-fluid" src="'+trustyylogo+'" style="height:28px;">'+
                    //                 '</div>'+
                    //             '</div>' +
                    //         '</div>';

                } // end for loop
                var trustyylogofooter = '<div style="position: absolute;bottom: 10px;left: 45%;">' +        
                        '<img class="img-fluid" src="'+trustyylogo+'" style="height:28px;">'+
                    '</div>'; 
                // appending html
                $('#preview_card #grid_widget .row').html(html+trustyylogofooter);

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
                        reviewsource =
                            '<i class="fab fa-tripadvisor text-right" style="border: 1px black solid;border-radius: 50%;padding: 2px;"></i>';
                    } else if (data[index].type == "Yelp") {
                        reviewsource = '<i class="fab fa-yelp text-right" style="border: 1px black solid;border-radius: 50%;padding: 2px;"></i>';
                    } else if (data[index].type == "Google Places") {
                        reviewsource = '<i class="fab fa-google text-right" style="border: 1px black solid;border-radius: 50%;padding: 2px;"></i>';
                    }

                    // for display avatar
                    var avatar = baseUrl+ '/public/images/avatardp.png';

                    // for display stars
                    var stars = '';
                    for (let starindex = 0; starindex < data[index].rating; starindex++) {
                        stars += '<span><i class="fa fa-star" style="color:#F7B707;"></i></span>';
                    }

                    // '<div id="single_quote" class="mt-5">' + 
                    html += '<div class="container rounded shadow mb-3 p-3">' +    
                                '<div class="text-center">' +        
                                    '<img src="'+ avatar +'" alt="" class="rounded-circle"style=" width: 60px;height: 60px;position: relative;top: -40px;">' +            
                                    '<span style="position: relative; top: -15px;left: -15px;">' +
                                        reviewsource +
                                    '</span>' +             
                                '</div>' +        
                                '<div class="row">' +        
                                    '<div class="col-md-12">' +            
                                        '<div class="three-multi-review quote_font_color review-column text-center">' +                
                                            '<p> "';
                                                html += data[index].message ? data[index].message : 'No review for this user.';
                                                html += '"</p>' +
                                        '</div>' +                
                                    '</div>' +            
                                    '<div class="col-md-6 text-center text-md-right">' +            
                                        '<h4 class="author_font_color three-multi-review">'+
                                            data[index].reviewer +
                                        '</h4>'+
                                    '</div>' +            
                                    '<div class="col-md-6 text-center text-md-left">' +            
                                        '<div class="three-multi-review">' +                
                                            stars +                    
                                        '</div>' +                
                                    '</div>' +            
                                '</div>' +        
                                       
                            '</div>';   
                    // '</div>';

                    // old
                    // html += '<div class="container rounded shadow mb-3 p-3">' +
                    //             '<div class="row">'+
                    //                 '<div class="col-md-3 text-md-right">' +
                    //                     '<img src="'+ avatar +'"alt="" class="rounded-circle" style="width:40px; height:40px;">'+
                    //                 '</div>'+
                    //                 '<div class="col-md-6 text-md-center">'+
                    //                     '<h4 class="author_font_color three-multi-review">'+
                    //                         data[index].reviewer +
                    //                     '</h4>'+
                    //                     '<div class="three-multi-review">'+
                    //                         stars +
                    //                     '</div>'+
                    //                     '<div class="three-multi-review date_color">'+
                    //                         '<p>'+
                    //                             data[index].review_date +
                    //                         '</p>'+ 
                    //                     '</div>'+
                    //                 '</div>'+
                    //                 '<div class="col-md-3 text-md-left">'+
                    //                     reviewsource +
                    //                 '</div>'+
                    //                 '<div class="col-md-12">'+
                    //                     '<div class="three-multi-review quote_font_color review-column">'+
                    //                         '<p> "';
                    //                             html += data[index].message ? data[index].message : 'No review for this user.';
                    //                         html += '"</p>' +
                    //                     '</div>'+
                    //                 '</div>'+
                    //             '</div>'+
                    //             '<div class="text-center">'+
                    //                 '<img class="img-fluid" src="'+trustyylogo+'" style="height:28px;">'+
                    //             '</div>'+
                    //         '</div>';

                } // end for loop

                // appending html
                var trustyylogofooter = '<div style="position: absolute;bottom: 10px;left: 45%;">' +        
                        '<img class="img-fluid" src="'+trustyylogo+'" style="height:28px;">'+
                    '</div>';
                $('#preview_card #single_quote').html(html + trustyylogofooter);

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
                    // var averageTripadvisor = 'No Reviews found';
                    var averageTripadvisor = 0;
                }
                if (totalYelp) {
                    var averageYelp = sumYelp/totalYelp;
                        averageYelp = averageYelp.toFixed(1);
                } else {
                    // var averageYelp = 'No Reviews found';
                    var averageYelp = 0;
                }
                if (totalGoogle) {
                    var averageGoogle = sumGoogle/totalGoogle;
                        averageGoogle = averageGoogle.toFixed(1);
                } else {
                    // var averageGoogle = 'No Reviews found';
                    var averageGoogle = 0;
                }
                console.log(averageTripadvisor);
                console.log(averageYelp);
                console.log(averageGoogle);

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


                if (averageTripadvisor >= averageYelp && averageTripadvisor > averageGoogle) {
                    html += 
                '<div class="container-fluid">' +
                    '<div class="row">' +

                        '<div class="col-md-10 m-auto">' +
                            '<div class="card shadow rounded m-auto" style="max-width: 300px;">' +
                                '<div class="card-body p-3">' +
                                    '<div>'+'<span><img class="img-fluid" src="'+tripadvisorpng+'" style="height:28px;"></span><span style="font-size:20px;">Trip Advisor</span>'+'</div>'+
                                    '<h4>'+ averageTripadvisor +' '+ starsTripadvisor +'</h4>' +
                                    '<p style="margin-bottom: 0px;">'+'Based on '+ totalTripadvisor +' reviews'+'</p>' +
                                '</div>' +
                                '<div class="card-footer text-center p-2">'+
                                    '<img class="img-fluid" src="'+trustyylogo+'" style="height:28px;">'+
                                '</div>'+
                            '</div>' +
                        '</div>' +

                    '</div>' +
                '</div>';
                } else if (averageYelp > averageTripadvisor && averageYelp > averageGoogle) {
                    html += 
                '<div class="container-fluid">' +
                    '<div class="row">' +
                        
                        '<div class="col-md-10 m-auto">' +
                            '<div class="card shadow rounded m-auto" style="max-width: 300px;">' +
                                '<div class="card-body p-3">' +
                                    '<div>'+'<span><img class="img-fluid" src="'+yelppng+'"></span><span style="font-size:20px;">Yelp</span>'+'</div>'+
                                    '<h4>'+ averageYelp +' '+ starsYelp +'</h4>' +
                                    '<p style="margin-bottom: 0px;">'+'Based on '+ totalYelp +' reviews'+'</p>' +
                                '</div>' +
                                '<div class="card-footer text-center p-2">'+
                                    '<img class="img-fluid" src="'+trustyylogo+'" style="height:28px;">'+
                                '</div>'+
                            '</div>' +
                        '</div>' +
                        
                    '</div>' +
                '</div>';
                } else {
                    html += 
                    '<div class="container-fluid">' +
                        '<div class="row">' +
                         
                            '<div class="col-md-10 m-auto">' +
                                '<div class="card shadow rounded m-auto" style="max-width: 300px;">' +
                                    '<div class="card-body p-3">' +
                                        '<div>'+'<span><img class="img-fluid" src="'+googleplacespng+'"></span><span style="font-size:20px;">Google</span>'+'</div>'+
                                        '<h4>'+ averageGoogle +' '+ starsGoogle +'</h4>' +
                                        '<p style="margin-bottom: 0px;">'+'Based on '+ totalGoogle +' reviews'+'</p>' +
                                    '</div>' +
                                    '<div class="card-footer text-center p-2">'+
                                        '<img class="img-fluid" src="'+trustyylogo+'" style="height:28px;">'+
                                    '</div>'+
                                '</div>' +
                            '</div>' +

                        '</div>' +
                    '</div>';
                }

                
                
                // appending html
                $('#preview_card #badge_quote').html(html);


                break;

            default:
                break;
        }
        console.log(data);
        console.log(data.length);

    }).fail(function (error) {
        console.log(error);

    });
}
$(document).ready(function () {

    // number_of_reviews
    var number_of_reviews = $("#number_of_reviews");
    var number_of_reviews_preview = $("#number_of_reviews_preview");
    number_of_reviews_preview.text(number_of_reviews.val());

    $("#number_of_reviews").change(function () {
        var number_of_reviews_preview = $("#number_of_reviews_preview");
        number_of_reviews_preview.text(number_of_reviews.val());
        var selected_widget_name = $('.widget-selected').attr('data-value');
        numberOfReviews(selected_widget_name);
    });


    // minimum_rating
    var minimum_rating = $("#minimum_rating");
    var minimum_rating_preview = $("#minimum_rating_preview");
    minimum_rating_preview.text(minimum_rating.val());

    $("#minimum_rating").change(function () {
        var minimum_rating_preview = $("#minimum_rating_preview");
        minimum_rating_preview.text(minimum_rating.val());
        var selected_widget_name = $('.widget-selected').attr('data-value');
        numberOfReviews(selected_widget_name);
    });

    // sort_review_by
    $("#sort_review_by").change(function () {
        var selected_widget_name = $('.widget-selected').attr('data-value');
        numberOfReviews(selected_widget_name);
    });

    $("#font_style").change(function () {
        $('#preview_card').css("font-family", this.value);
        console.log(this.value);
        console.log($('#preview_card').css('font-family'));

    });

    // background_color

    $("#background_color").change(function () {
        $('#background_color_text').val(this.value);
        var selected_widget_name = $('.widget-selected').attr('data-value');
        console.log(selected_widget_name);
        switch (selected_widget_name) {
            case "Slider":
                $('#preview_card #slider_carousel .shadow').css("background-color", this.value);
                break;
            case "MultiSlider":
                $('#preview_card #multislider_carousel > .carousel-inner > .carousel-item > .row > .col-md-4 > .shadow').css("background-color", this.value);
                break;
            case "List":
                $('#preview_card #list_widget .shadow').css("background-color", this.value);
                break;
            case "Grid":
                $('#preview_card #grid_widget .row .col-md-4 div').css("background-color", this.value);
                break;
            case "SingleQuote":
                $('#preview_card #single_quote .container').css("background-color", this.value);  
                break;
            case "Badge":
                $('#preview_card #badge_quote .col-md-10 .card').css("background-color", this.value);
                $('#preview_card #badge_quote .col-md-10 .card .card-footer').css("background-color", this.value);
                
                break;
                
            default:
                break;
        }

    });
    $("#background_color_text").change(function () {
        $('#background_color').val(this.value);
    });
    // star_color

    $("#star_color").change(function () {
        $('#star_color_text').val(this.value);
        $('#preview_card .fa-star').css("color", this.value);
    });
    $("#star_color_text").change(function () {
        $('#star_color').val(this.value);
    });
    // author_font_color

    $("#author_font_color").change(function () {
        $('#author_font_color_text').val(this.value);
        $('#preview_card .author_font_color').css("color", this.value);
    });
    $("#author_font_color_text").change(function () {
        $('#author_font_color').val(this.value);
    });
    // quote_font_color

    $("#quote_font_color").change(function () {
        $('#quote_font_color_text').val(this.value);
        $('#preview_card .quote_font_color').css("color", this.value);
    });
    $("#quote_font_color_text").change(function () {
        $('#quote_font_color').val(this.value);
    });
    // date_color
    $("#date_color_text").change(function () {
        $('#date_color').val(this.value);
    });
    $("#date_color").change(function () {
        $('#date_color_text').val(this.value);
        $('#preview_card .date_color').css("color", this.value);
    });
    $('#widget_name').focusout(function (param) {

        if ($('#widget_name').val()) {
            $('#WidgetTypeContainer').show();
            $('.widget-type').click(function (param) {
                var selected_widget_name = $('.widget-selected').attr('data-value');
                console.log(param.currentTarget.attributes[1].value);
                numberOfReviews(param.currentTarget.attributes[1].value);
                // SelectedWidgetType = e.g Slider || Grid
                var widget_name = $('#widget_name').val();
                // var widget_type = param.currentTarget.attributes[1].nodeValue;
                $('.widget-type').removeClass("widget-selected");

                var widget_type = $(this).addClass("widget-selected");
                var selected_widget_name = $('.widget-selected').attr('data-value');
                switch (selected_widget_name) {
                    case "Slider":
                        $('#slider_carousel').show();
                        $("#slider_carousel").siblings().hide();

                        break;
                    case "MultiSlider":
                        $('#multislider_carousel').show();
                        $("#multislider_carousel").siblings().hide();

                        break;
                    case "List":
                        $('#list_widget').show();
                        $("#list_widget").siblings().hide();

                        break;
                    case "Grid":
                        $('#grid_widget').show();
                        $("#grid_widget").siblings().hide();

                        break;
                    case "SingleQuote":
                        $('#single_quote').show();
                        $("#single_quote").siblings().hide();

                        break;
                    case "Badge":
                        $('#badge_quote').show();
                        $("#badge_quote").siblings().hide();

                        break;

                    default:
                        break;
                }
                
                $('#WidgetSettingPreviewContainer').show();
                $('#createWidget').show();
            });

            // show embeded code
            $('#createWidget').click(function (param) {
                $('#WidgetEmbededCodeContainer').show();
            });

        }
    });

    $('#createWidget').click(function (event) {
        // event.preventDefault();
        console.log('createWidget');

        var widget_name = $('#widget_name').val();
        var widget_type = $('.widget-selected').attr('data-value');
        console.log(widget_type);

        // number_of_reviews minimum_rating sort_review_by schema_markup 
        var number_of_reviews = $('#number_of_reviews').val();
        var minimum_rating = $('#minimum_rating').val();
        var sort_review_by = $('#sort_review_by').val();
        var schema_markup = 0;
        $('#schema_markup').click(function (param) {
            if ($('#schema_markup:checked').val()) {
                var schema_markup = $('#schema_markup:checked').val();
            } else {
                var schema_markup = 0;
            }
        });

        // font_style background_color star_color author_font_color quote_font_color
        var font_style = $('#font_style').val();
        var background_color = $('#background_color').val();
        var star_color = $('#star_color').val();
        var author_font_color = $('#author_font_color').val();
        var quote_font_color = $('#quote_font_color').val();
        var date_color = $('#date_color').val();
        var token = $('input[name="_token"]').val();
        showPreloader();
        $.post( baseUrl + "/createNewWidget", {
                _token: token,
                widget_name: widget_name,
                widget_type: widget_type,
                number_of_reviews: number_of_reviews,
                minimum_rating: minimum_rating,
                sort_review_by: sort_review_by,
                schema_markup: schema_markup,
                font_style: font_style,
                background_color: background_color,
                star_color: star_color,
                author_font_color: author_font_color,
                quote_font_color: quote_font_color,
                date_color: date_color

            }).done(function (data) {
                hidePreloader();
                console.log(data);
                var embed_code = '<div id="preview_card" class="card"></div><script id="widget_script" type="text/javascript" src="'+baseUrl+'/public/js/widgets/show-widget.js?id='+data.id+'"></script>';
                
                $('#codetextarea').val(embed_code);
                swal({
                    title: "Successful!",
                    text: 'Widget created successfully',
                    type: "success"
                }, function () {

                });
            })
            .fail(function (error) {
                hidePreloader();
                var errors = error.responseJSON.errors;
                $.each(errors, function( index, value ) {
                    console.log(index + ": " + value);
                    // console.log(a);
                    swal({
                        title: "OOPS!",
                        text: value,
                        type: "error"
                    }, function () {

                    });
                    
                    return false;
                  });
                console.error(error.responseJSON.errors);
                
            });
    });

    $('#settingWidgetButton').click(function (event) {
        console.log('settingForm');
        var widget_name = $('#widget_name').val();
        var widget_type = $('.widget-selected').attr('data-value');
        // number_of_reviews minimum_rating sort_review_by schema_markup 
        var number_of_reviews = $('#number_of_reviews').val();
        var minimum_rating = $('#minimum_rating').val();
        var sort_review_by = $('#sort_review_by').val();
        var schema_markup = 0;
        $('#schema_markup').click(function (param) {
            if ($('#schema_markup:checked').val()) {
                var schema_markup = $('#schema_markup:checked').val();
            } else {
                var schema_markup = 0;
            }
        });
        showPreloader();
        var token = $('input[name="_token"]').val();
        $.post( baseUrl + "/widgetSetting", {
                _token: token,
                widget_name: widget_name,
                widget_type: widget_type,
                number_of_reviews: number_of_reviews,
                minimum_rating: minimum_rating,
                sort_review_by: sort_review_by,
                schema_markup: schema_markup

            }).done(function (data) {
                hidePreloader();
                console.log(data);
                if (data != 0) {
                    swal({
                        title: "Successful!",
                        text: 'Widget Setting updated successfully',
                        type: "success"
                    }, function () {

                    });
                } else {
                    swal({
                        title: "OOPS!",
                        text: 'First Create Widget',
                        type: "error"
                    }, function () {

                    });
                }
            })
            .fail(function (error) {
                hidePreloader();
                var errors = error.responseJSON.errors;
                console.error(error.responseJSON.errors);
                swal({
                    title: "OOPS!",
                    text: error.statusText,
                    type: "error"
                }, function () {

                });

            });
    });

    $('#themeWidgetButton').click(function (event) {
        console.log('themeForm');
        var widget_name = $('#widget_name').val();
        var widget_type = $('.widget-selected').attr('data-value');
        // font_style background_color star_color author_font_color quote_font_color
        var font_style = $('#font_style').val();
        var background_color = $('#background_color').val();
        var star_color = $('#star_color').val();
        var author_font_color = $('#author_font_color').val();
        var quote_font_color = $('#quote_font_color').val();
        var date_color = $('#date_color').val();
        var token = $('input[name="_token"]').val();
        showPreloader();
        
        $.post( baseUrl + "/widgetTheme", {
                _token: token,
                widget_name: widget_name,
                widget_type: widget_type,
                font_style: font_style,
                background_color: background_color,
                star_color: star_color,
                author_font_color: author_font_color,
                quote_font_color: quote_font_color,
                date_color: date_color

            }).done(function (data) {
                hidePreloader();
                console.log(data);
                if (data != 0) {
                    swal({
                        title: "Successful!",
                        text: 'Widget Theme updated successfully',
                        type: "success"
                    }, function () {

                    });
                } else {
                    swal({
                        title: "OOPS!",
                        text: 'First Create Widget',
                        type: "error"
                    }, function () {

                    });
                }
            })
            .fail(function (error) {
                hidePreloader();
                var errors = error.responseJSON.errors;
                console.error(error.responseJSON.errors);
                swal({
                    title: "OOPS!",
                    text: error.statusText,
                    type: "error"
                }, function () {

                });
            });
    });
});
