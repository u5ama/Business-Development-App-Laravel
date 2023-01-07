            // Function to remove array element
            function removeA(arr) {
                console.log(arr);
                
                var what, a = arguments, L = a.length, ax;
                while (L > 1 && arr.length) {
                    what = a[--L];
                    while ((ax= arr.indexOf(what)) !== -1) {
                        arr.splice(ax, 1);
                    }
                }
                return arr;
            }
            function updatedBulkDeleteButton(widgetsListTable){
                var noOfSelectedRows= window.selectedWidgetsIndexes.length;
                if(noOfSelectedRows!=0){
                    $("#delete_widgets_button").removeClass('hide').addClass('show-inline-block');
                    $("#delete_widgets_button").parent().removeClass('hide').addClass('show-inline-block');
                    //$("#num_selected_records").text(noOfSelectedRows);
                }
                else{
                    $("#delete_widgets_button").removeClass('show-inline-block').addClass('hide');
                    $("#delete_widgets_button").parent().removeClass('show-inline-block').addClass('hide');
                    //$("#num_selected_records").text('0');
                }
            }

            function deleteWidget(widgetID,widgetsListTable){
                var baseUrl = $('#hfBaseUrl').val();
                showPreloader();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    type: "GET",
                    url:  baseUrl + "/delete-widget?widgetID="+widgetID,
                    success: function (response, status) {
                        console.log(response);
                        var statusCode = response._metadata.outcomeCode;
                        var statusMessage = response._metadata.outcome;
                        var message = response._metadata.message;
                        var errors = response.errors;
                        var records = response.records;

                        if(statusCode==200){

                            // var dataTablePageInfo = widgetsListTable.page.info();
                            // var arrayCheck=Array.isArray(widgetID);
                            // console.log(arrayCheck);
                            // if(arrayCheck==true){
                            //     $.each(widgetID, function (index, value) {
                            //         widgetsListTable.row('[data-widget-id="'+value+'"]').remove().draw();
                            //     });
                            // }
                            // else{
                            //     widgetsListTable.row('[data-widget-id="'+widgetID+'"]').remove().draw();
                            // }

                            $('#widgets-list thead tr th:eq(0)').removeClass('selected');
                            widgetsListTable.rows().deselect();
                            window.selectedWidgetsIndexes=[];
                            updatedBulkDeleteButton(widgetsListTable);

                            // var currentDataTablePageInfo = widgetsListTable.page.info();
                            // if(dataTablePageInfo.pages==currentDataTablePageInfo.pages){
                            //     widgetsListTable.page(dataTablePageInfo.page).draw( 'page' );
                            // }

                            // widgetsListTable.draw();

                            // $("#total_widgets").text(currentDataTablePageInfo.recordsTotal);

                            swal({
                                title: "",
                                text: message,
                                type: 'success',
                                allowOutsideClick: false,
                                html: true,
                                showCancelButton: false,
                                confirmButtonColor: '#8CD4F5',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'OK',
                                cancelButtonText: "Cancel",
                                closeOnConfirm: true,
                                closeOnCancel: true
                            },function(){
                                swal.close();
                                showPreloader();
                                location.reload();
                            });
                        }
                        else{
                            if(errors.length!=0) {
                                $.each(errors, function (index, value) {
                                    toastr.error(value.message);
                                })
                            }
                            else{
                                swal({
                                    title: "",
                                    text: message,
                                    type: 'error',
                                    allowOutsideClick: false,
                                    html: true,
                                    showCancelButton: false,
                                    confirmButtonColor: '#8CD4F5 ',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'OK',
                                    cancelButtonText: "Cancel",
                                    closeOnConfirm: true,
                                    closeOnCancel: true
                                });
                            }
                        }
                        hidePreloader();
                    },
                    error: function (data, status) {
                        swal({
                            title: "",
                            text: "OOPs! Something went wrong...",
                            type: 'error',
                            allowOutsideClick: false,
                            html: true,
                            showCancelButton: false,
                            confirmButtonColor: '#8CD4F5 ',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'OK',
                            cancelButtonText: "Cancel",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        });
                        hidePreloader();
                    }
                })
            }
            function copyClipBoard() {
                
                var copyShowEmbedCodeTextarea = document.getElementById('showEmbedCodeTextarea');
                copyShowEmbedCodeTextarea.select();
                copyShowEmbedCodeTextarea.setSelectionRange(0, 99999)
                document.execCommand("copy");
                
                // alert("Copied the text: \n" + copyShowEmbedCodeTextarea.value);
                
            }
            function showEmbedCode(param) { 
                var copyText = document.getElementById("textarea-"+param);
                document.getElementById('showEmbedCodeTextarea').value = copyText.value;
            }
        var baseUrl = $('#hfBaseUrl').val();
        console.log(baseUrl);
        var typingTimer; //timer identifier
        var doneTypingInterval = 500;
        window.selectedWidgetsIndexes=[];

        $(document).ready(function () {
            localStorage.removeItem("selectedCheckboxes");
            window.selectedWidgetsIDs=[];
            function saveCheckboxesState(){
                var indexes=widgetsListTable.rows({selected: true}).toArray()[0];
                console.log('indexes');
                console.log(indexes);
                if(indexes.length !=0){
                    var rowData = widgetsListTable.rows( indexes ).data().toArray();
                    // window.selectedWidgetsIDs=[];
                    $.each(rowData, function (index, value) {
                        var actionsRow=rowData[index];
                        var widgetID=actionsRow.id;
                        if (window.selectedWidgetsIDs.indexOf(widgetID) === -1){
                            window.selectedWidgetsIDs.push(widgetID);
                        }
                    });
                    console.log(window.selectedWidgetsIDs);
                    localStorage.setItem( 'selectedCheckboxes', JSON.stringify( window.selectedWidgetsIDs ) );
                }
                else
                {
                    console.log("else");
                    // setTimeout(function () {
                    //     $(".dataTables_processing").hide();
                    // },300);
                }
            }
            function getCheckboxesState(){
                var x = localStorage.getItem("selectedCheckboxes");
                if(x){
                    var xyz=JSON.parse(x);
                    console.log(xyz);
                    $.each(xyz, function (index, value) {
                        widgetsListTable.row("[data-widget-id='"+value+"']").select();
                    });
                }
            }

            var height=$('body').height()-150;
            console.log(height);
            let widgetsListTable =$('#widgets-list').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 150,
                lengthChange: true,
                // lengthMenu: [[10, 20, 50, 100], ['10 Rows', '25 Rows', '50 Rows', '100 Rows']],
                searching: true,
                ordering: true,

                "order": [[ 5, "desc" ]],
                info: true,
                language: {
                    emptyTable: "Widgets not found.",
                    paginate: {
                        first: "First",
                        previous: "<i class='fa fa-caret-left'></i>",
                        next: "<i class='fa fa-caret-right'></i>",
                        last:  "Last"
                    },
                    "lengthMenu": "_MENU_ ",
                    "info": "_START_ to _END_ of _TOTAL_",
                    "infoEmpty": "0 of 0",
                    "infoFiltered":  "",
                    "loadingRecords": '<img class="web-loader" src="'+baseUrl+'/public/images/transparent_loader.gif" style="display: table; width: 48px; margin: 0px auto;">',
                    processing: '<img class="web-loader" src="'+baseUrl+'/public/images/transparent_loader.gif" style="display: table; width: 48px; margin: 0px auto;">'
                },
                columnDefs: [
                    { "orderable": false, "targets": 0 },
                    { "orderable": false, "targets": 3 },
                    { "orderable": false, "targets": 5 },
                    {
                        orderable: false,
                        className: 'select-checkbox',
                        targets: 0
                    }
                ],
                
                select: {
                    style: 'multi',
                    selector: 'td:first-child' //td:first-child //tr td.select
                },
                //dom: '<"top"i>rt<"bottom"flp><"clear">'
                //dom: '<"wrapper"ipt>',
                dom: '<"pagination-container"iptr>',
                ajax: baseUrl + "/widgetsList",
                "columns": [
                    { "data": "extra" },
                    { "data": "name" },
                    { "data": "type" },
                    { "data": "id",
                        render: function ( data, type, row ) {
                            return ('<button onclick="showEmbedCode('+ row.id +')" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#showEmbedCodeModal" type="button">Show Embed Code</button><textarea class="form-control" id="textarea-'+row.id+'" data-id="'+row.id+'" style="display:none; width:100%;height:80px" placeholder="Emded code here"><div id="preview_card" class="card"></div><script id="widget_script" type="text/javascript" src="'+ baseUrl  +'/public/js/widgets/show-widget.js?id='+row.id+'"></script></textarea>');
                        } 
                    },
                    { "data": "created_at" },
                    { "data": "extra" }
                ],
                drawCallback: function( settings ) {
                    console.log("full");
                    console.log(settings);
                    
                    var data=settings.json.data;
                    console.log('data =>');

                    console.log(data);

                    var rows= $("#widgets-list tbody tr");

                    var checkEmptyRow=rows[0];
                    var flag=$(checkEmptyRow).find('td:eq(0)').hasClass('dataTables_empty');

                    console.log('checkEmptyRow');
                    
                    console.log($(checkEmptyRow).find('td:eq(0)'));
                    
                    console.log(flag);
                    if(!flag){
                        $.each(rows, function( index, value ) {
                            console.log('index');
                            console.log(index);
                            console.log('value');
                            console.log(value);
                           
                            var widgetRecord=data[index];
                            var name=$(value).find('td:eq(1)').html();
                            console.log('name');
                            console.log(name);
                            
                            $(value).attr('data-widget-id',widgetRecord.id);

                            // if(name!=''){
                            //     var arr_name = name.split(" ");
                            //     if(arr_name.length==1){
                            //         var name_symbol = arr_name[0].substr(0, 1);
                            //     }
                            //     else{
                            //         var first_chr = arr_name[0].substr(0, 1);
                            //         var second_chr = arr_name[1].substr(0, 1);
                            //         var name_symbol=first_chr+second_chr;
                            //     }
                            //     var name_symbol=name_symbol.toUpperCase();
                            //     var widget_name_icon_visibility='';
                            // }
                            // else{
                            //     var name_symbol='NA';
                            //     var widget_name_icon_visibility='widget-name-icon-hide';
                            // }

                            // var widgetNameIconColorClass=generateIconColor();
                            // var temp="<div class='widget-name-icon "+widgetNameIconColorClass+" "+widget_name_icon_visibility+"'>"+
                            //     String(name_symbol) +
                            //     "</div>"+
                            //     String(name);
                            // $(value).find('td:eq(1)').html(String(name));
                            var temp2='<div class="actions-container">\n' +
                                // '   <a class="widget-edit-button" data-widget-id="'+widgetRecord.id+'"><i class="mdi mdi-pencil" aria-hidden="true"></i></a>\n' +
                                '   <a class="widget-delete-button" data-widget-id="'+widgetRecord.id+'"><i class="fas fa-trash-alt icon1" aria-hidden="true"></i></a>\n' +
                                ' </div>';



                                if($('#page-wrapper').hasClass('crm-widgets-list')){
                                    $(value).find('td:eq(5)').html('');
                                }
                                else{
                                    $(value).find('td:eq(5)').html(temp2);
                                }
                                $(value).find('td:eq(0)').css({'width':'5%'});
                                $(value).find('td:eq(1)').css({'width':'15%'});
                                $(value).find('td:eq(2)').css({'width':'10%'});
                                $(value).find('td:eq(3)').css({'width':'40%'});
                                $(value).find('td:eq(4)').css({'width':'10%'});
                                $(value).find('td:eq(5)').css({'width':'20%'});
                                $(value).find('td:eq(3),td:eq(4),td:eq(5)').addClass('text-verticle-align');
                               
                        });
                        $("#total_widgets").text(settings.json.recordsFiltered);
                    }
                    else{
                        // $("#total_widgets").text('0');
                    }

                    var val=$('#searchRecords').val();
                    if(val==''){
                        // $('.widgets-header').text('Patients List');
                        $('.widgets-header').text('widgets List');
                        $('#total_widgets_text').text(' Total widgets');
                        $('.closeSearch').addClass('hide');
                        $('span.search-user').next().addClass('hide');
                        $('span.search-user').next().next().addClass('hide');
                        $('span.search-user').removeClass('hide');
                    }
                    else{
                        $('.widgets-header').text('Search Results');
                        $('#total_widgets_text').text(' Matches');
                    }

                    getCheckboxesState();
                },
                scrollY: height,
                scrollX: false,
                scroller: {
                    // loadingIndicator: true
                }
            }); // widgets-list

            $('#searchRecords').on( 'keyup', function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(function(){
                    var val=$('#searchRecords').val();
                    $('.closeSearch').removeClass('hide');
                    console.log('val');
                    console.log(val);
                    widgetsListTable.search( val ).draw();
                }, doneTypingInterval);
            } );

            $('.closeSearch').on('click',function (e){
                $('#searchRecords').val('');
                $('span.search-user').next().addClass('hide');
                // $('span.search-user').next().next().addClass('hide');
                $('span.search-user').removeClass('hide');
                widgetsListTable.search('').draw();
            });

            widgetsListTable.on( 'search.dt', function () {
                console.log("search");
                saveCheckboxesState();
            } );


            $(".dataTables_scrollHead table").on("click", "th.select-checkbox", function() {
                if ($("th.select-checkbox").hasClass("selected")) {  //De Select All
                    widgetsListTable.rows().deselect();
                    $("th.select-checkbox").removeClass("selected");

                    window.selectedWidgetsIndexes=[];
                    updatedBulkDeleteButton(widgetsListTable);
                    console.log(window.selectedWidgetsIndexes);

                    window.selectedWidgetsIDs=[];
                    localStorage.removeItem("selectedCheckboxes");

                    console.log(window.selectedWidgetsIDs);
                }
                else {
                    if ($('#page-wrapper').hasClass('crm-widgets-list')) {
                        var rows = widgetsListTable.rows().nodes().to$();
                        $.each(rows, function(a,i) {
                            var checkClass=$(i).find('td:eq(0)').hasClass('disabled-checkbox');
                            if(checkClass==false){
                                var widgetID=$(i).attr('data-widget-id');
                                widgetsListTable.row('[data-widget-id="'+widgetID+'"]').select();
                            }
                        });
                    }
                    else{
                        widgetsListTable.rows().select();             //Select All
                    }

                    $("th.select-checkbox").addClass("selected");

                    window.selectedWidgetsIndexes=[];
                    var indexes=widgetsListTable.rows({selected: true}).toArray()[0];
                    console.log(indexes);

                    var info = widgetsListTable.page.info();
                    //indexes=indexes.slice(info.page*info.length,(info.page+1)*info.length);

                    window.selectedWidgetsIndexes=indexes;
                    updatedBulkDeleteButton(widgetsListTable);
                    console.log(window.selectedWidgetsIndexes);

                    console.log(window.selectedWidgetsIDs);
                }
            });


            widgetsListTable.on( 'select', function ( e, dt, type, indexes ) {
                console.log("on select");
                console.log(e);
                console.log(dt);
                console.log(type);
                console.log(indexes);
                
                if (type === 'row') {
                    var rows = widgetsListTable.rows(indexes).nodes().to$();
                    var widgetID=$(rows[0]).attr('data-widget-id');
                    var checkClass=$(rows[0]).find('td:eq(0)').hasClass('disabled-checkbox');
                    if(checkClass==false){
                        if (widgetsListTable.rows({selected: true}).count() !== widgetsListTable.rows().count()) {
                            $("th.select-checkbox").removeClass("selected");
                        }
                        else {
                            $("th.select-checkbox").addClass("selected");
                        }
                        console.log(indexes[0]);
                        
                        window.selectedWidgetsIndexes.push(indexes[0]);
                        console.log( window.selectedWidgetsIndexes.push(indexes[0]));
                        
                        updatedBulkDeleteButton(widgetsListTable);
                        saveCheckboxesState();
                    }
                    else{
                        widgetsListTable.row('[data-widget-id="'+widgetID+'"]').deselect();
                    }
                }
            } ).on( 'deselect', function ( e, dt, type, indexes ) {
                console.log("on dselect");
                if (type === 'row') {
                    var rows = widgetsListTable.rows(indexes).nodes().to$();
                    var widgetID=$(rows[0]).attr('data-widget-id');
                    var checkClass=$(rows[0]).find('td:eq(0)').hasClass('disabled-checkbox');
                    if(checkClass==false){
                        if (widgetsListTable.rows({selected: true}).count() !== widgetsListTable.rows().count()) {
                            $("th.select-checkbox").removeClass("selected");
                        }
                        else {
                            $("th.select-checkbox").addClass("selected");
                        }

                        removeA(window.selectedWidgetsIndexes, indexes[0]);
                        updatedBulkDeleteButton(widgetsListTable);

                        var rowData = widgetsListTable.rows( indexes ).data().toArray();
                        $.each(rowData, function (index, value) {
                            var actionsRow=rowData[index];
                            var widgetID=actionsRow.id;
                            removeA(window.selectedWidgetsIDs, String(widgetID));
                        });
                        if(window.selectedWidgetsIDs.length==0){
                            localStorage.removeItem("selectedCheckboxes");
                        }
                        saveCheckboxesState();
                    }
                }
            } );


            $("select[name='widgets-list_length']").addClass('form-control');
            $("select[name='widgets-list_length']").css({
                'width':'150px',
                'font-size':'14px',
                'font-weight': 500,
                'border-radius': '5px'
            });

            
            var dataTables_info_element=$(".dataTables_info");

            $(".dataTables_scrollHead table thead th:eq(6) #info_cont").html( dataTables_info_element);
            //$(".dataTables_scrollHead table thead th:eq(5) #pagination_cont").html( element);

            $(".dataTables_scrollHead table thead th:eq(0)").removeClass('sorting_asc').addClass('sorting_disabled');



            $(document).on('click',"#delete_widgets_button",function () {
                if(window.selectedWidgetsIndexes.length==0){
                    swal({
                        title: "",
                        text: "No widget(s) are selected...",
                        type: 'error',
                        allowOutsideClick: false,
                        html: true,
                        showCancelButton: false,
                        confirmButtonColor: '#8CD4F5 ',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK',
                        cancelButtonText: "Cancel",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    });
                    return false;
                }
                var rowData = widgetsListTable.rows( window.selectedWidgetsIndexes ).data().toArray();
                window.selectedWidgetsIDs=[];
                $.each(rowData, function (index, value) {
                    var actionsRow=rowData[index];
                    // var deleteColumn=$($(actionsRow[5])[0]).find('.delete-button');
                    // var widgetID=$(deleteColumn[0]).attr('data-widget-id');
                    var widgetID=actionsRow.id;
                    window.selectedWidgetsIDs.push(widgetID);
                });
                // console.log(window.selectedWidgetsIDs);

                var noOfSelectedRows= window.selectedWidgetsIDs.length;
                var str= noOfSelectedRows>1? ' these '+noOfSelectedRows+' selected widgets?' : 'this selected widget?';

                var strTitle= noOfSelectedRows>1? 'Are you sure you want to delete these widgets?': 'Are you sure you want to delete this widget?';
                var strText= noOfSelectedRows>1? "Deleting these widgets will delete everything associated with them.": "Deleting this contact will delete everything associated with it.";

                swal({
                    title: strTitle,
                    text: strText,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#ff6666",
                    confirmButtonText: "Yes, delete!"
                }, function (isConfirm) {
                    if(isConfirm){
                        var widgetID=window.selectedWidgetsIDs;
                        // console.log(widgetID);
                        if(typeof(widgetID)=='undefined' || widgetID=='null' || widgetID==null || widgetID==''){
                            swal({
                                title: "",
                                text: "OOPs! Something went wrong...",
                                type: 'error',
                                allowOutsideClick: false,
                                html: true,
                                showCancelButton: false,
                                confirmButtonColor: '#8CD4F5 ',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'OK',
                                cancelButtonText: "Cancel",
                                closeOnConfirm: true,
                                closeOnCancel: true
                            });
                            return false;
                        }
                        deleteWidget(widgetID,widgetsListTable);
                    }
                    else{
                        swal.close();
                    }
                });
            });

            $(document).on('click',".widget-delete-button",function () {
                var element=$(this);
                swal({
                    title: "Are you sure you want to delete this widget?",
                    text: "Deleting this widget will delete everything associated with it.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#ff6666",
                    confirmButtonText: "Yes, delete!"
                }, function (isConfirm) {
                    if(isConfirm){
                        var widgetID=element.attr('data-widget-id');
                        console.log(widgetID);
                        if(typeof(widgetID)=='undefined' || widgetID=='null' || widgetID==null || widgetID==''){
                            swal({
                                title: "",
                                text: "OOPs! Something went wrong...",
                                type: 'error',
                                allowOutsideClick: false,
                                html: true,
                                showCancelButton: false,
                                confirmButtonColor: '#8CD4F5 ',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'OK',
                                cancelButtonText: "Cancel",
                                closeOnConfirm: true,
                                closeOnCancel: true
                            });
                            return false;
                        }
                        deleteWidget(widgetID,widgetsListTable);
                    }
                    else{
                        swal.close();
                    }
                });
            });

        }); // jquery ready ends here
        // 
