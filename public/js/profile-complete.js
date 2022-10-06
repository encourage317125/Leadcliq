    
    function showNextStep(current, formToSend, loading){
        if(formToSend == undefined){
            $('#step' + current).toggle('slide', { direction:'left' }, 'slow', function(){
                $('#step' + (current + 1)).toggle('slide', { direction:'right' }, 'slow');
            });
        }else{
            //hide warning message on next input
            var $form = $('#'+formToSend).bind('input',function(){
                $('.fill-all').hide();
            });

            var requiredFieldsFilled = true;

            $form.find('input[required], .required').each(function (){
                var $this = $(this);
                var typeaheadData = $this.typeahead('val');
                if (!$this.val() && !typeaheadData && $this.attr('name')){ //BUG: make sure name is set because selector is
                    $('.fill-all').fadeIn('slow');
                    requiredFieldsFilled = false;
                    return false;
                }
            });

            //todo: make sure min length is reached

            if (requiredFieldsFilled){
                $('.fill-all').hide();

                ajaxSubmit(formToSend, loading, function(){
                    $('#step' + current).toggle('slide', { direction:'left' }, 'slow', function(){
                        $('#step' + (current + 1)).toggle('slide', { direction:'right' }, 'slow', function(){
                            if(current == 2){
                                //custom step functionality here
                            }
                        });
                    });
                });
            }
        }
    }

    function showPrevStep(current){
        $('#step' + current).toggle('slide', { direction:'right' }, 'slow', function(){
            $('#step' + (current - 1)).toggle('slide', { direction:'left' }, 'slow');
        });
    }

    $( function () {

    /* ====================  SELECTIZER.JS PLUGIN CUSTOMIZATION ===================== */

        var Selectizer = function() {

            return {
                loadOptions: function(query, callback) {
                
                    var selectize = this;
                    var url = selectize.settings.remoteUrl;
                    
                    if (selectize.settings.initData === true) { 
                        url = selectize.settings.initUrl; // If first time; load the Init URL
                    } else {
                        if (query.length < 2) return callback();
                    }
                    
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            keyword: query,
                            items_limit: 10,
                        },
                        error: function() {
                            console.log('error');
                            callback();
                        },
                        success: function(res) {
                            callback(res);
                            //console.log(res);

                            if (selectize.settings.initData === true) { // If it's the first time
                                var type = Object.prototype.toString.call(res);
                                //console.log('Type: ' + type);
                                
                                if( type == "[object Object]") {
                                    console.log('Single item');
                                    selectize.addOption(JSON.stringify(res)); // Add an option to the select.
                                    selectize.addItem(res.id); // Tell selectize that this new option is selected. 
                                } else { // Array
                                    for (var key in res) {
                                        var obj = res[key];
                                        selectize.addOption(JSON.stringify(obj)); // Add an option to the select.
                                        selectize.addItem(obj.id); // Tell selectize that this new option is selected. 
                                    }
                                }
                                selectize.settings.initData = false; // Next load won't be the first init one. 
                            }
                        }
                    });
                },

                createOption: function(input) {

                    if (!input.length) return false;

                    var selectize = this;
                    var url = selectize.settings.createUrl;

                    var newId, newName, newSuccess = false;
                    
                    $.ajax({
                        url: url,
                        type: 'POST',
                        async: false,
                        dataType: 'json',
                        data: {
                            name: input,
                        },
                        error: function() {
                            console.log('error');
                        },
                        success: function(res) {
                            //console.log(res);
                            
                            newSuccess = true;
                            newId = res.id;
                            newName = res.name;
                        }
                    });

                    if( newSuccess ) {
                        return {
                            id: newId,
                            name: newName
                        }
                    }

                    return false;
                },

                renderTemplate: {

                    item: function (item, escape) {
                        return '<div>' + (item.name ? '<span class="name">' + escape(item.name) + '</span>' : '') + '</div>';
                    },
                    option: function (item, escape) {
                        return '<div>' + '<span class="label">' + escape(item.name) + '</span>' + '</div>';
                    }
                },

                typeEventHandler: function (str) {

                    if( !str.length ) {
                        selectizer = this;
                        selectizer.close();
                    }
                },

                closeEventHandler: function(){
                    selectizer = this;
                    selectizer.close();
                },
            }

        }();

        /* ------------  CUSTOMIZATION END ------------ */

    /* ====================  Complete Profile : STEP 2 ===================== */

        $('#currentCompany').selectize({

            dropdownParent: 'body',
            delimiter: '\r',
            valueField: 'id',
            labelField: 'name',
            searchField: ['name'],
            initData: false,
            remoteUrl: '/companies',
            initUrl: '',
            createUrl: '/companies',

            onType: Selectizer.typeEventHandler,
            render: Selectizer.renderTemplate,
            create: Selectizer.createOption,
            load: Selectizer.loadOptions
        });

        $('#currentTitle').selectize({

            dropdownParent: 'body',
            delimiter: '\r',
            valueField: 'id',
            labelField: 'name',
            searchField: ['name'],
            initData: false,
            remoteUrl: '/titles',
            initUrl: '',
            createUrl: '/titles',

            onType: Selectizer.typeEventHandler,
            render: Selectizer.renderTemplate,
            create: Selectizer.createOption,
            load: Selectizer.loadOptions
        });

        $('#currentIndustry').selectize({

            dropdownParent: 'body',
            delimiter: '\r',
            valueField: 'id',
            labelField: 'name',
            searchField: ['name'],
            initData: false,
            remoteUrl: '/industries',
            initUrl: '',
            createUrl: '/industries',

            onType: Selectizer.typeEventHandler,
            render: Selectizer.renderTemplate,
            create: Selectizer.createOption,
            load: Selectizer.loadOptions
        });

        $('#companiesWorkedWith').selectize({

            plugins: ['remove_button'],
            persist: false,
            preload: true,
            maxItems: 3,
            delimiter: '\r',
            valueField: 'id',
            labelField: 'name',
            searchField: ['name'],
            initData: true,
            remoteUrl: '/companies',
            initUrl: '/companies_worked_with',
            createUrl: '/companies',
            options: [],
            
            onType: Selectizer.typeEventHandler,
            onItemAdd: Selectizer.closeEventHandler,
            render: Selectizer.renderTemplate,
            create: Selectizer.createOption,
            load: Selectizer.loadOptions
        });

        $('#offersServices').selectize({

            plugins: ['remove_button'],
            persist: false,
            preload: true,
            maxItems: 3,
            delimiter: '\r',
            valueField: 'id',
            labelField: 'name',
            searchField: ['name'],
            initData: true,
            remoteUrl: '/services',
            initUrl: '/offers_services',
            createUrl: '/services',
            options: [],

            onType: Selectizer.typeEventHandler,
            onItemAdd: Selectizer.closeEventHandler,
            render: Selectizer.renderTemplate,
            create: Selectizer.createOption,
            load: Selectizer.loadOptions
        });

    /* ====================  Complete Profile : STEP 3 ===================== */


        $('#seekingTitles').selectize({

            plugins: ['remove_button'],
            persist: false,
            preload: true,
            maxItems: 3,
            delimiter: '\r',
            valueField: 'id',
            labelField: 'name',
            searchField: ['name'],
            initData: true,
            remoteUrl: '/titles',
            initUrl: '/seeking_titles',
            createUrl: '/titles',
            options: [],

            onType: Selectizer.typeEventHandler,
            onItemAdd: Selectizer.closeEventHandler,
            render: Selectizer.renderTemplate,
            create: Selectizer.createOption,
            load: Selectizer.loadOptions
        });

        $('#targetIndustries').selectize({

            plugins: ['remove_button'],
            persist: false,
            preload: true,
            maxItems: 3,
            delimiter: '\r',
            valueField: 'id',
            labelField: 'name',
            searchField: ['name'],
            initData: true,
            remoteUrl: '/industries',
            initUrl: '/target_industries',
            createUrl: '/industries',
            options: [],

            onType: Selectizer.typeEventHandler,
            onItemAdd: Selectizer.closeEventHandler,
            render: Selectizer.renderTemplate,
            create: Selectizer.createOption,
            load: Selectizer.loadOptions 
        });

        $('#networksWithTitles').selectize({

            plugins: ['remove_button'],
            persist: false,
            preload: true,
            maxItems: 3,
            delimiter: '\r',
            valueField: 'id',
            labelField: 'name',
            searchField: ['name'],
            initData: true,
            remoteUrl: '/titles',
            initUrl: '/networks_with_titles',
            createUrl: '/titles',
            options: [],

            onType: Selectizer.typeEventHandler,
            onItemAdd: Selectizer.closeEventHandler,
            render: Selectizer.renderTemplate,
            create: Selectizer.createOption,
            load: Selectizer.loadOptions
        });

        $('#complementaryServices').selectize({

            plugins: ['remove_button'],
            persist: false,
            preload: true,
            maxItems: 3,
            delimiter: '\r',
            valueField: 'id',
            labelField: 'name',
            searchField: ['name'],
            initData: true,
            remoteUrl: '/services',
            initUrl: '/complementary_services',
            createUrl: '/services',
            options: [],

            onType: Selectizer.typeEventHandler,
            onItemAdd: Selectizer.closeEventHandler,
            render: Selectizer.renderTemplate,
            create: Selectizer.createOption,
            load: Selectizer.loadOptions
        });

    });