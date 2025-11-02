// Class to represent a row in the sections grid
var elementTypes = {
    "text": {value: 1, text: 'Textfield'},
    "radioButton": {value: 2, text: 'Radio Buttons'},
    "checkbox": {value: 3, text: 'Checkboxes'},
    "boolean": {value: 4, text: "Valores Verdaderos"},
    "date": {value: 5, text: 'Date '},
    "rating": {value: 6, text: 'Star Rating'},
    "textArea": {value: 7, text: 'Text Area'},
    "drop": {value: 8, text: 'Dropdown'},

}

function getDataDropByField(field) {
    var availableWidgets = [];
    switch (field) {
        case '1'://text
            availableWidgets = [
                elementTypes["text"], elementTypes["textArea"]
            ];

            break;
        case '2'://simple
            availableWidgets = [elementTypes["radioButton"]];

            break;
        case '3'://multiple
            availableWidgets = [elementTypes["checkbox"]];

            break;
        case '4'://valores verdaderos o falso
            availableWidgets = [elementTypes["boolean"]];
            break;
        case '5'://fecha
            availableWidgets = [elementTypes["date"]];
            break;
        case '6'://rating
            availableWidgets = [elementTypes["rating"]];
            break;
        default:
            break;

    }

    return availableWidgets;
}

function Section(data) {
    var self = this;
    self.id = data.id;
    self.name = ko.observable(data.name).extend({required: true});
    self.weight = ko.observable(data.weight);
    self.fields = ko.observableArray();
    self.deletedFields = ko.observableArray();

    // Operations
    self.updateFieldPosition = function () {
        var i = 0;
        ko.utils.arrayForEach(self.fields(), function (field) {
            field.weight(i++);
        });
    }
    self.addField = function (data, event) {

        var allowOptions = false;
        var availableWidgets = [];
        var availableValidations = [];
        var widget_type;

        availableWidgets = getDataDropByField(data);
        switch (data) {
            case '1':
                widget_type = '1';//default selection drop
                availableValidations = [{
                    value: 'required',
                    text: 'Required'
                }, {value: 'numerical', text: 'Numerical'}, {
                    value: 'digits',
                    text: 'Digits'
                }, {value: 'email', text: 'Email'}, {
                    value: 'url',
                    text: 'URL'
                }];
                break;
            case '2':
                widget_type = '2';//default selection drop
                availableValidations = [{value: 'required', text: 'Required'}, {
                    value: 'comment_allow',
                    text: 'Agregar Comentario'
                }];

                allowOptions = true;
                break;
            case '3':
                widget_type = '3';//default selection drop
                availableValidations = [{value: 'required', text: 'Required'}, {
                    value: 'comment_allow',
                    text: 'Agregar Comentario'
                }];

                allowOptions = true;
                break;
            case '4':
                widget_type = '4';//default selection drop
                availableValidations = [{value: 'required', text: 'Required'}];

                break;

            case '5'://fecha
                widget_type = '5';//default selection drop

                availableValidations = [{value: 'required', text: 'Required'}];
                break;
            case '6':
                widget_type = '6';//default selection drop
                availableValidations = [{value: 'required', text: 'Required'}];
                allowOptions = true;
                break;
            default:
                break;
        }
        var Fila = new Field({
            allowOptions: allowOptions,
            field_type: data,
            availableWidgets: availableWidgets,
            widget_type: widget_type,
            availableValidations: availableValidations
        })
        self.fields.push(Fila);
        if (data == 6) {
            Fila.addOption();
            ocultarRating();
            validacionCampoMaximoRating();
        }

        self.updateFieldPosition();
        $('textarea').autosize();
    }
    self.removeField = function (field) {

        $.confirm({
            title: 'Confirm!',
            content: 'Do you really want to delete this field?',
            buttons: {
                confirm: function () {
                    self.fields.remove(field);
                    if (field.id)
                        self.deletedFields.push(field);
                    self.updateFieldPosition();
                },
                cancel: function () {

                },

            }
        });

    };
}