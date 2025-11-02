export const CUSTOMER = {
    first_name: '',
    last_name: '',
    payer_email: '',
    manager_id: '',
};
export default class {
    customerData = null;

    constructor(customerData) {
        this.customerData = customerData;
        console.log(customerData);
    }

    get getCustomer() {
        var result = this.getUserCurrentInformation['Customer'];
        return result;
    }

    get getUserCurrentInformation() {
        var allowViewDataCustomer = Object.keys(this.customerData).length > 0;
        var first_name = allowViewDataCustomer ? this.customerData['Customer']['first_name'] : '';
        var last_name = allowViewDataCustomer ? this.customerData['Customer']['last_name'] : '';
        var payer_email = allowViewDataCustomer ? this.customerData['Customer']['payer_email'] : '';
        var manager_id = allowViewDataCustomer ? this.customerData['Customer']['manager_id'] : null;

        var result = {
            success: allowViewDataCustomer,
            Customer: {
                first_name: first_name,
                last_name: last_name,
                payer_email: payer_email,
                manager_id: manager_id
            }
        };

        return result;
    }


}

