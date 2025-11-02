// Class to represent a row in the questions grid
function Option(data) {
    var self = this;
    self.id = data.id;
    self.label = ko.observable(data.label);
    self.weight = ko.observable(data.weight);
    self.option_score = ko.observable(data.option_score).extend({number:true}).extend({min:0});


}