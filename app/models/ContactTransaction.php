<?php

class ContactTransaction extends Eloquent {

    protected $guarded = array();

    /**
     * When an item it's given for free, means no cost is involved for neither of them.
     * After this, the item looses all it's value.  
     */
    public static $CONTACT_PUBLIC = 0;
    
    /**
     * When an item it's given for free, means no cost is involved for neither of them.
     * After this, the item looses all it's value.
     */
    public static $CONTACT_PRIVATE = 1;
    
    /**
     * Sell/Buy operation a contact or an appointment.
     */
    public static $CONTACT_SOLD = 2;
    
    /**
     * Sell/Buy operation a contact or an appointment.
     */
    public static $CONTACT_FOR_SELL = 3;

    /**
     * The buyer has initiated a dispute over a bought contact
     */
    public static $CONTACT_DISPUTED = 4;

    /**
     * The dispute has been closed by admin
     */
    public static $CONTACT_DISPUTE_CLOSED = 5;

    /**
     * The contact is for sell in the Open Market
     */
    public static $SELL_IN_OPEN_MARKET = 1;

    public function getReadable(){
       switch ($this->operation) {
            case ContactTransaction::$CONTACT_FOR_SELL:
                return 'Contact put for sale';
            break;
                
            case ContactTransaction::$CONTACT_SOLD:
                return 'Contact sold';
            break;
            
            case ContactTransaction::$CONTACT_PUBLIC:
                return 'Contact made public';
            break;

            case ContactTransaction::$CONTACT_PRIVATE:
                return 'Contact put in private mode';
            break;
            
            case ContactTransaction::$CONTACT_DISPUTED:
                return 'Open new dispute';
            break;

            case ContactTransaction::$CONTACT_DISPUTE_CLOSED:
                return 'Close dispute';
            break;

            default:
                return 'Unkown operation';
            break;
        }
    }

    public function contact($id) {
    	$contact = Contact::findOrFail($id);
	    return $contact;
    }
    
    public function getContact() {
        return Contact::findOrFail($this->contact_id);
    }

}