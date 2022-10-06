function checkListingMassUploadHeaders(){
  
    var required = [
        'listing_type',                
        'listing_title',
        'company_id',
        'zip',
        'address'
    ];
    
    var requiredName = [
        'Listing Type',                
        'Title',
        'Company Id',
        'Zip',
        'Street Address'
    ];
    
     var contactRequired = [
        'contact_name',
        'contact_email',        
    ];
    
    var contactRequiredName = [
        'Contact Name',
        'Contact Email',        
    ];
    
   
    var ins = document.forms["mass-upload-form"].getElementsByTagName("select");
    
    var present = [];
    for ( var i in ins) {
        if(ins[i].selectedIndex != undefined){
            present.push(ins[i].options[ins[i].selectedIndex].value);
        }
    }
    
    for ( var i in required) {
        if($.inArray(required[i], present) == -1){
            document.getElementById('mass-upload-error').innerHTML = 'The required column <strong>' + requiredName[i] + '</strong> has not been selected yet.';
            return false;
        }
    }
    
    for ( var i in contactRequired) {
        if($.inArray(contactRequired[i], present) == -1){
            document.getElementById('mass-upload-error').innerHTML = 'The required column <strong>' + contactRequiredName[i] + '</strong> has not been selected yet.';
            return false;
        }
    }
    
    
    return true;
}
