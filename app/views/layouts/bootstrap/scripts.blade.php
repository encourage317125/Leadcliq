  

<script>

/**
 * START ANGULAR CODE
 * todo: This should be separated out into multiple files
 */

   
/**
 * START jQUERY CODE
 * todo: this should be switched to angular if possible
 */

$('.header-menu li').hover(function (){
	$('.header-menu li a').removeClass('active');
	$(this).children('a').addClass('active');
	$('.submenu').hide();
	submenu = $(this).attr('data-submenu');		
	$('#'+submenu).show();		
});

$('header').mouseleave(function() {
	showSubmenu();
});

$('#img-open-file').change(function() {
	$('#update-image-form').submit();
});

$('.phoneinput').mask("(999) 999-9999");

$( "#zip" ).keyup(function(e) {
    var zip = $( "#zip" ).val();
    if (zip.length === 5){
        getCity($( "#zip" ).val());
    }
});

$('#datepicker').datepicker({
	numberOfMonths : 1,
	showOtherMonths: true,
	selectOtherMonths: true,
	dateFormat : 'mm/dd/yy'		
});

$('.tablesorter').tablesorter();
$('.tablepaginator').tablePagination();



$(document).ready(function(){

//    $('input[name="services_provide"]').tagsinput('input').typeahead({
//            prefetch: '/companies'
//        }).bind('typeahead:selected', $.proxy(function (obj, datum) {
//            this.tagsinput('add', datum.value);
//            this.tagsinput('input').typeahead('setQuery', '');
//        }, $('input')));

	showSubmenu();
	showOpportDetails();
	showNameDrop();

	$('#session-message').toggle('highlight', {color: '#FFDEAD'}, 'slow');
	
	var errors = '';
	$('.error').each(function(index){
		errors += $( this ).text() + '<br>';
	});

	if(errors != ''){
		$('#modal-body').html(errors);
		$('#modal-title').html('Plase review this errors and try again');
		$('#modal-window').modal('show');
	}

	activateFronEndValidations();

    /**
     * BALANCED CREDIT CARD PROCESSING
     * todo: Move this!
     * @type {boolean}
     */
    var submittedToBalance = false;

    function handleCCResponse(response) {
        submittedToBalance = true;
        var $form = $('form#addCard');

        //on success
        if (response.status_code === 201) {

            //add URI (ID we recieve from Balanced) to form
            $form.find('[name="uri"]').val(response.cards[0].href);

            //User inputs whole card number. remove all but last four digits to send to our backend
            var card = $form.find('[name="last_four"]').val();
            var lastFour = card.substr(card.length-4,card.length);
            $form.find('[name="last_four"]').val(lastFour);

            //submit form like normal
            $form.submit();

        }

        //on error
        else {
            //flag for resubmission
            submittedToBalance = false;

            //add error message
            $('#addCardError').remove();
            var $error = $('<p id="addCardError" class="alert alert-warning">Unable to add credit card. Please check your details.</p>').prependTo($form);
            $form.on('input',function(){
                $error.remove();
            })
        }
    }

    //submit form to BalancedAPI
    $('#cc-submit').click(function (e) {
        if (submittedToBalance) return;
        e.preventDefault();

        var payload = {
            name: $('#cc-name').val(),
            number: $('#cc-number').val(),
            expiration_month: $('#cc-ex-month').val(),
            expiration_year: $('#cc-ex-year').val(),
            security_code: $('#ex-csc').val()
        };

        // Create credit card
        balanced.card.create(payload, handleCCResponse);
    });

    /**
     * BALANCED BANK ACCOUNT PROCESSING
     * TODO: move this!
     * @type {boolean}
     */

    submittedToBalance = false;

    function handleBAResponse(response) {
        submittedToBalance = true;
        var $form = $('form#addAccount');

        //on success
        if (response.status_code === 201) {

            //add URI (ID we recieve from Balanced) to form
            $form.find('[name="uri"]').val(response.bank_accounts[0].href);

            //don't submit routing number to our server (for security)
            $form.find('#ba-routing').remove();

            //submit form like normal
            $form.submit();

        }

        //on error
        else {
            //flag for resubmission
            submittedToBalance = false;

            //add error message
            $('#addAccountError').remove();
            var $error = $('<p id="addAccountError" class="alert alert-warning">Unable to add bank account. Please check your details.</p>').prependTo($form);
            $form.on('input',function(){
                $error.remove();
            })
        }
    }

    //submit form to BalancedAPI
    $('#ba-submit').click(function (e) {
        if (submittedToBalance) return;
        e.preventDefault();

        var payload = {
            name: $('#ba-name').val(),
            routing_number: $('#ba-routing').val(),
            account_number: $('#ba-number').val()
        };

        // Create credit card
        balanced.bankAccount.create(payload, handleBAResponse);
    });

});
</script>
 

