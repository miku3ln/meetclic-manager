// Class to represent a row in the questions grid
function Field(data) {
    var self = this;
    self.id = data.id;
    self.label = ko.observable(data.label);
    self.description = ko.observable(data.description);
    self.weight = ko.observable(data.weight);
    self.field_type = data.field_type;
    self.allowOptions = data.allowOptions;
    self.fieldOptions = ko.observableArray();
    self.deletedFieldOptions = ko.observableArray();
    self.availableWidgets = ko.observableArray(data.availableWidgets);
    self.widget_type = ko.observable(data.widget_type);
    self.availableValidations = ko.observableArray(data.availableValidations);
    self.validations = ko.observableArray(data.validations);
    self.showValidations = ko.observable(false);
    self.showDescription = ko.observable(false);
    self.formated_type = ko.computed(function () {
        switch (self.field_type) {
            case '1':
                return 'Text';
                break;
            case '1':
                return 'Text';
                break;
            case '2':
                return 'Simple Choice';
                break;
            case '3':
                return 'Multiple Choice';
                break;
            case '4':
                return 'Boolean';
                break;
            case '5':
                return 'Date';
                break;
            case '6':
                return 'Rating';
                break;
            default:
                break;
        }
    });

    // Operations
    self.toggleValidations = function () {
        self.showValidations(!self.showValidations());
    }
    self.toggleDescription = function () {
        self.showDescription(!self.showDescription());
    }
    self.updateOptionPosition = function () {
        var i = 0;
        ko.utils.arrayForEach(self.fieldOptions(), function (fieldOption) {
            fieldOption.weight(i++);
        });
    }
    self.addOption = function () {

        self.fieldOptions.push(new Option([]));
        self.updateOptionPosition();
    }
    self.removeOption = function (option) {
        self.fieldOptions.remove(option);
        if (option.id) self.deletedFieldOptions.push(option);
        self.updateOptionPosition();
    }
}

